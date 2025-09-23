<?php
/**
 * HackerNull Theme Functions
 * Clean, optimized version
 */

// ==============================
// Theme Setup
// ==============================
add_action('after_setup_theme', function() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('custom-logo');
    add_theme_support('automatic-feed-links');
    
    register_nav_menus([
        'primary' => __('Primary Menu', 'hackernull'),
        'footer' => __('Footer Menu', 'hackernull')
    ]);
    
    // Image sizes
    add_image_size('hn-card', 640, 360, true);
    add_image_size('hn-featured', 960, 540, true);
    add_image_size('hn-category', 400, 250, true);
});

// ==============================
// Enqueue Scripts & Styles
// ==============================
add_action('wp_enqueue_scripts', function() {
    $ver = wp_get_theme()->get('Version') ?: '2.0.0';
    
    // Styles - using get_theme_file_uri for better reliability
    wp_enqueue_style('hackernull-style', get_theme_file_uri('style.css'), [], $ver);
    wp_enqueue_style('hackernull-logo', get_theme_file_uri('logo.css'), [], $ver);
    wp_enqueue_style('hackernull-anim', get_theme_file_uri('animation.css'), [], $ver);
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css', [], '6.0.0');
    
    // Scripts
    wp_enqueue_script('hackernull-script', get_theme_file_uri('script.js'), ['jquery'], $ver, true);
    
    // Localize script for AJAX
    wp_localize_script('hackernull-script', 'HN', [
        'ajax' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('hn_nonce'),
        'turnstileSiteKey' => get_option('hn_turnstile_site_key', ''),
        'i18n' => [
            'subscribing' => __('Subscribing…', 'hackernull'),
            'thanks' => __('Thanks! You are subscribed.', 'hackernull'),
            'error' => __('Something went wrong. Please try again.', 'hackernull'),
            'invalidEmail' => __('Please enter a valid email.', 'hackernull'),
        ]
    ]);
});

// ==============================
// Performance Optimizations
// ==============================
// Defer non-critical scripts
add_filter('script_loader_tag', function($tag, $handle) {
    if (is_admin()) return $tag;
    $defer = ['hackernull-script'];
    if (in_array($handle, $defer)) {
        $tag = str_replace(' src', ' defer src', $tag);
    }
    return $tag;
}, 10, 2);

// Remove WordPress bloat
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');

// Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// ==============================
// Custom Post Queries
// ==============================
function hn_get_featured_posts($count = 6) {
    $sticky = get_option('sticky_posts');
    if (!empty($sticky)) {
        rsort($sticky);
        return new WP_Query([
            'post__in' => $sticky,
            'ignore_sticky_posts' => 1,
            'posts_per_page' => $count
        ]);
    }
    // Fallback to tag "featured"
    return new WP_Query([
        'posts_per_page' => $count,
        'ignore_sticky_posts' => 1,
        'tag' => 'featured'
    ]);
}

function hn_get_latest_posts($count = 6) {
    return new WP_Query([
        'posts_per_page' => $count,
        'ignore_sticky_posts' => 1,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC'
    ]);
}

function hn_get_category_posts($cat_id, $count = 6) {
    $args = [
        'posts_per_page' => $count,
        'ignore_sticky_posts' => 1,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC'
    ];
    if ($cat_id) $args['cat'] = (int) $cat_id;
    return new WP_Query($args);
}

// ==============================
// Newsletter Functionality
// ==============================
// Create subscribers table on theme activation
add_action('after_switch_theme', function() {
    global $wpdb;
    $table = $wpdb->prefix . 'hn_subscribers';
    $charset = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE IF NOT EXISTS $table (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        email VARCHAR(191) NOT NULL UNIQUE,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY(id)
    ) $charset;";
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
});

// AJAX newsletter subscription
add_action('wp_ajax_hn_subscribe', 'hn_ajax_subscribe');
add_action('wp_ajax_nopriv_hn_subscribe', 'hn_ajax_subscribe');

function hn_ajax_subscribe() {
    check_ajax_referer('hn_nonce', 'nonce');
    
    $email = sanitize_email($_POST['email'] ?? '');
    $token = sanitize_text_field($_POST['cf_token'] ?? '');
    
    if (!is_email($email)) {
        wp_send_json_error(['message' => __('Invalid email', 'hackernull')], 400);
    }
    
    // Verify Cloudflare Turnstile (if configured)
    $secret = get_option('hn_turnstile_secret_key', '');
    if ($secret && $token) {
        $resp = wp_remote_post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'body' => [
                'secret' => $secret,
                'response' => $token,
                'remoteip' => $_SERVER['REMOTE_ADDR'] ?? ''
            ],
            'timeout' => 10,
        ]);
        
        if (!is_wp_error($resp)) {
            $data = json_decode(wp_remote_retrieve_body($resp), true);
            if (empty($data['success'])) {
                wp_send_json_error(['message' => __('CAPTCHA failed', 'hackernull')], 400);
            }
        }
    }
    
    // Save to database
    global $wpdb;
    $table = $wpdb->prefix . 'hn_subscribers';
    $result = $wpdb->insert($table, ['email' => $email]);
    
    if ($result === false) {
        // Duplicate email - still return success for better UX
        wp_send_json_success(['message' => __('Already subscribed or saved.', 'hackernull')]);
    }
    
    wp_send_json_success(['message' => __('Subscribed successfully!', 'hackernull')]);
}

// ==============================
// Admin Settings Page
// ==============================
add_action('admin_menu', function() {
    add_theme_page(
        'HackerNull Settings',
        'HackerNull',
        'manage_options',
        'hackernull',
        'hn_options_page'
    );
});

function hn_options_page() {
    if (!current_user_can('manage_options')) return;
    
    if (isset($_POST['hn_save'])) {
        check_admin_referer('hn_opts');
        update_option('hn_turnstile_site_key', sanitize_text_field($_POST['turnstile_site_key'] ?? ''));
        update_option('hn_turnstile_secret_key', sanitize_text_field($_POST['turnstile_secret_key'] ?? ''));
        echo '<div class="updated"><p>Settings saved!</p></div>';
    }
    
    $site_key = get_option('hn_turnstile_site_key', '');
    $secret_key = get_option('hn_turnstile_secret_key', '');
    ?>
    <div class="wrap">
        <h1>HackerNull Settings</h1>
        <form method="post">
            <?php wp_nonce_field('hn_opts'); ?>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row">Cloudflare Turnstile Site Key</th>
                    <td><input type="text" name="turnstile_site_key" value="<?php echo esc_attr($site_key); ?>" class="regular-text"/></td>
                </tr>
                <tr>
                    <th scope="row">Cloudflare Turnstile Secret Key</th>
                    <td><input type="text" name="turnstile_secret_key" value="<?php echo esc_attr($secret_key); ?>" class="regular-text"/></td>
                </tr>
            </table>
            <p><button class="button button-primary" name="hn_save" value="1">Save Changes</button></p>
        </form>
    </div>
    <?php
}

// ==============================
// Widget Areas
// ==============================
add_action('widgets_init', function() {
    register_sidebar([
        'name' => 'Sidebar',
        'id' => 'sidebar-1',
        'description' => 'Main sidebar area',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    ]);
});

// ==============================
// Custom Excerpt
// ==============================
add_filter('excerpt_length', function($length) {
    return 20;
});

add_filter('excerpt_more', function($more) {
    return '... <a href="' . get_permalink() . '" class="read-more">Read More</a>';
});

// ==============================
// Clean up sitemaps
// ==============================
add_filter('wp_sitemaps_add_provider', function($provider, $name) {
    if (in_array($name, ['users', 'taxonomies'])) {
        return false;
    }
    return $provider;
}, 10, 2);

add_filter('wp_sitemaps_post_types', function($post_types) {
    unset($post_types['page']);
    return $post_types;
});

// ==============================
// Helper Functions
// ==============================
function hn_get_category_by_name($name) {
    return get_term_by('name', $name, 'category') ?: get_term_by('slug', sanitize_title($name), 'category');
}

function hn_related_posts($post_id, $count = 3) {
    $cats = wp_get_post_categories($post_id);
    $tags = wp_get_post_tags($post_id, ['fields' => 'ids']);
    
    $tax_query = [];
    if ($cats) $tax_query[] = ['taxonomy' => 'category', 'field' => 'term_id', 'terms' => $cats];
    if ($tags) $tax_query[] = ['taxonomy' => 'post_tag', 'field' => 'term_id', 'terms' => $tags];
    
    $args = [
        'post__not_in' => [$post_id],
        'posts_per_page' => $count,
        'ignore_sticky_posts' => 1,
        'orderby' => 'date',
        'order' => 'DESC'
    ];
    
    if ($tax_query) {
        $args['tax_query'] = ['relation' => 'OR', ...$tax_query];
    }
    
    return new WP_Query($args);
}

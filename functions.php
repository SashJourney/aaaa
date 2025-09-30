<?php
/**
 * HackerNull Theme Functions
 */

// Theme Setup
function hackernull_theme_setup() {
    // Add theme support
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

    // Register navigation menus
    register_nav_menus(array(
        'primary-menu' => 'Primary Menu',
        'footer-menu' => 'Footer Menu'
    ));

    // Register custom image sizes
    add_image_size('category-thumb', 300, 200, true);
    add_image_size('featured-large', 1200, 675, true);
    add_image_size('post-thumbnail', 800, 450, true);
    
    // Set default thumbnail size
    set_post_thumbnail_size(800, 450, true);
}
add_action('after_setup_theme', 'hackernull_theme_setup');

// Enqueue scripts and styles
function hackernull_scripts() {
    // Styles
    wp_enqueue_style('hackernull-style', get_stylesheet_uri(), array(), '1.4');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css', array(), '6.0.0');
    
    // Scripts
    wp_enqueue_script('hackernull-script', get_template_directory_uri() . '/script.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'hackernull_scripts');

// Custom excerpt length
function hackernull_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'hackernull_excerpt_length');

// Custom excerpt more
function hackernull_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'hackernull_excerpt_more');

// Register widget areas
function hackernull_widgets_init() {
    register_sidebar(array(
        'name'          => 'Sidebar',
        'id'            => 'sidebar-1',
        'description'   => 'Add widgets here.',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'hackernull_widgets_init');

// Newsletter subscription handler
function hackernull_newsletter_subscription() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'hn_nonce')) {
        wp_send_json_error('Invalid nonce');
    }
    
    $email = sanitize_email($_POST['email']);
    if (!is_email($email)) {
        wp_send_json_error('Invalid email');
    }
    
    global $wpdb;
    $table = $wpdb->prefix . 'hn_subscribers';
    
    $result = $wpdb->insert($table, array(
        'email' => $email,
        'created_at' => current_time('mysql')
    ));
    
    if ($result) {
        wp_send_json_success('Subscribed successfully');
    } else {
        wp_send_json_error('Subscription failed');
    }
}
add_action('wp_ajax_newsletter_subscription', 'hackernull_newsletter_subscription');
add_action('wp_ajax_nopriv_newsletter_subscription', 'hackernull_newsletter_subscription');

// Create subscribers table
function hackernull_create_subscribers_table() {
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
}
add_action('after_switch_theme', 'hackernull_create_subscribers_table');

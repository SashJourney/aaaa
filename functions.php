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
}
add_action('after_setup_theme', 'hackernull_theme_setup');

// Enqueue scripts and styles
function hackernull_scripts() {
    // Styles
    wp_enqueue_style('hackernull-style', get_stylesheet_uri(), array(), '1.0.1');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css', array(), '6.0.0');
    
    // Add inline CSS to ensure styles are loaded
    $custom_css = "
        :root {
            --primary: #00ff00;
            --primary-hover: #00cc00;
            --bg-dark: #000000;
            --bg-card: #111111;
            --text-primary: #ffffff;
            --text-secondary: #888888;
            --border-color: rgba(0, 255, 0, 0.1);
            --glow: 0 0 10px rgba(0, 255, 0, 0.2);
        }

        /* Base styles */
        body {
            background-color: var(--bg-dark) !important;
            color: var(--text-primary) !important;
            font-family: 'Courier New', monospace !important;
            line-height: 1.6 !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Layout */
        .site-main {
            max-width: 1200px !important;
            margin: 0 auto !important;
            padding: 2rem !important;
        }

        /* Header */
        .site-title a {
            color: var(--primary) !important;
            text-decoration: none !important;
            font-size: 2.5rem !important;
            font-weight: bold !important;
            text-shadow: 0 0 10px rgba(0, 255, 0, 0.3) !important;
        }

        /* Categories */
        .categories-section {
            margin: 2rem 0 !important;
            display: grid !important;
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 1.5rem !important;
        }

        .category-card {
            background: var(--bg-card) !important;
            border: 1px solid var(--border-color) !important;
            padding: 1.5rem !important;
            border-radius: 4px !important;
            transition: all 0.3s ease !important;
        }

        .category-card:hover {
            border-color: var(--primary) !important;
            box-shadow: var(--glow) !important;
            transform: translateY(-5px) !important;
        }

        /* Links */
        a {
            color: var(--primary) !important;
            text-decoration: none !important;
            transition: all 0.3s ease !important;
        }

        a:hover {
            text-shadow: var(--glow) !important;
        }

        /* Section titles */
        h1, h2, h3 {
            color: var(--primary) !important;
            text-transform: uppercase !important;
            letter-spacing: 1px !important;
            margin-bottom: 1.5rem !important;
        }

        /* Search box */
        .search-box input {
            background: var(--bg-card) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
            padding: 0.5rem !important;
            border-radius: 4px !important;
        }

        .search-box input:focus {
            border-color: var(--primary) !important;
            box-shadow: var(--glow) !important;
            outline: none !important;
        }

        /* Posts */
        .post-card {
            background: var(--bg-card) !important;
            border: 1px solid var(--border-color) !important;
            padding: 1rem !important;
            border-radius: 4px !important;
            margin-bottom: 1.5rem !important;
            transition: all 0.3s ease !important;
        }

        .post-card:hover {
            border-color: var(--primary) !important;
            box-shadow: var(--glow) !important;
        }

        /* Particles Background */
        .particles-background {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            z-index: -1 !important;
            background: linear-gradient(to bottom, #000000, #001100) !important;
        }

        /* Matrix-style Animation */
        @keyframes matrix-glow {
            0% { text-shadow: 0 0 5px var(--primary); }
            50% { text-shadow: 0 0 15px var(--primary); }
            100% { text-shadow: 0 0 5px var(--primary); }
        }

        .site-title a {
            animation: matrix-glow 2s infinite !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .categories-section {
                grid-template-columns: 1fr !important;
            }
            .site-main {
                padding: 1rem !important;
            }
        }
    ";
    wp_add_inline_style('hackernull-style', $custom_css);

    // Scripts
    wp_enqueue_script('jquery');
    wp_enqueue_script('particles', 'https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js', array(), '2.0.0', true);
    wp_enqueue_script('cloudflare-turnstile', 'https://challenges.cloudflare.com/turnstile/v0/api.js', array(), null, true);
    wp_enqueue_script('hackernull-custom', get_template_directory_uri() . '/script.js', array('jquery', 'particles'), '1.0.1', true);

    // Localize script for AJAX
    wp_localize_script('hackernull-custom', 'hackernullAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('hackernull-nonce')
    ));
}
add_action('wp_enqueue_scripts', 'hackernull_scripts');

// Register widget areas
function hackernull_widgets_init() {
    register_sidebar(array(
        'name' => 'Sidebar',
        'id' => 'sidebar-1',
        'description' => 'Main sidebar area',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    ));
}
add_action('widgets_init', 'hackernull_widgets_init');

// Custom excerpt length
function hackernull_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'hackernull_excerpt_length');

// Custom excerpt more
function hackernull_excerpt_more($more) {
    return '... <a href="' . get_permalink() . '" class="read-more">Read More</a>';
}
add_filter('excerpt_more', 'hackernull_excerpt_more');

// Newsletter subscription AJAX handler
function hackernull_newsletter_subscribe() {
    check_ajax_referer('hackernull-nonce', 'nonce');

    $email = sanitize_email($_POST['email']);
    $captcha_token = sanitize_text_field($_POST['token']);

    // Verify Cloudflare Turnstile token
    $verify_url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
    $secret_key = get_option('cloudflare_turnstile_secret'); // Add this in WordPress settings

    $response = wp_remote_post($verify_url, array(
        'body' => array(
            'secret' => $secret_key,
            'response' => $captcha_token
        )
    ));

    if (is_wp_error($response)) {
        wp_send_json_error('Captcha verification failed');
        return;
    }

    $body = json_decode(wp_remote_retrieve_body($response));
    if (!$body->success) {
        wp_send_json_error('Invalid captcha');
        return;
    }

    // Add your newsletter subscription logic here
    // For example, store in database or send to external service

    wp_send_json_success('Successfully subscribed!');
}
add_action('wp_ajax_hackernull_newsletter_subscribe', 'hackernull_newsletter_subscribe');
add_action('wp_ajax_nopriv_hackernull_newsletter_subscribe', 'hackernull_newsletter_subscribe');

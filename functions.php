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
    wp_enqueue_style('hackernull-style', get_stylesheet_uri(), array(), '1.0.0');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

    // Scripts
    wp_enqueue_script('particles', 'https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js', array(), '2.0.0', true);
    wp_enqueue_script('cloudflare-turnstile', 'https://challenges.cloudflare.com/turnstile/v0/api.js', array(), null, true);
    wp_enqueue_script('hackernull-custom', get_template_directory_uri() . '/script.js', array('jquery', 'particles'), '1.0.0', true);

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

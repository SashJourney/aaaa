<?php
function hackernull_scripts() {
    wp_enqueue_style('hackernull-style', get_stylesheet_uri());
    wp_enqueue_script('particles', 'https://cdn.jsdelivr.net/npm/particles.js', [], null, true);
    wp_enqueue_script('hackernull-custom', get_template_directory_uri().'/script.js', ['particles'], null, true);
}
add_action('wp_enqueue_scripts', 'hackernull_scripts');

add_theme_support('post-thumbnails');
add_theme_support('title-tag');

<?php
function hackernull_enqueue_scripts() {
    wp_enqueue_style( 'hackernull-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'hackernull_enqueue_scripts' );

// Add support for featured images & title tag
add_theme_support( 'post-thumbnails' );
add_theme_support( 'title-tag' );

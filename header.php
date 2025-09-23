<?php
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Fallback CSS link in case enqueue fails -->
    <link rel="stylesheet" href="<?php echo get_theme_file_uri('style.css'); ?>" type="text/css" media="all" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="site-header">
    <div class="container header-inner">
        <div class="brand">
            <div class="brand-logo" aria-hidden="true">⚡</div>
            <h1 class="site-title">
                <a href="<?php echo home_url(); ?>">
                    <?php bloginfo('name'); ?>
                </a>
            </h1>
        </div>
        
        <nav class="main-nav" aria-label="Primary">
            <?php 
            wp_nav_menu([
                'theme_location' => 'primary',
                'container' => false,
                'items_wrap' => '<ul class="nav-menu">%3$s</ul>',
                'fallback_cb' => false
            ]); 
            ?>
        </nav>
        
        <div class="search-box">
            <?php get_search_form(); ?>
        </div>
    </div>
</header>

<main class="site-main">
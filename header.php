<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div class="network-banner" id="particles-js"></div>

<header class="site-header">
    <div class="header-container">
        <div class="logo-container">
            <h1 class="site-title">
                <a href="<?php echo home_url(); ?>" data-text="HackerNull">
                    <span class="hack">Hacker</span><span class="null">Null</span>
                </a>
            </h1>
            <p class="site-description">Learn Ethical Hacking | Cybersecurity Tips & Trends</p>
        </div>

        <nav class="main-navigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary-menu',
                'container' => false,
                'menu_class' => 'nav-menu',
            ));
            ?>
            <div class="search-box">
                <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
                    <input type="search" class="search-input" placeholder="Search..." value="<?php echo get_search_query(); ?>" name="s">
                    <button type="submit" class="search-submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </nav>
    </div>
</header>

<!-- Dark mode toggle -->
<div class="dark-mode-toggle">
    <i class="fas fa-moon"></i>
</div>

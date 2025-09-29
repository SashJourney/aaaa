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
    wp_enqueue_style('hackernull-style', get_stylesheet_uri(), array(), '1.0.1');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css', array(), '6.0.0');
    
    // Add inline CSS to ensure styles are loaded
    $custom_css = "
        :root {
            --primary: #00ff00;
            --primary-hover: #00cc00;
            --primary-glow: #00ff0033;
            --bg-dark: #000000;
            --bg-card: #0a0f0a;
            --bg-card-hover: #111111;
            --text-primary: #ffffff;
            --text-secondary: #888888;
            --border-color: rgba(0, 255, 0, 0.1);
            --glow: 0 0 10px rgba(0, 255, 0, 0.2);
            --glow-strong: 0 0 20px rgba(0, 255, 0, 0.4);
            --terminal-shadow: 0 0 20px rgba(0, 255, 0, 0.1);
            --card-bg: linear-gradient(145deg, #0a0f0a, #111111);
            --card-bg-hover: linear-gradient(145deg, #111111, #0a0f0a);
            --terminal-prompt: '> ';
            --scanline-color: rgba(0, 255, 0, 0.1);
            --matrix-bg: linear-gradient(45deg, transparent, var(--primary-glow), transparent);
            --spacing-sm: 0.5rem;
            --spacing-md: 1rem;
            --spacing-lg: 2rem;
            --border-radius: 8px;
        }

        .container {
            width: 100% !important;
            max-width: 1400px !important;
            margin: 0 auto !important;
            padding: 0 2rem !important;
        }
        /* Terminal Theme */
        .section-header {
            margin-bottom: 3rem !important;
            text-align: center !important;
            position: relative !important;
        }

        .terminal-line {
            font-family: 'Courier New', monospace !important;
            color: var(--text-secondary) !important;
            margin-bottom: 1rem !important;
            display: inline-block !important;
            padding: 0.5rem 1rem !important;
            background: var(--bg-card) !important;
            border-radius: 4px !important;
            border: 1px solid var(--border-color) !important;
        }

        .terminal-prompt {
            color: var(--primary) !important;
        }

        .command {
            color: var(--text-primary) !important;
        }

        /* Categories Grid */
        .categories-section {
            margin: 4rem 0 !important;
            position: relative !important;
            padding: 2rem 0 !important;
        }

        .category-grid {
            display: grid !important;
            grid-template-columns: repeat(3, minmax(300px, 1fr)) !important;
            gap: 1.5rem !important;
            position: relative !important;
            margin: 2rem 0 3rem !important;
            width: 100% !important;
            padding: 0 2rem !important;
        }

        .category-card {
            background: rgba(0, 0, 0, 0.6) !important;
            padding: 1.5rem !important;
            border-radius: 8px !important;
            text-decoration: none !important;
            color: var(--text-primary) !important;
            transition: all 0.3s ease !important;
            border: 1px solid var(--border-color) !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            text-align: center !important;
            position: relative !important;
            overflow: hidden !important;
            min-height: 180px !important;
            justify-content: flex-start !important;
            backdrop-filter: blur(10px) !important;
            gap: 0.75rem !important;
        }

        .category-card::before {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            background: linear-gradient(45deg, var(--primary-glow), transparent) !important;
            opacity: 0 !important;
            transition: opacity 0.3s ease !important;
            z-index: 1 !important;
        }

        .category-card:hover::before {
            opacity: 0.1 !important;
        }

        .category-icon {
            flex-shrink: 0 !important;
            width: 48px !important;
            height: 48px !important;
            background: var(--bg-dark) !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            border: 1px solid var(--border-color) !important;
            position: relative !important;
            z-index: 2 !important;
            transition: all 0.3s ease !important;
        }

        .category-icon::after {
            content: '' !important;
            position: absolute !important;
            top: -2px !important;
            left: -2px !important;
            right: -2px !important;
            bottom: -2px !important;
            border-radius: 50% !important;
            background: linear-gradient(45deg, var(--primary), transparent) !important;
            opacity: 0 !important;
            transition: opacity 0.3s ease !important;
            z-index: -1 !important;
        }

        .category-icon i {
            font-size: 1.25rem !important;
            color: var(--primary) !important;
            text-shadow: var(--glow) !important;
            transition: all 0.3s ease !important;
        }

        .category-card:hover .category-icon::after {
            opacity: 1 !important;
        }

        .category-card h3 {
            font-size: 0.95rem !important;
            margin: 0.75rem 0 0.35rem !important;
            color: var(--primary) !important;
            font-family: 'Courier New', monospace !important;
            position: relative !important;
            display: inline-block !important;
            text-transform: uppercase !important;
            letter-spacing: 1px !important;
            z-index: 2 !important;
        }

        .category-card h3::before {
            content: '>' !important;
            color: var(--primary) !important;
            margin-right: 0.35rem !important;
            opacity: 0 !important;
            transform: translateX(-10px) !important;
            display: inline-block !important;
            transition: all 0.3s ease !important;
        }

        .category-description {
            color: var(--text-secondary) !important;
            font-size: 0.8rem !important;
            line-height: 1.4 !important;
            margin-bottom: 0.75rem !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 2 !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
            z-index: 2 !important;
        }

        .post-count {
            color: var(--text-secondary) !important;
            font-size: 0.8rem !important;
            font-family: 'Courier New', monospace !important;
            margin-top: auto !important;
            background: var(--bg-dark) !important;
            padding: 0.15rem 0.5rem !important;
            border-radius: 8px !important;
            border: 1px solid var(--border-color) !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.35rem !important;
            z-index: 2 !important;
        }

        .post-count i {
            color: var(--primary) !important;
            font-size: 0.8rem !important;
        }

        .category-content {
            flex: 1 !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 0.75rem !important;
            width: 100% !important;
        }

        .category-content h3 {
            font-size: 1rem !important;
            margin: 0 !important;
            color: var(--primary) !important;
            font-family: 'Courier New', monospace !important;
            position: relative !important;
            display: inline-block !important;
            text-transform: uppercase !important;
            letter-spacing: 1px !important;
            font-weight: bold !important;
        }

        .category-description {
            color: var(--text-secondary) !important;
            font-size: 0.85rem !important;
            line-height: 1.4 !important;
            font-family: 'Courier New', monospace !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 2 !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
            text-align: center !important;
            margin: 0 !important;
            max-width: 90% !important;
        }

        .category-meta {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            gap: 1rem !important;
            width: 100% !important;
            margin-top: auto !important;
            border-top: 1px solid var(--border-color) !important;
            padding-top: 0.75rem !important;
            margin-top: 1rem !important;
            font-family: 'Courier New', monospace !important;
        }

        .post-count {
            font-size: 0.9rem !important;
            color: var(--text-secondary) !important;
            display: flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
            background: var(--bg-dark) !important;
            padding: 0.25rem 0.75rem !important;
            border-radius: 12px !important;
            border: 1px solid var(--border-color) !important;
        }

        .view-more {
            font-size: 0.9rem !important;
            color: var(--primary) !important;
            display: flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
            opacity: 0 !important;
            transform: translateX(-10px) !important;
            transition: all 0.3s ease !important;
        }

        .category-card:hover {
            transform: translateY(-5px) !important;
            border-color: var(--primary) !important;
            box-shadow: var(--glow) !important;
            background: linear-gradient(145deg, var(--bg-card), var(--bg-dark)) !important;
        }

        .category-card:hover .view-more {
            opacity: 1 !important;
            transform: translateX(0) !important;
        }

        .category-card:hover .category-icon {
            background: var(--primary) !important;
            border-color: var(--primary) !important;
            transform: rotate(-5deg) !important;
        }

        .category-card:hover .category-icon i {
            color: var(--bg-dark) !important;
            transform: rotate(5deg) !important;
        }

        .category-card:hover h3::before {
            opacity: 1 !important;
            transform: translateX(0) !important;
        }

        @media (max-width: 768px) {
            .category-grid {
                grid-template-columns: 1fr !important;
            }
            .post-grid {
                grid-template-columns: 1fr !important;
            }
        }

        /* Post Cards */
        .post-grid {
            display: grid !important;
            grid-template-columns: repeat(3, minmax(300px, 1fr)) !important;
            gap: 1.5rem !important;
            margin-bottom: 2rem !important;
            width: 100% !important;
            padding: 0 2rem !important;
        }

        .post-card {
            background: rgba(0, 0, 0, 0.6) !important;
            border-radius: var(--border-radius) !important;
            overflow: hidden !important;
            transition: all 0.3s ease !important;
            border: 1px solid var(--border-color) !important;
            position: relative !important;
            height: 100% !important;
            display: flex !important;
            flex-direction: column !important;
            backdrop-filter: blur(10px) !important;
        }

        .post-image {
            position: relative !important;
            padding-top: 56.25% !important; /* 16:9 aspect ratio */
            overflow: hidden !important;
            flex-shrink: 0 !important;
            background: rgba(0, 0, 0, 0.2) !important;
            border-bottom: 1px solid var(--border-color) !important;
        }

        .post-image img {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            transition: transform 0.3s ease !important;
            display: block !important;
            z-index: 1 !important;
        }

        .post-image a {
            display: block !important;
            width: 100% !important;
            height: 100% !important;
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            z-index: 2 !important;
        }

        .post-image::before {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background: linear-gradient(45deg, var(--primary-glow), transparent) !important;
            opacity: 0.1 !important;
            z-index: 2 !important;
        }

        .post-categories {
            position: absolute !important;
            top: var(--spacing-sm) !important;
            left: var(--spacing-sm) !important;
            display: flex !important;
            gap: 0.5rem !important;
            z-index: 1 !important;
            flex-wrap: wrap !important;
        }

        .post-category {
            background: rgba(0, 0, 0, 0.8) !important;
            color: var(--primary) !important;
            padding: 0.15rem 0.5rem !important;
            border-radius: 8px !important;
            font-size: 0.75rem !important;
            border: 1px solid var(--primary) !important;
            font-family: 'Courier New', monospace !important;
            backdrop-filter: blur(4px) !important;
        }

        .post-content {
            padding: 1rem !important;
            flex-grow: 1 !important;
            display: flex !important;
            flex-direction: column !important;
        }

        .post-meta {
            display: flex !important;
            gap: 1rem !important;
            margin-bottom: 0.5rem !important;
            font-family: 'Courier New', monospace !important;
            font-size: 0.75rem !important;
            color: var(--text-secondary) !important;
            flex-wrap: wrap !important;
        }

        .post-meta span {
            display: flex !important;
            align-items: center !important;
            gap: 0.35rem !important;
        }

        .post-meta i {
            font-size: 0.8rem !important;
            color: var(--primary) !important;
        }

        .post-card h3 {
            margin: 0 0 0.5rem !important;
            font-size: 1rem !important;
            line-height: 1.3 !important;
            font-family: 'Courier New', monospace !important;
        }

        .post-card h3 a {
            color: var(--text-primary) !important;
            text-decoration: none !important;
            transition: color 0.3s ease !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 2 !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
        }

        .post-card p {
            color: var(--text-secondary) !important;
            margin-bottom: 0.75rem !important;
            font-size: 0.85rem !important;
            line-height: 1.5 !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 2 !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
            flex-grow: 1 !important;
        }

        .read-more {
            color: var(--primary) !important;
            text-decoration: none !important;
            font-family: 'Courier New', monospace !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
            font-size: 0.9rem !important;
            transition: all 0.3s ease !important;
        }

        .post-card:hover {
            transform: translateY(-5px) !important;
            border-color: var(--primary) !important;
            box-shadow: var(--glow) !important;
        }

        .post-card:hover img {
            transform: scale(1.05) !important;
        }

        .post-card:hover h3 a {
            color: var(--primary) !important;
        }

        .post-card:hover .read-more {
            gap: 0.75rem !important;
        }
        :root {
            --primary: #00ff00;
            --primary-hover: #00cc00;
            --primary-glow: #00ff0033;
            --bg-dark: #000000;
            --bg-card: #0a0f0a;
            --bg-card-hover: #111111;
            --text-primary: #ffffff;
            --text-secondary: #888888;
            --border-color: rgba(0, 255, 0, 0.1);
        }

        .container {
            width: 100% !important;
            max-width: 1400px !important;
            margin: 0 auto !important;
            padding: 0 2rem !important;
        }

        /* Header Styles */
        .site-header {
            background: rgba(0, 0, 0, 0.8) !important;
            padding: 1rem 0 !important;
            position: sticky !important;
            top: 0 !important;
            z-index: 1000 !important;
            border-bottom: 1px solid var(--border-color) !important;
            backdrop-filter: blur(10px) !important;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5) !important;
        }

        .site-header::before {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            height: 1px !important;
            background: linear-gradient(90deg, 
                transparent, 
                var(--primary), 
                transparent
            ) !important;
            opacity: 0.5 !important;
        }

        .site-header .container {
            display: grid !important;
            grid-template-columns: 1fr auto 1fr !important;
            align-items: center !important;
            gap: 2rem !important;
            position: relative !important;
            padding: 1rem 2rem !important;
        }

        .site-branding {
            grid-column: 2 !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            gap: 0.5rem !important;
            position: relative !important;
        }

        .site-title {
            font-size: 2rem !important;
            font-family: 'Courier New', monospace !important;
            font-weight: bold !important;
            margin: 0 !important;
            position: relative !important;
            display: inline-block !important;
            z-index: 2 !important;
        }

        .site-title a {
            color: var(--primary) !important;
            text-decoration: none !important;
            text-transform: uppercase !important;
            letter-spacing: 3px !important;
            position: relative !important;
            padding: 0.75rem 1.5rem !important;
            background: rgba(0, 255, 0, 0.05) !important;
            border-radius: 4px !important;
            border: 1px solid var(--border-color) !important;
            transition: all 0.3s ease !important;
            display: inline-block !important;
            text-shadow: 0 0 10px var(--primary) !important;
        }

        .site-title a::before,
        .site-title a::after {
            content: '' !important;
            position: absolute !important;
            top: -2px !important;
            bottom: -2px !important;
            width: 2px !important;
            background: var(--primary) !important;
            box-shadow: 0 0 10px var(--primary) !important;
            transition: all 0.3s ease !important;
        }

        .site-title a::before {
            left: -2px !important;
            transform: scaleY(0.7) !important;
        }

        .site-title a::after {
            right: -2px !important;
            transform: scaleY(0.7) !important;
        }

        .site-title a:hover::before,
        .site-title a:hover::after {
            transform: scaleY(1) !important;
        }

        .site-title a:hover {
            text-shadow: 0 0 20px var(--primary) !important;
            border-color: var(--primary) !important;
            box-shadow: 0 0 30px rgba(0, 255, 0, 0.2) !important;
            background: rgba(0, 255, 0, 0.1) !important;
            letter-spacing: 4px !important;
        }

        .site-description {
            display: none !important;
        }

        .main-navigation {
            grid-column: 3 !important;
            justify-self: end !important;
            display: flex !important;
            align-items: center !important;
            gap: 2rem !important;
        }

        .nav-menu {
            display: flex !important;
            gap: 1rem !important;
            list-style: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .nav-menu li a {
            color: var(--text-primary) !important;
            text-decoration: none !important;
            font-family: 'Courier New', monospace !important;
            font-size: 0.9rem !important;
            padding: 0.5rem 1rem !important;
            border-radius: 4px !important;
            transition: all 0.3s ease !important;
            border: 1px solid transparent !important;
            position: relative !important;
            overflow: hidden !important;
        }

        .nav-menu li a::before {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background: linear-gradient(45deg, transparent, var(--primary-glow), transparent) !important;
            transform: translateX(-100%) !important;
            transition: transform 0.3s ease !important;
        }

        .nav-menu li a:hover {
            color: var(--primary) !important;
            border-color: var(--border-color) !important;
        }

        .nav-menu li a:hover::before {
            transform: translateX(100%) !important;
        }

        .search-box {
            position: relative !important;
            width: 200px !important;
            grid-column: 1 !important;
            justify-self: start !important;
        }

        .search-box input.search-field {
            background: rgba(0, 0, 0, 0.3) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
            padding: 0.35rem 1rem !important;
            padding-left: 2rem !important;
            border-radius: 4px !important;
            font-family: 'Courier New', monospace !important;
            font-size: 0.85rem !important;
            width: 180px !important;
            transition: all 0.3s ease !important;
        }

        .search-box::before {
            content: '>' !important;
            position: absolute !important;
            left: 0.75rem !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            color: var(--primary) !important;
            font-family: 'Courier New', monospace !important;
            opacity: 0.7 !important;
            font-size: 0.85rem !important;
            pointer-events: none !important;
        }

        .search-box input.search-field:focus {
            width: 240px !important;
            border-color: var(--primary) !important;
            box-shadow: 0 0 15px rgba(0, 255, 0, 0.15) !important;
            outline: none !important;
            background: rgba(0, 0, 0, 0.5) !important;
        }

        .search-box input.search-field::placeholder {
            color: var(--text-secondary) !important;
            opacity: 0.5 !important;
            font-size: 0.85rem !important;
        }

        @keyframes scanline {
            0% { transform: translateY(-100%); }
            100% { transform: translateY(100%); }
        }

        @keyframes glitch {
            0% { text-shadow: 0.05em 0 0 var(--primary-glow), -0.05em -0.025em 0 var(--primary-hover); }
            14% { text-shadow: 0.05em 0 0 var(--primary-glow), -0.05em -0.025em 0 var(--primary-hover); }
            15% { text-shadow: -0.05em -0.025em 0 var(--primary-glow), 0.025em 0.025em 0 var(--primary-hover); }
            49% { text-shadow: -0.05em -0.025em 0 var(--primary-glow), 0.025em 0.025em 0 var(--primary-hover); }
            50% { text-shadow: 0.025em 0.05em 0 var(--primary-glow), 0.05em 0 0 var(--primary-hover); }
            99% { text-shadow: 0.025em 0.05em 0 var(--primary-glow), 0.05em 0 0 var(--primary-hover); }
            100% { text-shadow: -0.025em 0 0 var(--primary-glow), -0.025em -0.025em 0 var(--primary-hover); }
        }

        @keyframes terminalType {
            from { width: 0; }
            to { width: 100%; }
        }

        @keyframes matrixRain {
            0% { background-position: 0% -100%; }
            100% { background-position: 0% 100%; }
        }

        @keyframes typing {
            from { width: 0 }
            to { width: 100% }
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
            animation: glitch 3s infinite !important;
            position: relative !important;
            display: inline-block !important;
        }

        .site-title a::before {
            content: attr(data-text) !important;
            position: absolute !important;
            left: -2px !important;
            text-shadow: 2px 0 var(--primary-glow) !important;
            top: 0 !important;
            color: var(--primary) !important;
            background: var(--bg-dark) !important;
            overflow: hidden !important;
            animation: glitch-2 15s infinite linear alternate-reverse !important;
        }

        @keyframes glitch-2 {
            0% { clip-path: inset(40% 0 61% 0); }
            20% { clip-path: inset(92% 0 1% 0); }
            40% { clip-path: inset(43% 0 1% 0); }
            60% { clip-path: inset(25% 0 58% 0); }
            80% { clip-path: inset(54% 0 7% 0); }
            100% { clip-path: inset(58% 0 43% 0); }
        }

        /* Categories */
        .categories-section {
            margin: 3rem 0 !important;
            display: grid !important;
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 2rem !important;
            position: relative !important;
        }

        .categories-section::before {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            background: radial-gradient(circle at 50% 50%, rgba(0, 255, 0, 0.1) 0%, transparent 70%) !important;
            pointer-events: none !important;
        }

        .category-card {
            background: var(--card-bg) !important;
            border: 1px solid var(--border-color) !important;
            padding: 2rem !important;
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
            position: relative !important;
            overflow: hidden !important;
            box-shadow: var(--terminal-shadow) !important;
        }

        @keyframes matrixBg {
            0% { background-position: 0% 0%; }
            100% { background-position: 100% 100%; }
        }

        .category-card::before {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background: linear-gradient(45deg, 
                transparent 0%, 
                rgba(0, 255, 0, 0.05) 30%,
                rgba(0, 255, 0, 0.1) 50%,
                rgba(0, 255, 0, 0.05) 70%,
                transparent 100%
            ) !important;
            background-size: 400% 400% !important;
            animation: matrixBg 3s ease infinite !important;
            opacity: 0 !important;
            transition: opacity 0.3s ease !important;
            border-radius: var(--border-radius) !important;
        }

        .category-card:hover::before {
            opacity: 1 !important;
        }

        .category-card:hover {
            border-color: var(--primary) !important;
            box-shadow: var(--glow) !important;
            transform: translateY(-5px) !important;
            background: linear-gradient(145deg, #111111, #0a0f0a) !important;
        }

        .category-card h3 {
            color: var(--primary) !important;
            font-size: 1.5rem !important;
            margin-bottom: 1rem !important;
            font-family: 'Courier New', monospace !important;
            text-transform: uppercase !important;
            letter-spacing: 2px !important;
            position: relative !important;
            display: inline-block !important;
            text-shadow: var(--glow) !important;
        }

        .post-count {
            font-family: 'Courier New', monospace !important;
            color: var(--text-secondary) !important;
            font-size: 0.9rem !important;
            background: rgba(0, 255, 0, 0.1) !important;
            padding: 0.25rem 0.75rem !important;
            border-radius: 12px !important;
            display: inline-block !important;
            margin-top: 1rem !important;
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
            letter-spacing: 2px !important;
            margin-bottom: 2rem !important;
            font-family: 'Courier New', monospace !important;
            position: relative !important;
            display: inline-block !important;
            text-shadow: var(--glow) !important;
        }

        h2.section-title {
            font-size: 2rem !important;
            text-align: center !important;
            width: 100% !important;
            margin-bottom: 3rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 1rem !important;
        }

        h2.section-title::before,
        h2.section-title::after {
            content: '' !important;
            height: 1px !important;
            background: linear-gradient(90deg, transparent, var(--primary), transparent) !important;
            flex: 1 !important;
        }

        /* Latest News Section */
        .latest-news {
            margin-top: 4rem !important;
            position: relative !important;
            padding: 2rem !important;
            background: var(--card-bg) !important;
            border-radius: 8px !important;
            border: 1px solid var(--border-color) !important;
            box-shadow: var(--terminal-shadow) !important;
        }

        .latest-news::before {
            content: '> Latest_Updates.log' !important;
            position: absolute !important;
            top: -1.5rem !important;
            left: 0 !important;
            color: var(--primary) !important;
            font-family: 'Courier New', monospace !important;
            font-size: 0.9rem !important;
            opacity: 0.7 !important;
        }

        .post-title {
            font-family: 'Courier New', monospace !important;
            color: var(--primary) !important;
            font-size: 1.5rem !important;
            margin-bottom: 1rem !important;
            display: block !important;
            position: relative !important;
            padding-left: 1.5rem !important;
        }

        .post-title::before {
            content: '>' !important;
            position: absolute !important;
            left: 0 !important;
            color: var(--primary) !important;
            opacity: 0.7 !important;
        }

        .post-meta {
            font-family: 'Courier New', monospace !important;
            color: var(--text-secondary) !important;
            font-size: 0.9rem !important;
            margin-bottom: 1rem !important;
            display: flex !important;
            gap: 1rem !important;
            align-items: center !important;
        }

        .post-meta::before {
            content: '[' !important;
            color: var(--primary) !important;
        }

        .post-meta::after {
            content: ']' !important;
            color: var(--primary) !important;
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

        /* Newsletter Section */
        .newsletter-section {
            background: var(--card-bg) !important;
            padding: 3rem !important;
            margin: 4rem 0 !important;
            text-align: center !important;
            border-radius: 8px !important;
            border: 1px solid var(--border-color) !important;
            position: relative !important;
            overflow: hidden !important;
            box-shadow: var(--terminal-shadow) !important;
        }

        .newsletter-section::before {
            content: '> Subscribe_Now.exe' !important;
            position: absolute !important;
            top: 1rem !important;
            left: 1rem !important;
            color: var(--primary) !important;
            font-family: 'Courier New', monospace !important;
            font-size: 0.9rem !important;
            opacity: 0.7 !important;
        }

        .newsletter-section h2 {
            font-size: 2rem !important;
            margin-bottom: 1rem !important;
            position: relative !important;
            display: inline-block !important;
        }

        .newsletter-section p {
            color: var(--text-secondary) !important;
            margin-bottom: 2rem !important;
            font-family: 'Courier New', monospace !important;
            max-width: 600px !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        .newsletter-form {
            display: flex !important;
            gap: 1rem !important;
            max-width: 500px !important;
            margin: 0 auto !important;
            position: relative !important;
        }

        .newsletter-form input[type=email] {
            flex: 1 !important;
            padding: 1rem !important;
            background: var(--bg-dark) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 4px !important;
            color: var(--text-primary) !important;
            font-family: 'Courier New', monospace !important;
        }

        .newsletter-form input[type=email]:focus {
            outline: none !important;
            border-color: var(--primary) !important;
            box-shadow: var(--glow) !important;
        }

        .newsletter-form button {
            padding: 1rem 2rem !important;
            background: transparent !important;
            border: 1px solid var(--primary) !important;
            color: var(--primary) !important;
            border-radius: 4px !important;
            cursor: pointer !important;
            font-family: 'Courier New', monospace !important;
            text-transform: uppercase !important;
            letter-spacing: 1px !important;
            position: relative !important;
            overflow: hidden !important;
            transition: all 0.3s ease !important;
        }

        .newsletter-form button::before {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background: var(--primary) !important;
            transform: scaleX(0) !important;
            transform-origin: right !important;
            transition: transform 0.3s ease !important;
            z-index: -1 !important;
        }

        .newsletter-form button:hover {
            color: var(--bg-dark) !important;
        }

        .newsletter-form button:hover::before {
            transform: scaleX(1) !important;
            transform-origin: left !important;
        }

        /* Footer */
        .site-footer {
            background: var(--bg-card) !important;
            border-top: 1px solid var(--border-color) !important;
            padding: var(--spacing-lg) 0 !important;
            margin-top: var(--spacing-lg) !important;
        }

        .footer-content {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
        }

        .terminal-prompt {
            color: var(--primary) !important;
            font-family: 'Courier New', monospace !important;
            margin-right: var(--spacing-sm) !important;
        }

        .typing-text {
            color: var(--text-secondary) !important;
            font-family: 'Courier New', monospace !important;
            animation: typing 3s steps(60, end) !important;
        }

        .footer-menu {
            display: flex !important;
            gap: var(--spacing-md) !important;
            list-style: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .footer-menu a {
            color: var(--text-secondary) !important;
            text-decoration: none !important;
            font-family: 'Courier New', monospace !important;
            transition: all 0.3s ease !important;
        }

        .footer-menu a:hover {
            color: var(--primary) !important;
            text-shadow: var(--glow) !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .categories-section {
                grid-template-columns: 1fr !important;
            }
            .site-main {
                padding: 1rem !important;
            }
            .newsletter-form {
                flex-direction: column !important;
            }
            .newsletter-section {
                padding: 2rem 1rem !important;
            }
            .footer-content {
                flex-direction: column !important;
                gap: var(--spacing-md) !important;
                text-align: center !important;
            }
            .footer-menu {
                flex-direction: column !important;
                align-items: center !important;
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

// Clean up taxonomies and post types
function cleanup_taxonomies() {
    // Unregister unnecessary taxonomies
    unregister_taxonomy_for_object_type('post_format', 'post');
    unregister_taxonomy_for_object_type('post_tag', 'post');
}
add_action('init', 'cleanup_taxonomies');

// Clean up sitemap
function cleanup_sitemap($provider, $name) {
    // Remove users sitemap
    if ('users' === $name) {
        return false;
    }
    
    // Remove unnecessary taxonomies
    if ('taxonomies' === $name) {
        return false;
    }

    // Remove pages sitemap
    if ('post_type' === $name && $provider instanceof WP_Sitemaps_Posts) {
        $post_types = $provider->get_object_subtypes();
        unset($post_types['page']);
        
        // Only keep 'post' type
        $provider->object_subtypes = array('post' => $post_types['post']);
    }
    
    return $provider;
}

// Remove pages from sitemap
function remove_page_from_sitemap($post_types) {
    unset($post_types['page']);
    return $post_types;
}
add_filter('wp_sitemaps_post_types', 'remove_page_from_sitemap');
add_filter('wp_sitemaps_add_provider', 'cleanup_sitemap', 10, 2);

// Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// Remove unnecessary links from wp_head
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'start_post_rel_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link');

// Disable emojis
function disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'disable_emojis');

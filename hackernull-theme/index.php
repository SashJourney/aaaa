<?php
// Minimal guaranteed working WordPress theme
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body>
    <h1>✅ Welcome to Hackernull Theme!</h1>
    <p>If you see this, the theme is working correctly 🎉</p>

    <?php
    // Show posts if they exist
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            echo '<h2>' . get_the_title() . '</h2>';
            the_content();
        endwhile;
    else :
        echo '<p>No posts yet. Add one in WP Admin → Posts.</p>';
    endif;
    ?>

    <?php wp_footer(); ?>
</body>
</html>

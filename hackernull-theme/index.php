<?php
// Load WordPress header
get_header();
?>

<main id="site-content">
    <h1>Welcome to Hackernull Theme!</h1>
    <p>If you see this, the theme is working 🎉</p>

    <?php
    // WordPress loop: display posts if any exist
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            the_title('<h2>', '</h2>');
            the_content();
        endwhile;
    else :
        echo '<p>No posts yet. Add one in WP Admin → Posts.</p>';
    endif;
    ?>
</main>

<?php
// Load WordPress footer
get_footer();
?>

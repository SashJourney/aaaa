<?php get_header(); ?>

<main>
    <h1>✅ Welcome to Hackernull Theme!</h1>

    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <article>
                <h2><?php the_title(); ?></h2>
                <div><?php the_content(); ?></div>
            </article>
        <?php endwhile; ?>
    <?php else : ?>
        <p>No posts found. Add one in WP Admin → Posts.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>

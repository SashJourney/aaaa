<?php get_header(); ?>

<div class="container section">
    <?php if (have_posts()): while(have_posts()): the_post(); ?>
        <article <?php post_class('card'); ?>>
            <div class="body">
                <h1><?php the_title(); ?></h1>
                <div class="post-content">
                    <?php the_content(); ?>
                </div>
            </div>
        </article>
    <?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>
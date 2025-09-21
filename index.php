<?php get_header(); ?>

<div class="container">

    <h2>Latest News</h2>
    <div class="post-grid">
        <?php
        $latest_posts = new WP_Query(array('posts_per_page' => 6));
        if ($latest_posts->have_posts()):
            while ($latest_posts->have_posts()): $latest_posts->the_post(); ?>
                <article>
                    <?php if (has_post_thumbnail()): ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium'); ?>
                        </a>
                    <?php endif; ?>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p><?php the_excerpt(); ?></p>
                </article>
            <?php endwhile;
        endif;
        wp_reset_postdata();
        ?>
    </div>

    <div class="newsletter">
        <h2>Subscribe to our Newsletter</h2>
        <form>
            <input type="email" placeholder="Enter your email">
            <button type="submit">Subscribe</button>
        </form>
    </div>

</div>

<?php get_footer(); ?>

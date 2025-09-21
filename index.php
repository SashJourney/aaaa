<?php get_header(); ?>

<main>
  <section>
    <h2>Latest News</h2>
    <div class="post-grid">
      <?php
        $latest = new WP_Query(['posts_per_page' => 6, 'category_name' => 'news']);
        while($latest->have_posts()): $latest->the_post(); ?>
          <article>
            <a href="<?php the_permalink(); ?>">
              <?php the_post_thumbnail('medium'); ?>
              <h3><?php the_title(); ?></h3>
            </a>
          </article>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </section>

  <section>
    <h2>Cyber News & Risks</h2>
    <div class="post-grid">
      <?php
        $cyber = new WP_Query(['posts_per_page' => 6, 'category_name' => 'cyber']);
        while($cyber->have_posts()): $cyber->the_post(); ?>
          <article>
            <a href="<?php the_permalink(); ?>">
              <?php the_post_thumbnail('medium'); ?>
              <h3><?php the_title(); ?></h3>
            </a>
          </article>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </section>
</main>

<?php get_footer(); ?>

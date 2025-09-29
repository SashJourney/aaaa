<?php get_header(); ?>

<main>
  <h1><?php single_cat_title(); ?></h1>
  <div class="post-grid">
    <?php if (have_posts()): while (have_posts()): the_post(); ?>
      <article>
        <a href="<?php the_permalink(); ?>">
          <?php the_post_thumbnail('medium'); ?>
          <h3><?php the_title(); ?></h3>
        </a>
      </article>
    <?php endwhile; endif; ?>
  </div>
</main>

<?php get_footer(); ?>

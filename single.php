<?php get_header(); ?>

<main>
  <?php if (have_posts()): while (have_posts()): the_post(); ?>
    <h1><?php the_title(); ?></h1>
    <p>By <?php the_author(); ?> | <?php the_date(); ?></p>
    <?php the_post_thumbnail('large'); ?>
    <div><?php the_content(); ?></div>

    <div class="post-nav">
      <?php previous_post_link('%link', '← Previous'); ?>
      <?php next_post_link('%link', 'Next →'); ?>
    </div>

    <div class="share-buttons">
      <a href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>" target="_blank">Share on Twitter</a>
    </div>
  <?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>

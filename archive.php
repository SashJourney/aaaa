<?php get_header(); ?>

<div class="container section">
    <h1 class="archive-title">
        <?php 
        if (is_category()) {
            echo 'Category: ' . single_cat_title('', false);
        } elseif (is_tag()) {
            echo 'Tag: ' . single_tag_title('', false);
        } elseif (is_author()) {
            echo 'Author: ' . get_the_author();
        } elseif (is_date()) {
            echo 'Archive: ' . get_the_date('F Y');
        } else {
            echo 'Archive';
        }
        ?>
    </h1>
    
    <div class="grid cols-3">
        <?php if (have_posts()): while(have_posts()): the_post(); ?>
            <article class="card">
                <a href="<?php the_permalink(); ?>" class="thumb">
                    <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('hn-card'); ?>
                    <?php else: ?>
                        <div style="background: var(--bg-card); height: 100%; display: flex; align-items: center; justify-content: center; color: var(--text-secondary);">
                            <i class="fas fa-image"></i>
                        </div>
                    <?php endif; ?>
                </a>
                <div class="body">
                    <div class="meta">
                        <span><?php echo get_the_date(); ?></span>
                        <?php 
                        $categories = get_the_category();
                        if ($categories): 
                        ?>
                            <span>•</span>
                            <a href="<?php echo get_category_link($categories[0]->term_id); ?>">
                                <?php echo $categories[0]->name; ?>
                            </a>
                        <?php endif; ?>
                    </div>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                </div>
            </article>
        <?php endwhile; else: ?>
            <p>No posts found in this archive.</p>
        <?php endif; ?>
    </div>
    
    <!-- Pagination -->
    <div class="pagination-wrapper">
        <?php the_posts_pagination(['mid_size' => 2]); ?>
    </div>
</div>

<?php get_footer(); ?>
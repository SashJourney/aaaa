<?php get_header(); ?>

<main class="site-main single-post">
    <?php if (have_posts()): while (have_posts()): the_post(); ?>
        <article class="post-content">
            <!-- Featured Image Banner -->
            <?php if (has_post_thumbnail()): ?>
                <div class="featured-image-banner">
                    <?php the_post_thumbnail('featured-large'); ?>
                </div>
            <?php endif; ?>

            <div class="container">
                <!-- Post Header -->
                <header class="post-header">
                    <!-- Categories -->
                    <div class="post-categories">
                        <?php
                        $categories = get_the_category();
                        if ($categories) {
                            foreach ($categories as $category) {
                                echo '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>';
                            }
                        }
                        ?>
                    </div>

                    <h1 class="post-title"><?php the_title(); ?></h1>

                    <div class="post-meta">
                        <!-- Author Info -->
                        <div class="author-info">
                            <?php echo get_avatar(get_the_author_meta('ID'), 40); ?>
                            <div>
                                <span class="author-name">By <?php the_author(); ?></span>
                                <span class="post-date"><?php echo get_the_date(); ?></span>
                            </div>
                        </div>

                        <!-- Reading Time -->
                        <div class="reading-time">
                            <?php
                            $content = get_post_field('post_content', get_the_ID());
                            $word_count = str_word_count(strip_tags($content));
                            $reading_time = ceil($word_count / 200); // Assuming 200 words per minute
                            echo '<i class="fas fa-clock"></i> ' . $reading_time . ' min read';
                            ?>
                        </div>
                    </div>
                </header>

                <!-- Social Share Floating Bar -->
                <div class="social-share-floating">
                    <button class="share-button" data-share="twitter">
                        <i class="fab fa-twitter"></i>
                    </button>
                    <button class="share-button" data-share="facebook">
                        <i class="fab fa-facebook-f"></i>
                    </button>
                    <button class="share-button" data-share="linkedin">
                        <i class="fab fa-linkedin-in"></i>
                    </button>
                    <button class="share-button" data-share="reddit">
                        <i class="fab fa-reddit-alien"></i>
                    </button>
                    <button class="share-button" data-share="copy">
                        <i class="fas fa-link"></i>
                    </button>
                </div>

                <!-- Main Content -->
                <div class="post-body">
                    <?php the_content(); ?>

                    <!-- Tags -->
                    <?php
                    $tags = get_the_tags();
                    if ($tags): ?>
                        <div class="post-tags">
                            <?php foreach ($tags as $tag): ?>
                                <a href="<?php echo get_tag_link($tag->term_id); ?>" class="tag">
                                    #<?php echo $tag->name; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Author Box -->
                <div class="author-box">
                    <div class="author-avatar">
                        <?php echo get_avatar(get_the_author_meta('ID'), 100); ?>
                    </div>
                    <div class="author-info">
                        <h3><?php the_author(); ?></h3>
                        <p><?php echo get_the_author_meta('description'); ?></p>
                        <div class="author-social">
                            <?php
                            $twitter = get_the_author_meta('twitter');
                            $linkedin = get_the_author_meta('linkedin');
                            if ($twitter) echo '<a href="' . esc_url($twitter) . '" target="_blank"><i class="fab fa-twitter"></i></a>';
                            if ($linkedin) echo '<a href="' . esc_url($linkedin) . '" target="_blank"><i class="fab fa-linkedin"></i></a>';
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Post Navigation -->
                <nav class="post-navigation">
                    <?php
                    $prev_post = get_previous_post();
                    $next_post = get_next_post();
                    ?>
                    
                    <?php if (!empty($prev_post)): ?>
                        <a href="<?php echo get_permalink($prev_post); ?>" class="nav-link prev-post">
                            <span class="nav-label"><i class="fas fa-arrow-left"></i> Previous</span>
                            <span class="nav-title"><?php echo $prev_post->post_title; ?></span>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($next_post)): ?>
                        <a href="<?php echo get_permalink($next_post); ?>" class="nav-link next-post">
                            <span class="nav-label">Next <i class="fas fa-arrow-right"></i></span>
                            <span class="nav-title"><?php echo $next_post->post_title; ?></span>
                        </a>
                    <?php endif; ?>
                </nav>

                <!-- Related Posts -->
                <div class="related-posts">
                    <h2>Related Articles</h2>
                    <div class="post-grid">
                        <?php
                        $categories = get_the_category();
                        if ($categories) {
                            $category_ids = array();
                            foreach ($categories as $category) $category_ids[] = $category->term_id;

                            $related_posts = new WP_Query(array(
                                'category__in' => $category_ids,
                                'post__not_in' => array(get_the_ID()),
                                'posts_per_page' => 3,
                                'orderby' => 'rand'
                            ));

                            if ($related_posts->have_posts()):
                                while ($related_posts->have_posts()): $related_posts->the_post(); ?>
                                    <article class="post-card">
                                        <div class="post-image">
                                            <?php if (has_post_thumbnail()): ?>
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php the_post_thumbnail('category-thumb'); ?>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="post-content">
                                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                            <div class="post-meta">
                                                <span class="post-date"><?php echo get_the_date(); ?></span>
                                            </div>
                                        </div>
                                    </article>
                                <?php endwhile;
                            endif;
                            wp_reset_postdata();
                        }
                        ?>
                    </div>
                </div>

                <!-- Comments Section -->
                <?php
                if (comments_open() || get_comments_number()):
                    comments_template();
                endif;
                ?>
            </div>
        </article>
    <?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>

<?php get_header(); ?>

<main class="site-main">
    <!-- Featured Section -->
    <section class="featured-section">
        <div class="container">
            <h2 class="section-title">Featured Articles</h2>
            <div class="featured-grid">
                <?php
                $featured_posts = new WP_Query(array(
                    'posts_per_page' => 3,
                    'meta_key' => 'featured_post',
                    'meta_value' => '1'
                ));
                if ($featured_posts->have_posts()):
                    while ($featured_posts->have_posts()): $featured_posts->the_post(); ?>
                        <article class="featured-article">
                            <div class="article-image">
                                <?php if (has_post_thumbnail()): ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('featured-large'); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="article-content">
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <div class="article-meta">
                                    <span class="post-date"><?php echo get_the_date(); ?></span>
                                    <span class="post-author">by <?php the_author(); ?></span>
                                </div>
                                <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                            </div>
                        </article>
                    <?php endwhile;
                endif;
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </section>

    <!-- Category Grid -->
    <section class="categories-section">
        <div class="container">
            <h2 class="section-title">Explore Topics</h2>
            <div class="category-grid">
                <?php
                $categories = array(
                    array('slug' => 'cyber-news', 'name' => 'Cyber News & Risks', 'icon' => 'fa-newspaper'),
                    array('slug' => 'tutorials', 'name' => 'Tutorials', 'icon' => 'fa-graduation-cap'),
                    array('slug' => 'tools', 'name' => 'Security Tools', 'icon' => 'fa-tools'),
                    array('slug' => 'vulnerabilities', 'name' => 'Vulnerabilities', 'icon' => 'fa-shield-alt'),
                    array('slug' => 'research', 'name' => 'Research', 'icon' => 'fa-microscope'),
                    array('slug' => 'community', 'name' => 'Community', 'icon' => 'fa-users')
                );

                foreach ($categories as $cat): ?>
                    <a href="<?php echo get_category_link(get_cat_ID($cat['name'])); ?>" class="category-card">
                        <i class="fas <?php echo $cat['icon']; ?>"></i>
                        <h3><?php echo $cat['name']; ?></h3>
                        <span class="post-count">
                            <?php 
                            $category = get_category(get_cat_ID($cat['name']));
                            if (!is_wp_error($category)) {
                                echo $category->count . ' posts';
                            } else {
                                echo '0 posts';
                            }
                            ?>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Latest Posts -->
    <section class="latest-posts-section">
        <div class="container">
            <h2 class="section-title">Latest News</h2>
            <div class="post-grid">
                <?php
                $latest_posts = new WP_Query(array(
                    'posts_per_page' => 6,
                    'ignore_sticky_posts' => 1
                ));
                if ($latest_posts->have_posts()):
                    while ($latest_posts->have_posts()): $latest_posts->the_post(); ?>
                        <article class="post-card">
                            <div class="post-image">
                                <?php if (has_post_thumbnail()): ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('category-thumb'); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="post-content">
                                <div class="post-meta">
                                    <span class="post-date"><?php echo get_the_date(); ?></span>
                                    <?php
                                    $categories = get_the_category();
                                    if ($categories): ?>
                                        <span class="post-category">
                                            <?php echo esc_html($categories[0]->name); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <p><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                                <a href="<?php the_permalink(); ?>" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </article>
                    <?php endwhile;
                endif;
                wp_reset_postdata();
                ?>
            </div>
            <div class="view-all-posts">
                <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="button">View All Posts</a>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="container">
            <div class="newsletter-content">
                <h2>Stay Updated with HackerNull</h2>
                <p>Get the latest cybersecurity news, tutorials, and research delivered to your inbox.</p>
                <form class="newsletter-form" id="newsletter-form">
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Enter your email address" required>
                        <button type="submit">Subscribe <i class="fas fa-paper-plane"></i></button>
                    </div>
                    <div id="captcha-container"></div>
                    <div class="form-message"></div>
                </form>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>

<?php get_header(); ?>

<div class="container section">
    <!-- Featured Articles -->
    <?php 
    $featured = hn_get_featured_posts(6);
    if ($featured->have_posts()): 
    ?>
        <h2 class="section-title">Featured Articles</h2>
        <div class="grid cols-3">
            <?php while($featured->have_posts()): $featured->the_post(); ?>
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
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    <?php endif; ?>
</div>

<div class="container section">
    <!-- Categories Grid -->
    <h2 class="section-title">Categories</h2>
    <div class="grid cols-4">
        <?php
        $categories = get_categories(['hide_empty' => false, 'number' => 8]);
        foreach($categories as $category):
            $icon = 'fas fa-folder';
            // Set different icons based on category name
            $category_name = strtolower($category->name);
            if (strpos($category_name, 'security') !== false) $icon = 'fas fa-shield-alt';
            elseif (strpos($category_name, 'hack') !== false) $icon = 'fas fa-bug';
            elseif (strpos($category_name, 'news') !== false) $icon = 'fas fa-newspaper';
            elseif (strpos($category_name, 'tech') !== false) $icon = 'fas fa-microchip';
            elseif (strpos($category_name, 'web') !== false) $icon = 'fas fa-globe';
            elseif (strpos($category_name, 'mobile') !== false) $icon = 'fas fa-mobile-alt';
            elseif (strpos($category_name, 'data') !== false) $icon = 'fas fa-database';
            elseif (strpos($category_name, 'cloud') !== false) $icon = 'fas fa-cloud';
        ?>
            <a href="<?php echo get_category_link($category->term_id); ?>" class="category-card">
                <div class="category-icon">
                    <i class="<?php echo $icon; ?>"></i>
                </div>
                <h3><?php echo $category->name; ?></h3>
                <div class="category-description">
                    <?php echo $category->description ?: 'Explore ' . $category->name . ' articles'; ?>
                </div>
                <div class="post-count">
                    <i class="fas fa-file-alt"></i>
                    <?php echo $category->count; ?> posts
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<div class="container section">
    <!-- Latest Posts -->
    <h2 class="section-title">Latest Posts</h2>
    <div class="grid cols-3">
        <?php 
        $latest = hn_get_latest_posts(6);
        if ($latest->have_posts()): 
            while($latest->have_posts()): $latest->the_post(); 
        ?>
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
        <?php 
            endwhile; 
            wp_reset_postdata(); 
        else: 
        ?>
            <p>No posts found.</p>
        <?php endif; ?>
    </div>
</div>

<div class="container section">
    <!-- Newsletter -->
    <div class="newsletter" id="newsletter">
        <h3>Stay Updated with HackerNull</h3>
        <p>No spam. Just the latest in security, software, and systems.</p>
        <form id="newsletter-form">
            <input type="email" name="email" placeholder="you@domain.com" required />
            <input type="hidden" name="cf_token" id="cf_token" />
            <button type="submit">Subscribe</button>
            <div class="status" id="newsletter-status" aria-live="polite"></div>
        </form>
        <!-- Turnstile placeholder -->
        <div id="cf-turnstile-placeholder" class="cf-turnstile" data-sitekey="" data-size="invisible" hidden></div>
    </div>
</div>

<?php get_footer(); ?>

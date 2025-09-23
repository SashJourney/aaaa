<?php get_header(); ?>

<div class="container section">
    <?php if (have_posts()): while(have_posts()): the_post(); ?>
        <article <?php post_class('card'); ?>>
            <?php if (has_post_thumbnail()): ?>
                <div class="thumb">
                    <?php the_post_thumbnail('hn-featured'); ?>
                </div>
            <?php endif; ?>
            
            <div class="body">
                <div class="post-header">
                    <h1><?php the_title(); ?></h1>
                    <div class="byline">
                        By <?php the_author_posts_link(); ?> • 
                        <?php echo get_the_date(); ?> • 
                        <?php 
                        $categories = get_the_category();
                        if ($categories): 
                        ?>
                            <a href="<?php echo get_category_link($categories[0]->term_id); ?>">
                                <?php echo $categories[0]->name; ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Share Buttons -->
                <div class="sharebar" role="group" aria-label="Share this post">
                    <?php 
                    $url = urlencode(get_permalink());
                    $title = urlencode(get_the_title());
                    ?>
                    <button type="button" class="share-btn" data-network="twitter" data-url="<?php echo $url; ?>" data-title="<?php echo $title; ?>">
                        <i class="fab fa-twitter"></i> Share on X
                    </button>
                    <button type="button" class="share-btn" data-network="linkedin" data-url="<?php echo $url; ?>" data-title="<?php echo $title; ?>">
                        <i class="fab fa-linkedin"></i> LinkedIn
                    </button>
                    <button type="button" class="share-btn" data-network="facebook" data-url="<?php echo $url; ?>" data-title="<?php echo $title; ?>">
                        <i class="fab fa-facebook"></i> Facebook
                    </button>
                    <button type="button" class="share-btn" data-network="reddit" data-url="<?php echo $url; ?>" data-title="<?php echo $title; ?>">
                        <i class="fab fa-reddit"></i> Reddit
                    </button>
                    <button type="button" class="share-btn" data-network="hackernews" data-url="<?php echo $url; ?>" data-title="<?php echo $title; ?>">
                        <i class="fab fa-hacker-news"></i> Hacker News
                    </button>
                </div>
                
                <div class="post-content">
                    <?php the_content(); ?>
                </div>
                
                <!-- Tags -->
                <?php 
                $tags = get_the_tags();
                if ($tags): 
                ?>
                    <div class="post-tags">
                        <strong>Tags:</strong>
                        <?php foreach($tags as $tag): ?>
                            <a href="<?php echo get_tag_link($tag->term_id); ?>" class="tag">
                                #<?php echo $tag->name; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <!-- Navigation -->
                <div class="post-navigation">
                    <div class="nav-previous">
                        <?php previous_post_link('%link', '← %title'); ?>
                    </div>
                    <div class="nav-next">
                        <?php next_post_link('%link', '%title →'); ?>
                    </div>
                </div>
            </div>
        </article>

        <!-- Related Posts -->
        <?php 
        $related = hn_related_posts(get_the_ID(), 3);
        if ($related->have_posts()): 
        ?>
            <div class="section">
                <h2>Related Articles</h2>
                <div class="grid cols-3">
                    <?php while($related->have_posts()): $related->the_post(); ?>
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
                                </div>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            </div>
                        </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
        <?php endif; ?>

    <?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>
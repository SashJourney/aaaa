<?php ?>
</main>

<footer class="site-footer">
    <div class="container">
        <div style="display: flex; justify-content: space-between; gap: 10px; flex-wrap: wrap; align-items: center;">
            <div>
                © <?php echo date('Y'); ?> <?php bloginfo('name'); ?> | 
                <span class="terminal-line">Security, software, systems. No fluff — just signal.</span>
            </div>
            <div>
                <?php 
                wp_nav_menu([
                    'theme_location' => 'footer',
                    'container' => false,
                    'items_wrap' => '<ul class="footer-menu" style="display: flex; gap: 15px; list-style: none; margin: 0; padding: 0;">%3$s</ul>',
                    'fallback_cb' => false
                ]); 
                ?>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
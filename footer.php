<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-left">
                <p class="copyright">
                    <span class="terminal-prompt">[root@hackernull]# </span>
                    <span class="typing-text">echo "© <?php echo date('Y'); ?> HackerNull - Empowering Ethical Hackers"</span>
                </p>
            </div>
            <div class="footer-right">
                <nav class="footer-nav">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-menu',
                        'container' => false,
                        'menu_class' => 'footer-menu',
                        'fallback_cb' => false
                    ));
                    ?>
                </nav>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

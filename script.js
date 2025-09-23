/**
 * HackerNull Theme JavaScript
 * Clean, modern ES6+ code
 */

(function() {
    'use strict';

    // ==============================
    // Newsletter with Turnstile
    // ==============================
    const initNewsletter = () => {
        const newsletter = document.getElementById('newsletter');
        const form = document.getElementById('newsletter-form');
        const statusEl = document.getElementById('newsletter-status');
        const tokenEl = document.getElementById('cf_token');
        const placeholder = document.getElementById('cf-turnstile-placeholder');

        if (!newsletter || !form) return;

        // Load Turnstile script
        const loadTurnstile = () => {
            if (!HN.turnstileSiteKey || document.getElementById('cf-turnstile-js')) return Promise.resolve();
            
            return new Promise((resolve) => {
                const script = document.createElement('script');
                script.id = 'cf-turnstile-js';
                script.src = 'https://challenges.cloudflare.com/turnstile/v0/api.js';
                script.async = true;
                script.onload = () => resolve();
                document.head.appendChild(script);
            });
        };

        // Render Turnstile widget
        const renderTurnstile = () => {
            if (!window.turnstile || !placeholder) return;
            
            placeholder.dataset.sitekey = HN.turnstileSiteKey;
            placeholder.hidden = false;
            
            window.turnstile.render(placeholder, {
                sitekey: HN.turnstileSiteKey,
                size: 'invisible',
                callback: (token) => {
                    if (tokenEl) tokenEl.value = token;
                }
            });
        };

        // Initialize Turnstile
        loadTurnstile().then(() => {
            if (window.turnstile) {
                renderTurnstile();
            }
        });

        // Handle form submission
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const email = form.querySelector('input[type="email"]').value.trim();
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                statusEl.textContent = HN.i18n.invalidEmail;
                return;
            }

            statusEl.textContent = HN.i18n.subscribing;

            // Execute Turnstile if available
            if (window.turnstile && placeholder && !tokenEl.value) {
                try {
                    await window.turnstile.execute(placeholder);
                } catch (e) {
                    console.log('Turnstile execution failed:', e);
                }
            }

            // Submit form
            const formData = new FormData();
            formData.append('action', 'hn_subscribe');
            formData.append('nonce', HN.nonce);
            formData.append('email', email);
            formData.append('cf_token', tokenEl ? tokenEl.value : '');

            try {
                const response = await fetch(HN.ajax, {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                statusEl.textContent = data.data?.message || (response.ok ? HN.i18n.thanks : HN.i18n.error);
                
                if (response.ok) {
                    form.reset();
                    if (tokenEl) tokenEl.value = '';
                }
            } catch (error) {
                statusEl.textContent = HN.i18n.error;
                console.error('Newsletter error:', error);
            }
        });
    };

    // ==============================
    // Share Buttons
    // ==============================
    const initShareButtons = () => {
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('.share-btn');
            if (!btn) return;

            const network = btn.dataset.network;
            const url = btn.dataset.url;
            const title = btn.dataset.title;

            if (!network || !url) return;

            const shareUrls = {
                twitter: `https://twitter.com/intent/tweet?text=${encodeURIComponent(title)}&url=${encodeURIComponent(url)}`,
                facebook: `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`,
                linkedin: `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`,
                reddit: `https://www.reddit.com/submit?url=${encodeURIComponent(url)}&title=${encodeURIComponent(title)}`,
                hackernews: `https://news.ycombinator.com/submitlink?u=${encodeURIComponent(url)}&t=${encodeURIComponent(title)}`
            };

            const shareUrl = shareUrls[network];
            if (shareUrl) {
                window.open(shareUrl, '_blank', 'noopener,noreferrer,width=700,height=570');
            }
        });
    };

    // ==============================
    // Smooth Scrolling
    // ==============================
    const initSmoothScrolling = () => {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    };

    // ==============================
    // Intersection Observer for Animations
    // ==============================
    const initScrollAnimations = () => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        document.querySelectorAll('.card, .category-card, .section').forEach(el => {
            observer.observe(el);
        });
    };

    // ==============================
    // Mobile Menu Toggle
    // ==============================
    const initMobileMenu = () => {
        const menuToggle = document.querySelector('.menu-toggle');
        const navMenu = document.querySelector('.main-nav');
        
        if (menuToggle && navMenu) {
            menuToggle.addEventListener('click', () => {
                navMenu.classList.toggle('active');
                menuToggle.classList.toggle('active');
            });
        }
    };

    // ==============================
    // Initialize Everything
    // ==============================
    const init = () => {
        // Wait for DOM to be ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
            return;
        }

        initNewsletter();
        initShareButtons();
        initSmoothScrolling();
        initScrollAnimations();
        initMobileMenu();
    };

    // Start the initialization
    init();

})();
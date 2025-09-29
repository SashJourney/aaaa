document.addEventListener('DOMContentLoaded', function() {
    // Initialize particles.js
    particlesJS('particles-js', {
        particles: {
            number: {
                value: 80,
                density: {
                    enable: true,
                    value_area: 800
                }
            },
            color: {
                value: '#9f7aea'
            },
            shape: {
                type: 'circle'
            },
            opacity: {
                value: 0.5,
                random: false
            },
            size: {
                value: 3,
                random: true
            },
            line_linked: {
                enable: true,
                distance: 150,
                color: '#9f7aea',
                opacity: 0.4,
                width: 1
            },
            move: {
                enable: true,
                speed: 2,
                direction: 'none',
                random: false,
                straight: false,
                out_mode: 'out',
                bounce: false
            }
        },
        interactivity: {
            detect_on: 'canvas',
            events: {
                onhover: {
                    enable: true,
                    mode: 'grab'
                },
                onclick: {
                    enable: true,
                    mode: 'push'
                },
                resize: true
            },
            modes: {
                grab: {
                    distance: 140,
                    line_linked: {
                        opacity: 1
                    }
                },
                push: {
                    particles_nb: 4
                }
            }
        },
        retina_detect: true
    });

    // Dark mode toggle
    const darkModeToggle = document.querySelector('.dark-mode-toggle');
    const body = document.body;

    darkModeToggle.addEventListener('click', () => {
        body.classList.toggle('light-mode');
        const icon = darkModeToggle.querySelector('i');
        if (body.classList.contains('light-mode')) {
            icon.classList.remove('fa-moon');
            icon.classList.add('fa-sun');
        } else {
            icon.classList.remove('fa-sun');
            icon.classList.add('fa-moon');
        }
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Newsletter form submission with Cloudflare captcha
    const newsletterForm = document.querySelector('.newsletter form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            try {
                const token = await turnstile.render('#captcha-container');
                const email = newsletterForm.querySelector('input[type="email"]').value;
                
                // Add your newsletter subscription logic here
                console.log('Newsletter subscription:', { email, token });
                
                // Show success message
                const successMessage = document.createElement('div');
                successMessage.className = 'newsletter-success';
                successMessage.textContent = 'Successfully subscribed!';
                newsletterForm.appendChild(successMessage);
                
                // Reset form
                newsletterForm.reset();
                setTimeout(() => successMessage.remove(), 3000);
            } catch (error) {
                console.error('Newsletter subscription failed:', error);
            }
        });
    }

    // Auto-verify captcha on scroll
    let captchaVerified = false;
    window.addEventListener('scroll', () => {
        const captchaContainer = document.querySelector('#captcha-container');
        if (captchaContainer && !captchaVerified) {
            const rect = captchaContainer.getBoundingClientRect();
            if (rect.top >= 0 && rect.bottom <= window.innerHeight) {
                turnstile.ready(() => {
                    turnstile.render('#captcha-container');
                    captchaVerified = true;
                });
            }
        }
    });
});
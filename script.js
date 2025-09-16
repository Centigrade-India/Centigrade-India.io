
// JavaScript for BeatNight Website

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {

    // Mobile Navigation Toggle
    const navToggle = document.querySelector('.nav-toggle');
    const navMenu = document.querySelector('.nav-menu');

    if (navToggle && navMenu) {
        navToggle.addEventListener('click', function() {
            navMenu.classList.toggle('nav-menu-active');
            navToggle.classList.toggle('toggle-active');
        });
    }

    // Smooth scrolling for navigation links
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetSection = document.getElementById(targetId);

            if (targetSection) {
                const headerHeight = document.querySelector('.header').offsetHeight;
                const targetPosition = targetSection.offsetTop - headerHeight;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }

            // Close mobile menu after clicking
            navMenu.classList.remove('nav-menu-active');
            navToggle.classList.remove('toggle-active');
        });
    });

    // Header background on scroll
    const header = document.querySelector('.header');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 100) {
            header.style.background = 'rgba(10, 10, 10, 0.98)';
        } else {
            header.style.background = 'rgba(10, 10, 10, 0.95)';
        }
    });

    // Gallery filter functionality
    const filterBtns = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-album');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');

            const filterValue = this.getAttribute('data-filter');

            galleryItems.forEach(item => {
                if (filterValue === 'all') {
                    item.style.display = 'block';
                    item.style.animation = 'fadeInUp 0.5s ease-out';
                } else {
                    const itemCategories = item.getAttribute('data-category');
                    if (itemCategories && itemCategories.includes(filterValue)) {
                        item.style.display = 'block';
                        item.style.animation = 'fadeInUp 0.5s ease-out';
                    } else {
                        item.style.display = 'none';
                    }
                }
            });
        });
    });

    // Album view functionality
    const viewAlbumBtns = document.querySelectorAll('.view-album-btn');
    viewAlbumBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const albumTitle = this.closest('.album-overlay').querySelector('h4').textContent;
            alert(`Opening album: ${albumTitle}\n\nThis would typically open a lightbox gallery or navigate to a detailed album page.`);
        });
    });

    // Contact form submission
    const contactForm = document.querySelector('.contact-form form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData(this);
            const name = formData.get('name');
            const email = formData.get('email');
            const phone = formData.get('phone');
            const subject = formData.get('subject');
            const message = formData.get('message');

            // Basic validation
            if (!name || !email || !message) {
                alert('Please fill in all required fields.');
                return;
            }

            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Please enter a valid email address.');
                return;
            }

            // Simulate form submission
            const submitBtn = this.querySelector('.btn-primary');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Sending...';
            submitBtn.disabled = true;

            setTimeout(() => {
                alert(`Thank you, ${name}! Your message has been sent. We'll get back to you soon.`);
                this.reset();
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }, 2000);
        });
    }

    // Animate elements on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'fadeInUp 1s ease-out';
                entry.target.style.opacity = '1';
            }
        });
    }, observerOptions);

    // Observe elements for animation
    const animateElements = document.querySelectorAll('.event-card, .gallery-album, .team-member, .contact-item');
    animateElements.forEach(el => {
        el.style.opacity = '0';
        observer.observe(el);
    });

    // Event ticket booking tracking
    const ticketButtons = document.querySelectorAll('.btn-event');
    ticketButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            const eventTitle = this.closest('.event-card').querySelector('h3').textContent;
            const eventPrice = this.closest('.event-card').querySelector('.event-price').textContent;

            // Track the click (you can integrate with analytics here)
            console.log(`Ticket booking clicked: ${eventTitle} - ${eventPrice}`);

            // Optional: Show booking confirmation
            const confirmation = confirm(`You're about to book tickets for:\n\n${eventTitle}\nPrice: ${eventPrice}\n\nProceed to booking partner?`);

            if (!confirmation) {
                e.preventDefault();
            }
        });
    });

    // Add loading animation for hero section
    const heroTitle = document.querySelector('.hero-title');
    if (heroTitle) {
        setTimeout(() => {
            heroTitle.style.animation = 'fadeInUp 1s ease-out';
        }, 500);
    }

    // Dynamic year update in footer
    const currentYear = new Date().getFullYear();
    const footerYear = document.querySelector('.footer-bottom p');
    if (footerYear) {
        footerYear.innerHTML = footerYear.innerHTML.replace('2024', currentYear);
    }

    // Preloader (optional)
    window.addEventListener('load', function() {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            preloader.style.opacity = '0';
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        }
    });

    // Social media share functionality
    function shareOnSocial(platform, url, text) {
        let shareUrl;

        switch(platform) {
            case 'facebook':
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
                break;
            case 'twitter':
                shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(text)}`;
                break;
            case 'instagram':
                // Instagram doesn't have direct sharing, so we'll just open the profile
                shareUrl = 'https://instagram.com/beatnight_blr';
                break;
            default:
                return;
        }

        window.open(shareUrl, '_blank', 'width=600,height=400');
    }

    // Add share buttons functionality if needed
    const shareButtons = document.querySelectorAll('.social-share-btn');
    shareButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const platform = this.getAttribute('data-platform');
            const url = window.location.href;
            const text = 'Check out BeatNight - Bangalore\'s hottest nightclub events!';
            shareOnSocial(platform, url, text);
        });
    });
});

// Additional utility functions for WordPress integration
const BeatNightUtils = {
    // Initialize AJAX for WordPress
    ajaxUrl: '/wp-admin/admin-ajax.php',

    // Send AJAX request to WordPress
    sendAjaxRequest: function(action, data, callback) {
        const xhr = new XMLHttpRequest();
        const params = new URLSearchParams({
            action: action,
            ...data
        });

        xhr.open('POST', this.ajaxUrl);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                callback(JSON.parse(xhr.responseText));
            }
        };
        xhr.send(params);
    },

    // Format date for events
    formatDate: function(dateString) {
        const date = new Date(dateString);
        const options = { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };
        return date.toLocaleDateString('en-US', options);
    },

    // Generate event schema markup for SEO
    generateEventSchema: function(event) {
        return {
            "@context": "https://schema.org",
            "@type": "Event",
            "name": event.name,
            "startDate": event.startDate,
            "endDate": event.endDate,
            "location": {
                "@type": "Place",
                "name": event.venue,
                "address": event.address
            },
            "organizer": {
                "@type": "Organization",
                "name": "BeatNight",
                "url": "https://beatnight.in"
            },
            "offers": {
                "@type": "Offer",
                "price": event.price,
                "priceCurrency": "INR",
                "url": event.ticketUrl
            }
        };
    }
};

// Export for WordPress theme integration
if (typeof window !== 'undefined') {
    window.BeatNightUtils = BeatNightUtils;
}

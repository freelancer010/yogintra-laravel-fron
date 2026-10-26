(function () {
    'use strict';

    var loader = document.getElementById('homeLegacyLoader');
    if (!loader) return;

    var pluginSource = loader.getAttribute('data-plugin-src');
    var loading = false;

    function loadLegacyCarouselRuntime() {
        if (loading || !pluginSource || (window.jQuery && jQuery.fn && jQuery.fn.owlCarousel)) {
            if (window.jQuery && jQuery.fn && jQuery.fn.owlCarousel) {
                window.dispatchEvent(new Event('home:legacy-ready'));
            }
            return;
        }

        loading = true;
        var script = document.createElement('script');
        script.src = pluginSource;
        script.async = true;
        script.onload = function () {
            window.dispatchEvent(new Event('home:legacy-ready'));
        };
        script.onerror = function () {
            loading = false;
        };
        document.head.appendChild(script);
    }

    ['pointerdown', 'touchstart', 'keydown', 'wheel'].forEach(function (eventName) {
        window.addEventListener(eventName, loadLegacyCarouselRuntime, { once: true, passive: eventName !== 'keydown' });
    });

    var carousels = document.querySelectorAll('.home-trainer-carousel, .home-testimonial-carousel');
    if ('IntersectionObserver' in window && carousels.length) {
        var observer = new IntersectionObserver(function (entries) {
            if (!entries.some(function (entry) { return entry.isIntersecting; })) return;
            observer.disconnect();
            loadLegacyCarouselRuntime();
        }, { rootMargin: '800px 0px' });
        carousels.forEach(function (carousel) { observer.observe(carousel); });
    }
}());

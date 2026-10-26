(function () {
    'use strict';

    var loader = document.getElementById('homeLegacyLoader');
    if (!loader) return;

    var jquerySource = loader.getAttribute('data-jquery-src');
    var pluginSource = loader.getAttribute('data-plugin-src');
    var loading = false;

    function dispatchReady() {
        window.dispatchEvent(new Event('home:legacy-ready'));
    }

    function loadPluginRuntime() {
        if (window.jQuery && jQuery.fn && jQuery.fn.owlCarousel) {
            dispatchReady();
            return;
        }

        var script = document.createElement('script');
        script.src = pluginSource;
        script.async = true;
        script.onload = dispatchReady;
        script.onerror = function () {
            loading = false;
        };
        document.head.appendChild(script);
    }

    function loadLegacyCarouselRuntime() {
        if (loading || !pluginSource) return;
        if (window.jQuery && jQuery.fn && jQuery.fn.owlCarousel) {
            dispatchReady();
            return;
        }

        loading = true;
        if (window.jQuery) {
            loadPluginRuntime();
            return;
        }

        if (!jquerySource) {
            loading = false;
            return;
        }

        var jquery = document.createElement('script');
        jquery.src = jquerySource;
        jquery.async = true;
        jquery.onload = loadPluginRuntime;
        jquery.onerror = function () {
            loading = false;
        };
        document.head.appendChild(jquery);
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

(function () {
    'use strict';

    function labelCarouselDots(scope) {
        (scope || document).querySelectorAll('.owl-dots .owl-dot').forEach(function (dot, index) {
            if (!dot.getAttribute('aria-label')) {
                dot.setAttribute('aria-label', 'Show slide ' + (index + 1));
            }

            dot.setAttribute('aria-current', dot.classList.contains('active') ? 'true' : 'false');
        });
    }

    function observeCarouselControls() {
        labelCarouselDots();

        new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                mutation.addedNodes.forEach(function (node) {
                    if (node.nodeType === Node.ELEMENT_NODE) {
                        if (node.matches('.owl-dots .owl-dot')) {
                            node.setAttribute('aria-label', 'Show slide');
                        }
                        labelCarouselDots(node.parentElement || document);
                    }
                });
            });
        }).observe(document.body, { childList: true, subtree: true });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', observeCarouselControls, { once: true });
    } else {
        observeCarouselControls();
    }
}());

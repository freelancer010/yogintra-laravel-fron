(function () {
                        var video = document.querySelector('.hero-background-video');
                        if (!video) return;
                        video.muted = true;
                        var startVideo = function () { video.play().catch(function () {}); };
                        // The preloaded poster is the LCP image. Delay the larger
                        // video request until the initial page paint is complete.
                        window.addEventListener('load', function () {
                            if ('requestIdleCallback' in window) {
                                window.requestIdleCallback(startVideo, { timeout: 1500 });
                            } else {
                                window.setTimeout(startVideo, 300);
                            }
                        }, { once: true });

                        var showPosterFallback = function () {
                            video.style.display = 'none';
                        };
                        video.addEventListener('error', showPosterFallback);
                    }());

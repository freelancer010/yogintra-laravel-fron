(function () {
                        var video = document.querySelector('.hero-background-video');
                        if (!video) return;
                        video.muted = true;
                        var playButton = document.querySelector('.hero-video-play');
                        var connection = navigator.connection;
                        var manualPlayback = window.matchMedia('(max-width: 767px), (prefers-reduced-motion: reduce)').matches || (connection && connection.saveData);
                        if (manualPlayback) {
                            if (playButton) {
                                playButton.hidden = false;
                                playButton.addEventListener('click', function () {
                                    video.play().then(function () {
                                        video.classList.add('is-playing');
                                        playButton.hidden = true;
                                    }).catch(function () {
                                        playButton.setAttribute('aria-label', 'Retry background video');
                                        playButton.setAttribute('title', 'Retry background video');
                                    });
                                });
                            }
                            return;
                        }
                        var startVideo = function () {
                            video.play().then(function () {
                                video.classList.add('is-playing');
                            }).catch(function () {});
                        };
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
                            video.classList.remove('is-playing');
                            video.style.display = 'none';
                        };
                        video.addEventListener('error', showPosterFallback);
                    }());

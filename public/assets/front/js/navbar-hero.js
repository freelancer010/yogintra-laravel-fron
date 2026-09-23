document.addEventListener('DOMContentLoaded', function () {
                const header = document.getElementById('header');
                const hero = document.getElementById('home');
                if (!header || !hero) return;
                const isLandingNavigation = header.classList.contains('landing-hero-navigation');
                const scrolledClass = isLandingNavigation ? 'landing-hero-scrolled' : 'mobile-hero-scrolled';
                const nav = header.querySelector('.header-nav');
                const navWrapper = header.querySelector('.header-nav-wrapper');
                const menu = header.querySelector('.menuzord');
                const updateMobileHeroNavigation = function () {
                    if (window.innerWidth > 1000 && !isLandingNavigation) {
                        header.classList.remove(scrolledClass);
                        [header, nav, navWrapper, menu].filter(Boolean).forEach(function (element) {
                            element.style.removeProperty('background-color');
                            element.style.removeProperty('box-shadow');
                        });
                        ['position', 'top', 'left', 'width'].forEach(function (property) {
                            header.style.removeProperty(property);
                            if (nav) nav.style.removeProperty(property);
                        });
                        return;
                    }
                    const scrolled = Math.max(
                        window.pageYOffset || 0,
                        document.documentElement.scrollTop || 0,
                        document.body.scrollTop || 0
                    ) > 12;
                    header.classList.toggle(scrolledClass, scrolled);
                    if (scrolled) {
                        header.style.setProperty('position', 'fixed', 'important');
                        header.style.setProperty('top', '0', 'important');
                        header.style.setProperty('left', '0', 'important');
                        header.style.setProperty('width', '100%', 'important');
                        if (nav && !isLandingNavigation) {
                            nav.style.setProperty('position', 'fixed', 'important');
                            nav.style.setProperty('top', '0', 'important');
                            nav.style.setProperty('left', '0', 'important');
                            nav.style.setProperty('width', '100%', 'important');
                            nav.style.setProperty('z-index', '1101', 'important');
                        }
                    } else {
                        header.style.removeProperty('position');
                        header.style.removeProperty('top');
                        header.style.removeProperty('left');
                        header.style.removeProperty('width');
                        if (nav) {
                            ['position', 'top', 'left', 'width', 'z-index'].forEach(function (property) {
                                nav.style.removeProperty(property);
                            });
                        }
                    }
                    [header, nav, navWrapper, menu].filter(Boolean).forEach(function (element) {
                        if (scrolled) {
                            element.style.setProperty('background-color', '#fff', 'important');
                            element.style.setProperty('box-shadow', element === header ? '0 2px 12px rgba(10,49,59,.12)' : 'none', 'important');
                        } else if (isLandingNavigation) {
                            element.style.setProperty('background-color', 'transparent', 'important');
                            element.style.setProperty('box-shadow', 'none', 'important');
                        } else {
                            element.style.removeProperty('background-color');
                            element.style.removeProperty('box-shadow');
                        }
                    });
                };
                updateMobileHeroNavigation();
                window.addEventListener('scroll', updateMobileHeroNavigation, { passive: true });
                document.addEventListener('scroll', updateMobileHeroNavigation, { passive: true, capture: true });
                window.addEventListener('resize', updateMobileHeroNavigation);
                (function watchMobileHeroNavigation() {
                    updateMobileHeroNavigation();
                    window.requestAnimationFrame(watchMobileHeroNavigation);
                }());
                document.addEventListener('click', function (event) {
                    if (!event.target.closest('.home-mobile-hero-navigation .showhide, .landing-hero-navigation .showhide')) return;
                    header.classList.toggle('mobile-menu-open');
                    const toggle = header.querySelector('.showhide');
                    if (toggle) toggle.setAttribute('aria-expanded', header.classList.contains('mobile-menu-open') ? 'true' : 'false');
                }, true);
            });

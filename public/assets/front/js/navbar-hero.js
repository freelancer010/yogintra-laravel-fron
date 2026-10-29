document.addEventListener('DOMContentLoaded', function () {
                const header = document.getElementById('header');
                if (!header) return;
                const isLandingNavigation = header.classList.contains('landing-hero-navigation');
                const scrolledClass = isLandingNavigation ? 'landing-hero-scrolled' : 'mobile-hero-scrolled';
                const nav = header.querySelector('.header-nav');
                const navWrapper = header.querySelector('.header-nav-wrapper');
                const menu = header.querySelector('.menuzord');
                const updateMobileHeroNavigation = function () {
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
                // Landing pages retain their existing sticky integration. Home
                // already updates on scroll/resize; idle frames need no writes.
                if (isLandingNavigation) (function watchMobileHeroNavigation() {
                    updateMobileHeroNavigation();
                    window.requestAnimationFrame(watchMobileHeroNavigation);
                }());
                const homeToggle = header.querySelector('.home-native-menu-toggle');
                const homeMenu = header.querySelector('#home-navigation-menu');
                const homeSubmenuItems = homeMenu ? Array.from(homeMenu.children).filter(function (item) {
                    return Array.from(item.children).some(function (child) {
                        return child.matches('ul.dropdown, ul.megamenu');
                    });
                }) : [];
                const setHomeSubmenuOpen = function (item, open) {
                    const toggle = item.querySelector(':scope > .home-submenu-toggle');
                    item.classList.toggle('home-submenu-open', open);
                    if (toggle) {
                        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                        const symbol = toggle.querySelector('[aria-hidden="true"]');
                        if (symbol) symbol.textContent = open ? '\u2212' : '+';
                    }
                };
                homeSubmenuItems.forEach(function (item, index) {
                    const link = Array.from(item.children).find(function (child) { return child.matches('a'); });
                    const submenu = Array.from(item.children).find(function (child) { return child.matches('ul.dropdown, ul.megamenu'); });
                    if (!link || !submenu) return;
                    const submenuId = 'home-mobile-submenu-' + index;
                    const toggle = document.createElement('button');
                    const symbol = document.createElement('span');
                    item.classList.add('home-has-submenu');
                    submenu.id = submenuId;
                    toggle.type = 'button';
                    toggle.className = 'home-submenu-toggle';
                    toggle.setAttribute('aria-label', 'Toggle ' + link.textContent.trim() + ' submenu');
                    toggle.setAttribute('aria-controls', submenuId);
                    toggle.setAttribute('aria-expanded', 'false');
                    symbol.setAttribute('aria-hidden', 'true');
                    symbol.textContent = '+';
                    toggle.appendChild(symbol);
                    item.insertBefore(toggle, submenu);
                });
                const setHomeMenuOpen = function (open) {
                    header.classList.toggle('mobile-menu-open', open);
                    if (homeToggle) homeToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                    if (!open) homeSubmenuItems.forEach(function (item) { setHomeSubmenuOpen(item, false); });
                };
                document.addEventListener('click', function (event) {
                    const nativeToggle = event.target.closest('.home-mobile-hero-navigation .home-native-menu-toggle');
                    if (nativeToggle) {
                        event.preventDefault();
                        setHomeMenuOpen(!header.classList.contains('mobile-menu-open'));
                        return;
                    }
                    if (!event.target.closest('.landing-hero-navigation .showhide')) return;
                    header.classList.toggle('mobile-menu-open');
                    const landingToggle = header.querySelector('.showhide');
                    if (landingToggle) landingToggle.setAttribute('aria-expanded', header.classList.contains('mobile-menu-open') ? 'true' : 'false');
                }, true);
                document.addEventListener('keydown', function (event) {
                    if (event.key !== 'Escape' || !header.classList.contains('mobile-menu-open') || !homeToggle) return;
                    setHomeMenuOpen(false);
                    homeToggle.focus();
                });
                if (homeMenu) {
                    homeMenu.addEventListener('click', function (event) {
                        const submenuToggle = event.target.closest('.home-submenu-toggle');
                        if (submenuToggle) {
                            event.preventDefault();
                            const item = submenuToggle.parentElement;
                            const willOpen = !item.classList.contains('home-submenu-open');
                            homeSubmenuItems.forEach(function (otherItem) {
                                setHomeSubmenuOpen(otherItem, otherItem === item && willOpen);
                            });
                            return;
                        }
                        if (event.target.closest('a') && !event.target.closest('.indicator')) setHomeMenuOpen(false);
                    });
                }
                window.addEventListener('resize', function () {
                    if (window.innerWidth > 1000 && homeToggle) setHomeMenuOpen(false);
                });
            });

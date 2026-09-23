document.addEventListener('DOMContentLoaded', function () {
            const makeMobileMenuToggleCrawlable = function () {
                const toggle = document.querySelector('#menuzord-right > .showhide, #menuzord-right .showhide');
                if (!toggle) return false;
                if (/^javascript:/i.test(toggle.getAttribute('href') || '')) {
                    toggle.setAttribute('href', '#menuzord-right');
                }
                toggle.setAttribute('role', 'button');
                toggle.setAttribute('aria-label', 'Toggle navigation menu');
                toggle.setAttribute('aria-controls', 'menuzord-right');
                toggle.setAttribute('aria-expanded', 'false');
                if (!toggle.querySelector('.sr-only')) {
                    const label = document.createElement('span');
                    label.className = 'sr-only';
                    label.textContent = 'Toggle navigation menu';
                    toggle.appendChild(label);
                }
                return true;
            };

            if (makeMobileMenuToggleCrawlable()) return;
            const observer = new MutationObserver(function () {
                if (makeMobileMenuToggleCrawlable()) observer.disconnect();
            });
            observer.observe(document.body, { childList: true, subtree: true });
        });

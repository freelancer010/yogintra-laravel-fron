(function () {
            var consentCookie = 'yogintra_cookie_preferences';
            var maxAge = 60 * 60 * 24 * 365;
            var banner = document.getElementById('cookieBanner');
            var preferences = document.getElementById('cookiePreferences');

            function readConsent() {
                var match = document.cookie.match(new RegExp('(?:^|; )' + consentCookie + '=([^;]*)'));
                if (!match) return null;
                try { return JSON.parse(decodeURIComponent(match[1])); } catch (error) { return null; }
            }

            function applyConsent(consent) {
                if (consent.analytics) window.loadGoogleAnalytics();
                if (consent.marketing) window.loadMetaPixel();
                if (consent.functional) window.loadWhatsAppWidget();
            }

            function saveConsent(consent) {
                var secure = window.location.protocol === 'https:' ? '; Secure' : '';
                document.cookie = consentCookie + '=' + encodeURIComponent(JSON.stringify(consent)) + '; path=/; max-age=' + maxAge + '; SameSite=Lax' + secure;
                applyConsent(consent);
                banner.style.display = 'none';
            }

            var savedConsent = readConsent();
            if (savedConsent) {
                applyConsent(savedConsent);
            } else {
                banner.style.display = 'block';
            }

            document.getElementById('cookieAcceptAll').addEventListener('click', function () {
                saveConsent({ version: 1, analytics: true, marketing: true, functional: true });
            });
            document.getElementById('cookieReject').addEventListener('click', function () {
                saveConsent({ version: 1, analytics: false, marketing: false, functional: false });
            });
            document.getElementById('cookieManage').addEventListener('click', function () {
                preferences.classList.toggle('is-open');
            });
            document.getElementById('cookieSave').addEventListener('click', function () {
                saveConsent({
                    version: 1,
                    analytics: document.getElementById('cookieAnalytics').checked,
                    marketing: document.getElementById('cookieMarketing').checked,
                    functional: document.getElementById('cookieFunctional').checked
                });
            });
        }());

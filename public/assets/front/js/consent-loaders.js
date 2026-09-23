window.loadGoogleAnalytics = function () {
            if (window.googleAnalyticsLoaded) return;
            window.googleAnalyticsLoaded = true;
            window.dataLayer = window.dataLayer || [];
            window.gtag = function () { window.dataLayer.push(arguments); };
            window.gtag('js', new Date());
            window.gtag('config', 'G-8QW4B6YQ9G');

            var script = document.createElement('script');
            script.async = true;
            script.src = 'https://www.googletagmanager.com/gtag/js?id=G-8QW4B6YQ9G';
            document.head.appendChild(script);
        };

        window.loadMetaPixel = function () {
            if (window.metaPixelLoaded) return;
            window.metaPixelLoaded = true;
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            window.fbq('init', '399354049700557');
            window.fbq('track', 'PageView');
        };

        window.loadWhatsAppWidget = function () {
            if (window.whatsAppWidgetLoaded) return;
            window.whatsAppWidgetLoaded = true;
            window.wa_btnSetting = {"btnColor":"#16BE45","ctaText":"","cornerRadius":40,"marginBottom":20,"marginLeft":20,"marginRight":20,"btnPosition":"right","whatsAppNumber":"919867291573","welcomeMessage":"Hello","zIndex":999999,"btnColorScheme":"light"};
            var script = document.createElement('script');
            script.async = true;
            script.src = 'https://d2mpatx37cqexb.cloudfront.net/delightchat-whatsapp-widget/embeds/embed.min.js';
            script.onload = function () { window._waEmbed(window.wa_btnSetting); };
            document.body.appendChild(script);
        };

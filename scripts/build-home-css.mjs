import { createRequire } from 'node:module';
import { readFileSync, writeFileSync } from 'node:fs';
const require = createRequire(import.meta.url);
const { PurgeCSS } = require(process.env.PURGECSS_PATH || 'purgecss');

// The homepage bundle must not inherit selectors from every unrelated public
// page or from the legacy all-plugins scripts. Scan the homepage and its shared
// shell/components, plus only scripts that actually mutate homepage markup.
// Plugin-generated classes are retained explicitly below.
const [result] = await new PurgeCSS().purge({
  content: [
    'resources/views/front/home.blade.php',
    'resources/views/partials/navbar.blade.php',
    'resources/views/partials/footer.blade.php',
    'resources/views/components/multi-step-form.blade.php',
    'resources/views/layouts/layout.blade.php',
    'public/assets/front/js/home-page.js',
    'public/assets/front/js/home-legacy-loader.js',
    'public/assets/front/js/home-backgrounds.js',
    'public/assets/front/js/home-carousel-accessibility.js',
    'public/assets/front/js/home-hero-video.js',
    'public/assets/front/js/navbar-hero.js',
    'public/assets/front/js/navbar-accessibility.min.js',
    'public/assets/front/js/contact-popup-form.min.js',
    'public/assets/front/js/cookie-preferences.min.js',
  ],
  css: [{
    raw: [
      readFileSync('public/assets/front/css/frontend.bundle.min.css', 'utf8'),
      readFileSync('public/assets/front/css/home.min.css', 'utf8'),
    ].join('\n'),
    extension: 'css',
  }],
  safelist: {
    // Static utility classes are discovered directly in the Blade/JS sources.
    // Keep only classes generated at runtime by icon, carousel, navigation and
    // overlay plugins; retaining every col/text/font/spacing class kept more
    // than 250 KB of CSS that the homepage never uses.
    standard: [
      /^(?:fa|owl|menuzord)(?:$|-)/,
      /^(?:modal|collapse|collapsing|dropdown|tooltip|popover|mfp|select2|ui-)(?:$|-)/,
      /^(?:has-|is-)/,
      'active', 'open', 'in', 'show', 'hide', 'fade', 'collapsed',
      'disabled', 'error', 'valid', 'is-invalid',
    ],
    deep: [/^(?:owl|menuzord|modal|dropdown|mfp|select2|ui-)/],
  },
  fontFace: false,
  keyframes: false,
  variables: false,
});
writeFileSync('public/assets/front/css/homepage.bundle.min.css', result.css);
console.log(`Homepage CSS: ${Buffer.byteLength(result.css)} bytes`);

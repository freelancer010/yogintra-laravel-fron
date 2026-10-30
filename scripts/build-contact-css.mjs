import { createRequire } from 'node:module';
import { readFileSync, writeFileSync } from 'node:fs';

const require = createRequire(import.meta.url);
const { PurgeCSS } = require(process.env.PURGECSS_PATH || 'purgecss');

// Build a page-specific stylesheet from the existing public bundle. Dynamic
// navigation, modal and form state classes are retained explicitly so the
// contact flow behaves exactly like pages using the full legacy stylesheet.
const [result] = await new PurgeCSS().purge({
  content: [
    'resources/views/front/contact.blade.php',
    'resources/views/partials/navbar.blade.php',
    'resources/views/partials/footer.blade.php',
    'resources/views/components/multi-step-form.blade.php',
    'resources/views/layouts/layout.blade.php',
    'public/assets/front/js/custom.min.js',
    'public/assets/front/js/navbar-accessibility.min.js',
    'public/assets/front/js/contact-popup-form.min.js',
    'public/assets/front/js/cookie-preferences.min.js',
  ],
  css: ['public/assets/front/css/frontend.bundle.min.css'],
  safelist: {
    standard: [
      /^(?:fa|menuzord)(?:$|-)/,
      /^(?:modal|collapse|collapsing|dropdown|tooltip|popover|select2|ui-)(?:$|-)/,
      /^(?:has-|is-)/,
      'active', 'open', 'in', 'show', 'hide', 'fade', 'collapsed',
      'disabled', 'error', 'valid', 'is-invalid',
    ],
    deep: [/^(?:menuzord|modal|dropdown|select2|ui-)/],
  },
  fontFace: false,
  keyframes: false,
  variables: false,
});

writeFileSync('public/assets/front/css/contact.bundle.min.css', result.css);
console.log(`Contact CSS: ${Buffer.byteLength(result.css)} bytes`);

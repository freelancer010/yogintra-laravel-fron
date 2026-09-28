import { createRequire } from 'node:module';
import { writeFileSync } from 'node:fs';
const require = createRequire(import.meta.url);
const { PurgeCSS } = require(process.env.PURGECSS_PATH || 'purgecss');

// Scan all public templates and scripts, not just the initial viewport.
// Preserve plugin-generated markup and dynamic utility/icon classes used by
// database content, menus, modals, carousels and form validation.
const [result] = await new PurgeCSS().purge({
  content: [
    'resources/views/front/**/*.blade.php',
    'resources/views/partials/**/*.blade.php',
    'resources/views/components/**/*.blade.php',
    'resources/views/layouts/layout.blade.php',
    'public/assets/front/js/*.js',
  ],
  css: ['public/assets/front/css/frontend.bundle.min.css'],
  safelist: {
    standard: [/^(?:fa|glyphicon|owl|menuzord|slick|modal|collapse|collapsing|dropdown|tooltip|popover|carousel|mfp|select2|ui-|has-|is-|bg-|text-|font-|col-|hidden-|visible-|btn|alert|form-|input-|p[trblxy]?-|m[trblxy]?-)/, 'active', 'open', 'in', 'show', 'hide', 'disabled', 'error', 'valid'],
    deep: [/^(?:owl|menuzord|modal|dropdown|mfp|select2|ui-)/],
  },
  fontFace: false,
  keyframes: false,
  variables: false,
});
writeFileSync('public/assets/front/css/homepage.bundle.min.css', result.css);
console.log(`Homepage CSS: ${Buffer.byteLength(result.css)} bytes`);

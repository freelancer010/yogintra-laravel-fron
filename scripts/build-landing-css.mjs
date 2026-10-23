import { readFileSync, writeFileSync } from 'node:fs';
import { resolve } from 'node:path';

const root = resolve(import.meta.dirname, '..');
const minifyCss = (css) => css
    .replace(/\/\*[\s\S]*?\*\//g, '')
    .replace(/\s+/g, ' ')
    .replace(/\s*([{}:;,])\s*/g, '$1')
    .trim();

const sourceFiles = [
    'public/assets/landing-reference/classic-trainers.css',
    'public/assets/landing-reference/global-footer.css',
    'public/assets/landing-reference/classic-locations.css',
    'public/assets/landing-reference/classic-testimonials.css',
    'public/assets/landing-reference/landing-floating-tools.css',
];

const css = sourceFiles
    .map((file) => readFileSync(resolve(root, file), 'utf8'))
    .join('\n');

writeFileSync(
    resolve(root, 'public/assets/landing-reference/landing-components.min.css'),
    `${minifyCss(css)}\n`,
);

const criticalHeaderCss = [
    readFileSync(resolve(root, 'public/assets/landing-reference/global-header.css'), 'utf8'),
    '.brand-logo img{display:block;width:190px;height:auto;object-fit:contain}@media(max-width:680px){.brand-logo img{width:150px}}',
].join('\n');

writeFileSync(
    resolve(root, 'public/assets/landing-reference/global-header.min.css'),
    `${minifyCss(criticalHeaderCss)}\n`,
);

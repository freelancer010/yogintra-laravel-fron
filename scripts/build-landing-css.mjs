import { readFileSync, writeFileSync } from 'node:fs';
import { resolve } from 'node:path';

const root = resolve(import.meta.dirname, '..');
const sourceFiles = [
    'public/assets/landing-reference/classic-trainers.css',
    'public/assets/landing-reference/global-footer.css',
    'public/assets/landing-reference/classic-locations.css',
    'public/assets/landing-reference/classic-testimonials.css',
    'public/assets/landing-reference/landing-floating-tools.css',
];

const css = sourceFiles
    .map((file) => readFileSync(resolve(root, file), 'utf8'))
    .join('\n')
    .replace(/\/\*[\s\S]*?\*\//g, '')
    .replace(/\s+/g, ' ')
    .replace(/\s*([{}:;,])\s*/g, '$1')
    .trim();

writeFileSync(resolve(root, 'public/assets/landing-reference/landing-components.min.css'), `${css}\n`);

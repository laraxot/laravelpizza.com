#!/usr/bin/env node
/**
 * Genera un PDF da un manuale markdown (docs/manuals/manuale-utente.md).
 *
 * Uso:
 *   node tools/visual/md-to-pdf.mjs --md laravel/Modules/Notify/docs/manuals/manuale-utente.md \
 *       --out laravel/Modules/Notify/docs/manuals/manuale-utente.pdf
 *
 * Il .md resta la fonte: rigenerare il PDF a ogni modifica del manuale.
 * Immagini: i path relativi (assets/...) sono risolti rispetto alla cartella del .md.
 */
import { createRequire } from 'node:module';
import { readFileSync, writeFileSync, mkdtempSync } from 'node:fs';
import { tmpdir } from 'node:os';
import { dirname, join, resolve } from 'node:path';
import { fileURLToPath, pathToFileURL } from 'node:url';

const ROOT = resolve(dirname(fileURLToPath(import.meta.url)), '../..');
const REQUIRE_FROM = '/mnt/nas07/var/www/_bases/base_fixcity_fila5/package.json';

function arg(name, dflt = '') {
  const i = process.argv.indexOf(`--${name}`);
  return i > -1 ? process.argv[i + 1] : dflt;
}

const mdPath = resolve(arg('md'));
const outPath = resolve(arg('out', mdPath.replace(/\.md$/, '.pdf')));
if (!mdPath || !process.argv.includes('--md')) {
  console.error('uso: md-to-pdf.mjs --md <file.md> [--out <file.pdf>]');
  process.exit(2);
}

const req = createRequire(REQUIRE_FROM);
const MarkdownIt = req('markdown-it');
const { chromium } = req('playwright');

let src = readFileSync(mdPath, 'utf8');
src = src.replace(/^---\n[\s\S]*?\n---\n/, ''); // frontmatter
const md = new MarkdownIt({ html: true, linkify: true, typographer: false });
const body = md.render(src);
const dirUrl = pathToFileURL(dirname(mdPath) + '/').href;

const html = `<!doctype html><html lang="it"><head><meta charset="utf-8">
<title>${mdPath.split('/').pop()}</title>
<base href="${dirUrl}">
<style>
  @page { size: A4; margin: 18mm 16mm; }
  body { font-family: -apple-system, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; font-size: 11pt; line-height: 1.55; color: #1a1a1a; }
  h1 { font-size: 20pt; border-bottom: 2px solid #444; padding-bottom: 6px; }
  h2 { font-size: 15pt; margin-top: 1.4em; border-bottom: 1px solid #ccc; padding-bottom: 4px; }
  h3 { font-size: 12.5pt; margin-top: 1.2em; }
  img { max-width: 100%; height: auto; border: 1px solid #ddd; border-radius: 4px; margin: 8px 0; }
  code { background: #f3f3f3; padding: 1px 4px; border-radius: 3px; font-size: 9.5pt; }
  pre { background: #f6f6f6; padding: 10px; border-radius: 4px; overflow-x: auto; }
  pre code { background: none; padding: 0; }
  blockquote { border-left: 3px solid #999; margin-left: 0; padding-left: 12px; color: #444; }
  table { border-collapse: collapse; width: 100%; font-size: 10pt; }
  th, td { border: 1px solid #ccc; padding: 5px 8px; text-align: left; }
  th { background: #f0f0f0; }
  a { color: #0645ad; text-decoration: none; }
</style></head><body>${body}</body></html>`;

const tmp = join(mkdtempSync(join(tmpdir(), 'mdpdf-')), 'manuale.html');
writeFileSync(tmp, html);

const browser = await chromium.launch({
  executablePath: process.env.CHROMIUM_PATH || '/usr/bin/google-chrome-stable',
  args: ['--no-sandbox'],
});
const page = await browser.newPage();
await page.goto(pathToFileURL(tmp).href);
await page.evaluate(() => document.fonts.ready);
await page.pdf({ path: outPath, format: 'A4', printBackground: true });
await browser.close();
console.log(`OK ${outPath}`);

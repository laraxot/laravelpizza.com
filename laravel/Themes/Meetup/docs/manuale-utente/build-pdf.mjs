#!/usr/bin/env node
// Genera i PDF del manuale d'uso dai file .md di questa cartella.
//
// Requisiti: pandoc (>= 3) e Node con il pacchetto `playwright` (Chromium installato).
// Uso, da questa cartella:   node build-pdf.mjs
// (se Playwright non trova il browser: CHROMIUM_PATH=/percorso/chrome node build-pdf.mjs)
// Risultato: pdf/manuale-completo.pdf e un PDF per capitolo (pdf/01-visitatore.pdf, ...).
//
// I .md restano la fonte: quando cambi testo o screenshot, rigenera i PDF e committa entrambi.

import { execFileSync } from 'node:child_process';
import { mkdirSync, mkdtempSync, readFileSync, writeFileSync } from 'node:fs';
import { tmpdir } from 'node:os';
import { dirname, join } from 'node:path';
import { fileURLToPath, pathToFileURL } from 'node:url';
import { chromium } from 'playwright';

const here = dirname(fileURLToPath(import.meta.url));
const outDir = join(here, 'pdf');
const tmp = mkdtempSync(join(tmpdir(), 'manuale-'));
mkdirSync(outDir, { recursive: true });

const title = 'Manuale d\'uso di Laravel Pizza Meetups';
const chapters = [
    { file: '01-visitatore.md', label: 'Capitolo 1 · Visitatore' },
    { file: '02-partecipante.md', label: 'Capitolo 2 · Partecipante' },
    { file: '03-organizzatore.md', label: 'Capitolo 3 · Organizzatore' },
];
const today = new Date().toLocaleDateString('it-IT', { day: 'numeric', month: 'long', year: 'numeric' });

const read = (f) => readFileSync(join(here, f), 'utf8');
const stem = (f) => f.replace(/\.md$/, '');

// Righe di sola navigazione tra i file: nel PDF non servono.
const stripNav = (md) => md
    .replace(/^\[← Torna all'indice\]\(readme\.md\)\s*$/m, '')
    .replace(/^\[Continua con [^\]]*\]\([^)]*\.md\)\s*$/m, '');

// La sezione per i manutentori resta solo nel .md.
const stripMaintainerNotes = (md) => md.replace(/\n## Note per chi mantiene il manuale[\s\S]*$/, '\n');

const toHtml = (md) => execFileSync('pandoc', ['-f', 'gfm', '-t', 'html5'], { input: md, encoding: 'utf8' });

const css = `
@page { size: A4; margin: 18mm 16mm 20mm; }
* { box-sizing: border-box; }
body { font-family: Inter, "Segoe UI", Roboto, "DejaVu Sans", sans-serif; font-size: 10.5pt; line-height: 1.55; color: #1f2328; }
h1 { font-size: 22pt; color: #b91c1c; margin: 0 0 10pt; line-height: 1.2; }
h2 { font-size: 14pt; margin: 20pt 0 6pt; padding-bottom: 3pt; border-bottom: 1px solid #e5e7eb; break-after: avoid; }
h3 { font-size: 12pt; margin: 14pt 0 4pt; break-after: avoid; }
p, li { orphans: 3; widows: 3; }
a { color: #b91c1c; text-decoration: none; }
img { display: block; max-width: 100%; max-height: 120mm; margin: 8pt auto; border: 1px solid #d1d5db; border-radius: 4pt; break-inside: avoid; }
p:has(> img:only-child) { break-inside: avoid; }
blockquote { margin: 10pt 0; padding: 6pt 10pt; background: #fef3c7; border-left: 4pt solid #f59e0b; border-radius: 3pt; break-inside: avoid; }
blockquote p { margin: 0; }
table { width: 100%; border-collapse: collapse; font-size: 9.5pt; margin: 8pt 0; break-inside: avoid; }
th, td { border: 1px solid #d1d5db; padding: 4pt 6pt; vertical-align: top; text-align: left; }
th { background: #f3f4f6; }
code { font-family: "DejaVu Sans Mono", monospace; font-size: 9pt; background: #f3f4f6; padding: 0 2pt; border-radius: 2pt; }
.chapter { break-before: page; }
.cover { height: 240mm; display: flex; flex-direction: column; justify-content: center; text-align: center; }
.cover h1 { font-size: 30pt; border: 0; }
.cover .sub { font-size: 13pt; color: #4b5563; margin-top: 6pt; }
.cover .date { margin-top: 30pt; color: #6b7280; }
.toc { break-before: page; }
.toc ol { font-size: 12pt; line-height: 2; }
`;

const page = (body) => `<!doctype html><html lang="it"><head><meta charset="utf-8">
<base href="${pathToFileURL(here + '/').href}"><title>${title}</title><style>${css}</style></head>
<body>${body}</body></html>`;

// CHROMIUM_PATH: Chromium già installato da usare al posto di quello di Playwright (opzionale).
const browser = await chromium.launch(process.env.CHROMIUM_PATH ? { executablePath: process.env.CHROMIUM_PATH } : {});
const ctx = await browser.newContext();

async function render(html, out, footerLabel) {
    const file = join(tmp, 'page.html');
    writeFileSync(file, html);
    const p = await ctx.newPage();
    await p.goto(pathToFileURL(file).href, { waitUntil: 'load' });
    await p.pdf({
        path: join(outDir, out),
        format: 'A4',
        printBackground: true,
        preferCSSPageSize: true,
        displayHeaderFooter: true,
        headerTemplate: '<span></span>',
        footerTemplate: `<div style="width:100%;font-size:8px;color:#6b7280;padding:0 16mm;display:flex;justify-content:space-between;font-family:sans-serif">
            <span>${footerLabel}</span><span><span class="pageNumber"></span> / <span class="totalPages"></span></span></div>`,
    });
    await p.close();
    console.log(`pdf/${out}`);
}

// 1. Manuale completo: copertina, indice (readme), capitoli. Link tra file → ancore interne.
const toAnchor = (md) => md.replace(/\]\((0\d-[a-z]+)\.md(#[^)]+)?\)/g, (_, f, hash) => `](${hash ?? '#' + f})`);
let body = `<section class="cover"><h1>${title}</h1>
<div class="sub">Guida passo per passo per visitatori, partecipanti e organizzatori</div>
<div class="date">Aggiornato al ${today}</div></section>`;
body += `<section class="toc">${toHtml(toAnchor(stripMaintainerNotes(read('readme.md'))))}</section>`;
for (const c of chapters) {
    body += `<section class="chapter" id="${stem(c.file)}">${toHtml(toAnchor(stripNav(read(c.file))))}</section>`;
}
await render(page(body), 'manuale-completo.pdf', title);

// 2. Un PDF per capitolo, da dare a chi interessa solo il proprio ruolo. Link → altri PDF.
const toPdfLink = (md) => md
    .replace(/\]\(readme\.md\)/g, '](manuale-completo.pdf)')
    .replace(/\]\((0\d-[a-z]+)\.md(#[^)]+)?\)/g, (_, f, hash) => `](${f}.pdf${hash ?? ''})`);
for (const c of chapters) {
    await render(page(toHtml(toPdfLink(stripNav(read(c.file))))), `${stem(c.file)}.pdf`, `${title} — ${c.label}`);
}

await browser.close();

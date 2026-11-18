// Audit di accessibilità WCAG 2.1 A/AA (axe-core) sulle pagine pubbliche principali.
// Uso: BASE_URL=http://laravelpizza.local node scripts/a11y-audit.mjs [/it,/it/events,...]
// Esce con codice 1 se trova violazioni: utilizzabile prima di ogni rilascio (FR-19).
import { chromium } from 'playwright';
import { readFileSync } from 'node:fs';
import { createRequire } from 'node:module';

const require = createRequire(import.meta.url);
const axeSource = readFileSync(require.resolve('axe-core/axe.min.js'), 'utf8');
const base = process.env.BASE_URL ?? 'http://laravelpizza.local';
const paths = (process.argv[2] ?? '/it,/en,/it/events,/it/events/past,/it/about,/it/contact,/it/auth/login,/it/auth/register,/it/privacy,/it/cookie-policy').split(',');

const browser = await chromium.launch(process.env.CHROMIUM_PATH ? { executablePath: process.env.CHROMIUM_PATH } : {});
const page = await (await browser.newContext({ viewport: { width: 1280, height: 900 } })).newPage();
let total = 0;

for (const path of paths) {
    await page.goto(base + path, { waitUntil: 'networkidle' });
    await page.addScriptTag({ content: axeSource });
    const result = await page.evaluate(() => window.axe.run(document, { runOnly: { type: 'tag', values: ['wcag2a', 'wcag2aa', 'wcag21a', 'wcag21aa'] } }));
    total += result.violations.length;
    console.log(`${result.violations.length === 0 ? '✓' : '✗'} ${path}: ${result.violations.length} violazioni`);
    for (const v of result.violations) {
        console.log(`  - [${v.impact}] ${v.id}: ${v.help} (${v.nodes.length}) → ${v.nodes[0].target.join(' ')}`);
    }
}

await browser.close();
process.exit(total === 0 ? 0 : 1);

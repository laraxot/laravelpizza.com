#!/usr/bin/env node
// Immagine per la condivisione social e il markup degli eventi: public/images/social-share.jpg, 1200x630.
// La usano il <head> del CMS (og:image, twitter:image) e Event::toSchemaOrg() come immagine di riserva.
// Uso, da laravel/Themes/Meetup:  node scripts/social-share-image.mjs   (CHROMIUM_PATH per un Chromium già installato)
// Poi `npm run build` non serve: l'immagine sta in public/ così com'è.
import { readFileSync, mkdirSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';
import { chromium } from 'playwright';

const here = dirname(fileURLToPath(import.meta.url));
const logo = readFileSync(join(here, '../../../Modules/Meetup/resources/svg/logo.svg'), 'utf8')
    .replace('<svg ', '<svg width="150" height="150" style="color:#ef4444" ');

const html = `<!doctype html><html><head><meta charset="utf-8"><style>
* { margin: 0; box-sizing: border-box; }
body { width: 1200px; height: 630px; font-family: Inter, "DejaVu Sans", sans-serif; color: #fff;
  background: radial-gradient(circle at 85% 15%, rgba(239,68,68,.35), transparent 45%), linear-gradient(135deg, #0f172a 0%, #1e293b 55%, #450a0a 100%);
  display: flex; flex-direction: column; justify-content: center; padding: 0 90px; }
.brand { display: flex; align-items: center; gap: 36px; }
h1 { font-size: 84px; font-weight: 800; line-height: 1.05; letter-spacing: -2px; }
h1 span { color: #ef4444; }
p { margin-top: 34px; font-size: 38px; color: #cbd5e1; font-weight: 500; }
.tags { margin-top: 44px; display: flex; gap: 18px; }
.tags div { border: 2px solid rgba(255,255,255,.25); border-radius: 999px; padding: 10px 26px; font-size: 26px; color: #e2e8f0; }
</style></head><body>
<div class="brand">${logo}<h1>Laravel Pizza<br><span>Meetups</span></h1></div>
<p>Laravel · Filament · Livewire — talks, community &amp; pizza</p>
<div class="tags"><div>Milano</div><div>Roma</div><div>Torino</div><div>Bologna</div></div>
</body></html>`;

const out = join(here, '../public/images/social-share.jpg');
mkdirSync(dirname(out), { recursive: true });
const browser = await chromium.launch(process.env.CHROMIUM_PATH ? { executablePath: process.env.CHROMIUM_PATH } : {});
const page = await browser.newPage({ viewport: { width: 1200, height: 630 }, deviceScaleFactor: 1 });
await page.setContent(html, { waitUntil: 'load' });
await page.screenshot({ path: out, type: 'jpeg', quality: 88 });
await browser.close();
console.log(out);

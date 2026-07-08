const { chromium } = require('playwright');
const path = require('path');
const fs = require('fs');

const PAGES = [
  'persona-dettaglio',
  'ufficio',
  'ufficio-dettaglio',
  'enti-e-fondazioni',
  'ente-dettaglio',
  'documenti-dati',
  'documento-dettaglio',
  'dataset-dettaglio',
  'novita',
  'novita-dettaglio',
];

const BASE_REF = 'https://italia.github.io/design-comuni-pagine-statiche/sito';
const BASE_LOCAL = 'http://127.0.0.1:8000/it/tests';
const DOCS_DIR = '/var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen/docs/pages';

async function screenshot(page, url, outPath) {
  try {
    await page.goto(url, { waitUntil: 'networkidle', timeout: 30000 });
    await page.waitForTimeout(1000);
    await page.screenshot({ path: outPath, fullPage: false });
    console.log(`OK: ${outPath}`);
  } catch (e) {
    console.error(`FAIL ${url}: ${e.message}`);
  }
}

(async () => {
  const browser = await chromium.launch({ args: ['--no-sandbox'] });

  for (const pg of PAGES) {
    const dir = path.join(DOCS_DIR, pg);
    fs.mkdirSync(dir, { recursive: true });

    // Desktop
    const desktop = await browser.newContext({ viewport: { width: 1280, height: 900 } });
    const dp = await desktop.newPage();
    await screenshot(dp, `${BASE_REF}/${pg}.html`, path.join(dir, 'REF-desktop.png'));
    await screenshot(dp, `${BASE_LOCAL}/${pg}`, path.join(dir, 'LOCAL-desktop.png'));
    await desktop.close();

    // Mobile
    const mobile = await browser.newContext({ viewport: { width: 375, height: 812 } });
    const mp = await mobile.newPage();
    await screenshot(mp, `${BASE_REF}/${pg}.html`, path.join(dir, 'REF-mobile.png'));
    await screenshot(mp, `${BASE_LOCAL}/${pg}`, path.join(dir, 'LOCAL-mobile.png'));
    await mobile.close();
  }

  await browser.close();
  console.log('Done!');
})();

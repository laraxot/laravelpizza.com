#!/usr/bin/env node
/**
 * Cattura screenshot di laravelpizza.com e della nostra home e li salva in
 * docs/screenshots/grafica-confronto/
 *
 * Prerequisiti: npm install (playwright come devDependency) e
 * npx playwright install chromium (se non già installato).
 *
 * Uso: dalla root del tema (Themes/Meetup):
 *   node scripts/capture-screenshots.mjs
 * oppure
 *   npm run screenshots
 *
 * La nostra home usa LOCAL_URL (default http://127.0.0.1:8002/it).
 * Avviare prima l'app (es. composer dev da laravel/).
 */

import { chromium } from 'playwright';
import { fileURLToPath } from 'url';
import path from 'path';
import fs from 'fs';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const themeRoot = path.resolve(__dirname, '..');
const outDir = path.join(themeRoot, 'docs', 'screenshots', 'grafica-confronto');

const PROD_URL = 'https://laravelpizza.com/';
const LOCAL_URL = process.env.LOCAL_URL || 'http://127.0.0.1:8002/it';

async function main() {
  if (!fs.existsSync(outDir)) {
    fs.mkdirSync(outDir, { recursive: true });
  }

  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext({
    viewport: { width: 1280, height: 720 },
    userAgent: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
  });

  try {
    // Screenshot produzione
    const pageProd = await context.newPage();
    await pageProd.goto(PROD_URL, { waitUntil: 'networkidle', timeout: 15000 });
    await pageProd.screenshot({
      path: path.join(outDir, 'laravelpizza-com-home.png'),
      fullPage: true,
    });
    await pageProd.close();
    console.log('Salvato: docs/screenshots/grafica-confronto/laravelpizza-com-home.png');
  } catch (e) {
    console.warn('Produzione:', e.message);
  }

  try {
    // Screenshot nostra home (richiede app avviata)
    const pageLocal = await context.newPage();
    await pageLocal.goto(LOCAL_URL, { waitUntil: 'networkidle', timeout: 15000 });
    await pageLocal.screenshot({
      path: path.join(outDir, 'nostra-home.png'),
      fullPage: true,
    });
    await pageLocal.close();
    console.log('Salvato: docs/screenshots/grafica-confronto/nostra-home.png');
  } catch (e) {
    console.warn('Locale (avvia l\'app prima):', e.message);
  }

  await browser.close();
}

main();

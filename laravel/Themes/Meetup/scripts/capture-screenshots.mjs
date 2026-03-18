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
const PROD_EVENTS_URL = 'https://laravelpizza.com/events';

const LOCAL_URL = process.env.LOCAL_URL || 'http://127.0.0.1:8002/it';
const LOCAL_EVENTS_URL = process.env.LOCAL_EVENTS_URL || `${LOCAL_URL.replace(/\/$/, '')}/events`;

async function gotoStable(page, url, timeoutMs) {
  await page.goto(url, { waitUntil: 'domcontentloaded', timeout: timeoutMs });
  await page.waitForTimeout(1200);
}

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
    await pageProd.goto(PROD_URL, { waitUntil: 'networkidle', timeout: 20000 });
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
    await gotoStable(pageLocal, LOCAL_URL, 20000);
    await pageLocal.screenshot({
      path: path.join(outDir, 'nostra-home.png'),
      fullPage: true,
    });
    await pageLocal.close();
    console.log('Salvato: docs/screenshots/grafica-confronto/nostra-home.png');
  } catch (e) {
    console.warn('Locale (avvia l\'app prima):', e.message);
  }

  try {
    // Screenshot produzione eventi
    const pageProdEvents = await context.newPage();
    await pageProdEvents.goto(PROD_EVENTS_URL, { waitUntil: 'networkidle', timeout: 20000 });
    await pageProdEvents.screenshot({
      path: path.join(outDir, 'laravelpizza-com-events.png'),
      fullPage: true,
    });
    await pageProdEvents.close();
    console.log('Salvato: docs/screenshots/grafica-confronto/laravelpizza-com-events.png');
  } catch (e) {
    console.warn('Produzione events:', e.message);
  }

  try {
    // Screenshot nostri eventi (richiede app avviata)
    const pageLocalEvents = await context.newPage();
    await gotoStable(pageLocalEvents, LOCAL_EVENTS_URL, 20000);
    await pageLocalEvents.screenshot({
      path: path.join(outDir, 'nostri-events.png'),
      fullPage: true,
    });
    await pageLocalEvents.close();
    console.log('Salvato: docs/screenshots/grafica-confronto/nostri-events.png');
  } catch (e) {
    console.warn('Locale events (avvia l\'app prima):', e.message);
  }

  await browser.close();
}

main();

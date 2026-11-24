#!/usr/bin/env node
/**
 * Cattura screenshot della sola sezione footer di laravelpizza.com e della nostra home,
 * per confronto logo footer. Salva in docs/screenshots/footer-logo-confronto/
 *
 * Uso: dalla root del tema (Themes/Meetup):
 *   node scripts/capture-footer-screenshots.mjs
 *   LOCAL_URL=http://127.0.0.1:8000/it node scripts/capture-footer-screenshots.mjs
 *
 * Prerequisiti: npm install, npx playwright install chromium. App locale avviata per nostra home.
 */

import { chromium } from 'playwright';
import { fileURLToPath } from 'url';
import path from 'path';
import fs from 'fs';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const themeRoot = path.resolve(__dirname, '..');
const outDir = path.join(themeRoot, 'docs', 'screenshots', 'footer-logo-confronto');

const PROD_URL = 'https://laravelpizza.com/';
const LOCAL_URL = process.env.LOCAL_URL || 'http://127.0.0.1:8000/it';

async function main() {
  if (!fs.existsSync(outDir)) {
    fs.mkdirSync(outDir, { recursive: true });
  }

  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext({
    viewport: { width: 1280, height: 720 },
    userAgent: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
  });

  async function captureFooter(page, url, outName) {
    await page.goto(url, { waitUntil: 'networkidle', timeout: 20000 });
    const footer = page.locator('footer').first();
    await footer.waitFor({ state: 'visible', timeout: 5000 }).catch(() => {});
    await footer.screenshot({ path: path.join(outDir, outName) });
    console.log('Salvato:', path.join('docs/screenshots/footer-logo-confronto', outName));
  }

  try {
    const pageProd = await context.newPage();
    await captureFooter(pageProd, PROD_URL, 'footer-laravelpizza-com.png');
    await pageProd.close();
  } catch (e) {
    console.warn('Produzione:', e.message);
  }

  try {
    const pageLocal = await context.newPage();
    await captureFooter(pageLocal, LOCAL_URL, 'footer-locale-it.png');
    await pageLocal.close();
  } catch (e) {
    console.warn('Locale (avvia l\'app prima):', e.message);
  }

  await browser.close();
}

main();

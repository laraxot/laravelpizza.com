#!/usr/bin/env node
/**
 * Screenshot reale di una pagina (FO pubblica o pannello Filament) via Playwright + Chrome di sistema.
 *
 * Uso (dalla radice del repo):
 *   node tools/visual/shot.mjs --url /it --out /tmp/home.png
 *   node tools/visual/shot.mjs --url /admin --auth --out docs/.../admin-dashboard.png
 *   node tools/visual/shot.mjs --url /it/events --viewport 375x812 --fullpage --out mobile.png
 *
 * Opzioni:
 *   --base URL        default http://127.0.0.1:8000
 *   --url PATH        percorso relativo alla base (o URL assoluto)
 *   --out FILE        file PNG di destinazione (la cartella viene creata)
 *   --auth            login Filament prima di aprire la pagina (marco.sottana@gmail.com / marco, override con env SHOT_EMAIL/SHOT_PASSWORD)
 *   --viewport WxH    default 1440x900
 *   --fullpage        screenshot di tutta la pagina
 *   --wait MS         attesa extra dopo il caricamento (default 1200)
 *   --state FILE      riusa un storageState JSON
 *   --save-state FILE salva lo storageState dopo il login
 */
import { createRequire } from 'node:module';
import { existsSync, mkdirSync } from 'node:fs';
import { dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';

const ROOT = resolve(dirname(fileURLToPath(import.meta.url)), '../..');

function parseArgs(argv) {
  const a = { base: 'http://127.0.0.1:8000', url: '/', out: '', auth: false, viewport: '1440x900', fullpage: false, wait: 1200, state: '', saveState: '' };
  for (let i = 0; i < argv.length; i += 1) {
    const k = argv[i];
    const v = () => argv[++i];
    if (k === '--base') a.base = v().replace(/\/$/, '');
    else if (k === '--url') a.url = v();
    else if (k === '--out') a.out = v();
    else if (k === '--auth') a.auth = true;
    else if (k === '--viewport') a.viewport = v();
    else if (k === '--fullpage') a.fullpage = true;
    else if (k === '--wait') a.wait = Number(v());
    else if (k === '--state') a.state = v();
    else if (k === '--save-state') a.saveState = v();
    else { console.error(`argomento sconosciuto: ${k}`); process.exit(2); }
  }
  if (!a.out) { console.error('--out obbligatorio'); process.exit(2); }
  return a;
}

function loadPlaywright() {
  const candidates = [
    resolve(ROOT, 'laravel/Themes/Meetup/package.json'),
    '/mnt/nas07/var/www/_bases/base_restaurant_fila5/laravel/package.json',
    '/mnt/nas07/var/www/_bases/base_restaurant_fila5/package.json',
    '/mnt/nas07/var/www/_bases/base_fixcity_fila5/package.json',
    '/mnt/nas07/var/www/_bases/base_trade_fila5/laravel/package.json',
  ];
  for (const pkg of candidates) {
    try {
      const req = createRequire(pkg);
      return req('playwright');
    } catch { /* prova il candidato successivo */ }
  }
  console.error('playwright non trovato: installalo nel tema (npm i) o in un base vicino');
  process.exit(2);
}

async function login(page, base) {
  const email = process.env.SHOT_EMAIL || 'marco.sottana@gmail.com';
  const password = process.env.SHOT_PASSWORD || 'marco';
  await page.goto(`${base}/admin`, { waitUntil: 'domcontentloaded', timeout: 30000 });
  await page.waitForLoadState('networkidle', { timeout: 15000 }).catch(() => {});
  await page.waitForTimeout(800);
  if (!/login|auth/i.test(page.url())) return;
  // Banner consenso cookie (GDPR) se presente: accetta e chiudi.
  const accept = page.getByRole('button', { name: /got it|accetta|accept/i }).first();
  if (await accept.isVisible().catch(() => false)) {
    await accept.click().catch(() => {});
    await page.waitForTimeout(400);
  }
  const emailInput = page.locator('#form\\.email, input[name="email"], input[type="email"]').first();
  const passInput = page.locator('input[type="password"]').first();
  await emailInput.waitFor({ state: 'visible', timeout: 15000 });
  await emailInput.fill(email);
  await passInput.fill(password);
  const submit = page.locator('form:has(input[type="password"]) button[type="submit"], form:has(input[type="password"]) button').filter({ hasText: /sign in|accedi|log in/i }).first();
  await Promise.all([
    page.waitForURL((u) => !/login|auth/i.test(u.pathname), { timeout: 30000 }).catch(() => {}),
    submit.click(),
  ]);
  await page.waitForTimeout(1500);
}

async function main() {
  const args = parseArgs(process.argv.slice(2));
  const { chromium } = loadPlaywright();
  const exe = ['/usr/bin/google-chrome-stable', '/usr/bin/chromium-browser', '/usr/bin/chromium'].find(existsSync);
  if (!exe) { console.error('Nessun Chrome di sistema trovato'); process.exit(2); }
  const [w, h] = args.viewport.split('x').map(Number);
  const url = /^https?:/.test(args.url) ? args.url : `${args.base}${args.url.startsWith('/') ? '' : '/'}${args.url}`;

  const browser = await chromium.launch({ executablePath: exe, args: ['--no-sandbox', '--disable-dev-shm-usage'] });
  const context = await browser.newContext({
    viewport: { width: w, height: h },
    storageState: args.state || undefined,
    locale: 'it-IT',
  });
  const page = await context.newPage();
  try {
    if (args.auth) await login(page, args.base);
    const resp = await page.goto(url, { waitUntil: 'domcontentloaded', timeout: 45000 });
    await page.waitForLoadState('networkidle', { timeout: 20000 }).catch(() => {});
    await page.waitForTimeout(args.wait);
    mkdirSync(dirname(resolve(args.out)), { recursive: true });
    await page.screenshot({ path: resolve(args.out), fullPage: args.fullpage });
    const status = resp ? resp.status() : 0;
    console.log(`OK ${status} ${page.url()} -> ${args.out}`);
    if (args.saveState) {
      mkdirSync(dirname(resolve(args.saveState)), { recursive: true });
      await context.storageState({ path: resolve(args.saveState) });
      console.log(`state salvato: ${args.saveState}`);
    }
  } finally {
    await browser.close();
  }
}

main().catch((e) => { console.error(e.message || e); process.exit(1); });

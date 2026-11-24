// Audit completo del front office: ospite e utente loggato, desktop e mobile (docs/front-office-audit.md).
// Per ogni pagina: HTTP, errori console/rete, richieste a siti terzi, chiavi di traduzione grezze, immagini rotte,
// numero di h1, <title>, meta description, overflow orizzontale su mobile, violazioni axe WCAG 2.1 AA.
// Prova anche il logout dal menu mobile. Screenshot in ./audit-shots (ignorata da git).
//
// Uso (dati demo del seeder): npm run audit:fo
//   BASE_URL      default http://laravelpizza.local
//   EVENT_SLUG    evento pubblicato da aprire     PAST_SLUG   un secondo evento
//   USER_EMAIL / USER_PASSWORD   partecipante demo
//   USER_ID / ORGANIZER_ID       id dei profili da aprire (vuoti = saltati)
//   MAP_HOST      IP a cui risolvere l'host di BASE_URL     CHROMIUM_PATH   Chromium già installato
const { chromium, devices } = require('playwright');
const fs = require('fs');
const axe = fs.readFileSync(require.resolve('axe-core/axe.min.js'), 'utf8');
const B = process.env.BASE_URL ?? 'http://laravelpizza.local';
const HOST = new URL(B).hostname;
const SLUG = process.env.EVENT_SLUG ?? 'laravel-13-e-filament-5-cosa-cambia-davvero';
const SLUG2 = process.env.PAST_SLUG ?? 'pizza-pest-testare-senza-paura';
const USER_ID = process.env.USER_ID ?? '';
const ORGANIZER_ID = process.env.ORGANIZER_ID ?? '';
const SHOTS = 'audit-shots';
const guestPaths = ['/it', '/en', '/de', '/fr', '/es', '/ru', '/it/events', '/en/events', '/it/events?city=Roma', '/it/events/past', '/en/events/past',
  `/it/events/${SLUG}`, `/en/events/${SLUG}`, `/it/events/${SLUG2}`, '/it/about', '/en/about', '/it/contact', '/en/contact',
  '/it/privacy', '/en/privacy', '/it/terms', '/it/cookie-policy', '/it/auth/login', '/en/auth/login', '/it/auth/register', '/it/auth/password/reset',
  '/it/events/my', '/it/pagina-che-non-esiste', '/it/events/evento-inesistente', '/en/xyz', '/it/login',
  ...(ORGANIZER_ID ? [`/it/profile/${ORGANIZER_ID}`] : [])];
const userPaths = ['/it', '/it/events', `/it/events/${SLUG}`, '/it/events/my', '/en/events/my', '/it/auth/login', '/it/auth/register', '/it/contact',
  ...(USER_ID ? [`/it/profile/${USER_ID}`] : []), ...(ORGANIZER_ID ? [`/it/profile/${ORGANIZER_ID}`] : []), '/it/auth/password/confirm', '/it/auth/verify', '/it/profile/edit', '/en/profile/edit', '/it/events/past'];
fs.mkdirSync(SHOTS, { recursive: true });
const report = [];
async function audit(ctx, label, path, mobile) {
  const page = await ctx.newPage();
  const errs = [];
  page.on('console', m => { if (m.type() === 'error') errs.push('console: ' + m.text().slice(0, 150)); });
  page.on('pageerror', e => errs.push('js: ' + e.message.slice(0, 150)));
  page.on('request', r => { const h = new URL(r.url()).hostname; if (![HOST, '127.0.0.1', 'localhost'].includes(h) && !r.url().startsWith('data:')) errs.push('3rd-party: ' + h); });
  page.on('response', r => { if (r.status() >= 400 && r.url() !== B + path) errs.push(`${r.status()} ${r.url().replace(B, '')}`); });
  let status = 0;
  try { const r = await page.goto(B + path, { waitUntil: 'networkidle', timeout: 30000 }); status = r.status(); } catch (e) { errs.push('goto: ' + e.message.slice(0, 100)); }
  await page.waitForTimeout(400);
  const info = await page.evaluate(() => {
    const txt = document.body.innerText;
    const raw = [...new Set((txt.match(/\b[a-z_]+::[a-z0-9_.-]+|\b(?:fields|actions|navigation|messages)\.[a-z_]+\.[a-z_.]+|\{\{[^}]*\}\}/g) || []))].slice(0, 8);
    const broken = [...document.images].filter(i => i.complete && i.naturalWidth === 0 && i.getAttribute('src')).map(i => i.getAttribute('src')).slice(0, 5);
    return { raw, broken, h1: document.querySelectorAll('h1').length, title: document.title, desc: document.querySelector('meta[name=description]')?.content || '',
      overflow: document.documentElement.scrollWidth - window.innerWidth, lang: document.documentElement.lang };
  });
  let axeV = [];
  if (!mobile) {
    await page.addScriptTag({ content: axe });
    const r = await page.evaluate(() => window.axe.run(document, { runOnly: { type: 'tag', values: ['wcag2a', 'wcag2aa', 'wcag21a', 'wcag21aa'] } }));
    axeV = r.violations.map(v => `${v.id}(${v.nodes.length}): ${v.nodes[0].target.join(' ')}`);
  }
  const name = `${label}${mobile ? '-m' : ''}${path.replace(/\W+/g, '_')}`;
  await page.screenshot({ path: `${SHOTS}/${name}.png`, fullPage: !mobile });
  report.push({ label: label + (mobile ? '/mobile' : ''), path, status, ...info, errs: [...new Set(errs)], axe: axeV });
  await page.close();
}
(async () => {
  const b = await chromium.launch({
    ...(process.env.CHROMIUM_PATH ? { executablePath: process.env.CHROMIUM_PATH } : {}),
    args: process.env.MAP_HOST ? [`--host-resolver-rules=MAP ${HOST} ${process.env.MAP_HOST}`] : [],
  });
  const guest = await b.newContext({ viewport: { width: 1280, height: 900 }, locale: 'it-IT' });
  for (const p of guestPaths) await audit(guest, 'guest', p, false);
  const gm = await b.newContext({ ...devices['iPhone 13'], locale: 'it-IT' });
  for (const p of ['/it', '/it/events', `/it/events/${SLUG}`, '/it/contact', '/it/auth/login', '/it/auth/register']) await audit(gm, 'guest', p, true);
  const user = await b.newContext({ viewport: { width: 1280, height: 900 }, locale: 'it-IT' });
  const lp = await user.newPage();
  await lp.goto(B + '/it/auth/login', { waitUntil: 'networkidle' });
  await lp.locator('input[type=email]').fill(process.env.USER_EMAIL ?? 'paolo.ferri@laravelpizza.test');
  await lp.locator('input[type=password]').fill(process.env.USER_PASSWORD ?? 'Password!2026');
  await lp.locator('form button[type=submit]').first().click();
  await lp.waitForTimeout(2500);
  report.push({ label: 'user', path: 'login -> ' + lp.url().replace(B, ''), status: 0, errs: [], axe: [] });
  await lp.close();
  for (const p of userPaths) await audit(user, 'user', p, false);
  const um = await b.newContext({ ...devices['iPhone 13'], locale: 'it-IT', storageState: await user.storageState() });
  for (const p of ['/it/events/my', `/it/events/${SLUG}`]) await audit(um, 'user', p, true);
  // Menu mobile aperto e logout dal menu mobile
  const mp = await um.newPage();
  await mp.goto(B + '/it/events', { waitUntil: 'networkidle' });
  await mp.click('#mobile-menu-button');
  await mp.waitForTimeout(400);
  await mp.screenshot({ path: `${SHOTS}/user-m_menu_open.png` });
  await mp.locator('#mobile-menu form button[type=submit]').click();
  await mp.waitForLoadState('networkidle');
  const loggedOut = await mp.locator('#mobile-menu a[href$="/auth/login"]').count();
  report.push({ label: 'user/mobile', path: 'logout -> ' + mp.url().replace(B, '') + (loggedOut ? ' (guest)' : ' (STILL LOGGED)'), status: 0, errs: [], axe: [] });
  await mp.close();
  await b.close();
  fs.writeFileSync(`${SHOTS}/report.json`, JSON.stringify(report, null, 1));
  // Pagine che DEVONO rispondere 404 (pagina di errore del tema): lo stato e il 404 in console sono attesi.
  const expected404 = ['/it/pagina-che-non-esiste', '/it/events/evento-inesistente', '/en/xyz'];
  let failures = 0;
  for (const r of report) {
    const issues = [];
    const want404 = expected404.includes(r.path);
    if (want404) r.errs = r.errs.filter(e => !e.includes('status of 404'));
    if (want404 ? r.status !== 404 : r.status >= 400) issues.push('HTTP ' + r.status);
    if (r.path.includes('STILL LOGGED')) issues.push('logout failed');
    if (r.raw?.length) issues.push('RAW ' + r.raw.join(' | '));
    if (r.broken?.length) issues.push('IMG ' + r.broken.join(' '));
    if (r.h1 !== undefined && r.h1 !== 1) issues.push('h1=' + r.h1);
    if (r.overflow > 0) issues.push('overflow ' + r.overflow);
    if (r.desc === '') issues.push('no meta description');
    if (r.errs.length) issues.push('ERR ' + r.errs.join(' ; '));
    if (r.axe.length) issues.push('AXE ' + r.axe.join(' ; '));
    if (issues.length) failures++;
    console.log(`${r.label} ${r.path} [${r.status}] ${r.title ? '«' + r.title + '»' : ''} ${issues.length ? '\n    ' + issues.join('\n    ') : 'OK'}`);
  }
  console.log(failures ? `\n${failures} pagine con problemi` : '\nNessun problema trovato');
  process.exitCode = failures ? 1 : 0;
})();

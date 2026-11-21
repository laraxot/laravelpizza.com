// Audit del back office: apre come super-admin ogni pagina GET dei pannelli Filament (senza parametri) e segnala
// HTTP >= 400, pagine di eccezione, errori JavaScript/console (anche gli errori "Livewire Entangle"), risposte 5xx
// delle chiamate Livewire e chiavi di traduzione grezze (modulo::chiave) nel testo.
// Docs: laravel/Modules/Xot/docs/filament/xotbasepage-form-and-generic-view.md, docs/deploy/runbook.md §9.
//
// Uso: npm run audit:bo   (RECORDS=0 per saltare le pagine dei singoli record)
//   BASE_URL        default http://laravelpizza.local
//   ADMIN_EMAIL / ADMIN_PASSWORD   utente con ruolo super-admin
//   PHP_BIN         default php (serve per `artisan route:list`)
//   MAP_HOST / CHROMIUM_PATH       come audit:fo
//
// ATTENZIONE in locale: con lang.save_missing_translations attivo, AutoLabelAction scrive nei file lang ogni chiave
// che le pagine chiedono. Dopo l'audit: git checkout -- ':(glob)laravel/Modules/*/lang/**' && git clean -f -- ':(glob)laravel/Modules/*/lang/**'
const { chromium } = require('playwright');
const { execFileSync } = require('child_process');
const path = require('path');

const B = process.env.BASE_URL ?? 'http://laravelpizza.local';
const HOST = new URL(B).hostname;
const laravel = path.resolve(__dirname, '../../..');

const routes = JSON.parse(execFileSync(process.env.PHP_BIN ?? 'php', ['artisan', 'route:list', '--json', '--method=GET'], { cwd: laravel, maxBuffer: 64 * 1024 * 1024 }).toString())
  .filter(r => typeof r.name === 'string' && r.name.startsWith('filament.') && !r.name.includes('.auth.') && !r.uri.includes('{'))
  .map(r => r.uri)
  .filter((u, i, all) => all.indexOf(u) === i)
  .sort();

// Pagine dove "modulo::nome" è contenuto, non una traduzione mancante: elenco dei file di traduzione, ruoli ("meetup::admin").
const RAW_OK = ['lang/admin/translation-files', 'user/admin/roles'];

(async () => {
  const b = await chromium.launch({
    ...(process.env.CHROMIUM_PATH ? { executablePath: process.env.CHROMIUM_PATH } : {}),
    args: process.env.MAP_HOST ? [`--host-resolver-rules=MAP ${HOST} ${process.env.MAP_HOST}`] : [],
  });
  const p = await (await b.newContext({ viewport: { width: 1366, height: 900 }, locale: 'it-IT' })).newPage();
  await p.goto(B + '/it/auth/login', { waitUntil: 'networkidle' });
  await p.fill('input[type=email]', process.env.ADMIN_EMAIL ?? 'superadmin@laravelpizza.test');
  await p.fill('input[type=password]', process.env.ADMIN_PASSWORD ?? 'Password!2026');
  await p.locator('form button[type=submit]').first().click();
  await p.waitForTimeout(3000);

  // Oltre alle pagine senza parametri, da ogni elenco si apre il primo record in "vedi" e in "modifica":
  // le pagine con {record} sono quelle che si rompono senza che una lista lo mostri (es. TeamModelNotConfigured).
  const pages = [...routes];
  if (process.env.RECORDS !== '0') {
    for (const r of routes) {
      try {
        await p.goto(B + '/' + r, { waitUntil: 'networkidle', timeout: 30000 });
        const hrefs = await p.$$eval('table a[href]', (as, base) => as.map(a => a.href.split('?')[0]).filter(h => h.startsWith(base + '/')), B + '/' + r);
        const edit = hrefs.find(h => /\/[^/]+\/edit$/.test(h));
        const view = hrefs.find(h => /^[^/]+$/.test(h.slice((B + '/' + r + '/').length)));
        for (const h of [view, edit]) if (h) pages.push(h.slice(B.length + 1));
      } catch (e) { /* l'elenco stesso viene controllato sotto */ }
    }
  }

  let bad = 0;
  for (const r of [...new Set(pages)]) {
    const errs = [];
    const onErr = e => errs.push('js: ' + e.message.slice(0, 120));
    const onCon = m => { if (m.type() === 'error') errs.push('console: ' + m.text().slice(0, 120)); };
    const onResp = x => { if (x.status() >= 500) errs.push(x.status() + ' ' + x.url().replace(B, '')); };
    p.on('pageerror', onErr); p.on('console', onCon); p.on('response', onResp);
    let status = 0;
    let raw = [];
    try {
      const resp = await p.goto(B + '/' + r, { waitUntil: 'networkidle', timeout: 30000 });
      status = resp ? resp.status() : 0;
      await p.waitForTimeout(300);
      const info = await p.evaluate(() => ({
        // i nomi di vista ("pub_theme::components.blocks...") nei dati delle sezioni CMS sono contenuto, non traduzioni
        raw: (document.body.innerText.match(/\b[a-z_]+::[a-z_.]+\b/g) || []).filter(k => !/::(components|layouts|pages)\./.test(k)).slice(0, 4),
        exc: !!document.querySelector('.exception-message, #sf-resetcontent'),
      }));
      raw = RAW_OK.includes(r) ? [] : info.raw;
      if (info.exc) errs.push('pagina di eccezione');
    } catch (e) { errs.push('goto: ' + e.message.slice(0, 100)); }
    p.off('pageerror', onErr); p.off('console', onCon); p.off('response', onResp);
    if (status >= 400 || errs.length || raw.length) {
      bad++;
      console.log(`[${status}] /${r}  ${raw.length ? 'RAW ' + raw.join(', ') + '  ' : ''}${errs.slice(0, 3).join(' | ')}`);
    }
  }
  console.log(`\n${new Set(pages).size} pagine (${routes.length} elenchi e pagine, il resto record), ${bad} con problemi`);
  await b.close();
  process.exitCode = bad ? 1 : 0;
})();

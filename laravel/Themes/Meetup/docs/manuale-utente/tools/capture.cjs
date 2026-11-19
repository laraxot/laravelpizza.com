// Cattura gli screenshot del manuale percorrendo i flussi veri del sito, sui dati demo (tools/seed-demo.php).
//
// Uso, da laravel/Themes/Meetup (dove c'è playwright):
//   sh docs/manuale-utente/tools/reset-demo.sh            (da laravel/, con PHP_BIN se serve)
//   php docs/manuale-utente/tools/render-mail.php $PWD /tmp/mail.html it   (da laravel/: email per p08)
//   node docs/manuale-utente/tools/capture.cjs docs/manuale-utente/img /tmp/mail.html
// Edizione inglese (solo sito pubblico: il pannello di amministrazione è in italiano, i capitoli 3 e 4 usano le
// immagini italiane): reset-demo.sh, render-mail.php ... /tmp/mail-en.html en, poi
//   MANUAL_LANG=en node docs/manuale-utente/tools/capture.cjs docs/manuale-utente/en/img /tmp/mail-en.html
// Variabili: BASE_URL (default http://laravelpizza.local), MAP_HOST (es. 127.0.0.1), CHROMIUM_PATH, PHP_BIN (per i
// dati dell'assistente, tools/assistant-events.php), MANUAL_LANG (it, default, o en).
// Ogni riquadro giallo numerato corrisponde a un passo del testo. "! mark non trovato" = interfaccia cambiata.
// L'assistente (p20-p23) risponde con flussi AG-UI composti qui dai dati veri: nessun modello AI viene chiamato.
const { chromium } = require('playwright');
const fs = require('fs');
const path = require('path');
const { execFileSync } = require('child_process');

const OUT = process.argv[2];
const MAILHTML = process.argv[3];
const B = process.env.BASE_URL ?? 'http://laravelpizza.local';
const HOST = new URL(B).hostname;
const LANG = process.env.MANUAL_LANG ?? 'it';
const L = (url) => `/${LANG}${url === '/' ? '' : url}`;
const EV1 = L('/events/laravel-13-e-filament-5-cosa-cambia-davvero');
const EV2 = L('/events/livewire-4-in-produzione-lezioni-imparate');
const EV3 = L('/events/pizza-pest-testare-senza-paura');
const LARAVEL = path.resolve(__dirname, '../../../../..');

// Testi dell'interfaccia e dati di esempio nelle due lingue.
const T = {
  it: {
    cookie: 'Ho capito', events: 'Eventi', langBtn: /cambia lingua/, login: 'Accedi', register: 'Registrati',
    past: 'Eventi passati', search: 'Cerca', reset: 'Togli i filtri', send: 'Invia il messaggio', date: 'Data',
    calendar: /Aggiungi al calendario/, otherLang: 'English', otherLangUrl: '/en/events',
    first: 'Nome', last: 'Cognome', privacy: "Ho letto e accetto l'Informativa Privacy",
    terms: 'Ho letto e accetto i Termini e Condizioni', create: /Crea il mio account/, signIn: /^Accedi/,
    join: /Iscriviti all'evento/, leave: /Annulla iscrizione/, myEvents: 'I miei eventi', profile: /^\s*Profilo\s*$/,
    editProfile: 'Modifica il profilo', logout: 'Esci', save: 'Salva i dati', photo: 'Carica la foto',
    password: 'Cambia la password', deleteOpen: "Voglio eliminare l'account", deleteOk: 'Elimina definitivamente',
    resetLink: 'Inviami il link', full: /Posti esauriti/, locale: 'it-IT',
    contact: 'Ciao! Vorrei proporre un talk su Pest per il prossimo meetup di Milano.',
    assistant: "Chiedi all'assistente", confirm: 'Conferma', ask: 'Quali sono i prossimi meetup?',
    askJoin: (t) => `Iscrivimi a ${t}`,
    answer: (n) => `Ho trovato **${n} meetup** nei prossimi mesi: li vedi nelle schede qui sopra.\nVuoi che ti iscriva a uno di questi?`,
    done: (t) => `Fatto! Sei iscritto a **${t}**: ti ho mandato l'email con il file per il calendario.`,
    // pannello di amministrazione
    pEvents: /^Eventi/, pVenues: /^Sedi/, newEvent: 'Nuovo evento', title: /Titolo/, description: /Descrizione/,
    city: /Città o luogo/, seats: /Posti disponibili/, publication: /Pubblicazione|Stato dell'evento/, published: 'Pubblicato',
    del: /Elimina/, people: 'Relatori e sponsor', csv: /Scarica CSV/, newVenue: 'Nuova sede',
    users: /^Utenti/, orgTab: 'Organizzazione', attach: 'Collega',
  },
  en: {
    cookie: 'Got it', events: 'Events', langBtn: /change language/, login: 'Log in', register: 'Sign up',
    past: 'Past events', search: 'Search', reset: 'Clear filters', send: 'Send message', date: 'Date',
    calendar: /Add to calendar/, otherLang: 'Italiano', otherLangUrl: '/it/events',
    first: 'First Name', last: 'Last Name', privacy: 'I have read and understood the Privacy Policy',
    terms: 'I have read and accept the Terms and Conditions', create: /Join the Community/, signIn: /^Sign in/,
    join: /Register for this event/, leave: /Cancel registration/, myEvents: 'My events', profile: /^\s*Profile\s*$/,
    editProfile: 'Edit profile', logout: 'Log out', save: 'Save details', photo: 'Upload photo',
    password: 'Change password', deleteOpen: 'I want to delete my account', deleteOk: 'Delete permanently',
    resetLink: 'Send me the link', full: /Sold out/, locale: 'en-GB',
    contact: "Hi! I'd like to propose a talk on Pest for the next meetup in Milan.",
    assistant: 'Ask the assistant', confirm: 'Confirm', ask: 'What are the next meetups?',
    askJoin: (t) => `Register me for ${t}`,
    answer: (n) => `I found **${n} upcoming meetups**: they are in the cards above.\nShall I register you for one of them?`,
    done: (t) => `Done! You are registered for **${t}**: I sent you the email with the calendar file.`,
    pEvents: /^Events/, pVenues: /^Venues/, newEvent: 'New event', title: /Title/, description: /Description/,
    city: /City or place/, seats: /Available seats/, publication: /Publication/, published: 'Published',
    del: /Delete/, people: 'Speakers and sponsors', csv: /CSV/, newVenue: 'New Venue',
    users: /^Users/, orgTab: 'Organization', attach: 'Attach',
  },
}[LANG];
const PWD = 'Password!2026';
const log = (...a) => console.log(...a);
let missing = 0;

async function clearMarks(page) {
  await page.evaluate(() => document.querySelectorAll('.lp-mark').forEach(e => e.remove()));
}
// Riquadro giallo numerato attorno a un elemento (coordinate di pagina).
async function mark(page, locator, n, pad = 6) {
  const el = locator.first();
  await el.scrollIntoViewIfNeeded({ timeout: 5000 }).catch(() => {});
  const box = await el.boundingBox({ timeout: 5000 }).catch(() => null);
  if (!box) { log('  ! mark non trovato', n, String(locator)); missing++; return; }
  await page.evaluate(({ box, n, pad }) => {
    const sx = window.scrollX, sy = window.scrollY;
    const d = document.createElement('div');
    d.className = 'lp-mark';
    Object.assign(d.style, { position: 'absolute', left: (box.x + sx - pad) + 'px', top: (box.y + sy - pad) + 'px', width: (box.width + 2 * pad) + 'px', height: (box.height + 2 * pad) + 'px', border: '4px solid #facc15', borderRadius: '10px', boxShadow: '0 0 0 4px rgba(0,0,0,.35)', zIndex: 99998, pointerEvents: 'none' });
    const b = document.createElement('div');
    b.className = 'lp-mark';
    b.textContent = n;
    Object.assign(b.style, { position: 'absolute', left: (box.x + sx - pad - 16) + 'px', top: (box.y + sy - pad - 16) + 'px', width: '32px', height: '32px', lineHeight: '32px', borderRadius: '50%', background: '#facc15', color: '#111', font: '700 18px/32px Inter,Arial,sans-serif', textAlign: 'center', zIndex: 99999, boxShadow: '0 2px 6px rgba(0,0,0,.5)', pointerEvents: 'none' });
    document.body.appendChild(d); document.body.appendChild(b);
  }, { box, n, pad });
}
async function shot(page, name, opts = {}) {
  await page.mouse.move(1270, 790).catch(() => {});
  await page.waitForTimeout(400);
  await page.screenshot({ path: `${OUT}/${name}.jpg`, type: 'jpeg', quality: 82, ...opts });
  log('  ✓', name);
}
async function settle(page) {
  await page.waitForLoadState('networkidle').catch(() => {});
  await page.waitForTimeout(600);
}
async function go(page, url) {
  await page.goto(B + url, { waitUntil: 'networkidle', timeout: 120000 });
  await page.waitForTimeout(500);
  // chiude il banner cookie (una volta per contesto) per non coprire la pagina
  const ok = page.getByRole('button', { name: T.cookie });
  if (await ok.count() && await ok.first().isVisible()) { await ok.first().click(); await page.waitForTimeout(400); }
}
async function siteLogin(page, email) {
  await go(page, L('/auth/login'));
  await page.locator('input[type=email]').fill(email);
  await page.locator('input[type=password]').fill(PWD);
  await page.getByRole('button', { name: T.signIn }).last().click();
  await settle(page); await page.waitForTimeout(800);
}
// Centra un elemento nella schermata (dopo un ricaricamento scrollBy da solo non basta).
const center = (locator) => locator.first().evaluate(e => e.scrollIntoView({ block: 'center' })).catch(() => {});
const top = (page, y = 0) => page.evaluate(y => window.scrollTo(0, y), y);

// ---------------- ASSISTENTE (p20-p23) ----------------
// Flusso AG-UI: un frame "data: {json}" per evento, come lo manda StreamAgentRunAction.
const sse = (events) => events.map((e) => `data: ${JSON.stringify(e)}\n\n`).join('');
const text = (id, body) => [
  { type: 'TEXT_MESSAGE_START', messageId: id, role: 'assistant' },
  ...body.match(/[\s\S]{1,12}/g).map((delta) => ({ type: 'TEXT_MESSAGE_CONTENT', messageId: id, delta })),
  { type: 'TEXT_MESSAGE_END', messageId: id },
];
const tool = (id, name, args, content) => [
  { type: 'TOOL_CALL_START', toolCallId: id, toolCallName: name },
  { type: 'TOOL_CALL_ARGS', toolCallId: id, delta: JSON.stringify(args) },
  { type: 'TOOL_CALL_END', toolCallId: id },
  { type: 'TOOL_CALL_RESULT', messageId: `result_${id}`, role: 'tool', toolCallId: id, content },
];

async function assistantShots(page) {
  // Dati veri dal database demo, nella lingua del manuale (eventi futuri e testo della conferma).
  const data = JSON.parse(execFileSync(process.env.PHP_BIN ?? 'php', [path.join(__dirname, 'assistant-events.php'), LARAVEL, LANG], { encoding: 'utf8' }));
  if (!data.join) { log('  ! assistente: nessun evento libero per la conferma'); missing++; return; }
  let turn = 0;
  await page.route('**/meetup/assistant', async (route) => {
    const req = JSON.parse(route.request().postData());
    const run = { threadId: req.threadId, runId: req.runId };
    turn++;
    let events;
    if (turn === 1) {
      events = [...tool('call_s', 'search_events', {}, JSON.stringify({ events: data.events })), ...text('m1', T.answer(data.events.length))];
    } else if (turn === 2) {
      const interrupt = { id: 'call_j', reason: 'confirmation', message: data.join.approval, responseSchema: { type: 'object', properties: { approved: { type: 'boolean' } }, required: ['approved'] } };
      events = [{ type: 'RUN_STARTED', ...run }, { type: 'RUN_FINISHED', ...run, outcome: { type: 'interrupt', interrupts: [interrupt] } }];
      return route.fulfill({ status: 200, headers: { 'Content-Type': 'text/event-stream; charset=utf-8' }, body: sse(events) });
    } else {
      events = [...tool('call_j', 'join_event', { slug: data.join.slug }, 'OK'), ...text('m3', T.done(data.join.title))];
    }
    await route.fulfill({ status: 200, headers: { 'Content-Type': 'text/event-stream; charset=utf-8' }, body: sse([{ type: 'RUN_STARTED', ...run }, ...events, { type: 'RUN_FINISHED', ...run }]) });
  });

  await go(page, L('/events'));
  const toggle = page.getByRole('button', { name: T.assistant });
  await mark(page, toggle, 1);
  await shot(page, 'p20-assistente');
  await clearMarks(page);

  await toggle.click(); await page.waitForTimeout(500);
  await page.fill('#meetup-assistant-input', T.ask); await page.keyboard.press('Enter');
  await page.waitForTimeout(2500);
  const panel = page.locator('[data-assistant-panel]');
  await mark(page, panel.locator('[data-assistant-messages] ul').first(), 1, 2);
  await mark(page, page.locator('#meetup-assistant-input'), 2, 2);
  await shot(page, 'p21-assistente-risposta');
  await clearMarks(page);

  await page.fill('#meetup-assistant-input', T.askJoin(data.join.title)); await page.keyboard.press('Enter');
  await page.waitForTimeout(2500);
  await mark(page, panel.getByRole('group').getByRole('button', { name: T.confirm, exact: true }), 1, 2);
  await shot(page, 'p22-assistente-conferma');
  await clearMarks(page);

  await panel.getByRole('button', { name: T.confirm, exact: true }).click(); await page.waitForTimeout(2500);
  await shot(page, 'p23-assistente-fatto');
  await page.unroute('**/meetup/assistant');
  if (turn !== 3) { log('  ! assistente: richieste', turn); missing++; }
}

(async () => {
  const browser = await chromium.launch({
    ...(process.env.CHROMIUM_PATH ? { executablePath: process.env.CHROMIUM_PATH } : {}),
    args: [`--host-resolver-rules=MAP ${HOST} ${process.env.MAP_HOST ?? '127.0.0.1'}`],
  });
  const AVATAR = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><rect width="64" height="64" fill="#cbd5e1"/><circle cx="32" cy="24" r="12" fill="#94a3b8"/><path d="M10 60c4-14 14-20 22-20s18 6 22 20z" fill="#94a3b8"/></svg>';
  const newCtx = async () => {
    const c = await browser.newContext({ viewport: { width: 1280, height: 800 }, deviceScaleFactor: 2, locale: T.locale });
    await c.route(/gravatar\.com|ui-avatars\.com/, r => r.fulfill({ status: 200, contentType: 'image/svg+xml', body: AVATAR }));
    return c;
  };

  // ---------------- VISITATORE ----------------
  log('Visitatore');
  let ctx = await newCtx(); let page = await ctx.newPage();
  await go(page, L('/'));
  await mark(page, page.getByRole('link', { name: T.events, exact: true }).first(), 1);
  await mark(page, page.getByRole('button', { name: T.langBtn }).first(), 2);
  await mark(page, page.getByRole('link', { name: T.login, exact: true }).first(), 3);
  await mark(page, page.getByRole('link', { name: T.register, exact: true }).first(), 4);
  await top(page);
  await shot(page, 'v01-home');
  await clearMarks(page);

  await go(page, L('/events'));
  await mark(page, page.locator('a[href*="/events/laravel-13"]').first(), 1, 4);
  await mark(page, page.locator('form[role=search]'), 2, 4);
  await mark(page, page.getByRole('link', { name: T.past }).first(), 3);
  await top(page);
  await shot(page, 'v02-eventi');
  await clearMarks(page);

  await page.locator('select[name=city]').selectOption('Roma');
  await mark(page, page.locator('select[name=city]'), 1);
  await mark(page, page.getByRole('button', { name: T.search }), 2);
  await top(page);
  await shot(page, 'v06-filtro-citta', { clip: { x: 0, y: 0, width: 1280, height: 520 } });
  await clearMarks(page);
  await page.getByRole('button', { name: T.search }).click();
  await settle(page);
  await mark(page, page.getByRole('link', { name: T.reset }).first(), 1);
  await top(page);
  await shot(page, 'v07-filtro-risultato');
  await clearMarks(page);

  await go(page, L('/events/past'));
  await top(page);
  await shot(page, 'v08-eventi-passati');

  await go(page, L('/contact'));
  await page.locator('#contact-name').fill('Giulia Rossi');
  await page.locator('#contact-email').fill('giulia@example.com');
  await page.locator('#contact-message').fill(T.contact);
  await mark(page, page.locator('#contact-name').locator('xpath=ancestor::div[contains(@class,"grid")][1]'), 1, 4);
  await mark(page, page.locator('#contact-message'), 2);
  await mark(page, page.locator('form input[type=checkbox]').first().locator('xpath=ancestor::label[1]'), 3);
  await mark(page, page.getByRole('button', { name: T.send }), 4);
  await page.locator('#contact-message').scrollIntoViewIfNeeded();
  await page.evaluate(() => window.scrollBy(0, 60));
  await shot(page, 'v09-contatti');
  await clearMarks(page);

  // dettaglio evento: da visitatore il riquadro d'iscrizione è il modulo email + password
  await go(page, EV1);
  await top(page, 260); await page.waitForTimeout(300);
  await mark(page, page.getByText(T.date, { exact: true }).first().locator('xpath=ancestor::div[contains(@class,"rounded-lg")][1]'), 1, 2);
  await mark(page, page.locator('form[wire\\:submit="signUp"]'), 2, 4);
  await mark(page, page.getByRole('link', { name: T.calendar }), 3);
  await top(page, 260);
  await shot(page, 'v03-dettaglio');
  await clearMarks(page);

  await go(page, L('/events'));
  const langBtn = page.getByRole('button', { name: T.langBtn }).first();
  if (await langBtn.count()) { await langBtn.click(); await page.waitForTimeout(500); }
  await mark(page, page.locator('a:visible, [role=menuitem]:visible, [role=option]:visible').filter({ hasText: new RegExp(`^\\s*${T.otherLang}\\s*$`, 'i') }).first(), 1);
  await top(page);
  await shot(page, 'v04-lingua', { clip: { x: 0, y: 0, width: 1280, height: 420 } });
  await clearMarks(page);
  await go(page, T.otherLangUrl);
  await shot(page, 'v05-english', { clip: { x: 0, y: 0, width: 1280, height: 560 } });
  await ctx.close();

  // ---------------- PARTECIPANTE ----------------
  log('Partecipante');
  // Iscrizione in un passo dalla pagina dell'evento (account creato insieme all'iscrizione)
  ctx = await newCtx(); page = await ctx.newPage();
  await go(page, EV2);
  const form = page.locator('form[wire\\:submit="signUp"]');
  await form.locator('#event-signup-email').fill('sara.nuova@laravelpizza.test');
  await form.locator('#event-signup-password').fill('PizzaMargherita!26');
  await form.locator('input[type=checkbox]').check();
  await mark(page, form.locator('#event-signup-email'), 1);
  await mark(page, form.locator('#event-signup-password'), 2);
  await mark(page, form.locator('input[type=checkbox]').locator('xpath=ancestor::label[1]'), 3);
  await mark(page, form.locator('button[type=submit]'), 4);
  await form.scrollIntoViewIfNeeded(); await page.evaluate(() => window.scrollBy(0, -120));
  await shot(page, 'p18-iscrizione-rapida');
  await clearMarks(page);
  await Promise.all([page.waitForNavigation({ waitUntil: 'networkidle' }).catch(() => {}), form.locator('button[type=submit]').click()]);
  await settle(page);
  await center(page.getByRole('status')); await page.waitForTimeout(300);
  await mark(page, page.getByRole('status').first(), 1, 4);
  await shot(page, 'p19-iscrizione-rapida-fatta');
  await ctx.close();

  // Registrazione classica
  ctx = await newCtx(); page = await ctx.newPage();
  await go(page, L('/auth/register'));
  const reg = { first: 'Luca', last: 'Bianchi', email: 'luca.bianchi@laravelpizza.test', pwd: 'PizzaMargherita!26' };
  await page.getByLabel(T.first, { exact: true }).fill(reg.first).catch(() => log('  ! nome'));
  await page.getByLabel(T.last).fill(reg.last).catch(() => log('  ! cognome'));
  await page.getByLabel(/email/i).first().fill(reg.email).catch(() => log('  ! email'));
  const pw = page.locator('input[type=password]');
  await pw.nth(0).fill(reg.pwd); await pw.nth(1).fill(reg.pwd);
  await top(page, 330); await page.waitForTimeout(300);
  await mark(page, page.locator('form input').first().locator('xpath=ancestor::div[contains(@class,"grid")][1]'), 1, 4);
  await shot(page, 'p01-registrazione-dati');
  await clearMarks(page);
  const boxes = page.locator('input[type=checkbox]');
  for (let i = 0; i < Math.min(2, await boxes.count()); i++) await boxes.nth(i).check({ force: true }).catch(() => log('  ! check', i));
  await mark(page, page.getByText(T.privacy).first(), 1, 8);
  await mark(page, page.getByText(T.terms).first(), 2, 8);
  await mark(page, page.getByRole('button', { name: T.create }), 3);
  await page.getByRole('button', { name: T.create }).scrollIntoViewIfNeeded();
  await page.evaluate(() => window.scrollBy(0, 120));
  await shot(page, 'p02-registrazione-consensi');
  await clearMarks(page);
  await page.getByRole('button', { name: T.create }).click();
  await page.waitForURL(u => !u.toString().includes('/auth/register'), { timeout: 20000 }).catch(() => log('  ! nessun redirect dopo la registrazione'));
  await settle(page); await page.waitForTimeout(1500);
  await top(page);
  await shot(page, 'p03-registrazione-fatta');
  await ctx.close();

  // Giulia: accesso, iscrizione, annullamento, menu, i miei eventi, profilo
  ctx = await newCtx(); page = await ctx.newPage();
  await go(page, L('/auth/login'));
  await page.locator('input[type=email]').fill('giulia@laravelpizza.test');
  await page.locator('input[type=password]').fill(PWD);
  await mark(page, page.locator('input[type=email]'), 1);
  await mark(page, page.locator('input[type=password]'), 2);
  await mark(page, page.getByRole('button', { name: T.signIn }).last(), 3);
  await top(page);
  await shot(page, 'p04-login');
  await clearMarks(page);
  await page.getByRole('button', { name: T.signIn }).last().click();
  await settle(page); await page.waitForTimeout(1000);
  await shot(page, 'p05-dopo-login', { clip: { x: 0, y: 0, width: 1280, height: 420 } });

  await go(page, EV1);
  await top(page, 260); await page.waitForTimeout(300);
  await mark(page, page.getByRole('button', { name: T.join }), 1);
  await top(page, 260);
  await shot(page, 'p06-iscriviti');
  await clearMarks(page);
  await page.getByRole('button', { name: T.join }).click();
  await page.waitForTimeout(2000);
  await mark(page, page.getByRole('status').first(), 1, 4);
  await mark(page, page.getByRole('button', { name: T.leave }), 2);
  await top(page, 260);
  await shot(page, 'p07-iscritto');
  await clearMarks(page);
  await page.getByRole('button', { name: T.leave }).click();
  await page.waitForTimeout(2000);
  await top(page, 260);
  await shot(page, 'p09-annullata');

  // Giulia occupa l'ultimo posto del workshop di Torino (per p11) e resta iscritta a Milano (per p12)
  await go(page, EV3);
  await page.getByRole('button', { name: T.join }).click().catch(() => log('  ! iscrizione torino'));
  await page.waitForTimeout(1500);
  await go(page, EV1);
  await page.getByRole('button', { name: T.join }).click().catch(() => log('  ! iscrizione milano'));
  await page.waitForTimeout(1500);

  await go(page, L('/'));
  await page.locator('#user-menu-button').first().click(); await page.waitForTimeout(400);
  await mark(page, page.locator('a:visible', { hasText: T.myEvents }).first(), 1);
  await mark(page, page.locator('a:visible', { hasText: T.profile }).first(), 2);
  await mark(page, page.locator('a:visible', { hasText: T.editProfile }).first(), 3);
  await mark(page, page.locator(':is(a,button):visible', { hasText: T.logout }).first(), 4);
  await top(page);
  await shot(page, 'p10-menu-utente', { clip: { x: 0, y: 0, width: 1280, height: 480 } });
  await clearMarks(page);
  await go(page, L('/events/my'));
  await shot(page, 'p12-miei-eventi');
  await page.locator('#user-menu-button').first().click(); await page.waitForTimeout(400);
  await page.locator('a:visible', { hasText: T.profile }).first().click(); await settle(page);
  await shot(page, 'p13-profilo');

  await go(page, L('/profile/edit'));
  await mark(page, page.locator('#profile-data-heading').locator('xpath=ancestor::section[1]'), 1, 2);
  await mark(page, page.getByRole('button', { name: T.save }), 2);
  await top(page);
  await shot(page, 'p15-modifica-profilo');
  await clearMarks(page);
  await page.locator('#profile-photo-heading').scrollIntoViewIfNeeded();
  await mark(page, page.locator('#profile-photo'), 1);
  await mark(page, page.getByRole('button', { name: T.photo }), 2);
  await mark(page, page.locator('#profile-current-password'), 3);
  await mark(page, page.getByRole('button', { name: T.password }), 4);
  await page.evaluate(() => window.scrollBy(0, -40));
  await shot(page, 'p16-foto-password');
  await clearMarks(page);
  await page.getByRole('button', { name: T.deleteOpen }).click(); await page.waitForTimeout(400);
  await page.locator('#profile-delete-heading').scrollIntoViewIfNeeded();
  await page.evaluate(() => window.scrollBy(0, 120));
  await mark(page, page.locator('#profile-delete-password'), 1);
  await mark(page, page.locator('input[wire\\:model="delete_confirmed"]').locator('xpath=ancestor::label[1]'), 2);
  await mark(page, page.getByRole('button', { name: T.deleteOk }), 3);
  await shot(page, 'p17-elimina-account');
  await clearMarks(page);
  await assistantShots(page);

  // Collegare un assistente esterno (Claude, Cursor): token personale creato dal profilo
  await go(page, L('/profile/assistants'));
  await page.fill('#assistant-token-name', 'Claude Desktop');
  await page.locator('form[wire\\:submit="create"] button[type=submit]').click();
  await page.waitForSelector('#assistant-new-token', { timeout: 10000 }).catch(() => log('  ! token non creato'));
  await settle(page);
  await mark(page, page.locator('[data-mcp-url]'), 1, 4);
  await mark(page, page.locator('#assistant-new-token').locator('xpath=..'), 2, 4);
  await mark(page, page.locator('pre').first(), 3, 4);
  await page.locator('[data-mcp-url]').scrollIntoViewIfNeeded(); await page.evaluate(() => window.scrollBy(0, -60));
  await shot(page, 'p24-collega-assistente');
  await clearMarks(page);
  await ctx.close();

  // password dimenticata (da visitatore)
  ctx = await newCtx(); page = await ctx.newPage();
  await go(page, L('/auth/password/reset'));
  await page.locator('#email').fill('giulia@laravelpizza.test');
  await mark(page, page.locator('#email'), 1);
  await mark(page, page.getByRole('button', { name: T.resetLink }), 2);
  await shot(page, 'p14-password-dimenticata', { clip: { x: 0, y: 0, width: 1280, height: 640 } });
  await clearMarks(page);
  // evento pieno visto da un visitatore
  await go(page, EV3);
  await top(page, 260); await page.waitForTimeout(300);
  await mark(page, page.getByText(T.full).first(), 1, 6);
  await top(page, 260);
  await shot(page, 'p11-evento-pieno');
  await ctx.close();

  if (MAILHTML && fs.existsSync(MAILHTML)) {
    ctx = await browser.newContext({ viewport: { width: 760, height: 900 }, deviceScaleFactor: 2 });
    page = await ctx.newPage();
    await page.goto('file://' + fs.realpathSync(MAILHTML)); await page.waitForTimeout(500);
    await shot(page, 'p08-email-conferma', { fullPage: true });
    await ctx.close();
  } else { log('  ! email non generata: p08 non aggiornato'); }

  // I pannelli seguono la lingua preferita dell'utente (users.lang): organizzatrice e amministratore nella lingua del manuale.
  execFileSync(process.env.PHP_BIN ?? 'php', ['artisan', 'tinker', `--execute=Modules\\User\\Models\\User::whereIn('email', ['organizzatrice@laravelpizza.test', 'superadmin@laravelpizza.test'])->update(['lang' => '${LANG}']);`], { cwd: LARAVEL });

  // ---------------- ORGANIZZATORE ----------------
  log('Organizzatore');
  ctx = await newCtx(); page = await ctx.newPage();
  await go(page, '/meetup/admin/login');
  await page.locator('input[type=email]').fill('organizzatrice@laravelpizza.test');
  await page.locator('input[type=password]').fill(PWD);
  await mark(page, page.locator('input[type=email]'), 1);
  await mark(page, page.locator('input[type=password]'), 2);
  await mark(page, page.locator('button[type=submit]'), 3);
  await shot(page, 'o01-login-admin');
  await clearMarks(page);
  await page.locator('button[type=submit]').click();
  await page.waitForURL(u => !u.toString().includes('/login'), { timeout: 30000 });
  await settle(page);

  await go(page, '/meetup/admin');
  await mark(page, page.getByRole('link', { name: T.pEvents }).first(), 1);
  await mark(page, page.getByRole('link', { name: T.pVenues }).first(), 2);
  await mark(page, page.locator('.fi-wi-stats-overview').first(), 3, 4);
  await shot(page, 'o02-dashboard');
  await clearMarks(page);

  await go(page, '/meetup/admin/events');
  await mark(page, page.getByRole('link', { name: T.newEvent }).first().or(page.getByRole('button', { name: T.newEvent }).first()), 1);
  await shot(page, 'o03-lista-eventi');
  await clearMarks(page);
  await top(page, 250); await page.waitForTimeout(300);
  await shot(page, 'o04-lista-eventi-schede');

  await go(page, '/meetup/admin/events/create');
  await page.getByLabel(T.title).fill('Laravel Pizza Bologna: primo meetup');
  await page.getByLabel(T.description).fill('Il primo meetup a Bologna: presentazioni, networking e pizza.');
  const dt = page.locator('input[type="datetime-local"]');
  if (await dt.count() >= 2) { await dt.nth(0).fill('2027-01-21T19:00'); await dt.nth(1).fill('2027-01-21T22:00'); } else { log('  ! datetime inputs', await dt.count()); }
  await page.getByLabel(T.city).fill('Bologna');
  await page.getByLabel(T.seats).fill('');
  await mark(page, page.getByLabel(T.seats), 1);
  await top(page);
  await shot(page, 'o05-nuovo-evento', { fullPage: true });
  await clearMarks(page);
  await page.locator('button[type=submit][wire\\:target="create"]').click();
  await page.waitForTimeout(1500);
  await page.getByLabel(T.seats).scrollIntoViewIfNeeded();
  await page.evaluate(() => window.scrollBy(0, -200));
  await shot(page, 'o06-errore-capienza');
  await page.getByLabel(T.seats).fill('45');
  const sel = page.getByLabel(T.publication);
  await sel.selectOption({ label: T.published }).catch(async () => { await sel.selectOption('published').catch(() => log('  ! status select')); });
  await mark(page, sel, 1);
  await mark(page, page.locator('button[type=submit][wire\\:target="create"]'), 2);
  await shot(page, 'o07-pubblica-e-salva');
  await clearMarks(page);
  await page.locator('button[type=submit][wire\\:target="create"]').click();
  await settle(page); await page.waitForTimeout(1200);
  await shot(page, 'o08-evento-salvato', { clip: { x: 0, y: 0, width: 1280, height: 520 } });

  await go(page, '/meetup/admin/events/laravel-13-e-filament-5-cosa-cambia-davvero/edit');
  const delBtn = page.getByRole('button', { name: T.del }).first();
  await mark(page, delBtn, 1);
  await top(page);
  await shot(page, 'o09-modifica-evento');
  await clearMarks(page);
  await delBtn.click(); await page.waitForTimeout(1200);
  await page.mouse.move(5, 790); await page.waitForTimeout(400);
  await page.screenshot({ path: `${OUT}/o10-conferma-eliminazione.jpg`, type: 'jpeg', quality: 82 }); log('  ✓ o10-conferma-eliminazione');
  await page.keyboard.press('Escape'); await page.waitForTimeout(600);

  await go(page, '/meetup/admin/events/laravel-13-e-filament-5-cosa-cambia-davvero/edit');
  const people = page.getByRole('heading', { name: T.people }).last();
  await people.scrollIntoViewIfNeeded();
  await page.evaluate(() => window.scrollBy(0, -120));
  await mark(page, people.locator('xpath=ancestor::section[1]'), 1, 4);
  await shot(page, 'o11-relatori-sponsor');
  await clearMarks(page);

  await page.evaluate(() => window.scrollTo(0, document.body.scrollHeight)); await page.waitForTimeout(2500);
  const csv = page.getByRole('button', { name: T.csv }).first();
  await mark(page, csv, 1);
  await mark(page, page.locator('table').last().locator('tbody tr').first().locator('button').first(), 2);
  await csv.scrollIntoViewIfNeeded();
  await page.evaluate(() => window.scrollBy(0, -80));
  await shot(page, 'o12-iscritti');
  await clearMarks(page);

  await go(page, '/meetup/admin/venues');
  await mark(page, page.getByRole('link', { name: T.newVenue }).first().or(page.getByRole('button', { name: T.newVenue }).first()), 1);
  await shot(page, 'o13-sedi');
  await ctx.close();

  // ---------------- AMMINISTRATORE ----------------
  log('Amministratore');
  ctx = await newCtx(); page = await ctx.newPage();
  await siteLogin(page, 'superadmin@laravelpizza.test');
  await go(page, '/user/admin/users');
  const paolo = page.locator('tr', { hasText: 'paolo.ferri@laravelpizza.test' });
  await mark(page, page.getByRole('link', { name: T.users }).first(), 1);
  await mark(page, page.getByRole('searchbox').first().or(page.locator('input[type=search]').first()), 2);
  await mark(page, paolo.locator('a[href*="/edit"]').first(), 3);
  await top(page);
  await shot(page, 'a01-utenti');
  await clearMarks(page);
  await paolo.locator('a[href*="/edit"]').first().click(); await settle(page); await page.waitForTimeout(1000);
  await page.getByRole('tab', { name: T.orgTab }).click(); await page.waitForTimeout(2500);
  const attach = page.getByRole('button', { name: T.attach }).first();
  await mark(page, page.getByRole('tab', { name: T.orgTab }), 1);
  await mark(page, attach, 2);
  await attach.scrollIntoViewIfNeeded(); await page.evaluate(() => window.scrollBy(0, -260));
  await shot(page, 'a02-scheda-organizzazione');
  await clearMarks(page);
  await attach.click(); await page.waitForTimeout(1500);
  const dlg = page.locator('.fi-modal-window:visible').first();
  await dlg.locator('.fi-select-input-btn').first().click(); await page.waitForTimeout(800);
  const search = dlg.locator('input[placeholder*="cercare"]:visible, input[placeholder*="search" i]:visible, input[type=search]:visible').first();
  if (await search.count()) { await search.fill('meetup'); await page.waitForTimeout(1500); }
  await page.locator('[role=option]:visible', { hasText: 'meetup::admin' }).first().click().catch(() => log('  ! ruolo non trovato'));
  await page.waitForTimeout(500);
  await mark(page, dlg.locator('.fi-select-input-btn').first(), 1);
  await mark(page, dlg.getByRole('button', { name: T.attach, exact: true }), 2);
  await shot(page, 'a03-assegna-ruolo');
  await clearMarks(page);
  await dlg.getByRole('button', { name: T.attach, exact: true }).click(); await page.waitForTimeout(2500);
  const roleRow = page.locator('tr', { hasText: 'meetup::admin' }).first();
  await center(roleRow); await page.waitForTimeout(300);
  await mark(page, roleRow, 1, 2);
  await shot(page, 'a04-ruolo-assegnato');
  await clearMarks(page);
  await go(page, '/user/admin/roles');
  await shot(page, 'a05-ruoli');
  await ctx.close();

  await browser.close();
  log(missing ? `\n${missing} riquadri non trovati: controlla le immagini` : '\nTutti i riquadri trovati');
})().catch(e => { console.error('ERRORE', e.message); process.exit(1); });

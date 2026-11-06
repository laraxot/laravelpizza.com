---
id: dcp-153
title: "DCP-153: cookiebar integrata nel modulo Gdpr, multilingua, non bloccante e a norma"
type: story
epic: dc-parity-v2
status: done
priority: P0
owner: module:Gdpr
module: Gdpr
created: 2026-10-14
updated: 2026-10-14
qmd: "dcp-153 cookiebar bootstrap italia statikbe spatie laravel-cookie-consent gdpr banner cookie policy inventario InjectCookieBanner consenso garante linee guida 2021 multilingua it en de es axe playwright"
related: [dcp-112, dcp-136, dcp-161, cookiebar-bootstrap-italia-integration]
supersedes_claim_of: ../../../../Themes/Sixteen/docs/bmad/stories/dcp-cookiebar-gdpr-compliance.story.md
---

# DCP-153: cookiebar integrata nel modulo Gdpr

## Richiesta (2026-10-14, utente)
«Studia la cookiebar di Bootstrap Italia: va sempre integrata nel progetto, tenendo conto del modulo Gdpr, `spatie/laravel-cookie-consent`, `statikbe/laravel-cookie-consent`, Tailwind + Alpine + Lit + DaisyUI + Flowbite (niente Bootstrap). E' un progetto multilingua: capisci il senso, la funzionalita', l'utilita'. Fai tutto cio' che serve per rendere il sito a norma di legge. Crea tutte le story BMAD e controlla cosa manca nel resto del sito.»

## Analisi
### Che cosa e' la cookiebar di Bootstrap Italia (letto il 2026-10-14)
Una `<section class="cookiebar">` con `aria-label="Gestione dei cookies"`, un testo, un link «Preferenze» e un pulsante «Accetto» (`data-bs-accept="cookiebar"`), da mettere subito dopo `<body>`. La pagina non documenta: variante con «Rifiuta», dove e come si memorizza la scelta, durata, pannello delle preferenze (il link e' `href="#"`), gestione della tastiera. Rimanda al provvedimento del Garante dell'8 maggio 2014. E' quindi un **contratto di markup**, non un sistema di consenso: da solo, con «Accetto» come unica scelta, non basterebbe appena il sito usasse un cookie non tecnico (le linee guida 2021, par. 7.1, chiedono comandi di pari peso).

### A che cosa serve davvero qui
Il sito oggi imposta solo cookie tecnici (`fixcity_session`, `XSRF-TOKEN`; DCP-136 ne ha misurati 2 su 10 pagine). Per i soli cookie tecnici il Garante (par. 7.1) non richiede un banner: basta l'informazione. Il banner serve a due cose: informare in modo visibile (come fa la cookiebar di Bootstrap Italia) e tenere pronto il meccanismo del consenso per quando un modulo aggiungera' uno strumento di analisi o di marketing, **prima** che parta. Per questo la barra ha due modi, scelti dall'inventario dei cookie.

### Lo stato trovato (prove)
Un'altra sessione aveva dichiarato la cookiebar «completata, a norma». Misurato sulle pagine servite il 2026-10-14:
- 0 occorrenze della barra in `/it`, `/en`, `/it/tickets`, `/it/auth/login`, `/it/privacy` (il middleware era spento dal tenant: `config/local/fixcity/gdpr.php` aveva `cookie_banner_on => false`, decisione di DCP-136);
- il componente (`partials/cookie-bar.blade.php`) usava 13 chiavi `gdpr::cookie.*` che non esistono e la rotta `pages.view` che non esiste, e un errore di battitura (`this.pategories`); salvava la scelta in `localStorage`, che il server non legge;
- la pagina `/it/cookie-policy` rispondeva 404 (cache delle rotte Folio) e, una volta servita, mostrava come titolo la chiave `cookie-consent::texts.policy_title`;
- l'override `resources/views/vendor/cookie-consent/index.blade.php` includeva `sixteen::components.feedback.cookiebar`, un namespace che non esiste: accendendo il middleware il sito rispondeva **500** (provato e subito ripristinato);
- il testo del banner del pacchetto descriveva «cookie analitici» che il sito non ha.

### Perche' non lo script del pacchetto
Il JS di `statikbe/laravel-cookie-consent` all'apertura rende inerti (`inert`) tutti gli altri elementi della pagina e mostra uno sfondo finche' non si sceglie: un blocco della navigazione. Per un banner informativo e per le linee guida (nessun cookie wall, par. 6.1) non va bene. Dal pacchetto si tiene il middleware, la chiave del cookie e i suoi valori; lo script e la vista sono sostituiti.

## Modifiche
Modulo Gdpr: `CookieCategory` (enum), `CookieData` e `CookieInventoryData`, `GetCookieInventoryAction`, vista `cookie-consent/index.blade.php`, middleware `InjectCookieBanner`, testi in 4 lingue (46 chiavi), configurazione `cookie.consent_lifetime` (180) ed `extra`, documento `docs/cookie-banner.md`. Provider: namespace delle traduzioni registrato a boot concluso, vista del modulo prepesa a quella del pacchetto, middleware aggiunto al kernel.
Tema Sixteen: blocco `cookie-policy/design-comuni.blade.php`, voci «Cookie policy» e «Gestisci cookie» nel `footer_bottom_links` (template e `footer.json`), tolte le due inclusioni del vecchio partial dai layout `main` e `test`.
Contenuto: pagina JSON `cookie-policy.index.json` per i tenant `local`, `eu` e per il modulo Fixcity.
Rimossi (creati oggi da un'altra sessione, non tracciati, rotti): `laravel/resources/views/vendor/cookie-consent/index.blade.php`, `Themes/Sixteen/resources/views/pages/cookie-policy.blade.php`, `laravel/lang/vendor/cookie-consent/` (copie identiche del pacchetto, ignorate da git).
Tenant `local/fixcity`: `cookie_banner_on => true`.

## Difetti trovati lungo la strada
1. Per le traduzioni vince l'ultimo namespace registrato e il pacchetto registra `cookie-consent` dopo il modulo: i file `it` e `de` del modulo non erano mai stati caricati. Un test che leggeva i file non lo vedeva: serve `trans()`.
2. `laravel/lang/vendor/cookie-consent/{en,es,fr,nl,oc}` (copie pubblicate) si applicano sopra le traduzioni del modulo chiave per chiave: in inglese e spagnolo comparivano ancora i testi del pacchetto.
3. `config('gdpr.cookie.consent_lifetime')` era `null`: la configurazione del modulo e' sotto `gdpr.config.*`.
4. Il flag del tenant era valutato all'avvio del provider: in un'applicazione multi-tenant dipende dalla richiesta.
5. `pushMiddlewareToGroup` sul router andava perso nei test (il gruppo `web` non conteneva il middleware): si aggiunge sul kernel.
6. La barra fissa copriva il fondo della pagina e il link «Gestisci cookie» non era cliccabile finche' restava: ora la pagina lascia lo spazio sotto.

## Verifica (2026-10-14)
| Prova | Esito |
|---|---|
| `Themes/Sixteen/tests/browser/cookie-banner.spec.mjs`, Chromium, `FIXCITY_BASE_URL=http://127.0.0.1:8091` | **17 passati su 17** (1,5 minuti): barra al primo accesso in it, en, de, es; non bloccante (0 elementi `inert`); pulsante alto almeno 44 px con sfondo non azzerato dal CSS Design Comuni; cookie `__cookie_consent=false`, `SameSite=Lax`, scadenza 179-181 giorni; dopo il ricaricamento la barra non torna; «Gestisci cookie» riapre le preferenze senza navigare, Esc le chiude; axe (wcag2a/aa, 2.1a/aa) senza violazioni su barra e finestra in 4 lingue; la tabella della cookie policy elenca esattamente i cookie impostati dal server; modo consenso (markup reso con un cookie analitico dichiarato): Accetta e Rifiuta di pari peso, X = rifiuto, Personalizza salva `2`, Accetta tutti scrive `true` ed emette `cookie-consent:changed` |
| Pest `Modules/Fixcity/tests/Unit/Cookie`, `Feature/Pages/CookieBannerPagesTest`, `PublicPagesStructureTest`, `FooterLinksResolveTest` su DB isolato (`pest-scratch-db.sh`) | **59 passati, 1 todo** (575 asserzioni). Utenti e ticket del DB di sviluppo identici prima e dopo (11 e 18) |
| Scansione di 12 pagine pubbliche in 4 lingue (48 combinazioni) | 0 problemi: `lang` giusto, un solo `<h1>`, `<title>` distinti, nessuna chiave di traduzione visibile |
| `curl` su 8081 e 8091, `/it` `/en` `/de` `/es` | HTTP 200, una barra per pagina, in modo `info` |
| Test del modo consenso | Il markup in modo consenso e' reso dalla vista Blade vera con un cookie dichiarato e provato nel browser; **non e' stato provato su un'istanza reale in quel modo**, perche' oggi il sito non ha cookie non tecnici |

Non verificato: lettore di schermo (NVDA, VoiceOver, TalkBack), Safari e Firefox (solo Chromium), contrasto con i colori dei tenant diversi da quello di prova (il colore primario viene da `--bs-primary`, con ripiego `#0066cc`), CSP con nonce.

## Decisioni
- Una sola implementazione, nel modulo proprietario (Gdpr), valida per ogni tema.
- Modo `info` finche' l'inventario ha solo cookie tecnici; il consenso scatta da `gdpr.config.cookie.extra`.
- 180 giorni: il minimo che le linee guida (par. 6.2) ammettono prima di riproporre la richiesta.
- Il banner e' attivo per scelta dell'utente («va sempre integrato»), anche se per soli cookie tecnici la norma non lo richiede.

## Aperto
- DCP-161: rimozione delle implementazioni duplicate del tema (e di due test del modulo UI che le nominano).
- DCP-137: Google Fonts e tessere OpenStreetMap ricevono l'IP del visitatore senza cookie; la cookie policy lo dichiara solo per OpenStreetMap perche' e' l'unico verificato in questa sessione. Verificare i font.
- Provare lo script con un lettore di schermo, e in Firefox e Safari.
- Il flag `cookie_banner_on` per il tenant `eu/fixcity` non ha file: vale il default `true` del `GdprData`.
- I test del modulo Gdpr non avviano l'applicazione (186 su 254 falliscono con «A facade root has not been set», misurato dall'agente di studio dei docs): per questo i test del banner stanno nel modulo Fixcity, come quello dell'avatar di Xot.

---
title: "Banner dei cookie del modulo Gdpr"
type: reference
status: active
updated: 2026-10-14
tags: [gdpr, cookie, banner, garante, statikbe, multilingua, accessibilita]
qmd: "banner cookie cookiebar gdpr statikbe laravel-cookie-consent inventario cookie policy garante linee guida 2021 consenso InjectCookieBanner GetCookieInventoryAction gdpr.config.cookie.extra __cookie_consent"
related:
  - ./stories/dcp-153-cookiebar-integrata-nel-modulo-gdpr.story.md
  - ./stories/dcp-136-cookie-inventario-informazione-e-guardia-sui-cookie-impostati.story.md
---

# Banner dei cookie del modulo Gdpr

Questo e' il documento di riferimento. Sostituisce `cookiebar-integration.md`, `cookie-consent.md` e le loro copie, che descrivono un componente diverso da quello che gira (vedi la story DCP-153).

## Che cosa fa
Una barra in fondo alla pagina, non bloccante, e una finestra delle preferenze, in italiano, inglese, tedesco e spagnolo. Segue il contratto di markup della cookiebar di Bootstrap Italia (regione con `aria-label`, due controlli) senza usare Bootstrap: stile incorporato, nessuna dipendenza.

**Due modi, scelti dall'inventario e non da un flag.** Oggi il sito imposta solo cookie tecnici (`fixcity_session`, `XSRF-TOKEN`, `__cookie_consent` e, solo se si spunta «Ricordami» al login, `remember_web_*` per 400 giorni; inventario in `GetCookieInventoryAction`, misurato con `Set-Cookie` il 2026-10-26): la barra informa e ha un solo comando, «Ho capito». Appena un modulo dichiara un cookie non tecnico, la stessa barra passa a «Accetta tutti», «Rifiuta tutti» (stesso peso), «Personalizza» e la X di chiusura, che equivale a rifiutare.

## Come e' fatto
| Pezzo | Dove |
|---|---|
| Inventario dei cookie | `app/Actions/Cookie/GetCookieInventoryAction.php`, restituisce `CookieInventoryData` (`app/Datas/`) |
| Vista del banner | `resources/views/cookie-consent/index.blade.php` (markup, stile e uno script di una sessantina di righe) |
| Iniezione | `app/Http/Middleware/InjectCookieBanner.php`, sottoclasse del middleware di `statikbe/laravel-cookie-consent`; registrato nel gruppo `web` dal kernel in `GdprServiceProvider` |
| Testi | `lang/cookie-consent/{it,en,de,es}/texts.php` (46 chiavi identiche nelle quattro lingue) |
| Pagina cookie policy | blocco `cookie-policy` del tema Sixteen e pagina JSON `cookie-policy.index.json` |
| Flag per tenant | `config/<tenant>/gdpr.php`, chiave `cookie_banner_on` (valutata a ogni richiesta) |

Dal pacchetto restano il middleware, la chiave del cookie (`cookie-consent.cookie_key`, `__cookie_consent`) e i suoi valori: `true` analitici e marketing, `2` solo analitici, `3` solo marketing, `false` nessuno. Lo **script del pacchetto non si usa**: all'apertura rende inerte tutta la pagina e mostra uno sfondo, cioe' blocca la navigazione.

## Dichiarare un cookie non tecnico
In `Modules/Gdpr/config/config.php`, chiave `cookie.extra` (letta come `gdpr.config.cookie.extra`):
```php
'extra' => [
    ['name' => '_pk_id', 'category' => 'analytics', 'purpose' => 'Misura le visite', 'duration' => '13 mesi'],
],
```
`category` e' `analytics` o `marketing`. Da quel momento il banner chiede il consenso e la cookie policy mostra il cookie. Lo script non attivato dal consenso non deve partire: ascoltare l'evento `cookie-consent:changed` (`detail: { value, analytics, marketing }`) e leggere il cookie al caricamento della pagina.

## Regole del Garante rispettate (linee guida 10.6.2021 n. 231, registro fonti 02)
- Par. 7.1: al primo accesso nessun cookie non tecnico; X in alto a destra, che lascia le impostazioni di default; comandi di uguali dimensioni, enfasi e colori; link nel footer per rivedere le scelte («Gestisci cookie», `data-cookie-preferences`); con soli cookie tecnici basta l'informazione.
- Par. 6.1: lo scorrimento non vale come consenso; nessun cookie wall.
- Par. 6.2: la scelta, anche di rifiuto, e' registrata (cookie di 180 giorni) e non richiesta di nuovo prima di 6 mesi.
- Par. 8: informativa, e banner accessibile con tecnologie assistive (L. 4/2004): verificato con axe nelle quattro lingue.

La pagina di Bootstrap Italia rimanda al provvedimento dell'8 maggio 2014. Il registro fonti del progetto usa le linee guida 2021 come testo vigente e il controllo del 2026-10-13 non ha trovato testi successivi che le sostituiscano.

## Trappole incontrate (2026-10-14)
1. **Il namespace delle traduzioni e' conteso.** Il pacchetto registra `cookie-consent` dopo il modulo e per le traduzioni vince l'ultimo: il modulo lo registra a boot concluso (`app->booted`).
2. **`laravel/lang/vendor/cookie-consent/`** (copie pubblicate dei testi del pacchetto, ignorate da git) si applica *sopra* le traduzioni del modulo, chiave per chiave. Su una macchina che le ha, va cancellata. Il test `resolves the module texts through the translator` lo rileva.
3. **La configurazione del modulo si carica sotto `gdpr.config.*`**, non `gdpr.*`: `config('gdpr.cookie...')` e' sempre `null`.
4. **Il flag del tenant non si valuta all'avvio** del provider: il tenant dipende dalla richiesta.
5. **Un `pushMiddlewareToGroup` sul router puo' andare perso** (il kernel risincronizza i gruppi): si aggiunge sul kernel.
6. Un chiave di traduzione mancante non da errore: la vista mostra la chiave. `PublicPagesStructureTest` cerca le chiavi grezze nel testo visibile di 12 pagine in 4 lingue.

## Verifica
- Browser: `Themes/Sixteen/tests/browser/cookie-banner.spec.mjs` (17 test: 4 lingue, cookie, tastiera, axe, modo consenso).
- Pest (modulo Fixcity, che avvia l'applicazione): `tests/Unit/Cookie/*`, `tests/Feature/Pages/CookieBannerPagesTest.php`, `tests/Feature/Pages/PublicPagesStructureTest.php`.
- Guardia: ogni cookie impostato a un ospite deve essere nell'inventario (`sets no cookie that the inventory does not declare`).

---
title: "Banner cookie, inventario e terze parti"
type: guide
module: Gdpr
updated: 2026-11-25
related:
  - adr/cookie-banner-wired-by-the-module.md
  - stories/dcp-445-guardia-del-cablaggio-del-banner-cookie.story.md
  - stories/dcp-454-terze-parti-prima-del-consenso-gravatar-e-openstreetmap.story.md
---

# Banner cookie, inventario e terze parti

Il banner e' del pacchetto `statikbe/laravel-cookie-consent`, ma traduzioni, vista e iniezione sono del modulo (decisione in
[ADR](adr/cookie-banner-wired-by-the-module.md)). Norma di riferimento: D.Lgs. 196/2003 art. 122 e Linee guida cookie del
Garante (provv. 10.6.2021 n. 231): per i soli cookie tecnici basta l'informativa; i cookie analitici e di marketing richiedono
consenso preventivo, raccolto con "Accetta" e "Rifiuta" di pari peso, senza caselle preselezionate e senza blocco della navigazione.

## Come e' cablato (`GdprServiceProvider::boot()`)

1. **Traduzioni** `cookie-consent::texts.*`: il provider le ricarica in `app->booted()` con `Translator::addLines` per `it`, `en`,
   `de`, `es` da `lang/cookie-consent/<lingua>/texts.php`. Per le traduzioni vince l'ultimo namespace registrato e il pacchetto
   (solo en, es, fr, nl, oc) registra il suo dopo il provider: senza questo passo in `/it` il banner mostrava le chiavi grezze.
2. **Vista**: `View::prependNamespace('cookie-consent', resources/views/cookie-consent)` fa prevalere la vista del modulo.
3. **Middleware**: `InjectCookieBanner` (estende `CookieConsentMiddleware`) e' aggiunto al gruppo `web` **sul kernel HTTP** e non
   solo sul router (il kernel risincronizza i gruppi: un push fatto solo sul router puo' andare perso). E' sempre registrato:
   il flag `cookie_banner_on` del tenant (`GdprData`, default `true`) lo valuta il middleware a **ogni richiesta**, perche' in
   un'applicazione multi-tenant il tenant si conosce solo con la richiesta.
4. **CSS**: `AdminPanelProvider` registra `resources/dist/cookie-consent.css` con `FilamentAsset`; `php artisan filament:assets` lo
   copia nella cartella pubblica servita (un URL `/vendor/cookie-consent/...` puntava a una cartella non servita: 404).

## Due modi del banner (deciso da `GetCookieInventoryAction`, non da un flag)

- **Solo cookie tecnici** (oggi, con `gdpr.config.cookie.extra` vuoto): barra informativa con "Ho capito", nessun "Rifiuta".
  Con `info_banner = false` (`GdprConfigData`) non compare nulla: l'informativa basta.
- **Almeno un cookie non tecnico dichiarato**: "Accetta tutti", "Rifiuta tutti" (stesso peso), "Personalizza" per categoria,
  chiusura con la X = rifiuto, nessuna casella preselezionata. Il valore del cookie di consenso coincide con quello del pacchetto
  (`true` = analitici e marketing, `2` = analitici, `3` = marketing, `false` = nessuno).

La barra non blocca la pagina (lo script del pacchetto la rendeva inerte: non ammesso dalle linee guida). Il markup segue il
contratto di Bootstrap Italia senza Bootstrap. Posizione: fissa in basso; `data-layout="flow"` la mette in flusso in cima alla pagina se
copre un controllo del primo schermo; un tema con header fisso aggancia quell'attributo. Con CSP a nonce aggiungere il nonce a
`<style>` e `<script>`.

## Inventario dei cookie

`GetCookieInventoryAction` (`CookieInventoryData` di `CookieData{name, category, purpose, duration}`) ricava i cookie **tecnici**
dalla configurazione reale: sessione (`session.cookie`, `session.lifetime`), `XSRF-TOKEN`, "ricordami" del guard (nome del
recaller, 400 giorni: elencato anche se impostato solo se l'utente spunta la casella), chiave del consenso
(`cookie-consent.cookie_key`, durata `consent_lifetime`). La cookie policy non puo' dire una cosa diversa da quella che il server
imposta. Un modulo che aggiunge un cookie **non** tecnico lo dichiara in `gdpr.config.cookie.extra` come
`[name, category (analytics|marketing), purpose, duration]` (purpose e duration: chiavi di traduzione o testi): da quel momento
il banner passa dalla sola informazione alla richiesta di consenso. `CookieCategory`: `necessary` (unica senza consenso),
`analytics`, `marketing`.

## Impostazioni (`SettingPage`)

`consent_lifetime` (giorni di validita' della scelta, default 180, **minimo 180**: il Garante non ammette di riproporre il banner
prima di 6 mesi), `info_banner`, `policy_path` (default `/cookie-policy`, pagina dei testi della cookie policy
`cookie-consent::texts.policy_*`). Un'unica definizione in `GdprConfigData`, non in `config/config.php`.

## Terze parti prima del consenso

Non sono cookie, ma richieste a servizi esterni che espongono IP e user agent. Decisione del titolare (story
[DCP-454](stories/dcp-454-terze-parti-prima-del-consenso-gravatar-e-openstreetmap.story.md)): **nessuna richiesta a terzi dal
browser prima della scelta**: avatar Gravatar sostituiti da iniziali con interruttore `comments.gravatar.enabled` (modulo
Comment), tile OpenStreetMap e Nominatim serviti da un proxy con cache (modulo Geo). La cookie policy e l'informativa devono dire
la stessa cosa; i layer scelti esplicitamente dall'utente (satellitare, umanitario) restano diretti. Non c'e' integrazione con
Google Analytics o Cloudflare nel modulo (verificato: nessun riferimento nel codice).

## Trappole (tutte successe)

1. **Provider riportato a una versione vecchia da un mirror** (commit "." del 2026-11-11): niente `booted` con `addLines`, niente
   `prependNamespace`, niente `InjectCookieBanner` nel gruppo `web`. Effetto: `/cookie-policy` con 20 chiavi grezze, **nessun
   banner**, terze parti caricate prima della scelta, e i test del banner restavano verdi perche' non avviavano il provider.
   Guardia: `tests/Unit/Providers/CookieConsentWiringTest.php` (3 test: ogni riga di `texts.php` si risolve nelle 4 lingue e
   sono controllate oltre 100 righe; la vista del modulo prevale su quella del pacchetto; `InjectCookieBanner` e' nel gruppo
   `web`). Dichiara `uses(TestCase::class)`: Pest legge solo `laravel/tests/Pest.php` e senza `uses()` il test girerebbe su un
   container vuoto. Ripristino sempre **in avanti** (mai `checkout`/`reset`).
2. **`use function Safe\realpath;` duplicato** nel provider (2026-03-02): fatal error che bloccava `package:discover` e ogni
   `artisan`. Importare la funzione una volta sola.
3. **Valutare `cookie_banner_on` all'avvio del provider**: dipende dal tenant attivo in quel momento e in multi-tenant e' sbagliato
   in principio: lo valuta il middleware.
4. **Traduzioni**: `lang/cookie-consent` ha `it`, `en`, `de`, `es`; `fr` e `ru` del modulo non hanno la traduzione del pacchetto
   (aperto, vedi [roadmap.md](roadmap.md)).

## Verifica

Pagine pubbliche da ospite: la sezione `.gdpr-cookiebar` (`data-cookiebar="info"` o `"consent"`) deve comparire prima di `</body>` se `cookie_banner_on` e' vero;
la cookie policy mostra testi e non chiavi nelle quattro lingue. La guardia automatica e' il test del punto 1; la resa visiva
(contrasto, focus, mobile) e' ancora da verificare ([story DCP-136a](stories/dcp-136a-cookie-banner-stato-reale-audit-visivo.story.md)).

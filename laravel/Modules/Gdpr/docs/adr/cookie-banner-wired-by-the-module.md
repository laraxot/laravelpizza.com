---
title: "ADR — Il banner cookie è cablato dal provider del modulo, sopra il pacchetto statikbe"
type: decision
status: accepted
module: Gdpr
tags: [adr, gdpr, cookie, banner, provider, middleware]
created: 2026-11-24
updated: 2026-11-24
related:
  - ../stories/dcp-445-guardia-del-cablaggio-del-banner-cookie.story.md
  - ../stories/dcp-454-terze-parti-prima-del-consenso-gravatar-e-openstreetmap.story.md
---

# ADR: il banner cookie è cablato dal provider del modulo, sopra il pacchetto statikbe

## Contesto

- Il banner viene da `statikbe/laravel-cookie-consent`, che porta traduzioni solo en, es, fr, nl, oc e una vista sua.
- Il commit "." `78c4ef9` (un mirror) ha riportato `GdprServiceProvider` a una versione vecchia: `/cookie-policy` con 20 chiavi grezze,
  **nessun banner su nessuna pagina**, terze parti caricate prima della scelta; i test restavano verdi (DCP-445).
- Il flag `cookie_banner_on` è del tenant, e il tenant si conosce solo con la richiesta.
- Domanda: dove e come si attacca il banner perché non sparisca in silenzio?

## Decisione

In `app/Providers/GdprServiceProvider.php::boot()`:

- traduzioni `cookie-consent` del modulo (it, en, de, es) aggiunte con `addLines` dentro `app->booted()`, perché il pacchetto
  registra il suo namespace dopo il provider e altrimenti vincerebbe;
- `View::prependNamespace('cookie-consent', resources/views/cookie-consent)`: la vista del modulo prevale (DCP-153);
- `InjectCookieBanner` sempre aggiunto al gruppo `web`, sul kernel HTTP (il kernel risincronizza i gruppi sul router);
- il middleware (`app/Http/Middleware/InjectCookieBanner.php`) valuta `GdprData::make()->cookie_banner_on` **a ogni richiesta**.

## Alternative scartate

- Pubblicare viste e traduzioni del pacchetto nell'app: copie per progetto che invecchiano, e il modulo non sarebbe più agnostico.
- Decidere al boot del provider se registrare il middleware (com'era): dipende da quale tenant è attivo all'avvio, sbagliato in un'app
  multi-tenant.
- Includere il banner a mano nel layout di ogni tema: basta un tema che se ne dimentica.

## Conseguenze

- Pro: un solo punto di cablaggio, testi in quattro lingue, banner per tenant.
- Contro: il provider dipende dall'ordine di boot del pacchetto (`app->booted`); un mirror che riporta indietro il file lo rompe.
- Debito: nessuno noto oltre alla fragilità dei mirror, coperta dalla guardia.

## Verifica

`vendor/bin/pest Modules/Gdpr/tests/Unit/Providers/CookieConsentWiringTest.php` (3 test, verdi il 2026-11-24): fallisce se le righe di
`texts.php` non si risolvono nelle quattro lingue, se `cookie-consent::index` non è la vista del modulo o se `InjectCookieBanner` non è
nel gruppo `web`.

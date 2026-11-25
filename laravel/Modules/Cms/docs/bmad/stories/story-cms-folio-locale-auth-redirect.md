---
title: "Folio guests keep the requested locale on authentication redirects"
type: story
status: done
module: Cms
created: 2026-09-27
updated: 2026-09-27
tags: [bmad, folio, localization, authentication, fixcity]
qmd: "Folio guest auth redirect preserves requested locale en it login route"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/383"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/392"
related:
  - ../../folio-routing-locale.md
  - ../../locale-prefix-e2e-rule.md
  - ../../../../Fixcity/docs/bmad/gap-analysis.md
---

# Story

Come visitatore, quando apro una pagina Folio protetta in una lingua specifica,
voglio essere mandato alla pagina di accesso nella stessa lingua, così non perdo
il contesto prima di autenticarmi.

## Acceptance criteria

1. Guest su `/it/tickets/create` riceve redirect a `/it/auth/login`.
2. Guest su `/en/tickets/create` riceve redirect a `/en/auth/login`.
3. La locale app e quella di LaravelLocalization corrispondono al prefisso della
   richiesta quando viene generato il redirect.
4. Il comportamento JSON resta non redirect (risposta 401).
5. Nessuna credenziale o configurazione `.env.testing` viene alterata per i test.

## Implementazione

`bootstrap/app.php` configura `redirectGuestsTo` con
`LaravelLocalization::getLocalizedURL()` e la locale già risolta da
`SetFolioLocale`. Il fallback costruisce il path con la stessa locale, mai con la
route nominata `login` che usa la lingua predefinita. Test di regressione nel
modulo owner FixCity: `tests/Feature/Pages/TicketGuestLocaleRedirectTest.php`.

## Verifica

- Pest: redirect IT/EN e conservazione di `url.intended` + 401 JSON, 3 casi / 15
  asserzioni.
- Suite completa FixCity: 372 test / 1.585 asserzioni.
- Chromium end-to-end: `/it|en/tickets/create` da guest termina sul login
  localizzato; copy/footer e link corretti a 320/768/1440 px, nessun overflow o
  errore JavaScript.

Correzione verificata 2026-10-13 (DCP-35 S4): lo stato attuale di `/it/tickets/create` e `/en/tickets/create` per un ospite è `200` senza redirect (curl): `tickets.create.json` non ha la chiave `middleware` in nessuna delle tre copie. I criteri 1 e 2 valgono solo per pagine protette con `auth`; il test `Modules/Fixcity/tests/Feature/Pages/TicketGuestLocaleRedirectTest.php` (che chiede il redirect su `/{it,en}/tickets/create`) oggi fallisce 3 casi su 3 (`pest` del 2026-10-13: «Expected response status code [401] but received 200» e `assertRedirect` non soddisfatto): è obsoleto o va riallineato alla decisione sull'`auth` di `tickets.create`.

Aggiornamento 2026-10-13 14:05 UTC: la chiave `"middleware": ["auth"]` e' stata ripristinata in `config/local/fixcity/.../tickets.create.json` (D17, DCP-42). Un ospite riceve ora 302 `/it/auth/login` e `/en/auth/login`; `TicketGuestLocaleRedirectTest` passa (6 test, 28 asserzioni con gli altri due file). Le copie `Modules/Fixcity/config` ed `eu` non hanno ancora la chiave.

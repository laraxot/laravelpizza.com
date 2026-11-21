---
title: "Login guest IT — catalogo traduzioni"
type: bugfix
status: fixed
created: 2026-09-27
updated: 2026-09-27
module: User
tags: [bmad, user, auth, guest, i18n]
qmd: "Italian guest login empty translation catalog PHP 500 array_replace_recursive"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/383"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/392"
related:
  - ../wiki/auth-patterns.md
  - ../../../../Themes/Sixteen/resources/views/pages/auth/login.blade.php
---

# Login guest in italiano — correzione

## Comportamento atteso e osservato

Il visitatore guest che apre `/it/auth/login`, o viene reindirizzato al login da una pagina protetta, deve ottenere una pagina 200 con form e testi italiani. Prima della correzione, `Modules/User/lang/it/login.php` conteneva solo `declare(strict_types=1)` e il `require` restituiva `1`; il loader Laravel passava quindi un intero a `array_replace_recursive()` e rispondeva 500.

## Correzione e verifica

- Aggiunto il catalogo italiano `fields/actions/messages` e le etichette usate dalla pagina Sixteen.
- `AuthComponentsTest` verifica 200, etichetta “Ricordami”, CTA di registrazione e redirect guest della pagina profilo al login. I riferimenti alle view sono qualificati col namespace owner `user::`.
- Verifica: `APP_ENV=testing FIXCITY_TEST_SQLITE=1 vendor/bin/pest Modules/User/tests/Feature/AuthComponentsTest.php --filter='login page loads correctly'` — 1 test / 4 asserzioni passati.
- Suite auth mirata: 8 test / 19 asserzioni passati, nessuno skip.
- Smoke browser guest: `/it/auth/login` e `/it/auth/register` 200; `/it/segnalazioni/create`, `/it/area-personale/pratiche` e `/it/area-personale/seguite` arrivano al login senza errori JS.

## Limiti

La registrazione è stata verificata solo al rendering: invio, verifica email e accesso con account non fanno parte di questo smoke. La home `/it/` mostra la lista pubblica come definito dal JSON owner `config/local/fixcity/database/content/pages/home.json`; il contenuto CMS del deploy non è stato verificato.

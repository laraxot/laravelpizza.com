---
id: STORY-ENGLISH-LOGIN-20261007
title: "Login inglese senza fallback italiano"
status: implemented-runtime-pending
owner: User
created: 2026-10-07
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/572"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/573"
---

# Login inglese senza fallback italiano

## Problema

`/en/auth/login` impostava correttamente la lingua URL ma mancavano le chiavi
`user::auth.login_page.*` e alcuni link `user::login.*` in inglese. Laravel quindi
usava il fallback italiano, producendo una pagina ibrida.

## Correzione

Completate le chiavi inglesi nel modulo User. Sixteen continua a consumare le
traduzioni namespaced del modulo, senza etichette hardcoded nel tema.

## Acceptance criteria

- [x] Titolo, heading, descrizione e supporto di `/en/auth/login` sono inglesi.
- [x] Link registrazione e reset password sono inglesi.
- [x] `/it/auth/login` resta italiano.
- [ ] Smoke test browser automatizzato su HTTPS quando il runtime Playwright è disponibile.

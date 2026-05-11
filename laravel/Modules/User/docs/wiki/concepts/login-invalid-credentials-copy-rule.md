---
title: "Login invalid credentials copy rule"
type: concept
confidence: high
created: 2026-04-27
updated: 2026-04-27
tags: [login, i18n, translations, auth]
sources:
  - ../../../../app/Filament/Widgets/Auth/LoginWidget.php
  - ../../../../resources/views/pages/auth/login.blade.php
  - ../../../../lang/it/login.php
related:
  - ./translation-5-level-structure.md
  - ./login-page-design-comuni.md
---

# Login invalid credentials copy rule

## Regola

Per il login pubblico non usare:

- `__('auth.failed')`
- chiavi ad hoc tipo `__('user::auth.failed.text')`

Usare invece una chiave conforme alla struttura minima:

- `__('user::login.actions.login.error')`

## Motivazione

- resta dentro il contesto/attore `login`
- usa la collezione `actions`
- identifica l'elemento `login`
- usa il tipo `error`
- rispetta il prototipo minimo a 5 elementi contando il namespace

## Copy approvato

`Le credenziali inserite non sono corrette.`

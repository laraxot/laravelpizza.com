---
title: "Registrazione mobile — larghezza form"
type: bugfix
status: implemented-pending-browser
created: 2026-09-27
updated: 2026-09-27
module: User
tags: [bmad, user, auth, mobile, ux]
qmd: "register mobile form width narrow card viewport 390"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/383"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/392"
related:
  - ../wiki/auth-patterns.md
  - ../../../../Themes/Sixteen/resources/views/filament/widgets/auth/register.blade.php
---

# Registrazione mobile — larghezza del form

## Comportamento osservato

Con viewport 390 px la card di registrazione occupava 318 px, mentre il form si restringeva a 116 px. I campi e le etichette andavano a capo e la compilazione diventava impraticabile.

## Correzione

Il form del widget di registrazione ora dichiara `w-full min-w-0`: espande il layout alla larghezza disponibile e permette ai contenuti flessibili di restringersi senza forzare la card. La regola è limitata alla view owner Sixteen della registrazione.

## Verifica

- Aggiunto test Playwright mobile a 390 px: il form deve superare il 70% della larghezza card e la pagina non deve avere overflow orizzontale.
- Suite `AuthComponentsTest`: 8 test / 19 asserzioni passati; `view:cache`, `node --check` e `git diff --check` passano. Il CSS compilato include `.w-full { width: 100% }`.
- Esecuzione test browser bloccata: `@playwright/test` non è installato nel progetto e Chromium non è disponibile nell'ambiente (mancano binario/librerie runtime).
- Limite residuo: la verifica del solo breakpoint 390 px non sostituisce un audit accessibilità completo su tastiera e screen reader.

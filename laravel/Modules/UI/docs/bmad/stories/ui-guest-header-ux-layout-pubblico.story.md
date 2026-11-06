---
title: "UI guest header e layout pubblico"
type: story
module: UI
track: ux/guest-auth
status: superseded
superseded_by: ui-guest-header-ux.story.md
---

## Obiettivo funzionale

Le pagine pubbliche devono essere navigabili senza sessione autenticata. Il
header non deve leggere dati utente o mostrare link protetti ai guest; deve
offrire CTA chiare per Login e Register.

## Correzioni

- `header.blade.php`: navigazione protetta solo per utenti autenticati;
  dropdown profilo solo sotto `@auth`; CTA guest Login/Register; attributi
  ARIA sul menu e sul toggle.
- Homepage Four: usa il layout guest invece del layout app autenticato.

## Verifica

- `php artisan view:cache`: OK.
- `GET /it`: HTTP 200 senza `Attempt to read property`.
- Regola second brain applicata: layout guest per pagine pubbliche, app per
  pagine autenticate.

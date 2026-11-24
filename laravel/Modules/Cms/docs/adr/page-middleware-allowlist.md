---
title: "ADR — I middleware dichiarati nel JSON di una pagina passano da un'allowlist di configurazione"
type: decision
module: Cms
tags: [adr, cms, sicurezza, middleware, folio, dcp-283]
created: 2026-11-24
updated: 2026-11-24
status: accepted
related:
  - ../../app/Actions/ValidatePageMiddlewareAction.php
  - ../../app/Http/Middleware/PageSlugMiddleware.php
  - ../../config/config.php
---

# ADR: i middleware dichiarati nel JSON di una pagina passano da un'allowlist di configurazione

## Contesto

- Ogni pagina CMS e' un JSON (`config/<tenant>/database/content/pages/*.json`) con un campo `middleware`, che
  `PageSlugMiddleware` applica alla richiesta (es. `auth`, `throttle:10,1`).
- Il JSON e' un dato modificabile (editor, import, merge): senza un controllo, chi lo scrive farebbe eseguire qualunque
  classe con un metodo `handle` come middleware (DCP-283, punto C-03).
- Misurato: i JSON del repository usano solo `auth` e `throttle` (piu' `web`, gia' applicato dallo stack Folio).

Domanda: come lasciare ai JSON la scelta della protezione senza dar loro il potere di eseguire codice arbitrario?

## Decisione

- `ValidatePageMiddlewareAction` confronta il nome prima dei due punti con `cms.config.page_middleware_allowlist`
  (`config/config.php`, oggi `['auth', 'throttle']`); `web` passa sempre (`FOLIO_APPLIED_GROUPS`) e non fa nulla.
- Un solo nome fuori elenco rifiuta l'intera lista (`InvalidArgumentException`).
- `PageSlugMiddleware` tratta qualsiasi errore nel determinare la protezione come **503** con log: una pagina con protezione
  incerta non si serve, ne' aperta ne' con un 500 che espone dettagli.
- L'allowlist si estende solo da configurazione, mai dal JSON.

## Alternative scartate

- Fidarsi del JSON: esecuzione di classi arbitrarie da un dato.
- Denylist (vietare `guest`, `api`, classi FQCN): ogni middleware nuovo del framework o di un modulo diventerebbe
  ammesso per default.
- Ammettere i nomi registrati nel Kernel (alias): includono `guest` (bloccherebbe i loggati) e alias di moduli pensati per
  altre rotte.
- In caso di errore servire la pagina senza protezione: una pagina pensata per `auth` diventerebbe pubblica.

## Conseguenze

- Pro: il JSON sceglie tra protezioni note; un errore di battitura (`auht`) chiude la pagina invece di aprirla.
- Contro: un middleware nuovo richiede di aggiornare la config del modulo o del tenant.
- Chi aggiunge una pagina con un middleware nuovo deve prima estendere l'allowlist; il test sui JSON lo segnala.

## Verifica

- `Modules/Cms/tests/Unit/Actions/ValidatePageMiddlewareActionTest.php` (group `CMS-PAGE-MIDDLEWARE-INV-1` ... `-INV-4`):
  nomi fuori elenco, maiuscole, spazi, prefissi, `guest`, `api`, FQCN rifiutati; `web` ammesso; elenco solo da config.
- `Modules/Cms/tests/Unit/Content/PageJsonMiddlewareAllowlistTest.php`: ogni JSON di pagina del repository dichiara solo
  middleware in allowlist.

---
title: "Contratto — ValidatePageMiddlewareAction"
type: contract
action: "Modules\Cms\Actions\ValidatePageMiddlewareAction"
tags: [contract, action, cms, middleware, sicurezza]
created: 2026-11-24
updated: 2026-11-24
---

# ValidatePageMiddlewareAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/ValidatePageMiddlewareAction.php`. Perche': [ADR](../adr/page-middleware-allowlist.md).
Chiamante: `app/Http/Middleware/PageSlugMiddleware.php`. Action pura, con contratto perche' e' un confine di sicurezza.

## Input

- `$declared`: lista dei middleware letti dal campo `middleware` del JSON della pagina (es. `['auth', 'throttle:10,1']`).
- Implicito: `cms.config.page_middleware_allowlist`.

## Output

- La stessa lista, invariata, se ogni voce e' ammessa.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| CMS-PAGE-MIDDLEWARE-INV-1 | Si confronta il nome prima dei `:` in modo esatto (maiuscole, spazi, prefissi contano); fuori allowlist = eccezione. | `CMS-PAGE-MIDDLEWARE-INV-1` |
| CMS-PAGE-MIDDLEWARE-INV-2 | Un solo nome non ammesso rifiuta l'intera lista. | `CMS-PAGE-MIDDLEWARE-INV-2` |
| CMS-PAGE-MIDDLEWARE-INV-3 | `web` passa sempre: e' gia' applicato dallo stack Folio. | `CMS-PAGE-MIDDLEWARE-INV-3` |
| CMS-PAGE-MIDDLEWARE-INV-4 | L'allowlist viene solo dalla config; se non e' un array, non passa nulla tranne `web`. | `CMS-PAGE-MIDDLEWARE-INV-4` |

## Effetti collaterali

- Nessuno.

## Errori

- `InvalidArgumentException` al primo middleware non ammesso, con il nome e l'elenco ammesso nel messaggio.
  `PageSlugMiddleware` la trasforma in 503 con log.

## Non fa

- Non verifica che il middleware esista o sia risolvibile (lo fa `PageSlugMiddleware::assertResolvable`).
- Non applica i middleware.
- Non legge il JSON: riceve la lista gia' estratta.

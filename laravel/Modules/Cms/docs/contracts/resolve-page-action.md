---
title: "Contratto — ResolvePageAction"
type: contract
action: "Modules\Cms\Actions\ResolvePageAction"
tags: [contract, action, cms, folio, sicurezza]
created: 2026-11-24
updated: 2026-11-24
---

# ResolvePageAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/ResolvePageAction.php`. Perche': [ADR](../adr/container0-model-allowlist.md).
Chiamante: pagina Folio del tema `[container0]/[slug0]`.

## Input

- `$container0`, `$slug0`: i due segmenti dell'URL dopo la lingua (dati dell'utente, non fidati).

## Output

- `ResolvePageData`: `renderMode` `model` (con `item` e `pageSlug` = `<container0>.view`) oppure `cms` (`item` null, `pageSlug`
  = `<container0>.<slug0>` se esiste quella pagina, altrimenti `<container0>.view` se esiste, altrimenti `<container0>.<slug0>`).

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| CMS-RESOLVE-PAGE-INV-1 | Un contenitore non elencato in `cms.config.container0_models` (ne' `blog`/`events`) non carica alcun modello: niente euristiche sul nome. | `CMS-RESOLVE-PAGE-INV-1` |
| CMS-RESOLVE-PAGE-INV-2 | Un modello elencato e' esposto solo se `Gate::allows('view')` per chi guarda; negato o senza policy e' indistinguibile da non trovato. | `CMS-RESOLVE-PAGE-INV-2` |
| CMS-RESOLVE-PAGE-INV-3 | Il record si legge con `resolveRouteBinding()`: gli scope globali del modello valgono. | `CMS-RESOLVE-PAGE-INV-3` |
| CMS-RESOLVE-PAGE-INV-4 | Una voce di config che non e' una sottoclasse di `Model` e' ignorata. | `CMS-RESOLVE-PAGE-INV-4` |
| CMS-RESOLVE-PAGE-INV-5 | `blog` ed `events` passano solo dai finder Blog dei contenuti pubblicati, del tipo giusto (un post non e' un evento). | `CMS-RESOLVE-PAGE-INV-5` |

## Effetti collaterali

- Solo letture: query sul modello elencato, sul Blog e sulla tabella delle pagine CMS. Nessuna scrittura.

## Errori

- `QueryException` nella lettura del modello (es. chiave di tipo sbagliato): assorbita, risultato come non trovato.
- Altre eccezioni (policy, finder Blog) risalgono alla pagina.

## Non fa

- Non restituisce 404: la pagina Folio decide cosa fare con `item` null e `pageSlug`.
- Non applica i middleware della pagina CMS (lo fa `PageSlugMiddleware` con `ValidatePageMiddlewareAction`).
- Non cerca modelli per altri campi: solo la chiave di rotta del modello.

---
title: "ADR 0011 — @contract docblock reference su Actions"
type: decision
status: accepted
created: 2026-11-23
updated: 2026-11-24
issues:
  - "https://github.com/laraxot/module_xot_fila5/issues/ADR-0011"
qmd: "0011 contract docblock reference actions"
---

# ADR 0011: @contract docblock reference su Actions

## Contesto

Le `Actions` in `Modules/*/app/Actions/` sono classi che contengono logica applicativa da invocare (execute). Molte Action scrivono dati o chiamano servizi esterni, ma mancava una convenzione documentale per riferirsi al contratto comportamentale.

## Decisione

**Ogni Action che scrive dati o chiama servizi esterni deve includere un docblock `@contract` che fa riferimento al file del contratto comportamentale.**

Il docblock segue questo pattern:
```php
/**
 * @see docs/contracts/{nome-action}.md
 * @contract docs/contracts/{nome-action}.md
 */
class SaveTicketAction
```

Se l'Action non scrive dati né chiama servizi esterni, non è necessaria la reference `@contract`.

## Driver della decisione

- il contratto deve essere trovabile dal codice senza duplicare la specifica nel docblock;
- un controllo statico deve poter verificare esistenza e collegamento del file;
- `@see` serve agli IDE, `@contract` è il marker per harness e agenti (vedi [standard di authoring](../contracts/contract-authoring-standard.md)).

## Alternative scartate

- Aggiungere `@contract` a tutte le Action: over-engineering per Action che sono solo wrapper
- Creare un contratto formale per ogni Action: introduce boilerplate inutile
- Documentare inline solo: non riutilizzabile e perdibile nei refactoring

## Conseguenze

### Positive
- Documentazione automatica: `@contract` punta a file markdown viventi
- Caccia all'ignorato: action senza `@contract` viene segnalata dai test
- Coerenza con il pattern `Actions over Services` di questo progetto

### Negative
- Richiede la creazione o la verifica di file `docs/contracts/{NomeAction}.md`
- Alcune Action esistenti dovranno essere aggiornate con la nuova convenzione

## Conferma

`Modules/Xot/tests/Unit/Docs/ActionContractsAreCompleteTest.php` cerca `@contract docs/contracts/<file>.md` nel docblock di ogni Action che ha un contratto. Stato misurato il 2026-11-24: in `Modules/Xot/app/Actions` nessuna delle 238 Action contiene il marker `@contract` (`rg -c "@contract" app/Actions` vuoto): il test non fallisce perché Xot non ha contratti di Action, quindi la regola è oggi non applicata in Xot ed è debito dichiarato (vedi «Backlog contract» in [contracts/index.md](../contracts/index.md)).

Il file `00011-contract-docblock-reference.md` è superseded da questo.

## Cross-link

- `laravel/Modules/*/app/Actions/*.php` — tutte le Action del progetto
- `docs/contracts/` — directory dei contratti comportamentali
- `docs/wiki/rules/actions-over-services.md` — filosofia Actions vs Services
- `laravel/Modules/Xot/tests/Unit/Docs/PackagesHaveContractsAndAdrTest.php` — test di conformità
- `laravel/Modules/Xot/tests/Unit/Docs/ActionContractsAreCompleteTest.php` — test completamento contratti
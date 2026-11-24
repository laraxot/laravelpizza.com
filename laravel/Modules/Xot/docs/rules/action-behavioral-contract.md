---
qmd: "contratto di comportamento action behavioral contract input output invarianti effetti collaterali errori non fa"
title: "Regola — Contratto di comportamento delle Action"
type: rule
module: Xot
tags: [rule, actions, contract, ai-readability, testing]
created: 2026-11-18
updated: 2026-11-18
status: active
related:
  - ../../tests/Unit/Docs/ActionContractsAreCompleteTest.php
  - ../../tests/Unit/Docs/PackagesHaveContractsAndAdrTest.php
---

# Contratto di comportamento delle Action

La logica di business sta nelle Action (`Modules/<Modulo>/app/Actions`). Il nome dice *cosa* fa un'Action; il contratto dice
*cosa promette*: senza, chi la chiama (una persona o un agente AI) deve ricostruirlo leggendo il codice, e sbaglia proprio sui
casi limite. Il contratto e' la regola **scritta**; il test sotto la rende **verificabile**.

## Dove e in che formato

Ogni modulo e tema ha `docs/contracts/` (e `docs/adr/` per il perche' delle scelte). Un file per Action, nome in kebab-case
della classe (`create-ticket-action.md`), frontmatter `type: contract` e `action: "<FQCN>"`, sei sezioni nell'ordine:

```markdown
## Input
## Output
## Invarianti
## Effetti collaterali
## Errori
## Non fa
```

Il docblock dell'Action contiene il marker machine-readable `@contract`, cosi'
chi legge il codice e gli strumenti del progetto trovano il file:

```php
/**
 * Unico punto di creazione di una segnalazione.
 *
 * @contract docs/contracts/create-ticket-action.md
 * Contratto di comportamento (sei sezioni: input, output, invarianti, effetti
 * collaterali, errori, non fa).
 */
```

«Non fa» e' la sezione che evita piu' errori: dice dove *non* cercare un comportamento, e dove cercarlo.

## Quando

- Ogni Action nuova o modificata che scrive dati, chiama un servizio esterno o ha effetti collaterali.
- Le Action pure (formattano, calcolano) possono farne a meno.

## Verifica

- `Modules/Xot/tests/Unit/Docs/ActionContractsAreCompleteTest.php`: ogni `docs/contracts/*.md` con `type: contract` ha le sei
  sezioni nell'ordine, la sua `action` esiste e il docblock dell'Action contiene `@contract`; le Action dei moduli condivisi
  nell'elenco `REQUIRED` hanno il contratto.
- Il modulo del progetto elenca le proprie Action obbligatorie nel suo test (es. `tests/Unit/ActionContractsTest.php`).
- `Modules/Xot/tests/Unit/Docs/PackagesHaveContractsAndAdrTest.php`: ogni modulo e tema ha `docs/contracts/` e `docs/adr/`;
  ogni ADR ha Contesto, Decisione, Alternative scartate, Conseguenze.

Un contratto che non corrisponde piu' al codice e' peggio di nessun contratto: chi cambia il comportamento aggiorna il
contratto nello stesso commit, e il test dell'Action prova le righe del contratto.

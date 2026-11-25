---
title: "Architecture Decision Records"
type: index
tags: [adr, decisioni]
created: 2026-11-18
updated: 2026-11-24
qmd: "xot adr architecture decision records indice metodo harness decisioni"
---

# Architecture Decision Records

## Metodo Harness

Scrivere un ADR solo per una scelta difficile da invertire, sorprendente o fondata su un trade-off reale. Un ADR deve rendere leggibili contesto, driver, alternative, decisione, conseguenze e una conferma ripetibile; non è un diario né una spiegazione retroattiva inventata.

Le decisioni vanno verificate contro codice e test correnti. Una modifica sostanziale crea un nuovo ADR e collega il precedente come superseded/deprecated.

Il **perche'** delle scelte di questo pacchetto: una decisione per file, con le
alternative scartate. **Ogni ADR ha basename `NNNN-slug.md`** (harness MADR);
non si usano date o timestamp nel nome (la data sta nella frontmatter).

Ispirazione obbligatoria:
[harness 0000-template](https://raw.githubusercontent.com/robertogallea/laravelday-harness-workshop/refs/heads/main/docs/adr/0000-template.md)
· copia locale [0000-template.md](./0000-template.md).

Eccezioni al prefisso numerico: `README.md`, `INDEX.md`/`index.md`, `0000-template.md`.

## Formato (MADR breve / harness)

```markdown
---
status: proposed | accepted | rejected | deprecated | superseded by NNNN
date: YYYY-MM-DD
decision-makers:
---

# <!-- problema + soluzione -->

## Context and Problem Statement
## Decision Drivers
## Considered Options
## Decision Outcome
### Consequences
### Confirmation
```

File: `docs/adr/NNNN-titolo-con-trattini.md` (NNNN a 4 cifre, prossimo libero).

## Sezioni obbligatorie e deroghe

Ogni ADR non superseded ha, in questo ordine o equivalente: `## Contesto`, `## Driver della decisione`, `## Alternative scartate`, `## Decisione`, `## Conseguenze`, `## Conferma`. Una sezione può mancare solo con una deroga dichiarata nel file (esempio: [0010](0010-no-ticket-logic-in-page-slug-middleware.md), dove la Conferma non è eseguibile in Xot). Il modello breve in stile MADR è [0000-template](0000-template.md) (intestazioni inglesi: lo si adatta alle sezioni italiane qui sopra).

La governance dei contratti comportamentali, collegati agli ADR tramite invarianti con ID stabile e gruppo Pest, è la decisione [0012](0012-behavioral-contract-governance.md); gli indici sono in [../contracts/index.md](../contracts/INDEX.md).

## Duplicati e superseded

Un file duplicato non si cancella: riceve `status: superseded by <canonico>.md` nella frontmatter e, in cima al corpo, la riga «Superseded da ...». Il canonico è la versione numerata. Nei nomi file non ci sono date né timestamp.

## Decisioni

L'elenco completo, con numero, stato e canonico/superseded, è in [index.md](index.md): è l'unico inventario e va aggiornato nello stesso commit che aggiunge o modifica un ADR.

Regola tipizzazione trasversale (tutti i moduli): [0014 — `mixed` solo come ultima spiaggia](0014-mixed-last-resort.md).

## Decisioni precedenti (formato libero, non ancora ADR)

- [module-admin-role-policy-bypass](../wiki/decisions/module-admin-role-policy-bypass.md)
- [security-middleware-csrf-order](../wiki/decisions/security-middleware-csrf-order.md)

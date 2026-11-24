---
title: "Architecture Decision Records"
type: index
tags: [adr, decisioni]
created: 2026-11-18
updated: 2026-11-24
---

# Architecture Decision Records

## Metodo Harness

Scrivere un ADR solo per una scelta difficile da invertire, sorprendente o fondata su un trade-off reale. Un ADR deve rendere leggibili contesto, driver, alternative, decisione, conseguenze e una conferma ripetibile; non è un diario né una spiegazione retroattiva inventata.

Le decisioni vanno verificate contro codice e test correnti. Una modifica sostanziale crea un nuovo ADR e collega il precedente come superseded/deprecated.

Il **perche'** delle scelte di questo pacchetto: una decisione per file, con le
alternative scartate. I numeri sequenziali sono ammessi per gli ADR canonici;
non si usano date o timestamp nel nome (la data sta nella frontmatter).

## Formato

```markdown
---
title: "ADR — <decisione in una riga>"
type: decision
status: proposed | accepted | deprecated | superseded by <file-canonico>.md
superseded_by: <file-canonico>.md   # solo se superseded
created: AAAA-MM-GG
updated: AAAA-MM-GG
issues: []
---

# ADR: <decisione>

## Contesto
Fatti e vincoli che hanno reso necessaria la scelta (misure, norme, policy, incidenti).

## Driver della decisione
Vincoli e forze che pesano sulla scelta.

## Decisione
Cosa si fa, in concreto, e dove sta nel codice.

## Alternative scartate
Ogni alternativa seria, con il motivo per cui non e' stata scelta.

## Conseguenze
Pro, contro, debito che resta, cosa misurare. Chi cambia la decisione scrive un nuovo ADR e segna questo `superseded`.

## Conferma
Test, audit o controllo ripetibile che dimostra il rispetto della decisione.
```

## Sezioni obbligatorie e deroghe

Ogni ADR non superseded ha, in questo ordine o equivalente: `## Contesto`, `## Driver della decisione`, `## Alternative scartate`, `## Decisione`, `## Conseguenze`, `## Conferma`. Una sezione può mancare solo con una deroga dichiarata nel file (esempio: [0010](0010-no-ticket-logic-in-page-slug-middleware.md), dove la Conferma non è eseguibile in Xot). Il modello breve in stile MADR è [0000-template](0000-template.md) (intestazioni inglesi: lo si adatta alle sezioni italiane qui sopra).

La governance dei contratti comportamentali, collegati agli ADR tramite invarianti con ID stabile e gruppo Pest, è la decisione [0012](0012-behavioral-contract-governance.md); gli indici sono in [../contracts/INDEX.md](../contracts/INDEX.md).

## Duplicati e superseded

Un file duplicato non si cancella: riceve `status: superseded by <canonico>.md` nella frontmatter e, in cima al corpo, la riga «Superseded da ...». Il canonico è la versione numerata. Nei nomi file non ci sono date né timestamp.

## Decisioni

L'elenco completo, con numero, stato e canonico/superseded, è in [INDEX.md](INDEX.md): è l'unico inventario e va aggiornato nello stesso commit che aggiunge o modifica un ADR.

## Decisioni precedenti (formato libero, non ancora ADR)

- [module-admin-role-policy-bypass](../wiki/decisions/module-admin-role-policy-bypass.md)
- [security-middleware-csrf-order](../wiki/decisions/security-middleware-csrf-order.md)

---
title: "Contratti"
type: index
tags: [contracts, actions, interfaces]
created: 2026-11-18
updated: 2026-11-23
qmd: "contratti"
---

# Contratti

## Metodo Harness

Un contratto descrive una singola operazione pubblica con effetti collaterali, chiamate esterne o invarianti di dominio. Documenta il comportamento osservabile, inclusi errori e non-goals, senza trasformare ogni metodo interno in un contratto.

Ogni invariante ha un ID stabile nel formato `XOT-INV-N`; il test Pest corrispondente usa lo stesso ID come group. La classe implementatrice deve contenere `@contract docs/contracts/<file>.md`; contratto, codice e test cambiano nello stesso commit.

Cosa promette la superficie pubblica di questo pacchetto: le classi base `XotBase*` che gli altri moduli estendono,
le Action che scrivono dati, chiamano servizi esterni o hanno effetti collaterali, e le interfacce (`app/Contracts`).
Regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`.

## Classi base

- [Contratto delle classi XotBase](xotbase-classes.md) — cosa garantiscono a chi le estende, cosa pretendono in
  cambio, le due trappole note (`registerConfig()` non ricorsiva, `tableUpdate()` che crea la tabella) e come si
  verifica una modifica che le tocca.

## Contratto di comportamento di un'Action

Un file per Action, nome in kebab-case della classe (`create-ticket-action.md`), frontmatter `type: contract` e
`action: <FQCN>`, e queste sei sezioni nell'ordine:

```markdown
## Input
## Output
## Invarianti
## Effetti collaterali
## Errori
## Non fa
```

Il docblock dell'Action rimanda al file con il marker machine-readable
`@contract docs/contracts/<file>.md`. La frase descrittiva legacy può restare,
ma il marker è il collegamento verificato dai test.
Chi cambia il comportamento aggiorna il contratto nello stesso commit.

Ogni invariante ha un ID stabile nel formato `<OWNER>-<OPERAZIONE>-INV-<N>` e
indica il group Pest omonimo. Il test dell'invariante usa
`->group('<OWNER>-<OPERAZIONE>-INV-<N>')`, così la conferma mirata è
`vendor/bin/pest --group=<ID>`. Il [template operativo](behavioral-contract-template.md)
contiene la tabella minima di mapping fra regola, group e test.

## Contratti

- [Standard di authoring dei contratti](contract-authoring-standard.md)
- [Template per Behavioral Contract](behavioral-contract-template.md) — IDs, gruppi Pest e comando di conferma
- [ADR degli entrypoint di route vuoti](../adr/0036-route-entrypoints-canonical-empty.md) — gli entrypoint senza route
  restano presenti e delegano al percorso canonico senza registrare route.


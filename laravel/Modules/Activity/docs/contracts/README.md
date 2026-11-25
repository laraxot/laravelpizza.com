---
title: "Contratti del modulo Activity"
type: index
module: Activity
status: active
created: 2026-11-18
updated: 2026-11-25
qmd: "activity contracts readme formato contratto di comportamento azioni invarianti marker contract docblock"
---

# Contratti del modulo Activity

Un contratto descrive il comportamento promesso da una Action con effetti collaterali o invarianti di dominio: cosa riceve, cosa restituisce, cosa garantisce, cosa tocca, quando fallisce e cosa **non** fa. Regola e governance: `Modules/Xot/docs/rules/action-behavioral-contract.md`.

## Formato

Un file per Action, nome in kebab-case della classe (`log-activity-action.md`), frontmatter con `type: contract` e `action: "Modules\\Activity\\Actions\\..."`, e queste sei sezioni nell'ordine:

```markdown
## Input
## Output
## Invarianti
## Effetti collaterali
## Errori
## Non fa
```

Gli invarianti hanno ID `ACTIVITY-<AREA>-INV-<N>` e il test Pest che li verifica usa lo stesso ID come `->group('<ID>')`. Il docblock dell'Action rimanda al file con `@contract docs/contracts/<file>.md`; chi cambia il comportamento aggiorna contratto, codice e test nello stesso commit. Il test `Modules/Xot/tests/Unit/Docs/ActionContractsAreCompleteTest.php` controlla che ogni file `type: contract` abbia le sei sezioni, un'`action:` esistente e il `@contract` nel docblock di quella classe.

## Quali Action hanno un file

Sei Action sono pubbliche e delicate (scrittura del registro, ripristino di un record, accesso ai file di log): hanno un file proprio, elencato in [index.md](./index.md). Le altre 24 Action del modulo hanno un contratto sintetico nella pagina [../actions.md](../actions.md), che e' il bersaglio dei loro tag `@see` e `@contract`. Se una di esse acquista effetti collaterali rilevanti (dati personali, servizi esterni), si estrae in un file qui e si aggiorna il docblock.

Le decisioni dietro i contratti stanno in [../adr/](../adr/README.md).

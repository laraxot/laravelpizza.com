---
title: "trova esclusi criteri per anno"
type: concept
module: Ptv
tags: [trova-esclusi, criteri-esclusione, criteri-option, scheda-contract, refactor]
created: 2026-06-18
updated: 2026-06-18
qmd: "TrovaEsclusiByModelClassYearAction getCriteriEsclusioneByYear SchedaContract CriteriOption"
issues:
  - "https://github.com/provtv/module_ptv_fila5/issues/TBD"
discussions:
  - "https://github.com/provtv/module_ptv_fila5/discussions/TBD"
related:
  - ./trova-esclusi-gg-cascade.md
  - ./getter-by-year-naming.md
  - ./phpstan-scheda-actions.md
  - ./scheda-contract-inheritance.md
  - ../../../../../../docs/chat/analisi-trova-esclusi-criteri-refactor.md
  - ../../../../../../docs/wiki/patterns/bugfix-business-logic-before-type.md
---

# Trova esclusi: criteri per anno

## Scopo

`TrovaEsclusiByModelClassYearAction` carica **una volta per batch** i criteri di esclusione e le options dell'anno, poi valuta ogni scheda via `Check`.

## API su SchedaContract

Static su `SchedaContract`, implementati su `BaseScheda` — naming [getter-by-year](./getter-by-year-naming.md):

- `getCriteriEsclusioneByYear(int $year, string $fieldName = 'anno')`
- `getCriteriOptionsParsedByYear(int $year, string $fieldName = 'anno')`

L'action usa `class-string<SchedaContract>`: `SchedaContract` estende `ModelContract`, quindi un check aggiuntivo su `Model` è ridondante.

Test: `Modules/Ptv/tests/Unit/Models/BaseSchedaCriteriByYearTest.php`

## GitHub

```bash
gh auth login
bash bashscripts/ai/gh-ptv-trova-esclusi-criteri-refactor-audit.sh
```

Analisi: [analisi-trova-esclusi-criteri-refactor.md](../../../../../../docs/chat/analisi-trova-esclusi-criteri-refactor.md)

## Collegamenti

- [trova-esclusi-gg-cascade](./trova-esclusi-gg-cascade.md)
- [getter-by-year-naming](./getter-by-year-naming.md)
- [scheda-contract-inheritance](./scheda-contract-inheritance.md)
- [phpstan-scheda-actions](./phpstan-scheda-actions.md)

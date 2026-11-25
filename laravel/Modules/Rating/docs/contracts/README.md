---
title: "Contratti — Rating"
type: index
owner: Rating
updated: 2026-11-24
qmd: "Rating contract comportamentali valutazioni dati personali policy aggregazioni invarianti RATING-INV"
---

# Contratti — Rating

Un contract descrive un'operazione di Rating che tocca valutazioni (dati personali di performance) o ne regola l'accesso. Documenta il comportamento **implementato**. Standard: [contract-authoring-standard](../../../Xot/docs/contracts/contract-authoring-standard.md); governance: [ADR 0012](../../../Xot/docs/adr/0012-behavioral-contract-governance.md).

## Formato

Per le Action: frontmatter `type: contract` e `action: "Modules\\Rating\\Actions\\..."`, sezioni `## Input`, `## Output`, `## Invarianti`, `## Effetti collaterali`, `## Errori`, `## Non fa`. Per la policy: `type: policy-contract` e `contract: <FQCN>` (standard, sezione «Contratti non-Action»). Invarianti con ID `RATING-<AREA>-INV-<N>` e test Pest con `->group('<ID>')`. Registro: [INDEX.md](index.md).

## File presenti

- [get-sum-by-model-rating-id-action](get-sum-by-model-rating-id-action.md)
- [get-count-by-model-rating-id-action](get-count-by-model-rating-id-action.md)
- [rating-morph-policy](rating-morph-policy.md) (policy-contract)

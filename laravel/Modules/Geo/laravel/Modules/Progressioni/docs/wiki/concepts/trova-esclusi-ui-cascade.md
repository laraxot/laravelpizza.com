---
title: "trova esclusi ui cascade"
type: concept
module: Progressioni
tags: [trova-esclusi, scheda, filament, ptv]
created: 2026-06-18
updated: 2026-06-18
related:
  - ../../../../Ptv/docs/wiki/concepts/trova-esclusi-gg-cascade.md
  - ../../../../Sigma/docs/wiki/concepts/function-extra-relation-query-pattern.md
---

# Trova esclusi (UI Progressioni)

## Scopo

La lista schede Progressioni espone l'azione **Trova esclusi** (header action da modulo Ptv). L'implementazione e la cascata business sono **owned da Ptv + Sigma** — questo modulo ospita solo la risorsa Filament.

## Dove leggere

- Cascata criteri e giorni: [trova-esclusi-gg-cascade](../../../../Ptv/docs/wiki/concepts/trova-esclusi-gg-cascade.md)
- Query `qua00f` / `ggInSedeTot`: [function-extra-relation-query-pattern](../../../../Sigma/docs/wiki/concepts/function-extra-relation-query-pattern.md)

## Verifica manuale

`/progressioni/admin/schedas?filters[anno_valutatore][anno]=YYYY` → azione Trova esclusi (super admin).

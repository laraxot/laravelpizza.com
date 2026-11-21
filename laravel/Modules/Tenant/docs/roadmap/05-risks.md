---
issues: []
discussions: []
title: "Risks - Tenant"
module: "Tenant"
type: concept
tags: [05, risks]
created: 2026-07-14
updated: 2026-07-14
qmd: "05 risks"
related:
  - "./phpstan-corrections-january.md"
---
# Risks - Tenant

## Top Risks

1. Drift tra documentazione e comportamento runtime.
2. Regressioni introdotte da fix rapidi non verificati.
3. Dipendenze incrociate non documentate.

## Mitigations

1. Aggiornare docs insieme ai fix di codice.
2. Usare checklist pre-merge e post-fix.
3. Mantenere un set di file canonici per diagnosi rapida.
---
title: "Profiles ownership boundary rule"
type: rule
tags: [profiles, ownership, boundary, rule]
created: 2026-07-14
updated: 2026-07-14
qmd: "profiles-ownership-boundary-rule profiles ownership boundary rule"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./ai-harness-user-discipline.md"
  - "./baseuser-hierarchy.md"
  - "./code-redundancy-user.md"
  - "./context-mode-user-discipline.md"
  - "./context-overflow-prevention.md"
  - "./filament-langserviceprovider-governance.md"
  - "./filament-widget-linear-crud-model-create.md"
  - "./filament-widget-resource-form-delegation.md"
---

# Profiles ownership boundary rule

## Regola

Nel contesto Laraxot di questo repository, il contratto schema di `profiles` e' owner del modulo Fixcity.

## Implicazioni

- il modulo User non deve introdurre migrazioni additive su `profiles`
- non sono ammessi file con naming `add_*_to_profiles_table.php`
- eventuali cambi al contratto `profiles` passano dalla migrazione canonica `create_profiles_table` owner

## Rationale

- DRY: una sola fonte di verita' per il modello
- KISS: evitare catene additive e ownership ambigua tra moduli
- anti-regressione: prevenire conflitti e rollback complessi

## Riferimenti

- [profiles uuid single migration rule](../../../../../../docs/wiki/concepts/profiles-uuid-single-migration-rule.md)
- [fixcity profiles uuid contract](../../../../Fixcity/docs/wiki/concepts/profiles-uuid-contract.md)

---
title: SaveTenantConfigAction sostituisce le liste invece di fonderle per indice
status: done
module: Tenant (owner)
created: 2026-10-28
repository: "https://github.com/provtv/base_ptv_fila5_mono"
github_issue: "https://github.com/provtv/base_ptv_fila5_mono/issues"
github_discussion: "https://github.com/provtv/base_ptv_fila5_mono/discussions"
related:
  - ../../../Xot/docs/stories/base-setting-page.story.md
---

# SaveTenantConfigAction sostituisce le liste invece di fonderle per indice

## Fase BMAD

Build (fix mirato), emerso progettando `BaseSettingPage` (Xot).

## Problema

`arrayMergeRecursiveDistinct()` fonde ricorsivamente ogni coppia di array. Per una lista
(`[0 => ..., 1 => ...]`) la fusione avviene per indice:

```
esistente: [2023, 2024, 2025]
salvo:     [2026]
risultato: [2026, 2024, 2025]   // 2024 e 2025 non si possono piu' togliere
```

Una lista salvata da un form (TagsInput, CheckboxList, Repeater) e' sempre lo stato completo:
fonderla con la vecchia non ha senso.

## Soluzione

Se il valore nuovo e' una lista (`array_is_list`), sostituisce quello esistente. Gli array
associativi continuano a fondersi ricorsivamente, quindi le chiavi del file non gestite dal
form restano.

## Verifica

- Test: `tests/Unit/Actions/Config/SaveTenantConfigActionTest.php`, caso "replaces lists".
- Pest saltato su 10.100.200.15 (produzione).

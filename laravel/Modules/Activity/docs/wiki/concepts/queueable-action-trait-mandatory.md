---
title: "QueueableAction trait mandatory"
type: concept
module: Activity
tags: [activity, queueable-action, spatie, trait]
created: 2026-07-12
updated: 2026-07-12
qmd: "Activity QueueableAction trait mandatory app Actions Support Adapters"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/372"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - ./queueable-action-execute-entrypoint.md
  - ../../../../../../docs/wiki/rules/queueable-action-trait-mandatory.md
  - ../../../Xot/docs/wiki/concepts/queueable-action-trait-mandatory.md
---

# QueueableAction trait — Activity

## Audit modulo

```bash
bash bashscripts/tools/audit-queueable-action-trait.sh
```

Stato 2026-07-12: **OK** — ogni file in `app/Actions/` ha il trait.

## Fuori da `app/Actions/` (corretto)

| Classe | Path | Motivo |
|--------|------|--------|
| `ActivityLogger` | `app/Adapters/` | Facade multi-metodo (ex-`Support/`, eliminato 2026-07-12) |
| `ActivityRecorder` | `app/Adapters/` | Implementazione interface cross-modulo |

## Canon

- [execute entrypoint](./queueable-action-execute-entrypoint.md)
- [Regola progetto](../../../../../../docs/wiki/rules/queueable-action-trait-mandatory.md)

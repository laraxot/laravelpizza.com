---
title: ripristino policy dopo errore ponytail
type: troubleshooting
confidence: high
updated: 2026-06-30
tags: [job, policy, ponytail-audit, incident]
related:
  - ./model-policy-laravel-contract.md
  - ../../ponytail-audit-over-engineering.md
  - ../../../../../../docs/wiki/concepts/model-policy-laravel-contract.md
  - ../../../../../../docs/wiki/concepts/sacred-artifacts-never-delete.md
---

# Ripristino policy Job — incidente ponytail

## Cosa è successo

Finding ponytail J1 classificava le policy `extends JobBasePolicy {}` come YAGNI eliminabili. **Errore grave**: sono contratto Laravel.

## File ripristinati (da git `abd3e2d7f`)

| Policy | Modello |
|--------|---------|
| `ExportPolicy` | `Export` |
| `ImportPolicy` | `Import` |
| `FailedImportRowPolicy` | `FailedImportRow` |
| `FrequencyPolicy` | `Frequency` |
| `JobManagerPolicy` | `JobManager` |
| `JobsWaitingPolicy` | `JobsWaiting` |
| `ParameterPolicy` | `Parameter` |
| `ResultPolicy` | `Result` |

Stato attuale: **16** file in `app/Models/Policies/` (15 modello + `JobBasePolicy`).

## Forma canonica accettata

`ExportPolicy` può restare minima (`class ExportPolicy extends JobBasePolicy {}`) — confermato dal team.

## Prevenzione

- Hub progetto: [sacred-artifacts-never-delete.md](../../../../../../docs/wiki/concepts/sacred-artifacts-never-delete.md)
- Guard: `bash bashscripts/tools/guard-model-policy-delete.sh`
- Finding J1 rimosso da [ponytail-audit-over-engineering.md](../../ponytail-audit-over-engineering.md)

---
title: "Handoff — Sigma Model Inheritance"
type: handoff
module: Sigma
status: completed
updated: 2026-06-15
related:
  - ../wiki/rules/eloquent-basemodel-hierarchy.md
  - ../../laravel/Modules/Sigma/docs/wiki/concepts/sigma-model-inheritance.md
---

# Handoff: Sigma Model Inheritance — completato

## Stato (2026-06-15)

| Modello | Estensione | Note |
|---------|------------|------|
| Qua00f | `BaseDateRangeModel` | ✅ verificato in codice + PHPStan |
| Qua03f | `BaseDateRangeModel` | ✅ |
| Asz00k1, Asz00f, Rep00f | `BaseDateRangeModel` | ✅ |
| Altri modelli Sigma | `BaseModel` | ✅ zero `extends Model` in `app/Models` |

PHPStan `Modules/Sigma`: **0 errori**.

## Regola CARDINAL

Mai `extends Illuminate\Database\Eloquent\Model` nei modelli applicativi del modulo.

Audit: `bash bashscripts/tools/audit-eloquent-basemodel-hierarchy.sh`

## Riferimenti

- [sigma-model-inheritance](../../laravel/Modules/Sigma/docs/wiki/concepts/sigma-model-inheritance.md)
- [eloquent-basemodel-hierarchy](../wiki/rules/eloquent-basemodel-hierarchy.md)

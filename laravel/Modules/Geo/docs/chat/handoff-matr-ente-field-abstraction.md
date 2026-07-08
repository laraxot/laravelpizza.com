---
title: "Handoff — matrField / enteField"
type: handoff
module: Sigma
status: completed
completed: 2026-06-15
related:
  - ../wiki/rules/model-owned-ente-matr-fields.md
  - ../../laravel/Modules/Sigma/docs/wiki/concepts/ente-matr-field-ownership.md
---

# Handoff: matrField() / enteField() — completato

## Implementato

- Contratto `Modules\Sigma\Models\Contracts\EnteMatrFieldsContract`
- Default su `BaseModel` + helper `hasManyByEnteMatr` / `hasOneByEnteMatr`
- `EnteMatrRelationship` refactorato
- Override: `Dipt00f`, `Wstr01lx`, `Wstr02f`
- Eccezione documentata: `Rep00f::qua00f()` (ente legacy `'90'`)

## Audit

```bash
bash bashscripts/tools/audit-sigma-ente-matr-fields.sh
```

Unico hit atteso: `Rep00f.php` (eccezione).

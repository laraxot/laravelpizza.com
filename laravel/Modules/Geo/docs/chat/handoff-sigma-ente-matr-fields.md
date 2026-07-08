---
title: "Handoff — EnteMatrFieldsContract"
type: chat-handoff
module: Sigma
created: 2026-06-15
related:
  - ../../laravel/Modules/Sigma/docs/wiki/concepts/ente-matr-field-ownership.md
---

# EnteMatrFieldsContract — implementato

## Fatto

- Contratto `EnteMatrFieldsContract` (`matrField`, `enteField`)
- `BaseModel::hasManyByEnteMatr()`
- Refactor `EnteMatrRelationship`, `Dipt00f`, `Sto00f`, `Asz00k1`
- Repo: `git@github.com:laraxot/module_sigma_fila5.git`

## Aperto

- `Rep00f::qua00f()` override legacy (ente `90` + range)
- Altri modelli `Wstr*` con chiavi figlio non standard
- PHPStan Qua00f covariance (4 errori pre-esistenti su HasMany template)

## Verifica

```bash
bash bashscripts/tools/audit-sigma-ente-matr-fields.sh
bash bashscripts/tools/phpstan-module.sh Sigma
```

---
title: "Case Sensitivity Rules - Lang Module"
module: "Lang"
type: rule
tags: [migrazione, filament, 4]
created: 2026-07-14
updated: 2026-07-14
qmd: "migrazione filament 4"
related:
  - "./italian-text-refined-audit-report.md"
---
# Case Sensitivity Rules - Lang Module

## Problema / Problem

**NON possono esistere file con lo stesso nome che differiscono solo per maiuscole/minuscole nella stessa directory.**

Riferimento completo: [Xot Module Case Sensitivity Rules](../../xot/docs/case-sensitivity-rules.md)

## File/Directory Rimossi da Lang Module

I seguenti file/directory sono stati eliminati perché violavano le regole:

```
✗ Removed: database/Migrations/ (entire directory)
✗ Removed: database/migrations/Migrations/ (nested anti-pattern — 2026-07-01)
✓ Kept:    database/migrations/ (flat, solo file .php)
```

Dettaglio incidente e verifica: [wiki/concepts/migration-path-canonical.md](wiki/concepts/migration-path-canonical.md).

## Convenzioni

### Directory Structure
- **Formato**: lowercase
- **Esempio**: `database/migrations/`
- ❌ **Errato**: `database/Migrations/`, `Database/Migrations/`, `database/migrations/Migrations/`

### Motivazione

Laravel usa la convenzione `database/migrations/` (lowercase) per:
1. Compatibilità con filesystem Unix/Linux
2. Standard della community
3. Compatibilità con Artisan commands (`php artisan make:migration`)

## Update Log

- **2025-11-04**: Removed `database/Migrations/` uppercase directory
- **2026-07-01**: Removed nested `database/migrations/Migrations/` (reintroduced per errore automazione in `f840e0cc0`; fix `247054abb`)

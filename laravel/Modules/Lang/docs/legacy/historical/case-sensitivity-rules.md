# Case Sensitivity Rules - Lang Module

## Problema / Problem

**NON possono esistere file con lo stesso nome che differiscono solo per maiuscole/minuscole nella stessa directory.**

Riferimento completo: [Xot Module Case Sensitivity Rules](../../Xot/docs/case-sensitivity-rules.md)

## File/Directory Rimossi da Lang Module

I seguenti file/directory sono stati eliminati perché violavano le regole:

```
✗ Removed: database/Migrations/ (entire directory)
✓ Kept:    database/migrations/
```

## Convenzioni

### Directory Structure
- **Formato**: lowercase
- **Esempio**: `database/migrations/`
- ❌ **Errato**: `database/Migrations/`, `Database/Migrations/`

### Motivazione

Laravel usa la convenzione `database/migrations/` (lowercase) per:
1. Compatibilità con filesystem Unix/Linux
2. Standard della community
3. Compatibilità con Artisan commands (`php artisan make:migration`)

## Update Log

- **2025-11-04**: Removed `database/Migrations/` uppercase directory

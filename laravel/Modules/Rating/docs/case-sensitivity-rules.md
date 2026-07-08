# Case Sensitivity Rules - Rating Module

## Problema / Problem

**NON possono esistere file con lo stesso nome che differiscono solo per maiuscole/minuscole nella stessa directory.**

Riferimento completo: [Xot Module Case Sensitivity Rules](../../Xot/docs/case-sensitivity-rules.md)

## File/Directory Rimossi da Rating Module

I seguenti file/directory sono stati eliminati perché violavano le regole:

```
✗ Removed: database/Seeders/ (entire directory)
✓ Kept:    database/seeders/
```

## Convenzioni

### Directory Structure
- **Formato**: lowercase
- **Esempio**: `database/seeders/`
- ❌ **Errato**: `database/Seeders/`, `Database/Seeders/`

### Motivazione

Laravel usa la convenzione `database/seeders/` (lowercase) per:
1. Compatibilità con filesystem Unix/Linux
2. Standard della community Laravel
3. Compatibilità con Artisan commands (`php artisan make:seeder`)
4. Coerenza con altre directory Laravel (migrations, factories)

## Update Log

- **2025-11-04**: Removed `database/Seeders/` uppercase directory

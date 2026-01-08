# Case Sensitivity Rules - Gdpr Module

## Problema / Problem

**NON possono esistere file con lo stesso nome che differiscono solo per maiuscole/minuscole nella stessa directory.**

Riferimento completo: [Xot Module Case Sensitivity Rules](../../Xot/docs/case-sensitivity-rules.md)

## File Rimossi da Gdpr Module

I seguenti file sono stati eliminati perché violavano le regole:

```
✗ Removed: tests/Feature/conflictresolutiontest.php
✓ Kept:    tests/Feature/ConflictResolutionTest.php
```

## Convenzioni

### Test Files
- **Formato**: PascalCase
- **Esempio**: `ConflictResolutionTest.php`
- ❌ **Errato**: `conflictresolutiontest.php`

## Verifica / Check

Per verificare che non ci siano duplicati case-insensitive nel modulo:

```bash
cd /var/www/_bases/base_ptvx_fila4_mono/laravel/Modules/Gdpr
# See Xot/docs/case-sensitivity-rules.md for the verification script
```

## Update Log

- **2025-11-04**: Removed `conflictresolutiontest.php` duplicate

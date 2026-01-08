# Case Sensitivity Rules - Tenant Module

## Problema / Problem

**NON possono esistere file con lo stesso nome che differiscono solo per maiuscole/minuscole nella stessa directory.**

Riferimento completo: [Xot Module Case Sensitivity Rules](../../Xot/docs/case-sensitivity-rules.md)

## File/Directory Rimossi da Tenant Module

I seguenti file/directory sono stati eliminati perché violavano le regole:

### Directory Structure
```
✗ Removed: database/Factories/ (entire directory)
✓ Kept:    database/factories/

✗ Removed: Tests/ (entire directory)
✓ Kept:    tests/
```

### Test Files
```
✗ Removed: tests/Unit/domaintest.php
✓ Kept:    tests/Unit/DomainTest.php
```

## Convenzioni

### Directory Structure
- **Formato**: lowercase
- **Esempi**:
  - `database/factories/`
  - `tests/`
- ❌ **Errato**:
  - `database/Factories/`, `Database/Factories/`
  - `Tests/`

### Test Files
- **Formato**: PascalCase
- **Esempio**: `DomainTest.php`
- ❌ **Errato**: `domaintest.php`

### Motivazione

Laravel usa le convenzioni lowercase per directory:
1. `database/factories/` - Standard Laravel
2. `tests/` - Standard PHPUnit/Pest
3. Compatibilità con Artisan commands
4. Standard Unix/Linux

## Update Log

- **2025-11-04**: Major cleanup
  - Removed `database/Factories/` uppercase directory
  - Removed `Tests/` uppercase directory
  - Removed `domaintest.php` lowercase test file

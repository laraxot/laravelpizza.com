# Case Sensitivity Rules - Media Module

## Problema / Problem

**NON possono esistere file con lo stesso nome che differiscono solo per maiuscole/minuscole nella stessa directory.**

Riferimento completo: [Xot Module Case Sensitivity Rules](../../Xot/docs/case-sensitivity-rules.md)

## File Rimossi da Media Module

I seguenti file sono stati eliminati perché violavano le regole:

```
✗ Removed: tests/Filament/Resources/mediaconvertresourcetest.php
✓ Kept:    tests/Filament/Resources/MediaConvertResourceTest.php
```

## Convenzioni

### Test Files (Filament Resources)
- **Formato**: PascalCase
- **Esempio**: `MediaConvertResourceTest.php`
- ❌ **Errato**: `mediaconvertresourcetest.php`

## Update Log

- **2025-11-04**: Removed `mediaconvertresourcetest.php` duplicate

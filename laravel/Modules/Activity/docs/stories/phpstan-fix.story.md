# BMAD Story — Activity PHPStan Fix

## Understand
- **Modulo**: Activity
- **Errori**: 71 (analisi aggiornata)
- **Tipologia**: mixed cast, method calls
- **Regola**: `mixed` -> tipi concreti; cast sicuri

## Plan
1. Analizzare errori in dettaglio
2. Sistematizzare fix
3. Verificare con phpstan + git sync

## Implement

### Step 1: Analisi
```bash
./vendor/bin/phpstan analyse Modules/Activity --error-format=table 2>&1 | head -100
```

### Step 2: Fix Pattern
```php
// Mixed cast
is_numeric($value) ? (int) $value : 0

// Method call su mixed
if ($obj instanceof Class) {
    $obj->method();
}
```

## Verify
- [ ] Activity: 0 errori
- [ ] Git sync completato

## Status
- [ ] Da iniziare

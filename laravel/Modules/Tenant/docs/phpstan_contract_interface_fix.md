# PHPStan Contract Interface Fix

## Problem
PHPStan Level 10 non riusciva a risolvere i metodi del trait `SushiToJsons` quando chiamati dalle closures `bootSushiToJsons()`.

**Error Pattern:**
```
Call to an undefined method
Modules\Cms\Models\PageContent::getJsonFile().
```

## Root Cause Analysis

Il problema era causato da due fattori:

1. **Interfaccia Mancante**: I modelli implementavano `SushiToJsonsContract` ma l'interfaccia non esisteva fisicamente nel filesystem.
2. **Metodi Non Dichiarati nell'Interfaccia**: PHPStan Level 10 richiede che TUTTI i metodi accessibili siano dichiarati nell'interfaccia.

## Solution

### 1. Create the Interface

Creato `Modules/Tenant/Contracts/SushiToJsonsContract.php`:

```php
<?php

declare(strict_types=1);

namespace Modules\Tenant\Contracts;

/**
 * Interface SushiToJsonsContract.
 *
 * @property array<string, mixed> $schema
 */
interface SushiToJsonsContract
{
    /**
     * Ottiene il percorso del file JSON per il modello corrente.
     *
     * @return string
     */
    public function getJsonFile(): string;

    /**
     * Ottiene i dati dal file JSON per il modello Sushi.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getSushiRows(): array;
}
```

### 2. Fix Function Namespace Issue

Rimosso l'import errato di `authId` poiché la funzione è definita nello scope globale in `Modules/Xot/helpers/Helper.php`:

```php
// ❌ WRONG - La funzione non è nel namespace Modules\Xot\Helpers
use function Modules\Xot\Helpers\authId;

// ✅ CORRECT - Chiamare direttamente la funzione globale
authId();
```

## Key Lessons

### 1. PHPStan Level 10 Interface Completeness
**CRITICAL RULE**: Ogni interfaccia implementata dai modelli DEVE:
- Esistere fisicamente nel filesystem
- Dichiarare TUTTI i metodi pubblici che verranno chiamati
- Avere return type annotations complete
- Avere PHPDoc completo con @property tags

### 2. Function Namespace Resolution
- Le funzioni definite senza `namespace` nello scope globale sono accessibili direttamente
- Non creare import `use function` per funzioni che non sono in un namespace
- Verificare sempre se la funzione è definita con o senza namespace prima di importarla

### 3. DRY Principle Violation Prevention
**NEVER** duplicare metodi in più modelli quando basta aggiungerli UNA VOLTA nel trait o nell'interfaccia.

## Results

### Before Fix
```
[ERROR] Found 154 errors
- 9 errors in SushiToJsons trait (method.notFound)
```

### After Fix
```
[OK] No errors
```

## Files Modified

1. ✅ `Modules/Tenant/Contracts/SushiToJsonsContract.php` - CREATED
2. ✅ `Modules/Tenant/app/Models/Traits/SushiToJsons.php` - Fixed authId namespace
3. ✅ `Modules/Cms/app/Models/Attachment.php` - Implements SushiToJsonsContract
4. ✅ `Modules/Cms/app/Models/Menu.php` - Implements SushiToJsonsContract
5. ✅ `Modules/Cms/app/Models/PageContent.php` - Implements SushiToJsonsContract
6. ✅ `Modules/Cms/app/Models/Section.php` - Implements SushiToJsonsContract

## Compliance

✅ DRY (Don't Repeat Yourself) - Methods defined once in trait
✅ KISS (Keep It Simple, Stupid) - Simple interface with clear contracts
✅ PHPStan Level 10 - Full type safety compliance
✅ SOLID - Interface segregation with focused contracts
✅ Laraxot Zen - Follows architectural patterns
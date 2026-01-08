# PHPStan Corrections - Geo Module - Gennaio 2026

**Data**: 2026-01-02  
**Status**: ✅ COMPLETATO  
**Errori corretti**: Da 13 a 0

## File corretti

### 1. database/factories/GeoNamesCapFactory.php

**Problema**: Import duplicato di `GeoNamesCap` (righe 8 e 9)

**Soluzione**: Rimosso import duplicato

```php
// ❌ PRIMA
use Modules\Geo\Models\GeoNamesCap;
use Modules\Geo\Models\GeoNamesCap;

// ✅ DOPO
use Modules\Geo\Models\GeoNamesCap;
```

### 2. app/Actions/UpdateClientCoordinatesBulkAction.php

**Problema**: 
- PHPDoc errato: `Collection<int, Client>` invece di `Collection<int, Address>`
- Check ridondanti: `is_string()` su tipi già ristretti

**Soluzione**:
```php
// ❌ PRIMA
/**
 * @param  Collection<int, Client>  $clients
 */
public function execute(Collection $addresses): array
{
    // ...
    $addressName = is_string($address->name) ? $address->name : 'Unknown';
    $errorMsg = $errors->implode(', ') ?: 'Errore sconosciuto';
}

// ✅ DOPO
/**
 * @param  Collection<int, Address>  $addresses
 */
public function execute(Collection $addresses): array
{
    // ...
    // PHPStan L10: $address->name è già string|null, non serve is_string()
    $addressName = $address->name ?? 'Unknown';
    $errors = $this->getAddressDataFromFullAddressAction->getErrors();
    // PHPStan L10: Collection::implode() restituisce string, non serve ?:
    $errorMsg = $errors->implode(', ');
    if ($errorMsg === '') {
        $errorMsg = 'Errore sconosciuto';
    }
}
```

### 3. app/Models/Address.php

**Problema**: 
- `is_string($part)` chiamato su `non-empty-string` (riga 225)
- `is_string($value)` chiamato su `string` (riga 263)

**Soluzione**:
```php
// ❌ PRIMA - is_string() ridondante
], fn ($part): bool => $part !== null && $part !== '' && is_string($part));

// ✅ DOPO - type narrowing corretto
], fn ($part): bool => {
    // PHPStan L10: dopo !== null e !== '', $part è non-empty-string, non serve is_string()
    if ($part === null || $part === '') {
        return false;
    }
    // Verifica che sia string (potrebbe essere int|bool|object)
    return \is_string($part);
});
```

```php
// ❌ PRIMA - is_string() ridondante
if ($value !== null && is_string($value)) {
    return $value;
}

// ✅ DOPO - rimosso check ridondante
// PHPStan L10: $value è già ?string, dopo !== null è string
if ($value !== null) {
    return $value;
}
```

## Pattern Documentati

### array_filter() con Type Narrowing

**Problema**: `array_filter()` con closure che verifica `!== null && !== '' && is_string()` causa errore perché dopo i primi due check, `is_string()` è ridondante.

**Soluzione**: Separare i check in guard clauses:
```php
], fn ($part): bool => {
    if ($part === null || $part === '') {
        return false;
    }
    // Ora verifica il tipo
    return \is_string($part);
});
```

### Collection::implode() Return Type

**Regola**: `Collection::implode()` restituisce sempre `string` (non `string|null`), quindi non serve `?:`:
```php
// ❌ SBAGLIATO
$errorMsg = $errors->implode(', ') ?: 'Errore sconosciuto';

// ✅ CORRETTO
$errorMsg = $errors->implode(', ');
if ($errorMsg === '') {
    $errorMsg = 'Errore sconosciuto';
}
```

## Risultato

- ✅ PHPStan Level 10: 0 errori
- ✅ PHPMD: Nessun problema critico
- ✅ Pint: Formattazione corretta

## Collegamenti

- [Address.php](../../app/Models/Address.php)
- [UpdateClientCoordinatesBulkAction.php](../../app/Actions/UpdateClientCoordinatesBulkAction.php)
- [GeoNamesCapFactory.php](../../database/factories/GeoNamesCapFactory.php)
- [PHPStan Code Quality Guide](../../Xot/docs/phpstan-code-quality-guide.md)

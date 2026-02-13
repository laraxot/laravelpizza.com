# Risoluzione Conflitti Git - Modulo Geo

## Data: 2025-01-06

## File Corretti

### 1. AddressResource.php
**Percorso**: `laravel/Modules/Geo/app/Filament/Resources/AddressResource.php`

**Conflitti Risolti**:
- Rimosso codice commentato obsoleto per Comune::query()
- Mantenuta implementazione corretta con Locality::query()
- Risolto conflitto nella gestione del campo postal_code

**Modifiche Applicate**:
```php
// VERSIONE CORRETTA
$res=Locality::query()
    ->where('region_id', $region)
    ->where('province_id', $province)
    ->when($city, fn($query) => $query->where('id', $city))
    ->select('postal_code')
    ->distinct()
    ->orderBy('postal_code')
    ->get()
    ->pluck('postal_code', 'postal_code')
    ->toArray();
```

### 2. Locality.php
**Percorso**: `laravel/Modules/Geo/app/Models/Locality.php`

**Conflitti Risolti**:
- Aggiunto import corretto: `use function Safe\json_decode;`
- Mantenuta implementazione con map() per gestione postal_code
- Risolto conflitto nella gestione dei dati JSON

**Modifiche Applicate**:
```php
use function Safe\json_decode;

// Nel metodo getRows()
->get()
->map(function($row){
    /** @phpstan-ignore offsetAccess.nonOffsetAccessible, property.notFound */
    $postal_code=json_decode($row->postal_code)[0];
    /** @phpstan-ignore property.notFound */
    $row->postal_code=$postal_code;
    return $row;
});
```

### 3. File di Traduzione
**Percorso**: `laravel/Modules/Geo/lang/en/`

**File Corretti**:
- `webbingbrasil-map.php`: Traduzioni in inglese corrette
- `geo.php`: Traduzioni in inglese per messaggi di errore

**Modifiche Applicate**:
```php
// webbingbrasil-map.php
'label' => 'Webbingbrasil Map',
'group' => 'Territory Management',

// geo.php
'network_error' => 'Network error',
'not_found' => 'Location not found',
```

## File del Tema Two Corretti

### 1. doctor_states.php
**Percorsi**:
- `laravel/Themes/Two/lang/it/doctor_states.php`
- `laravel/Themes/Two/lang/en/doctor_states.php`
- `laravel/Themes/Two/lang/de/doctor_states.php`

**Conflitti Risolti**:
- Rimossa duplicazione delle chiavi integration_*
- Mantenuta struttura corretta senza ripetizioni
- Aggiunto `declare(strict_types=1);` dove mancante

### 2. patient_states.php
**Percorsi**:
- `laravel/Themes/Two/lang/it/patient_states.php`
- `laravel/Themes/Two/lang/en/patient_states.php`
- `laravel/Themes/Two/lang/de/patient_states.php`

**Conflitti Risolti**:
- Rimossa duplicazione delle chiavi integration_*
- Mantenuta struttura corretta senza ripetizioni
- Aggiunto `declare(strict_types=1);` dove mancante

## Verifiche Post-Correzione

### 1. Controllo Conflitti
```bash

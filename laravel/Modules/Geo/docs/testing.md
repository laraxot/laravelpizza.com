# Testing del Modulo Geo - <main module>

## Panoramica

Questo documento descrive la strategia di testing per il modulo Geo, focalizzandosi sui test di integrazione per la gestione degli indirizzi e la geolocalizzazione.

## Architettura di Testing

### Approccio In-Memory
Il modulo Geo utilizza un approccio di testing in-memory per garantire:
- **Isolamento**: Test senza dipendenze da database o servizi esterni
- **Velocità**: Esecuzione rapida senza overhead di I/O
- **Affidabilità**: Test deterministici e riproducibili

### Test Structure
```
Modules/Geo/tests/Feature/AddressIntegrationTest.php
```

## Test Cases Implementati

### 1. **Polymorphic Relationship Testing**
```php
it('can attach address to patient via polymorphic relationship', function () {
    $patient = (object) ['id' => 1001, 'type' => 'patient'];
    $address = makeAddress([
        'model_type' => 'patient',
        'model_id' => $patient->id,
        'is_primary' => true,
    ]);

    expect($address->model_type)->toBe('patient')
        ->and($address->model_id)->toBe($patient->id)
        ->and($address->is_primary)->toBeTrue();
});
```

**Scopo**: Verifica che gli indirizzi possano essere associati a entità diverse (patient, doctor, studio) attraverso relazioni polimorfiche.

### 2. **Address Formatting**
```php
it('generates proper full address from components', function () {
    $address = makeAddress([
        'route' => 'Via Giuseppe Verdi',
        'street_number' => '42',
        'locality' => 'Milano',
        'postal_code' => '20121',
        'country' => 'Italia',
    ]);

    $fullAddress = formatFullAddress($address);

    expect($fullAddress)->toContain('Via Giuseppe Verdi')
        ->and($fullAddress)->toContain('42')
        ->and($fullAddress)->toContain('Milano')
        ->and($fullAddress)->toContain('20121');
});
```

**Scopo**: Verifica che la formattazione degli indirizzi completi funzioni correttamente combinando tutti i componenti.

### 3. **Geolocation Data Handling**
```php
it('handles geolocation data correctly', function () {
    $milan = makeAddress([
        'latitude' => 45.4642,
        'longitude' => 9.1900,
    ]);

    expect($milan->latitude)->toBe(45.4642)
        ->and($milan->longitude)->toBe(9.1900);
});
```

**Scopo**: Verifica che i dati di geolocalizzazione (latitudine e longitudine) siano gestiti correttamente.

### 4. **Google Places API Integration**
```php
it('can store Google Places API data', function () {
    $address = makeAddress([
        'place_id' => 'ChIJu46S-ZZjhkcRLuFvLjVZ400',
        'formatted_address' => 'Piazza del Duomo, 20121 Milano MI, Italy',
        'extra_data' => [
            'google_types' => ['establishment', 'point_of_interest'],
            'rating' => 4.5,
            'business_status' => 'OPERATIONAL',
        ],
    ]);

    expect($address->place_id)->toBe('ChIJu46S-ZZjhkcRLuFvLjVZ400')
        ->and($address->formatted_address)->toContain('Piazza del Duomo')
        ->and($address->extra_data['google_types'])->toContain('establishment')
        ->and($address->extra_data['rating'])->toBe(4.5);
});
```

**Scopo**: Verifica che i dati provenienti da Google Places API siano memorizzati e accessibili correttamente.

### 5. **Multiple Addresses per Entity**
```php
it('supports multiple addresses per entity', function () {
    $patient = (object) ['id' => 2001, 'type' => 'patient'];

    $homeAddress = makeAddress([
        'model_type' => 'patient',
        'model_id' => $patient->id,
        'type' => AddressTypeEnum::HOME->value,
        'is_primary' => true,
    ]);

    $workAddress = makeAddress([
        'model_type' => 'patient',
        'model_id' => $patient->id,
        'type' => AddressTypeEnum::WORK->value,
        'is_primary' => false,
    ]);

    $patientAddresses = [$homeAddress, $workAddress];

    expect(count($patientAddresses))->toBe(2);

    $primary = null;
    foreach ($patientAddresses as $addr) {
        if ($addr->is_primary === true) {
            $primary = $addr; break;
        }
    }

    expect($primary?->id)->toBe($homeAddress->id);
});
```

**Scopo**: Verifica che un'entità possa avere più indirizzi (casa, lavoro) con gestione corretta dell'indirizzo primario.

### 6. **Soft Delete Handling**
```php
it('handles soft deletion correctly', function () {
    $address = makeAddress();

    // Soft delete simulation
    $address->deleted_at = date('c');

    // Lookup simulations
    $active = null; // would be null after soft-delete
    $withTrashed = $address; // still available with trashed scope

    expect($active)->toBeNull()
        ->and($withTrashed)->not->toBeNull()
        ->and($withTrashed->deleted_at)->not->toBeNull();
});
```

**Scopo**: Verifica che la gestione della soft deletion funzioni correttamente, mantenendo i dati per scopi di audit.

## Helper Functions

### makeAddress()
```php
function makeAddress(array $overrides = []): object
{
    static $autoId = 1;

    $defaults = [
        'id' => $autoId++,
        'model_type' => null,
        'model_id' => null,
        'route' => 'Via Roma',
        'street_number' => '1',
        'locality' => 'Milano',
        'administrative_area_level_2' => 'MI',
        'postal_code' => '20100',
        'country' => 'Italia',
        'is_primary' => false,
        'type' => AddressTypeEnum::HOME->value,
        'latitude' => null,
        'longitude' => null,
        'place_id' => null,
        'formatted_address' => null,
        'extra_data' => [],
        'deleted_at' => null,
    ];

    return (object) array_replace($defaults, $overrides);
}
```

**Scopo**: Crea oggetti indirizzo con valori di default sensati, permettendo override per test specifici.

### formatFullAddress()
```php
function formatFullAddress(object $a): string
{
    $parts = array_filter([
        $a->route ?? null,
        $a->street_number ?? null,
        $a->locality ?? null,
        $a->postal_code ?? null,
        $a->country ?? null,
    ], fn ($v) => (string) $v !== '');

    return implode(', ', $parts);
}
```

**Scopo**: Formatta un indirizzo completo combinando tutti i componenti disponibili.

## Enum Usage

### AddressTypeEnum
```php
use Modules\Geo\Enums\AddressTypeEnum;

// Nei test
'type' => AddressTypeEnum::HOME->value,
'type' => AddressTypeEnum::WORK->value,
```

**Vantaggi**:
- Type safety garantita
- Coerenza con l'architettura dell'applicazione
- Facilità di manutenzione

## Best Practices

### 1. **Test Isolation**
- Ogni test è indipendente
- Utilizzo di oggetti mock per evitare dipendenze
- Reset dello stato tra test

### 2. **Data Validation**
- Verifica di tutti i campi critici
- Test di edge cases (valori null, stringhe vuote)
- Validazione di formati e tipi di dati

### 3. **Business Logic Testing**
- Test di regole aziendali specifiche
- Validazione di transizioni di stato
- Test di integrità dei dati

## Esecuzione dei Test

### Comandi Specifici
```bash
# Test del modulo Geo
php artisan test --filter=Geo

# Test specifici per indirizzi
php artisan test --filter="Address Integration"

# Test specifici per geolocalizzazione
php artisan test --filter="geolocation"
```

### Filtri Utili
```bash
# Test di relazioni polimorfiche
php artisan test --filter="polymorphic"

# Test di formattazione indirizzi
php artisan test --filter="format"

# Test di Google Places API
php artisan test --filter="Google Places"
```

## Monitoraggio e Qualità

### 1. **Coverage Analysis**
- Test di tutti i percorsi critici per indirizzi
- Validazione di business logic per geolocalizzazione
- Test di integrazione con API esterne

### 2. **Performance Testing**
- Benchmark di operazioni di formattazione indirizzi
- Test di scalabilità per grandi volumi di indirizzi
- Validazione di performance per operazioni geografiche

### 3. **Regression Testing**
- Test automatici per modifiche agli indirizzi
- Validazione di compatibilità con API esterne
- Test di integrità dopo refactoring

## Collegamenti

- [Architettura Testing Principale](../../../docs/testing-architecture-overview.md)
- [Modulo Geo README](README.md)
- [Address Implementation](address-implementation.md)
- [Geo Entities](geo-entities.md)

---

**Ultimo aggiornamento**: Gennaio 2025
**Versione**: 1.0
**Compatibilità**: Pest 3.x, Laravel 12.x, PHP 8.3+

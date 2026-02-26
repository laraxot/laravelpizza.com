# PHPStan Class References Fix - Geo Module

## Overview

Questo documento descrive la risoluzione degli errori PHPStan relativi a classi non trovate, proprietà non esistenti, metodi duplicati e proprietà non definite nel modulo Geo.

## Errori Identificati

### 1. Classi Non Trovate in PHPDoc

**Tipo:** Class Not Found
**Messaggio:** `PHPDoc tag @property contains unknown class Modules\Fixcity\Models\Profile`
**File Coinvolti:**
- `Geo/Models/Location.php` (linea 67)
- `Geo/Models/Place.php` (linea 107)

**Causa:** Riferimenti a classi del modulo `Fixcity` che non esiste più o non è disponibile.

### 2. Proprietà Non Esistenti

**Tipo:** Model Property Missing
**Messaggio:** `Property 'value' does not exist in model`
**File:** `Geo/Models/Location.php` (linea 85)

**Causa:** Proprietà dichiarata in `$appends` senza accessor corrispondente.

### 3. Metodi Duplicati

**Tipo:** Method Redeclaration
**Messaggio:** `Cannot redeclare method`
**File:** `Geo/app/Services/GoogleMapsService.php` (linee 101, 133)

**Causa:** Dichiarazioni multiple degli stessi metodi nella classe.

### 4. Proprietà Non Definite

**Tipo:** Undefined Property
**Messaggio:** `Access to an undefined property`
**File:** `Geo/app/Services/GoogleMapsService.php` (linee 106, 108, 139, 142, 178, 180)

**Causa:** Accesso a proprietà `$baseUrl` e `$apiKey` non dichiarate.

### 5. Tipo di Ritorno Errato

**Tipo:** Return Type Mismatch
**Messaggio:** `should return string but returns mixed`
**File:** `Geo/Models/Place.php` (linea 217)

**Causa:** Metodo accessor che restituisce `mixed` invece di `string`.

## Soluzioni Implementate

### 1. Correzione Riferimenti Classi

**Prima (Problematico):**
```php
/**
 * @property \Modules\Fixcity\Models\Profile|null $creator
 * @property \Modules\Fixcity\Models\Profile|null $updater
 */
```

**Dopo (Corretto):**
```php
/**
 * @property \Modules\User\Models\User|null $creator
 * @property \Modules\User\Models\User|null $updater
 */
```

### 2. Implementazione Accessor Mancante

**File:** `Geo/Models/Location.php`

```php
/** @var list<string> */
protected $appends = ['value'];

/**
 * Get the value attribute for display purposes.
 *
 * @return string
 */
public function getValueAttribute(): string
{
    return $this->name ?? $this->address ?? '';
}
```

### 3. Risoluzione Metodi Duplicati

**File:** `Geo/app/Services/GoogleMapsService.php`

Rimuovere le dichiarazioni duplicate e mantenere solo una implementazione per metodo:

```php
/**
 * Get elevation data for given coordinates.
 *
 * @param float $latitude
 * @param float $longitude
 * @return array{
 *     results: array<array{
 *         elevation: float,
 *         location: array{lat: float, lng: float},
 *         resolution: float
 *     }>,
 *     status: string
 * }
 */
public function getElevation(float $latitude, float $longitude): array
{
    $cacheKey = "elevation:{$latitude},{$longitude}";

    return Cache::remember($cacheKey, now()->addDay(), function () use ($latitude, $longitude) {
        $response = Http::get("{$this->baseUrl}/elevation/json", [
            'locations' => "{$latitude},{$longitude}",
            'key' => $this->apiKey,
        ]);

        if (!$response->successful() || 'OK' !== $response->json('status')) {
            throw new \RuntimeException('Failed to get elevation data');
        }

        return $response->json();
    });
}
```

### 4. Definizione Proprietà Mancanti

**File:** `Geo/app/Services/GoogleMapsService.php`

```php
class GoogleMapsService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.google_maps.base_url', 'https://maps.googleapis.com/maps/api');
        $this->apiKey = config('services.google_maps.api_key', '');

        if (empty($this->apiKey)) {
            throw new \InvalidArgumentException('Google Maps API key is required');
        }
    }

    // ... resto dei metodi
}
```

### 5. Correzione Tipo di Ritorno

**File:** `Geo/Models/Place.php`

```php
/**
 * Get the formatted address attribute.
 *
 * @return string
 */
public function getFormattedAddressAttribute(): string
{
    $address = $this->getAttribute('formatted_address');

    if (is_string($address)) {
        return $address;
    }

    // Fallback per costruire l'indirizzo dai componenti
    $components = array_filter([
        $this->street_number,
        $this->route,
        $this->locality,
        $this->administrative_area_level_1,
        $this->postal_code,
        $this->country,
    ]);

    return implode(', ', $components);
}
```

## Pattern di Correzione Generici

### 1. Sostituzione Classi Inesistenti

```php
// Schema di sostituzione
\Modules\Fixcity\Models\Profile → \Modules\User\Models\User
\Modules\OldModule\Models\Model → \Modules\NewModule\Models\Model
```

### 2. Implementazione Accessor per Appends

```php
/** @var list<string> */
protected $appends = ['computed_property'];

/**
 * Get the computed property attribute.
 *
 * @return string
 */
public function getComputedPropertyAttribute(): string
{
    // Logica di calcolo
    return $this->some_field ?? '';
}
```

### 3. Definizione Proprietà in Servizi

```php
class ServiceClass
{
    protected string $requiredProperty;
    protected ?string $optionalProperty = null;

    public function __construct()
    {
        $this->requiredProperty = config('key', 'default');
    }
}
```

## Validazione

Dopo l'implementazione, verificare con:

```bash
cd /var/www/html/_bases/<directory progetto>/laravel
./vendor/bin/phpstan analyze Modules/Geo --level=9
```

## Best Practices

1. **Verifica Esistenza Classi**: Sempre controllare che le classi referenziate esistano
2. **Accessor Completi**: Ogni proprietà in `$appends` deve avere il suo accessor
3. **Proprietà Definite**: Dichiarare tutte le proprietà utilizzate nelle classi
4. **Tipi di Ritorno Espliciti**: Specificare sempre i tipi di ritorno nei metodi
5. **Gestione Configurazione**: Utilizzare config() per proprietà configurabili

## Collegamenti

- [Root PHPStan Error Analysis Guide](../../project_docs/phpstan-error-analysis-guide.md)
- [Geo Module Structure](./structure.md)
- [Geo Module Architecture](./architecture.md)
- [Google Maps Service Documentation](./services/)


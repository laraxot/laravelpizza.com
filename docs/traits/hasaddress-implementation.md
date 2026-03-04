# Trait HasAddress

## Panoramica

Il trait `HasAddress` implementa un pattern di progettazione per gestire la relazione polimorfa con gli indirizzi in modo standardizzato e riutilizzabile. Questo trait permette a qualsiasi modello Eloquent di avere uno o più indirizzi associati, con funzionalità complete per la gestione, la ricerca e l'interrogazione degli indirizzi.

## Implementazione

```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Geo\Models\Address;

trait HasAddress
{
    // Implementazione del trait...
}
```

## Relazioni

Il trait `HasAddress` definisce la relazione polimorfa con il modello `Address`:

```php
/**
 * Relazione con gli indirizzi associati a questo modello.
 */
public function addresses(): MorphMany
{
    return $this->morphMany(Address::class, 'model');
}

/**
 * Ottiene l'indirizzo principale.
 */
public function primaryAddress(): ?Address
{
    return $this->addresses()->where('is_primary', true)->first();
}
```

## Metodi di Utilità

### Gestione degli Indirizzi

```php
/**
 * Aggiunge un nuovo indirizzo.
 */
public function addAddress(array $attributes): Address
{
    // Se l'indirizzo è impostato come principale, rimuove questo attributo dagli altri
    if (isset($attributes['is_primary']) && $attributes['is_primary']) {
        $this->addresses()->update(['is_primary' => false]);
    }
    
    return $this->addresses()->create($attributes);
}

/**
 * Imposta un indirizzo come principale.
 */
public function setAsPrimaryAddress(Address $address): void
{
    // Verifica che l'indirizzo appartenga a questo modello
    if ($address->model_id !== $this->id || $address->model_type !== get_class($this)) {
        throw new \InvalidArgumentException('L\'indirizzo non appartiene a questo modello');
    }
    
    // Rimuove l'attributo principale da tutti gli altri indirizzi
    $this->addresses()->where('id', '!=', $address->id)->update(['is_primary' => false]);
    
    // Imposta questo indirizzo come principale
    $address->update(['is_primary' => true]);
}

/**
 * Aggiorna l'indirizzo principale.
 */
public function updatePrimaryAddress(array $attributes): ?Address
{
    $address = $this->primaryAddress();
    
    if ($address) {
        $address->update($attributes);
        return $address->fresh();
    }
    
    // Se non esiste un indirizzo principale, ne crea uno nuovo
    $attributes['is_primary'] = true;
    return $this->addAddress($attributes);
}
```

### Accesso ai Dati degli Indirizzi

```php
/**
 * Ottiene l'indirizzo completo formattato.
 */
public function getFullAddress(): ?string
{
    $address = $this->primaryAddress();
    return $address ? $address->getFullAddressAttribute() : null;
}

/**
 * Ottiene la città dell'indirizzo principale.
 */
public function getCity(): ?string
{
    $address = $this->primaryAddress();
    return $address ? $address->locality : null;
}

/**
 * Ottiene il CAP dell'indirizzo principale.
 */
public function getPostalCode(): ?string
{
    $address = $this->primaryAddress();
    return $address ? $address->postal_code : null;
}

/**
 * Ottiene la provincia dell'indirizzo principale.
 */
public function getProvince(): ?string
{
    $address = $this->primaryAddress();
    return $address ? $address->administrative_area_level_3 : null;
}

/**
 * Ottiene la regione dell'indirizzo principale.
 */
public function getRegion(): ?string
{
    $address = $this->primaryAddress();
    return $address ? $address->administrative_area_level_2 : null;
}

/**
 * Ottiene lo stato/paese dell'indirizzo principale.
 */
public function getCountry(): ?string
{
    $address = $this->primaryAddress();
    return $address ? $address->country : null;
}
```

## Query Scope

Il trait `HasAddress` implementa scope locali che permettono di filtrare i modelli in base alle proprietà degli indirizzi associati:

```php
/**
 * Scope per filtrare i modelli per città.
 */
public function scopeInCity(Builder $query, string $city): Builder
{
    return $query->whereHas('addresses', function (Builder $query) use ($city) {
        $query->where('locality', $city);
    });
}

/**
 * Scope per filtrare i modelli per provincia.
 */
public function scopeInProvince(Builder $query, string $province): Builder
{
    return $query->whereHas('addresses', function (Builder $query) use ($province) {
        $query->where('administrative_area_level_3', $province);
    });
}

/**
 * Scope per filtrare i modelli per regione.
 */
public function scopeInRegion(Builder $query, string $region): Builder
{
    return $query->whereHas('addresses', function (Builder $query) use ($region) {
        $query->where('administrative_area_level_2', $region);
    });
}

/**
 * Scope per filtrare i modelli per CAP.
 */
public function scopeInPostalCode(Builder $query, string $postalCode): Builder
{
    return $query->whereHas('addresses', function (Builder $query) use ($postalCode) {
        $query->where('postal_code', $postalCode);
    });
}

/**
 * Scope per filtrare i modelli per indirizzi nelle vicinanze.
 */
public function scopeNearby(Builder $query, float $latitude, float $longitude, float $radiusKm = 10): Builder
{
    return $query->whereHas('addresses', function (Builder $query) use ($latitude, $longitude, $radiusKm) {
        $query->nearby($latitude, $longitude, $radiusKm);
    });
}
```

## Utilizzo in Filament

Il trait `HasAddress` è progettato per funzionare perfettamente con Filament. Per standardizzare i form degli indirizzi in tutta l'applicazione, è consigliato utilizzare il form schema predefinito di `AddressResource`:

```php
use Modules\Geo\Filament\Resources\AddressResource;

// Utilizzo in una risorsa Filament
public static function getFormSchema(): array
{
    return [
        // ... altri campi
        
        'addresses' => Forms\Components\Repeater::make('addresses')
            ->relationship('addresses')
            ->schema(AddressResource::getFormSchema()),
    ];
}
```

## Testing

Il trait `HasAddress` include test unitari completi per verificare tutte le funzionalità:

```php
// Verifica la relazione con gli indirizzi
public function test_it_can_have_multiple_addresses()
{
    // ...
}

// Verifica la gestione dell'indirizzo principale
public function test_it_can_get_primary_address()
{
    // ...
}

// Verifica l'impostazione dell'indirizzo principale
public function test_it_can_set_primary_address()
{
    // ...
}

// Verifica il filtro per città
public function test_it_can_filter_models_by_city()
{
    // ...
}
```

## Best Practices

1. **Utilizza il trait in modelli appropriati**: Non tutti i modelli necessitano di indirizzi. Utilizza il trait solo dove ha senso.

2. **Gestisci correttamente gli indirizzi principali**: Ogni entità dovrebbe avere al massimo un indirizzo principale. Utilizza sempre i metodi dedicati (`setAsPrimaryAddress`) per gestire questa logica.

3. **Sfrutta gli scope di query**: Gli scope di query forniti dal trait permettono di effettuare ricerche avanzate. Utilizzali invece di implementare logiche personalizzate.

4. **Utilizza il form schema standard**: Per mantenere coerenza nell'UI, utilizza sempre il form schema fornito da `AddressResource` per i form Filament.

5. **Estendi le funzionalità**: Se necessario, estendi il trait con metodi specifici per il tuo dominio, mantenendo la compatibilità con le funzionalità base.

## Riferimenti

- [Modello Address](../models/address.md)
- [Documentazione Laravel Eloquent Traits](https://laravel.com/docs/10.x/eloquent-traits)
- [Pattern Relazioni Polimorfe](../morphs-relationship-patterns.md)
- [Risorsa Filament per Address](../filament/address-resource.md)
# Relazioni del Modello Address

## Casi d'Uso Tipici
Il modello `Address` è stato progettato per essere riutilizzabile in diversi contesti applicativi. Questa documentazione descrive i vari casi d'uso e le relazioni che il modello può avere con altre entità del sistema.

## Relazione Polimorfica

Il modello `Address` implementa una relazione polimorfica `addressable` che consente di associarlo a qualsiasi altro modello dell'applicazione:

```php
/**
 * Get the addressable model that the address belongs to.
 *
 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
 */
public function addressable()
{
    return $this->morphTo();
}
```

## Casi d'Uso Principali

### 1. Indirizzi di Persona

Ogni persona può avere più indirizzi (casa, lavoro, ecc.):

```php
// Nel modello Person
public function addresses()
{
    return $this->morphMany(Address::class, 'addressable');
}

// Esempio di utilizzo
$person->addresses()->create([
    'type' => Address::TYPE_HOME,
    'street_address' => 'Via Roma 123',
    'postal_code' => '00100',
    'administrative_area_level_3' => 'Roma',
    'administrative_area_level_2' => 'RM',
    'administrative_area_level_1' => 'Lazio',
    'country' => 'Italia',
    'country_code' => 'IT',
]);
```

### 2. Indirizzi di Struttura Sanitaria

Una struttura sanitaria può avere una sede principale e diverse sedi secondarie:

```php
// Nel modello HealthFacility
public function addresses()
{
    return $this->morphMany(Address::class, 'addressable');
}

// Sede principale
$facility->addresses()->create([
    'type' => Address::TYPE_HEADQUARTER,
    'is_primary' => true,
    // ... altri campi dell'indirizzo
]);

// Sede secondaria
$facility->addresses()->create([
    'type' => Address::TYPE_BRANCH,
    'is_primary' => false,
    // ... altri campi dell'indirizzo
]);
```

### 3. Indirizzi di Negozio/Attività

Un negozio o un'attività commerciale può avere un indirizzo fisico:

```php
// Nel modello Store
public function address()
{
    return $this->morphOne(Address::class, 'addressable');
}

// Oppure per supportare multiple sedi
public function addresses()
{
    return $this->morphMany(Address::class, 'addressable');
}
```

### 4. Indirizzi per Ordini e Fatturazione

Gli ordini possono avere indirizzi di spedizione e fatturazione diversi:

```php
// Nel modello Order
public function shippingAddress()
{
    return $this->morphOne(Address::class, 'addressable')
        ->where('type', Address::TYPE_SHIPPING);
}

public function billingAddress()
{
    return $this->morphOne(Address::class, 'addressable')
        ->where('type', Address::TYPE_BILLING);
}
```

## Implementazione nei Diversi Modelli

### Trait Reusable

Per semplificare l'implementazione, è possibile creare un trait che può essere utilizzato in qualsiasi modello che necessita di indirizzi:

```php
namespace Modules\Geo\Traits;

use Modules\Geo\Models\Address;

trait HasAddresses
{
    /**
     * Get all addresses for this model.
     */
    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }
    
    /**
     * Get the primary address for this model.
     */
    public function primaryAddress()
    {
        return $this->morphOne(Address::class, 'addressable')
            ->where('is_primary', true);
    }
    
    /**
     * Get addresses of a specific type.
     */
    public function addressesOfType(string $type)
    {
        return $this->morphMany(Address::class, 'addressable')
            ->where('type', $type);
    }
    
    /**
     * Get the home address for this model.
     */
    public function homeAddress()
    {
        return $this->morphOne(Address::class, 'addressable')
            ->where('type', Address::TYPE_HOME);
    }
    
    /**
     * Get the work address for this model.
     */
    public function workAddress()
    {
        return $this->morphOne(Address::class, 'addressable')
            ->where('type', Address::TYPE_WORK);
    }
    
    /**
     * Get the billing address for this model.
     */
    public function billingAddress()
    {
        return $this->morphOne(Address::class, 'addressable')
            ->where('type', Address::TYPE_BILLING);
    }
    
    /**
     * Get the shipping address for this model.
     */
    public function shippingAddress()
    {
        return $this->morphOne(Address::class, 'addressable')
            ->where('type', Address::TYPE_SHIPPING);
    }
}
```

Utilizzo del trait:

```php
class Doctor extends Model
{
    use HasAddresses;
    
    // ... altri metodi e proprietà
}

// Ora il modello Doctor ha tutti i metodi per gestire gli indirizzi
$doctor->addresses()->create([...]);
$primaryAddress = $doctor->primaryAddress;
$workAddresses = $doctor->addressesOfType(Address::TYPE_WORK);
```

## Integrazione con Filament

### Form Component Riusabile

Per facilitare l'inserimento degli indirizzi nei form Filament, è possibile creare un componente riusabile:

```php
namespace Modules\Geo\Filament\Forms;

use Filament\Forms;
use Illuminate\Database\Eloquent\Model;

class AddressForm
{
    public static function make(): array
    {
        return [
            Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\TextInput::make('street_address')
                        ->label('address-form.fields.street_address')
                        ->required(),
                        
                    Forms\Components\TextInput::make('address_line2')
                        ->label('address-form.fields.address_line2'),
                ])
                ->columns(2),
                
            Forms\Components\Grid::make()
                ->schema([
                    // Componenti per regione, provincia e comune
                    // ... componenti geografici specifici per l'Italia
                ])
                ->columns(3),
                
            Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\TextInput::make('postal_code')
                        ->label('address-form.fields.postal_code')
                        ->required(),
                        
                    Forms\Components\Select::make('type')
                        ->label('address-form.fields.type')
                        ->options(function () {
                            return Address::getTypes();
                        })
                        ->default(Address::TYPE_HOME)
                        ->required(),
                        
                    Forms\Components\Toggle::make('is_primary')
                        ->label('address-form.fields.is_primary')
                        ->default(false),
                ])
                ->columns(3),
        ];
    }
    
    public static function saveAddress(Model $model, array $data): void
    {
        $address = $model->addresses()->updateOrCreate(
            [
                'type' => $data['type'],
                'is_primary' => $data['is_primary'] ?? false,
            ],
            [
                'street_address' => $data['street_address'],
                'address_line2' => $data['address_line2'] ?? null,
                'postal_code' => $data['postal_code'],
                'administrative_area_level_1' => $data['administrative_area_level_1'] ?? null,
                'administrative_area_level_2' => $data['administrative_area_level_2'] ?? null,
                'administrative_area_level_3' => $data['administrative_area_level_3'] ?? null,
                'country' => $data['country'] ?? 'Italia',
                'country_code' => $data['country_code'] ?? 'IT',
            ]
        );
        
        // Se questo è l'indirizzo principale, imposta tutti gli altri come non principali
        if ($data['is_primary'] ?? false) {
            $model->addresses()
                ->where('id', '!=', $address->id)
                ->update(['is_primary' => false]);
        }
    }
}
```

## Pattern di Implementazione Consigliati

### 1. Address come Entità Indipendente

In questo pattern, `Address` è un'entità indipendente con una propria tabella e può essere collegata a qualsiasi altra entità.

**Pro**:
- Massima flessibilità
- Riutilizzo completo
- Supporta relazioni multiple (una persona può avere più indirizzi)

**Contro**:
- Complessità leggermente maggiore
- Richiede join per accedere ai dati dell'indirizzo

### 2. Address come Trait e JSON

In questo pattern, i campi dell'indirizzo sono memorizzati come JSON in una colonna della tabella principale.

```php
trait HasAddress
{
    public function getAddressAttribute(): array
    {
        return json_decode($this->attributes['address_data'] ?? '{}', true);
    }
    
    public function setAddressAttribute(array $value): void
    {
        $this->attributes['address_data'] = json_encode($value);
    }
}
```

**Pro**:
- Semplice da implementare
- Nessun join necessario
- Buono per casi d'uso semplici

**Contro**:
- Meno flessibile
- Difficile da interrogare e indicizzare
- Non adatto per relazioni multiple

### 3. Address come Modello Embeddable (con Laravel 10+)

Con Laravel 10+, è possibile utilizzare i nuovi modelli embeddable:

```php
// In una versione futura con Laravel 10+
class Address
{
    public function __construct(
        public string $street_address,
        public ?string $address_line2,
        public string $postal_code,
        public string $city,
        public string $province,
        public string $region,
        public string $country = 'Italia',
        public string $country_code = 'IT',
    ) {
    }
}

class Person extends Model
{
    protected $casts = [
        'home_address' => Address::class,
        'work_address' => Address::class,
    ];
}
```

**Pro**:
- Elegante e tipizzato
- Buon equilibrio tra semplicità e funzionalità
- Supporta multiple istanze di indirizzi

**Contro**:
- Richiede Laravel 10+
- Meno flessibile della relazione polimorfica completa

## Conclusioni

Il modello `Address` è stato progettato per essere altamente riutilizzabile in diversi contesti applicativi. La scelta del pattern di implementazione dipende dalle specifiche esigenze del progetto:

1. **Per massima flessibilità**: Utilizzare il modello completo con relazione polimorfica
2. **Per semplicità**: Utilizzare il trait HasAddress con JSON
3. **Per tipizzazione**: Considerare i modelli embeddable (con Laravel 10+)

In tutti i casi, è importante mantenere una struttura coerente per gli indirizzi in tutta l'applicazione e seguire le best practices per la validazione e la formattazione degli indirizzi italiani.

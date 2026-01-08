# Trait HasAddresses

## Overview
Il trait `HasAddresses` fornisce funzionalità per gestire indirizzi in qualsiasi modello dell'applicazione. Questo trait è progettato per essere facile da integrare e permettere una gestione completa degli indirizzi, incluse le specificità degli indirizzi italiani.

## Implementazione

```php
use Modules\Geo\Traits\HasAddresses;

class User extends Model
{
    use HasAddresses;
    
    // Altri metodi e proprietà...
}
```

## Funzionalità Fornite

### Relazioni Base

```php
// Tutti gli indirizzi di un modello
$user->addresses()->get();

// Indirizzo principale
$user->primaryAddress;

// Indirizzo di casa
$user->homeAddress;

// Indirizzo di lavoro
$user->workAddress;

// Indirizzo di fatturazione
$user->billingAddress;
```

### Metodi per Gestione Indirizzi

```php
// Aggiungere un nuovo indirizzo
$user->addAddress([
    'type' => AddressTypeEnum::HOME,
    'street_address' => 'Via Roma 123',
    'address_locality' => 'Milano',
    'province' => 'Milano',
    'address_region' => 'Lombardia',
    'postal_code' => '20100',
    'address_country' => 'IT'
]);

// Impostare un indirizzo come principale
$user->setPrimaryAddress($address);

// Ottenere indirizzi per tipo
$user->getAddressesByType(AddressTypeEnum::WORK);
```

## Supporto per Indirizzi Italiani

Il trait supporta la gestione di indirizzi italiani con campi distinti per regione e provincia:

```php
// Aggiungere un indirizzo italiano completo
$user->addAddress([
    'type' => AddressTypeEnum::HOME,
    'street_address' => 'Via Roma 123',
    'address_locality' => 'Milano',
    'province' => 'Milano', // Provincia italiana
    'province_short' => 'MI', // Sigla provincia
    'address_region' => 'Lombardia', // Regione italiana
    'postal_code' => '20100',
    'address_country' => 'IT'
]);
```

## Estensione del Trait

Il trait può essere esteso per aggiungere funzionalità specifiche:

```php
/**
 * Ottieni gli indirizzi solo in una specifica regione italiana.
 */
public function getAddressesInRegion(string $region)
{
    return $this->addresses()
        ->where('address_region', $region)
        ->where('address_country', 'IT')
        ->get();
}

/**
 * Ottieni gli indirizzi solo in una specifica provincia italiana.
 */
public function getAddressesInProvince(string $province)
{
    return $this->addresses()
        ->where('province', $province)
        ->where('address_country', 'IT')
        ->get();
}
```

## Validazione

Si raccomanda di validare gli indirizzi italiani con regole specifiche:

```php
// Esempio di regole di validazione per indirizzi italiani
$rules = [
    'addresses.*.address_region' => ['required_if:addresses.*.address_country,IT'],
    'addresses.*.province' => ['required_if:addresses.*.address_country,IT'],
    'addresses.*.postal_code' => [
        'required_if:addresses.*.address_country,IT',
        'regex:/^[0-9]{5}$/'
    ],
];
```

## Integrazione con Filament

Per l'utilizzo in form Filament, è possibile utilizzare:

```php
public static function getFormSchema(): array
{
    return [
        'addresses' => Forms\Components\Repeater::make('addresses')
            ->relationship()
            ->schema([
                'type' => Forms\Components\Select::make('type')
                    ->enum(AddressTypeEnum::class)
                    ->required(),
                'street_address' => Forms\Components\TextInput::make('street_address')
                    ->required(),
                'address_locality' => Forms\Components\TextInput::make('address_locality')
                    ->required(),
                'province' => Forms\Components\TextInput::make('province')
                    ->requiredIf('address_country', 'IT'),
                'address_region' => Forms\Components\TextInput::make('address_region')
                    ->requiredIf('address_country', 'IT'),
                'postal_code' => Forms\Components\TextInput::make('postal_code')
                    ->required(),
                'address_country' => Forms\Components\Select::make('address_country')
                    ->required()
                    ->options(Countries::getSelectOptions()),
                'is_primary' => Forms\Components\Toggle::make('is_primary'),
            ]),
    ];
}
```

## Best Practices

1. Utilizzare sempre il tipo di indirizzo appropriato (HOME, WORK, BILLING, ecc.)
2. Per gli indirizzi italiani, compilare sempre sia regione che provincia
3. Impostare sempre un indirizzo principale per ogni modello
4. Utilizzare i CAP in formato valido per l'Italia (5 cifre)
5. Memorizzare il paese in formato ISO 3166-1 alpha-2 (es. "IT" per Italia)

## Aggiornamento 2024-06: Centralizzazione logica in HasAddress

- Tutti i metodi di accesso, formattazione e ricerca degli indirizzi principali sono ora centralizzati nel trait `HasAddress`.
- Il trait va usato in tutti i modelli che hanno relazioni polimorfiche con Address (es. Studio, User, ecc.).
- Esempio:

```php
use Modules\Geo\Models\Traits\HasAddress;

class Studio extends Model
{
    use HasAddress;
    // ...
}
```

- Questo garantisce:
  - **DRY**: nessuna duplicazione di metodi tra modelli
  - **KISS**: override e personalizzazione semplici
  - **Zen**: la logica dell'indirizzo è in un solo punto, facilmente testabile e documentabile
  - **Multi-modulo**: ogni modulo può estendere/overrideare solo ciò che serve

- Per dettagli sulla struttura del modello Address, vedi [models/address.md](../models/address.md)
- Per esempi di override, vedi la sezione "Estensione del Trait" qui sopra.

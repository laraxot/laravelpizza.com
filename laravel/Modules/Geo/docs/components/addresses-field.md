# AddressesField Component

## Panoramica

Il componente `AddressesField` è un componente Filament riutilizzabile progettato per gestire indirizzi multipli con logica avanzata per la visibilità condizionale e la gestione del campo primario. Questo componente implementa il principio DRY (Don't Repeat Yourself) centralizzando la logica complessa di gestione indirizzi che altrimenti dovrebbe essere duplicata in multiple risorse.

## Caratteristiche Principali

### 🏗️ Architettura
- **Estende**: `Filament\Forms\Components\Field`
- **Namespace**: `Modules\Geo\Filament\Forms\Components`
- **Vista**: `geo::filament.forms.components.addresses-field`

### 🚀 Funzionalità Avanzate

1. **Gestione Indirizzi Multipli**: Utilizza un `Repeater` per gestire una collezione di indirizzi
2. **Visibilità Condizionale**: Campo `name` visibile solo con più di 1 indirizzo
3. **Gestione Primario Esclusiva**: Campo `is_primary` con logica che garantisce un solo indirizzo primario
4. **Schema Completo**: Utilizza l'intero schema di `AddressResource` con tutti i campi italiani
5. **Configurabilità**: Multipli parametri per personalizzare il comportamento

### 📋 Schema Indirizzo Incluso

Il componente utilizza automaticamente lo schema completo dell'`AddressResource` che include:
- **Regioni**: Selezione a cascata con tutti i dati italiani
- **Province**: Filtrate dinamicamente per regione selezionata
- **Comuni**: Filtrati dinamicamente per provincia selezionata
- **CAP**: Filtrati dinamicamente per comune selezionato
- **Via e Numero Civico**: Campi separati per indirizzo completo
- **Coordinate**: Latitudine e longitudine per geolocalizzazione

## API e Configurazione

### Metodi di Configurazione

```php
AddressesField::make('addresses')
    ->relationship('addresses')           // Nome della relazione (default: 'addresses')
    ->minItems(1)                        // Numero minimo di indirizzi (default: 1)
    ->maxItems(5)                        // Numero massimo di indirizzi (default: null)
    ->addActionLabel('Aggiungi Sede')    // Etichetta pulsante aggiunta
    ->reorderable(true)                  // Abilita riordinamento (default: false)
    ->deletable(true)                    // Abilita eliminazione (default: true)
    ->managePrimary(true)                // Gestione automatica is_primary (default: true)
    ->columnSpanFull()                   // Occupa tutta la larghezza disponibile
```

### Parametri Disponibili

| Parametro | Tipo | Default | Descrizione |
|-----------|------|---------|-------------|
| `relationship()` | `string` | `'addresses'` | Nome della relazione Eloquent |
| `minItems()` | `int` | `1` | Numero minimo di indirizzi richiesti |
| `maxItems()` | `int\|null` | `null` | Numero massimo di indirizzi consentiti |
| `addActionLabel()` | `string` | `'Aggiungi Indirizzo'` | Etichetta pulsante aggiunta |
| `reorderable()` | `bool` | `false` | Abilita riordinamento con drag&drop |
| `deletable()` | `bool` | `true` | Abilita eliminazione indirizzi |
| `managePrimary()` | `bool` | `true` | Gestione automatica campo primario |

## Esempi d'Uso

### 1. Utilizzo Base in StudioResource

```php
<?php

namespace Modules\<main module>\Filament\Resources;

use Modules\Geo\Filament\Forms\Components\AddressesField;

class StudioResource extends XotBaseResource
{
    public static function getFormSchema(): array
    {
        return [
            // Altri campi dello studio...

            'addresses' => AddressesField::make('addresses')
                ->relationship('addresses')
                ->minItems(1)
                ->addActionLabel('Aggiungi Sede')
                ->columnSpanFull(),
        ];
    }
}
```

### 2. Configurazione Avanzata per PatientResource

```php
<?php

namespace Modules\Patient\Filament\Resources;

use Modules\Geo\Filament\Forms\Components\AddressesField;

class PatientResource extends XotBaseResource
{
    public static function getFormSchema(): array
    {
        return [
            // Altri campi del paziente...

            'addresses' => AddressesField::make('addresses')
                ->relationship('addresses')
                ->minItems(1)
                ->maxItems(3)  // Massimo 3 indirizzi per paziente
                ->addActionLabel('Aggiungi Residenza')
                ->reorderable(false)  // Nessun riordinamento per pazienti
                ->managePrimary(true)
                ->columnSpanFull(),
        ];
    }
}
```

### 3. Configurazione per ClinicResource con Riordinamento

```php
<?php

namespace Modules\Clinic\Filament\Resources;

use Modules\Geo\Filament\Forms\Components\AddressesField;

class ClinicResource extends XotBaseResource
{
    public static function getFormSchema(): array
    {
        return [
            // Altri campi della clinica...

            'addresses' => AddressesField::make('addresses')
                ->relationship('addresses')
                ->minItems(1)
                ->maxItems(10)  // Cliniche possono avere molte sedi
                ->addActionLabel('Aggiungi Filiale')
                ->reorderable(true)   // Abilita riordinamento
                ->deletable(true)
                ->managePrimary(true)
                ->columnSpanFull(),
        ];
    }
}
```

### 4. Utilizzo Senza Gestione Primario

```php
'shipping_addresses' => AddressesField::make('shipping_addresses')
    ->relationship('shippingAddresses')
    ->minItems(0)
    ->addActionLabel('Aggiungi Indirizzo di Spedizione')
    ->managePrimary(false)  // Disabilita gestione campo primario
    ->columnSpanFull(),
```

## Logica Interna Avanzata

### Visibilità Condizionale del Campo Nome

Il campo `name` viene mostrato automaticamente solo quando ci sono più di 1 indirizzi:

```php
Forms\Components\TextInput::make('name')
    ->maxLength(255)
    ->visible(function (Get $get): bool {
        $addresses = $get("../../{$this->relationshipName}") ?? [];
        return count($addresses) > 1;
    })
    ->live();
```

### Gestione Esclusiva Campo Primario

Il campo `is_primary` implementa una logica sofisticata per garantire l'esclusività:

1. **Visibilità**: Mostrato solo con più di 1 indirizzo
2. **Default**: Primo indirizzo è automaticamente primario
3. **Esclusività**: Impostando uno come primario, gli altri diventano secondari
4. **Validazione**: Con un solo indirizzo, è sempre forzato a `true`

```php
Forms\Components\Toggle::make('is_primary')
    ->afterStateUpdated(function ($state, $set, Get $get, Component $component): void {
        if ($state === true) {
            // Disattiva is_primary negli altri elementi
            // ... logica complessa di esclusività
        }
    })
    ->dehydrateStateUsing(function ($state, Get $get): bool {
        $addresses = $get("../../{$this->relationshipName}") ?? [];
        // Con un solo elemento, forza sempre true
        if (count($addresses) <= 1) {
            return true;
        }
        return (bool) $state;
    });
```

## Requisiti del Modello

### Relazione Eloquent

Il modello che utilizza `AddressesField` deve avere una relazione `addresses` (o altra personalizzata):

```php
<?php

namespace Modules\<main module>\Models;

use Modules\Geo\Models\Address;

class Studio extends BaseModel
{
    /**
     * Relazione con gli indirizzi.
     */
    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'model');
    }
}
```

### Migrazione per Supporto Polimorfico

```php
Schema::table('addresses', function (Blueprint $table) {
    $table->morphs('model');  // Aggiunge model_id e model_type
    $table->string('name')->nullable();
    $table->boolean('is_primary')->default(false);
});
```

## Traduzioni e Localizzazione

### File di Traduzione

Il componente utilizza il file di traduzione `Modules/Geo/lang/it/addresses.php`:

```php
return [
    'field' => [
        'help' => [
            'title' => 'Gestione Indirizzi',
            'description' => 'Puoi aggiungere più indirizzi...',
            'primary_note' => 'Solo un indirizzo può essere principale.',
        ],
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome Indirizzo',
            'placeholder' => 'es. Sede Principale, Filiale Nord',
        ],
        'is_primary' => [
            'label' => 'Indirizzo Principale',
        ],
    ],
];
```

### Override delle Traduzioni

Per personalizzare le traduzioni in un modulo specifico:

```php
// Nel modulo specifico, es. Modules/<main module>/lang/it/studio.php
return [
    'addresses' => [
        'add_action' => 'Aggiungi Sede Studio',
        'name_placeholder' => 'es. Sede Centrale, Filiale Roma Nord',
    ],
];
```

## Principi DRY Implementati

### Problemi Risolti

1. **Duplicazione di Codice**: La logica di gestione indirizzi era duplicata tra StudioResource, PatientResource, ecc.
2. **Inconsistenza**: Ogni implementazione aveva piccole differenze nel comportamento
3. **Manutenibilità**: Modifiche alla logica richiedevano update in multiple risorse
4. **Testing**: Era necessario testare la stessa logica in contesti diversi

### Vantaggi Ottenuti

1. **Centralizzazione**: Un solo punto per la logica di gestione indirizzi
2. **Consistenza**: Comportamento uniforme in tutta l'applicazione
3. **Manutenibilità**: Modifiche in un solo posto si propagano ovunque
4. **Configurabilità**: Flessibilità per adattarsi a casi d'uso specifici
5. **Testing**: Testing centralizzato della logica core

## Considerazioni di Performance

### Caricamento Lazy

Il componente implementa caricamento lazy per migliorare le performance:

```php
->live()  // Solo i campi necessari sono reattivi
```

### Ottimizzazioni Query

L'utilizzo delle relazioni Eloquent garantisce:
- Eager loading automatico quando necessario
- Query ottimizzate per il caricamento degli indirizzi
- Caching automatico delle opzioni comuni (regioni, province)

## Testing

### Test del Componente

```php
<?php

namespace Modules\Geo\Tests\Components;

use Tests\TestCase;
use Modules\Geo\Filament\Forms\Components\AddressesField;

class AddressesFieldTest extends TestCase
{
    /** @test */
    public function it_creates_repeater_with_correct_configuration(): void
    {
        $field = AddressesField::make('addresses')
            ->minItems(2)
            ->maxItems(5);

        $this->assertEquals(2, $field->getMinItems());
        $this->assertEquals(5, $field->getMaxItems());
    }

    /** @test */
    public function it_manages_primary_field_exclusivity(): void
    {
        // Test della logica di esclusività del campo primario
    }
}
```

### Test di Integrazione

```php
/** @test */
public function studio_can_manage_multiple_addresses(): void
{
    $studio = Studio::factory()->create();

    $addressData = [
        [
            'name' => 'Sede Principale',
            'route' => 'Via Roma',
            'street_number' => '123',
            'is_primary' => true,
        ],
        [
            'name' => 'Filiale Nord',
            'route' => 'Via Milano',
            'street_number' => '456',
            'is_primary' => false,
        ],
    ];

    $studio->addresses()->createMany($addressData);

    $this->assertCount(2, $studio->addresses);
    $this->assertTrue($studio->addresses->first()->is_primary);
    $this->assertFalse($studio->addresses->last()->is_primary);
}
```

## Problemi Comuni e Soluzioni

### 1. Campo name Non Visibile

**Problema**: Il campo `name` non appare quando si aggiungono indirizzi.

**Causa**: Logica di visibilità basata sul conteggio degli indirizzi.

**Soluzione**: Il campo appare automaticamente quando ci sono più di 1 indirizzi nel form.

### 2. is_primary Non Esclusivo

**Problema**: Più indirizzi risultano primari contemporaneamente.

**Causa**: Logica `afterStateUpdated` non funziona correttamente.

**Soluzione**: Verificare che `managePrimary(true)` sia impostato e che i campi abbiano `live()`.

### 3. Schema AddressResource Non Trovato

**Problema**: Errore durante il caricamento dello schema base.

**Causa**: `AddressResource::getFormSchema()` non accessibile.

**Soluzione**: Verificare che l'`AddressResource` sia correttamente configurato nel modulo Geo.

## Best Practice

### 1. Configurazione Appropriata

```php
// ✅ CORRETTO - Configurazione completa
AddressesField::make('addresses')
    ->relationship('addresses')
    ->minItems(1)
    ->addActionLabel(trans('studio::addresses.add'))
    ->columnSpanFull()

// ❌ ERRATO - Configurazione minimale senza contesto
AddressesField::make('addresses')
```

### 2. Gestione Relazioni

```php
// ✅ CORRETTO - Relazione polimorfica
public function addresses(): MorphMany
{
    return $this->morphMany(Address::class, 'model');
}

// ❌ ERRATO - Relazione diretta senza flessibilità
public function address(): BelongsTo
{
    return $this->belongsTo(Address::class);
}
```

### 3. Traduzioni Appropriate

```php
// ✅ CORRETTO - Traduzioni contestuali
->addActionLabel(trans('studio::addresses.add_studio_location'))

// ❌ ERRATO - Traduzioni generiche
->addActionLabel('Aggiungi')
```

## Roadmap e Miglioramenti Futuri

### V2.0 Planned Features

1. **Validazione Geografica**: Controllo automatico coordinate e indirizzi validi
2. **Integrazione Mappe**: Visualizzazione indirizzi su mappa interattiva
3. **Geofencing**: Definizione di aree geografiche per indirizzi
4. **Import/Export**: Funzionalità per importare indirizzi da file CSV/Excel
5. **Template Indirizzi**: Indirizzi predefiniti per tipologie comuni

### Miglioramenti UX

1. **Autocomplete Avanzato**: Integrazione con API geografiche per autocompletamento
2. **Validazione Real-time**: Verifica esistenza indirizzi durante la digitazione
3. **Drag & Drop Riordinamento**: Miglioramento interfaccia di riordinamento
4. **Bulk Operations**: Operazioni in massa su indirizzi multipli

## Collegamenti

### Documentazione Correlata
- [AddressResource Documentation](../address-resource.md)
- [Form Schema Reuse](../form-schema-reuse.md)
- [Address Model Documentation](../address-model-italian.md)
- [Studio Resource Implementation](../../<main module>/docs/studio-resource.md)

### File Correlati
- [AddressesField.php](../../app/Filament/Forms/Components/AddressesField.php)
- [addresses-field.blade.php](../../resources/views/filament/forms/components/addresses-field.blade.php)
- [addresses.php](../../lang/it/addresses.php)
- [StudioResource.php](../../<main module>/app/Filament/Resources/StudioResource.php)

---

*Ultimo aggiornamento: Dicembre 2024*

**Il componente AddressesField rappresenta un esempio eccellente di applicazione del principio DRY e di progettazione orientata al riutilizzo nel contesto Filament.**

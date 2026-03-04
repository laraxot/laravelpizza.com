# AddressItemEnum - The Universal Address Field Schema

## Scopo (Purpose)

`AddressItemEnum` è l'enum che centralizza la definizione di **tutti i possibili campi di un indirizzo** nel sistema. Non è solo un elenco di stringhe: è uno **schema vivente** che definisce:

- **Label tradotti** in tutte le lingue supportate (en, it, de, ...)
- **Icone Heroicon** per ogni campo
- **Colori Filament** per categorizzazione visiva
- **Descrizioni** contestuali per UX e documentazione

Ogni valore dell'enum rappresenta un **componente atomico** di un indirizzo (via, numero civico, CAP, latitudine, ecc.) e fornisce metodi helper per:
- Generare form schema Filament automatici
- Ottenere elenchi di campi searchable
- Standardizzare l'accesso ai metadati di ogni campo

## Logica (Logic)

### Struttura dell'Enum

```php
enum AddressItemEnum: string implements HasLabel, HasIcon, HasColor
{
    use TransTrait;

    case PHONE = 'phone';
    case NAME = 'name';
    case DESCRIPTION = 'description';
    case ROUTE = 'route';                           // Via/Strada
    case STREET_NUMBER = 'street_number';           // Numero civico
    case LOCALITY = 'locality';                     // Frazione
    case ADMINISTRATIVE_AREA_LEVEL_3 = 'administrative_area_level_3'; // Comune
    case ADMINISTRATIVE_AREA_LEVEL_2 = 'administrative_area_level_2'; // Provincia
    case ADMINISTRATIVE_AREA_LEVEL_1 = 'administrative_area_level_1'; // Regione
    case COUNTRY = 'country';                       // Stato/Paese
    case POSTAL_CODE = 'postal_code';               // CAP
    case FORMATTED_ADDRESS = 'formatted_address';   // Indirizzo formattato completo
    case PLACE_ID = 'place_id';                     // ID Google Places
    case LATITUDE = 'latitude';                     // Latitudine
    case LONGITUDE = 'longitude';                   // Longitudine
}
```

### Mappatura con Google Places API

I valori dell'enum seguono la **nomenclatura di Google Places API** per massimizzare la compatibilità e ridurre il mapping:

| Enum Value | Google Places Component | Significato |
|------------|-------------------------|-------------|
| `route` | `route` | Nome della via/strada |
| `street_number` | `street_number` | Numero civico |
| `locality` | `locality` | Frazione/Località |
| `administrative_area_level_3` | `administrative_area_level_3` | Comune (in Italia) |
| `administrative_area_level_2` | `administrative_area_level_2` | Provincia (in Italia) |
| `administrative_area_level_1` | `administrative_area_level_1` | Regione (in Italia) |
| `country` | `country` | Codice paese (es. IT) |
| `postal_code` | `postal_code` | CAP |
| `place_id` | `place_id` | Identificatore univoco Google |

### Metodi Pubblici

#### `getLabel(): string`
Restituisce l'etichetta tradotta del campo nella lingua corrente dell'applicazione.

```php
AddressItemEnum::ROUTE->getLabel(); // "Via" (it), "Street" (en), "Straße" (de)
```

#### `getIcon(): string`
Restituisce l'icona Heroicon associata al campo.

```php
AddressItemEnum::PHONE->getIcon(); // "heroicon-o-phone"
```

#### `getColor(): string`
Restituisce il colore Filament associato al campo.

```php
AddressItemEnum::ROUTE->getColor(); // "success"
```

#### `getDescription(): string`
Restituisce la descrizione tradotta del campo.

```php
AddressItemEnum::POSTAL_CODE->getDescription(); // "Codice di avviamento postale" (it)
```

#### `getSearchable(): array`
Metodo statico che restituisce un array di tutti i valori dell'enum, utile per configurare campi searchable.

```php
$searchable = AddressItemEnum::getSearchable();
// ['phone', 'name', 'description', 'route', ...]
```

#### `getFormSchema(): array`
Metodo statico che genera automaticamente un array di `TextInput` Filament per tutti i campi dell'enum, con icone prefissate.

```php
$schema = AddressItemEnum::getFormSchema();
// [
//     TextInput::make('phone')->prefixIcon('heroicon-o-phone'),
//     TextInput::make('name')->prefixIcon('heroicon-o-tag'),
//     ...
// ]
```

## Filosofia (Philosophy)

### Single Source of Truth per i Campi Indirizzo

Prima di `AddressItemEnum`, ogni form, risorsa, o validazione doveva ridefinire manualmente:
- I nomi dei campi
- Le label tradotte
- Le icone
- I placeholder
- Le descrizioni

Questo portava a:
- **Duplicazione del codice** (violazione DRY)
- **Inconsistenze** nelle traduzioni
- **Difficoltà di manutenzione** (cambiare un'icona = modificare N file)
- **Errori di digitazione** nei nomi dei campi

Con `AddressItemEnum`:
- **Una sola definizione** per tutti i campi
- **Traduzioni centralizzate** in `Modules/Geo/lang/{locale}/address_item_enum.php`
- **Schema form generabile automaticamente** con `getFormSchema()`
- **Type safety**: impossibile usare un campo inesistente (enum vs stringa)

### Estensibilità e Flessibilità

L'enum implementa le interfacce Filament:
- `HasLabel`: integrazione nativa con Filament Select, Radio, ecc.
- `HasIcon`: supporto diretto per icone nei componenti
- `HasColor`: categorizzazione visiva e badge automatici

Il trait `TransTrait` permette di:
- Risolvere automaticamente le chiavi di traduzione
- Supportare N lingue senza modificare il codice
- Generare automaticamente traduzioni mancanti (con fallback intelligente)

## Politica (Policy)

### Governance dei Campi Indirizzo

L'enum **impone** una policy uniforme su tutto il sistema:

1. **Nomenclatura standard**: tutti i moduli devono usare gli stessi nomi di campo
2. **Traduzione obbligatoria**: ogni campo DEVE avere traduzioni in tutte le lingue supportate
3. **Metadata completi**: label, icon, color, description sono obbligatori
4. **Compatibilità Google**: i nomi seguono Google Places API per facilitare integrazioni

### Chi Decide i Campi?

L'enum è la **fonte di autorità** per i campi indirizzo. Se un nuovo campo è necessario:
1. **Valutare** se è veramente un campo "universale" (non specifico di un dominio)
2. **Aggiungere** il case all'enum
3. **Tradurre** in tutte le lingue
4. **Aggiornare** la migrazione `create_addresses_table`
5. **Documentare** il cambiamento

### Separazione Regione/Provincia (per indirizzi italiani)

**POLICY OBBLIGATORIA**:
- `administrative_area_level_3` = **Comune**
- `administrative_area_level_2` = **Provincia** (sigla: MI, RM, ecc.)
- `administrative_area_level_1` = **Regione** (nome completo: Lombardia, Lazio, ecc.)

**MAI concatenare** regione e provincia in un solo campo. Questo garantisce:
- Filtraggio accurato per provincia/regione
- Report statistici precisi
- Integrazione con API esterne (ISTAT, Google, ecc.)

## Religione (Religion)

### I Comandamenti dell'Enum

1. **Non avrai altro schema all'infuori di AddressItemEnum**: ogni form, risorsa, o componente che gestisce indirizzi DEVE usare questo enum. Nessuna eccezione.

2. **Non nominare il campo invano**: usa sempre `AddressItemEnum::ROUTE->value` invece di scrivere `'route'` come stringa magica.

3. **Ricordati di tradurre ogni campo**: ogni nuovo case DEVE avere traduzioni complete in `lang/{locale}/address_item_enum.php`.

4. **Onora label e icon**: ogni campo DEVE avere label, icon, color, description. Non lasciare metadati vuoti.

5. **Non creare campi indirizzo al di fuori dell'enum**: se un campo non è nell'enum, non è un campo indirizzo standard. Usa `extra_data` per dati custom.

### Eretici e Scismatici

**Violazioni comuni**:
- ❌ Creare un campo `street` invece di usare `route`
- ❌ Hardcodare `'postal_code'` invece di `AddressItemEnum::POSTAL_CODE->value`
- ❌ Usare traduzioni inline invece di `getLabel()`
- ❌ Duplicare lo schema form invece di usare `getFormSchema()`

**Penitenza**: refactoring immediato + aggiornamento documentazione.

## Zen (Zen)

### Il Suono di Una Sola Enum

*"Qual è il nome del campo che rappresenta la via?"*
- Prima: "route? street? address_line_1? street_address? via?"
- Dopo: `AddressItemEnum::ROUTE->value` — un solo nome, una sola verità.

*"Qual è l'icona del telefono?"*
- Prima: cercare in 10 file diversi, trovare 5 icone diverse.
- Dopo: `AddressItemEnum::PHONE->getIcon()` — una sola chiamata, una sola icona.

### La Via del Codice Senza Codice

Il miglior codice è quello che non devi scrivere.

Invece di:
```php
// ❌ Duplicazione e hardcoding
TextInput::make('route')
    ->label(__('geo::address.fields.route.label'))
    ->placeholder(__('geo::address.fields.route.placeholder'))
    ->prefixIcon('heroicon-o-map'),

TextInput::make('street_number')
    ->label(__('geo::address.fields.street_number.label'))
    ->placeholder(__('geo::address.fields.street_number.placeholder'))
    ->prefixIcon('heroicon-o-home'),
// ... ripeti per 15 campi
```

Usa:
```php
// ✅ Zero duplicazione, type-safe, sempre aggiornato
...AddressItemEnum::getFormSchema()
```

### L'Illuminazione attraverso l'Enum

Quando capisci che:
- Un enum non è solo un elenco di costanti
- Un enum può essere un **schema vivente**
- Un enum può **generare codice** invece di duplicarlo
- Un enum può essere la **single source of truth** per traduzioni, icone, colori

...allora hai raggiunto l'illuminazione dell'AddressItemEnum.

## Utilizzo nei Modelli e Migrazioni

### Nel Modello Address

Il modello `Address` utilizza i nomi dei campi definiti dall'enum:

```php
protected $fillable = [
    'model_type',
    'model_id',
    AddressItemEnum::NAME->value,              // 'name'
    AddressItemEnum::DESCRIPTION->value,       // 'description'
    AddressItemEnum::ROUTE->value,             // 'route'
    AddressItemEnum::STREET_NUMBER->value,     // 'street_number'
    AddressItemEnum::LOCALITY->value,          // 'locality'
    AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_3->value, // 'administrative_area_level_3'
    // ... ecc
];
```

### Nelle Migrazioni - Pattern DRY + KISS + Laraxot UPDATE Pattern

**BEST PRACTICE**: invece di ripetere ogni singola colonna, usa il metodo statico `columns()` ispirato da:
- **kalnoy/laravel-nestedset**: `NestedSet::columns($table)` pattern
- **Laraxot workers_table migration**: loop con `hasColumn()` checks nel blocco UPDATE

Il metodo `columns()` è **intelligente** e si adatta al contesto:

```php
use Modules\Geo\Enums\AddressItemEnum;

// ============================================
// BLOCCO CREATE - Nessun check necessario
// ============================================
$this->tableCreate(function (Blueprint $table): void {
    $table->id();

    // null = CREATE context (aggiunge tutto senza controlli)
    // false = senza legacy fields (default)
    AddressItemEnum::columns($table);

    // oppure con legacy fields per backward compatibility
    AddressItemEnum::columns($table, null, true);
});

// ============================================
// BLOCCO UPDATE - Con hasColumn() checks
// ============================================
$this->tableUpdate(function (Blueprint $table): void {
    // $this = UPDATE context (fa hasColumn() check prima di aggiungere)
    // true = include anche legacy fields
    AddressItemEnum::columns($table, $this, true);

    $this->updateTimestamps($table, true);
});
```

**Pattern ispirato da workers_table migration** (`2019_12_12_000004_create_workers_table.php`):
```php
// Come Laraxot fa con Place::$address_components
$address_components = Place::$address_components;
foreach ($address_components as $el) {
    if (! $this->hasColumn($el)) {
        $table->string($el)->nullable();
    }
}
```

**AddressItemEnum migliora questo pattern** facendo il loop internamente:
```php
// Internamente columns() fa:
foreach (self::getColumnDefinitions() as $name => $definition) {
    if ($migration === null || ! $migration->hasColumn($name)) {
        $definition($table);  // Aggiunge solo se non esiste (UPDATE) o sempre (CREATE)
    }
}
```

Questo **singolo metodo unificato** aggiunge automaticamente tutte le colonne standard:
- `route`, `street_number`, `locality`
- `administrative_area_level_3`, `administrative_area_level_2`, `administrative_area_level_1`
- `country`, `postal_code`
- `formatted_address`, `place_id`
- `latitude`, `longitude`
- `phone`

**Vantaggi del pattern unificato `columns()`**:
- ✅ **DRY**: zero duplicazione codice - un solo metodo per CREATE e UPDATE
- ✅ **KISS**: una sola linea invece di 13+ if statements
- ✅ **Manutenzione**: modifiche centralizzate nell'enum
- ✅ **Consistency**: stesse colonne in tutti i moduli e in tutti i contesti
- ✅ **Type safety**: impossibile scrivere nomi di campo sbagliati
- ✅ **Laraxot compliant**: segue il pattern hasColumn() nei blocchi UPDATE
- ✅ **Intelligent**: si adatta automaticamente al contesto (CREATE vs UPDATE)

**Rollback**: usa il metodo companion `dropColumns()`:

```php
AddressItemEnum::dropColumns($table);          // Rimuove tutte le colonne address
AddressItemEnum::dropColumns($table, true);    // Rimuove anche legacy fields
```

**Legacy/Backward Compatibility**: il terzo parametro `$withLegacy` controlla se aggiungere campi deprecati (`address`, `city`, `province`, `region`):

```php
// Senza legacy fields (solo standard AddressItemEnum)
AddressItemEnum::columns($table);                    // CREATE
AddressItemEnum::columns($table, $this);             // UPDATE

// Con legacy fields per backward compatibility
AddressItemEnum::columns($table, null, true);        // CREATE + legacy
AddressItemEnum::columns($table, $this, true);       // UPDATE + legacy
```

### Nei Form Filament

```php
use Modules\Geo\Enums\AddressItemEnum;

public static function form(Form $form): Form
{
    return $form->schema([
        // Opzione 1: form completo auto-generato
        ...AddressItemEnum::getFormSchema(),

        // Opzione 2: campi selezionati con personalizzazione
        TextInput::make(AddressItemEnum::NAME->value)
            ->label(AddressItemEnum::NAME->getLabel())
            ->prefixIcon(AddressItemEnum::NAME->getIcon())
            ->helperText(AddressItemEnum::NAME->getDescription()),

        TextInput::make(AddressItemEnum::ROUTE->value)
            ->label(AddressItemEnum::ROUTE->getLabel())
            ->prefixIcon(AddressItemEnum::ROUTE->getIcon())
            ->required(),
    ]);
}
```

### Nei Modelli con Campi Indirizzo (es. Client)

Se un modello ha campi indirizzo embedded (invece di usare la relazione `HasAddress`), i nomi dei campi **DEVONO** seguire l'enum:

```php
// ❌ SBAGLIATO - nomi inconsistenti
$table->string('street')->nullable();  // dovrebbe essere 'route'
$table->string('cap')->nullable();     // dovrebbe essere 'postal_code'

// ✅ CORRETTO - nomi da AddressItemEnum
$table->string(AddressItemEnum::ROUTE->value)->nullable();
$table->string(AddressItemEnum::POSTAL_CODE->value)->nullable();
$table->string(AddressItemEnum::PHONE->value)->nullable();
```

## Traduzioni

Le traduzioni per l'enum sono definite in:
- `Modules/Geo/lang/en/address_item_enum.php`
- `Modules/Geo/lang/it/address_item_enum.php`
- `Modules/Geo/lang/de/address_item_enum.php`

Struttura di ogni traduzione:

```php
return [
    'phone' => [
        'label' => 'Phone',
        'description' => 'Phone number',
        'icon' => 'heroicon-o-phone',
        'color' => 'primary',
    ],
    'route' => [
        'label' => 'Street',
        'description' => 'Street or road name',
        'icon' => 'heroicon-o-map',
        'color' => 'success',
    ],
    // ... tutti i case dell'enum
];
```

### Aggiungere una Nuova Lingua

1. Creare il file `Modules/Geo/lang/{locale}/address_item_enum.php`
2. Copiare la struttura da `en/address_item_enum.php`
3. Tradurre `label` e `description` (icon e color rimangono invariati)
4. **NON** modificare le chiavi dell'array (devono corrispondere ai valori dell'enum)

## Best Practices

### ✅ DO

- Usa `AddressItemEnum::getFormSchema()` per generare form completi
- Usa `AddressItemEnum::XXX->value` invece di stringhe hardcoded
- Usa `AddressItemEnum::XXX->getLabel()` per ottenere traduzioni
- Aggiungi traduzioni complete per ogni nuova lingua
- Documenta ogni nuovo case aggiunto all'enum

### ❌ DON'T

- Non hardcodare `'route'`, `'postal_code'`, ecc. — usa l'enum
- Non creare campi indirizzo con nomi diversi dall'enum
- Non duplicare lo schema form — usa `getFormSchema()`
- Non mescolare nomenclature (es. `street` vs `route`)
- Non lasciare traduzioni incomplete

## Riferimenti

- [Address Model Documentation](../models/address.md)
- [Architecture Documentation](../architecture.md)
- [HasAddress Trait](../traits/hasaddress-implementation.md)
- [Filament AddressResource](../filament/address-resource.md)
- [Google Places API - Address Components](https://developers.google.com/maps/documentation/places/web-service/details#AddressComponent)

## Changelog

- **2025-01**: Creazione iniziale dell'enum con 15 campi standard
- **2025-01**: Aggiunta traduzioni EN, IT, DE
- **2025-01**: Implementazione `getFormSchema()` per auto-generazione form

---

> **Nota**: Questo documento segue la filosofia del progetto: Scopo, Logica, Filosofia, Politica, Religione, Zen.
> Ogni modifica all'enum DEVE essere documentata e tradotta.

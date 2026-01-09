# AddressItemEnum - Comprehensive Guide

## Purpose and Philosophy

### The Zen of AddressItemEnum

The `AddressItemEnum` embodies the **principle of structured flexibility** in address management. It serves as a **semantic bridge** between the chaotic reality of global addressing systems and the orderly world of structured data.

### Core Purpose

1. **Standardization**: Provides a unified interface for all address-related fields across different countries and systems
2. **Internationalization**: Supports multiple languages while maintaining semantic consistency
3. **UI Integration**: Seamlessly integrates with Filament forms through built-in contracts
4. **Extensibility**: Allows easy addition of new address components without breaking existing code

### The Logic

#### Hierarchical Structure
The enum follows Google's Address Component Types hierarchy:
- **Level 1**: Country/Region (administrative_area_level_1)
- **Level 2**: Province/State (administrative_area_level_2)
- **Level 3**: Municipality/Comune (administrative_area_level_3)
- **Level 4**: Street/Route (route)
- **Level 5**: Street Number (street_number)

#### Italian Administrative Context
The enum is particularly optimized for Italian administrative structure:
- Recognizes the unique role of "Comune" as both city and municipality
- Handles CAP (postal codes) with proper validation
- Supports Italian-specific address formats (via, piazza, corso)

### The Religion

We follow the **Doctrine of Single Responsibility**:
- Each enum value represents ONE specific address component
- No mixing of concepts (e.g., no combined address fields)
- Each value has a single, well-defined purpose

### The Politics

1. **Neutrality**: The enum doesn't favor any specific country's addressing system
2. **Inclusivity**: Accommodates various international formats
3. **Collaboration**: Works harmoniously with other modules (TechPlanner, User, etc.)
4. **Sovereignty**: Each module can use only the address components it needs

## Implementation Details

### Enum Values and Their Semantics

```php
enum AddressItemEnum: string implements HasLabel, HasIcon, HasColor
{
    // Contact Information
    case PHONE = 'phone';                    // Phone number associated with address

    // Identification
    case NAME = 'name';                      // Name/label for the address
    case DESCRIPTION = 'description';        // Additional description

    // Street Level
    case ROUTE = 'route';                    // Street name (Via Roma, Piazza Duomo)
    case STREET_NUMBER = 'street_number';    // Street number (123, 1/A)

    // Administrative Divisions
    case LOCALITY = 'locality';              // Locality/frazione
    case ADMINISTRATIVE_AREA_LEVEL_3 = 'administrative_area_level_3';  // Comune
    case ADMINISTRATIVE_AREA_LEVEL_2 = 'administrative_area_level_2';  // Provincia
    case ADMINISTRATIVE_AREA_LEVEL_1 = 'administrative_area_level_1';  // Regione

    // Country Level
    case COUNTRY = 'country';                // Country name/code
    case POSTAL_CODE = 'postal_code';        // CAP/Postal code

    // Geocoding
    case FORMATTED_ADDRESS = 'formatted_address';  // Full formatted address
    case PLACE_ID = 'place_id';              // Google Places ID
    case LATITUDE = 'latitude';              // Geographic coordinates
    case LONGITUDE = 'longitude';            // Geographic coordinates
    case FAX = 'fax';                        // Fax number associated with address
    case MOBILE = 'mobile';                  // Mobile number associated with address
    case PEC = 'pec';                        // Certified Email Address (PEC)
    case WHATSAPP = 'whatsapp';              // WhatsApp number associated with address
    case EMAIL = 'email';                    // Email address associated with address
    case NOTES = 'notes';                    // General notes about the address
}
```

### Translation System

The enum uses the `TransTrait` to provide multilingual support:
- Translation keys follow pattern: `geo::address_item_enum.{value}.{property}`
- Supports Italian, English, and German
- Each value has: label, description, icon, and color

### Form Integration

The `getFormSchema()` method automatically creates Filament form fields:
```php
public static function getFormSchema(): array
{
    return Arr::map(
        self::cases(),
        fn($item) => TextInput::make($item->value)
            ->prefixIcon($item->getIcon())
    );
}
```

## Usage Patterns

### 1. Basic Address Form
```php
// In a Filament Resource
public static function form(Form $form): Form
{
    return $form->schema([
        TextInput::make('name')->label(AddressItemEnum::NAME->getLabel()),
        TextInput::make('route')->label(AddressItemEnum::ROUTE->getLabel()),
        TextInput::make('street_number')->label(AddressItemEnum::STREET_NUMBER->getLabel()),
        TextInput::make('postal_code')->label(AddressItemEnum::POSTAL_CODE->getLabel()),
        // ... other fields
    ]);
}
```

### 2. Dynamic Field Generation
```php
// Generate all address fields dynamically
foreach (AddressItemEnum::cases() as $enum) {
    $fields[] = TextInput::make($enum->value)
        ->label($enum->getLabel())
        ->prefixIcon($enum->getIcon())
        ->hint($enum->getDescription());
}
```

### 3. Validation Rules
```php
// Create validation rules based on enum
$rules = [];
foreach (AddressItemEnum::cases() as $enum) {
    $rules[$enum->value] = ['string', 'nullable'];
}
$rules['postal_code'] = ['required_with:route', 'postal_code:IT'];
```

### 4. Address Formatting
```php
public function formatAddress(array $addressData): string
{
    $parts = [
        $addressData[AddressItemEnum::ROUTE->value] ?? '',
        $addressData[AddressItemEnum::STREET_NUMBER->value] ?? '',
        $addressData[AddressItemEnum::POSTAL_CODE->value] ?? '',
        $addressData[AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_3->value] ?? '',
        $addressData[AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_2->value] ?? '',
        $addressData[AddressItemEnum::COUNTRY->value] ?? '',
    ];

    return implode(', ', array_filter($parts));
}
```

## Integration with Migrations

### Address Table Structure
The enum values should map directly to database columns:
```sql
CREATE TABLE addresses (
    name VARCHAR(255),                    -- AddressItemEnum::NAME
    description TEXT,                      -- AddressItemEnum::DESCRIPTION
    route VARCHAR(255),                    -- AddressItemEnum::ROUTE
    street_number VARCHAR(50),             -- AddressItemEnum::STREET_NUMBER
    locality VARCHAR(255),                 -- AddressItemEnum::LOCALITY
    administrative_area_level_3 VARCHAR(255), -- AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_3
    administrative_area_level_2 VARCHAR(255), -- AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_2
    administrative_area_level_1 VARCHAR(255), -- AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_1
    country VARCHAR(2),                    -- AddressItemEnum::COUNTRY
    postal_code VARCHAR(20),               -- AddressItemEnum::POSTAL_CODE
    formatted_address TEXT,                -- AddressItemEnum::FORMATTED_ADDRESS
    place_id VARCHAR(255),                 -- AddressItemEnum::PLACE_ID
    latitude DECIMAL(15,10),              -- AddressItemEnum::LATITUDE
    longitude DECIMAL(15,10),             -- AddressItemEnum::LONGITUDE
    phone VARCHAR(50),                     -- AddressItemEnum::PHONE
    fax VARCHAR(50),                       -- AddressItemEnum::FAX
    mobile VARCHAR(50),                    -- AddressItemEnum::MOBILE
    pec VARCHAR(255),                      -- AddressItemEnum::PEC
    whatsapp VARCHAR(50),                  -- AddressItemEnum::WHATSAPP
    email VARCHAR(255),                    -- AddressItemEnum::EMAIL
    notes TEXT                             -- AddressItemEnum::NOTES
);
```

### Migration helper: `AddressItemEnum::columns()`

Inspired by `NestedSet::columns($table)` di `kalnoy/laravel-nestedset`, `AddressItemEnum` espone un helper per aggiungere **tutti** i campi standard di indirizzo in una sola chiamata:

```php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Geo\Enums\AddressItemEnum;

Schema::create('addresses', function (Blueprint $table): void {
    $table->id();
    $table->nullableMorphs('addressable');

    // Aggiunge tutti i campi definiti da AddressItemEnum (route, street_number, ...)
    AddressItemEnum::columns($table);

    $table->json('extra_data')->nullable();
    $table->timestamps();
});
```

Caratteristiche:

- **DRY**: un solo punto di verità per nomi, tipi e commenti dei campi.
- **KISS**: le migration non devono più elencare manualmente 12+ colonne di indirizzo.
- **Compatibilità**: il flag opzionale `$withLegacy` permette di aggiungere anche i vecchi campi `address`, `city`, `province`, `region` quando serve interoperare con codice legacy.

Sono inoltre disponibili:

- `AddressItemEnum::dropColumns($table, bool $withLegacy = false)` per rimuovere i campi in rollback;
- `AddressItemEnum::getColumnNames(bool $withLegacy = false): array` per ottenere la lista dei nomi colonna (utile per select dinamiche, validazioni, ecc.).

### Client Table Integration
For the TechPlanner client table, the enum helps standardize address fields:
```php
// In migration
$table->string('address')->nullable();              // Maps to ROUTE
$table->string('street_number')->nullable();        // Maps to STREET_NUMBER
$table->string('city')->nullable();                 // Maps to ADMINISTRATIVE_AREA_LEVEL_3
$table->string('province')->nullable();             // Maps to ADMINISTRATIVE_AREA_LEVEL_2
$table->string('country')->nullable();              // Maps to COUNTRY
$table->string('postal_code')->nullable();          // Maps to POSTAL_CODE
$table->string('phone')->nullable();               // Maps to PHONE
$table->decimal('latitude', 12, 8)->nullable();    // Maps to LATITUDE
$table->decimal('longitude', 12, 8)->nullable();   // Maps to LONGITUDE
```

## Best Practices

### 1. Consistency
- Always use enum values instead of hardcoded strings
- Use the provided getter methods for labels and icons
- Maintain consistent naming across models and migrations

### 2. Validation
- Implement country-specific validation for postal codes
- Use regex patterns for phone numbers based on country
- Validate administrative hierarchies (e.g., valid province for region)

### 3. Performance
- Cache enum values when used frequently
- Use indexes on frequently searched address components
- Consider separate tables for administrative divisions

### 4. Extensibility
- When adding new enum values, update all three language files
- Maintain backward compatibility when modifying existing values
- Document any breaking changes

## Testing Strategies

### Unit Tests
```php
class AddressItemEnumTest extends TestCase
{
    /** @test */
    public function it_provides_correct_labels()
    {
        $this->assertEquals('Telefono', AddressItemEnum::PHONE->getLabel('it'));
        $this->assertEquals('Phone', AddressItemEnum::PHONE->getLabel('en'));
    }

    /** @test */
    public function it_generates_form_schema()
    {
        $schema = AddressItemEnum::getFormSchema();
        $this->assertCount(15, $schema);
        $this->assertArrayHasKey('phone', $schema);
    }
}
```

### Integration Tests
```php
class AddressIntegrationTest extends TestCase
{
    /** @test */
    public function it_saves_address_with_enum_fields()
    {
        $address = Address::create([
            'route' => 'Via Roma',
            'street_number' => '123',
            'postal_code' => '00100',
            // ... other fields
        ]);

        $this->assertDatabaseHas('addresses', [
            'route' => 'Via Roma',
            'street_number' => '123',
        ]);
    }
}
```

## Future Considerations

1. **Dynamic Validation**: Add country-specific validation rules
2. **Autocomplete Integration**: Use Place API for address completion
3. **Geocoding Service**: Implement automatic geocoding on save
4. **Address Verification**: Add postal code validation service
5. **Historical Tracking**: Track address changes over time

## Conclusion

The AddressItemEnum represents a **harmonious balance** between flexibility and structure. It provides a **semantic foundation** for address management that transcends mere field names, embodying the **Zen principle** of "one thing, well-defined" while accommodating the **complex reality** of global addressing systems.

By following this enum's philosophy, we achieve:
- **Code clarity** through semantic naming
- **International readiness** through multilingual support
- **UI consistency** through Filament integration
- **Maintainability** through centralized logic

This is not just an enum; it's a **comprehensive addressing philosophy** encoded in PHP.

## Da migliorare (DRY + KISS)

- **Allineare gli esempi di integrazione client**
  L'esempio "Client Table Integration" usa ancora alias storici (`address`, `city`, `province`, `country`, `phone`, `latitude`, `longitude`).
  Nel codice reale (TechPlanner) ora i campi sono direttamente `AddressItemEnum::ROUTE->value`, `ADMINISTRATIVE_AREA_LEVEL_3->value`, ecc.
  *Da fare*: aggiornare l'esempio per riflettere esattamente la migration `create_client_table` e distinguere chiaramente tra
  cache/denormalizzazione e fonte di verità (`addresses`).

- **Separare responsabilità tra indirizzo e contatti**
  Alcune sezioni mescolano ancora `PHONE` dentro l'address; nel progetto stiamo introducendo
  `ContactTypeEnum` per i canali di contatto (phone, mobile, email, pec, whatsapp, fax, notes).
  *Da fare*: documentare esplicitamente che `AddressItemEnum::PHONE` è legacy e che i nuovi moduli
  dovrebbero preferire `ContactTypeEnum` per DRY/KISS.

- **Esempi con AddressItemEnum::columns() / ensureColumns() aggiornati**
  La sezione migration mostra ancora esempi generici. Nel codice reale usiamo:
  `AddressItemEnum::columns($table, null, true)` in `tableCreate` e
  `AddressItemEnum::columns($table, $this, true)` (o helper dedicato) in `tableUpdate`.
  *Da fare*: aggiungere esempi completi per entrambi i blocchi (CREATE/UPDATE) in stile XotBaseMigration,
  così che chi legge possa copiare/incollare senza reinventare controlli `hasColumn()`.

- **Backlog validazione dinamica**
  La sezione "Future Considerations" elenca idee (validazione country-specific, autocomplete, tracking storico)
  ma non indica priorità né moduli impattati.
  *Da fare*: aggiungere una piccola roadmap (es. v1: CAP IT, v2: altri paesi, v3: autocomplete) collegata ai moduli
  che useranno queste feature (Geo, TechPlanner, eventuali CRM).

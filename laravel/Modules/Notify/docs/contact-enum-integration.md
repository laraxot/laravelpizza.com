# ContactTypeEnum Integration Guide

## Overview

`ContactTypeEnum` è il componente centrale per la gestione dei contatti nel sistema TechPlanner. Fornisce una struttura unificata per tutti i tipi di contatto (telefono, email, PEC, WhatsApp, ecc.) seguendo i principi dell'architettura Laraxot.

## Architettura

### 1. Enum come Single Source of Truth

```php
enum ContactTypeEnum: string implements HasColor, HasIcon, HasLabel
{
    case PHONE = 'phone';
    case MOBILE = 'mobile';
    case EMAIL = 'email';
    case PEC = 'pec';
    case WHATSAPP = 'whatsapp';
    case FAX = 'fax';
}
```

Ogni caso dell'enum rappresenta:
- **Nome del campo database** (`$value`)
- **Label tradotta** (`getLabel()`)
- **Icona Heroicon** (`getIcon()`)
- **Colore tematico** (`getColor()`)
- **Descrizione contestuale** (`getDescription()`)

### 2. Metodi Helper Centralizzati

#### `getFormSchema()`
Genera automaticamente tutti i campi form per Filament:
```php
return [
    'phone' => TextInput::make('phone')->prefixIcon('heroicon-o-phone'),
    'mobile' => TextInput::make('mobile')->prefixIcon('heroicon-o-device-phone-mobile'),
    'email' => TextInput::make('email')->prefixIcon('heroicon-o-envelope'),
    // ...
];
```

#### `columns()` per Migrazioni
Gestisce sia contesti CREATE che UPDATE:
```php
// CREATE: aggiunge tutte le colonne
ContactTypeEnum::columns($table);

// UPDATE: verifica esistenza prima di aggiungere
ContactTypeEnum::columns($table, $this);
```

## Integrazione nei Modelli

### Pattern Base

```php
<?php

class Client extends BaseModel
{
    use HasEnumFillable;

    protected $fillable = [
        'name',
        'assigned_worker_id',
        // Altri campi non-contatto
    ];

    public function hasContacts(): bool
    {
        return true; // Questo modello ha contatti
    }
}
```

### Trait HasEnumFillable

Il trait fornisce integrazione automatica:

```php
trait HasEnumFillable
{
    public function getFillable(): array
    {
        return array_merge(
            $this->fillable,
            $this->getEnumFillable()
        );
    }

    protected function getEnumFillable(): array
    {
        $fields = [];

        if ($this->hasContacts()) {
            $fields = array_merge($fields, ContactTypeEnum::getColumnNames());
        }

        return $fields;
    }
}
```

## Vantaggi Architetturali

### 1. **Manutenzione Centralizzata**
- Nuovo tipo di contatto? Solo nell'enum
- Modifica label/icone? Solo nei file di traduzione
- Rimozione campo? Solo nell'enum

### 2. **Coerenza Garantita**
- Stessi nomi campi in database, form e modello
- Stesse icone e colori in tutta l'applicazione
- Traduzioni automatiche in tutte le lingue

### 3. **Type Safety**
- PHP 8.1+ enum previene errori di battitura
- IDE support completo
- Refactoring sicuro

### 4. **Performance**
- Cache automatica dei nomi campi
- Lazy loading solo quando necessario
- Niente duplicazioni

## Best Practices

### 1. **Struttura delle Traduzioni**

```php
// lang/it/contact_type_enum.php
return [
    'phone' => [
        'label' => 'Telefono',
        'description' => 'Numero di telefono fisso',
        'icon' => 'heroicon-o-phone',
        'color' => 'primary',
    ],
    'mobile' => [
        'label' => 'Cellulare',
        'description' => 'Numero di cellulare',
        'icon' => 'heroicon-o-device-phone-mobile',
        'color' => 'primary',
    ],
    // ...
];
```

### 2. **Migrazioni Corrette**

```php
// CREATE
$this->tableCreate(function (Blueprint $table): void {
    $table->id();
    ContactTypeEnum::columns($table);
});

// UPDATE
$this->tableUpdate(function (Blueprint $table): void {
    ContactTypeEnum::updateColumns($table, $this);
});
```

### 3. **Form Filament**

```php
// Non creare manualmente i campi
ContactSection::make()->schema([
    TextInput::make('phone'), // ❌ Manuale
]);

// Usa lo schema generato dall'enum
ContactSection::make()->schema(
    ContactTypeEnum::getFormSchema() // ✅ Automatico
);
```

## Politica Laraxot

Secondo i principi Laraxot:

1. **Logic**: Struttura matematicamente precisa e prevedibile
2. **Philosophy**: DRY - Single Source of Truth nell'enum
3. **Politics**: Governance centralizzata dei contatti
4. **Religion**: Strong typing attraverso enum
5. **Zen**: Forma senza forma - i contatti esistono nell'enum ma si manifestano dove necessario

## Pattern da Evitare

### ❌ Definizione Manuale dei Campi
```php
protected $fillable = [
    'phone',
    'mobile',
    'email',
    'pec',
    'whatsapp',
    'fax',
];
```

### ❌ Logica Duplicata
```php
// In ogni modello che ha contatti
protected $fillable = [
    'name',
    'phone',
    'mobile',
    'email',
    // Duplicazione
];
```

### ❌ Hardcoding nelle Migrazioni
```php
$table->string('phone')->nullable();
$table->string('mobile')->nullable();
// Manuale e soggetto a errori
```

## Esempi di Utilizzo

### 1. **Modello con Contatti**
```php
class Client extends BaseModel
{
    use HasEnumFillable;

    public function hasContacts(): bool { return true; }
}
```

### 2. **Modello senza Contatti**
```php
class Product extends BaseModel
{
    use HasEnumFillable;

    public function hasContacts(): bool { return false; }
}
```

### 3. **Modello con Contatti Condizionali**
```php
class User extends BaseModel
{
    use HasEnumFillable;

    public function hasContacts(): bool
    {
        return $this->role === 'customer'; // Solo clienti hanno contatti
    }
}
```

## Testing

### 1. **Unit Tests per l'Enum**
```php
test('ContactTypeEnum provides correct field names', function () {
    $expected = ['phone', 'mobile', 'email', 'pec', 'whatsapp', 'fax'];
    expect(ContactTypeEnum::getColumnNames())->toBe($expected);
});
```

### 2. **Model Tests**
```php
test('Client fillable includes contact fields', function () {
    $client = new Client();
    $fillable = $client->getFillable();

    expect($fillable)->toContain('phone', 'mobile', 'email');
});
```

## Conclusione

`ContactTypeEnum` rappresenta l'approccio Laraxot alla gestione dei contatti: centralizzato, type-safe, manutenibile e coerente con il contesto business italiano. L'integrazione attraverso il trait `HasEnumFillable` garantisce consistenza in tutta l'applicazione mentre mantiene i modelli puliti e focalizzati sulla loro logica di business.

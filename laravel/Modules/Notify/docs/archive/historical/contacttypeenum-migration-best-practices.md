# ContactTypeEnum Migration Best Practices

## Overview

`ContactTypeEnum` fornisce un pattern centralizzato per la gestione dei campi contatto nelle migrazioni, ispirato al pattern `NestedSet::columns()` e ottimizzato per XotBaseMigration.

## Filosofia del Pattern

Il ContactTypeEnum segue i principi fondamentali del progetto:

- **Logica**: Definizione matematicamente precisa dei campi contatto
- **Filosofia**: Single Source of Truth (DRY principle)
- **Politica**: Governance centralizzata della struttura contatti
- **Religione**: Strong typing attraverso enum values
- **Zen**: Form without form - la struttura emerge dall'enum

## Campi Gestiti

ContactTypeEnum gestisce i seguenti campi:

| Campo | Tipo | Descrizione |
|-------|------|-------------|
| `phone` | string | Telefono fisso |
| `mobile` | string | Cellulare |
| `email` | string | Indirizzo email |
| `pec` | string | Posta Elettronica Certificata |
| `whatsapp` | string | Numero WhatsApp |
| `fax` | string | Fax |
| `notes` | text | Note aggiuntive |

## Pattern di Migrazione Base

### 1. Creazione Nuova Tabella

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Notify\Enums\ContactTypeEnum;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = ContactModel::class;

    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('name');

            // Campi contatto standard
            ContactTypeEnum::columns($table);

            $table->timestamps();
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            // Per aggiungere nuovi campi in modo sicuro
            ContactTypeEnum::updateColumns($table, $this);

            $this->updateTimestamps($table);
        });
    }
};
```

### 2. Tabella Esistente - Solo Update

```php
<?php

$this->tableUpdate(function (Blueprint $table): void {
    // Aggiungi tutti i campi contatto se mancanti
    ContactTypeEnum::updateColumns($table, $this);

    // Altri aggiornamenti specifici
    if (! $this->hasColumn('is_active')) {
        $table->boolean('is_active')->default(true);
    }
});
```

### 3. Combinato con Altri Enum

```php
<?php

use Modules\Geo\Enums\AddressItemEnum;
use Modules\Notify\Enums\ContactTypeEnum;

$this->tableCreate(function (Blueprint $table): void {
    $table->id();
    $table->string('name');

    // Indirizzo
    AddressItemEnum::columns($table);

    // Contatti
    ContactTypeEnum::columns($table);

    $table->timestamps();
});
```

## Pattern Avanzati

### 1. Modello con Contatti Multipli

```php
<?php

return new class extends XotBaseMigration
{
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('type'); // customer, supplier, etc.

            // Contatti principali
            ContactTypeEnum::columns($table);

            // Contatti secondari (con prefisso)
            $table->string('billing_email')->nullable();
            $table->string('shipping_phone')->nullable();

            $table->timestamps();
        });
    }
};
```

### 2. Tabella Contatti Separata

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = Contact::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Relazione polimorfa
            $table->morphs('contactable');

            // Tipo di contatto
            $table->string('type')->index(); // primary, billing, shipping

            // Valore del contatto (usa enum per validazione)
            $table->string('value');

            $table->timestamps();
        });
    }
};
```

### 3. Contatti con Validazioni

```php
<?php

$this->tableCreate(function (Blueprint $table): void {
    $table->id();
    $table->string('name');

    // Email unica
    $table->string('email')->unique()->nullable();

    // Phone unico
    $table->string('phone')->unique()->nullable();

    // Altri contatti non unici
    $table->string('mobile')->nullable();
    $table->string('whatsapp')->nullable();
    $table->string('fax')->nullable();
    $table->string('pec')->nullable();

    $table->text('notes')->nullable();

    $table->timestamps();
});
```

## Integrazione con Modelli Eloquent

### 1. Modello Base

```php
<?php

namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactModel extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'mobile',
        'email',
        'pec',
        'whatsapp',
        'fax',
        'notes',
    ];

    protected $casts = [
        'notes' => 'string',
    ];

    // Scopes per query comuni
    public function scopeHasEmail($query)
    {
        return $query->whereNotNull('email')->where('email', '!=', '');
    }

    public function scopeHasPhone($query)
    {
        return $query->whereNotNull('phone')->where('phone', '!=', '');
    }

    public function scopeHasMobile($query)
    {
        return $query->whereNotNull('mobile')->where('mobile', '!=', '');
    }

    // Accessors per formattazione
    public function getFormattedPhoneAttribute(): string
    {
        return $this->phone ? '+39 ' . $this->phone : '';
    }

    public function getPrimaryContactAttribute(): string
    {
        return $this->email ?? $this->phone ?? $this->mobile ?? '';
    }
}
```

### 2. Modello con Contatti Multipli

```php
<?php

namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ContactableModel extends Model
{
    public function contacts(): MorphMany
    {
        return $this->morphMany(Contact::class, 'contactable');
    }

    public function getPrimaryContact(): ?Contact
    {
        return $this->contacts()->where('type', 'primary')->first();
    }

    public function getBillingContact(): ?Contact
    {
        return $this->contacts()->where('type', 'billing')->first();
    }
}
```

## Integrazione con Filament

### 1. Form Component

```php
<?php

use Modules\Notify\Enums\ContactTypeEnum;

// In una Resource Form
protected function form(Form $form): Form
{
    return $form
        ->schema([
            // Campi base
            TextInput::make('name')
                ->required(),

            // Campi contatto da enum
            ...ContactTypeEnum::getFormSchema(),
        ]);
}
```

### 2. Table Column

```php
<?php

use Modules\Notify\Filament\Tables\Columns\ContactColumn;

// In una Resource Table
protected function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('name'),

            ContactColumn::make('contacts')
                ->label('Contacts'),
        ]);
}
```

### 3. Filter

```php
<?php

use Modules\Notify\Enums\ContactTypeEnum;

// In una Resource Table
protected function table(Table $table): Table
{
    return $table
        ->filters([
            SelectFilter::make('has_email')
                ->options([
                    'yes' => 'Has Email',
                    'no' => 'No Email',
                ])
                ->query(fn ($query, $data) =>
                    $data === 'yes'
                        ? $query->whereNotNull('email')
                        : $query->whereNull('email')
                ),
        ]);
}
```

## Best Practices Specifiche

### 1. Validazione Email

```php
// In una Request
public function rules(): array
{
    return [
        'email' => [
            'nullable',
            'email',
            'max:255',
            Rule::unique('contacts')->ignore($this->id),
        ],
        'pec' => [
            'nullable',
            'email',
            'max:255',
        ],
    ];
}
```

### 2. Formattazione Numeri

```php
// In un Observer o Model
protected static function booted(): void
{
    static::saving(function ($model) {
        // Rimuovi spazi e caratteri non numerici
        $model->phone = preg_replace('/\D/', '', $model->phone);
        $model->mobile = preg_replace('/\D/', '', $model->mobile);
        $model->whatsapp = preg_replace('/\D/', '', $model->whatsapp);
    });
}
```

### 3. Query Ottimizzate

```php
// Per trovare contatti duplicati
$duplicateEmails = ContactModel::select('email')
    ->whereNotNull('email')
    ->groupBy('email')
    ->havingRaw('COUNT(*) > 1')
    ->pluck('email');

// Per contatti completi
$completeContacts = ContactModel::whereNotNull('email')
    ->whereNotNull('phone')
    ->where(function ($query) {
        $query->whereNotNull('mobile')
              ->orWhereNotNull('whatsapp');
    })
    ->get();
```

## Troubleshooting

### 1. "Column already exists"

**Problema**: Tentativo di aggiungere colonne già esistenti.

**Soluzione**: Usa sempre `updateColumns()` negli UPDATE block:
```php
// ✅ CORRETTO
ContactTypeEnum::updateColumns($table, $this);

// ❌ SBAGLIATO
ContactTypeEnum::columns($table);
```

### 2. Performance con Tabelle Grandi

**Problema**: Migrazioni lente su tabelle con molti dati.

**Soluzioni**:
- Aggiungi indici dopo aver inserito i dati
- Usa batch operations per migrazioni dati
- Considera separare i contatti in tabella dedicata

### 3. Validazioni Complesse

**Problema**: Validazioni multiple sui campi contatto.

**Soluzione**: Crea un Form Request dedicato:
```php
class ContactRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'mobile' => ['nullable', 'string', 'max:20'],
            // ... altre regole
        ];
    }
}
```

## Riferimenti

- [AddressItemEnum Pattern](../Geo/docs/addressitemenum-migration-pattern.md)
- [XotBaseMigration Documentation](../../Xot/docs/migration-patterns.md)
- [Filament Integration](../../docs/filament-integration.md)
- [Laravel Migration Best Practices](https://laravel.com/docs/migrations)

## Note Tecniche

- ContactTypeEnum è compatibile con PHPStan livello 10
- Segue il pattern XotBaseMigration per sicurezza
- Integrato con il sistema di traduzioni del progetto
- Supporta validazioni automatiche tramite enum

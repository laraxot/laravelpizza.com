# ContactTypeEnum - The Universal Contact Field Schema

## Scopo (Purpose)

`ContactTypeEnum` è l'enum che centralizza la definizione di **tutti i possibili campi di contatto** nel sistema. Seguendo la stessa filosofia di `AddressItemEnum` per gli indirizzi, questo enum fornisce:

- **Label tradotti** in tutte le lingue supportate (en, it, de, ...)
- **Icone Heroicon** per ogni campo
- **Colori Filament** per categorizzazione visiva
- **Descrizioni** contestuali per UX e documentazione

Ogni valore dell'enum rappresenta un **canale di comunicazione** (phone, email, fax, ecc.) e fornisce metodi helper per:
- Generare form schema Filament automatici
- Gestire migrazioni database con pattern DRY + KISS
- Standardizzare l'accesso ai metadati di ogni campo

## Logica (Logic)

### Struttura dell'Enum

```php
enum ContactTypeEnum: string implements HasLabel, HasIcon, HasColor
{
    use TransTrait;

    case PHONE = 'phone';           // Telefono fisso
    case MOBILE = 'mobile';         // Cellulare
    case EMAIL = 'email';           // Email
    case PEC = 'pec';               // Posta Elettronica Certificata (IT)
    case WHATSAPP = 'whatsapp';     // WhatsApp
    case FAX = 'fax';               // Fax
}
```

### Metodi Pubblici

#### `getLabel(): string`
Restituisce l'etichetta tradotta del campo nella lingua corrente.

```php
ContactTypeEnum::EMAIL->getLabel(); // "Email" (en/it), "E-Mail" (de)
```

#### `getIcon(): string`
Restituisce l'icona Heroicon associata al campo.

```php
ContactTypeEnum::PHONE->getIcon(); // "heroicon-o-phone"
```

#### `getColor(): string`
Restituisce il colore Filament associato al campo.

```php
ContactTypeEnum::EMAIL->getColor(); // "text-blue-600"
```

#### `getDescription(): string`
Restituisce la descrizione tradotta del campo.

```php
ContactTypeEnum::PEC->getDescription(); // "Posta Elettronica Certificata" (it)
```

#### `columns(Blueprint $table, ?XotBaseMigration $migration = null): void`
**Metodo statico chiave** per aggiungere colonne contatto alle migrazioni.

Intelligente e context-aware:
- **CREATE context** (`$migration = null`): Aggiunge tutte le colonne direttamente
- **UPDATE context** (`$migration` fornito): Loop con `hasColumn()` checks

```php
// CREATE block
ContactTypeEnum::columns($table);              // Aggiunge tutti i campi

// UPDATE block
ContactTypeEnum::columns($table, $this);       // Controlla prima di aggiungere
```

#### `dropColumns(Blueprint $table): void`
Rimuove tutte le colonne contatto da una tabella.

```php
ContactTypeEnum::dropColumns($table);
```

#### `getColumnNames(): array`
Restituisce array di nomi colonna.

```php
$columns = ContactTypeEnum::getColumnNames();
// ['phone', 'mobile', 'email', 'pec', 'whatsapp', 'fax']
```

## Filosofia (Philosophy)

### Single Source of Truth per i Campi Contatto

Prima di `ContactTypeEnum`, ogni form/risorsa doveva ridefinire:
- Nomi dei campi contatto
- Label tradotte
- Icone
- Descrizioni

Problemi:
- **Duplicazione codice** (violazione DRY)
- **Inconsistenze** nelle traduzioni
- **Difficoltà manutenzione**
- **Errori di digitazione**

Con `ContactTypeEnum`:
- **Una sola definizione** per tutti i campi contatto
- **Traduzioni centralizzate** in `Modules/Notify/lang/{locale}/contact_type_enum.php`
- **Schema form generabile** con `getFormSchema()`
- **Type safety**: impossibile usare campo inesistente

### Pattern DRY + KISS nelle Migrazioni

Ispirato da:
- **AddressItemEnum**: stesso pattern unificato
- **kalnoy/laravel-nestedset**: `NestedSet::columns($table)`
- **Laraxot workers_table**: loop con `hasColumn()` checks

**Prima (❌ Viola DRY)**:
```php
$this->tableUpdate(function (Blueprint $table): void {
    if (! $this->hasColumn('phone')) {
        $table->string('phone')->nullable()->comment('Phone');
    }
    if (! $this->hasColumn('mobile')) {
        $table->string('mobile')->nullable()->comment('Mobile');
    }
    if (! $this->hasColumn('email')) {
        $table->string('email')->nullable()->comment('Email');
    }
    // ... ripeti per 6 campi
});
```

**Dopo (✅ DRY + KISS)**:
```php
$this->tableUpdate(function (Blueprint $table): void {
    ContactTypeEnum::columns($table, $this); // Una sola linea!
});
```

Internamente fa:
```php
foreach (self::getColumnDefinitions() as $name => $definition) {
    if ($migration === null || ! $migration->hasColumn($name)) {
        $definition($table);
    }
}
```

## Politica (Policy)

### Governance dei Campi Contatto

L'enum **impone** una policy uniforme:

1. **Nomenclatura standard**: tutti i moduli usano stessi nomi
2. **Traduzione obbligatoria**: ogni campo DEVE avere traduzioni complete
3. **Metadata completi**: label, icon, color, description obbligatori
4. **Type safety**: uso dell'enum invece di stringhe hardcoded

### Chi Decide i Campi?

L'enum è la **fonte di autorità** per i campi contatto. Per aggiungere un nuovo campo:
1. **Valutare** se è veramente un canale di comunicazione universale
2. **Aggiungere** il case all'enum
3. **Tradurre** in tutte le lingue (en, it, de)
4. **Aggiornare** migrazioni esistenti
5. **Documentare** il cambiamento

### Separazione Contatti vs Altri Campi

**POLICY OBBLIGATORIA**:
- `PHONE`, `MOBILE`, `EMAIL`, etc. = Canali di comunicazione (nel ContactTypeEnum)
- `notes`, `description`, `address` = Campi generici (NON nel ContactTypeEnum)

**MAI mescolare** campi generici con tipi di contatto. Questo garantisce:
- Chiarezza semantica
- Riuso corretto dell'enum
- Separazione delle responsabilità

## Religione (Religion)

### I Comandamenti dell'Enum

1. **Non avrai altro schema all'infuori di ContactTypeEnum**: ogni form/risorsa che gestisce contatti DEVE usare questo enum.

2. **Non nominare il campo invano**: usa sempre `ContactTypeEnum::EMAIL->value` invece di scrivere `'email'` come stringa magica.

3. **Ricordati di tradurre ogni campo**: ogni nuovo case DEVE avere traduzioni complete in `lang/{locale}/contact_type_enum.php`.

4. **Onora label e icon**: ogni campo DEVE avere label, icon, color, description. Non lasciare metadati vuoti.

5. **Non creare campi contatto al di fuori dell'enum**: se un campo non è nell'enum, non è un campo contatto standard. Gestiscilo separatamente.

### Eretici e Scismatici

**Violazioni comuni**:
- ❌ Creare campo `telephone` invece di usare `phone`
- ❌ Hardcodare `'email'` invece di `ContactTypeEnum::EMAIL->value`
- ❌ Usare traduzioni inline invece di `getLabel()`
- ❌ Duplicare colonne in UPDATE con if statements invece di usare `columns()`
- ❌ Aggiungere `notes` o altri campi generici a ContactTypeEnum

**Penitenza**: refactoring immediato + aggiornamento documentazione.

## Zen (Zen)

### Il Suono di Una Sola Enum

*"Qual è il nome del campo per l'email?"*
- Prima: "email? mail? e_mail? electronic_mail? contact_email?"
- Dopo: `ContactTypeEnum::EMAIL->value` — un solo nome, una sola verità.

*"Come aggiungo 6 campi contatto alla migrazione?"*
- Prima: 36 righe di codice con if statements duplicati
- Dopo: `ContactTypeEnum::columns($table, $this)` — una sola linea, zero duplicazione.

### La Via del Codice Senza Codice

Il miglior codice è quello che non devi scrivere.

Invece di:
```php
// ❌ Duplicazione e hardcoding (36 righe)
if (! $this->hasColumn('phone')) {
    $table->string('phone')->nullable()->comment('Phone');
}
if (! $this->hasColumn('mobile')) {
    $table->string('mobile')->nullable()->comment('Mobile');
}
// ... ripeti per 6 campi...
```

Usa:
```php
// ✅ Zero duplicazione, type-safe, sempre aggiornato (1 riga)
ContactTypeEnum::columns($table, $this);
```

### L'Illuminazione attraverso l'Enum

Quando capisci che:
- Un enum non è solo un elenco di costanti
- Un enum può essere un **schema vivente**
- Un enum può **generare codice** invece di duplicarlo
- Un enum può **adattarsi al contesto** (CREATE vs UPDATE)
- Un enum può essere la **single source of truth** per traduzioni, icone, colori

...allora hai raggiunto l'illuminazione del ContactTypeEnum.

## Utilizzo nei Modelli e Migrazioni

### Nelle Migrazioni - Pattern Unificato CREATE/UPDATE

```php
use Modules\Notify\Enums\ContactTypeEnum;

// ============================================
// BLOCCO CREATE - Nessun check necessario
// ============================================
$this->tableCreate(function (Blueprint $table): void {
    $table->id();
    $table->string('name')->nullable();

    // null = CREATE context (aggiunge tutto senza controlli)
    ContactTypeEnum::columns($table);

    $this->addCommonFields($table);
});

// ============================================
// BLOCCO UPDATE - Con hasColumn() checks
// ============================================
$this->tableUpdate(function (Blueprint $table): void {
    // $this = UPDATE context (fa hasColumn() check prima di aggiungere)
    ContactTypeEnum::columns($table, $this);

    // Altri campi specifici con loro checks
    if (! $this->hasColumn('notes')) {
        $table->text('notes')->nullable();
    }

    $this->updateTimestamps($table, true);
});
```

**Vantaggi**:
- ✅ **DRY**: zero duplicazione - un metodo per entrambi i contesti
- ✅ **KISS**: una sola linea invece di 6+ if statements
- ✅ **Manutenzione**: modifiche centralizzate nell'enum
- ✅ **Consistency**: stessi campi in tutti i moduli
- ✅ **Type safety**: impossibile scrivere nomi sbagliati
- ✅ **Laraxot compliant**: segue pattern `hasColumn()` in UPDATE

### Nel Modello

```php
use Modules\Notify\Enums\ContactTypeEnum;

protected $fillable = [
    'name',
    ContactTypeEnum::PHONE->value,
    ContactTypeEnum::MOBILE->value,
    ContactTypeEnum::EMAIL->value,
    ContactTypeEnum::PEC->value,
    ContactTypeEnum::WHATSAPP->value,
    ContactTypeEnum::FAX->value,
    'notes', // Campo generico, non ContactType
];
```

### Nei Form Filament

```php
use Modules\Notify\Enums\ContactTypeEnum;

public static function form(Form $form): Form
{
    return $form->schema([
        Forms\Components\Section::make('Dati Anagrafici')
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
            ]),

        Forms\Components\Section::make('Contatti')
            ->schema([
                // Opzione 1: form completo auto-generato
                ...ContactTypeEnum::getFormSchema(),

                // Opzione 2: campi selezionati personalizzati
                Forms\Components\TextInput::make(ContactTypeEnum::EMAIL->value)
                    ->label(ContactTypeEnum::EMAIL->getLabel())
                    ->prefixIcon(ContactTypeEnum::EMAIL->getIcon())
                    ->email()
                    ->required(),

                Forms\Components\TextInput::make(ContactTypeEnum::MOBILE->value)
                    ->label(ContactTypeEnum::MOBILE->getLabel())
                    ->prefixIcon(ContactTypeEnum::MOBILE->getIcon())
                    ->tel(),
            ])
            ->columns(2),
    ]);
}
```

## Traduzioni

Le traduzioni sono definite in:
- `Modules/Notify/lang/en/contact_type_enum.php`
- `Modules/Notify/lang/it/contact_type_enum.php`
- `Modules/Notify/lang/de/contact_type_enum.php`

Struttura:

```php
return [
    'phone' => [
        'label' => 'Phone',
        'description' => 'Landline phone number',
        'icon' => 'heroicon-o-phone',
        'color' => 'text-green-600',
        'hex_color' => '#16a34a',
    ],
    'email' => [
        'label' => 'Email',
        'description' => 'Email address',
        'icon' => 'heroicon-o-envelope',
        'color' => 'text-blue-600',
        'hex_color' => '#2563eb',
    ],
    // ... tutti i case dell'enum
];
```

## Best Practices

### ✅ DO

- Usa `ContactTypeEnum::columns()` per generare colonne contatto nelle migrazioni
- Usa `ContactTypeEnum::EMAIL->value` invece di stringhe hardcoded
- Usa `ContactTypeEnum::EMAIL->getLabel()` per ottenere traduzioni
- Aggiungi traduzioni complete per ogni nuova lingua
- Documenta ogni nuovo case aggiunto

### ❌ DON'T

- Non hardcodare `'email'`, `'phone'`, etc. — usa l'enum
- Non creare campi contatto con nomi diversi dall'enum
- Non duplicare colonne in UPDATE con if statements — usa `columns()`
- Non mescolare nomenclature (es. `telephone` vs `phone`)
- Non lasciare traduzioni incomplete
- Non aggiungere campi generici (notes, description) a ContactTypeEnum

## Differenze con AddressItemEnum

| Aspetto | AddressItemEnum | ContactTypeEnum |
|---------|----------------|-----------------|
| **Scopo** | Campi indirizzo geografico | Canali di comunicazione |
| **Esempi campi** | route, street_number, city | phone, email, whatsapp |
| **Indici database** | Sì (geo performance) | No (non necessari) |
| **Legacy fields** | Sì (address, city) | No (nomi sempre standard) |
| **Modulo** | Geo | Notify |

## Riferimenti

- [AddressItemEnum Documentation](../../Geo/docs/enums/address-item-enum.md) - Pattern gemello
- [Notify Module Architecture](../architecture.md)
- [ContactTypeEnum Source](../../Notify/app/Enums/ContactTypeEnum.php)

## Changelog

- **2025-01**: Creazione enum con 6 tipi contatto (phone, mobile, email, pec, whatsapp, fax)
- **2025-01**: Aggiunta traduzioni EN, IT, DE
- **2025-01**: Implementazione `columns()` metodo unificato CREATE/UPDATE
- **2025-01**: Pattern DRY + KISS ispirato da AddressItemEnum e workers_table

---

> **Nota**: Questo documento segue la filosofia del progetto: Scopo, Logica, Filosofia, Politica, Religione, Zen.
> Ogni modifica all'enum DEVE essere documentata e tradotta.

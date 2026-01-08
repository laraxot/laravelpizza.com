# Convenzioni per i Campi dei Nomi Personali

## Regola Fondamentale

In tutto il progetto il progetto, utilizziamo:

1. **SEMPRE** `first_name` e `last_name` per i campi relativi ai nomi delle persone, e **MAI** `name` e `surname`.

2. **SEMPRE** `full_name` quando si richiede il nome completo in un unico campo, e **MAI** `name` o `complete_name`.

> **IMPORTANTE**: Per dettagli specifici sull'uso del campo `full_name`, consultare la [documentazione dedicata](./full-name-field.md).

```php
// ✅ CORRETTO
$table->string('first_name');
$table->string('last_name');

// ✅ CORRETTO
$table->string('full_name');

// ❌ ERRATO
$table->string('name');
$table->string('surname');
```

## Motivazioni

### 1. Standardizzazione Internazionale

L'utilizzo di `first_name` e `last_name` è uno standard internazionale riconosciuto, mentre `name` e `surname` possono variare tra diverse lingue e culture:

- `first_name` è universalmente compreso come "nome" in italiano o "given name" in inglese
- `last_name` è universalmente compreso come "cognome" in italiano o "family name" in inglese

### 2. Compatibilità con API e Librerie

La maggior parte delle API e librerie internazionali utilizzano `first_name` e `last_name` come convenzione standard:

- Stripe, PayPal, e altri gateway di pagamento
- Servizi di autenticazione OAuth (Google, Facebook, ecc.)
- Librerie per la gestione dei contatti

### 3. Chiarezza Semantica

- `name` è ambiguo: potrebbe riferirsi al nome completo o solo al nome di battesimo
- `first_name` e `last_name` sono espliciti e non lasciano spazio a interpretazioni

### 4. Coerenza nel Database

L'utilizzo coerente di `first_name` e `last_name` in tutto il database:
- Facilita le query e le join
- Semplifica la creazione di viste e report
- Migliora la manutenibilità del codice

### 5. Localizzazione e Internazionalizzazione

In alcune culture, l'ordine dei nomi è invertito (cognome prima del nome). Utilizzare `first_name` e `last_name` rende più chiaro quale campo contiene quale informazione, indipendentemente dall'ordine di visualizzazione.

## Implementazione

### Database Migrations

```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('first_name');
    $table->string('last_name');
    // ...
});
```

### Modelli

```php
class User extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        // ...
    ];
    
    // Accessor per il nome completo
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
```

### Filament Forms

```php
public static function form(Form $form): Form
{
    return $form
        ->schema([
            TextInput::make('first_name')
                ->label(trans('user.fields.first_name.label'))
                ->required(),
                
            TextInput::make('last_name')
                ->label(trans('user.fields.last_name.label'))
                ->required(),
            // ...
        ]);
}
```

### Traduzioni

```php
// it/user.php
return [
    'fields' => [
        'first_name' => [
            'label' => 'Nome',
        ],
        'last_name' => [
            'label' => 'Cognome',
        ],
    ],
];

// en/user.php
return [
    'fields' => [
        'first_name' => [
            'label' => 'First Name',
        ],
        'last_name' => [
            'label' => 'Last Name',
        ],
    ],
];
```

## Gestione dei Casi Particolari

### Nome Completo

Se è necessario memorizzare o visualizzare il nome completo, utilizzare un accessor nel modello:

```php
public function getFullNameAttribute(): string
{
    return "{$this->first_name} {$this->last_name}";
}
```

### Nomi Multipli

Per persone con più nomi (es. "Maria Luisa"), utilizzare comunque `first_name` per tutti i nomi di battesimo:

```
first_name: "Maria Luisa"
last_name: "Rossi"
```

### Titoli e Suffissi

Per titoli (Dott., Prof.) e suffissi (Jr., Sr.), utilizzare campi separati:

```php
$table->string('title')->nullable(); // Dott., Prof., ecc.
$table->string('first_name');
$table->string('last_name');
$table->string('suffix')->nullable(); // Jr., Sr., ecc.
```

## Collegamenti Bidirezionali

- [Convenzioni di Nomenclatura](../naming-conventions.md)
- [Linee Guida per i Database](../database-guidelines.md)
- [Traduzioni](../translations.md)

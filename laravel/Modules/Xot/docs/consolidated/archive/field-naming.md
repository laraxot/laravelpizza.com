# Convenzioni Naming Campi Database

## Regole Fondamentali

### 1. Nomi Personali
**Regola**: Usare sempre `first_name` e `last_name`, MAI `surname` o `name`

#### Motivazione
1. **Internazionalizzazione**
   - Diverse culture hanno ordini diversi per i nomi
   - Alcuni paesi usano più di due nomi
   - Supporto per caratteri non-ASCII

2. **Standard Industriali**
   - Compatibilità con API esterne
   - Conformità con sistemi CRM
   - Facilità di integrazione

3. **Chiarezza Semantica**
   - `first_name`: nome di battesimo
   - `last_name`: cognome di famiglia
   - Evita ambiguità con altri tipi di "name" nel sistema

### Implementazione

```php
// Schema Migration
public function up()
{
    Schema::create('patients', function (Blueprint $table) {
        $table->id();
        $table->string('first_name');  // ✓ CORRETTO
        $table->string('last_name');   // ✓ CORRETTO
        // $table->string('surname');   // ✗ ERRATO
        // $table->string('name');      // ✗ ERRATO
        $table->timestamps();
    });
}

// Model
class Patient extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
    ];

    // Accessor per nome completo
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
```

### Validazione

```php
// Form Request
public function rules()
{
    return [
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
    ];
}

// Messaggi di errore personalizzati
public function messages()
{
    return [
        'first_name.required' => 'Il nome è obbligatorio',
        'last_name.required' => 'Il cognome è obbligatorio',
    ];
}
```

### File di Traduzione

```php
// resources/lang/it/fields.php
return [
    'first_name' => [
        'label' => 'Nome',
        'placeholder' => 'Inserisci il nome',
        'help' => 'Nome di battesimo',
    ],
    'last_name' => [
        'label' => 'Cognome',
        'placeholder' => 'Inserisci il cognome',
        'help' => 'Cognome di famiglia',
    ],
];
```

### Filament Forms

```php
use Filament\Forms\Components\TextInput;

public static function form(Form $form): Form
{
    return $form->schema([
        TextInput::make('first_name')
            ->required()
            ->maxLength(255),
        TextInput::make('last_name')
            ->required()
            ->maxLength(255),
    ]);
}
```

## Best Practices

1. **Coerenza**
   - Usare sempre lo stesso naming in tutti i moduli
   - Mantenere la coerenza anche nelle API
   - Documentare chiaramente nei commenti

2. **Migrazione da Sistemi Legacy**
   ```php
   // In caso di migrazione da vecchi sistemi
   protected $casts = [
       'surname' => 'last_name',  // Map vecchio campo a nuovo
       'name' => 'first_name',    // Map vecchio campo a nuovo
   ];
   ```

3. **Validazione Internazionale**
   ```php
   // Supporto per caratteri internazionali
   'first_name' => ['required', 'string', 'max:255', 'regex:/^[\pL\s\-]+$/u'],
   'last_name' => ['required', 'string', 'max:255', 'regex:/^[\pL\s\-]+$/u'],
   ```

## Note Importanti

1. **Ordine dei Nomi**
   - Alcuni paesi (es. Ungheria, Giappone) mettono il cognome prima del nome
   - Implementare un flag `name_order` per gestire queste differenze
   - Fornire helper per la formattazione corretta

2. **Caratteri Speciali**
   - Supportare caratteri accentati
   - Gestire apostrofi e trattini
   - Considerare la normalizzazione Unicode

3. **Privacy e GDPR**
   - Implementare la cifratura dove necessario
   - Gestire correttamente il diritto all'oblio
   - Documentare il trattamento dei dati personali

## Collegamenti
- [Database Schema Guidelines](../database/schema.md)
- [Internationalization Guide](../i18n/guide.md)
- [GDPR Compliance](../gdpr/compliance.md) 
# Generazione di Slug in Filament

## Panoramica
Questo documento analizza l'approccio alla generazione di slug in Filament, basato sull'articolo di [Laravel News](https://laravel-news.com/generating-slugs-from-a-title-in-filament).

## Approccio Base

### 1. Implementazione Semplice
```php
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;

TextInput::make('name')
    ->required()
    ->live()
    ->afterStateUpdated(function ($state, callable $set) {
        $set('slug', Str::slug($state));
    }),

TextInput::make('slug')
    ->required()
    ->unique(ignoreRecord: true)
```

### 2. Vantaggi
- **Semplicità**: Implementazione diretta
- **Nessuna Dipendenza**: Utilizzo di componenti nativi
- **Flessibilità**: Facile personalizzazione
- **Performance**: Leggero e veloce

## Approccio Avanzato

### 1. Trait Riutilizzabile
```php
namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    public static function bootHasSlug()
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('name') && !$model->isDirty('slug')) {
                $model->slug = Str::slug($model->name);
            }
        });
    }
}
```

### 2. Implementazione nel Modello
```php
use App\Traits\HasSlug;

class MailTemplate extends Model
{
    use HasSlug;
    
    protected $fillable = ['name', 'slug'];
}
```

## Best Practices

### 1. Validazione
```php
TextInput::make('slug')
    ->required()
    ->unique(ignoreRecord: true)
    ->rules([
        'required',
        'string',
        'max:255',
        'regex:/^[a-z0-9-]+$/',
    ])
```

### 2. Gestione Unicità
```php
TextInput::make('slug')
    ->unique(
        table: 'mail_templates',
        column: 'slug',
        ignoreRecord: true,
        callback: function ($query) {
            return $query->where('is_active', true);
        }
    )
```

### 3. Personalizzazione Slug
```php
TextInput::make('name')
    ->afterStateUpdated(function ($state, callable $set) {
        $slug = Str::slug($state);
        $count = 1;
        
        while (MailTemplate::where('slug', $slug)->exists()) {
            $slug = Str::slug($state) . '-' . $count++;
        }
        
        $set('slug', $slug);
    })
```

## Integrazione con Filament

### 1. Form Resource
```php
public static function form(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
{
    return $form
        ->schema([
            TextInput::make('name')
                ->required()
                ->live()
                ->afterStateUpdated(function ($state, callable $set) {
                    $set('slug', Str::slug($state));
                }),
            TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true)
                ->helperText('Generato automaticamente dal nome')
        ]);
}
```

### 2. Table Resource
```php
public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('name')
                ->searchable()
                ->sortable(),
            TextColumn::make('slug')
                ->searchable()
                ->sortable()
                ->copyable()
        ]);
}
```

## Considerazioni Tecniche

### 1. Performance
- **Query Ottimizzazione**: Indici su slug
- **Cache**: Possibilità di caching
- **Lazy Loading**: Caricamento on-demand

### 2. Sicurezza
- **Validazione**: Sanitizzazione input
- **Unicità**: Controllo duplicati
- **Accesso**: Controllo permessi

### 3. Manutenibilità
- **Codice**: Struttura pulita
- **Testing**: Facile testabilità
- **Documentazione**: Chiara e completa

## Confronto con Altri Approcci

### 1. vs Package Dedicato
- **Vantaggi**:
  - Nessuna dipendenza esterna
  - Controllo completo
  - Personalizzazione totale
- **Svantaggi**:
  - Manutenzione manuale
  - Meno feature out-of-box

### 2. vs Soluzione Custom
- **Vantaggi**:
  - Integrazione nativa
  - Performance ottimizzata
  - Codice pulito
- **Svantaggi**:
  - Implementazione manuale
  - Testing necessario

## Esempi di Utilizzo

### 1. Base
```php
TextInput::make('name')
    ->required()
    ->live()
    ->afterStateUpdated(fn ($state, $set) => 
        $set('slug', Str::slug($state))
    )
```

### 2. Avanzato
```php
TextInput::make('name')
    ->required()
    ->live()
    ->afterStateUpdated(function ($state, $set) {
        $baseSlug = Str::slug($state);
        $slug = $baseSlug;
        $count = 1;
        
        while (MailTemplate::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count++;
        }
        
        $set('slug', $slug);
    })
```

## Note di Implementazione

### 1. Database
- Indice su slug
- Validazione a livello DB
- Gestione migrazioni

### 2. Testing
- Unit test per generazione
- Integration test per unicità
- Feature test per UI

### 3. Deployment
- Migrazione dati esistenti
- Backup prima modifica
- Monitoraggio performance

## Collegamenti
- [Laravel News Article](https://laravel-news.com/generating-slugs-from-a-title-in-filament)
- [Filament Documentation](https://filamentphp.com/docs)
- [Laravel Str Helper](https://laravel.com/docs/helpers#method-str-slug) 

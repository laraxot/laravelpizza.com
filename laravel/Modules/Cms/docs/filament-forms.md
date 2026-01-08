# Utilizzo dei Widget Filament per i Form

## Indice
- [Introduzione](#introduzione)
- [Architettura dei Form](#architettura-dei-form)
- [Vantaggi dei Widget Filament](#vantaggi-dei-widget-filament)
- [Implementazione](#implementazione)
- [Best Practices](#best-practices)
- [Esempi Pratici](#esempi-pratici)
- [Estensione e Personalizzazione](#estensione-e-personalizzazione)

## Introduzione

Questo modulo utilizza esclusivamente i widget Filament per la creazione e gestione dei form. Questa scelta architetturale offre numerosi vantaggi in termini di consistenza, manutenibilità e velocità di sviluppo. Questo documento spiega in dettaglio perché è stata adottata questa strategia e come implementarla correttamente.

## Architettura dei Form

L'architettura dei form nel sistema è basata su Filament, un framework di amministrazione per Laravel che fornisce un insieme completo di componenti per la creazione di interfacce utente. I form sono definiti utilizzando un approccio dichiarativo attraverso il metodo `getFormSchema()` nei Resource di Filament.

### Struttura Base

La struttura base di un form Filament è definita nella classe astratta `XotBaseResource`, che tutti i Resource del sistema estendono:

```php
abstract class XotBaseResource extends FilamentResource
{
    // ...
    
    /**
     * @return array<string|int,\Filament\Forms\Components\Component>
     */
    abstract public static function getFormSchema(): array;

    final public static function form(Form $form): Form
    {
        return $form
            ->schema(static::getFormSchema());
    }
    
    // ...
}
```

Ogni Resource deve implementare il metodo `getFormSchema()` che restituisce un array di componenti Filament che definiscono la struttura del form.

## Vantaggi dei Widget Filament

L'utilizzo esclusivo dei widget Filament per i form offre numerosi vantaggi:

### 1. Consistenza dell'Interfaccia Utente

Utilizzando lo stesso sistema di componenti per tutti i form, si garantisce una consistenza visiva e funzionale in tutta l'applicazione. Questo migliora l'esperienza utente e riduce la curva di apprendimento.

### 2. Validazione Integrata

I widget Filament integrano meccanismi di validazione avanzati che seguono le convenzioni di Laravel, permettendo di definire regole di validazione direttamente nella definizione del campo:

```php
Forms\Components\TextInput::make('title')
    ->required()
    ->maxLength(255)
    ->unique(ignorable: fn ($record) => $record)
```

### 3. Tipizzazione Forte

I componenti Filament supportano la tipizzazione forte, migliorando la robustezza del codice e facilitando il refactoring:

```php
Forms\Components\TextInput::make('email')
    ->email()
    ->required()
```

### 4. Riutilizzabilità dei Componenti

I componenti Filament possono essere facilmente riutilizzati in diversi contesti, riducendo la duplicazione del codice:

```php
// Definizione di un componente riutilizzabile
public static function addressFields(): array
{
    return [
        Forms\Components\TextInput::make('address_line_1')->required(),
        Forms\Components\TextInput::make('address_line_2'),
        Forms\Components\TextInput::make('city')->required(),
        Forms\Components\TextInput::make('postal_code')->required(),
    ];
}

// Utilizzo in un form
public static function getFormSchema(): array
{
    return [
        // ... altri campi
        Forms\Components\Section::make('Indirizzo')->schema(self::addressFields()),
        // ... altri campi
    ];
}
```

### 5. Integrazione con il Sistema di Autorizzazioni

I widget Filament si integrano perfettamente con il sistema di autorizzazioni di Laravel, permettendo di controllare l'accesso ai campi in base ai permessi dell'utente:

```php
Forms\Components\TextInput::make('salary')
    ->visible(fn () => auth()->user()->can('view_salaries'))
```

### 6. Supporto per Relazioni Complesse

I widget Filament offrono un supporto avanzato per la gestione delle relazioni tra modelli, semplificando la creazione di form con relazioni one-to-many, many-to-many, ecc.:

```php
Forms\Components\Select::make('categories')
    ->multiple()
    ->relationship('categories', 'name')
```

### 7. Estensibilità

Il sistema di componenti Filament è facilmente estensibile, permettendo di creare componenti personalizzati per esigenze specifiche.

## Implementazione

Per implementare un form utilizzando i widget Filament, è necessario seguire questi passaggi:

### 1. Creare un Resource

```php
namespace Modules\Cms\Filament\Resources;

use Filament\Forms;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Cms\Models\Page;

class PageResource extends XotBaseResource
{
    protected static ?string $model = Page::class;
    
    // ...
}
```

### 2. Definire lo Schema del Form

```php
public static function getFormSchema(): array
{
    return [
        Forms\Components\TextInput::make('title')
            ->required()
            ->maxLength(255),
            
        Forms\Components\TextInput::make('slug')
            ->required()
            ->unique(ignorable: fn ($record) => $record),
            
        Forms\Components\RichEditor::make('content')
            ->columnSpanFull(),
    ];
}
```

### 3. Personalizzare il Comportamento dei Campi

```php
Forms\Components\TextInput::make('title')
    ->required()
    ->lazy()
    ->afterStateUpdated(static function ($set, $get, $state): void {
        if ($get('slug')) {
            return;
        }
        $set('slug', Str::slug($state));
    })
```

## Best Practices

Per utilizzare al meglio i widget Filament per i form, è consigliabile seguire queste best practices:

### 1. Organizzare i Campi in Sezioni

```php
public static function getFormSchema(): array
{
    return [
        Forms\Components\Section::make('Informazioni Base')
            ->schema([
                // Campi per le informazioni base
            ]),
            
        Forms\Components\Section::make('Contenuto')
            ->schema([
                // Campi per il contenuto
            ]),
    ];
}
```

### 2. Utilizzare Grid per Layout Responsivi

```php
Forms\Components\Grid::make()
    ->columns(12)
    ->schema([
        Forms\Components\TextInput::make('first_name')
            ->columnSpan(6),
            
        Forms\Components\TextInput::make('last_name')
            ->columnSpan(6),
            
        Forms\Components\Textarea::make('bio')
            ->columnSpan(12),
    ])
```

### 3. Creare Componenti Personalizzati per Logiche Ripetitive

```php
class AddressFields
{
    public static function make(): array
    {
        return [
            // ... campi per l'indirizzo
        ];
    }
}

// Utilizzo
public static function getFormSchema(): array
{
    return [
        // ...
        Forms\Components\Section::make('Indirizzo')
            ->schema(AddressFields::make()),
        // ...
    ];
}
```

### 4. Utilizzare Tabs per Form Complessi

```php
Forms\Components\Tabs::make('Tabs')
    ->tabs([
        Forms\Components\Tabs\Tab::make('Informazioni Generali')
            ->schema([
                // ...
            ]),
            
        Forms\Components\Tabs\Tab::make('Contenuto')
            ->schema([
                // ...
            ]),
            
        Forms\Components\Tabs\Tab::make('SEO')
            ->schema([
                // ...
            ]),
    ])
```

## Esempi Pratici

### Esempio: Form per una Pagina

```php
public static function getFormSchema(): array
{
    return [
        Forms\Components\Grid::make()->columns(2)->schema([
            Forms\Components\TextInput::make('title')
                ->columnSpan(1)
                ->required()
                ->lazy()
                ->afterStateUpdated(static function ($set, $get, $state): void {
                    if ($get('slug')) {
                        return;
                    }
                    $set('slug', Str::slug($state));
                }),

            Forms\Components\TextInput::make('slug')
                ->required()
                ->columnSpan(1)
                ->afterStateUpdated(static fn ($set, $state) => $set('slug', Str::slug($state))),
        ]),
        
        Forms\Components\Section::make('Contenuto della Pagina')->schema([
            PageContent::make('content_blocks')
                ->label('Blocchi Contenuto')
                ->required()
                ->columnSpanFull(),
        ]),

        Forms\Components\Section::make('Contenuto Sidebar')->schema([
            LeftSidebarContent::make('sidebar_blocks')
                ->label('Blocchi Sidebar')
                ->columnSpanFull(),
        ]),
    ];
}
```

## Estensione e Personalizzazione

Il sistema di widget Filament può essere esteso e personalizzato in vari modi:

### 1. Creare Componenti Personalizzati

```php
namespace Modules\Cms\Filament\Fields;

use Filament\Forms\Components\Field;

class PageContent extends Field
{
    // Implementazione del componente personalizzato
}
```

### 2. Estendere Componenti Esistenti

```php
namespace Modules\Cms\Filament\Fields;

use Filament\Forms\Components\RichEditor;

class EnhancedRichEditor extends RichEditor
{
    // Estensione del componente RichEditor
}
```

### 3. Utilizzare Traits per Funzionalità Comuni

```php
namespace Modules\Cms\Filament\Traits;

trait HasSeoFields
{
    public static function getSeoFields(): array
    {
        return [
            // Campi SEO
        ];
    }
}

// Utilizzo
class PageResource extends XotBaseResource
{
    use HasSeoFields;
    
    public static function getFormSchema(): array
    {
        return [
            // ...
            Forms\Components\Section::make('SEO')
                ->schema(self::getSeoFields()),
            // ...
        ];
    }
}
```

## Conclusione

L'utilizzo esclusivo dei widget Filament per i form rappresenta una scelta architetturale che offre numerosi vantaggi in termini di consistenza, manutenibilità e velocità di sviluppo. Seguendo le best practices e sfruttando le funzionalità avanzate di Filament, è possibile creare form robusti, tipizzati e facilmente manutenibili.

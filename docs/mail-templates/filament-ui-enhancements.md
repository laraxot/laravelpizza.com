# Miglioramenti UI/UX per MailTemplateResource

## Componenti Filament Consigliati

### 1. TextInput con Slug Generation
```php
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;

// Nel form di MailTemplateResource
TextInput::make('name')
    ->label('Nome Template')
    ->required()
    ->live()
    ->afterStateUpdated(function ($state, callable $set) {
        $set('slug', Str::slug($state));
    })
    ->suffixAction(
        Action::make('generateSlug')
            ->icon('heroicon-m-sparkles')
            ->action(function ($state, callable $set) {
                $set('slug', Str::slug($state));
            })
    ),

TextInput::make('slug')
    ->label('Slug')
    ->required()
    ->unique(ignoreRecord: true)
    ->prefix('template/')
    ->suffixIcon('heroicon-m-link')
    ->helperText('Lo slug verrà utilizzato per identificare il template')
```

### 2. Input Group con Preview
```php
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Group;

Group::make()
    ->schema([
        TextInput::make('name')
            ->label('Nome Template')
            ->required()
            ->live()
            ->afterStateUpdated(function ($state, callable $set) {
                $set('slug', Str::slug($state));
            }),
        TextInput::make('slug')
            ->label('Slug')
            ->required()
            ->unique(ignoreRecord: true)
            ->prefix('template/')
    ])
    ->columnSpan('full')
```

### 3. Card con Preview Live
```php
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\View;

Card::make()
    ->schema([
        TextInput::make('name')
            ->label('Nome Template')
            ->required()
            ->live(),
        TextInput::make('slug')
            ->label('Slug')
            ->required()
            ->unique(ignoreRecord: true)
            ->prefix('template/'),
        View::make('notify::preview-slug')
            ->viewData([
                'name' => fn ($get) => $get('name'),
                'slug' => fn ($get) => $get('slug'),
            ])
    ])
```

## Miglioramenti UI/UX Proposti

### 1. Validazione Visiva
- **Icone di Stato**: Mostrare icone per validazione
- **Colori Dinamici**: Feedback visivo immediato
- **Messaggi Contestuali**: Helper text dinamici

### 2. Interazione
- **Auto-completamento**: Suggerimenti basati su template esistenti
- **Drag & Drop**: Riorganizzazione template
- **Quick Actions**: Azioni rapide per slug

### 3. Preview
- **Anteprima Live**: Visualizzazione in tempo reale
- **URL Preview**: Come apparirà l'URL
- **Template Preview**: Anteprima del template

## Best Practices Filament

### 1. Layout
- Utilizzare `columnSpan` per layout responsive
- Implementare `grid` per organizzazione ottimale
- Sfruttare `section` per raggruppamento logico

### 2. Interattività
- Utilizzare `live()` per aggiornamenti real-time
- Implementare `afterStateUpdated` per logica
- Sfruttare `suffixAction` per azioni rapide

### 3. Validazione
- Utilizzare `unique()` con `ignoreRecord`
- Implementare `rules()` per validazione custom
- Sfruttare `helperText()` per feedback

## Esempi di Implementazione

### 1. Form Completo
```php
public static function form(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
{
    return $form
        ->schema([
            Section::make('Informazioni Template')
                ->schema([
                    TextInput::make('name')
                        ->label('Nome Template')
                        ->required()
                        ->live()
                        ->afterStateUpdated(function ($state, callable $set) {
                            $set('slug', Str::slug($state));
                        })
                        ->suffixAction(
                            Action::make('generateSlug')
                                ->icon('heroicon-m-sparkles')
                                ->action(function ($state, callable $set) {
                                    $set('slug', Str::slug($state));
                                })
                        ),
                    TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->prefix('template/')
                        ->suffixIcon('heroicon-m-link')
                        ->helperText('Lo slug verrà utilizzato per identificare il template')
                ])
                ->columns(2)
        ]);
}
```

### 2. Table View
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
                ->tooltip('Clicca per copiare lo slug')
        ]);
}
```

## Considerazioni

### 1. Performance
- Ottimizzare query live
- Gestire cache per preview
- Limitare aggiornamenti real-time

### 2. UX
- Fornire feedback immediato
- Mantenere coerenza visiva
- Facilitare la navigazione

### 3. Manutenibilità
- Documentare componenti custom
- Mantenere codice pulito
- Seguire convenzioni Filament

## Collegamenti
- [Documentazione Filament Forms](https://filamentphp.com/docs/3.x/forms/installation)
- [Componenti Blade Filament](https://filamentphp.com/docs/3.x/support/blade-components)
- [Best Practices UI/UX](https://filamentphp.com/docs/3.x/panels/resources/getting-started) 

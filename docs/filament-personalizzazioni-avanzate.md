# Personalizzazioni Avanzate di Filament in il progetto

Questa guida illustra le tecniche avanzate per personalizzare Filament all'interno del framework il progetto, con particolare attenzione alle funzionalità che migliorano l'esperienza utente e la manutenibilità del codice.

## Indice
1. [Personalizzazione della Navigazione](#personalizzazione-della-navigazione)
2. [Gestione delle Relazioni](#gestione-delle-relazioni)
3. [Stili Condizionali](#stili-condizionali)
4. [Ottimizzazione del Codice](#ottimizzazione-del-codice)
5. [Breadcrumbs](#breadcrumbs)
6. [Menu Utente](#menu-utente)
7. [Best Practices in il progetto](#best-practices-in-<nome progetto>)

## Personalizzazione della Navigazione

### Gruppi di Navigazione

I gruppi di navigazione consentono di organizzare le risorse in categorie logiche:

```php
// In Modules\NomeModulo\Filament\Resources\MiaRisorsa.php
protected static ?string $navigationGroup = 'Amministrazione';

// Ordinamento dei gruppi
public static function getNavigationGroups(): array
{
    return [
        NavigationGroup::make()
            ->label('Principale')
            ->icon('heroicon-o-home')
            ->collapsed(), // Gruppo inizialmente collassato
        NavigationGroup::make()
            ->label('Amministrazione')
            ->icon('heroicon-o-cog')
            ->collapsible(false), // Gruppo non collassabile
    ];
}
```

### Sub-Navigazione per Risorse

Filament supporta la sub-navigazione all'interno delle risorse, utile per risorse complesse:

```php
protected static ?string $navigationLabel = 'Utenti';

public static function getRecordSubNavigation(Page $page): array
{
    return $page->generateNavigationItems([
        Pages\ViewUser::class,
        Pages\EditUser::class,
        Pages\ManageUserPermissions::class,
    ]);
}
```

### Sidebar Collassabile

Per ottimizzare lo spazio sullo schermo, è possibile rendere la sidebar collassabile:

```php
// In Modules\NomeModulo\Providers\FilamentServiceProvider.php
public function panel(Panel $panel): Panel
{
    return $panel
        ->collapsibleNavigation()
        ->collapsibleNavigationGroups();
}
```

## Gestione delle Relazioni

### Aggiornamento Dinamico dei Relation Manager

I Relation Manager caricano i dati una sola volta. Per aggiornarli dinamicamente:

```php
use Filament\Actions\Action;

public static function table(Table $table): Table
{
    return $table
        ->headerActions([
            Action::make('refresh')
                ->label('Aggiorna')
                ->icon('heroicon-o-arrow-path')
                ->action(fn (RelationManager $livewire) => $livewire->refresh()),
        ]);
}
```

### Personalizzazione delle Azioni nei Relation Manager

```php
protected function getHeaderActions(): array
{
    return [
        Actions\CreateAction::make()
            ->label('Aggiungi nuovo')
            ->icon('heroicon-o-plus')
            ->modalHeading('Crea nuovo record')
            ->successNotificationTitle('Record creato con successo'),
    ];
}
```

## Stili Condizionali

### Colori di Sfondo Condizionali per le Righe

Applicare colori diversi alle righe della tabella in base a condizioni specifiche:

```php
public static function table(Table $table): Table
{
    return $table
        ->columns([
            // Definizione delle colonne...
        ])
        ->recordClasses(function ($record) {
            if ($record->status === 'critical') {
                return 'bg-danger-500/10';
            }
            
            if ($record->status === 'warning') {
                return 'bg-warning-500/10';
            }
            
            return '';
        });
}
```

### Stili Condizionali per le Colonne

```php
TextColumn::make('stock')
    ->color(function ($state) {
        if ($state <= 0) {
            return 'danger';
        }
        
        if ($state < 10) {
            return 'warning';
        }
        
        return 'success';
    })
```

## Ottimizzazione del Codice

### Evitare Duplicazioni con Metodi Statici

Per evitare la ripetizione di codice nei form con calcoli live:

```php
// Metodo statico per calcoli ripetitivi
public static function calculateTotal($get, $set): void
{
    $quantity = $get('quantity') ?? 0;
    $price = $get('price') ?? 0;
    $set('total', $quantity * $price);
}

// Utilizzo nei campi del form
TextInput::make('quantity')
    ->numeric()
    ->live()
    ->afterStateUpdated(fn ($get, $set) => self::calculateTotal($get, $set)),

TextInput::make('price')
    ->numeric()
    ->live()
    ->afterStateUpdated(fn ($get, $set) => self::calculateTotal($get, $set)),
```

### Riutilizzo dello Schema del Form

```php
// In Modules\NomeModulo\Filament\Resources\MiaRisorsa.php
public static function getFormSchema(): array
{
    return [
        'nome' => TextInput::make('nome')
            ->required(),
        'email' => TextInput::make('email')
            ->email()
            ->required(),
        // Altri campi...
    ];
}

// Riutilizzo in un widget o in un altro contesto
public function form(Form $form): Form
{
    return $form
        ->schema(MiaRisorsa::getFormSchema())
        ->statePath('data');
}
```

## Breadcrumbs

### Disabilitare i Breadcrumbs per Pagine Specifiche

```php
// Disabilitare per una pagina specifica
protected function hasBreadcrumbs(): bool
{
    return false;
}

// Disabilitare per l'intero pannello
public function panel(Panel $panel): Panel
{
    return $panel
        ->breadcrumbs(false);
}
```

### Personalizzare i Breadcrumbs

```php
protected function getBreadcrumbs(): array
{
    return [
        route('filament.admin.pages.dashboard') => 'Dashboard',
        route('filament.admin.resources.users.index') => 'Utenti',
        '#' => 'Dettaglio',
    ];
}
```

## Menu Utente

### Aggiungere Elementi al Menu Utente

```php
// In Modules\NomeModulo\Providers\FilamentServiceProvider.php
public function panel(Panel $panel): Panel
{
    return $panel
        ->userMenuItems([
            MenuItem::make()
                ->label('Impostazioni')
                ->url(route('filament.admin.pages.settings'))
                ->icon('heroicon-o-cog'),
            MenuItem::make()
                ->label('Profilo')
                ->url(route('filament.admin.pages.profile'))
                ->icon('heroicon-o-user'),
        ]);
}
```

## Best Practices in il progetto

### Struttura Corretta dei File

In il progetto, è fondamentale rispettare la struttura corretta:

```
/Modules/NomeModulo/
  ├── Filament/
  │   ├── Resources/
  │   └── Widgets/
  ├── resources/
  │   └── views/
  │       └── filament/
  │           ├── resources/
  │           └── widgets/
```

### Namespace Corretti

```php
// Corretto
namespace Modules\NomeModulo\Filament\Resources;

// Errato
namespace Modules\NomeModulo\App\Filament\Resources;
```

### Registrazione dei Componenti

Registrare sempre i componenti Filament nel service provider del modulo:

```php
// In Modules\NomeModulo\Providers\NomeModuloServiceProvider.php
public function boot(): void
{
    // ...
    $this->registerFilamentResources();
    $this->registerFilamentWidgets();
}

protected function registerFilamentResources(): void
{
    Filament::registerResources([
        Resources\MiaRisorsa::class,
    ]);
}

protected function registerFilamentWidgets(): void
{
    Filament::registerWidgets([
        Widgets\MioWidget::class,
    ]);
}
```

### Localizzazione

In il progetto, non utilizzare mai il metodo `->label()` nei componenti Filament:

```php
// Errato
TextInput::make('nome')
    ->label('Nome utente')
    ->required();

// Corretto
TextInput::make('nome')
    ->required();
```

Le etichette sono gestite automaticamente dal LangServiceProvider, seguendo la convenzione:
`modulo::risorsa.fields.campo.label`

### Utilizzo di XotBaseResource

Quando si estende `XotBaseResource`:

```php
// Corretto
class MiaRisorsa extends XotBaseResource
{
    public static function getFormSchema(): array
    {
        return [
            'nome' => TextInput::make('nome')
                ->required(),
            'email' => TextInput::make('email')
                ->email()
                ->required(),
        ];
    }
}

// Errato
class MiaRisorsa extends XotBaseResource
{
    protected static ?string $navigationIcon = 'heroicon-o-document';
    
    public static function getRelations(): array
    {
        return [];
    }
    
    public static function getFormSchema(): array
    {
        return [
            TextInput::make('nome'),
            TextInput::make('email'),
        ];
    }
}
```

## Conclusione

Queste personalizzazioni avanzate di Filament consentono di creare interfacce amministrative potenti e intuitive all'interno di il progetto. Seguendo le best practices e le convenzioni del framework, è possibile mantenere un codice pulito, manutenibile e coerente.

## Risorse Aggiuntive

- [Documentazione ufficiale di Filament](https://filamentphp.com/docs)
- [FilamentExamples.com](https://filamentexamples.com)
- [Repository GitHub di Filament](https://github.com/filamentphp/filament)

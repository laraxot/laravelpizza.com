# Compatibilità Filament 5.x - Modulo Cms

**Status**: ✅ ATTIVO  
**Versione Filament**: ^5.0 (versione corrente del progetto)  
**Regola**: I nomi dei file .md sono in minuscolo con trattino; un solo file per la compatibilità Filament (5.x).

## Panoramica

Questo progetto usa **Filament 5.x** come framework per l'interfaccia di amministrazione. Tutti i moduli devono essere compatibili con Filament 5.x e seguire i pattern definiti in questa documentazione.

## Requisiti di Sistema

- Laravel 11.28+
- PHP 8.2+
- Livewire v4
- Node.js 18+
- Tailwind CSS v4.1+

## Differenze Principali da Filament 4.x

### Schema System
Filament 5.x usa un sistema dichiarativo Schema:

```php
// Filament 5.x
use Filament\Forms\Components\TextInput;

public static function getFormSchema(): array
{
    return [
        TextInput::make('name'),
    ];
}
```

### Panel Configuration
```php
use Filament\Panel;
use Filament\PanelProvider;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->resources([
                UserResource::class,
            ])
            ->widgets([
                StatsOverviewWidget::class,
            ]);
    }
}
```

## Classi XotBase Obbligatorie

Tutti i componenti Filament in questo progetto DEVONO estendere le classi XotBase:

### Resources
```php
// ❌ SBAGLIATO
use Filament\Resources\Resource;
class UserResource extends Resource {}

// ✅ CORRETTO
use Modules\Xot\Filament\Resources\XotBaseResource;
class UserResource extends XotBaseResource {}
```

### Relation Managers
```php
// ❌ SBAGLIATO
use Filament\Resources\RelationManagers\RelationManager;
class PostsRelationManager extends RelationManager {}

// ✅ CORRETTO
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;
class PostsRelationManager extends XotBaseRelationManager {}
```

### Widgets
```php
// ❌ SBAGLIATO
use Filament\Widgets\Widget;
class StatsWidget extends Widget {}

// ✅ CORRETTO
use Modules\Xot\Filament\Widgets\XotBaseWidget;
class StatsWidget extends XotBaseWidget {}
```

## Pattern Comuni

### Form Fields
Tutti i campi form devono usare chiavi di traduzione:

```php
// ❌ SBAGLIATO
TextInput::make('email')->label('Email Address')

// ✅ CORRETTO
TextInput::make('email')->label(__('user.email'))
```

### Table Columns
```php
use Filament\Tables\Columns\TextColumn;

public static function getTableColumns(): array
{
    return [
        TextColumn::make('name'),
    ];
}
```

## Risoluzione Problemi Comuni

### Errore Null Query
Se `getFilteredTableQuery()` restituisce null:

```php
$query = $livewire->getFilteredTableQuery();
if ($query === null) {
    throw new \Exception('Query is null');
}
$rows = $query->get();
```

```php
->widgets([
    StatsOverviewWidget::class,
])
```

## Inclusione nei Blade View

Per includere un widget Filament (che è un componente Livewire) all'interno di una vista Blade o di una pagina Folio, **non** usare la sintassi del tag `<livewire:module::widget-name />` a meno che non sia esplicitamente registrato. 

La sintassi corretta e sicura per Filament 5.x è l'uso diretto della classe:

```blade
@livewire(\Modules\User\Filament\Widgets\Auth\LoginWidget::class)
```

Questo evita errori di `ComponentNotFoundException` nelle architetture modulari.

## Riferimenti

- [Filament 5.x Documentazione Ufficiale](https://filamentphp.com/docs/5.x)
- [Filament 5.x Guida Upgrade](https://filamentphp.com/docs/5.x/panels/upgrade)
- [Classi XotBase](../Xot/docs/filament-xotbase-classes.md)
- [Testing Filament](../Xot/docs/filament-testing.md)

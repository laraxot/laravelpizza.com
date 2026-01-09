# Errori Comuni in Filament

## Errori di compatibilità metodi statici/instanza

### Descrizione

Uno degli errori più comuni nei componenti Filament è l'incompatibilità tra metodi statici e di istanza:

```
Cannot make non static method Filament\Resources\RelationManagers\RelationManager::getTableColumns() static in class Modules\User\Filament\Resources\UserResource\RelationManagers\TeamsRelationManager
```

Questo errore si verifica quando un metodo è dichiarato come statico in una classe derivata ma è non-statico nella classe base, violando il principio di sostituzione di Liskov.

### Soluzione

```php
// ERRATO ❌
public static function getTableColumns(): array {...}

// CORRETTO ✅
public function getTableColumns(): array {...}
```

### Metodi da verificare
- `getTableColumns()`
- `getHeaderActions()`
- `getTableFilters()`
- `getTableBulkActions()`
- `getFormSchema()` (nei Widget)

## Errori di metodi astratti vs concreti

### Descrizione

Un altro errore comune è tentare di renderare astratto un metodo che nella classe base è concreto:

```
Cannot make non abstract method Filament\Resources\Pages\ListRecords::getTableColumns() abstract in class Modules\Xot\Filament\Resources\Pages\XotBaseListRecords
```

### Soluzione

Implementare il metodo concreto che deleghi al metodo astratto personalizzato:

```php
// CORRETTO ✅
public function getTableColumns(): array
{
    return $this->getListTableColumns();
}

abstract public function getListTableColumns(): array;
```

## Errori di label nei componenti

### Descrizione

In base alle regole del progetto, **non si deve mai usare il metodo `->label()`** nei componenti Filament:

```php
// ERRATO ❌
TextColumn::make('name')
    ->label('Nome utente')
```

### Soluzione

Rimuovere le chiamate `->label()` e utilizzare i file di traduzione:

```php
// CORRETTO ✅
TextColumn::make('name')
```

Con i file di traduzione appropriati:
```php
// resources/lang/it/resource.php
return [
    'fields' => [
        'name' => [
            'label' => 'Nome utente'
        ]
    ]
];
```

## Errori di PSR-4 Autoloading

### Descrizione

Gli errori di autoloading PSR-4 si verificano quando il namespace della classe non corrisponde alla sua posizione nel filesystem:

```
Class App\Filament\Blocks\Page located in ./Modules/UI/app/Filament/Blocks/Page.php does not comply with psr-4 autoloading standard
```

### Soluzione

Assicurarsi che il namespace corrisponda alla posizione del file:

```php
// ERRATO ❌
namespace App\Filament\Blocks;

// CORRETTO ✅
namespace Modules\UI\Filament\Blocks;
```

## Errori nei componenti Dropdown

### Descrizione

I componenti dropdown di Filament hanno una struttura specifica che deve essere rispettata:

```
Unable to locate a class or view for component [filament::dropdown.list.separator].
```

### Soluzione

Per i separatori, utilizzare HTML diretto invece di tentare di creare componenti personalizzati:

```blade
<!-- CORRETTO ✅ -->
<div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
```

La struttura corretta per i componenti dropdown è:

```blade
<x-filament::dropdown>
    <x-slot name="trigger">
        <!-- Trigger content -->
    </x-slot>

    <x-filament::dropdown.list>
        <x-filament::dropdown.list.item>
            <!-- Item content -->
        </x-filament::dropdown.list.item>

        <!-- Separatore -->
        <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>

        <x-filament::dropdown.list.item>
            <!-- Another item -->
        </x-filament::dropdown.list.item>
    </x-filament::dropdown.list>
</x-filament::dropdown>
```

## Errori in widget Livewire

### Descrizione

Errori comuni nei widget Livewire:

```
Livewire: [wire:model="data.newsletter"] property does not exist on component: [modules.user.filament.widgets.registration-widget]
```

### Soluzione

Definire esplicitamente tutte le proprietà utilizzate con `wire:model` nella classe del widget:

```php
// CORRETTO ✅
class RegistrationWidget extends XotBaseWidget
{
    public array $data = [
        'newsletter' => false,
        // altri campi
    ];

    // resto del widget
}
```

## Performance e Timeout

Se riscontri timeout durante l'esecuzione di comandi Laravel:

```
The process "'/usr/bin/php8.3' -d allow_url_fopen='1' -d disable_functions='' -d memory_limit='-1' artisan vendor:publish --tag=laravel-assets --ansi --force" exceeded the timeout of 1800 seconds.
```

### Soluzioni

1. **Esegui comandi selettivamente**:
   ```bash
   php artisan vendor:publish --provider="SpecificProvider\ServiceProvider" --force
   ```

2. **Aumenta timeout e memoria**:
   ```bash
   PHP_CLI_SERVER_WORKERS=1 php -d memory_limit=2G -d max_execution_time=3600 artisan vendor:publish
   ```

3. **Esegui in più passaggi**:
   ```bash
   php artisan vendor:publish --tag=config --force
   php artisan vendor:publish --tag=migrations --force
   php artisan vendor:publish --tag=public --force
   ```

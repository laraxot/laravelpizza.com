# Gestione delle Tabelle in Filament

Questo documento definisce le linee guida per l'implementazione delle tabelle Filament nel progetto PTVX, utilizzando il trait `HasXotTable`.

## Introduzione

Il trait `HasXotTable` è progettato per standardizzare e semplificare la configurazione delle tabelle Filament in tutte le risorse del progetto. Offre un insieme di metodi predefiniti e una struttura coerente per le tabelle.

## Uso Base

Per utilizzare il trait `HasXotTable` in una risorsa Filament:

```php
<?php

namespace Modules\Example\Filament\Resources;

use Filament\Resources\Resource;
use Modules\Xot\Filament\Traits\HasXotTable;

class ExampleResource extends Resource
{
    use HasXotTable;
    
    // ...
}
```

## Proprietà Principali

Il trait offre le seguenti proprietà configurabili:

- `public TableLayoutEnum $layoutView = TableLayoutEnum::LIST;`: Definisce il layout predefinito per la tabella (LIST, GRID)
- `protected static bool $canReplicate = false;`: Abilita/disabilita la funzionalità di replica dei record
- `protected static bool $canView = true;`: Abilita/disabilita la funzionalità di visualizzazione dei record
- `protected static bool $canEdit = true;`: Abilita/disabilita la funzionalità di modifica dei record

## Metodi da Sovrascrivere

Per personalizzare il comportamento della tabella, è possibile sovrascrivere i seguenti metodi:

### Azioni

```php
// Azioni nell'intestazione della tabella
protected function getTableHeaderActions(): array
{
    return [
        'create' => Tables\Actions\CreateAction::make(),
        // Altre azioni...
    ];
}

// Azioni principali della risorsa
protected function getHeaderActions(): array
{
    return [
        'create' => Actions\CreateAction::make()
            ->icon('heroicon-o-plus'),
        // Altre azioni...
    ];
}

// Azioni per ogni record della tabella
protected function getTableActions(): array
{
    return [
        'view' => Tables\Actions\ViewAction::make()
            ->iconButton()
            ->tooltip(__('user::actions.view')),
        // Altre azioni...
    ];
}

// Azioni bulk per selezioni multiple
protected function getTableBulkActions(): array
{
    return [
        'delete' => DeleteBulkAction::make()
            ->icon('heroicon-o-trash'),
        // Altre azioni...
    ];
}
```

### Colonne

```php
// Colonne per il layout a lista
public function getListTableColumns(): array
{
    return [
        'id' => TextColumn::make('id')
            ->sortable(),
        'name' => TextColumn::make('name')
            ->searchable(),
        // Altre colonne...
    ];
}

// Colonne per il layout a griglia
public function getGridTableColumns(): array
{
    return [
        Stack::make([
            TextColumn::make('title'),
            TextColumn::make('description'),
        ]),
        // Altre stack o colonne...
    ];
}
```

### Filtri

```php
protected function getTableFilters(): array
{
    return [
        'active' => TernaryFilter::make('is_active')
            ->label(__('user::fields.is_active.label')),
        // Altri filtri...
    ];
}
```

## Metodi di Supporto

Il trait include vari metodi di supporto per configurare il comportamento della tabella:

- `protected function shouldShowAssociateAction(): bool`
- `protected function shouldShowAttachAction(): bool`
- `protected function shouldShowDetachAction(): bool`
- `protected function shouldShowReplicateAction(): bool`
- `protected function shouldShowViewAction(): bool`
- `protected function shouldShowEditAction(): bool`

## Controllo della Visibilità delle Azioni

Per controllare quali azioni sono disponibili nella tabella, puoi sovrascrivere i metodi 'should':

```php
protected function shouldShowViewAction(): bool
{
    // Logica personalizzata
    return static::$canView && Auth::user()->can('view', $this->getModel());
}
```

## Caratteristiche Avanzate

### Layout Personalizzato

Il trait supporta diversi layout di tabella tramite l'enumerazione `TableLayoutEnum`:

```php
public TableLayoutEnum $layoutView = TableLayoutEnum::GRID;
```

### Ordinamento Predefinito

È possibile configurare l'ordinamento predefinito della tabella:

```php
protected function getDefaultTableSortColumn(): ?string
{
    return 'created_at';
}

protected function getDefaultTableSortDirection(): ?string
{
    return 'desc';
}
```

## Gestione degli Errori

Il trait include meccanismi di gestione degli errori, ad esempio:

- Notifica quando la tabella del database non esiste
- Configurazione di una tabella vuota quando non ci sono dati
- Controlli per assicurarsi che i metodi siano disponibili prima di chiamarli

## Note Importanti

- Assicurarsi di definire correttamente il metodo `getModelClass()` per garantire il corretto funzionamento del trait
- Utilizzare i metodi con i tipi di ritorno corretti come indicato nei PHPDoc
- Non definire azioni duplicate con lo stesso nome

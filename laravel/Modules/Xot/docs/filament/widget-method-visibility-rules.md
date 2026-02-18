# Regole Visibilità Metodi Widget - HasXotTable

**Data Creazione**: 2025-01-27  
**Ultimo Aggiornamento**: 2026-01-27  
**Status**: ✅ Critico

## Regola Fondamentale

Tutti i metodi `getTable*()` nel trait `HasXotTable` sono dichiarati come `protected` per allinearsi a Filament 5 ed evitare conflitti di visibilità con il trait `InteractsWithTable`. Le classi (pagine/widget) che sovrascrivono questi metodi possono continuare a usare `public` per permettere l'accesso cross-component (widening), ma nel trait devono rimanere `protected`.
<<<<<<< .merge_file_3TpUGS
=======
Tutti i metodi `getTable*()` in `HasXotTable` sono dichiarati come `public` perché vengono chiamati da Filament/Livewire dall'esterno della classe. I widget che sovrascrivono questi metodi **DEVONO** mantenere la stessa visibilità `public`.
>>>>>>> .merge_file_46PPqg

## Metodi che Devono Essere Public

| Metodo | Visibilità Richiesta | Motivo |
|--------|---------------------|--------|
| `getTableHeading()` | `public` | Chiamato da Filament per heading |
| `getTableHeaderActions()` | `public` | Chiamato da Filament per azioni header |
| `getTableActions()` | `public` | Chiamato da Filament per azioni riga |
| `getTableBulkActions()` | `public` | Chiamato da Filament per azioni bulk |
| `getTableFilters()` | `public` | Chiamato da Filament per filtri |
| `getTableSearch()` | `public` | Chiamato da ListRecords per ricerca |

## Metodi che Possono Essere Protected

| Metodo | Visibilità | Motivo |
|--------|-----------|--------|
| `getDefaultTableSortColumn()` | `protected` | Chiamato internamente da `table()` |
| `getDefaultTableSortDirection()` | `protected` | Chiamato internamente da `table()` |
| `getTablePaginated()` | `protected` | Chiamato internamente da `table()` |
| `getTablePollInterval()` | `protected` | Chiamato internamente da `table()` |

## Esempio Corretto

```php
<?php

declare(strict_types=1);

namespace Modules\Quaeris\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseTableWidget;

class MyWidget extends XotBaseTableWidget
{
    /**
     * CRITICO: Deve essere public.
     *
     * @return array<string, \Filament\Actions\Action>
     */
    public function getTableHeaderActions(): array
    {
        return [
            // Azioni
        ];
    }

    /**
     * CRITICO: Deve essere public.
     *
     * @return array<string, \Filament\Tables\Filters\Filter>
     */
    public function getTableFilters(): array
    {
        return [
            // Filtri
        ];
    }

    /**
     * Può essere protected (chiamato internamente).
     */
    protected function getDefaultTableSortColumn(): ?string
    {
        return 'created_at';
    }
}
```

## Errori Comuni

### Errore: Access level must be public

```
PHP Fatal error: Access level to Widget::getTableHeaderActions() 
must be public (as in class HasXotTable)
```

**Causa**: Metodo dichiarato come `protected` invece di `public`

**Soluzione**: Cambiare visibilità a `public`

## Riferimenti

- [HasXotTable Trait Source](../../../Modules/Xot/app/Filament/Traits/HasXotTable.php)
- [Widget Table Configuration](../../../Modules/Xot/docs/filament/widget-table-configuration.md)

*Ultimo aggiornamento: 2026-01-27*
<<<<<<< .merge_file_3TpUGS
=======
*Ultimo aggiornamento: 2025-01-27*
>>>>>>> .merge_file_46PPqg

# Configurazione Tabelle Widget - Pattern e Regole

**Data Creazione**: 2025-01-27  
**Status**: ✅ Attivo

## Filosofia e Business Logic

### Perché `table()` è final?
Il metodo `table()` in `HasXotTable` è dichiarato `final` per:
1. **Coerenza**: Garantisce che tutte le tabelle seguano lo stesso pattern
2. **Traduzioni**: Centralizza la gestione automatica delle traduzioni
3. **Manutenibilità**: Modifiche centrali si propagano a tutte le tabelle
4. **DRY**: Evita duplicazione di codice di configurazione

### Pattern di Configurazione Personalizzata

I widget che estendono `XotBaseTableWidget` (che usa `HasXotTable`) **NON POSSONO** sovrascrivere `table()`, ma possono personalizzare la configurazione tramite metodi dedicati:

```php
/**
 * Default sort column for the table.
 */
protected function getDefaultTableSortColumn(): ?string
{
    return 'submitdate';
}

/**
 * Default sort direction for the table.
 */
protected function getDefaultTableSortDirection(): ?string
{
    return 'desc';
}

/**
 * Pagination options for the table.
 * Can return bool (true/false) or array of page sizes [10, 25, 50, 100].
 *
 * @return bool|array<int>
 */
protected function getTablePaginated(): bool|array
{
    return [10, 25, 50, 100];
}

/**
 * Polling interval for the table.
 * Returns null to disable polling, or a string like '30s' to enable.
 *
 * @return string|null
 */
protected function getTablePollInterval(): ?string
{
    return '30s';
}
```

## Metodi Disponibili per Personalizzazione

### Metodi di Configurazione Tabella

| Metodo | Tipo di Ritorno | Default | Descrizione |
|--------|----------------|---------|-------------|
| `getDefaultTableSortColumn()` | `?string` | `null` | Colonna per ordinamento predefinito |
| `getDefaultTableSortDirection()` | `?string` | `'desc'` | Direzione ordinamento (asc/desc) |
| `getTablePaginated()` | `bool\|array<int>` | `true` | Opzioni paginazione (bool o array) |
| `getTablePollInterval()` | `?string` | `null` | Intervallo polling (es. '30s') |

### Metodi Obbligatori (Public)

| Metodo | Visibilità | Descrizione |
|--------|-----------|-------------|
| `getTableHeading()` | `public` | Heading della tabella |
| `getTableHeaderActions()` | `public` | Azioni nell'header |
| `getTableActions()` | `public` | Azioni per riga |
| `getTableBulkActions()` | `public` | Azioni bulk |
| `getTableFilters()` | `public` | Filtri della tabella |
| `getTableSearch()` | `public` | Query di ricerca |

## Implementazione Corretta

### Widget che Estende XotBaseTableWidget

```php
<?php

declare(strict_types=1);

namespace Modules\healthcare_app\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseTableWidget;

class MyTableWidget extends XotBaseTableWidget
{
    /**
     * Query per la tabella.
     */
    protected function getTableQuery(): Builder
    {
        // Implementazione query
    }

    /**
     * Colonne della tabella.
     *
     * @return array<string, \Filament\Tables\Columns\Column>
     */
    protected function getTableColumns(): array
    {
        return [
            // Colonne
        ];
    }

    /**
     * Heading del widget.
     * 
     * CRITICO: Deve essere public.
     */
    public function getTableHeading(): ?string
    {
        return __('module::widget.navigation.heading');
    }

    /**
     * Default sort column.
     */
    protected function getDefaultTableSortColumn(): ?string
    {
        return 'created_at';
    }

    /**
     * Default sort direction.
     */
    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }

    /**
     * Pagination options.
     *
     * @return bool|array<int>
     */
    protected function getTablePaginated(): bool|array
    {
        return [10, 25, 50, 100];
    }

    /**
     * Polling interval.
     */
    protected function getTablePollInterval(): ?string
    {
        return '30s';
    }
}
```

## Anti-Pattern da Evitare

### ❌ ERRATO: Sovrascrivere table()

```php
// ❌ GRAVEMENTE ERRATO - MAI FARE QUESTO
public function table(Table $table): Table
{
    return $table
        ->query($this->getTableQuery())
        ->columns($this->getTableColumns())
        ->defaultSort('column', 'desc')
        ->paginated([10, 25, 50, 100])
        ->poll('30s');
}
```

### ❌ ERRATO: Metodi Protected invece di Public

```php
// ❌ ERRATO
protected function getTableHeading(): ?string
protected function getTableHeaderActions(): array
protected function getTableActions(): array
protected function getTableFilters(): array
protected function getTableSearch(): ?string

// ✅ CORRETTO
public function getTableHeading(): ?string
public function getTableHeaderActions(): array
public function getTableActions(): array
public function getTableFilters(): array
public function getTableSearch(): ?string
```

## Checklist Implementazione

- [ ] Widget estende `XotBaseTableWidget`
- [ ] Nessun metodo `table()` implementato
- [ ] Tutti i metodi `getTable*()` sono `public` (non `protected`)
- [ ] Configurazioni personalizzate tramite metodi dedicati
- [ ] PHPStan Level 10 passa
- [ ] Documentazione aggiornata

## Inizializzazione Proprietà Widget

### Pattern: Proprietà Pubbliche per Parametri Esterni

Quando si passa un array di parametri a `Widget::make()`, Livewire 3.x può inizializzare **solo proprietà pubbliche**:

```php
// ✅ CORRETTO: Proprietà public viene inizializzata automaticamente
class MyTableWidget extends XotBaseTableWidget
{
    public ?string $group = null; // ✅ Viene inizializzata da make(['group' => ...])
    public string $title = '';
}

// Uso:
MyTableWidget::make([
    'title' => 'Risposte',
    'group' => 'date_format(submitdate, "%Y-%m")',
]);
```

**⚠️ IMPORTANTE**: Le proprietà `protected` o `private` **NON** vengono inizializzate da `make()`.

Per documentazione completa, vedere:
- [Widget Property Initialization Pattern](../../../modules/healthcare_app/docs/widget-property-initialization-pattern.md)

## Riferimenti

- [HasXotTable Trait](../../../modules/xot/docs/filament/xot-table.md)
- [No Table Override Rule](../../../modules/xot/docs/filament/no-table-override.md)
- [Widget Table Method Final Analysis](../../../modules/healthcare_app/docs/widget-table-method-final-analysis.md)
- [Widget Property Initialization Pattern](../../../modules/healthcare_app/docs/widget-property-initialization-pattern.md)


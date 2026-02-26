# DIVIETO ASSOLUTO DI IMPLEMENTARE table()

## Regola Fondamentale Inviolabile

**Chi estende `XotBaseRelationManager` NON DEVE MAI implementare il metodo `table(Table $table): Table`.**

Questa regola **NON HA ECCEZIONI** e si applica a tutti i RelationManager che estendono `XotBaseRelationManager`.

## Motivazione

Il metodo `table()` è già implementato in `XotBaseRelationManager` e fa uso dei metodi:
- `getTableColumns()`
- `getTableFilters()`
- `getTableHeaderActions()`
- `getTableActions()`
- `getTableBulkActions()`

Implementare `table()` in una classe derivata:
1. **Sovrascrive** le personalizzazioni standard di Laraxot PTVX
2. **Compromette** la gestione automatica delle traduzioni
3. **Interferisce** con il funzionamento del `LangServiceProvider`
4. **Causa** comportamenti imprevedibili e difficili da debuggare

## Implementazione Corretta

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Filament\Resources\NomeResource\RelationManagers;

use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class EsempioRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'nomeRelazione';
    
    /**
     * @return array<int, \Filament\Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            // Definizione delle colonne
        ];
    }
    
    /**
     * @return array<string, \Filament\Tables\Actions\Action>
     */
    public function getTableHeaderActions(): array
    {
        return [
            // Definizione delle azioni nell'header
        ];
    }
    
    /**
     * @return array<string, \Filament\Tables\Actions\Action>
     */
    public function getTableActions(): array
    {
        return [
            // Definizione delle azioni per riga
        ];
    }
    
    /**
     * @return array<string, \Filament\Tables\Actions\BulkAction>
     */
    public function getTableBulkActions(): array
    {
        return [
            // Definizione delle bulk actions
        ];
    }
}
```

## Implementazione ERRATA

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Filament\Resources\NomeResource\RelationManagers;

use Filament\Tables\Table;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class EsempioRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'nomeRelazione';
    
    // ❌ GRAVEMENTE ERRATO - MAI IMPLEMENTARE QUESTO METODO
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                // Colonne
            ])
            ->filters([
                // Filtri
            ])
            ->headerActions([
                // Azioni header
            ])
            ->actions([
                // Azioni per riga
            ])
            ->bulkActions([
                // Bulk actions
            ]);
    }
}
```

## Procedure di Correzione

Se trovi un `RelationManager` che implementa il metodo `table()`:

1. **Elimina completamente** il metodo `table()`
2. **Crea o aggiorna** i metodi `getTableColumns()`, `getTableHeaderActions()`, `getTableActions()` e `getTableBulkActions()`
3. **Esegui i test** per verificare che la tabella funzioni correttamente
4. **Aggiorna la documentazione** se necessario

## Link a Risorse Correlate

- [Regole per RelationManager](/docs/filament/relation_managers.md)
- [Divieto di usare label(), placeholder() e helperText()](/laravel/Modules/Xot/docs/filament/no_labels.md)
- [Esempio TeamsRelationManager](/laravel/Modules/User/docs/filament/teams_relation_manager.md)

*Ultimo aggiornamento: 3 Giugno 2025*
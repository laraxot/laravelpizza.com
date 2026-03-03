# Errori Comuni Filament nel Modulo User

## Errori di Metodi Statici

### 1. getTableColumns() non può essere statico in RelationManager

**Errore:**
```php
Cannot make non static method Filament\Resources\RelationManagers\RelationManager::getTableColumns() static in class Modules\User\Filament\Resources\UserResource\RelationManagers\TeamsRelationManager
```

**Causa:**
Il metodo `getTableColumns()` è definito come non statico nella classe base `RelationManager` di Filament, quindi non può essere dichiarato come statico nelle classi che lo estendono.

**Soluzione:**
Rimuovere il modificatore `static` dal metodo:

```php
// ❌ ERRATO
public static function getTableColumns(): array
{
    return [
        TextColumn::make('name'),
        TextColumn::make('personal_team'),
    ];
}

// ✅ CORRETTO
public function getTableColumns(): array
{
    return [
        TextColumn::make('name'),
        TextColumn::make('personal_team'),
    ];
}
```

### 2. Altri Metodi Non Statici di RelationManager

I seguenti metodi di `RelationManager` devono essere dichiarati come non statici:

- `getTableColumns()`
- `getTableFilters()`
- `getTableActions()`
- `getTableBulkActions()`
- `getTableRecordUrlUsing()`
- `getTablePolling()`
- `getRelationship()`

## Best Practices per i RelationManager

1. **Visibilità dei Metodi**
   - Mantenere la stessa visibilità del metodo della classe padre
   - Non rendere statico un metodo non statico
   - Non rendere pubblico un metodo protetto
   - Verificare sempre la firma del metodo nella classe padre

2. **Estensione dei Metodi**
   - Chiamare sempre il metodo parent quando necessario
   - Aggiungere solo la logica specifica necessaria
   - Non duplicare la logica della classe padre
   - Mantenere la stessa struttura di parametri e tipo di ritorno

3. **Convenzioni di Naming**
   - Seguire le convenzioni di Filament
   - Usare nomi descrittivi per le colonne
   - Mantenere la coerenza con il resto del codice
   - Documentare eventuali deviazioni dalle convenzioni standard

## Esempio di Implementazione Corretta

```php
namespace Modules\User\Filament\Resources\UserResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Actions\DetachBulkAction;

class TeamsRelationManager extends RelationManager
{
    protected static string $relationship = 'teams';

    protected static ?string $recordTitleAttribute = 'name';

    public function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->searchable()
                ->sortable(),
            TextColumn::make('personal_team')
                ->boolean()
                ->sortable(),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
        ];
    }

    public function getTableActions(): array
    {
        return [
            AttachAction::make(),
            DetachAction::make(),
        ];
    }

    public function getTableBulkActions(): array
    {
        return [
            DetachBulkAction::make(),
        ];
    }
}
```

## Note Importanti

1. **Compatibilità**
   - Verificare sempre la compatibilità con la versione di Filament in uso
   - Controllare i breaking changes nelle nuove versioni
   - Mantenere aggiornata la documentazione
   - Testare tutte le classi che estendono `RelationManager`

2. **Performance**
   - Ottimizzare le query delle relazioni
   - Utilizzare gli indici appropriati
   - Limitare il numero di relazioni caricate
   - Monitorare le prestazioni con grandi quantità di dati

3. **Manutenibilità**
   - Commentare il codice complesso
   - Mantenere i metodi piccoli e focalizzati
   - Seguire il principio DRY (Don't Repeat Yourself)
   - Documentare le modifiche nel CHANGELOG

4. **Verifica del Codice**
   - Eseguire i test automatici dopo le modifiche
   - Verificare la compatibilità con PHPStan
   - Controllare gli errori del linter
   - Testare manualmente le funzionalità delle relazioni

## Checklist per la Correzione

- [ ] Rimuovere `static` da `getTableColumns()` in `TeamsRelationManager`
- [ ] Verificare altri metodi di `RelationManager` nella classe
- [ ] Testare il funzionamento delle relazioni dopo le modifiche
- [ ] Aggiornare i test unitari se presenti
- [ ] Documentare le modifiche nel CHANGELOG
- [ ] Eseguire PHPStan per verificare altri possibili errori 
# Errori Comuni Filament nel Modulo Activity

## Errori di Metodi Statici

### 1. getTableColumns() non può essere statico

**Errore:**
```php
Cannot make non static method Filament\Resources\Pages\ListRecords::getTableColumns() static in class Modules\Activity\Filament\Resources\ActivityResource\Pages\ListActivities

Cannot make non static method Filament\Resources\Pages\ListRecords::getTableColumns() static in class Modules\Activity\Filament\Resources\SnapshotResource\Pages\ListSnapshots
```

**Causa:**
Il metodo `getTableColumns()` è definito come non statico nella classe base `ListRecords` di Filament, quindi non può essere dichiarato come statico nelle classi che lo estendono. Questo errore si verifica in:
- `ListActivities.php`
- `ListSnapshots.php`

**Soluzione:**
- Rimuovere il modificatore `static` dal metodo:
  1. Se la tua pagina estende `XotBaseListRecords`, **rimuovi completamente** l'override di `getTableColumns()` e utilizza `getListTableColumns()` per definire le colonne:
  ```php
  public function getListTableColumns(): array
  {
      return [
          TextColumn::make('id')
              ->sortable()
              ->label('ID'),
          // ... altre colonne ...
      ];
  }
  ```
  2. Se invece estendi direttamente `Filament\Resources\Pages\ListRecords`, rimuovi il modificatore `static` dal metodo e mantieni l'override di `getTableColumns()`:
  ```php
  // ❌ ERRATO (static)
  public static function getTableColumns(): array
  {
      // ...
  }

  // ✅ CORRETTO (non-static)
  public function getTableColumns(): array
  {
      // ...
  }
  ```

### 2. Altri Metodi Non Statici di ListRecords

I seguenti metodi di `ListRecords` devono essere dichiarati come non statici in tutte le classi che estendono `ListRecords`:

- `getTableColumns()`
- `getTableFilters()`
- `getTableActions()`
- `getTableBulkActions()`
- `getTableRecordUrlUsing()`
- `getTablePolling()`

## Best Practices per i Metodi di ListRecords

1. **Visibilità dei Metodi**
   - Mantenere la stessa visibilità del metodo della classe padre
   - Non rendere statico un metodo non statico
   - Non rendere pubblico un metodo protetto
   - Verificare sempre la firma del metodo nella classe padre prima di implementarlo

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

## Esempi di Implementazione Corretta

### ListActivities.php
```php
namespace Modules\Activity\Filament\Resources\ActivityResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\TextColumn;

class ListActivities extends ListRecords
{
    public function getTableColumns(): array
    {
        return [
            TextColumn::make('id')
                ->sortable()
                ->searchable(),
            TextColumn::make('description')
                ->limit(50)
                ->searchable(),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
        ];
    }
}
```

### ListSnapshots.php
```php
namespace Modules\Activity\Filament\Resources\SnapshotResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\TextColumn;

class ListSnapshots extends ListRecords
{
    public function getTableColumns(): array
    {
        return [
            TextColumn::make('id')
                ->sortable()
                ->searchable(),
            TextColumn::make('aggregate_uuid')
                ->searchable(),
            TextColumn::make('aggregate_version')
                ->sortable(),
        ];
    }
}
```

## Note Importanti

1. **Compatibilità**
   - Verificare sempre la compatibilità con la versione di Filament in uso
   - Controllare i breaking changes nelle nuove versioni
   - Mantenere aggiornata la documentazione
   - Testare tutte le classi che estendono `ListRecords`

2. **Performance**
   - Ottimizzare le query delle colonne
   - Utilizzare gli indici appropriati
   - Limitare il numero di relazioni caricate
   - Monitorare le prestazioni delle liste con grandi quantità di dati

3. **Manutenibilità**
   - Commentare il codice complesso
   - Mantenere i metodi piccoli e focalizzati
   - Seguire il principio DRY (Don't Repeat Yourself)
   - Documentare le modifiche nei file CHANGELOG.md

4. **Verifica del Codice**
   - Eseguire i test automatici dopo le modifiche
   - Verificare la compatibilità con PHPStan
   - Controllare gli errori del linter
   - Testare manualmente le funzionalità delle liste

## Checklist per la Correzione

- [ ] Rimuovere `static` da `getTableColumns()` in `ListActivities`
- [ ] Rimuovere `static` da `getTableColumns()` in `ListSnapshots`
- [ ] Verificare altri metodi di `ListRecords` nelle classi
- [ ] Testare il funzionamento delle liste dopo le modifiche
- [ ] Aggiornare i test unitari se presenti
- [ ] Documentare le modifiche nel CHANGELOG
- [ ] Eseguire PHPStan per verificare altri possibili errori 
# List Records in Filament

> **AGGIORNAMENTO 2025-05-28:**
> Questa policy è stata aggiornata e propagata anche in [<nome progetto>/project_docs/resources/studio-resource.md](../../<nome progetto>/project_docs/resources/studio-resource.md) e [<nome progetto>/project_docs/README.md](../../<nome progetto>/project_docs/README.md). Vedi esempi di implementazione e note di propagazione.

## Estensione Corretta

```php
// ❌ ERRATO: Non estendere ListRecords
use Filament\Resources\Pages\ListRecords;

class ListMyRecords extends ListRecords
{
    // ...
}

// ✅ CORRETTO: Estendere XotBaseListRecords
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListMyRecords extends XotBaseListRecords
{
    protected static string $resource = MyResource::class;

    public function getTableColumns(): array
    {
        return [
            // definizione colonne
        ];
    }
}
```

## Metodi Obbligatori

Quando si estende `XotBaseListRecords`, è necessario implementare i seguenti metodi:

1. `getTableColumns()`: Definisce le colonne della tabella
2. `getListTableActions()`: Definisce le azioni per singola riga
3. `getListTableBulkActions()`: Definisce le azioni di massa
4. `getListTableFilters()`: Definisce i filtri della tabella

## Convenzioni Importanti

1. **Prefisso List**:
   - Tutti i metodi relativi alla tabella DEVONO avere il prefisso "List"
   - Es: `getTableColumns()` invece di `getListTableColumns()`

2. **Visibilità dei Metodi**:
   - Tutti i metodi devono essere `public`
   - Non cambiare la visibilità dei metodi ereditati

3. **Namespace**:
   ```php
   use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
   ```

## Errori Comuni da Evitare

1. **❌ Estensione Errata**:
   ```php
   // NON estendere mai ListRecords direttamente
   use Filament\Resources\Pages\ListRecords;
   ```

2. **❌ Metodi Duplicati**:
   ```php
   // NON dichiarare lo stesso metodo due volte
   public static function getResource(): string { ... }
   public static function getResource(): string { ... }  // ← ERRORE: Duplicato!
   ```
   **Errore**: `Cannot redeclare Modules\Xot\Filament\Resources\Pages\XotBaseListRecords::getResource()`
   **Soluzione**: Rimuovere la dichiarazione duplicata. Vedi [xotbaselistrecords-getresource-duplicate-fix.md](../../filament/xotbaselistrecords-getresource-duplicate-fix.md)

3. **❌ Metodi Senza Prefisso List**:
   ```php
   // NON usare i metodi senza prefisso List
   public function getTableColumns(): array
   public function getTableActions(): array
   public function getTableBulkActions(): array
   ```

3. **❌ Visibilità Errata**:
   ```php
   // NON cambiare la visibilità dei metodi
   protected function getTableColumns(): array
   ```

## Best Practices

1. **Organizzazione del Codice**:
   ```php
   class ListMyRecords extends XotBaseListRecords
   {
       protected static string $resource = MyResource::class;

       public function getTableColumns(): array
       {
           return [
               TextColumn::make('id')->sortable(),
               TextColumn::make('name')->searchable(),
           ];
       }

       public function getListTableActions(): array
       {
           return [
               EditAction::make(),
               DeleteAction::make(),
           ];
       }

       public function getListTableBulkActions(): array
       {
           return [
               DeleteBulkAction::make(),
           ];
       }
   }
   ```

2. **Traduzioni**:
   - Usare `static::trans()` per le traduzioni
   - Definire le traduzioni nel file di lingua del modulo

3. **Permessi**:
   - Implementare controlli nei mount()
   - Usare can() per azioni condizionali

## Note Importanti

1. XotBaseListRecords fornisce funzionalità aggiuntive rispetto a ListRecords:
   - Gestione automatica delle traduzioni
   - Integrazione con il sistema di permessi
   - Funzionalità custom del framework

2. La configurazione della tabella deve essere sempre nella classe List, non nel Resource

3. Mantenere la coerenza in tutto il progetto usando sempre XotBaseListRecords

> **AVVISO IMPORTANTE (2025-05-13):**
> Il metodo standard per la definizione delle colonne della tabella è ora `getTableColumns`. Il vecchio `getListTableColumns` è deprecato: aggiorna tutte le implementazioni e la documentazione. Questa scelta garantisce allineamento con Filament e coerenza tra tutti i moduli Laraxot.

## Esempio di Refactoring

**Prima:**
```php
public function getListTableColumns(): array
{
    return [
        // ...
    ];
}
```

**Dopo:**
```php
public function getTableColumns(): array
{
    return [
        // ...
    ];
}
```

## PROPAGAZIONE (2025-05-28):
La pagina ListStudios del modulo <nome progetto> implementa ora correttamente il metodo getTableColumns() secondo questa policy, con array associativo e chiavi stringa. Vedi esempio e dettagli in [<nome progetto>/project_docs/resources/studio-resource.md](../../<nome progetto>/project_docs/resources/studio-resource.md).

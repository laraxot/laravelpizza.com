# List Records in Filament

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

    public function getListTableColumns(): array
    {
        return [
            // definizione colonne
        ];
    }
}
```

## Metodi Obbligatori

Quando si estende `XotBaseListRecords`, è necessario implementare i seguenti metodi:

1. `getListTableColumns()`: Definisce le colonne della tabella
2. `getListTableActions()`: Definisce le azioni per singola riga
3. `getListTableBulkActions()`: Definisce le azioni di massa
4. `getListTableFilters()`: Definisce i filtri della tabella

## Convenzioni Importanti

1. **Prefisso List**:
   - Tutti i metodi relativi alla tabella DEVONO avere il prefisso "List"
   - Es: `getListTableColumns()` invece di `getTableColumns()`

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

2. **❌ Metodi Senza Prefisso List**:
   ```php
   // NON usare i metodi senza prefisso List
   public function getTableColumns(): array
   public function getTableActions(): array
   public function getTableBulkActions(): array
   ```

3. **❌ Visibilità Errata**:
   ```php
   // NON cambiare la visibilità dei metodi
   protected function getListTableColumns(): array
   ```

## Best Practices

1. **Organizzazione del Codice**:
   ```php
   class ListMyRecords extends XotBaseListRecords
   {
       protected static string $resource = MyResource::class;

       public function getListTableColumns(): array
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

```php
declare(strict_types=1);

namespace Modules\XXX\Filament\Resources\XXXResource\Pages;

use Exception;
use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Modules\UI\Enums\TableLayoutEnum;
use Modules\UI\Filament\Actions\Table\TableLayoutToggleTableAction;
use Modules\Xot\Filament\Traits\TransTrait;
use Webmozart\Assert\Assert;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;


class ListXXX extends XotBaseListRecords
{
    
    protected static string $resource = XXXResource::class;

    

    

  

    public function getGridTableColumns(): array
    {
        return [
        ];
    }

    public function getListTableColumns(): array
    {
        return [
        ];
    }

    public function getTableFilters(): array
    {
        return [
        ];
    }

    public function getTableActions(): array
    {
        return [
            
            ViewAction::make()
                ->label(''),
            EditAction::make()
                ->label(''),
            DeleteAction::make()
                ->label('')
                ->requiresConfirmation(),
        ];
    }

    public function getTableBulkActions(): array
    {
        return [
            DeleteBulkAction::make(),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            // ->columns($this->getTableColumns())
            ->columns($this->layoutView->getTableColumns())
            ->contentGrid($this->layoutView->getTableContentGrid())
            ->headerActions($this->getTableHeaderActions())

            ->filters($this->getTableFilters())
            ->filtersLayout(FiltersLayout::AboveContent)
            ->persistFiltersInSession()
            ->actions($this->getTableActions())
            ->bulkActions($this->getTableBulkActions())
            ->actionsPosition(ActionsPosition::BeforeColumns)
            ->defaultSort(
                column: 'created_at',
                direction: 'DESC',
            );
    }
}
```

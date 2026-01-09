# Incompatibilità tra metodi statici e di istanza in Filament

> **NOTA IMPORTANTE**: Questo documento è un riferimento specifico per il modulo User.
> La documentazione principale e completa si trova nel [modulo UI](../../../UI/docs/filament/errors/static-instance-method-incompatibility.md).
> La documentazione principale e completa si trova nel [modulo UI](../../../UI/project_docs/filament/errors/static-instance-method-incompatibility.md).
## Errori incontrati
### Errore 1: Metodo statico in RelationManager
Nel file `Modules/User/app/Filament/Resources/UserResource/RelationManagers/TeamsRelationManager.php` è stato rilevato il seguente errore:
```
Cannot make non static method Filament\Resources\RelationManagers\RelationManager::getTableColumns() static in class Modules\User\Filament\Resources\UserResource\RelationManagers\TeamsRelationManager
### Errore 2: Metodo statico in Widget
Nel file `Modules/User/app/Filament/Widgets/LoginWidget.php` è stato rilevato il seguente errore:
Cannot make non static method Modules\Xot\Filament\Widgets\XotBaseWidget::getFormSchema() static in class Modules\User\Filament\Widgets\LoginWidget
## Analisi degli errori
### Problema di base
Questi errori si verificano quando un metodo viene dichiarato come **statico** in una classe derivata, mentre nella classe base è un metodo di **istanza** (non statico). PHP non consente questa incompatibilità perché viola il principio di sostituzione di Liskov.
Inoltre, molti metodi utilizzano `->label()` direttamente nei componenti, violando una regola fondamentale del progetto che prevede che le etichette siano gestite tramite LangServiceProvider e file di traduzione.
## Soluzioni corrette
### 1. Per RelationManager e Resource
Modificare la dichiarazione del metodo per farlo corrispondere alla classe base:
```php
// ERRATO ❌
public static function getTableColumns(): array
// CORRETTO ✅
public function getTableColumns(): array
### 2. Per Widget
public static function getFormSchema(): array
public function getFormSchema(): array
### 3. Per tutte le classi
Rimuovere le chiamate a `->label()` per utilizzare il sistema di traduzione automatica:
\Filament\Tables\Columns\TextColumn::make('name')
    ->searchable()
    ->sortable()
    ->label(static::trans('fields.name.label'))
## Altri errori simili da verificare nel modulo
Verificare se i seguenti metodi sono stati dichiarati correttamente con la stessa visibilità della classe base:
### In Resource e RelationManager
- `getTableColumns()`
- `getHeaderActions()`
- `getTableFilters()`
- `getTableBulkActions()`
- `getListTableColumns()` (solo in classi che estendono XotBaseResource)
### In Widget
- `getFormSchema()`
- `mount()`
- `form()`
E controllare che nessuno di questi metodi contenga chiamate a `->label()`.
## Caso speciale: Metodi astratti vs concreti
Un altro tipo di incompatibilità si verifica quando si tenta di rendere astratto un metodo che nella classe base è concreto:
Cannot make non abstract method Filament\Resources\Pages\ListRecords::getTableColumns() abstract in class Modules\Xot\Filament\Resources\Pages\XotBaseListRecords
In questo caso, la soluzione è implementare il metodo concreto nella classe derivata, delegando al metodo astratto personalizzato:
// Soluzione corretta in XotBaseListRecords
{
    return $this->getListTableColumns();
}
abstract public function getListTableColumns(): array;
## Riferimenti
- [Documentazione principale sui metodi statici/di istanza](../../../UI/docs/filament/errors/static-instance-method-incompatibility.md)
- [Regole per le etichette dei componenti Filament](../../../UI/docs/filament/label-translation-system.md)
- [Documentazione principale sui metodi statici/di istanza](../../../UI/project_docs/filament/errors/static-instance-method-incompatibility.md)
- [Regole per le etichette dei componenti Filament](../../../UI/project_docs/filament/label-translation-system.md)

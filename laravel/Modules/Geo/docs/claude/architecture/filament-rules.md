# Regole Fondamentali PTVX - Estensioni Filament

## 1. Regole di Estensione Classi

**MAI estendere classi Filament direttamente** - usare sempre classi XotBase con prefisso:

| Classe Filament | Classe XotBase da usare |
|----------------|-----------------------|
| `Filament\Resources\Resource` | `Modules\Xot\Filament\Resources\XotBaseResource` |
| `Filament\Resources\Pages\CreateRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord` |
| `Filament\Resources\Pages\EditRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord` |
| `Filament\Resources\Pages\ListRecords` | `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords` |
| `Filament\Resources\Pages\Page` | `Modules\Xot\Filament\Resources\Pages\XotBasePage` |

### Esempi Corretti

```php
// ✅ CORRETTO
class MyResource extends XotBaseResource
{
    // ...
}

class CreateMy extends XotBaseCreateRecord
{
    // ...
}

class EditMy extends XotBaseEditRecord
{
    // ...
}

class ListMy extends XotBaseListRecords
{
    // ...
}

class ViewMy extends XotBasePage
{
    // ...
}
```

## 2. Regole Specifiche per XotBaseResource

Le classi che estendono **XotBaseResource**:
- ❌ NON devono avere `getTableColumns()`
- ✅ DEVONO avere `getFormSchema()`
- ✅ DEVONO avere `getPages()`
- ✅ POSSONO avere `getEloquentQuery()`

## 3. Regole Specifiche per XotBasePage

Le classi che estendono **XotBasePage**:
- ❌ NON devono avere `protected static ?string $navigationIcon`
- ❌ NON devono avere `protected static ?string $title`
- ❌ NON devono avere `protected static ?string $navigationLabel`

## 4. Azioni e Business Logic

- ❌ NON usare Services classici
- ✅ Usare [Spatie Laravel QueueableAction](https://github.com/spatie/laravel-queueable-action)

```php
// ✅ CORRETTO
use Spatie\QueueableAction\QueueableAction;

class CreateUserAction
{
    use QueueableAction;
    
    public function execute(UserData $data): User
    {
        return User::create($data->toArray());
    }
}
```

## 5. Traduzioni

- ❌ NON usare `->label()`, `->placeholder()`, `->tooltip()`
- ✅ Usare file di traduzione con LangServiceProvider

```php
// ❌ SBAGLIATO
TextInput::make('name')->label('Nome')

// ✅ CORRETTO
TextInput::make('name') // La traduzione viene gestita automaticamente
```

## 6. Componenti Deprecati

- ❌ NON usare `BadgeColumn` (deprecated)
- ✅ Usare `TextColumn::make()->badge()`

```php
// ❌ SBAGLIATO
BadgeColumn::make('status')

// ✅ CORRETTO
TextColumn::make('status')->badge()
```

## 7. REGOLA METODI TAB

I metodi delle tabelle DEVONO essere implementati SOLO nelle pagine List:

**Nella pagina List (es. `ListImportiCategorias.php`):**
- ✅ `getTableColumns()`
- ✅ `getTableFilters()`
- ✅ `getTableActions()`
- ✅ `getTableBulkActions()`

**Nella classe Resource (es. `ImportiCategoriaResource.php`):**
- ❌ MAI `getTableColumns()`
- ❌ MAI `getTableFilters()`
- ❌ MAI `getTableActions()`
- ❌ MAI `getTableBulkActions()`

## 8. Pattern Architetturale PTV

Il modulo PTV funziona come base/core da cui altri moduli specifici ereditano funzionalità comuni:

```php
// In modulo specifico (es. IndennitaResponsabilita)
class ListMyLogs extends PtvListMyLogs
{
    protected static string $resource = MyLogResource::class;
    // Eredita tutta la logica comune da PTV
}
```

Questo pattern si applica a:
1. Le classi Pages dei Resources
2. Le classi Resources con logica comune
3. Le classi di business logic riutilizzabile
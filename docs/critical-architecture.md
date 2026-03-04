# Regole Critiche di Architettura Laraxot

**
**STATUS**: ✅ REGOLE OBBLIGATORIE
**PRIORITÀ**: CRITICA - MAI VIOLARE

## 🚨 Regola Fondamentale: Mai Estendere Filament Direttamente

**MAI, MAI, MAI estendere classi Filament direttamente. SEMPRE usare classi XotBase.**

### Mapping Completo Classi

| ❌ SBAGLIATO (Filament) | ✅ CORRETTO (XotBase) |
|-------------------------|----------------------|
| `Filament\Resources\Resource` | `Modules\Xot\Filament\Resources\XotBaseResource` |
| `Filament\Resources\Pages\CreateRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord` |
| `Filament\Resources\Pages\EditRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord` |
| `Filament\Resources\Pages\ListRecords` | `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords` |
| `Filament\Resources\Pages\Page` | `Modules\Xot\Filament\Resources\Pages\XotBasePage` |
| `Filament\Widgets\Widget` | `Modules\Xot\Filament\Widgets\XotBaseWidget` |
| `Filament\Widgets\StatsOverviewWidget` | `Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget` |
| `Filament\Widgets\ChartWidget` | `Modules\Xot\Filament\Widgets\XotBaseChartWidget` |

## 📋 Regole Specifiche per Classe

### XotBaseResource

**VIETATO**: Metodo `getTableColumns()`
**MOTIVO**: Gestito automaticamente dalla classe base

```php
// ❌ SBAGLIATO
class MyResource extends XotBaseResource
{
    public function getTableColumns(): array
    {
        return [...];
    }
}

// ✅ CORRETTO
class MyResource extends XotBaseResource
{
    // getTableColumns() NON deve essere presente
}
```

### XotBasePage

**VIETATO**: Proprietà statiche di navigazione
**MOTIVO**: Gestite automaticamente dal sistema di traduzione

```php
// ❌ SBAGLIATO
class MyPage extends XotBasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $title = 'My Page';
    protected static ?string $navigationLabel = 'My Page';
}

// ✅ CORRETTO
class MyPage extends XotBasePage
{
    // navigationIcon, title, navigationLabel NON devono essere presenti
    // Usare file di traduzione invece
}
```

## 🔄 Services vs QueueableActions

**VIETATO**: Creare classi Service
**OBBLIGATORIO**: Usare Spatie QueueableActions

```php
// ❌ SBAGLIATO
class UserService
{
    public function createUser(array $data): User
    {
        // ...
    }
}

// ✅ CORRETTO
use Spatie\QueueableAction\QueueableAction;

class CreateUserAction
{
    use QueueableAction;

    public function execute(array $data): User
    {
        // ...
    }
}
```

**RIFERIMENTO**: https://github.com/spatie/laravel-queueable-action

## 🌐 Traduzioni: Mai Usare ->label(), ->placeholder(), ->tooltip()

**VIETATO**: Metodi diretti su componenti
**OBBLIGATORIO**: File di traduzione tramite LangServiceProvider

```php
// ❌ SBAGLIATO
TextInput::make('name')
    ->label('Nome')
    ->placeholder('Inserisci nome')
    ->tooltip('Il nome dell\'utente');

// ✅ CORRETTO
TextInput::make('name');
// Le traduzioni vengono caricate automaticamente da:
// Modules/MyModule/lang/it/fields.php
// ['name' => ['label' => 'Nome', 'placeholder' => 'Inserisci nome', 'tooltip' => 'Il nome dell\'utente']]
```

## 🏷️ BadgeColumn è Deprecated

**VIETATO**: Usare `BadgeColumn`
**OBBLIGATORIO**: Usare `TextColumn` con metodo `badge()`

```php
// ❌ SBAGLIATO
use Filament\Tables\Columns\BadgeColumn;

BadgeColumn::make('status')
    ->colors(['success' => 'active']);

// ✅ CORRETTO
use Filament\Tables\Columns\TextColumn;

TextColumn::make('status')
    ->badge()
    ->colors(['success' => 'active']);
```

## 🔗 Estensioni Modelli: Usare BaseModel del Modulo

**VIETATO**: Estendere `Model` direttamente o implementare contratti
**OBBLIGATORIO**: Estendere `BaseModel` del modulo

```php
// ❌ SBAGLIATO
class Team extends Model implements TeamContract
{
    // ...
}

// ✅ CORRETTO
use Modules\MyModule\Models\BaseTeam;

class Team extends BaseTeam
{
    // BaseTeam estende già il BaseModel del modulo
}
```

### Eccezione: Permission

**SPECIALE**: Permission deve estendere SpatiePermission

```php
// ❌ SBAGLIATO
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    // ...
}

// ✅ CORRETTO
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    // ...
}
```

## 📝 Non Replicare Metodi della Classe Estesa

**REGOLA**: Se un metodo nella classe estesa fa già quello che serve, NON replicarlo.

```php
// ❌ SBAGLIATO
class MyResource extends XotBaseResource
{
    public function getTableColumns(): array
    {
        // Stesso codice della classe base
        return parent::getTableColumns();
    }
}

// ✅ CORRETTO
class MyResource extends XotBaseResource
{
    // Se il metodo della classe base è sufficiente, NON ridefinirlo
}
```

## 🔧 $casts è Deprecated

**VIETATO**: Usare `protected $casts`
**OBBLIGATORIO**: Usare metodo `casts()`

```php
// ❌ SBAGLIATO
class MyModel extends BaseModel
{
    protected $casts = [
        'created_at' => 'datetime',
        'is_active' => 'boolean',
    ];
}

// ✅ CORRETTO
class MyModel extends BaseModel
{
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }
}
```

## 📚 Riferimenti

- [XotBase Extension Rules](./xotbase-extension-rules.md)
- [Architecture Best Practices](./architecture-best-practices.md)
- [Development Rules](./development-rules.md)

## ⚠️ Note Importanti

1. **Queste regole hanno PRIORITÀ ASSOLUTA** su qualsiasi altra considerazione
2. **Violare queste regole causa problemi di manutenzione e compatibilità**
3. **PHPStan dovrebbe rilevare molte di queste violazioni**
4. **Aggiornare sempre questo documento quando vengono aggiunte nuove regole**

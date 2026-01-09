# Filament Class Extension Rules - Laraxot Framework

**Principio Fondamentale**: Mai estendere classi Filament direttamente - sempre usare classi XotBase

---

## 🚨 Regola Assoluta

**NON estendere MAI classi Filament direttamente**

Sempre estendere classi astratte con prefisso `XotBase` che rispettano il vecchio percorso.

---

## 📋 Mapping Classi Filament → XotBase

### Resources Pages

| ❌ SBAGLIATO | ✅ CORRETTO |
|-------------|------------|
| `Filament\Resources\Pages\CreateRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord` |
| `Filament\Resources\Pages\EditRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord` |
| `Filament\Resources\Pages\ListRecords` | `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords` |
| `Filament\Resources\Pages\Page` | `Modules\Xot\Filament\Resources\Pages\XotBasePage` |
| `Filament\Actions\BulkAction` | `Modules\Xot\Filament\Actions\XotBaseBulkAction` |
| `Filament\Pages\Dashboard` | `Modules\Xot\Filament\Pages\XotBaseDashboard` |

### Schema Components

| ❌ SBAGLIATO | ✅ CORRETTO |
|-------------|------------|
| `Filament\Schemas\Components\Section` | `Modules\Xot\Filament\Schemas\Components\XotBaseSection` |

### Forms Components

| ❌ SBAGLIATO | ✅ CORRETTO |
|-------------|------------|
| `Filament\Forms\Components\Select` | `Modules\Xot\Filament\Forms\Components\XotBaseSelect` |
| `Filament\Forms\Components\CheckboxList` | `Modules\Xot\Filament\Forms\Components\XotBaseCheckboxList` |
| `Filament\Forms\Components\ViewField` | `Modules\Xot\Filament\Forms\Components\XotBaseViewField` |
| `Filament\Forms\Components\Radio` | `Modules\Xot\Filament\Forms\Components\XotBaseRadio` |

**⚠️ NOTA IMPORTANTE**: Nei moduli applicativi **non si estende mai** Filament direttamente.

- I moduli applicativi devono usare **solo** `XotBase*`.
- Solo il modulo `Xot` contiene (ed eventualmente aggiunge) i wrapper `XotBase*`.

**Classi Base Forms Components Esistenti**:
- `XotBaseField` (estende `Filament\Forms\Components\Field`) ✅
- `XotBaseFormComponent` (estende `Filament\Forms\Components\Field`) ✅
- `XotBasePlaceholder` (estende `Filament\Forms\Components\Placeholder`) ✅
- `XotBaseRadio` (estende `Filament\Forms\Components\Radio`) ✅
- `XotBaseSelect` (estende `Filament\Forms\Components\Select`) ✅
- `XotBaseCheckboxList` (estende `Filament\Forms\Components\CheckboxList`) ✅

### Auth Pages

| ❌ SBAGLIATO | ✅ CORRETTO |
|-------------|------------|
| `Filament\Auth\Pages\Login` | `Modules\Xot\Filament\Pages\Auth\XotBaseLogin` |
| `Filament\Auth\Pages\Register` | `Modules\Xot\Filament\Pages\Auth\XotBaseRegister` |
| `Filament\Auth\Pages\EditProfile` | `Modules\Xot\Filament\Pages\Auth\XotBaseEditProfile` |

### Actions

| ❌ SBAGLIATO | ✅ CORRETTO |
|-------------|------------|
| `Filament\Actions\ActionGroup` | `Modules\Xot\Filament\Actions\XotBaseActionGroup` |

### Resources

| ❌ SBAGLIATO | ✅ CORRETTO |
|-------------|------------|
| `Filament\Resources\Resource` | `Modules\Xot\Filament\Resources\XotBaseResource` |

### Standalone Pages

| ❌ SBAGLIATO | ✅ CORRETTO |
|-------------|------------|
| `Filament\Pages\Page` | `Modules\Xot\Filament\Pages\XotBasePage` |

### Widgets

| ❌ SBAGLIATO | ✅ CORRETTO |
|-------------|------------|
| `Filament\Widgets\Widget` | `Modules\Xot\Filament\Widgets\XotBaseWidget` |
| `Filament\Widgets\TableWidget` | `Modules\Xot\Filament\Widgets\XotBaseTableWidget` |
| `Filament\Widgets\ChartWidget` | `Modules\Xot\Filament\Widgets\XotBaseChartWidget` |
| `Filament\Widgets\StatsOverviewWidget` | `Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget` |

### Service Providers

| ❌ SBAGLIATO | ✅ CORRETTO |
|-------------|------------|
| `Illuminate\Support\ServiceProvider` | `Modules\Xot\Providers\XotBaseServiceProvider` |

---

## ⚠️ Regole Specifiche per XotBaseResource

### Metodo getTableColumns NON Richiesto

Chi estende `XotBaseResource` **NON deve avere** il metodo `getTableColumns()`.

```php
// ❌ SBAGLIATO
class UserResource extends XotBaseResource
{
    public static function getTableColumns(): array
    {
        return [/* ... */];
    }
}

// ✅ CORRETTO
class UserResource extends XotBaseResource
{
    // getTableColumns() gestito automaticamente da XotBaseResource
}
```

### Metodi Standard NON Richiesti

Non implementare questi metodi se restituiscono solo valori standard:

- `getPages()` - se contiene solo route standard
- `getRelations()` - se restituisce array vuoto
- `getTableActions()` - se contiene solo azioni standard
- `getTableBulkActions()` - se contiene solo azioni standard

---

## ⚠️ Regole Specifiche per XotBasePage

### Proprietà NON Consentite

Chi estende `Modules\Xot\Filament\Pages\XotBasePage` **NON deve avere**:

```php
// ❌ SBAGLIATO
class MyPage extends XotBasePage
{
    protected static ?string $navigationIcon;
    protected static ?string $title;
    protected static ?string $navigationLabel;
}

// ✅ CORRETTO
class MyPage extends XotBasePage
{
    // Queste proprietà sono gestite automaticamente dalla classe base
}
```

---

## ⚠️ Regole Specifiche per XotBaseWidget

### Metodo form() - Inizializzazione Automatica

`XotBaseWidget` inizializza automaticamente `$this->data` nel metodo `form()` quando si usa `statePath('data')`:

- **Widget senza modello**: `$this->data` viene inizializzato con le chiavi dello schema (`['email' => null, 'password' => null, ...]`).
- **Widget con modello**: `$this->data` viene popolato da `getFormFill()`

**Pattern corretto per widget senza modello**:
```php
// ✅ CORRETTO: Nessun mount() necessario
class LoginWidget extends XotBaseWidget
{
    #[\]Override]
    public function getFormSchema(): array
    {
        return [
            'email' => TextInput::make('email')->email()->required(),
            'password' => TextInput::make('password')->password()->required(),
        ];
    }
    // mount() NON necessario - form() gestisce tutto automaticamente
}
```

**Pattern per widget con logica aggiuntiva**:
```php
// ✅ CORRETTO: mount() solo se serve logica specifica
class EditUserWidget extends XotBaseWidget
{
    public function mount(string $type, ?string $userId = null): void
    {
        // Solo logica specifica - NON inizializzare $this->data qui
        $this->type = $type;
        $this->record = $this->getFormModel($userId);
        // form() gestirà automaticamente l'inizializzazione
    }
}
```

---

## 🔧 Pattern per Modelli

### Estensione BaseModel

```php
// ❌ SBAGLIATO
class Team extends Model implements TeamContract

// ✅ CORRETTO
class Team extends BaseTeam
```

### Estensione Modelli di Terze Parti

```php
// ❌ SBAGLIATO - laravel/Modules/User/app/Models/Permission.php
class Permission extends Model

// ✅ CORRETTO
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
```

### Non Replicare Metodi

**Regola**: Non replicare metodi della classe estesa se non ci sono differenze.

```php
// ❌ SBAGLIATO - Metodo identico alla classe base
class MyModel extends BaseModel
{
    public function getName(): string
    {
        return $this->name; // Identico alla classe base
    }
}

// ✅ CORRETTO - Rimuovi il metodo, usa quello della classe base
class MyModel extends BaseModel
{
    // Metodo getName() ereditato da BaseModel
}
```

---

## 🚫 Deprecazioni

### BadgeColumn Deprecato

```php
// ❌ DEPRECATO
use Filament\Tables\Columns\BadgeColumn;

BadgeColumn::make('status')

// ✅ CORRETTO - Usa TextColumn con badge()
use Filament\Tables\Columns\TextColumn;

TextColumn::make('status')->badge()
```

### protected $casts Deprecato (Laravel 11+)

```php
// ❌ DEPRECATO - Laravel 10 e precedenti
class User extends Model
{
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];
}

// ✅ CORRETTO - Laravel 11+ (metodo casts())
class User extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_admin' => 'boolean',
        ];
    }
}
```

**IMPORTANTE**: Se un modello ha ENTRAMBI `protected $casts` E `casts()`, rimuovi `protected $casts` (è deprecato e ignorato).

---

## 🌐 Gestione Traduzioni

### NON Usare Metodi Diretti

```php
// ❌ SBAGLIATO
TextInput::make('name')
    ->label('Nome')
    ->placeholder('Inserisci nome')
    ->tooltip('Il nome dell\'utente')

// ✅ CORRETTO - Usa file di traduzione
TextInput::make('name')
// Le traduzioni sono gestite automaticamente da LangServiceProvider
```

**Struttura file traduzione**:
```
Modules/{ModuleName}/lang/{locale}/{resource}.php

// Esempio: Modules/User/lang/it/user.php
return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci nome',
            'tooltip' => 'Il nome dell\'utente',
        ],
    ],
];
```

---

## 🔄 Actions invece di Services

### Usa Spatie Queueable Actions

```php
// ❌ SBAGLIATO - Service tradizionale
class UserService
{
    public function createUser(array $data): User
    {
        // ...
    }
}

// ✅ CORRETTO - Queueable Action
use Spatie\QueueableAction\QueueableAction;

class CreateUserAction
{
    use QueueableAction;

    public function execute(array $data): User
    {
        // ...
    }
}

// Uso
app(CreateUserAction::class)->execute($data);
```

**Risorsa**: https://github.com/spatie/laravel-queueable-action

---

## 📚 Esempi Completi

### Resource Completa

```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\User\Models\User;

class UserResource extends XotBaseResource
{
    protected static ?string $model = User::class;

    /**
     * @return array<int|string, \Filament\Schemas\Components\Component>
     */
    public static function getFormSchema(): array
    {
        return [
            TextInput::make('name')->required(),
            EmailInput::make('email')->required(),
        ];
    }

    // getTableColumns() NON necessario - gestito da XotBaseResource
    // getPages() NON necessario se standard
    // getTableActions() NON necessario se standard
}
```

### Page Completa

```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;

class DashboardPage extends XotBasePage
{
    // $navigationIcon NON necessario
    // $title NON necessario
    // $navigationLabel NON necessario
    // Gestiti automaticamente da XotBasePage
}
```

### Widget Completo

```php
<?php

declare(strict_types=1);

namespace Modules\Quaeris\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseTableWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class MyTableWidget extends XotBaseTableWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 1;

    public function getTableRecordKey(\Illuminate\Database\Eloquent\Model|array $record): string
    {
        if (\is_array($record)) {
            return (string) ($record['id'] ?? '');
        }

        return (string) ($record->id ?? '');
    }

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return MyModel::query();
    }

    /**
     * @return array<int, \Filament\Tables\Columns\Column>
     */
    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('id')->sortable(),
            TextColumn::make('name')->sortable()->searchable(),
        ];
    }
}
```

---

## 📋 Array Return Types Importanti

I seguenti metodi devono restituire array associativi con chiavi stringa:

- `getInfolistSchema()` (es. `XotBaseViewRecord`) deve restituire sempre un array con chiavi **stringa**.

### Metodi che richiedono array associativi
```php
// ✅ CORRETTO - Array associativo con chiavi stringa
public function getTableActions(): array
{
    return [
        'view' => ViewAction::make(),
        'edit' => EditAction::make(),
        'delete' => DeleteAction::make(),
    ];
}

public function getTableBulkActions(): array
{
    return [
        'delete' => DeleteBulkAction::make(),
        'export' => ExportBulkAction::make(),
    ];
}

public function getTableFilters(): array
{
    return [
        'status' => SelectFilter::make('status'),
        'date' => DateRangeFilter::make('created_at'),
    ];
}

public function getHeaderActions(): array
{
    return [
        'create' => CreateAction::make(),
        'import' => ImportAction::make(),
    ];
}

public function getFormSchema(): array
{
    return [
        'name' => TextInput::make('name')->required(),
        'email' => TextInput::make('email')->email()->required(),
    ];
}
```

### NOTA IMPORTANTE sugli array types
I metodi `getTableColumns`, `getFormSchema`, `getTableBulkActions`, `getTableActions`, `getTableFilters`, `getHeaderActions` restituiscono sempre `array<string, mixed>`. Evitare l'uso di `mixed` come tipo quando possibile, cercando di usarlo solo come ultima spiaggia.

---

## 🚫 Eloquent Magic Properties - REGOLA CRITICA

### Regola Assoluta: Mai usare `property_exists()` con modelli Eloquent

**Gli attributi Eloquent sono magic properties accessibili via `__get()`, quindi `property_exists()` non li rileva.**

```php
// ❌ SBAGLIATO - property_exists() NON funziona con magic attributes
if (property_exists($model, 'name')) { }

// ✅ CORRETTO - Usa isset() per magic attributes
if (isset($model->name)) { }

// ✅ ANCHE CORRETTO - Usa hasAttribute() se disponibile
if ($model->hasAttribute('name')) { }

// ✅ ANCHE CORRETTO - Usa isFillable() per attributi fillable
if ($model->isFillable('name')) { }

// ✅ ANCHE CORRETTO - Usa Schema::hasColumn() per colonne DB
use Illuminate\Support\Facades\Schema;

if (Schema::hasColumn($model->getTable(), 'name')) {
    $value = $model->name;
}

// ✅ ANCHE CORRETTO - Usa SafeAttributeCastAction per accesso sicuro
use Modules\Xot\Actions\Cast\SafeAttributeCastAction;

$value = SafeAttributeCastAction::get($model, 'name', 'default');
```

---

## ✅ Checklist Pre-Implementazione

Prima di creare una nuova classe Filament:

- [ ] Ho verificato quale classe XotBase estendere?
- [ ] Non sto estendendo direttamente classi Filament?
- [ ] Non sto replicando metodi della classe base?
- [ ] Sto usando file di traduzione invece di ->label()?
- [ ] Sto usando Actions invece di Services?
- [ ] Ho rimosso BadgeColumn deprecato?
- [ ] Ho migrato da `protected $casts` a `casts()`?
- [ ] I miei metodi restituiscono array associativi quando richiesto?
- [ ] Ho evitato l'uso di `property_exists()` sui modelli Eloquent?

---

## 🔗 Collegamenti Utili

- [XotBaseResource Documentation](../../laravel/Modules/Xot/docs/consolidated/filament/resources/xot-base-resource.md)
- [Base Classes Documentation](../../laravel/Modules/Xot/docs/consolidated/base-classes.md)
- [Spatie Queueable Actions](https://github.com/spatie/laravel-queueable-action)
- [Filament v4 Documentation](https://filamentphp.com/docs/4.x)

---

## 💡 Approccio di Lavoro

### Workflow Completo
Come sempre prima di correggere devi:
1. **Aumenta confidenza**: Studia architettura, business, doc root
2. **Studia docs**: Leggi `Modules/{Modulo}/docs/` + `Themes/{Tema}/docs/`
3. **Aggiorna docs**: Documenta ciò che stai per fare
4. **Ragiona**: Capisci logica, filosofia, scopo, perché
5. **Implementa**: Scrivi il codice o la correzione
6. **Controlla**: PHPStan livello 10, PHPMD, PHP Insights
7. **Correggi**: Risolvi errori trovati
8. **Verifica**: Riesegui tutti i tool
9. **Migliora**: Rivedi e ottimizza
10. **Git commit e push**: Dopo ogni modulo completato

### Verifica Qualità
Quando finisci una modifica devi sempre controllare con:
- **PHPStan livello 10**: `./vendor/bin/phpstan analyse Modules/{ModuleName} --level=10`
- **PHPMD**: `./vendor/bin/phpmd Modules/{ModuleName} text codesize`
- **PHP Insights**: `./vendor/bin/phpinsights analyse Modules/{ModuleName}`

### Workflow Modulo per Modulo
- **Lavora un modulo alla volta**: Completa tutti gli errori del modulo, poi passa al successivo
- **Quando tutti i moduli sono a posto**: Controlla tutta la cartella Modules
- **Verifica continua**: Dopo ogni batch di correzioni

---

## 💡 Ricorda Sempre

1. **Mai estendere Filament direttamente** - sempre XotBase
2. **Non replicare metodi** se identici alla classe base
3. **Usa traduzioni** invece di ->label() diretto
4. **Usa Actions** invece di Services (Spatie Queueable Actions)
5. **Rispetta deprecazioni** (BadgeColumn, `protected $casts`)
6. **Aggiorna docs** dopo ogni implementazione (modulo, non root)
7. **Usa array associativi** quando richiesto (chiavi stringa)
8. **property_exists() NON funziona** con modelli Eloquent - usa `isset()`, `hasAttribute()`, `isFillable()`, `Schema::hasColumn()`
9. **Mixed solo come ultima spiaggia** - preferisci union types, type narrowing, generics
10. **NO Controller**: Backoffice = Filament, Frontoffice = Folio + Volt
11. **Test in Pest**: Tutti i test devono essere in Pest
12. **Controlla sempre** con PHPStan livello 10, PHPMD, PHP Insights
13. **Git commit e push** dopo ogni modulo completato
14. **DRY + KISS**: Sempre applicare - non duplicare, non complicare

---

**Filosofia**: DRY + KISS - Non duplicare, non complicare, usa sempre le classi base.

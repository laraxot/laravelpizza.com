# Filament Class Extension Rules - Regole Complete

**Principio Fondamentale**: Mai estendere classi Filament direttamente - sempre usare classi XotBase

**Ultimo aggiornamento**: 2025-12-22

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
| `Filament\Schemas\Components\Section` | `Modules\Xot\Filament\Schemas\Components\XotBaseSection` |
| `Filament\Forms\Components\Select` | `Modules\Xot\Filament\Forms\Components\XotBaseSelect` |
| `Filament\Forms\Components\CheckboxList` | `Modules\Xot\Filament\Forms\Components\XotBaseCheckboxList` |

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

`XotBaseWidget` configura il form con `statePath('data')` nel metodo `form()`. L'inizializzazione di `$this->data` avviene automaticamente tramite Livewire quando si usa `statePath('data')`:

- **Widget senza modello**: `$this->data` viene inizializzato automaticamente da Livewire con le chiavi dello schema quando il form viene renderizzato. Le chiavi stringa in `getFormSchema()` sono **obbligatorie** per questo funzionamento.
- **Widget con modello**: `$this->data` viene popolato da `getFormFill()` se il modello esiste, altrimenti viene inizializzato con le chiavi dello schema.

**Pattern corretto per widget senza modello**:
```php
// ✅ CORRETTO: Nessun mount() necessario
class LoginWidget extends XotBaseWidget
{
    #[\Override]
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

### getFormSchema() deve essere PUBLIC

```php
// ❌ SBAGLIATO
class MyWidget extends XotBaseWidget
{
    protected function getFormSchema(): array
    {
        return [];
    }
}

// ✅ CORRETTO
class MyWidget extends XotBaseWidget
{
    public function getFormSchema(): array
    {
        return [];
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

## 📊 Tipizzazione Array - Regole Critiche

### Metodi che Restituiscono Array con Chiavi

I metodi `getTableColumns`, `getFormSchema`, `getTableBulkActions`, `getTableActions`, `getTableFilters`, `getHeaderActions` restituiscono sempre array con chiavi.

**Regola**: Usare `array<string|int, Component>` o `array<string, Component>` - **MAI `mixed`** se non come ultima spiaggia.

```php
// ❌ SBAGLIATO - Usa mixed
public function getFormSchema(): array
{
    return [/* ... */]; // PHPStan non sa che le chiavi sono string
}

// ✅ CORRETTO - Specifica le chiavi
/**
 * @return array<string, Component>
 */
public function getFormSchema(): array
{
    return [
        'email' => TextInput::make('email'),
        'password' => TextInput::make('password'),
    ];
}
```

### Widget: Chiavi Stringa Obbligatorie

Per `getFormSchema()` nei **widget senza modello**, le chiavi stringa sono **obbligatorie** per il corretto binding con `statePath('data')`:

```php
// ✅ CORRETTO per widget senza modello
/**
 * @return array<string, Component>
 */
public function getFormSchema(): array
{
    return [
        'email' => TextInput::make('email')->email()->required(),  // Chiave stringa necessaria
        'password' => TextInput::make('password')->password()->required(),  // Chiave stringa necessaria
    ];
}
```

### Resource/Pages: Array Indicizzati

Per `getFormSchema()` nei **resource e pagine**, usare array indicizzati:

```php
// ✅ CORRETTO per resource/pagine
/**
 * @return array<int, Component>
 */
public static function getFormSchema(): array
{
    return [
        TextInput::make('email')->email()->required(),
        TextInput::make('password')->password()->required(),
    ];  // Array indicizzato senza chiavi stringa
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

## 🔍 Eloquent Magic Properties

**Regola Critica**: **MAI usare `property_exists()` con modelli Eloquent** perché gli attributi dei modelli sono magici.

```php
// ❌ SBAGLIATO
if (property_exists($model, 'name')) {
    // Non funziona con attributi magici
}

// ✅ CORRETTO - Usa uno di questi metodi
if (isset($model->name)) {
    // Funziona con attributi magici
}

// Oppure
if ($model->hasAttribute('name')) {
    // Metodo Eloquent specifico
}

// Oppure per verificare se è fillable
if ($model->isFillable('name')) {
    // Verifica se il campo è fillable
}

// Oppure per verificare se esiste nella tabella
if (Schema::hasColumn($model->getTable(), 'name')) {
    // Verifica se la colonna esiste nella tabella
}
```

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
     * @return array<int, Component>
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

namespace Modules\User\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

class LoginWidget extends XotBaseWidget
{
    /**
     * @return array<string, Component>
     */
    #[\Override]
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
- [ ] Ho specificato correttamente i tipi array (string|int, non mixed)?
- [ ] Non sto usando `property_exists()` con modelli?
- [ ] Per widget, `getFormSchema()` è public e ha chiavi stringa?

---

## 🔗 Collegamenti Utili

- [XotBaseResource Documentation](./consolidated/filament/resources/xot-base-resource.md)
- [Base Classes Documentation](./consolidated/base-classes.md)
- [Array Typing Rules](./filament-array-typing-rules.md)
- [Spatie Queueable Actions](https://github.com/spatie/laravel-queueable-action)
- [Filament v4 Documentation](https://filamentphp.com/docs/4.x)

---

## 💡 Ricorda Sempre

1. **Mai estendere Filament direttamente** - sempre XotBase
2. **Non replicare metodi** se identici alla classe base
3. **Usa traduzioni** invece di ->label() diretto
4. **Usa Actions** invece di Services
5. **Rispetta deprecazioni** (BadgeColumn, $casts)
6. **Specifica tipi array** (string|int, non mixed)
7. **Mai property_exists()** con modelli - usa isset() o hasAttribute()
8. **Widget: chiavi stringa obbligatorie** in getFormSchema()
9. **Aggiorna docs** dopo ogni implementazione

---

**Filosofia**: DRY + KISS - Non duplicare, non complicare, usa sempre le classi base.


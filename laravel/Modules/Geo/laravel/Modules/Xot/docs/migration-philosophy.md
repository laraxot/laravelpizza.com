# Laraxot Migration Architecture Philosophy

## 🚨 ABSOLUTE RULE: NEVER USE DESTRUCTIVE MIGRATION COMMANDS

**FORBIDDEN - NEVER USE THESE COMMANDS:**
- `php artisan migrate:fresh`
- `php artisan migrate --force` 
- `php artisan migrate:refresh`
- `php artisan migrate:fresh --seed`
- Any variation of destructive migration commands

**REASON**: These commands destroy data, drop tables, or recreate databases without safeguards. They are dangerous in production, shared environments, or when data integrity matters.

**ALTERNATIVE**: Use proper migration updates following Laraxot philosophy - one migration per table, modify existing migrations with timestamp updates, never drop or recreate.

## Core Migration Principles

### The Single Source of Truth Principle

**🚨 FUNDAMENTAL RULE**: Each database table must have exactly **ONE** authoritative `create_table` migration within its module.

### Why This Architecture Matters

1. **<nome progetto>able Schema Evolution**: Clear, linear progression of database changes
2. **Environment Consistency**: Same migration order across all environments
3. **Maintainability**: Single file to modify for each table's base schema
4. **DRY Compliance**: Eliminates redundant schema definitions
5. **XotBaseMigration Integration**: Leverages auto-discovery and idempotent operations

### The XotBaseMigration Advantage

The `XotBaseMigration` class provides sophisticated migration capabilities:

#### Auto-Discovery Features

```php
// Automatically detects model class from migration name
public function getModelClass(): string
{
    // Extracts 'Role' from 'CreateRolesTable'
    // Resolves to: Modules\User\Models\Role
}
```

#### Idempotent Operations

```php
// Safe table creation - only creates if doesn't exist
$this->tableCreate(function (Blueprint $table) {
    $table->id();
    $table->string('name');
});

// Safe table updates - only adds missing columns
$this->tableUpdate(function (Blueprint $table) {
    if (!$this->hasColumn('team_id')) {
        $table->foreignId('team_id')->nullable()->index();
    }
});
```

### Migration Types and Their Purpose

#### 1. Table Creation Migrations
#### 1. Table Creation Migrations (UNICA per tabella)
- **Pattern**: `{timestamp}_create_{table}_table.php`
- **Purpose**: Define the base table schema
- **Rule**: Exactly ONE per table per module
- **Example**: `2024_01_01_000011_create_roles_table.php`

#### 2. Modifiche allo schema: stessa migrazione
- **Regola**: Per modificare campi o aggiungere colonne, **NON** creare nuove migrazioni separate
- **Procedura**: Modificare la **stessa** migrazione esistente e aggiornare il **timestamp** nel nome del file
- **Esempio**: Se `2024_01_01_000011_create_profiles_table.php` deve aggiungere `uuid`, si modifica quel file e si rinomina in `2026_02_22_000000_create_profiles_table.php`
- **Motivazione**: Una sola fonte di verità, DRY, KISS

#### 3. Data Migration Migrations (solo per trasformazioni dati)
- **Pattern**: `{timestamp}_migrate_{purpose}.php`
- **Purpose**: Transform or seed data (NON modifiche schema)
#### 2. Schema Evolution Migrations
- **Pattern**: `{timestamp}_{action}_{table}.php`
- **Purpose**: Modify existing table schema
- **Examples**:
  - `2024_06_15_add_email_to_users.php`
  - `2024_07_20_remove_old_column_from_posts.php`

#### 3. Data Migration Migrations
- **Pattern**: `{timestamp}_migrate_{purpose}.php`
- **Purpose**: Transform or seed data
- **Examples**:
  - `2024_08_10_migrate_user_roles.php`
  - `2024_09_15_seed_default_permissions.php`

### The Duplicate Migration Anti-Pattern

#### What NOT to Do

```
❌ WRONG - Multiple create_table migrations for same table
Modules/User/database/migrations/
├── 2023_01_01_000011_create_roles_table.php  # Duplicate
├── 2023_01_01_000012_create_roles_table.php  # Duplicate
└── 2024_01_01_000011_create_roles_table.php  # Authoritative
```

#### Why This Is Problematic

1. **Migration Order Ambiguity**: Which migration runs first?
2. **Schema Conflict Risk**: Different migrations may define different schemas
3. **Rollback Complexity**: Which migration should be rolled back?
4. **Development Confusion**: Which file is the source of truth?

### Correct Migration Strategy

#### Single Authoritative Migration

```
✅ CORRECT - One create_table migration per table
Modules/User/database/migrations/
├── 2024_01_01_000001_create_users_table.php
├── 2024_01_01_000011_create_roles_table.php      # Single authoritative
├── 2024_01_01_000021_create_permissions_table.php
└── 2026_02_22_000000_create_profiles_table.php   # Modifiche: stessa migrazione, timestamp aggiornato
```

**NON** creare `add_team_id_to_roles.php` separata: modificare `create_roles_table.php` e aggiornare il timestamp.

└── 2024_06_15_143000_add_team_id_to_roles.php    # Schema evolution
```

#### Schema Evolution Approach

When you need to modify a table:

1. **NEVER** create a new `create_table` migration
2. **NEVER** creare migrazioni separate tipo `add_column_to_table`
3. **ALWAYS** modificare la **stessa** migrazione esistente
4. **ALWAYS** aggiornare il timestamp nel nome del file
5. **USE** `XotBaseMigration::tableUpdate()` per aggiunte sicure
2. **ALWAYS** create a schema evolution migration
3. **USE** `XotBaseMigration::tableUpdate()` for safe modifications

### XotBaseMigration Best Practices

#### 1. Leverage Auto-Discovery

```php
class CreateRolesTable extends XotBaseMigration
{
    public function up(): void
    {
        // Connection auto-discovered as 'user'
        // Model auto-discovered as Modules\User\Models\Role

        $this->tableCreate(function (Blueprint $table) {
            // Base schema definition
        });

        $this->tableUpdate(function (Blueprint $table) {
            // Safe schema evolution
        });
    }
}
```

#### 2. Use Idempotent Methods

```php
// ✅ CORRECT - Safe for multiple runs
$this->tableCreate(...);
$this->tableUpdate(...);

// ❌ WRONG - May fail on subsequent runs
Schema::create(...);
$table->addColumn(...);
```

#### 3. Handle Connection Auto-Discovery

```php
// Connection automatically determined from:
// Modules\User\Models\Role → 'user' connection
// No need to manually set $connection
```

### Migration Cleanup Protocol

When duplicate migrations are discovered:

1. **Identify Authoritative File**: Most complete/current schema definition
2. **Remove Duplicates**: Delete older `create_table` migrations
3. **Verify Dependencies**: Ensure no other migrations depend on duplicates
4. **Test Rollback**: Confirm clean rollback and re-migration
5. **Update Documentation**: Document the consolidation

### Module-Specific Implementation

Each module should:

1. Maintain exactly one `create_table` migration per table
2. Use `XotBaseMigration` for all migrations
3. Document migration dependencies in module README
4. Follow consistent naming conventions

### Main-Module Dependency Rule

**Modelli strettamente dipendenti dal main_module** (es. Profile): la migrazione deve stare nel modulo main (es. TechPlanner), NON in moduli generici (User). Profile è dominio del main_module.

### Profile with UUID for Android/Postgres

Per tabelle che devono essere compatibili con applicazioni Android e Postgres, usare:
- `id` auto-increment (bigint)
- `uuid` colonna separata per referenziazione esterna

### Screenshots and Docs Location

**REGOLA**: Gli screenshot e la documentazione visuale devono essere salvati nelle cartelle `docs/` dentro i moduli e i temi, MAI in `/tmp` o altre posizioni.

```bash
# ✅ CORRETTO
laravel/Modules/User/docs/screenshots/login-widget.png
laravel/Themes/Two/docs/fix/login-alpine.png

# ❌ SBAGLIATO
/tmp/screenshot.png
/home/user/screenshots.png
```

---

## Alpine.js and Livewire in Themes

**REGOLA FONDAMENTALE**: Alpine.js è fornito automaticamente da Livewire/Filament. **NON** includere Alpine.js nel bundle del tema.

### Perché

- Livewire inietta automaticamente Alpine.js nel bundle
- Includere una seconda versione (bundle o CDN) causa errori critici:
  - `Detected multiple instances of Alpine running`
  - `$wire is not defined` nei form Filament
  - Form che non funzionano

### Come Configurare

#### 1. package.json - NON includere alpinejs

```json
{
  "dependencies": {
    "daisyui": "^5.5.18"
    "alpinejs": "NON INCLUDERE"
  },
  "devDependencies": {
    "@alpinejs/focus": "^3.14.9"  // Focus plugin, ma solo se necessario
  }
}
```

#### 2. app.js - NON importare alpine

```javascript
// ❌ SBAGLIATO
import Alpine from 'alpinejs'
import AlpineFocus from '@alpinejs/focus'

// ✅ CORRETTO - Lascia che Livewire gestisca Alpine
// app.js può rimanere vuoto
```

#### 3. Layout del tema

```blade
<!-- themes/Two/resources/views/components/layouts/main.blade.php -->
<body>
    ...
    {{-- Livewire fornisce automaticamente Alpine.js --}}
    @livewireScripts
    @filamentScripts
    
    {{-- Il bundle JS del tema (se necessario) --}}
    @vite(['resources/js/app.js'], 'themes/Two')
</body>
```

#### 4. Se serve Alpine dal CDN (emergenze)

```blade
{{-- Solo in caso di emergenza se Livewire non funziona --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
```

### Errori Comuni e Soluzioni

| Errore | Causa | Soluzione |
|--------|-------|-----------|
| `$wire is not defined` | Doppio Alpine | Rimuovere import da app.js |
| `Detected multiple instances` | Due versioni Alpine | Usare solo quella di Livewire |
| Form non submit | Alpine non caricato | Verificare @livewireScripts |

---

## Filament Widgets in Blade Views

**REGOLA**: I form devono essere gestiti SEMPRE tramite Filament Widget, NON con form HTML tradizionali.

### Perché

- Validazione automatica
- CSRF gestito da Livewire
- UI consistente con Filament
- Facilmente estendibile

### Come Usare un Filament Widget

#### 1. Creare il Widget

```php
// Modules/User/app/Filament/Widgets/Auth/LoginWidget.php
class LoginWidget extends XotBaseWidget
{
    protected string $view = 'user::filament.widgets.auth.login';

    public function getFormSchema(): array
    {
        return [
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->autofocus(),
            'password' => TextInput::make('password')
                ->password()
                ->required(),
            'remember' => Checkbox::make('remember'),
        ];
    }

    public function save(): void
    {
        // Logica di login
    }
}
```

#### 2. Creare la View del Widget

```blade
{{-- Modules/User/resources/views/filament/widgets/auth/login.blade.php --}}
<div class="filament-widget-login">
    <form wire:submit.prevent="save" class="space-y-5">
        {{ $this->form }}
        
        <button type="submit" class="...">
            {{ __('user::auth.login.submit') }}
        </button>
    </form>
</div>
```

#### 3. Usare nella Blade Page

```blade
{{-- themes/Two/resources/views/pages/auth/login.blade.php --}}
@livewire(\Modules\User\Filament\Widgets\Auth\LoginWidget::class)
```

### Traduzioni nei Widget

**REGOLA**: MAI usare `->label()` o `->placeholder()` nei componenti Filament. Le traduzioni sono gestite tramite LangServiceProvider.

```php
// ❌ SBAGLIATO
TextInput::make('email')
    ->label('Email')
    ->placeholder('Inserisci email')

// ✅ CORRETTO - Label gestita dalla view
TextInput::make('email')
```

```blade
<!-- Nella view del widget -->
<div>
    <label for="email">{{ __('user::auth.login.email') }}</label>
    <input type="email" wire:model="email" id="email">
</div>
```

### Registrazione Widget nel ServiceProvider

Per rendere disponibile un widget con alias stringa (opzionale):

```php
// Modules/User/app/Providers/UserServiceProvider.php
use Livewire\Livewire;
use Modules\User\Filament\Widgets\Auth\LoginWidget;

protected function registerLivewireAuthWidgets(): void
{
    $widgets = [
        'user::filament.widgets.auth.login-widget' => LoginWidget::class,
    ];
    
    foreach ($widgets as $name => $class) {
        Livewire::component($name, $class);
    }
}
```

### Errori Comuni

| Problema | Causa | Soluzione |
|----------|-------|-----------|
| `ComponentNotFoundException` | Widget non registrato | Usare classe invece di alias, o verificare ServiceProvider |
| Form non funziona | `$wire` non definito | Verificare Alpine.js (vedi sezione precedente) |
| Labels in inglese | Traduzioni mancanti | Aggiungere in lang/xx/ |

### Alpine.js and Livewire in Themes

**REGOLA**: Alpine.js è fornito automaticamente da Livewire/Filament. NON includere Alpine.js nel bundle del tema.

### Filament Widgets in Blade Views

**REGOLA**: I form devono essere gestiti SEMPRE tramite Filament Widget, NON con form HTML tradizionali.

### Exception Cases

**The ONLY exception** to the one-migration-per-table rule:

- **Module Splitting**: When a table moves to a different module
- **Major Refactoring**: Complete schema redesign requiring new table
- In both cases, the old migration should be removed after transition

---

**Philosophy Summary**: In Laraxot, migrations are the definitive history of your database schema. Keep that history clean, linear, and unambiguous. One table, one creation story.
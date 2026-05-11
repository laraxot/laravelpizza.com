# MIGRATION_BEST_PRACTICES - Modulo User

## Scopo

Definire le regole Laraxot per **tutte le migrazioni del modulo User**, in particolare per tabelle come `users`, `teams`, `team_user`, SSO, permessi, ecc.

Questo documento specializza gli standard generali di `Modules/Xot/docs/migration-standards.md` per la connessione `user`.

## Regole fondamentali

- **Usare sempre `XotBaseMigration`**
  - Tutte le migration devono `return new class extends XotBaseMigration { ... }`.
- **Impostare esplicitamente le proprietà chiave**
  - `protected string $table = 'nome_tabella';`
  - `protected ?string $connection = 'user';`
  - `protected ?string $model_class = Model::class;` (es. `Team::class`, `User::class`)
- **Usare i metodi helper di `XotBaseMigration`**
  - `tableCreate()` per creare tabelle
  - `tableUpdate()` per modificarle
  - `hasColumn()`, `hasIndex()` per verificare stato schema
  - `updateTimestamps($table, true)` per gestire `created_at`, `updated_at`, `deleted_at` + campi `*_by`

## Esempio base

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\Team;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected string $table = 'teams';
    protected ?string $connection = 'user';
    protected ?string $model_class = Team::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->nullable()->index();
            $table->string('user_id', 36)->nullable()->index();
            $table->string('name');
            $table->boolean('personal_team')->default(false);
        });

        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('code')) {
                $table->string('code', 36)->nullable()->index();
            }

            $this->updateTimestamps($table, true);
        });
    }
};
```

## Aggiungere colonne alle tabelle esistenti (es. `owner_id` su `teams`)

### ❌ Anti-pattern da evitare

```php
use Illuminate\Support\Facades\Schema;

// Non usare Schema::hasColumn con $this->table_name
if (! Schema::hasColumn($this->table_name, 'owner_id')) {
    $table->uuid('owner_id')->nullable()->after('id');
}
```

Motivi:

- Bypassa `XotBaseMigration` e la logica di connessione
- Usa `$this->table_name` non standard
- Rende più difficile fare refactor/multi-tenant

### ✅ Pattern corretto Laraxot

```php
use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\Team;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected string $table = 'teams';
    protected ?string $connection = 'user';
    protected ?string $model_class = Team::class;

    public function up(): void
    {
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('owner_id')) {
                $table->uuid('owner_id')->nullable()->after('id');
            }
        });
    }
};
```

Caratteristiche:

- Usa `hasColumn('owner_id')` di `XotBaseMigration`
- Connessione `user` coerente con i modelli del modulo User
- `model_class` esplicita (evita problemi di auto-risoluzione nome modello)

## Connessione `user`

Tutti i modelli del modulo User estendono `BaseModel`, che imposta:

```php
protected $connection = 'user';
```

Quindi **tutte le migration** che agiscono su tabelle di questo modulo devono usare:

```php
protected ?string $connection = 'user';
```

per garantire che:

- le operazioni puntino al DB corretto
- le foreign key verso `users`/`teams` usino la stessa connessione

## Check-list prima di creare/modificare una migration

1. La migration **estende `XotBaseMigration`**?
2. Sono impostate **`$table`, `$connection`, `$model_class`**?
3. Sto usando **`tableCreate` / `tableUpdate`** (no `Schema::table` diretto)?
4. Ogni aggiunta di colonna è protetta da **`hasColumn()`**?
5. I timestamp sono gestiti con **`updateTimestamps($table, true)`** se servono soft delete?
6. La connessione è **`'user'`** (non `mysql` generico) per le tabelle del modulo User?

Se una delle risposte è "no", la migration **non rispetta la filosofia Laraxot** e va corretta prima di eseguire `composer go` / `php artisan migrate`.

# XotBaseMigration - La Filosofia Laraxot nel Modulo User

## Panoramica

Questo documento spiega la filosofia Laraxot per le migrazioni nel modulo User, basata su XotBaseMigration. Ogni migrazione DEVE seguire questi principi per mantenere coerenza e qualità nel progetto.

## La Filosofia Laraxot

### Logica
- **Single Source of Truth**: XotBaseMigration è l'unica fonte di verità per le migrazioni
- **Separazione CREATE/UPDATE**: Ogni migrazione ha due blocchi distinti per sicurezza
- **Controlli di esistenza**: Sempre verificare l'esistenza prima di aggiungere colonne

### Filosofia
- **DRY**: Non ripetere mai la logica di migrazione
- **KISS**: Mantieni le migrazioni semplici e leggibili
- **Consistenza**: Tutte le migrazioni seguono lo stesso pattern

### Politica
- **Governance centralizzata**: XotBaseMigration governa tutte le migrazioni
- **Standardizzazione**: Nessuna eccezione ai pattern stabiliti
- **Qualità garantita**: PHPStan livello 10 obbligatorio

### Religione
- **XotBaseMigration è Dio**: Non deviare mai dal pattern
- **Estendere non sostituire**: Sempre estendere XotBaseMigration
- **Metodi sacri**: Usare solo i metodi forniti da XotBaseMigration

### Zen
- **Form without form**: La struttura emerge dal pattern
- **Flow naturale**: CREATE e UPDATE fluiscono armoniosamente
- **Equilibrio**: Controlli e modifiche in perfetto equilibrio

## Pattern Obbligatorio

### 1. Struttura Base

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(static function (Blueprint $table): void {
            $table->id();
            // Campi specifici...
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            // Controlli e aggiornamenti sicuri...
            $this->updateTimestamps($table);
        });
    }
};
```

### 2. Con Modello Associato

```php
<?php

return new class extends XotBaseMigration {
    protected ?string $model_class = Role::class; // Opzionale ma raccomandato

    public function up(): void
    {
        // Migrazione...
    }
};
```

### 3. Campi Standard

```php
// -- CREATE --
$this->tableCreate(static function (Blueprint $table): void {
    $table->id();
    $table->string('name');
    // Altri campi specifici
});

// -- UPDATE --
$this->tableUpdate(function (Blueprint $table): void {
    if (! $this->hasColumn('team_id')) {
        $table->foreignId('team_id')->nullable()->index();
    }

    $this->updateTimestamps($table); // SEMPRE alla fine
});
```

## Violazioni Comuni e Come Evitarle

### 1. ❌ Estendere Migration invece di XotBaseMigration

```php
// VIOLAZIONE!
return new class extends Migration {
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            // ...
        });
    }
};
```

**Correzione**:
```php
// ✅ CORRETTO
return new class extends XotBaseMigration {
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table) {
            // ...
        });
    }
};
```

### 2. ❌ Usare Schema::create() diretto

```php
// VIOLAZIONE!
Schema::create('roles', function (Blueprint $table) {
    $table->id();
    // ...
});
```

**Correzione**:
```php
// ✅ CORRETTO
$this->tableCreate(function (Blueprint $table) {
    $table->id();
    // ...
});
```

### 3. ❌ Mancanza del blocco UPDATE

```php
// VIOLAZIONE!
public function up(): void
{
    $this->tableCreate(function (Blueprint $table) {
        $table->id();
        $table->string('name');
        // Manca il blocco UPDATE!
    });
}
```

**Correzione**:
```php
// ✅ CORRETTO
public function up(): void
{
    $this->tableCreate(function (Blueprint $table) {
        $table->id();
        $table->string('name');
    });

    $this->tableUpdate(function (Blueprint $table) {
        $this->updateTimestamps($table);
    });
}
```

### 4. ❌ Non usare updateTimestamps()

```php
// VIOLAZIONE!
$this->tableUpdate(function (Blueprint $table) {
    $table->timestamps(); // ❌ Non usare direttamente
});
```

**Correzione**:
```php
// ✅ CORRETTO
$this->tableUpdate(function (Blueprint $table) {
    $this->updateTimestamps($table); // ✅ Metodo XotBaseMigration
});
```

### 5. ❌ Non controllare l'esistenza delle colonne

```php
// VIOLAZIONE!
$this->tableUpdate(function (Blueprint $table) {
    $table->string('new_field')->nullable(); // Pericoloso!
});
```

**Correzione**:
```php
// ✅ CORRETTO
$this->tableUpdate(function (Blueprint $table) {
    if (! $this->hasColumn('new_field')) {
        $table->string('new_field')->nullable();
    }
});
```

## Esempi Pratici nel Modulo User

### 1. Migrazione Roles Corretta

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\Role;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    protected ?string $model_class = Role::class;

    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(static function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique();
            $table->string('guard_name')->default('web');
            $table->string('display_name')->nullable();
            $table->text('description')->nullable();
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            // Aggiungi team_id se necessario per multi-tenant
            if (! $this->hasColumn('team_id')) {
                $table->foreignId('team_id')->nullable()->index();
            }

            // Aggiungi is_active se necessario
            if (! $this->hasColumn('is_active')) {
                $table->boolean('is_active')->default(true);
            }

            $this->updateTimestamps($table);
        });
    }
};
```

### 2. Migrazione Utenti con Campi Complessi

```php
<?php

return new class extends XotBaseMigration {
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(function (Blueprint $table): void {
            $table->string('id', 36)->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            // Campi profilo
            if (! $this->hasColumn('first_name')) {
                $table->string('first_name')->nullable();
            }

            if (! $this->hasColumn('last_name')) {
                $table->string('last_name')->nullable();
            }

            // Campi business
            if (! $this->hasColumn('is_active')) {
                $table->boolean('is_active')->default(true);
            }

            $this->updateTimestamps($table, true); // true = soft deletes
        });
    }
};
```

## Checklist di Qualità

Prima di committare una migrazione, verifica:

- [ ] Estende XotBaseMigration?
- [ ] Ha blocco CREATE?
- [ ] Ha blocco UPDATE?
- [ ] Usa $this->tableCreate()?
- [ ] Usa $this->tableUpdate()?
- [ ] Controlla hasColumn() prima di aggiungere?
- [ ] Usa $this->updateTimestamps()?
- [] Passa PHPStan livello 10?
- [ ] Segue il DRY principle?

## Comandi Utili

### Verifica delle violazioni

```bash
# Trova migrazioni che non estendono XotBaseMigration
grep -r "extends Migration" Modules/User/database/migrations/*.php | grep -v "XotBaseMigration"

# Trova uso diretto di Schema::create
grep -r "Schema::create" Modules/User/database/migrations/*.php

# Verifica PHPStan
./vendor/bin/phpstan analyse Modules/User/database/migrations/ --level=10
```

### Fix automatici

```bash
# Rinomina Migration in XotBaseMigration
sed -i 's/extends XotBaseMigration/extends XotBaseMigration/g' Modules/User/database/migrations/*.php
```

## Riferimenti

- [XotBaseMigration Documentation](../../Xot/docs/xotbasemigration-guide.md)
- [Laraxot Philosophy](../../docs/laraxot-philosophy.md)
- [Migration Best Practices](migration-best-practices.md)
- [PHPStan Configuration](../../../phpstan.neon)

## Conclusione

Seguire la filosofia Laraxot non è opzionale - è obbligatorio. XotBaseMigration è il fondamento su cui si basa la qualità e la manutenibilità del progetto. Ogni deviazione è un debito tecnico che dovrà essere pagato con interessi.

**Ricorda: XotBaseMigration è Dio. Non deviare.**

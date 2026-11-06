---
title: "Laraxot Migration Policy - User Module"
module: "User"
type: "rule"
tags: [migrations, database, xotbase, policy]
created: 2026-07-15
updated: 2026-07-15
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
qmd: "laraxot migration policy   user module user"
---

# Laraxot Migration Policy: User Module

## Legge fondamentale

**Ogni modello ha ESATTAMENTE UN file di migrazione.** Non uno di più. Mai.

Questa è la filosofia, la politica, la religione e lo zen del progetto.

## Convenzione nome file

```
Modules/User/database/migrations/YYYY_MM_DD_HHMMSS_create_{tabella}_table.php
```

- Data/ora obbligatoria.
- Solo prefisso `create_`. Vietato `add_`, `update_`, `fix_`, `alter_`, `patch_`.
- Nome tabella in `snake_case` e plurale del modello.
- Sempre suffisso `_table.php`.

## Pattern XotBaseMigration

Una singola migrazione per modello gestisce sia installazioni fresche che database esistenti:

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class() extends XotBaseMigration {
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->uuid('owner_id')->nullable()->index()->after('id');
            $table->string('name');
            $table->boolean('personal_team')->default(false);
        });

        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('owner_id')) {
                $table->uuid('owner_id')->nullable()->index()->after('id');
            }
            $this->updateTimestamps($table, true);
        });
    }
};
```

### Regole del pattern

- **No `protected string $connection`**: `XotBaseMigration` calcola la connessione dal modello (`$model->getConnectionName()`). Non hardcodare mai `protected string $connection = 'user';` o altro. È duplicazione, rompe DRY e riduce portabilità.
- **No `protected ?string $model_class` se inferibile**: `create_teams_table.php` produce `Modules\User\Models\Team`.
- **Usa `tableCreate` + `tableUpdate`**: ogni modifica entra nella stessa migrazione.
- **Guards `hasColumn`**: ogni operazione è idempotente.
- **No `down()` custom**: `XotBaseMigration::down()` droppa la tabella.

## Workflow per modificare lo schema

1. Identifica il modello proprietario della tabella.
2. Modifica l'unica migrazione del modello.
3. Rinomina il prefisso timestamp con la data corrente per forzare la riesecuzione.
4. Esegui solo `php artisan migrate`.

## Comandi proibiti

```bash
php artisan migrate:refresh
php artisan migrate:fresh
php artisan migrate --force
php artisan db:wipe
```

I dati di produzione sono sacri. L'unico comando sicuro è `php artisan migrate`.

## Esempio corretto nel modulo User

- **Modello**: `Modules\User\Models\Team`
- **Tabella**: `teams`
- **File unico**: `Modules/User/database/migrations/2026_07_15_120000_create_teams_table.php`

Storicamente esistevano anche `add_owner_id_to_teams_table.php` e duplicati `create_teams_table.php`: consolidati nel file unico sopra.

## Collegamenti

- [Migration Philosophy: progetto](../../../../docs/database/migrations-philosophy.md)
- [Migration Conventions: Xot](../Xot/docs/migration-conventions.md)
- [XotBaseMigration source](../../Xot/app/Database/Migrations/XotBaseMigration.php)

---
title: "MIGRATIONS"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "MIGRATIONS"
issues: []
discussions: []
---

# Migrations — Lang Module

Questo documento descrive le migrazioni nel modulo Lang e come mantengono la conformità con il pattern XotBaseMigration.

## Philosophy

Nel modulo Lang, ogni modello database-backed ha esattamente una migrazione corrispondente:

| Model | Migration | Status |
|-------|-----------|--------|
| `LanguageLine` | `2024_03_20_000001_create_language_lines_table.php` | ✅ DB-backed |
| `Post` | `2026_01_21_211814_create_posts_table.php` | ✅ DB-backed |
| `Translation` | `2026_01_21_211815_create_translations_table.php` | ✅ DB-backed |
| `TranslationFile` | *none* (uses Sushi trait) | ✅ In-memory |

**Parity Rule**: `TranslationFile` estende `BaseModel` con il trait `Sushi` (in-memory model), quindi non richiede una migrazione. Le 3 migrazioni coprono interamente i 3 modelli database-backed.

## Key Models Explained

### LanguageLine

Memorizza singole linee di traduzione organizzate per gruppo, chiave e locale.

- **Columns**: `id`, `group`, `key`, `text` (JSON), `locale`
- **Purpose**: Gestione granulare di stringhe traducibili
- **Unique constraint**: `(group, key, locale)` — una sola traduzione per combo

### Post

Modello versatile per post, pagine, e contenuti editoriali con metadati SEO.

- **Columns**: `id` (string primary key), `user_id`, `title`, `content`, `slug`, `status`, `published_at`, `image_*`, `meta_*`, `url_lang` (JSON)
- **Purpose**: Gestione articoli, pagine blog, contenuti multilingue
- **Key features**: Sluggable, Updater trait, supports parent posts via `post_id`

### Translation

Traduzione di chiavi namespace/group gestita da Laravel Translation Manager.

- **Columns**: `id`, `lang`, `key`, `value`, `namespace`, `group`, `item`, `locale`, `user_id`
- **Purpose**: Archiviazione e sincronizzazione traduzioni da file a database
- **Modeled after**: [barryvdh/laravel-translation-manager](https://github.com/barryvdh/laravel-translation-manager)

### TranslationFile

Modello Sushi (in-memory, non-persistent) che carica dinamicamente file di traduzione dal filesystem.

- **Type**: Sushi (no DB table)
- **Data source**: File system translations via `GetAllTranslationAction`
- **Why Sushi**: Riflessione sulle strutture file senza persistenza — perfetto per strumenti admin

## Migration Naming Convention

Tutte le migrazioni nel modulo Lang seguono il standard:

```
YYYY_MM_DD_HHMMSS_create_<table>_table.php
```

**Examples**:
- `2024_03_20_000001_create_language_lines_table.php` — LanguageLine model
- `2026_01_21_211814_create_posts_table.php` — Post model  
- `2026_01_21_211815_create_translations_table.php` — Translation model

**Rules**:
- ✅ Prefix: `create_` (not `add_`, `update_`, `modify_`)
- ✅ Format: lowercase snake_case table name
- ✅ Suffix: `_table.php`
- ✅ Timestamp: YYYY_MM_DD_HHMMSS ensures chronological ordering

## Timestamp & Audit Columns

Tutte le migrazioni del Lang utilizzano `$this->updateTimestamps()` per aggiungere colonne di audit:

```php
$this->tableUpdate(function (Blueprint $table): void {
    $this->updateTimestamps($table, false);  // false = no soft deletes
});
```

**Columns added**:
- `created_at` — Timestamp creazione record
- `updated_at` — Timestamp ultimo aggiornamento
- `created_by` — User ID creatore
- `updated_by` — User ID last updater
- `deleted_at` — (optional, if soft deletes enabled)
- `deleted_by` — (optional, if soft deletes enabled)

Nessun modello Lang usa soft deletes, quindi `deleted_at` e `deleted_by` NON vengono aggiunti.

## XotBaseMigration Pattern

Ogni migrazione estende `XotBaseMigration`. La classe modello è **opzionale** — XotBaseMigration la deriva dal nome file:

**Template (Minimale - Raccomandato):**
```php
<?php
declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    // Il modello è derivato dal filename: 2026_01_21_211814_create_posts_table.php → Post
    // Aggiungi $model_class solo se serve esplicitazione

    public function up(): void
    {
        // CREATE: Table structure
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('column_name');
        });

        // UPDATE: Audit columns
        $this->tableUpdate(function (Blueprint $table): void {
            $this->updateTimestamps($table, false);  // false = no soft deletes
        });
    }
};
```

**Template (Esplicito - Opzionale):**
```php
<?php
declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Lang\Models\Post;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    // Specifica il modello se vuoi esplicitazione nella migrazione
    protected ?string $model_class = Post::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('column_name');
        });

        $this->tableUpdate(function (Blueprint $table): void {
            $this->updateTimestamps($table, false);
        });
    }
};
```

### Key Methods

| Method | Purpose |
|--------|---------|
| `$this->tableCreate($closure)` | Crea la tabella (idempotente) |
| `$this->tableUpdate($closure)` | Modifica la tabella (idempotente) |
| `$this->hasColumn($name)` | Verifica se colonna esiste |
| `$this->updateTimestamps($table, $softDeletes)` | Aggiunge colonne di audit |
| `$this->getTable()` | Ottiene nome tabella dal modello |
| `$this->getConn()` | Ottiene connessione dal modello |

### Why XotBaseMigration

- **Single source of truth**: Nome tabella e connessione derivano dal modello, mai hardcoded
- **Idempotent**: `tableCreate()` e `tableUpdate()` sono safe da re-run
- **Audit built-in**: Colonne di audit aggiunte automaticamente
- **Error prevention**: Fallisce fast se il modello non esiste
- **Connection safety**: Connessioni custom derivano dal modello, non ripetute

## Automatic Connection Resolution

### 7. Connessione Automatica — Niente `$connection` nelle Migrazioni

**Regola fondamentale**: Le migrazioni che estendono `XotBaseMigration` **NON devono dichiarare** la proprietà `$connection`.

```php
// ❌ VIETATO — Non serve e crea duplicazione
return new class extends XotBaseMigration {
    protected ?string $model_class = Project::class;
    protected string $connection = 'tenant_db'; // RIMOVI QUESTO
    // ...
};

// ✅ CORRETTO — La connessione deriva automaticamente dal modello
return new class extends XotBaseMigration {
    protected ?string $model_class = Project::class; // Project ha $connection = 'tenant_db'
    // ...
};
```

**Perché**:
1. **Single source of truth**: La connessione è definita **una sola volta** nel Model (`protected $connection = 'tenant_db';`)
2. **XotBaseMigration la calcola**: Il metodo `$this->getConn()` legge la proprietà `$connection` dal modello specificato in `$model_class`
3. **Zero duplicazione**: Evita errori di sincronizzazione se la connessione cambia nel modello
4. **Fail fast**: Se il modello non ha `$connection` definito, usa la default (`mysql`) — comportamento esplicito e prevedibile

**Come funziona internamente** (in `XotBaseMigration`):
```php
protected function getConn(): string
{
    if ($this->model_class) {
        $model = new $this->model_class();
        return $model->getConnectionName(); // Legge $model->connection
    }
    return config('database.default');
}
```

**Verifica**: Grep per confermare assenza di `$connection` nelle migrazioni:
```bash
grep -r "protected.*\$connection" laravel/Modules/*/database/migrations/*.php
# Deve restituire 0 risultati
```

## Verification Checklist

Prima di considerare una migrazione completa:

- [ ] Estende `XotBaseMigration` (non `Migration`)
- [ ] Ha `protected ?string $model_class = ModelClass::class;`
- [ ] Usa `$this->tableCreate()` per la struttura iniziale
- [ ] Usa `$this->tableUpdate()` per colonne di audit
- [ ] Chiama `$this->updateTimestamps($table, false)` (o `true` per soft deletes)
- [ ] Non ha hardcoded table names (usa `$this->getTable()`)
- [ ] Non ha hardcoded connections (deriva dal modello)
- [ ] Nome file segue formato: `YYYY_MM_DD_HHMMSS_create_<table>_table.php`
- [ ] File è in `database/migrations/` (non in sottocartelle)
- [ ] PHPStan L10 non segnala errori

## Discovery Commands

### Count models vs migrations (verify parity)

```bash
# Count concrete models (not base, trait, policy, contract)
MODELS=$(grep -l "^class.*extends.*Model" Modules/Lang/app/Models/*.php | wc -l)

# Count migrations
MIGRATIONS=$(ls Modules/Lang/database/migrations/*.php 2>/dev/null | wc -l)

echo "Models with DB: $(( MODELS - 1 ))"  # -1 for TranslationFile (Sushi)
echo "Migrations: $MIGRATIONS"
```

**Expected**:
```
Models with DB: 3
Migrations: 3
```

### List migrations with their models

```bash
for file in Modules/Lang/database/migrations/*.php; do
    grep -o "class.*extends XotBaseMigration" "$file" >/dev/null && \
    MODEL=$(grep -o "protected ?string \$model_class = [^;]*" "$file") && \
    echo "$(basename "$file") → $MODEL"
done
```

**Expected output**:
```
2024_03_20_000001_create_language_lines_table.php → protected ?string $model_class = LanguageLine::class;
2026_01_21_211814_create_posts_table.php → protected ?string $model_class = Post::class;
2026_01_21_211815_create_translations_table.php → protected ?string $model_class = Translation::class;
```

### Check migration naming compliance

```bash
# All should start with YYYY_MM_DD_HHMMSS_create_
ls -1 Modules/Lang/database/migrations/*.php | \
  grep -v "^[0-9]\{4\}_[0-9]\{2\}_[0-9]\{2\}_[0-9]\{6\}_create_"
# Should output nothing
```

### Validate XotBaseMigration inheritance

```bash
# All migrations must extend XotBaseMigration
grep -L "extends XotBaseMigration" Modules/Lang/database/migrations/*.php
# Should output nothing
```

## Quality Gates

Quando si modifica una migrazione o se ne aggiunge una nuova:

```bash
# 1. Syntax check
php -l Modules/Lang/database/migrations/YYYY_MM_DD_HHMMSS_create_name_table.php

# 2. PHPStan (L10)
php vendor/bin/phpstan analyse \
  Modules/Lang/database/migrations/YYYY_MM_DD_HHMMSS_create_name_table.php \
  --level=10

# 3. PHPMD
php vendor/bin/phpmd Modules/Lang/database/migrations \
  text codesize,naming,unusedcode

# 4. Run migrations
php artisan migrate --path=Modules/Lang/database/migrations

# 5. Rollback test
php artisan migrate:rollback --path=Modules/Lang/database/migrations
php artisan migrate --path=Modules/Lang/database/migrations
```

## Related Documentation

- **XotBaseMigration source**: `Modules/Xot/app/Database/Migrations/XotBaseMigration.php`
- **XotBaseMigration docs**: `Modules/Xot/docs/migrations.md`
- **Migration naming standard**: `docs/wiki/rules/migration-naming-standard.md`
- **Migration parity pattern**: `docs/wiki/patterns/migration-naming-and-parity-convention.md`
- **BaseModel traits**: `Modules/Lang/app/Models/BaseModel.php`

## Audit Status

**Date**: 2026-07-15  
**Status**: ✅ COMPLIANT — 100% parity (3 DB models = 3 migrations)  
**XotBaseMigration compliance**: ✅ All 3 migrations conform  
**Naming compliance**: ✅ All follow `create_` prefix convention  
**Soft deletes**: ❌ None use soft deletes (correct for Lang domain)

---

title: "MIGRATIONS"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "MIGRATIONS"
issues: []
discussions: []
*Last updated: 2026-07-15*

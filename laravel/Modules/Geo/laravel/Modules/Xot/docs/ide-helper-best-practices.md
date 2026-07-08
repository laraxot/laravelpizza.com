# IDE Helper Best Practices - <nome progetto>

Documentazione completa sull'utilizzo di `barryvdh/laravel-ide-helper` nel progetto <nome progetto>.

---

## Introduzione

Laravel IDE Helper genera PHPDoc automatici per migliorare l'autocomplete e il type checking negli IDE (PHPStorm, VS Code, ecc.).

### Pacchetto Utilizzato
- **barryvdh/laravel-ide-helper** - Genera helper per IDE con supporto PHPStan

---

## Configurazione Progetto

### File di Configurazione

**Path**: `config/ide-helper.php`

**Configurazioni Chiave**:

```php
'model_locations' => [
    'Modules/*/app/Models',  // Scansiona tutti i moduli
],

'use_generics_annotations' => true,  // Usa Collection<Model> invece di Collection|Model[]

'write_model_magic_where' => true,  // Genera where* magic methods

'write_model_external_builder_methods' => true,  // Genera metodi Builder esterni

'write_model_relation_count_properties' => true,  // Genera *_count properties
```

---

## Comandi Disponibili

### 1. Generate Models PHPDoc

```bash
cd /var/www/_bases/base_<nome progetto>/laravel
php artisan ide-helper:models --write
```

**Cosa fa**:
- Scansiona tutti i modelli in `Modules/*/app/Models`
- Genera PHPDoc con `@property` per tutte le colonne database
- Genera `@property-read` per relazioni
- Genera `@method` per scope e magic methods
- Scrive direttamente nei file dei modelli

**Opzioni**:
- `--write` - Scrive nei file (default)
- `--nowrite` - Genera solo `_ide_helper_models.php`
- `--reset` - Rimuove PHPDoc esistenti prima di rigenerare

### 2. Generate Facades Helper

```bash
php artisan ide-helper:generate
```

**Cosa fa**:
- Genera `_ide_helper.php` con autocomplete per Facades
- Include Route, Config, Cache, ecc.

### 3. Generate PhpStorm Meta

```bash
php artisan ide-helper:meta
```

**Cosa fa**:
- Genera `.phpstorm.meta.php` per PhpStorm
- Migliora type inference per factory, container, ecc.

---

## Pattern PHPDoc Generati

### Proprietà Database

```php
/**
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Event extends BaseModel
```

### Relazioni

```php
/**
 * @property-read User|null $owner
 * @property-read User|null $organizer
 * @property-read Collection<int, EventUser> $attendees
 * @property-read int|null $attendees_count
 */
class Event extends BaseModel
{
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
```

### Scope e Magic Methods

```php
/**
 * @method static Builder<Event> upcoming()
 * @method static Builder<Event> past()
 * @method static Builder<Event> whereTitle($value)
 * @method static Builder<Event> whereStatus($value)
 */
class Event extends BaseModel
{
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('start_date', '>=', now());
    }
}
```

### Generics per Collection

```php
/**
 * @property-read Collection<int, User> $users
 * @property-read MediaCollection<int, Media> $media
 */
```

---

## Best Practices

### 1. Eseguire Dopo Modifiche Database

```bash
# Dopo ogni migrazione o modifica modello
php artisan migrate
php artisan ide-helper:models --write
```

### 2. Mantenere PHPDoc Personalizzati

IDE Helper **preserva** i PHPDoc personalizzati esistenti:

```php
/**
 * Modules\Meetup\Models\Event.
 *
 * Schema.org Event implementation with structured data support.
 *
 * @property int $id  // ← Generato da IDE Helper
 * @property string $title  // ← Generato da IDE Helper
 *
 * @method static Builder<Event> upcoming()  // ← Generato da IDE Helper
 * @method static Builder<Event> bySlug(string $slug)  // ← Personalizzato, preservato
 *
 * @see https://schema.org/Event  // ← Personalizzato, preservato
 */
class Event extends BaseModel
```

### 3. Commit dei File Generati

**File da committare**:
- ✅ Modifiche ai modelli (PHPDoc inline)
- ✅ `_ide_helper.php`
- ✅ `_ide_helper_models.php` (se usato)
- ✅ `.phpstorm.meta.php`

**File da ignorare**:
```gitignore
# Già nel .gitignore del progetto
```

### 4. ProfileContract — correzione obbligatoria dopo ide-helper (CRITICAL)

`ide-helper:models -W` genera automaticamente il tipo sbagliato per `$creator`, `$updater`, `$deleter`.

**Il tipo generato (SBAGLIATO):**
```php
// ❌ ide-helper scrive la classe Profile concreta del modulo che trova
* @property-read \Modules\Meetup\Models\Profile|null $creator
* @property-read \Modules\Ptv\Models\Profile|null $updater
```

**Il tipo corretto (da ripristinare manualmente):**
```php
// ✅ SEMPRE l'interfaccia ProfileContract
* @property-read \Modules\Xot\Contracts\ProfileContract|null $creator
* @property-read \Modules\Xot\Contracts\ProfileContract|null $deleter
* @property-read \Modules\Xot\Contracts\ProfileContract|null $updater
```

**Verifica dopo ogni esecuzione di ide-helper:**
```bash
grep -r "@property-read.*Models\\\\Profile.*\$(creator\|updater\|deleter)" Modules --include="*.php"
```
Se produce output: correggere quei file. Zero output = tutto ok.

Rule dedicata: `.cursor/rules/profile-contract-docblock.mdc`

### 5. Integrazione con PHPStan

IDE Helper è **compatibile** con PHPStan Level 10, ma solo dopo la correzione del punto 4:

```bash
# Verifica conformità
./vendor/bin/phpstan analyze Modules/Meetup/app/Models --level=10
```

**Risultato atteso**: 0 errori

---

## Workflow Consigliato

### Sviluppo Quotidiano

```bash
# 1. Modifica migrazione/modello
vim Modules/Meetup/database/migrations/2026_*_create_events_table.php

# 2. Esegui migrazione
php artisan migrate

# 3. Rigenera PHPDoc
php artisan ide-helper:models -W

# 3b. Correggi ProfileContract (OBBLIGATORIO dopo ide-helper)
# Verifica se ci sono tipi Profile concreti nei docblock
grep -r "@property-read.*Models\\\\Profile.*\$(creator\|updater\|deleter)" Modules --include="*.php"
# Se ci sono: correggi con \Modules\Xot\Contracts\ProfileContract|null

# 4. Verifica PHPStan
./vendor/bin/phpstan analyze Modules/Meetup --level=10

# 5. Commit
git add .
git commit -m "feat: add new fields to Event model"
```

### Ambiente di esecuzione

`ide-helper:models --write` o `-W` non va interpretato correttamente se il processo non puo' interrogare il database reale.

Nel progetto molti modelli usano connessioni non standard (`activity`, `gdpr`, `xot`, oltre a `mysql`), quindi:

- errori `SQLSTATE[HY000] [2002]` indicano spesso un problema di raggiungibilita' DB, non del model;
- prima di correggere relation o phpdoc bisogna ripetere il comando in ambiente con MySQL locale raggiungibile;
- solo il secondo run "live" puo' essere usato come base per valutare segnalazioni reali.

### Setup Nuovo Sviluppatore

```bash
# 1. Clone repository
git clone ...
cd laravel

# 2. Install dependencies
composer install

# 3. Generate all IDE helpers
php artisan ide-helper:generate
php artisan ide-helper:models --write
php artisan ide-helper:meta
```

---

## Troubleshooting

### Problema: PHPDoc Non Generati

**Causa**: Modello non trovato in `model_locations`

**Soluzione**:
```php
// config/ide-helper.php
'model_locations' => [
    'Modules/*/app/Models',  // ✅ Pattern corretto
    // 'app/Models',  // ❌ Non usato in questo progetto
],
```

### Problema: Relazioni Non Riconosciute

**Causa**: Tipo di ritorno mancante nel metodo relazione

**Soluzione**:
```php
// ❌ ERRATO
public function owner()
{
    return $this->belongsTo(User::class);
}

// ✅ CORRETTO
public function owner(): BelongsTo
{
    return $this->belongsTo(User::class);
}
```

### Problema: Scope Non Generati

**Causa**: Tipo di ritorno mancante nello scope

**Soluzione**:
```php
// ❌ ERRATO
public function scopeUpcoming($query)
{
    return $query->where('start_date', '>=', now());
}

// ✅ CORRETTO
public function scopeUpcoming(Builder $query): Builder
{
    return $query->where('start_date', '>=', now());
}
```

### Problema: Generics Non Funzionano

**Causa**: Configurazione disabilitata

**Soluzione**:
```php
// config/ide-helper.php
'use_generics_annotations' => true,  // ✅ Deve essere true
```

### Problema: Modelli che Causano Errori

Alcuni modelli non possono essere analizzati dall'IDE Helper:

#### Modelli OAuth (Laravel Passport)

I modelli che estendono `Laravel\Passport\Token` causano errori di relazione:

```php
// config/ide-helper.php
'ignored_models' => [
    Modules\User\Models\OauthAccessToken::class,
    Modules\User\Models\OauthToken::class,
    Modules\User\Models\OauthAuthCode::class,
    Modules\User\Models\OauthRefreshToken::class,
    Modules\User\Models\OauthClient::class,
    Modules\User\Models\OauthPersonalAccessClient::class,
    Modules\User\Models\OauthDeviceCode::class,
],
```

#### Modelli Sushi (Dati JSON)

I modelli che usano il trait Sushi per dati JSON usano database SQLite in memoria:

```php
// config/ide-helper.php
'ignored_models' => [
    Modules\Geo\Models\Comune::class,
    Modules\Geo\Models\Locality::class,
    Modules\Geo\Models\Province::class,
    Modules\Geo\Models\Region::class,
],
```

**Errori tipici**:
- `SQLSTATE[HY000]: General error: 1 malformed JSON`
- `SQLSTATE[HY000]: General error: 1 all VALUES must have the same number of terms`
- `Error resolving relation model of ...`

**Soluzione**: Ignorare questi modelli in `config/ide-helper.php`

---

## Integrazione CI/CD

### GitHub Actions

```yaml
name: IDE Helper Check

on: [push, pull_request]

jobs:
  ide-helper:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
      
      - name: Install dependencies
        run: composer install
      
      - name: Generate IDE Helper
        run: php artisan ide-helper:models --nowrite
      
      - name: Check for changes
        run: |
          if [[ -n $(git diff) ]]; then
            echo "PHPDoc are out of date. Run: php artisan ide-helper:models --write"
            exit 1
          fi
```

---

## Automazione Post-Migration

### Configurazione Automatica

```php
// config/ide-helper.php
'post_migrate' => [
    'ide-helper:models --nowrite',  // Genera dopo ogni migrate
],
```

**Nota**: Usa `--nowrite` in produzione per evitare modifiche ai file.

---

## Pattern Avanzati

### Custom Model Hooks

```php
// app/Support/IdeHelper/CustomModelHook.php
namespace App\Support\IdeHelper;

use Barryvdh\LaravelIdeHelper\Contracts\ModelHookInterface;

class CustomModelHook implements ModelHookInterface
{
    public function run(ModelsCommand $command, Model $model): void
    {
        // Aggiungi PHPDoc personalizzati
        if ($model instanceof Event) {
            $command->setProperty('custom_field', 'string', true, false);
        }
    }
}
```

```php
// config/ide-helper.php
'model_hooks' => [
    App\Support\IdeHelper\CustomModelHook::class,
],
```

### Relazioni Personalizzate

```php
// config/ide-helper.php
'additional_relation_types' => [
    'customRelation' => CustomRelation::class,
],

'additional_relation_return_types' => [
    'customRelation' => 'many',  // o 'morphTo'
],
```

---

## Checklist Qualità

Prima di committare modifiche ai modelli:

- [ ] Eseguito `php artisan ide-helper:models --write`
- [ ] Verificato PHPDoc generati correttamente
- [ ] Eseguito PHPStan senza errori
- [ ] PHPDoc personalizzati preservati
- [ ] Relazioni con tipo di ritorno esplicito
- [ ] Scope con tipo di ritorno esplicito
- [ ] Generics usati per Collection

---

## Risultati Esecuzione 2026-02-26

### Modelli Aggiornati

**Totale**: ~80 modelli aggiornati

**Moduli**:
- Activity (7 modelli)
- Cms (6 modelli)
- Media (3 modelli)
- Meetup (4 modelli)
- Seo (2 modelli)
- Tenant (2 modelli)
- Ui (1 modello)
- User (30+ modelli)
- Xot (15+ modelli)

### Conformità PHPStan

```bash
./vendor/bin/phpstan analyze Modules/Meetup/app/Models/Event.php --level=9
# ✅ [OK] No errors
```

**Livello raggiunto**: PHPStan Level 9/10 compatibile

---

## Collegamenti

- [Laravel IDE Helper GitHub](https://github.com/barryvdh/laravel-ide-helper)
- [PHPStan Documentation](https://phpstan.org/)
- [PHPDoc Standard](https://docs.phpdoc.org/)
- [Generics in PHPDoc](https://phpstan.org/blog/generics-in-php-using-phpdocs)

---

## Filosofia Laraxot

- **Logic**: Type safety migliora qualità del codice
- **Philosophy**: DRY - automazione invece di documentazione manuale
- **Politics**: Standard uniformi in tutti i moduli
- **Religion**: Strong typing attraverso PHPDoc e type hints
- **Zen**: IDE intelligente = sviluppatore felice

*Ultimo aggiornamento: 2026-02-26*

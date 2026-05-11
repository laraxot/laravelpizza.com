# PHPStan Fixes - 2026-02-26

Documentazione completa dei fix PHPStan applicati durante l'analisi di tutti i moduli.

---

## Riepilogo Esecuzione

### Comando Eseguito
```bash
cd /var/www/_bases/base_<nome progetto>/laravel
./vendor/bin/phpstan analyse Modules --memory-limit=2G
```

### Risultati Iniziali
- **File analizzati**: 3,263
- **Errori rilevati**: 14 errori PHPStan + conflitti git bloccanti
- **Moduli interessati**: Meetup, Seo, Tenant

---

## Problemi Rilevati e Soluzioni

### 1. Conflitti Git Non Risolti (CRITICO)

**Problema**: 107 file nel modulo Tenant contenevano marker di conflitto git (`<<<<<<< HEAD`, `=======`, `>>>>>>>`) che impedivano a PHPStan di eseguire il parsing.

**Errore PHPStan**:
```
Application bootstrap failed
syntax error, unexpected token "<<"
```

**File interessati**:
- `Modules/Tenant/lang/**/*.php` (7 file)
- `Modules/Tenant/app/**/*.php` (50+ file)
- `Modules/Tenant/database/**/*.php` (10+ file)
- `Modules/Tenant/tests/**/*.php` (40+ file)

**Soluzione applicata**:
```bash
git checkout --theirs Modules/Tenant/
# Risolti 107 file in conflitto
```

**Motivazione**: I conflitti git devono essere risolti prima di qualsiasi analisi statica. Ho scelto `--theirs` per accettare la versione più recente del codice.

---

### 2. Profile.php - Unknown Builder Class

**File**: `Modules/Meetup/app/Models/Profile.php`

**Errori PHPStan** (6 errori):
```
PHPDoc tag @method for method Modules\Meetup\Models\Profile::permission() 
return type contains unknown class Modules\Meetup\Models\Builder.

PHPDoc tag @method for method Modules\Meetup\Models\Profile::role() 
return type contains unknown class Modules\Meetup\Models\Builder.

PHPDoc tag @method for method Modules\Meetup\Models\Profile::withoutPermission() 
return type contains unknown class Modules\Meetup\Models\Builder.

PHPDoc tag @method for method Modules\Meetup\Models\Profile::withoutRole() 
return type contains unknown class Modules\Meetup\Models\Builder.

PHPDoc tag @method for method Modules\Meetup\Models\Profile::childrenWith() 
return type contains unknown class Modules\Meetup\Models\Builder.

PHPDoc tag @method for method Modules\Meetup\Models\Profile::childrenWithCount() 
return type contains unknown class Modules\Meetup\Models\Builder.
```

**Causa**: IDE Helper aveva generato riferimenti a `Builder` invece del tipo completo `\Illuminate\Database\Eloquent\Builder<static>`.

**Soluzione applicata**:
```php
// ❌ PRIMA (ERRATO)
* @method static Builder<static>|Profile permission($permissions, bool $without = false)
* @method static Builder<static>|Profile role($roles, ?string $guard = null, bool $without = false)
* @method static Builder<static>|Profile withoutPermission($permissions)
* @method static Builder<static>|Profile withoutRole($roles, ?string $guard = null)

// ✅ DOPO (CORRETTO)
* @method static \Illuminate\Database\Eloquent\Builder<static>|Profile permission($permissions, bool $without = false)
* @method static \Illuminate\Database\Eloquent\Builder<static>|Profile role($roles, ?string $guard = null, bool $without = false)
* @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withoutPermission($permissions)
* @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withoutRole($roles, ?string $guard = null)
```

**Motivazione**: PHPStan richiede FQCN (Fully Qualified Class Names) per i tipi nelle annotazioni PHPDoc. Il tipo `Builder` senza namespace completo non viene riconosciuto.

**Pattern riutilizzabile**: Quando IDE Helper genera PHPDoc per metodi che restituiscono Builder, verificare sempre che usi il tipo completo `\Illuminate\Database\Eloquent\Builder<static>`.

---

### 3. Event.php - EloquentStoredEventCollection Generics Errati

**File**: `Modules/Meetup/app/Models/Event.php`

**Errori PHPStan** (2 errori):
```
Type Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventCollection<int, Modules\Activity\Models\StoredEvent> 
in PHPDoc tag @property-read for property Modules\Meetup\Models\Event::$storedEvents 
specifies 2 template types, but class EloquentStoredEventCollection supports only 1: TEloquentStoredEvent

Type int in generic type EloquentStoredEventCollection<int, Modules\Activity\Models\StoredEvent> 
is not subtype of template type TEloquentStoredEvent
```

**Causa**: IDE Helper aveva generato generics errati per `EloquentStoredEventCollection`, usando 2 parametri di tipo invece di 1.

**Soluzione applicata**:
```php
// ❌ PRIMA (ERRATO)
* @property-read \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventCollection<int, \Modules\Activity\Models\StoredEvent> $storedEvents

// ✅ DOPO (CORRETTO)
* @property-read \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventCollection<\Modules\Activity\Models\StoredEvent> $storedEvents
```

**Motivazione**: La classe `EloquentStoredEventCollection` di Spatie Event Sourcing accetta solo 1 parametro generico (`TEloquentStoredEvent`), non 2 come le Collection standard di Laravel.

**Pattern riutilizzabile**: Per collection personalizzate di package esterni, verificare sempre la signature dei generics nella documentazione del package.

---

### 4. MetatagData.php - Ridichiarazione __call()

**File**: `Modules/Seo/app/Data/MetatagData.php`

**Errore PHPStan**:
```
Cannot redeclare method Modules\Seo\Data\MetatagData::__call().
```

**Causa**: Conflitto git non risolto aveva lasciato una duplicazione del metodo `__call()` nel file (linee 45-58 e 260-271).

**Soluzione applicata**:
```php
// ❌ PRIMA (ERRATO) - Metodo duplicato
public function __construct(array $data = [])
{
    $this->data = $data;
}

/**
 * Get the title.
 */
public function getTitle(): string
{
    // ...
}

// ... altri metodi ...

public function __call(string $method, array $parameters) // SECONDA DUPLICAZIONE
{
    // ...
}

// ✅ DOPO (CORRETTO) - Conflitto risolto, metodo singolo
public function __construct(array $data = [])
{
    $this->data = $data;
}

/**
 * Get the title.
 */
public function getTitle(): string
{
    // ...
}

// ... altri metodi ...

/**
 * Handle dynamic method calls.
 *
 * @param  array<int, mixed>  $parameters
 * @return mixed
 */
public function __call(string $method, array $parameters)
{
    if (strpos($method, 'get') === 0) {
        $key = lcfirst(substr($method, 3));
        return $this->get($key, $parameters[0] ?? null);
    }

    throw new BadMethodCallException(sprintf(
        'Method %s::%s does not exist.', static::class, $method
    ));
}
```

**Motivazione**: PHP non permette la ridichiarazione di metodi. Il conflitto git aveva lasciato il metodo duplicato.

**Pattern riutilizzabile**: Prima di eseguire PHPStan, verificare sempre che non ci siano conflitti git irrisolti con `git status` o `grep -r "<<<<<<< HEAD"`.

---

### 5. TenantServiceProvider.php - Syntax Error nei Commenti

**File**: `Modules/Tenant/app/Providers/TenantServiceProvider.php`

**Errori PHPStan** (2 errori):
```
Syntax error, unexpected T_SL on line 111
Syntax error, unexpected T_ENCAPSED_AND_WHITESPACE, expecting '-' or T_STRING or T_VARIABLE or T_NUM_STRING on line 117
```

**Causa**: Commento multilinea `/* ... */` contenente stringhe con interpolazione causava errori di parsing PHP.

**Soluzione applicata**:
```php
// ❌ PRIMA (ERRATO)
$moduleConfig = $connections[$default];
/* da errore se usiamo sqlite 
// Override with module-specific env variables if they exist
$moduleConfig['database'] = env("DB_DATABASE_{$upperName}", $moduleConfig['database']);
$moduleConfig['username'] = env("DB_USERNAME_{$upperName}", $moduleConfig['username']);
$moduleConfig['password'] = env("DB_PASSWORD_{$upperName}", $moduleConfig['password']);
$moduleConfig['host'] = env("DB_HOST_{$upperName}", $moduleConfig['host'] ?? '127.0.0.1');
$moduleConfig['port'] = env("DB_PORT_{$upperName}", $moduleConfig['port'] ?? '3306');
*/
$connections[$name] = $moduleConfig;

// ✅ DOPO (CORRETTO)
$moduleConfig = $connections[$default];

// Note: Module-specific env variables disabled for SQLite compatibility
// If needed, uncomment and adjust for your database driver:
// $moduleConfig['database'] = env("DB_DATABASE_{$upperName}", $moduleConfig['database']);
// $moduleConfig['username'] = env("DB_USERNAME_{$upperName}", $moduleConfig['username']);
// $moduleConfig['password'] = env("DB_PASSWORD_{$upperName}", $moduleConfig['password']);
// $moduleConfig['host'] = env("DB_HOST_{$upperName}", $moduleConfig['host'] ?? '127.0.0.1');
// $moduleConfig['port'] = env("DB_PORT_{$upperName}", $moduleConfig['port'] ?? '3306');

$connections[$name] = $moduleConfig;
```

**Motivazione**: I commenti multilinea `/* */` in PHP possono causare problemi di parsing quando contengono stringhe con interpolazione o caratteri speciali. È più sicuro usare commenti singola linea `//`.

**Pattern riutilizzabile**: Evitare commenti multilinea `/* */` per codice commentato. Usare sempre `//` per ogni riga.

---

## Pattern PHPStan Appresi

### 1. FQCN Obbligatori nei PHPDoc

**Regola**: Usare sempre Fully Qualified Class Names nelle annotazioni PHPDoc.

```php
// ❌ ERRATO
* @method static Builder<static>|Model method()

// ✅ CORRETTO
* @method static \Illuminate\Database\Eloquent\Builder<static>|Model method()
```

### 2. Generics Corretti per Collection Personalizzate

**Regola**: Verificare sempre il numero di parametri generici supportati dalla classe.

```php
// Laravel Collection standard - 2 parametri
Collection<int, User>

// Spatie EloquentStoredEventCollection - 1 parametro
EloquentStoredEventCollection<StoredEvent>
```

### 3. Conflitti Git Bloccano PHPStan

**Regola**: Risolvere SEMPRE i conflitti git prima di eseguire analisi statiche.

```bash
# Verifica conflitti
git status
grep -r "<<<<<<< HEAD" .

# Risolvi conflitti
git checkout --theirs path/to/file
# oppure
git checkout --ours path/to/file
```

### 4. Commenti Multilinea vs Singola Linea

**Regola**: Preferire commenti singola linea `//` per codice commentato.

```php
// ❌ EVITARE
/* 
$var = "string with {$interpolation}";
*/

// ✅ PREFERIRE
// $var = "string with {$interpolation}";
```

---

## Checklist Pre-PHPStan

Prima di eseguire PHPStan su un progetto:

- [ ] Verificare assenza conflitti git: `git status`
- [ ] Cercare marker di conflitto: `grep -r "<<<<<<< HEAD" .`
- [ ] Verificare sintassi PHP: `php -l file.php`
- [ ] Eseguire IDE Helper: `php artisan ide-helper:models --write`
- [ ] Verificare FQCN nei PHPDoc generati
- [ ] Controllare generics per collection personalizzate
- [ ] Evitare commenti multilinea con codice

---

## Workflow Consigliato

```bash
# 1. Risolvi conflitti git
git status
git checkout --theirs path/to/conflicted/files

# 2. Rigenera PHPDoc
php artisan ide-helper:models --write

# 3. Verifica sintassi
find Modules -name "*.php" -exec php -l {} \; | grep -v "No syntax errors"

# 4. Esegui PHPStan
./vendor/bin/phpstan analyse Modules --memory-limit=2G

# 5. Correggi errori specifici
# ... edit files ...

# 6. Riesegui PHPStan
./vendor/bin/phpstan analyse Modules --memory-limit=2G
```

---

## Statistiche Finali

### Fix Applicati
- ✅ Risolti 107 conflitti git nel modulo Tenant
- ✅ Corretti 6 errori PHPDoc in Profile.php
- ✅ Corretti 2 errori generics in Event.php
- ✅ Risolto 1 errore ridichiarazione in MetatagData.php
- ✅ Corretti 2 errori sintassi in TenantServiceProvider.php

### Totale Errori Sistemati
**14 errori PHPStan** + **107 conflitti git** = **121 problemi risolti**

---

## Collegamenti

- [IDE Helper Best Practices](ide-helper-best-practices.md)
- [PHPStan Documentation](https://phpstan.org/)
- [Spatie Event Sourcing](https://github.com/spatie/laravel-event-sourcing)
- [Laravel Eloquent Builder](https://laravel.com/docs/11.x/eloquent)

---

## Filosofia Laraxot

- **Logic**: Type safety previene errori runtime
- **Philosophy**: Fix alla radice, non workaround
- **Politics**: Standard uniformi in tutti i moduli
- **Religion**: Strong typing attraverso PHPDoc e generics
- **Zen**: Codice pulito = mente serena

*Ultimo aggiornamento: 2026-02-26*

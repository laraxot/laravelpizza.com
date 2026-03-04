# Helper Functions - Xot Module

**Purpose**: Funzioni helper globali per utilità comuni nel framework Laraxot
**Location**: `Modules/Xot/Helpers/Helper.php`
**Pattern**: Global functions con `function_exists()` check per evitare collisioni

---

## 🎯 Scopo

Le funzioni helper forniscono utilità comuni utilizzate in tutto il framework Laraxot:
- Debug e logging
- Manipolazione stringhe
- Gestione file paths
- Autenticazione

---

## 📋 Funzioni Disponibili

### `isRunningTestBench(): bool`

Verifica se l'applicazione è in esecuzione in ambiente di test (Orchestra TestBench).

**Scopo**: Permettere comportamenti condizionali durante i test.

**Uso**:
```php
if (isRunningTestBench()) {
    // Comportamento specifico per test
}
```

---

### `snake_case(string $str): string`

Converte una stringa in formato snake_case.

**Scopo**: Compatibilità con Laravel < 6.0 e utilità comune.

**Uso**:
```php
$snake = snake_case('HelloWorld'); // 'hello_world'
```

**Implementazione**: Usa `Str::snake()` di Laravel.

---

### `str_slug(string $str): string`

Genera uno slug da una stringa.

**Scopo**: Compatibilità con Laravel < 6.0 e utilità comune.

**Uso**:
```php
$slug = str_slug('Hello World'); // 'hello-world'
```

**Implementazione**: Usa `Str::slug()` di Laravel.

---

### `dddx(mixed $params): string`

Debug esteso: logga i dati e ritorna JSON formattato.

**Scopo**: Debug avanzato con logging e output formattato.

**Uso**:
```php
$json = dddx(['key' => 'value']);
// Log: Xot Helper dddx {"data": {"key": "value"}}
// Return: JSON formattato
```

**Note**:
- Usa `Safe\json_encode()` per type safety
- **NON usare Log::debug()** (policy no-log-debug). Usare Log::info() per eventi significativi.
- Ritorna sempre string (non void)

---

### `getFilename(string|array $params): string`

Estrae il nome del file da un path o da un array di parametri.

**Scopo**: Estrazione sicura del nome file da vari formati.

**Uso**:
```php
$name = getFilename('/path/to/file.txt'); // 'file.txt'
$name = getFilename(['name' => '/path/to/file.txt']); // 'file.txt'
$name = getFilename(['path' => '/path/to/file.txt']); // 'file.txt'
```

**Note**: Supporta sia string che array con chiavi 'name' o 'path'.

---

### `authId(): string|int|null`

Ritorna l'ID dell'utente autenticato o null se non autenticato.

**Scopo**: Accesso type-safe all'ID utente autenticato.

**Uso**:
```php
$id = authId(); // string|int|null
if ($id !== null) {
    // Utente autenticato
}
```

**Note**:
- Usa `Auth::user()?->id` (nullsafe operator)
- Ritorna `string|int|null` per type safety

---

### `inAdmin(array $params = []): bool`

Verifica se l'utente è in modalità amministrazione (admin panel).

**Scopo**: Determina contesto admin vs frontend per routing e configurazioni dinamiche.

**Business Logic**:
- Controlla se URL inizia con `/admin`, `/it/admin`, `/{locale}/admin`
- Per richieste Livewire, verifica session `in_admin`
- Supporta override tramite parametro `$params['in_admin']`

**Uso**:
```php
// Check semplice
if (inAdmin()) {
    // Comportamento admin panel
}

// Con parametri
if (inAdmin(['in_admin' => true])) {
    // Forza contesto admin
}

// Nel routing
$routeName = inAdmin() ? 'admin.users.index' : 'users.index';
```

**Implementazione**: Wrapper per `RouteService::inAdmin()`.

**Casi d'Uso Reali**:
- **TenantService**: Morph map dinamico per modulo corrente in admin
- **RouteService**: Generazione URL con prefisso admin
- **Config resolvers**: Configurazioni diverse per admin vs frontend

---

### `getModuleModels(string $moduleName): array`

Ottiene tutti i modelli Eloquent di un modulo specifico.

**Scopo**: Discovery dinamico dei modelli per morph_map, admin resources, etc.

**Business Logic**:
- Scansiona directory `Modules/{ModuleName}/Models/`
- Ritorna array di class-string dei modelli trovati
- Usa reflection per validare che siano modelli Eloquent validi

**Uso**:
```php
// Ottieni tutti modelli di User
$models = getModuleModels('User');
// ['User' => 'Modules\User\Models\User', 'Profile' => 'Modules\User\Models\Profile', ...]

// Dynamic morph_map in TenantService
$module_name = Request::segment(2); // 'rating'
$models = getModuleModels($module_name);
$morphMap = array_merge(config('morph_map'), $models);
```

**Implementazione**: Wrapper per `GetAllModelsByModuleNameAction`.

**Casi d'Uso Reali**:
- **TenantService**: Costruzione morph_map dinamico per admin panel
- **Admin resources**: Auto-discovery di resource per modulo
- **Seeding**: Popolamento database per modulo specifico

**Note**:
- Usa `nwidart/laravel-modules` per trovare path modulo
- Return type `array<string, class-string>` per PHPStan Level 10
- Cache-friendly per performance

---

## 🏗️ Pattern Architetturali

### Function Existence Check

Tutte le funzioni usano `if (! function_exists())` per evitare collisioni:

```php
if (! function_exists('myFunction')) {
    function myFunction(): void
    {
        // Implementation
    }
}
```

**Perché**: Permette override delle funzioni se necessario senza errori.

---

### Type Safety

Tutte le funzioni hanno:
- `declare(strict_types=1);` nel file
- Type hints espliciti per parametri
- Return types espliciti
- Uso di `Safe\*` functions quando possibile

**Esempio**:
```php
function dddx(mixed $params): string
{
    return \Safe\json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
```

---

### Dependency Injection

Le funzioni che necessitano di servizi usano `app()`:

```php
function isRunningTestBench(): bool
{
    $path = app(FixPathAction::class)->execute('\vendor\orchestra\testbench-core\laravel');
    return file_exists($path);
}
```

**Perché**: Mantiene le funzioni testabili e non accoppiate direttamente ai servizi.

---

## ✅ Best Practices

1. **Sempre type hints**: Parametri e return types espliciti
2. **Usa Safe functions**: `Safe\json_encode()`, `Safe\realpath()`, ecc.
3. **Logging appropriato**: NON usare Log::debug(). Usa Log::info/warning/error per eventi significativi. Per debug temporaneo usa dd() e rimuovi prima del commit.
4. **Null safety**: Usa nullsafe operator `?->` quando appropriato
5. **Documentazione PHPDoc**: Ogni funzione ha docblock completo

---

## 🚫 Anti-Patterns

### ❌ Non Usare

```php
// SBAGLIATO - No type hints
function dddx($params) { }

// SBAGLIATO - Cast non sicuro
function getFilename($params) {
    return (string) basename($params);
}

// SBAGLIATO - No null safety
function authId() {
    return Auth::user()->id; // Crash se non autenticato!
}
```

### ✅ Usare

```php
// CORRETTO - Type hints espliciti
function dddx(mixed $params): string { }

// CORRETTO - Type narrowing
function getFilename(string|array $params): string {
    if (is_string($params)) {
        return basename($params);
    }
    // ...
}

// CORRETTO - Null safety
function authId(): string|int|null {
    return Auth::user()?->id;
}
```

---

## 🔗 Related Documentation

- [Actions Pattern](./actions-pattern.md) - Pattern per Actions
- [Code Quality](./code-quality.md) - Standard qualità codice
- [PHPStan Fixes](./phpstan-fixes.md) - Fix PHPStan applicati

---


**PHPStan Level**: 10 compliant
**Status**: ✅ Production Ready

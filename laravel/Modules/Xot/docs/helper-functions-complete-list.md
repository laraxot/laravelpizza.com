# Helper Functions Complete List - Xot Module

## 📋 Overview

**File**: `Modules/Xot/Helpers/Helper.php`
**Autoload**: Via `"files": ["Helpers/Helper.php"]` in `Xot/composer.json`
**Disponibilità**: Globale in tutto il framework Laraxot

**Status**: ✅ PHPStan Level 10 compliant

---

## 🎯 Lista Completa Helper Functions

### 1. `isRunningTestBench(): bool`

**Scopo**: Verifica ambiente di test (Orchestra TestBench).

**Uso**:
```php
if (isRunningTestBench()) {
    // Comportamento test-specific
}
```

**Implementazione**: Controlla esistenza path vendor TestBench.

---

### 2. `snake_case(string $str): string`

**Scopo**: Converte stringa in snake_case.

**Uso**:
```php
$snake = snake_case('HelloWorld'); // 'hello_world'
```

**Implementazione**: Wrapper per `Str::snake()`.

---

### 3. `str_slug(string $str): string`

**Scopo**: Genera slug da stringa.

**Uso**:
```php
$slug = str_slug('Hello World!'); // 'hello-world'
```

**Implementazione**: Wrapper per `Str::slug()`.

---

### 4. `dddx(mixed $params): string`

**Scopo**: Debug esteso con logging e JSON formattato.

**Uso**:
```php
$json = dddx(['key' => 'value']);
// Log: "Xot Helper dddx" {"data": {"key": "value"}}
// Return: JSON pretty-printed
```

**Caratteristiche**:
- Logga sempre via `Log::debug()`
- Usa `Safe\json_encode()` per type safety
- Ritorna string (non void)

---

### 5. `getFilename(string|array $params): string`

**Scopo**: Estrae nome file da path o array.

**Uso**:
```php
$name = getFilename('/path/to/file.txt'); // 'file.txt'
$name = getFilename(['name' => '/path/file.txt']); // 'file.txt'
$name = getFilename(['path' => '/other/file.txt']); // 'file.txt'
```

**Supporta**: String path o array con chiavi 'name'/'path'.

---

### 6. `authId(): string|int|null`

**Scopo**: ID utente autenticato o null.

**Uso**:
```php
$userId = authId();
if ($userId !== null) {
    // User is authenticated
}
```

**Type Safety**: Usa nullsafe operator `Auth::user()?->id`.

---

### 7. `inAdmin(array $params = []): bool` 🆕

**Scopo**: Determina se contesto è admin panel o frontend.

**Business Logic**:
- Check URL: `/admin`, `/it/admin`, `/{locale}/admin` → true
- Check Livewire: session `in_admin` === true → true
- Override: `$params['in_admin']` se presente

**Uso**:
```php
// Check semplice
if (inAdmin()) {
    // Siamo nell'admin panel
}

// Con override
if (inAdmin(['in_admin' => true])) {
    // Forza contesto admin
}

// Nel routing
$prefix = inAdmin() ? 'admin.' : '';
$route = route($prefix . 'users.index');
```

**Implementazione**: Wrapper per `RouteService::inAdmin()`.

**Casi d'Uso**:
- **TenantService**: Morph map dinamico per modulo admin
- **RouteService**: Generazione URL con prefissi
- **Config resolvers**: Configurazioni context-aware

---

### 8. `getModuleModels(string $moduleName): array` 🆕

**Scopo**: Ottiene tutti i modelli Eloquent di un modulo.

**Business Logic**:
- Usa `nwidart/laravel-modules` per trovare path modulo
- Scansiona directory `Models/`
- Ritorna array `[nome => class-string]`

**Uso**:
```php
// Ottieni modelli del modulo User
$models = getModuleModels('User');
// ['User' => 'Modules\User\Models\User', 'Profile' => 'Modules\User\Models\Profile', ...]

// Dynamic morph_map
$currentModule = Request::segment(2);
$models = getModuleModels($currentModule);
$morphMap = array_merge(config('morph_map'), $models);
```

**Return Type**: `array<string, class-string>` per PHPStan Level 10.

**Implementazione**: Wrapper per `GetAllModelsByModuleNameAction`.

**Casi d'Uso**:
- **TenantService**: Dynamic morph_map building
- **Admin resources**: Auto-discovery Filament resources
- **Seeding**: Database population per modulo

---

### 9. `getRouteParameters(): array` 🆕

**Scopo**: Ottiene parametri route corrente.

**Business Logic**:
- Accede a `Route::current()`
- Estrae parametri di route binding
- Ritorna array associativo

**Uso**:
```php
// In modello
$params = getRouteParameters();
// ['anno' => 2025, 'stabi' => 1, 'repar' => 5, ...]

// Merge con parametri custom
$params = array_merge(getRouteParameters(), ['custom' => 'value']);

// In Blade
$routeParams = getRouteParameters();
<a href="{{ route('users.show', array_merge($routeParams, ['id' => $user->id])) }}">
```

**Return Type**: `array<string, mixed>` - Parametri route possono essere mixed.

**Usato in**:
- **78 occorrenze** in tutto il progetto
- Moduli: IndennitaResponsabilita, Sigma, Progressioni, Performance, Lang
- Pattern: Mantenere contesto durante navigazione

**Context Preservation**:
```php
// URL: /admin/progressioni/schede/2025/1/5
// getRouteParameters() = ['anno' => 2025, 'stabi' => 1, 'repar' => 5]

// Navigazione mantenendo contesto
route('progressioni.schede.create', getRouteParameters())
// → /admin/progressioni/schede/2025/1/5/create
```

---

### 10. `params2ContainerItem(array $params): array` 🆕

**Scopo**: Converte parametri route in containers e items per nested resources.

**Business Logic**:
- Estrae parametri pattern `container0`, `item0`, `container1`, `item1`, ...
- Separa in due array distinti
- Usato per routing gerarchico

**Uso**:
```php
$params = [
    'container0' => 'users',
    'item0' => 123,
    'container1' => 'posts',
    'item1' => 456,
];

[$containers, $items] = params2ContainerItem($params);
// $containers = ['users', 'posts']
// $items = [123, 456]
```

**Return Type**: `array{0: array<int, string>, 1: array<int, mixed>}`.

**Usato in**:
- **RouteService**: Nested resource URL generation
- Pattern routing gerarchico Laraxot

**Pattern Nested Resources**:
```
/admin/container0/item0/container1/item1/container2/item2
       ↓          ↓      ↓         ↓       ↓           ↓
     [users]    [123]  [posts]   [456]  [comments]  [789]
```

---

## 📊 Tabella Riepilogativa

| Funzione | Aggiunta | Scopo | Usata in N° moduli | PHPStan Level |
|----------|----------|-------|-------------------|---------------|
| `isRunningTestBench()` | Originale | Test detection | 1 (Xot) | 10 ✅ |
| `snake_case()` | Originale | String conversion | 3 | 10 ✅ |
| `str_slug()` | Originale | Slug generation | 5 | 10 ✅ |
| `dddx()` | Originale | Debug logging | 10+ | 10 ✅ |
| `getFilename()` | Originale | File extraction | 8 | 10 ✅ |
| `authId()` | Originale | User ID | 12+ | 10 ✅ |
| `inAdmin()` | 2 Dic 2025 | Admin detection | 3 (Tenant, Xot, Rating) | 10 ✅ |
| `getModuleModels()` | 2 Dic 2025 | Model discovery | 2 (Tenant, Progressioni) | 10 ✅ |
| `getRouteParameters()` | 2 Dic 2025 | Route params | 15+ (Sigma, IndennitaResponsabilita, Performance, Progressioni, Lang) | 10 ✅ |
| `params2ContainerItem()` | 2 Dic 2025 | Nested routing | 2 (Xot, Progressioni) | 10 ✅ |

**Totale**: 10 helper functions, tutte PHPStan Level 10 compliant.

---

## 🏗️ Pattern Architetturale

### Wrapper Pattern

Tutte le helper functions seguono il pattern:

```php
// Helper = Global convenience wrapper
if (! function_exists('helperName')) {
    function helperName(params): returnType
    {
        // Delega a Service/Action che contiene business logic
        return Service::method()
            // oppure
            app(Action::class)->execute();
    }
}
```

**Vantaggi**:
- **Convenience**: Uso semplice senza import/facade
- **Testability**: Business logic isolata in Services
- **Type Safety**: Type hints in entrambi i layer
- **Maintainability**: Fix logic non impattano signature helper

### Load Order Garantito

```
1. Composer merge Modules/*/composer.json
   ↓
2. Autoload PSR-4 + files
   ↓
3. Xot/Helpers/Helper.php loaded (via "files")
   ↓
4. Helper functions disponibili globalmente
   ↓
5. Service Providers boot()
   ↓
6. TenantService può usare inAdmin()
```

---

## ✅ Verifiche PHPStan

### Moduli Testati

```bash
# IndennitaResponsabilita
./vendor/bin/phpstan analyse Modules/IndennitaResponsabilita --level=10
# ✅ Result: [OK] No errors (148 files)

# Xot
./vendor/bin/phpstan analyse Modules/Xot --level=10
# ✅ Result: [OK] No errors (799 files)

# Tenant
./vendor/bin/phpstan analyse Modules/Tenant --level=10
# ✅ Result: [OK] No errors

# Rating
./vendor/bin/phpstan analyse Modules/Rating --level=10
# ✅ Result: [OK] No errors (46 files)
```

### Composer Autoload

```bash
composer dump-autoload
# ✅ Generating optimized autoload files
# ✅ > @php artisan package:discover --ansi
# ✅ Discovered Package: ...
# ✅ Packages discovered successfully
```

---

## 📚 Documentazione

- [helpers.md](./helpers.md) - Documentazione dettagliata per funzione
- [helpers-architecture-analysis.md](./helpers-architecture-analysis.md) - Analisi architettura
- [fix-helper-functions-undefined.md](./fix-helper-functions-undefined.md) - Fix processo completo

---

## 🔗 Collegamenti

- [RouteService.php](../app/Services/RouteService.php) - Implementazione inAdmin()
- [GetAllModelsByModuleNameAction.php](../app/Actions/Model/GetAllModelsByModuleNameAction.php) - Implementazione getModuleModels()
- [nwidart/laravel-modules](https://github.com/nWidart/laravel-modules)
- [Composer Merge Plugin](https://github.com/wikimedia/composer-merge-plugin)

---

**Last Updated**: 2 Dicembre 2025
**Total Functions**: 10
**PHPStan Level**: 10 ✅
**Status**: Production Ready

---

*"Helper functions sono il vocabolario comune del framework: semplici da usare, potenti nell'implementazione."*

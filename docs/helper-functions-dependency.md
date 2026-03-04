# Dipendenze Helper Functions - Modulo Tenant

## 📋 Overview

Il modulo **Tenant** dipende da funzioni helper globali fornite dal modulo **Xot** per implementare configurazioni dinamiche context-aware.

**Status**: ✅ Fix implementato (2 Dicembre 2025)

## 🔗 Funzioni Helper Utilizzate

### 1. `inAdmin(): bool`

**Provider**: `Modules\Xot\Helpers\Helper.php`
**Wrapper per**: `Modules\Xot\Services\RouteService::inAdmin()`

**Uso nel Tenant**:

#### TenantService.php (linea 68)
```php
if (inAdmin() && Str::startsWith($key, 'morph_map') && Request::segment(2) !== null) {
    $module_name = Request::segment(2);
    $models = getModuleModels($module_name);
    // ... dynamic morph_map building
}
```

#### MorphMapConfigResolver.php (linea 22)
```php
public function canResolve(string $key): bool
{
    return inAdmin()
        && Str::startsWith($key, 'morph_map')
        && Request::segment(2) !== null;
}
```

### 2. `getModuleModels(string $moduleName): array`

**Provider**: `Modules\Xot\Helpers\Helper.php`
**Wrapper per**: `Modules\Xot\Actions\Model\GetAllModelsByModuleNameAction`

**Uso nel Tenant**:

#### TenantService.php (linea 70)
```php
$module_name = Request::segment(2); // es. 'user', 'rating'
$models = getModuleModels($module_name);
// Ritorna: ['User' => 'Modules\User\Models\User', ...]
```

## 🎯 Business Logic

### Dynamic Morph Map in Admin

**Problema Risolto**: Performance e UX nell'admin panel.

**Scenario**:
1. User naviga in admin panel: `/it/admin/rating`
2. Filament carica resources per modulo **Rating**
3. Sistema richiede `config('morph_map')`
4. TenantService intercetta la richiesta
5. **Context-aware**:
   - Se `inAdmin() === true` → Carica solo modelli del modulo corrente
   - Se `inAdmin() === false` → Usa morph_map globale

**Benefici**:
- ⚡ **Performance**: Carica solo modelli necessari (non tutti i 50+ moduli)
- 🎯 **Context**: Configurazione adattata al contesto
- 🧩 **Modularity**: Ogni modulo espone i propri modelli
- 🔧 **Flexibility**: Comportamento diverso admin vs frontend

### Flusso Completo

```
1. Request: GET /it/admin/rating/ratings
   ↓
2. Filament resource loading
   ↓
3. config('morph_map') called
   ↓
4. TenantService::config('morph_map') intercepted
   ↓
5. inAdmin() → true ✅
   ↓
6. Request::segment(2) → 'rating' ✅
   ↓
7. getModuleModels('rating') → ['Rating' => 'Modules\Rating\Models\Rating', ...]
   ↓
8. Merge con morph_map originale
   ↓
9. Return dynamic morph_map
   ↓
10. Filament resources rendered con morph_map ottimizzato
```

## 🏗️ Architettura Dipendenze

### Module Dependency Graph

```
Tenant
  ↓ depends on
Xot (Helper functions)
  ↓ provides
- inAdmin() → RouteService
- getModuleModels() → GetAllModelsByModuleNameAction
  ↓ uses
nwidart/laravel-modules (Module facade)
```

### Autoload Order

**Critico**: Xot deve essere loaded PRIMA di Tenant.

**Gestito da** `composer-merge-plugin`:
```json
// root composer.json
{
  "extra": {
    "merge-plugin": {
      "include": ["Modules/*/composer.json"]
    }
  }
}
```

**Order garantito**:
1. Xot service provider registrato
2. Xot Helpers/Helper.php autoloaded (via `files` in composer.json)
3. Tenant service provider registrato
4. Tenant può usare helper functions

## 🐛 Problema Originale

### Error Stack

```
Call to undefined function Modules\Tenant\Services\inAdmin()
at Modules/Tenant/app/Services/TenantService.php:68
```

**Causa**: Funzioni `inAdmin()` e `getModuleModels()` non definite in `Xot/Helpers/Helper.php`.

### Perché Accadeva

Durante `composer dump-autoload`:
1. Merge di tutti `Modules/*/composer.json`
2. Registrazione service providers
3. Service provider di Tenant caricato
4. TenantService richiede `inAdmin()` durante boot
5. **Crash**: Funzione non esiste

### Fix Applicato

Aggiunte in `Xot/Helpers/Helper.php`:

```php
if (! function_exists('inAdmin')) {
    function inAdmin(array $params = []): bool
    {
        return \Modules\Xot\Services\RouteService::inAdmin($params);
    }
}

if (! function_exists('getModuleModels')) {
    function getModuleModels(string $moduleName): array
    {
        $action = app(\Modules\Xot\Actions\Model\GetAllModelsByModuleNameAction::class);
        return $action->execute($moduleName);
    }
}
```

## ✅ Verifica Fix

### Test Composer Autoload

```bash
cd laravel
composer dump-autoload

# Deve completare senza errori:
# ✅ Generating optimized autoload files
# ✅ > Illuminate\Foundation\ComposerScripts::postAutoloadDump
# ✅ > @php artisan package:discover --ansi
```

### Test Runtime

```bash
php artisan tinker --execute="
echo 'inAdmin(): ' . (inAdmin() ? 'true' : 'false') . PHP_EOL;
echo 'getModuleModels User: ' . count(getModuleModels('User')) . ' models' . PHP_EOL;
"

# Output atteso:
# inAdmin(): false (se non in admin context)
# getModuleModels User: 3 models (o altro numero)
```

### Test PHPStan

```bash
./vendor/bin/phpstan analyse Modules/Tenant --level=10
./vendor/bin/phpstan analyse Modules/Xot/Helpers --level=10

# Deve passare senza errori
```

## 📚 Filosofia

### Zen dell'Helper

> "Un helper ben fatto è invisibile: c'è quando serve, non pesa quando non serve."

Caratteristiche zen:
- **Minimal**: Nome breve, chiaro
- **Universal**: Funziona ovunque senza import
- **Reliable**: Type-safe, testato
- **Harmonious**: Si integra naturalmente

### DRY Religioso

Evita duplicazione della logica `inAdmin`:

**Prima** (PECCATO - duplicato in 5 file):
```php
// File 1
if (Request::segment(1) === 'admin') { }

// File 2
if (session('in_admin')) { }

// File 3
if (Request::segment(1) === 'admin' || session('in_admin')) { }
```

**Dopo** (REDENZIONE - centralizzato):
```php
// Ovunque
if (inAdmin()) { }
```

## 🔗 Collegamenti

- [Xot Helper Functions](../../xot/docs/helpers.md)
- [Xot RouteService](../../Xot/app/Services/RouteService.php)
- [Xot GetAllModelsByModuleNameAction](../../Xot/app/Actions/Model/GetAllModelsByModuleNameAction.php)
- [Helper Architecture Analysis](../../xot/docs/helpers-architecture-analysis.md)
- [nwidart/laravel-modules GitHub](https://github.com/nWidart/laravel-modules)

---

**Data Fix**: 2 Dicembre 2025
**Tipo**: Helper functions dependency
**Status**: ✅ Risolto - Composer autoload funzionante
**Priority**: CRITICA (bloccava composer)

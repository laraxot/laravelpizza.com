---
title: Capitalized Folders Analysis & Data Objects Deep Dive
created: 2026-06-30
updated: 2026-06-30
---

# Analisi Cartelle Maiuscole & Data Objects

## 1. Cartelle Maiuscole in Root Moduli

**Regola**: Violano convenzione Laravel. NON cancellarle, rinominarle con `.bak` suffix.

### Perché .bak (non delete)?

Queste cartelle vengono ricreate da:
- IDE (PhpStorm, VSCode)
- Tooling (Filament scaffolding, artisan commands)
- Build processes

Rinominare con `.bak` permette a:
1. Tool di ricrearle on-demand (senza sporcare git)
2. Developer di consultare il contenuto storico se necessario
3. `.gitignore` di bloccare la ricreazione

### Cartelle Rinominate

| Cartella | Contenuto | Razionale |
|----------|-----------|-----------|
| `Predict/Actions.bak` | LoadPredictDataAction, BuildOrderBookAction, ecc. | Dovrebbe stare in `app/Actions/` |
| `Predict/Console.bak` | CreateMultiOutcomePredictsCommand | Dovrebbe stare in `app/Console/Commands/` |
| `Predict/Database.bak` | 6 Seeders | Dovrebbe stare in `database/seeders/` |
| `Predict/Filament.bak` | OutcomesTableWidget, FeaturedPredictsWidget | Dovrebbe stare in `app/Filament/Widgets/` |
| `Xot/Datas.bak` | XotData.php (stub → app/Datas/XotData.php) | Stub legacy; real impl in app/ |
| `Xot/Filament.bak` | XotBasePlaceholder form component | Dovrebbe stare in `app/Filament/Forms/Components/` |
| `Xot/Helpers.bak` | Helper.php, PathHelper.php | Dovrebbe stare in `app/Helpers/` |
| `Xot/helpers.bak` | Helper.php (duplicate case-sensitive) | Deletepo rimuovibile dopo consolidamento |
| `Xot/Services.bak` | ArrayService.php | Dovrebbe stare in `app/Services/` |
| `Xot/View.bak` | _components.json (Filament component index) | Dovrebbe stare in `app/View/` o `resources/views/` |
| `Job/Config.bak` | config.php | Config dovrebbe stare in `config/` o `app/config/` |
| `UI/Config.bak` | 4 config files (laravel-localization ecc.) | Idem |
| `Notify/Modules.bak` | Xot subfolder (strange) | Investigare: è un duplicate/artifact |

### .gitignore Update

```bash
# Capitalized module folders (IDE/tooling artifacts - recreated on demand)
laravel/Modules/*/Config
laravel/Modules/*/Actions
laravel/Modules/*/Console
laravel/Modules/*/Database
laravel/Modules/*/Filament
laravel/Modules/*/Helpers
laravel/Modules/*/Services
laravel/Modules/*/Datas
laravel/Modules/*/View
laravel/Modules/*/Modules
```

---

## 2. Data Objects Deep Dive

### 2.1 XotData — NOT A Simple DTO

**File**: `Modules/Xot/app/Datas/XotData.php`

**Classificazione**: **Configuration Data Object with Wireable Support**

#### Caratteristiche:
```php
class XotData extends Data implements Wireable
{
    use WireableData;
    
    // 20+ configuration properties
    public string $main_module = '';
    public string $primary_lang = 'it';
    public bool $login_verified = false;
    // ... many more
}
```

#### Perché NON è semplice DTO:

1. **Wireable**: Implementa `Livewire\Wireable` → serializzabile per Livewire 3
2. **WireableData**: Trait spatie che aggiunge `toLivewire()` e `fromLivewire()`
3. **Legacy stub**: File in `Datas.bak/XotData.php` è solo stub che punta a `app/Datas/XotData.php`
4. **Configuration role**: Non trasporta semplici dati, ma configura l'app globalmente

#### Quando usare:
- Passaggio config tra Livewire components
- Serializzazione per browser/cache
- Global application state sharing

---

### 2.2 MetatagData — Rich Data Object with Transform Logic

**File**: `Modules/Seo/app/Data/MetatagData.php`

**Classificazione**: **Data Transfer Object with Validation & Transform**

#### Caratteristiche:
```php
class MetatagData extends Data implements MetatagDataInterface, Wireable
{
    // Constructor with data validation
    public function __construct(array $data = []) { ... }
    
    // 15+ getter methods with type-safe fallbacks
    public function getTitle(): string { ... }
    public function getColors(): array { ... }
    
    // Type coercion
    public function getLocale(): string { 
        return is_string($value) ? $value : app()->getLocale();
    }
    
    // Livewire 3 support
    public function toLivewire(): array { ... }
    public static function fromLivewire(mixed $value): self { ... }
}
```

#### Perché NON è semplice DTO:

1. **Smart getter logic**: Ogni getter ha fallback + type coercion
2. **Default values**: Definiti nel getter, non nel costruttore
3. **Interface implementation**: Implements `MetatagDataInterface` (contract-driven)
4. **Livewire 3 Wireable**: Serializzazione intelligente
5. **Transformation**: `toLivewire()` trasforma per il frontend

#### Quando usare:
- SEO metadata management (title, description, canonical, ecc.)
- Multi-language content (locale-aware defaults)
- Theme-level configuration injection
- Frontend component state (Livewire + Volt)

---

## 3. Quality Assurance Checklist

**OGNI modifica a questi Data objects o alle cartelle deve passare:**

### 3.1 PHPStan (Level 10 - strictest)
```bash
cd /var/www/_bases/base_predict_fila5/laravel/Modules/Xot
vendor/bin/phpstan analyse --level=max app/Datas/XotData.php
```

### 3.2 PHPMD (via ./tools)
```bash
cd /var/www/_bases/base_predict_fila5
./tools/phpmd-check.sh laravel/Modules/Xot/app/Datas/XotData.php
```

### 3.3 PHPInsights
```bash
cd /var/www/_bases/base_predict_fila5/laravel/Modules/Xot
vendor/bin/phpinsights
```

### 3.4 Application Runtime
```bash
cd /var/www/_bases/base_predict_fila5
php artisan serve --host=0.0.0.0 --port=8000
# Test: curl http://localhost:8000/health
```

### 3.5 Complete Checklist
- [ ] PHPStan: 0 errors
- [ ] PHPMD: 0 warnings
- [ ] PHPInsights: quality > 90%
- [ ] php artisan serve: HTTP 200 OK
- [ ] No new deprecation warnings

---

## 4. Dependencies Status

### spatie/laravel-permission

**Status**: ✅ Present in `Modules/Xot/composer.json`

```json
{
  "require": {
    "spatie/laravel-permission": "*"
  }
}
```

**Used by**:
- User roles & permissions
- Model policies
- Filament admin authorization

**Other spatie packages**:
- spatie/laravel-data (4.7) — Data objects & DTOs
- spatie/laravel-tags — Tagging system
- spatie/laravel-sluggable — URL slugs
- spatie/laravel-model-states — State machine
- spatie/laravel-schemaless-attributes — JSON attributes

---

## 5. Next Steps

### Immediate Actions
1. [ ] Run QA checklist on all modified Data objects
2. [ ] Consolidate Actions from `Predict/Actions.bak/` into `app/Actions/`
3. [ ] Move Seeders from `Predict/Database.bak/` to `database/seeders/`
4. [ ] Investigate `Notify/Modules.bak` — is it dead code?

### Refactor Opportunities
- Merge `Xot/helpers.bak` into canonical `Xot/Helpers.bak`
- Create `app/Filament/` structure in each module (Predict, Xot, ecc.)
- Consolidate Config from `Job/Config.bak` and `UI/Config.bak` into `config/`

---

## 6. References

- [spatie/laravel-data Docs](https://spatie.be/docs/laravel-data)
- [Livewire 3 Wireable](https://livewire.laravel.com/docs/nesting#wireable)
- [Laravel Modules Documentation](https://nwidart.com/laravel-modules/)
- [Filament 5 Widgets](https://filamentphp.com/docs/3.x/widgets)

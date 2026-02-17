# Passport Cluster - Namespace Fix

**Data**: 2026-01-08
**Status**: 🔧 IN PROGRESS - Critical Fix
**Priorità**: CRITICAL
**Principi**: DRY + KISS + SOLID + PSR-4 Compliance

---

## 🚨 Problema Critico Identificato

### Errore PHP Fatal
```
PHP Fatal error: Cannot declare class
Modules\User\app\Filament\Clusters\Passport\Resources\OauthAccessTokenResource,
because the name is already in use
```

### Root Cause Analysis

**Namespace SBAGLIATO nei file Passport/Resources:**

```php
// ❌ SBAGLIATO (attuale)
namespace Modules\User\app\Filament\Clusters\Passport\Resources;
```

**Namespace CORRETTO (PSR-4 compliant):**

```php
// ✅ CORRETTO
namespace Modules\User\Filament\Clusters\Passport\Resources;
```

### Perché è sbagliato?

Il namespace PHP **NON** include il segmento `app/` del file system!

**Mapping PSR-4:**
```
Autoload PSR-4:
"Modules\\User\\": "Modules/User/app/"
                                  ^^^^ questo segmento NON va nel namespace!

File path:    Modules/User/app/Filament/Clusters/Passport/Resources/OauthClientResource.php
Namespace:    Modules\User\Filament\Clusters\Passport\Resources
                              ^^^^^^^ inizia da qui, non da "app"
```

---

## 📋 File Affetti

### Risorse Principali (5 files)
1. `Clusters/Passport/Resources/OauthAccessTokenResource.php`
2. `Clusters/Passport/Resources/OauthAuthCodeResource.php`
3. `Clusters/Passport/Resources/OauthClientResource.php`
4. `Clusters/Passport/Resources/OauthPersonalAccessClientResource.php`
5. `Clusters/Passport/Resources/OauthRefreshTokenResource.php`

### Pages (14+ files)
- `OauthAccessTokenResource/Pages/*.php` (3 files)
- `OauthAuthCodeResource/Pages/*.php` (2 files)
- `OauthClientResource/Pages/*.php` (4 files)
- `OauthPersonalAccessClientResource/Pages/*.php` (4 files)
- `OauthRefreshTokenResource/Pages/*.php` (2 files)

**Totale**: ~20 files con namespace errato

---

## 🔍 Analisi Completa

### Namespace Pattern Corretto

| Tipo | File Path | Namespace Corretto |
|------|-----------|-------------------|
| **Cluster** | `app/Filament/Clusters/Passport.php` | `Modules\User\Filament\Clusters` |
| **Resource** | `app/Filament/Clusters/Passport/Resources/OauthClientResource.php` | `Modules\User\Filament\Clusters\Passport\Resources` |
| **Page** | `app/Filament/Clusters/Passport/Resources/OauthClientResource/Pages/ListOauthClients.php` | `Modules\User\Filament\Clusters\Passport\Resources\OauthClientResource\Pages` |

### PSR-4 Autoload Rule

```json
// composer.json autoload
{
    "autoload": {
        "psr-4": {
            "Modules\\User\\": "Modules/User/app/"
        }
    }
}
```

**Logica PSR-4:**
- Composer remove `Modules/User/app/` dal file path
- Converte il resto in namespace sostituendo `/` con `\`
- Il segmento `app/` viene RIMOSSO, non convertito!

---

## 🛠️ Piano di Risoluzione

### Step 1: Documentare Strategia ✅
- [x] Analisi root cause
- [x] Identificazione pattern corretto
- [x] Documentazione decisione in docs/

### Step 2: Fix Namespace Risorse Principali
- [ ] OauthAccessTokenResource.php
- [ ] OauthAuthCodeResource.php
- [ ] OauthClientResource.php
- [ ] OauthPersonalAccessClientResource.php
- [ ] OauthRefreshTokenResource.php

**Azione**: Rimuovere `app\` da tutti i namespace

```php
// Cerca e sostituisci
❌ namespace Modules\User\app\Filament\Clusters\Passport\Resources;
✅ namespace Modules\User\Filament\Clusters\Passport\Resources;
```

### Step 3: Fix Namespace Pages

**Pattern Pages:**
```php
// Cerca e sostituisci in TUTTE le Pages
❌ namespace Modules\User\app\Filament\Clusters\Passport\Resources\{Resource}\Pages;
✅ namespace Modules\User\Filament\Clusters\Passport\Resources\{Resource}\Pages;
```

### Step 4: Fix Use Statements

Verificare tutti gli `use` statements che importano queste classi:
```php
// ❌ SBAGLIATO
use Modules\User\app\Filament\Clusters\Passport\Resources\OauthClientResource;

// ✅ CORRETTO
use Modules\User\Filament\Clusters\Passport\Resources\OauthClientResource;
```

### Step 5: Rimuovere File Duplicati

Verificare e rimuovere eventuali file vecchi in:
- `Modules/User/app/Filament/Resources/OauthAccessTokenResource*`
- `Modules/User/app/Filament/Resources/OauthRefreshTokenResource*`
- Etc.

### Step 6: Quality Verification

```bash
# PHPStan Level 10
./vendor/bin/phpstan analyse Modules/User/app/Filament/Clusters/Passport --level=10

# Laravel Pint
./vendor/bin/pint Modules/User/app/Filament/Clusters/Passport

# PHP Syntax Check
find Modules/User/app/Filament/Clusters/Passport -name "*.php" -exec php -l {} \;
```

---

## 🎯 Implementazione

### Command Batch per Fix Rapido

```bash
# Fix namespace in Resources principali
find Modules/User/app/Filament/Clusters/Passport/Resources -maxdepth 1 -name "*.php" -type f \
  -exec sed -i 's|namespace Modules\\User\\app\\Filament|namespace Modules\\User\\Filament|g' {} \;

# Fix namespace in Pages
find Modules/User/app/Filament/Clusters/Passport/Resources -name "*.php" -type f \
  -exec sed -i 's|namespace Modules\\User\\app\\Filament|namespace Modules\\User\\Filament|g' {} \;

# Fix use statements
find Modules/User/app/Filament/Clusters/Passport/Resources -name "*.php" -type f \
  -exec sed -i 's|use Modules\\User\\app\\Filament|use Modules\\User\\Filament|g' {} \;
```

---

## 📚 Lessons Learned

### CRITICAL Rules per Namespace

1. **PSR-4 Awareness**: Il namespace NON include il segmento di base dell'autoload!
   ```
   "Modules\\User\\": "Modules/User/app/"
                                    ^^^^ NON va nel namespace
   ```

2. **Never Include 'app' in Namespace**:
   - ❌ `Modules\User\app\Filament\...`
   - ✅ `Modules\User\Filament\...`

3. **Verify Autoload Configuration**: Sempre controllare `composer.json` per capire il mapping

4. **Test After Refactoring**: Dopo spostare file, SEMPRE testare con `php artisan list` o simili

### Prevention

**Before Creating New Files:**
1. Controllare autoload PSR-4 in `composer.json`
2. Calcolare namespace corretto basandosi sul path relativo
3. Verificare con `composer dump-autoload -o`
4. Testare con `php artisan tinker` o PHPStan

---

## ✅ Checklist Finale

- [ ] Fix namespace in 5 Resource files
- [ ] Fix namespace in ~14 Page files
- [ ] Fix use statements in tutti i files
- [ ] Rimuovere eventuali file duplicati vecchi
- [ ] Run PHPStan Level 10 (0 errors expected)
- [ ] Run Laravel Pint
- [ ] Test `php artisan list` senza errori
- [ ] Update passport-cluster-implementation-status.md
- [ ] Git commit with clear message

---

## References

- [PSR-4 Autoloading Standard](https://www.php-fig.org/psr/psr-4/)
- [Composer Autoload Documentation](https://getcomposer.org/doc/04-schema.md#psr-4)
- [Laraxot Module Structure](../../Xot/docs/module-structure.md)
- [Previous Implementation Doc](./passport-cluster-implementation-status.md)

---

**Documentato da**: Claude (Super Cow Mode)
**Metodologia**: DRY + KISS + SOLID + PSR-4 Compliance
**Status**: 📝 Documented - Ready for Implementation

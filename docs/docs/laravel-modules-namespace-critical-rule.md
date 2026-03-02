# ⚠️ REGOLA CRITICA - Namespace Laravel Modules OBBLIGATORIA

**Status**: ✅ Regola Critica OBBLIGATORIA
**Fonte**: [Laravel Modules Documentation](https://laravelmodules.com/docs/12/getting-started/introduction)

---

## 🎯 La Regola Fondamentale

**NEI NAMESPACE DEI MODULI LARAVEL, NON INCLUDERE MAI `app` O `App`, ANCHE SE I FILE SONO FISICAMENTE NELLA DIRECTORY `app/`.**

---

## ❌ ERRORE GRAVE COMUNE

### ❌ VIETATO ASSOLUTAMENTE
```php
// ❌ GRAVEMENTE ERRATO - NON FARE MAI!
use Modules\User\app\Models\User;
use Modules\Meetup\app\Actions\CreateEventAction;
use Modules\Tenant\app\Services\TenantService;
```

### ✅ CORRETTO
```php
// ✅ CORRETTO - SEMPRE COSÌ!
use Modules\User\Models\User;
use Modules\Meetup\Actions\CreateEventAction;
use Modules\Tenant\Services\TenantService;
```

---

## 🔍 Perché Questa Regola?

### Struttura PSR-4 Autoload

Nei file `composer.json` dei moduli, l'autoload PSR-4 è configurato così:

```json
{
    "autoload": {
        "psr-4": {
            "Modules\\NomeModulo\\": "app/"
        }
    }
}
```

**Questo significa**:
- Il namespace `Modules\NomeModulo\` **mappa direttamente** alla directory `app/`
- Quindi `Modules\User\Models` corrisponde a `Modules/User/app/Models/` fisicamente
- **NON serve** (e **NON si deve**) includere `app` nel namespace

### Struttura Fisica vs Namespace

| Percorso Fisico | Namespace Corretto | ❌ Namespace Errato |
|-----------------|-------------------|---------------------|
| `Modules/User/app/Models/User.php` | `Modules\User\Models\User` | `Modules\User\app\Models\User` |
| `Modules/Meetup/app/Actions/CreateEventAction.php` | `Modules\Meetup\Actions\CreateEventAction` | `Modules\Meetup\app\Actions\CreateEventAction` |
| `Modules/Tenant/app/Services/TenantService.php` | `Modules\Tenant\Services\TenantService` | `Modules\Tenant\app\Services\TenantService` |

---

## 📋 Esempi Completi

### Models
```php
// File: Modules/User/app/Models/User.php
namespace Modules\User\Models;  // ✅ CORRETTO

// ❌ ERRATO: namespace Modules\User\app\Models;
```

### Actions
```php
// File: Modules/Meetup/app/Actions/Event/CreateEventAction.php
namespace Modules\Meetup\Actions\Event;  // ✅ CORRETTO

// ❌ ERRATO: namespace Modules\Meetup\app\Actions\Event;
```

### Services
```php
// File: Modules/Tenant/app/Services/TenantService.php
namespace Modules\Tenant\Services;  // ✅ CORRETTO

// ❌ ERRATO: namespace Modules\Tenant\app\Services;
```

### Filament Resources
```php
// File: Modules/User/app/Filament/Resources/UserResource.php
namespace Modules\User\Filament\Resources;  // ✅ CORRETTO

// ❌ ERRATO: namespace Modules\User\app\Filament\Resources;
```

### Controllers
```php
// File: Modules/Meetup/app/Http/Controllers/EventController.php
namespace Modules\Meetup\Http\Controllers;  // ✅ CORRETTO

// ❌ ERRATO: namespace Modules\Meetup\app\Http\Controllers;
```

---

## 🔍 Verifica

### Comando per Verificare Errori
```bash
# Cerca namespace errati con "app" o "App"
grep -r "use Modules\\[^\\]*\\app\\" laravel/Modules --include="*.php"
grep -r "namespace Modules\\[^\\]*\\app\\" laravel/Modules --include="*.php"
```

### Comando per Verificare Namespace Corretti
```bash
# Verifica namespace corretti (senza "app")
grep -r "use Modules\\[^\\]*\\Models\\" laravel/Modules --include="*.php" | head -5
```

---

## 📚 Riferimenti

- [Laravel Modules Documentation](https://laravelmodules.com/docs/12/getting-started/introduction)
- [Composer Merge Plugin](https://github.com/wikimedia/composer-merge-plugin)
- [PSR-4 Autoloading Standard](https://www.php-fig.org/psr/psr-4/)
- [Namespace Rules - Xot Module](./standards/namespace-rules.md)
- [Namespacing - Xot Module](./namespacing.md)

---

## ⚠️ Checklist Pre-Commit

Prima di ogni commit, verificare:

- [ ] Nessun `use Modules\...\app\...` nei file PHP
- [ ] Nessun `namespace Modules\...\app\...` nei file PHP
- [ ] Tutti i namespace seguono il pattern `Modules\NomeModulo\{Categoria}`
- [ ] Tutti gli import usano il namespace corretto (senza `app`)

---

**Ultimo aggiornamento**: [DATE]
**Versione**: 1.0.0
**Status**: ✅ Regola Critica OBBLIGATORIA

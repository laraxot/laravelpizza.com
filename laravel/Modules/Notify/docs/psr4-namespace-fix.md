# Fix Namespace PSR-4 - Modulo Notify

> **Versione**: 1.0  
> **Ultima modifica**: Vedi [CHANGELOG.md](./CHANGELOG.md)

**Problema**: Namespace con `\App\` viola convenzione Laraxot  
**Severità**: 🟡 Media (warning autoload, non blocca app)

## Errore Originale

```
Class Modules\Notify\App\Jobs\SendScheduledPushNotification 
does not comply with psr-4 autoloading standard
```

## Causa

**File**: `Modules/Notify/app/Jobs/SendScheduledPushNotification.php`  
**Linea 14**: Import con namespace errato

```php
use Modules\Notify\App\Services\PushNotificationService;  // ❌ ERRATO
```

## Filosofia del Namespace Laraxot

### Perché NO `\App\` ?

**Convenzione Laravel Standard** (app root):
```
File:      app/Services/MyService.php
Namespace: App\Services\MyService  ✅ OK
```

**Convenzione Laraxot Moduli**:
```
File:      Modules/Notify/app/Services/PushNotificationService.php
Namespace: Modules\Notify\Services\PushNotificationService  ✅ CORRETTO

// ❌ NON Modules\Notify\App\Services\...
```

**Perché**: `app/` è contenitore organizzativo del filesystem, NON parte del namespace logico.

## Fix Applicato

```php
// Prima (ERRATO)
use Modules\Notify\App\Services\PushNotificationService;

// Dopo (CORRETTO)
use Modules\Notify\Services\PushNotificationService;
```

## Verifica

```bash
cd /var/www/_bases/base_ptvx_fila4_mono/laravel
composer dump-autoload

# Output:
# Generated optimized autoload files containing 22855 classes
# ✅ Nessun warning PSR-4
```

## Regola Generale

**Per TUTTI i moduli Laraxot**:

```
Modules/{ModuleName}/app/{Subdirectory}/{File}.php
└─> namespace Modules\{ModuleName}\{Subdirectory}

NON: Modules\{ModuleName}\App\{Subdirectory}
```

## Collegamenti

- [Namespace Conventions](../../Xot/docs/namespace-conventions.md)
- [PSR-4 Autoloading Pattern](../../Xot/docs/namespace-autoload-pattern.md)

**Status**: ✅ RISOLTO  
**Impatto**: Nessuno (warning, non blocco funzionale)


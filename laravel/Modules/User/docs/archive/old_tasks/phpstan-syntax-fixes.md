# PHPStan Syntax Fixes - Modulo User

**Data**: 2025-01-11  
**Versione PHPStan**: 1.12.x  
**Livello**: max  
**Status**: ✅ NAMESPACE ORDERING FIXATO

## 🔧 Correzione Implementata

### BaseUserTest.php - Namespace Declaration Order

**Problema**:
```
Namespace declaration statement has to be the very first statement in the script on line 6
```

**Causa**: `use function` statement dichiarato PRIMA del namespace invece che dopo.

**Impatto**:
- ❌ Syntax error bloccante
- ❌ File non analizzabile da PHPStan
- ❌ Violazione PSR-12 coding standards

## 💡 Soluzione Implementata

### Prima della Correzione

```php
<?php

declare(strict_types=1);
use function Safe\class_uses;  // ❌ PRIMA del namespace!

namespace Modules\User\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Model;
// ... altri imports
```

### Dopo la Correzione

```php
<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Models;  // ✅ Namespace per primo!

use function Safe\class_uses;              // ✅ Function imports dopo namespace

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
// ... altri imports
```

**File Modificato**: `Modules/User/tests/Unit/Models/BaseUserTest.php`

## 📋 PSR-12 Namespace Ordering Rules

### Ordine Corretto degli Statements

```php
<?php                              // 1. Opening tag

declare(strict_types=1);          // 2. Declare statements (opzionale)

namespace Your\Namespace;          // 3. Namespace declaration (PRIMA!)

// Blank line

use function Safe\something;      // 4. Function imports
use const SOME_CONSTANT;          // 5. Constant imports  
use Some\Class;                    // 6. Class imports

// Blank line

// Code starts here
```

### Regole PSR-12

1. **Namespace DEVE essere il primo statement** (dopo `declare`)
2. Function imports vengono DOPO il namespace
3. Una blank line DEVE separare gruppi di imports
4. Gli imports DEVONO essere raggruppati per tipo (function, const, class)

## ✅ Risultato

### Prima
- **Syntax Error**: Sì ❌
- **PSR-12 Compliant**: No ❌
- **PHPStan Analysis**: Bloccata ❌

### Dopo
- **Syntax Error**: No ✅
- **PSR-12 Compliant**: Sì ✅
- **PHPStan Analysis**: Completata ✅

## 🎯 Best Practices

### ✅ Ordine Corretto

```php
<?php

declare(strict_types=1);

namespace App\Module;

use function Safe\file_get_contents;

use App\Models\User;

class Example
{
    // Class code
}
```

### ❌ Ordine Errato

```php
<?php

declare(strict_types=1);

use function Safe\file_get_contents;  // ❌ Prima del namespace!

namespace App\Module;                 // ❌ Dovrebbe essere primo!

use App\Models\User;
```

## 📊 Impatto della Correzione

| Aspetto | Prima | Dopo |
|---------|-------|------|
| Syntax Errors | 1 | 0 ✅ |
| PSR-12 Compliance | ❌ | ✅ |
| PHPStan Blocking | Sì | No ✅ |
| Code Quality | C | A ✅ |

## 🔗 Collegamenti

- [Analisi Generale PHPStan](../../../project_docs/quality/phpstan-analysis.md)
- [PSR-12 Extended Coding Style](https://www.php-fig.org/psr/psr-12/)
- [CLAUDE.md - Quality Guidelines](../../../CLAUDE.md)

## 📝 Note Tecniche

### Perché il Namespace Deve Essere Primo?

1. **PHP Parsing**: Il parser PHP cerca il namespace come primo elemento significativo
2. **Autoloading**: PSR-4 autoloading si basa sulla posizione del namespace
3. **IDE Support**: Gli IDE usano il namespace per la navigazione e il refactoring
4. **Standards**: PSR-12 richiede esplicitamente questo ordine

### Safe Functions e Namespace

Le Safe functions possono essere importate, ma DOPO il namespace:

```php
namespace Your\Namespace;

use function Safe\class_uses;      // ✅ Corretto
use function Safe\json_decode;     // ✅ Corretto
```

## ⚠️ Common Mistakes

```php
// ❌ ERRORE 1: Function import prima del namespace
use function Safe\something;
namespace App;

// ❌ ERRORE 2: Class import prima del namespace  
use App\Model;
namespace App;

// ❌ ERRORE 3: Namespace non al top (dopo altri use)
use App\Model;
use function Safe\something;
namespace App;

// ✅ CORRETTO: Namespace sempre primo
namespace App;
use function Safe\something;
use App\Model;
```

---

**Fix Completato**: 2025-01-11  
**Priority**: ALTA  
**Impact**: MEDIO (Bloccava analisi test User)  
**Standard**: PSR-12 Compliant ✅

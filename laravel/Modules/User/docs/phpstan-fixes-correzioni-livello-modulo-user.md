---
title: "Correzioni PHPStan Livello 7 - Modulo User"
type: concept
tags: [phpstan, fixes]
created: 2026-07-14
updated: 2026-07-14
qmd: "phpstan-fixes-1-1 correzioni phpstan livello 7 - modulo user"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Correzioni PHPStan Livello 7 - Modulo User

Questo documento traccia gli errori PHPStan di livello 7 identificati nel modulo User e le relative soluzioni implementate.

## Errori Identificati

### 1. Errori in Profile.php

```
Line 49: PHPDoc tag @method for method Modules\User\Models\Profile::permission() return type contains unknown class Modules\User\Models\Builder.
Line 49: PHPDoc tag @method for method Modules\User\Models\Profile::role() return type contains unknown class Modules\User\Models\Builder.
Line 49: PHPDoc tag @method for method Modules\User\Models\Profile::withExtraAttributes() return type contains unknown class Modules\User\Models\Builder.
Line 49: PHPDoc tag @method for method Modules\User\Models\Profile::withoutPermission() return type contains unknown class Modules\User\Models\Builder.
Line 49: PHPDoc tag @method for method Modules\User\Models\Profile::withoutRole() return type contains unknown class Modules\User\Models\Builder.
```

## Soluzioni Implementate

### 1. Correzione in Profile.php

Il problema è che i tag PHPDoc facevano riferimento a una classe `Builder` nel namespace `Modules\User\Models` che non esiste. Abbiamo corretto i riferimenti utilizzando il namespace completo per la classe Builder:

```php
/**
 * ...
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withExtraAttributes()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withoutRole($roles, $guard = null)
 * ...
 */
```

### Versione HEAD

Questo garantisce che PHPStan possa risolvere correttamente il tipo `Builder` utilizzando il namespace completo `\Illuminate\Database\Eloquent\Builder`. 
## Collegamenti tra versioni di phpstan-fixes.md
* [phpstan-fixes-8.md](../../../Xot/docs/phpstan/phpstan-fixes-8.md)
* [phpstan-fixes-8.md](../../../Xot/docs/phpstan-fixes-8.md)
* [phpstan-fixes-8.md](phpstan-fixes.md)
* [phpstan-fixes-8.md](../../../UI/docs/phpstan-fixes-8.md)
* [phpstan-fixes-8.md](../../../Media/docs/phpstan-fixes-8.md)


### Versione Incoming

Questo garantisce che PHPStan possa risolvere correttamente il tipo `Builder` utilizzando il namespace completo `\Illuminate\Database\Eloquent\Builder`. 

---


---
title: "Actions Structure"
type: concept
tags: [actions, structure]
created: 2026-07-14
updated: 2026-07-14
qmd: "actions-structure-3 actions structure"
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
status: draft
---

# Actions Structure 

## Directory Structure

, le Actions devono essere collocate nella directory `app/Actions/` del modulo, seguendo la struttura PSR-4 per l'autoloading:

- **Percorso Corretto**: `Modules/{ModuleName}/app/Actions/`
- **Namespace Corretto**: `Modules\{ModuleName}\Actions\`

### Esempi di percorsi corretti:
- `Modules/User/app/Actions/User/DeleteUserAction.php`
- `Modules/User/app/Actions/Auth/LoginAction.php`

### Esempi di percorsi errati:
- `Modules/User/Actions/User/DeleteUserAction.php` (manca la directory `app/`)
- `Modules/User/Actions/DeleteUserAction.php` (manca la directory `app/`)

## Namespace Structure

Il namespace deve riflettere la struttura del modulo, ma **NON** deve includere il segmento `App`:

```php
// CORRETTO
namespace Modules\User\Actions\User;

// ERRATO
namespace Modules\User\App\Actions\User;
```

Questa differenza è definita nel file `composer.json` di ogni modulo, che mappa il namespace `Modules\NomeModulo\` alla directory `app/`:

```json
"autoload": {
    "psr-4": {
        "Modules\\User\\": "app/"
    }
}
```

## Pattern di Implementazione

healthcare_app utilizza il package `spatie/laravel-queueable-action` per le Actions, NON il pattern Service:

```php
<?php

namespace Modules\User\Actions\User;

use Spatie\QueueableAction\QueueableAction;
use Modules\User\Models\User;

class DeleteUserAction
{
    use QueueableAction;

    public function execute(User $user): bool
    {
        // Implementazione...
        return true;
    }
}
```

## Vantaggi di questa Struttura

1. **Coerenza con la struttura PSR-4** definita nel composer.json
2. **Compatibilità con l'autoloading** di Composer
3. **Rispetto delle convenzioni** per i moduli
4. **Facilità di manutenzione** e navigazione del codice
5. **Supporto per operazioni asincrone** tramite `QueueableAction`

## Documentazione Correlata

- [Path Conventions](./path-conventions.md)
- [Directory Structure Checklist](./directory-structure-checklist.md)
- [Module Structure](./module-structure.md)
- [Path Conventions](./path-conventions-user.md)
- [Directory Structure Checklist](./directory-structure-checklist.md)
- [Module Structure](./module-structure-user.md)
- [Queueable Actions Best Practices](./best-practices/queueable-actions.md)
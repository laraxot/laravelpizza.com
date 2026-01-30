---
description: Regole di posizionamento dei test per il core Xot
---

# Test Placement Guidelines (Xot)

Queste regole definiscono dove devono essere salvati i file di test relativi al **core Xot** e hanno lo scopo di evitare che i test vengano sovrascritti dagli aggiornamenti di Laravel o da altri framework.

## 1. Directory dei test

```
Modules/Xot/tests/
├── Browser/   # Test browser (Dusk, Playwright, ecc.)
├── Feature/   # Test funzionali / HTTP
└── Unit/      # Test unitari & piccoli helper
```

* **NON** creare o lasciare file di test in `/laravel/tests/` fatta eccezione per gli stub installati automaticamente da Laravel.
* Ogni nuovo test del core Xot **deve** essere inserito nella sotto-cartella opportuna del percorso sopra.

## 2. Namespace

Il namespace dei test deve riflettere la struttura cartelle:

```php
namespace Modules\Xot\Tests\{Unit|Feature|Browser};
```

Esempio per un test unitario:

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Modules\Xot\...;
use Tests\TestCase;

class MetatagDataTest extends TestCase
{
    // ...
}
```

## 3. Spostamento automatico

Quando si individuano test errati in `/laravel/tests/`, spostarli manualmente o usare il comando helper:

```bash
php artisan xot:fix-test-paths
```

Questo comando cerca test con il prefisso `Modules\Xot\` in percorsi sbagliati e li sposta nella cartella corretta.

## 4. Aggiornamento della documentazione

Dopo aver aggiunto o spostato test:

1. Aggiornare questo file **se la struttura cambia**.
2. Aggiornare la documentazione root `docs/testing.md` con eventuali nuove regole globali.
3. Collegare la view con breadcrumb:
   - `docs/testing.md` → `Modules/Xot/project_docs/testing/test-placement-guidelines.md`
   - Questo file → `docs/testing.md`

## 5. Checklist PR

- [ ] Il test è nella cartella corretta `Modules/Xot/tests/...`
- [ ] Il namespace corrisponde al percorso della cartella
- [ ] Non esistono test duplicati nella root `/laravel/tests/`
- [ ] PHPStan livello 9+ passa senza errori
- [ ] Documentazione aggiornata (questo file & root docs)

*Ultimo aggiornamento: 2025-07-06 – aggiunte linee guida per prevenire posizionamenti errati (es. `MetatagDataTest`).*

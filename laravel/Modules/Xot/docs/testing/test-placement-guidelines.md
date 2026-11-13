---
description: Regole di posizionamento dei test per il core Xot
title: "Test Placement Guidelines (Xot)"
type: note
status: draft
updated: 2026-10-18
tags: [docs, xot, testing]
qmd: "test placement guidelines (xot) xot"
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

* **NON** creare file di test in `/laravel/tests/`. Dal 2026-11-11 quella
  cartella **non esiste piu'**: e' stata sciolta e i suoi test spostati nei
  moduli di competenza. Nemmeno gli stub di Laravel (`ExampleTest`) tornano
  li': `composer create-project` non gira su questo repository, e se un
  aggiornamento li ricreasse vanno cancellati.
* Non esiste piu' nemmeno il namespace `Tests\` come PSR-4: la mappatura e'
  stata tolta da `composer.json`. Un file che dichiara `namespace Tests\...`
  non e' caricabile.
* Un job della CI (`guard.yml`, "Nessun test fuori dai moduli") fallisce se
  compare un file sotto `laravel/tests/` o un riferimento al namespace della
  radice.
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

Se un test ricompare in `/laravel/tests/`, va spostato nel modulo che verifica.
Dove andarono quelli che c'erano (2026-11-11):

| Era | E' diventato |
|---|---|
| `tests/Architecture/ModulesArchitectureTest.php` | `Modules/Xot/tests/Architecture/` |
| `tests/Architecture/TestDatabaseGuardTest.php` | accorpato in `Modules/Xot/tests/Unit/Support/TestDatabaseGuardTest.php` |
| `tests/Feature/ViewQuestionChartPageTest.php` | `Modules/Quaeris/tests/Feature/` |
| `tests/Feature/Modules/UI/*` | `Modules/UI/tests/Feature/` |
| `tests/{Unit,Feature}/ExampleTest.php`, `SimpleTest.php` | cancellati (impalcatura Laravel) |
| `tests/reports/*` | cancellati (output generato) |
| `tests/TestCase.php`, `tests/Pest.php` | cancellati: ogni modulo ha i propri |

Per spostare, manualmente o con il comando helper:

```bash
php artisan xot:fix-test-paths
```

Questo comando cerca test con il prefisso `Modules\Xot\` in percorsi sbagliati e li sposta nella cartella corretta.

### Dopo lo spostamento: percorsi calcolati e prima esecuzione

Spostare un file non basta: un test che calcola percorsi da `__DIR__`
(`dirname(__DIR__, N)`) cambia bersaglio quando cambia cartella. E un test spostato
va **lanciato** subito, non solo sottoposto a `php -l`.

Caso reale (2026-11-12): `ModulesArchitectureTest` si spostò da
`laravel/tests/Architecture/` a `Modules/Xot/tests/Architecture/` con ancora
`dirname(__DIR__, 2).'/Modules'`, che ora indicava `Modules/Xot/Modules`. Il
Finder restava senza cartelle e 4 test su 5 cadevano con `LogicException`: il
gate cross-module non controllava niente. Corretto con `archModulesRoot()` =
`dirname(__DIR__, 3)`. Nello stesso spostamento `SurveyPdfPolicyTest` non era mai
passato (doppio di `tenants()` di tipo sbagliato, 5 casi su 8 in `TypeError`).
Story: [5.302](../bmad/stories/5.302-release-readiness-asset-temi-document-root.story.md),
seguito 2026-11-12.

## 4. Aggiornamento della documentazione

Dopo aver aggiunto o spostato test:

1. Aggiornare questo file **se la struttura cambia**.
2. Aggiornare la documentazione root `docs/testing.md` con eventuali nuove regole globali.
3. Collegare la view con breadcrumb:
   - `docs/testing.md` → `Modules/Xot/docs/testing/test-placement-guidelines.md`
   - Questo file → `docs/testing.md`

## 5. Checklist PR

- [ ] Il test è nella cartella corretta `Modules/Xot/tests/...`
- [ ] Il namespace corrisponde al percorso della cartella
- [ ] La cartella `/laravel/tests/` non esiste (la CI lo verifica)
- [ ] PHPStan livello 9+ passa senza errori
- [ ] Documentazione aggiornata (questo file & root docs)

*Ultimo aggiornamento: 2025-07-06 – aggiunte linee guida per prevenire posizionamenti errati (es. `MetatagDataTest`).*

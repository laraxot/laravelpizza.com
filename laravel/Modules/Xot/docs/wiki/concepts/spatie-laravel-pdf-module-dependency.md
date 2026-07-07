---
title: "spatie/laravel-pdf — owner modulo Xot"
type: concept
module: Xot
tags: [xot, pdf, spatie, composer, dependency, browsershot]
created: 2026-06-06
updated: 2026-06-06
qmd: "xot spatie laravel pdf module composer dependency MakePdfSpatieTestAction Pdf facade merge plugin"
issues:
  - "https://github.com/laraxot/base_techplanner_fila5/issues/16"
discussions:
  - "https://github.com/laraxot/base_techplanner_fila5/discussions/17"
related:
  - ../../composer-module-dependency-management.md
  - ../../../../../../docs/wiki/rules/composer-module-dependency-go.md
  - ../troubleshooting/browsershot-missing-dependency.md
  - ../../actions/pdf-actions-overview.md
---

# spatie/laravel-pdf in Xot

## Perché

PDF infrastrutturali (export, test, engine Browsershot) sono **competenza Xot**, non root Laravel. Il facade `Pdf` è il contratto ufficiale Spatie v2.

## Dove

| Artefatto | Path |
|-----------|------|
| Require | `Modules/Xot/composer.json` → `"spatie/laravel-pdf": "^2.11"` |
| Config | `laravel/config/laravel-pdf.php` (publish da pacchetto) |
| Action test | `app/Actions/Pdf/MakePdfSpatieTestAction.php` |
| View | `resources/views/pdf/spatie-test.blade.php` |

## Uso canon

```php
use Spatie\LaravelPdf\Facades\Pdf;

return Pdf::view('xot::pdf.spatie-test', $data)
    ->format('a4')
    ->name($filename)
    ->toResponse($request);
```

## Install / sync (regola Laraxot)

```bash
# 1. require già in Modules/Xot/composer.json
rm -rf laravel/Modules/Xot/vendor
cd laravel && php -d memory_limit=-1 composer.phar update -W
# stack completo (migrate/serve): composer go — solo se appropriato
```

Upstream: [github.com/spatie/laravel-pdf](https://github.com/spatie/laravel-pdf)

Regola globale: [composer-module-dependency-go.md](../../../../../../docs/wiki/rules/composer-module-dependency-go.md) · Issue [#16](https://github.com/laraxot/base_techplanner_fila5/issues/16)

## PHPStan

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Xot/app/Actions/Pdf/MakePdfSpatieTestAction.php --memory-limit=-1
```

## Zen

- **Non** reimplementare Browsershot nell'action se il pacchetto è dichiarato nel modulo
- **Non** duplicare classi in `tests/Support/` — testa l'action in `app/`

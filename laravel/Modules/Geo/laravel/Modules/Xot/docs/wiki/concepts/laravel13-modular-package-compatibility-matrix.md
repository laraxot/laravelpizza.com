---
title: "Laravel 13 Modular Package Compatibility Matrix"
module: "Xot"
created: "2026-04-28"
updated: "2026-05-21"
---

# Laravel 13 Modular Package Compatibility Matrix

## Scopo

Definire una regola operativa semplice: in progetto modulare Laraxot i pacchetti si installano nel modulo owner tramite merge del `composer.json` root. **Baseline runtime:** Laravel **13** con **PHP ≥8.4** per linee aggiornate Spatie incluso `laravel-model-states` ^2.14 ([#87](https://github.com/laraxot/base_fixcity_fila5/issues/87)); `php` di default sulla shell può restare **8.3** finché Composer/Stan usano **`php8.4`**.

## Matrice verificata

| Pacchetto | Owner canonico | Compatibile Laravel 13 | Compatibile PHP 8.3 | Decisione |
|---|---|---|---|---|
| `fruitcake/laravel-debugbar` | `Modules/Xot` (`require-dev`) | si (`illuminate ^11|^12|^13.0`) | si (`^8.2`) | dichiarare solo in Xot come `^4.2.8`; non duplicare nel root o nei temi |
| `spatie/laravel-pdf` | `Modules/Incentivi` | si dalla linea `^2.8` (`illuminate/contracts ^11|^12|^13`) | si (`^8.2`) | aggiornare da `^1.5` a `^2.8`; non spostare nel root |
| `spatie/laravel-responsecache` | nessun owner runtime confermato | si (`8.3.x`) | no (`php ^8.4`) | non reinstallare; la linea `7.7.2` resta ferma a `Laravel 12` |
| `aaronfrancis/fast-paginate` | `Modules/Xot` | no (stable fino a `illuminate ^12`) | si | bloccato in attesa release stable `^13`; oggi manca dal lock root |
| `fidum/laravel-eloquent-morph-to-one` | `Modules/Xot` | no (stable fino a `illuminate ^12`) | si | bloccato in attesa release stable `^13`; oggi manca dal lock root |
| `spatie/laravel-model-states` | `Modules/UI` + `Modules/Xot` | si (`2.14.1`, `illuminate ^13`) | **no** su solo 8.3 (2.14 richiede `php ^8.4`) | **risolto** 2026-05-21: `php8.4 … composer update -W` da `laravel/`; vendor OK; PHPStan `app/States/` OK. Lock root locale (repo: `*.lock` gitignored). [#87](https://github.com/laraxot/base_fixcity_fila5/issues/87) |

## Evidenze codice

- `aaronfrancis/fast-paginate`: `Modules/Xot/app/Filament/Resources/Pages/XotBaseListRecords.php`
- `fidum/laravel-eloquent-morph-to-one`: `Modules/Xot/app/Actions/Model/Store/MorphToOneAction.php`, `Modules/Xot/app/Actions/Model/Update/MorphToOneAction.php`
- `spatie/laravel-model-states`: `Modules/UI/app/Filament/Forms/Components/SelectState.php`, `Modules/UI/app/Filament/Tables/Columns/*State*.php`, `Modules/Xot/app/States/*`
- `spatie/laravel-responsecache`: nessuna integrazione applicativa forte nel codice PHP corrente; presenti solo riferimenti documentali e una riga commentata in `ArtisanService`
- `fruitcake/laravel-debugbar`: `Modules/Xot/composer.json`, `laravel/config/debugbar.php`, middleware/security bypass e servizi Artisan in Xot
- `spatie/laravel-pdf`: `Modules/Incentivi/composer.json`, report PDF del dominio Incentivi

## Regola operativa

- Prima la compatibilita' tecnica, poi la preferenza architetturale.
- Modularita' non significa forzare installazioni incompatibili.
- Se un pacchetto non risolve su lock condiviso, si documenta il motivo e si pianifica re-check.
- Il file canonico da aggiornare e' il `composer.json` del modulo owner; i `composer.lock` locali dei moduli non sono sorgente autorevole per il lock condiviso root.

## Trigger di ri-valutazione

- upgrade ambiente a `PHP 8.4`;
- nuova release stable con supporto `illuminate ^13`;
- rimozione di branch `dev-*` come unica opzione.

## Riferimenti

- [debugbar architecture](../../debugbar-architecture.md)
- [story 8-69](../../../../../../../_bmad-output/implementation-artifacts/8-69-modular-laravel13-package-reintroduction-compatibility-matrix.md)
- [root decision](../../../../../../docs/wiki/concepts/laravel13-modular-package-reintroduction.md)

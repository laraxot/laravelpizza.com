---
title: "Laravel 13 Modular Package Compatibility Matrix"
module: "Xot"
created: "2026-04-28"
updated: "2026-04-28"
---

# Laravel 13 Modular Package Compatibility Matrix

## Scopo

Definire una regola operativa semplice: in progetto modulare Laraxot i pacchetti si installano nel modulo owner, ma solo se compatibili con il runtime reale (`Laravel 13` + `PHP 8.3`).

## Matrice verificata

| Pacchetto | Owner canonico | Compatibile Laravel 13 | Compatibile PHP 8.3 | Decisione |
|---|---|---|---|---|
| `fruitcake/laravel-debugbar` | `Modules/Xot` (`require-dev`) | si (`^13`) | si (`^8.2`) | gia' presente nel lock root come `v4.2.8`; non duplicare altrove |
| `spatie/laravel-responsecache` | nessun owner runtime confermato | si (`8.3.x`) | no (`php ^8.4`) | non reinstallare; la linea `7.7.2` resta ferma a `Laravel 12` |
| `aaronfrancis/fast-paginate` | `Modules/Xot` | no (stable fino a `illuminate ^12`) | si | bloccato in attesa release stable `^13`; oggi manca dal lock root |
| `fidum/laravel-eloquent-morph-to-one` | `Modules/Xot` | no (stable fino a `illuminate ^12`) | si | bloccato in attesa release stable `^13`; oggi manca dal lock root |
| `spatie/laravel-model-states` | `Modules/UI` + `Modules/Xot` | si (`2.13.1`) | no (`php ^8.4`) | bloccato su runtime attuale; `2.12.1` supporta solo `Laravel 10|11|12` |

## Evidenze codice

- `aaronfrancis/fast-paginate`: `Modules/Xot/app/Filament/Resources/Pages/XotBaseListRecords.php`
- `fidum/laravel-eloquent-morph-to-one`: `Modules/Xot/app/Actions/Model/Store/MorphToOneAction.php`, `Modules/Xot/app/Actions/Model/Update/MorphToOneAction.php`
- `spatie/laravel-model-states`: `Modules/UI/app/Filament/Forms/Components/SelectState.php`, `Modules/UI/app/Filament/Tables/Columns/*State*.php`, `Modules/Xot/app/States/*`
- `spatie/laravel-responsecache`: nessuna integrazione applicativa forte nel codice PHP corrente; presenti solo riferimenti documentali e una riga commentata in `ArtisanService`
- `fruitcake/laravel-debugbar`: `laravel/config/debugbar.php`, middleware/security bypass e servizi Artisan in Xot

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

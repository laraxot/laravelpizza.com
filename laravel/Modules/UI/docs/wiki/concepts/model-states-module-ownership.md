---
title: "Model States Module Ownership"
module: "UI"
created: "2026-04-28"
updated: "2026-04-28"
---

# Model States Module Ownership

## Scopo

Fissare la regola di ownership per `spatie/laravel-model-states` nel progetto modulare Laraxot dopo l'upgrade a Laravel 13.

## Decisione

- Il package non appartiene al root `composer.json`.
- Il package non appartiene a un singolo modulo dominio.
- L'owner tecnico e' condiviso tra `Modules/UI` e `Modules/Xot`:
  - `UI` espone componenti Filament che tipizzano `HasStatesContract` e `State`;
  - `Xot` definisce i base state e le transition astratte.

## Evidenze codice

- `Modules/UI/app/Filament/Forms/Components/SelectState.php`
- `Modules/UI/app/Filament/Tables/Columns/SelectStateColumn.php`
- `Modules/UI/app/Filament/Tables/Columns/IconStateColumn.php`
- `Modules/UI/app/Filament/Tables/Columns/IconStateSplitColumn.php`
- `Modules/Xot/app/States/XotBaseState.php`
- `Modules/Xot/app/States/Transitions/XotBaseTransition.php`

## Compatibilita' verificata al 2026-04-28

- latest stable `2.13.1`: supporta `Laravel 12|13` ma richiede `php ^8.4`
- linea precedente `2.12.1`: supporta `php ^7.4|^8.0` ma solo `Laravel 10|11|12`

## Regola operativa

- Su runtime `Laravel 13 + PHP 8.3.6` non si reinstalla il package.
- Se il progetto sale a `PHP 8.4`, il primo punto da aggiornare e' il `composer.json` del modulo owner canonico, non il root.
- Fino a quel momento, i riferimenti codice restano debito tecnico esplicito da non riattivare con branch `dev-*`.

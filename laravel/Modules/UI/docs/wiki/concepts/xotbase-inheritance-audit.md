---
title: "XotBase inheritance audit"
type: concept
tags: [filament, xotbase, inheritance, ui, phpstan]
created: 2026-07-17
updated: 2026-07-17
qmd: "ui filament direct inheritance xotbase action form table widget audit"
issues:
  - "https://github.com/laraxot/module_ui_fila5/issues/27"
discussions:
  - "https://github.com/laraxot/<nome repository>/discussions/12"
  - "https://github.com/laraxot/base_techplanner_fila5/discussions/12"
  - "https://github.com/laraxot/<nome repository>/discussions/12"
  - "https://github.com/laraxot/base_techplanner_fila5/discussions/12"
  - "https://github.com/laraxot/<nome repository>/discussions/12"
  - ""
  - "https://github.com/laraxot/<nome repository>/discussions/12"
related:
  - "../../../../Xot/docs/wiki/concepts/xotbase-filament-widget-hierarchy.md"
---

# XotBase inheritance audit

Le classi concrete UI non estendono Filament direttamente. Il parent deve essere la base astratta speculare `Modules\\Xot\\Filament\\...\\XotBase*`; gli import Filament usati come tipi, contratti o composizione non sono violazioni.

## Inventario UI

L'audit ha corretto 13 parent: due Action, cinque componenti form, quattro colonne table e tre widget. Le basi riusate sono `XotBaseAction`, `XotBaseViewField`, `XotBaseSelect`, `XotBaseTextInput`, `XotBaseRadio`, `XotBaseColumn`, `XotBaseIconColumn`, `XotBaseColumnGroup`, `XotBaseSelectColumn`, `XotBaseStatsOverviewWidget` e `XotBaseChartWidget`.

## Gate

`php -l`, PHPStan mirato e `git diff --check` sono verdi. PHPMD conserva debito preesistente nelle colonne state (complessità, method length e import); non deriva dal cambio di parent.

`EnumSelect` non deve ridefinire `make(?string)` per inoltrare un nullable: tutti gli usi passano un nome stringa e il contratto va ereditato da `XotBaseSelect`. Il completamento è tracciato nell'issue owner perché il file era locked da un altro agente durante l'audit.

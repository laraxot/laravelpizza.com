---
title: "chart widgets"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< .merge_file_hyfJ6J
<<<<<<< .merge_file_BGsi60
updated: 2026-11-23
=======
=======
>>>>>>> .merge_file_kjEGf5
<<<<<<< HEAD
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
<<<<<<< .merge_file_hyfJ6J
>>>>>>> .merge_file_KOijBj
=======
>>>>>>> .merge_file_kjEGf5
qmd: "chart widgets"
issues: []
discussions: []
status: draft
---

# Quick Reference - Chart Widgets

## Errori comuni

- `Cannot read properties of null (reading 'x')` su doughnut/pie
  - Causa probabile: plugin datalabels/runtime callback su meta/data non disponibili.
  - Azione: validare dataset/options nel widget e disabilitare datalabels dove necessario per radial.

## File chiave

- `laravel/Modules/<nome progetto>/app/Filament/Widgets/QuestionChartAnswersChartWidget.php`
- `laravel/Modules/<nome progetto>/app/Filament/Widgets/QuestionChartAnswersTripleChartWidget.php`
- `laravel/Modules/Chart/resources/js/filament-chart-js-plugins.js`

## Check dataset rapido

- label/values con stessa lunghezza
- niente `null` dove il plugin si aspetta coordinate/valori numerici
- per `_total` su doughnut: modellare il dataset per resa visiva attesa

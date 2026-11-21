---
id: story-ui-table-layout-enum-translations
slug: ui-table-layout-enum-translations
title: "UI — Allineare le traduzioni italiane di TableLayoutEnum"
description: "Mantiene le voci enum sotto values, come richiesto da EnumTrait, e impedisce che Filament interpreti la chiave di traduzione come nome SVG."
document_type: story
category: quality
status: in_progress
version: 1.0.0
language: it-IT
project: FixCity Fila5
created_at: '2026-09-27'
updated_at: '2026-09-27'
author: Codex
priority: Must
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/383"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/392"
related:
  - ../../stories/5.8.merge-conflict-markers-cleanup.story.md
  - ../../../../Xot/app/Traits/EnumTrait.php
  - ../../lang/it/table_layout_enum.php
  - ../../tests/Unit/Enums/TableLayoutEnumTest.php
---

# Problema

`EnumTrait::getIcon()` e `getLabel()` leggono `values.{case}.{property}`. Il catalogo
italiano aveva invece `list` e `grid` al livello radice. La traduzione restituiva la
chiave `fix:ui::table_layout_enum.values.grid.icon` al posto del nome Heroicon; le
tabelle Filament fallivano con `SvgNotFound` durante il rendering.

## Criteri di accettazione

- [x] Le opzioni italiane `list` e `grid` sono annidate sotto `values`.
- [x] Il test enum verifica label e nomi icona per entrambi i casi in italiano.
- [x] La suite Feature Filament Fixcity passa senza `SvgNotFound` (66 test / 277 asserzioni).
- [ ] PHPStan, Pint e quality gate wiki sono verdi sullo stato finale.

## Implementazione e prova

Corretto `Modules/UI/lang/it/table_layout_enum.php` secondo il contratto di
`EnumTrait` e aggiunta la regressione a `Modules/UI/tests/Unit/Enums/TableLayoutEnumTest.php`.
La suite Feature Filament eseguita con SQLite isolato passa: 66 test / 277 asserzioni.
Il precedente run completo Fixcity aveva errori SVG nelle pagine resource; la verifica
mirata conferma il rendering delle pagine Filament dopo la correzione.

## Rischio residuo

Resta necessario ripetere la suite completa e distinguere i fallimenti non correlati
all'enum. Le chiavi inglesi sono già annidate sotto `values`; la regressione era nel
catalogo italiano.

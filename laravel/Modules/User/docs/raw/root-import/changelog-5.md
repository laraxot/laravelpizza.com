---
title: "Changelog"
type: concept
tags: [changelog]
created: 2026-07-14
updated: 2026-07-14
qmd: "changelog-5 changelog"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./changelog-1.md"
  - "./changelog-2.md"
  - "./changelog-3.md"
  - "./changelog-4.md"
  - "./changelog.md"
  - "./git-reset-1.md"
  - "./git-reset.md"
  - "./pest-test-report-1.md"
---

# Changelog

Tutte le modifiche notevoli a questo modulo saranno documentate in questo file.

Il formato è basato su [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
e questo progetto aderisce al [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Fixed
- Rimosso il modificatore `static` dal metodo `getTableColumns()` in `TeamsRelationManager` per risolvere l'errore di compatibilità con Filament
- Aggiornata la documentazione degli errori comuni di Filament
- Aggiunta checklist per la correzione degli errori nei RelationManager
- Rimosso il modificatore `static` dal metodo `getFormSchema()` in `LoginWidget` per risolvere l'errore di compatibilità con Filament
- Aggiornata la documentazione degli errori comuni di Filament
- Aggiunta checklist per la correzione degli errori nei Widget

### Added
- Nuova documentazione dettagliata sugli errori comuni di Filament nel modulo
- Esempi di implementazione corretta per i RelationManager
- Checklist per la verifica delle correzioni
- Esempi di implementazione corretta per i Widget
- Checklist per la verifica delle correzioni

### Changed
- Migliorata la struttura della documentazione Filament
- Aggiornate le best practices per i metodi di RelationManager
- Aggiunte note sulla verifica del codice e la manutenibilità
- Migliorata la struttura della documentazione Filament
- Aggiornate le best practices per i metodi di Widget
- Aggiunte note sulla verifica del codice e la manutenibilità

## [1.0.0] - 2024-03-XX

### Added
- Implementazione iniziale del modulo User
- Risorse Filament per User e Team
- Gestione delle relazioni tra User e Team
- Documentazione base del modulo
- Widget per il login e la registrazione
- Gestione delle autenticazioni
- Documentazione base del modulo

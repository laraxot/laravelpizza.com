---
title: Architecture Patterns — Xot Module
type: architecture
module: Xot
status: approved
tags: [architecture, framework-base, patterns, design]
updated: "2026-06-18"
related:
  - ./README.md
  - ../app
  - ../../docs/wiki/concepts/xot-framework-architecture.md
---

# Architecture Patterns — Xot Module

> **Framework Base Architecture.** Xot è il modulo fondamentale di Laraxot: fornisce classi base, traits, convenzioni e pattern architetturali usati da tutti gli altri moduli dell'ecosistema.

## Overview

Xot implementa un'architettura **modulare monolitica** basata su:
- **Classi base** (`XotBase*`) per ereditarietà coerente
- **Traits ricchi** per composizione funzionale
- **Data Transfer Objects (Datas)** per incapsulamento dati
- **Actions** per single-responsibility
- **Service providers** auto-registration
- **Support classes** per utility comuni

## 1. XotBase Classes — Inheritance Foundation

- **`XotBaseResource`** → Filament Resources
- **`XotBaseAction`** → Query & Mutation Actions (166+ actions)
- **`XotBaseEnum`** → Type-safe Enumerations
- **`XotBaseModel`** → Base Eloquent Models

## 2. Traits Ecosystem

**Model Traits**
- `HasUuid` — UUID primary keys
- `HasMedia` — Spatie Media Library
- `HasStates` — State machines
- `HasActivityLog` — Activity tracking
- `HasXotTable` — Filament enhancements
- `TransTrait` — Multilanguage
- 20+ more traits for composition

## 3. Data Transfer Objects (30+ Datas)

Type-safe configuration objects: `RouteData`, `OptionData`, `ColumnData`, `RelationData`, `MetatagData`, `ArticleData`, `EnvData`, `FilemanagerData`, `NotificationData`, `PdfData`, etc.

## 4. Actions Pattern (166+ Actions)

Single-responsibility actions for business logic:
- GetModelByModelTypeAction
- GetModelClassByModelTypeAction
- GetViewByClassAction
- ExecuteArtisanCommandAction
- GeneratePdfAction
- GetTransKeyAction
- ParsePrintPageStringAction

## 5. Support Classes & Utilities

- `EloquentModelResolver` — model_type → class resolution
- `RouteHelper`, `TranslationHelper` — utilities
- Query filters, custom casts

## 6. Service Providers — Auto-Registration

`XotServiceProvider` handles:
- Auto-binding of actions
- Macro registration
- Config merging
- View namespacing

## 7. Filament Integration

- `XotBaseResource` with auto table/form generation
- Automatic relation detection
- Customizable columns via `ColumnData`
- BelongsToMany handling

## Best Practices

1. **Extend XotBase*** classes for core components
2. **Use Traits** for optional functionality
3. **DTOs for type-safe** parameter passing
4. **Actions for complex** business logic
5. **Type everything** (PHPStan level 10)
6. **Test thoroughly** (Pest)

## Backlinks & References

- **Root README**: [Xot Module](./README.md)
- **Wiki**: [docs/wiki/concepts/xot-framework-architecture.md](../../../docs/wiki/concepts/xot-framework-architecture.md)
- **PHPStan Patterns**: [docs/Xot/docs/phpstan-*.md](./phpstan-*.md)
- **Dependent Modules**: IndennitaCondizioniLavoro, IndennitaResponsabilita, UI, Ptv, Progressioni, Incentivi, Rating, Activity, Job

---

**Document Type**: Architecture Reference  
**Module**: Xot  
**Last Updated**: 2026-06-18  
**Status**: Approved

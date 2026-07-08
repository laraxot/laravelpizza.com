---
title: "XotData e MetatagData — non DTO semplici"
type: reference
module: Xot
status: active
tags: [xotdata, metatagdata, spatie-data, wireable]
updated: "2026-06-30"
related:
  - ../concepts/module-root-uppercase-folders-archive.md
  - ../../helper-autoload-compatibility.md
---

# XotData e MetatagData — non DTO semplici

## Scopo

Documentare perché queste classi in `app/Datas/` **non** vanno trattate come DTO passivi da sostituire con array o interfacce a singola implementazione.

## XotData

- Estende `Spatie\LaravelData\Data` + `Livewire\Wireable`
- Configurazione runtime: modulo principale, lingua, tema pub, SSL, auth, path moduli
- Usata come singleton di contesto applicativo (tenant, user class resolution)

## MetatagData

- Estende `Data` + `Wireable`
- Metadati pagina, Open Graph, asset path, colori design system
- Transformer custom (`AssetTransformer`), integrazione `TenantService`

## Implicazioni per refactor

- Non estrarre interfacce “per policy” senza almeno due implementazioni reali
- Non spostare logica in service layer generico: viola regola Actions Laraxot
- QA obbligatorio dopo ogni edit: PHPStan max, PHPMD, PHPInsights, runtime HTTP

## Dipendenze correlate

`spatie/laravel-permission` resta in `Modules/Xot/composer.json` (RBAC condiviso).

---
title: "Memoria — struttura modulo: solo app/ per il PHP"
type: memory
module: Xot
tags: [module-structure, psr-4, agent-discipline, laraxot]
created: "2026-06-18"
updated: "2026-06-18"
related:
  - ../../../../../../docs/wiki/rules/module-root-php-folders-forbidden.md
  - ../../../../../../docs/wiki/concepts/module-structure.md
  - ../module-directory-structure-rule.md
qmd: "memory module app only directory structure forbidden root Actions Database Events"
---

# Memoria — struttura modulo: solo `app/` per il PHP

## Trigger mentale

Se vedi `laravel/Modules/*/Actions` (senza `app/`) → **errore strutturale**, non crearne di nuove.

## Lista cartelle root vietate

`Actions`, `Application`, `Database` (PascalCase), `Events`, `Listeners`, `Models`, `Enums`, `Http`, `Providers`, `Services`, `Filament`, `Datas`.

## Dove mettere cosa

- Business logic → `app/Actions/` (QueueableAction, mai `App\Services`)
- Eventi/listener → `app/Events/`, `app/Listeners/`
- Application layer → `app/Application/` sotto `app/`
- DB → `database/migrations|factories|seeders` (minuscolo)

## Stato repo (2026-06-18)

Unica violazione: ~~`laravel/Modules/User/`~~ ✅ risolto 2026-06-18.

## Azione agente

Prima di creare file in un modulo: path deve contenere `app/` (o `database/`/`config/`/`routes/` per non-PHP).

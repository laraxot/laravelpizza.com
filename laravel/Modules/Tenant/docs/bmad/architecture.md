---
tags: [documentation]
created: 2026-09-26
issues: []
discussions: []
scope: Tenant
epic: 5.124-bmad-user-module-perfection-study
bmad_version: v3.30.1
updated_at: '2026-09-22'
related:
  - ../stories/continuazione-domani.md
title: "Tenant — Architettura BMAD"
type: architecture
status: active
updated: 2026-11-16
module: Tenant
qmd: "architettura Tenant risoluzione tenant host config per ente sushi json provider morph map connessioni database"
---

# Tenant — Architettura

## Scopo

## Milestones Domani
1. Verificare conformità con XotBase
2. Aggiornare `docs/bmad/stories/continuazione-domani.md` se chiuso
3. Indicare stato concluso in `docs/sprint-status.yaml`
Scopo e perché: [purpose.md](./purpose.md). Dettaglio risoluzione: [architecture/tenant-config-resolution.md](./architecture/tenant-config-resolution.md), confini: [architecture/module-boundary.md](./architecture/module-boundary.md). Finding: [audits/tenant-audit.md](./audits/tenant-audit.md).

## Flusso (verificato sul codice, 2026-11-16)

1. `GetTenantNameAction` ricava il nome ente dall'host (slug per parte; fallback default).
2. `GetTenantConfigPathAction` / `GetTenantFilePathAction` mappano nome → `config/<tenant>/…` (guardia anti-traversal).
3. `TenantServiceProvider::boot()`: `mergeConfigs()` → `registerDB()` (config `database` del tenant, alias delle connessioni di modulo sulla default, riconnessione tranne in test) → `registerMorphMap()` (solo chiavi stringa, classi esistenti).
4. I model Sushi (`SushiToJson`, `SushiToCsv`, `SushiToPhpArray`) leggono la config del tenant come tabella.

## Componenti

| Area | N | Note |
|---|---:|---|
| Actions | 19 | `Config`, `Json`, `Domains`, `Ente`, `Models`, `Modules`, `Translations`, `Markdown` |
| Models | 10 | `Tenant`, `Domain`, `TenantDomain`, `TenantSetting`, `TenantSubscription`, `DatabaseConfig`, `BaseModel*` |
| Policy | 2 | `TenantBasePolicy` (astratta), `DomainPolicy` |
| Filament | 1 Resource (`DomainResource`) + 2 Pages | estende Xot |
| Services | 0 | logica in Action |

## Rischi architetturali

Host come input (TEN-P1-01), bypass policy (TEN-P1-02), segreti non cifrati (TEN-P1-03), due varianti Sushi JSON (TEN-P2-01). Dettaglio e task: [epics.md](./epics.md).

---
issues: []
discussions: []
title: "Tenant Module LLM Wiki"
module: "Tenant"
type: concept
tags: [index]
created: 2026-07-14
updated: 2026-07-27
qmd: "index"
related:
  - "./phpstan-corrections-january.md"
---
# Tenant Module LLM Wiki

Indice operativo del wiki Tenant.

## Struttura canonica (sacred)

- [concepts/](./concepts/): Pattern architetturali e metodologie multi-tenant.
- [entities/](./entities/): Modelli e componenti chiave.
- [sources/](./sources/): Dati di ricerca e link esterni.
- [comparisons/](./comparisons/): Implementazioni alternative.
- [decisions/](./decisions/): ADL (Architectural Decision Log).
- [troubleshooting/](./troubleshooting/): Problemi noti e soluzioni.
- Storico modulo fuori dal wiki canonico: [../legacy/](../legacy/) (se presente).
- [_templates/](./_templates/): Template standard.

## Regole collegate

- [forbidden-folders-rule](../../../../docs/wiki/concepts/forbidden-folders.md): Vincoli strutturali strict.
- [llm-wiki-standard](../../../../docs/project/karpathy-llm-wiki-adoption.md): Mapping repository e ciclo di vita conoscenza.
- [laravel-multi-tenancy](../../../../docs/wiki/concepts/laravel-multi-tenancy.md): Multi-tenancy patterns.
- [lowercase-tests-directory](./concepts/lowercase-tests-directory.md): solo `tests/`, mai `Tests/`.
- [lowercase-database-factories-directory](./concepts/lowercase-database-factories-directory.md): solo `database/factories|seeders|migrations` minuscolo; mai `Factories_/`.
- [services-to-queueable-actions](./concepts/no-app-support-queueable-actions.md): mapping completo `TenantService` → `app(...)->execute()` e regola no injection tra Actions.
- [tenant-module-status-registry](../tenant-module-status-registry.md) — registry `modules_statuses.json` per overlay tenant (`config/local/workorder/`)
- [runtime-config-religion-hub](../../../../Themes/docs/shared-components/runtime-config-religion-hub.md) — hub cross-modulo (permission, config.php, statuses)

## Scopo Tenant Module

Gestione multi-tenancy, isolamento dati, tenant scoping e provisioning.

## Compiled Pages

| Pagina | Tipo | Argomento | Data |
|--------|------|-----------|------|
| [.gitkeep](./concepts/.gitkeep) | Concept | - | 2026-04-21 |
| [tenant-module-status-registry](../tenant-module-status-registry.md) | Concept | Registry moduli abilitati per tenant | 2026-07-27 |
| [tenant-config-restoration-incident](./concepts/tenant-config-restoration-incident.md) | Troubleshooting | Ripristino config tenant 2026-07-01 | 2026-07-01 |
| [lowercase-database-factories-directory](./concepts/lowercase-database-factories-directory.md) | Concept | `database/factories/` canonico; `Factories_` vietata | 2026-07-01 |
| [lowercase-tests-directory](./concepts/lowercase-tests-directory.md) | Concept | Cartella test canonica minuscola | 2026-06-30 |
| [xotbase-table-columns-enforcement](./concepts/xotbase-table-columns-enforcement.md) | Concept | 1 Table file — DomainsTable populated | 2026-05-07 |

## Best Practices

- Usare Actions per tenant logic (vedi [actions-over-services-governance](https://github.com/laraxot/platform/blob/main/.opencode/skills/actions-over-services-governance/SKILL.md))
- Implementare `casts()` method non `$casts` property (vedi [model-casts-phpstan](../../../../docs/wiki/concepts/model-casts-phpstan.md))
- Usare tenant scoping (vedi [laravel-multi-tenancy](../../../../docs/wiki/concepts/laravel-multi-tenancy.md))

## Bad Practices

- NON creare Service classes - usare Actions (vedi [actions-over-services-governance](https://github.com/laraxot/platform/blob/main/.opencode/skills/actions-over-services-governance/SKILL.md))
- NON usare `dehydrated(false)` nei trait - blocca salvataggio (vedi Geo CoordinatePicker fix)
- NON confondere `modules_statuses.json` root con overlay tenant — per workorder vale `config/local/workorder/modules_statuses.json` (vedi [tenant-module-status-registry](../tenant-module-status-registry.md))

## False Friends

- `dehydrated(false)` sembra mantenere il campo nei dati ma blocca il salvataggio (vedi [coordinate-picker-filament5-save-pattern](../../Geo/docs/wiki/concepts/coordinate-picker-filament5-save-pattern.md))
- `live()` in Filament non rende il campo sempre live - serve `$applyStateBindingModifiers()` (vedi [coordinate-picker-state-binding-rule](../../Geo/docs/wiki/concepts/coordinate-picker-state-binding-rule.md))

## Troubleshooting

| Pagina | Tipo | Argomento |
|--------|------|-----------|
| [.gitkeep](./concepts/.gitkeep) | Concept | Template iniziale |

Aggiornato: 2026-07-27

## Shared Second Brain Discipline

- [second-brain-local-discipline](./concepts/second-brain-local-discipline.md) — local docs/wiki operating contract aligned with root LLM Wiki discipline.

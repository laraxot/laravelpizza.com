---
title: "no app/Support — Tenant QueueableAction"
type: concept
tags: [tenant, actions, queueable-action, support, config, migration]
created: 2026-07-12
updated: 2026-07-13
qmd: "Tenant module no Support ConfigStringKeyFilter morph map merge config TenantService migration"
issues:
  - "https://github.com/laraxot/platform/issues/372"
discussions:
  - "https://github.com/laraxot/platform/discussions/273"
related:
  - ../../../../docs/wiki/concepts/no-app-support-monorepo-migration.md
  - config-merge-philosophy.md
---

# Tenant — `app/Services/` senza PHP attivo

| Legacy | Action |
|--------|--------|
| `ConfigStringKeyFilter::onlyStringKeys` | `Actions/Config/FilterConfigStringKeysAction` |
| `ConfigStringKeyFilter::mergeRecursive` | `Actions/Config/MergeRecursiveStringKeyConfigAction` |

## TenantService → Action dirette (2026-07)

`TenantService` (facade statica) **eliminata**. I caller usano `app(SomeAction::class)->execute(...)` — **non** `handle()`.

| Ex `TenantService::` | Action |
|----------------------|--------|
| `getName()` | `GetTenantNameAction` |
| `filePath($f)` | `GetTenantFilePathAction` |
| `config($k,$d)` | `ResolveTenantConfigValueAction` |
| `getConfigPath($k)` | `GetTenantConfigPathAction` |
| `getConfig($n)` | `GetTenantConfigArrayAction` |
| `saveConfig($n,$d)` | `SaveTenantConfigAction` |
| `getConfigNames()` | `GetTenantConfigNamesAction` |
| `modelClass($n)` | `ResolveTenantModelClassAction` |
| `model($n)` | `ResolveTenantModelInstanceAction` |
| `trans($k)` | `TranslateTenantKeyAction` |
| `allModules()` | `GetTenantModulesAction` |

Config tenant (`config/{tenant}/*.php`): `app(GetTenantFilePathAction::class)->execute('…')`.

Test: mockare l'Action rilevante (`app()->instance(GetTenantFilePathAction::class, $mock)`), non più `TenantService`.

## Composizione e confini

Le Actions non ricevono altre Actions nel costruttore: quando un use case ne compone un altro usa `app(AltraAction::class)->execute(...)`. Questo mantiene identica la risoluzione sync/queue, evita grafi di injection inutili e rende ogni chiamante rintracciabile con `rg`.

I vecchi resolver e `TenantService` restano soltanto come file `.bak` per studio forward-only; non sono autoloadabili. Il contratto resolver vivo, se necessario, appartiene a `app/Contracts`, mai a `app/Services`.

## Perché

Config tenant e morph map devono ignorare chiavi non-string (PHPStan + merge sicuro). Static helper in Support impediva mock e coda; le Action restano pure e componibili nel `TenantServiceProvider` e trait Sushi.

## Collegamenti

- [no-app-support-monorepo-migration](../../../../docs/wiki/concepts/no-app-support-monorepo-migration.md)

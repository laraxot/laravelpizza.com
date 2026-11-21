---
title: "Tenant — Setup Guide"
type: note
module: Tenant
tags:
  - bmad
  - tenant
  - setup
created: 2026-09-28
updated: 2026-09-28
qmd: "tenant setup install config migrate test"
related:
  - README.md
  - quick-reference.md
---

# Tenant — Setup Guide

> **SUMMARY** — Come si porta il modulo `Tenant` in un ambiente funzionante: config da
  caricare, provider da registrare, migrazioni presenti nel modulo, test da eseguire.
> Comandi da eseguire dalla root di `laravel/`.

## 1. Registrazione provider

`module.json` e `composer.json` dichiarano:

- `Modules\Tenant\Providers\TenantServiceProvider`
- `Modules\Tenant\Providers\Filament\AdminPanelProvider`

`app/Providers/TenantServiceProvider.php::register()` ha la registrazione di
`AdminPanelProvider` commentata: il pannello Filament del modulo non viene registrato
automaticamente, va verificato chi lo registra.

## 2. Config

| File | Contenuto |
|------|-----------|
| `config/config.php` | `name`, `description`, `icon`, `navigation` (enabled/sort), `routes` (enabled/middleware `web`,`auth`), `providers` |
| `config/database.php` | connessione DB |
| `config/modules.php` | elenco moduli |
| `config/xra.php`, `config/metatag.php`, `config/test.php` | config accessorie |

Il provider carica inoltre, a runtime, i nomi restituiti da
`app/Actions/Config/GetTenantConfigNamesAction.php`.

## 3. Migrazioni presenti nel modulo

Solo tre, tutte del 2026-07-24:

- `database/migrations/2026_07_24_000000_create_tenant_settings_table.php`
- `database/migrations/2026_07_24_000001_create_tenant_subscriptions_table.php`
- `database/migrations/2026_07_24_000002_create_database_configs_table.php`

**La tabella `tenants` non viene creata da questo modulo.** `app/Models/Tenant.php`,
`database/factories/TenantFactory.php` e `database/seeders/TenantSeeder.php` la usano:
prima di eseguire i seeders verificare da dove arriva la tabella.

Vincoli del progetto: mai `migrate:fresh`, mai `--force`, mai `RefreshDatabase`.

## 4. Seeders

| Seeder | Path |
|--------|------|
| `TenantSeeder` | `database/seeders/TenantSeeder.php` |
| `TenantDatabaseSeeder` | `database/seeders/TenantDatabaseSeeder.php` |
| `TenantDomainSeeder` | `database/seeders/TenantDomainSeeder.php` |
| `TenantSettingSeeder` | `database/seeders/TenantSettingSeeder.php` |
| `TenantSubscriptionSeeder` | `database/seeders/TenantSubscriptionSeeder.php` |
| `DomainSeeder` / `DomainsSeeder` | `database/seeders/DomainSeeder.php`, `database/seeders/DomainsSeeder.php` |
| `DatabaseConfigSeeder` | `database/seeders/DatabaseConfigSeeder.php` |

## 5. Test

Da `laravel/`:

```bash
./vendor/bin/pest --filter=Tenant
./vendor/bin/pest Modules/Tenant
```

Nota di progetto: sull'host `10.100.200.15` non si lanciano test (dati sacri).

## 6. Helper di test

- `tests/Pest.php`, `tests/TestCase.php`
- `tests/TenantContextSetter.php` — contesto di tenant per i test
- `tests/Support/helpers.php`
- `tests/Fixtures/` — modelli di prova per i trait Sushi

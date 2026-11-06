---
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-10-14
qmd: "tenant module readme host config directory sushi json resolve"
issues: []
discussions: []
title: "Tenant: Multi-Tenancy"
description: "Modulo per il multi-tenancy, isolamento dati per tenant"
module: "Tenant"
alias: "tenant"
version: "1.0.0"
priority: 2
active: true
status: active
author: "Team Laraxot"
license: "MIT"
php_version: "^8.1"
core_version: "10.0"
dependencies: ["Xot", "User"]
extends: []
extended_by: 0
documentation_date: "2026-05-27"
---

# Tenant: Multi-Tenancy

## Scopo

Il "tenant" di questo progetto e' una **cartella di configurazione scelta dal nome host**, non una riga di database. `Actions\GetTenantNameAction` legge `SERVER_NAME` (o l'host di `APP_URL` se manca o e' `127.0.0.1`), toglie `www.`, ne fa slug e inverte le parti: `fixcity.local` diventa `local/fixcity`. Se `laravel/config/local/fixcity/` esiste, quello e' il tenant; se l'host ha piu' di due parti prova senza la parte piu' a sinistra; altrimenti ripiega sull'host di `APP_URL` e infine su `localhost`. Verificato il 2026-10-14: `php artisan tenant:test` stampa `tenant name :local/fixcity`.

Da quel nome derivano tutte le configurazioni per tenant (verificato 2026-10-14):

- `Actions\Config\ResolveTenantConfigValueAction`: fonde `config('<gruppo>')` con `config('<tenant con punti>.<gruppo>')` (fusione ricorsiva) e ripubblica il gruppo. `TenantServiceProvider::boot()` la applica a ogni file `.php` presente nella cartella del tenant (`GetTenantConfigNamesAction`).
- `Actions\Config\SaveTenantConfigAction`: unico punto di scrittura, fonde i dati in `config/<tenant>/<nome>.php`.
- `Actions\Config\GetTenantFilePathAction`: percorso `config/<tenant>/<file>`; rifiuta percorsi assoluti, `..` e byte nulli.
- Trait `Models\Traits\SushiToJson`, `SushiToJsons`, `SushiToPhpArray`, `SushiToCsv`: modelli Sushi con righe lette da `config/<tenant>/database/content/<tabella>/<id>.json` (create/update/delete riscrivono il file). E' il meccanismo con cui il modulo Cms serve le pagine (`Modules\Cms\Models\Page` usa `SushiToJsons`; 99 JSON in `config/local/fixcity/database/content/pages/` al 2026-10-14).
- `TenantServiceProvider`: registra anche il morph map (chiave `morph_map` della config del tenant), le connessioni database (fusione di `config/<tenant>/database.php` con quelle dei moduli; connessione `tenant` presente a runtime) e `Schema::defaultStringLength(191)`.

Tenant esistenti oggi in `laravel/config/`: `local/fixcity`, `eu/fixcity`, `net/futurely`, `localhost`.

## Quick start

```bash
cd laravel
php artisan tenant:test            # nome del tenant per l'host corrente
php artisan tinker --execute="echo config_path(app(Modules\\Tenant\\Actions\\GetTenantNameAction::class)->execute());"
```

## Cosa NON c'e' (verificato 2026-10-14)

- Nessun isolamento per riga: niente `BelongsToTenant`, niente global scope, niente `TenantService`, `TenantSwitcher` o `SetTenant` (grep su `app/`, `routes/`, `config/`, `database/` del modulo). Il testo "Tenant scoping automatico" dei docs descrive un'architettura non implementata.
- `BaseTenant`, `HasTenants` e la tabella pivot `tenant_user` non stanno qui: sono nel modulo User (`Modules/User/app/Models/BaseTenant.php`, `Models/Traits/HasTenants.php`).
- `Models\Tenant::users()` e' una `hasMany` verso la classe utente di `XotData`, non un pivot.
- Nessuna rotta (`routes/web.php` e `api.php` sono commenti) e nessun controller attivo (restano file `.no`).
- Nessuna impersonation, fatturazione per tenant, backup isolato o analytics.
- Un solo comando Artisan: `tenant:test`.

## Chi lo usa

Importano `Modules\Tenant` (grep, esclusi i docs): Cms (16 file), Xot (6), User (4), Geo (3), Notify, Gdpr, Fixcity, Blog (1 ciascuno).

## Filament e dati

`Filament\Resources\DomainResource` elenca i tenant con il modello Sushi `Models\Domain` (`GetDomainsArrayAction` percorre le sottocartelle di `config/`, escludendo `lang`). Le migration (`2026_07_24_*`) creano `tenant_settings`, `tenant_subscriptions`, `database_configs`.

## Test

Cartelle `tests/Unit` (Actions/Config, Models, Fixtures Sushi), `tests/Feature` (`TenantConfigIsolationTest`, `TenantBusinessLogicTest`), `tests/Integration`, `tests/Performance`. Esecuzione non provata in questa verifica.

## Religione

- **"Un database per tenant o row-level security"**: due politiche accettate, ma **mai mixate**
- **"Tenant è una primitiva, non un dettaglio"**: ogni modulo deve essere tenant-aware
- **"HasTenants trait su BaseUser"**: dottrina valida per il modulo User (il trait sta in `Modules/User`)
- **"Salvataggio config con Action"**: `SaveTenantConfigAction` è il punto unico
- **"XotBase come fondamento"**: ogni risorsa tenant estende `XotBaseResource`

## Filosofia

Tenant crede che **l'isolamento dei dati sia un diritto, non un optional**. Ogni tenant ha la sua configurazione, le sue risorse, la sua sicurezza. Il sistema è progettato per **scalare orizzontalmente** aggiungendo tenant senza modificare il codice.

## Politica

Riga di principio, non verificabile nel codice di questo modulo: le regole sul pivot `tenant_user`, su `HasTenants` e su `BaseTenant::$connection` riguardano il modulo User. La politica verificata e' quella descritta in "Scopo": un tenant e' una cartella `config/<host invertito>/`, `SaveTenantConfigAction` e' il punto unico di scrittura e il nome dell'host decide il tenant.

## Zen

> **"Il tenant è un confine. Il confine è una promessa. La promessa è la privacy."**

Lo Zen di Tenant è l'**isolamento**. I dati di un tenant non possono mai essere visti, modificati o cancellati da un altro tenant. È una promessa architetturale, non una feature.

## Perché esiste

Le applicazioni SaaS moderne hanno bisogno di multi-tenancy per servire più clienti con un'unica installazione. Tenant esiste per **gestire questa complessità** in modo standardizzato.

## Cosa Mancherebbe (Gap Analysis)

| Gap | Severità | Suggerimento |
|-----|----------|--------------|
| Manca tenant impersonation | Alta | Aggiungere `ImpersonateTenantAction` |
| Nessun sistema di tenant billing | Alta | Integrare con `Billing` per fatturazione per tenant |
| Manca tenant backup isolato | Media | Aggiungere `TenantBackup` con restore selettivo |
| Nessun sistema di tenant analytics | Media | Aggiungere `TenantAnalytics` per usage tracking |
| Manca cross-tenant reporting | Bassa | Aggiungere `CrossTenantReport` per admin globali |

---

*Documento generato secondo le convenzioni del progetto: modulo `Tenant`: data 2026-05-27*
---
# Documentation

This directory contains documentation for the module.

## Structure

- **bmad/architecture-tenant.md** - Module architecture and design patterns
- **README.md** - This file

## Guidelines

Documentation should be:
- Clear and concise
- Example-driven
- Updated with code changes
- Use Markdown format (.md)

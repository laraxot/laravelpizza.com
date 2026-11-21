---
issues: []
discussions: []
title: "Modules Statuses — root vs tenant-scoped"
module: "Tenant"
type: concept
tags: [modules, statuses, tenant, navigation, config]
created: 2026-07-14
updated: 2026-07-27
qmd: "modules statuses tenant scoped GetTenantModulesAction GetTenantNameAction navigation menu"
related:
  - "../../../app/Actions/Modules/GetTenantModulesAction.php"
  - "../../../app/Actions/GetTenantNameAction.php"
  - "../../../app/Actions/Config/GetTenantFilePathAction.php"
  - "../../../../Xot/app/Actions/Filament/GetModulesNavigationItems.php"
---

# Modules Statuses — due file indipendenti, non uno solo

Questo progetto ha **due file `modules_statuses.json` completamente separati**, con
scopi diversi. Confonderli (o dimenticarsi del secondo) produce un bug silenzioso:
un modulo perfettamente funzionante ma invisibile nel menu di navigazione admin.

## 1. Root — `laravel/modules_statuses.json`

Letto da nwidart/laravel-modules (`config('modules.activators.file.statuses-file')`
→ `base_path('modules_statuses.json')`). Controlla se il `ServiceProvider` del
modulo viene registrato/booted da Laravel. Se un modulo è `false` qui, non esiste
per l'applicazione: niente rotte, niente migrazioni, niente Eloquent.

## 2. Tenant-scoped — `config/{tenant}/modules_statuses.json`

Risolto dinamicamente per hostname. Per workorder, `config/local/workorder/modules.php` **sovrascrive** anche l’activator nwidart:

```php
'statuses-file' => base_path('config/local/workorder/modules_statuses.json'),
```

Catena navigazione:

```
GetTenantNameAction::execute()
  → reversed hostname (es. workorder.local → local/workorder)
GetTenantFilePathAction::execute('modules_statuses.json')
  → config_path("{tenant}/modules_statuses.json")
GetTenantModulesAction::execute()
  → legge quel file, filtra sui soli nomi con directory reale (File::exists(Modules/{name}))
  → consumato da Modules\Xot\app\Actions\Filament\GetModulesNavigationItems.php
```

Questo file **non** influenza se il modulo funziona — influenza **solo** se
compare come voce di navigazione nel pannello Filament admin. Un modulo può avere
rotte, migrazioni e modelli perfettamente funzionanti e restare invisibile nel
menu solo perché manca da questo file, senza nessun errore o eccezione.

## Incidente reale (2026-07-27)

`config/local/workorder/modules_statuses.json` conteneva moduli di un progetto
completamente diverso (`modulo questionari`, `BarberShop`, `RealEstate`, `Food`, `Forum`,
`Shop`, `Ticket`, `Limesurvey`, …) — nessuno esistente in `Modules/` di questo
progetto — più `Blog`/`Comment`/`TestModule` mai ripuliti dopo la loro rimozione.
`GetTenantModulesAction` filtra silenziosamente le voci senza directory reale, per
cui l'errore non si è mai manifestato come eccezione: semplicemente, la maggior
parte dei moduli reali di questo progetto (WhatsApp, TimberBilling,
PublicProcurement, EnergyBroker, Compliance, Inventory, Production, HR, …) non
compariva nel menu admin.

## Checklist di audit

```bash
# Devono restituire lo stesso insieme di nomi (a meno di moduli col solo
# ServiceProvider abilitato ma navigazione volutamente nascosta):
diff <(php -r 'echo implode("\n", array_keys(json_decode(file_get_contents("modules_statuses.json"), true)));' | sort) \
     <(php -r 'echo implode("\n", array_keys(json_decode(file_get_contents("config/local/workorder/modules_statuses.json"), true)));' | sort)
```

Quando si aggiunge o rimuove un modulo, aggiornare **entrambi** i file JSON (root e tenant) — non solo quello root.

Rigenerazione: `bash bashscripts/tools/sync-tenant-modules-statuses.sh local/workorder`

Riferimenti: [session-learnings-modules-config.md](../../session-learnings-modules-config.md) · [Themes/tenant-modules-navigation-discipline.md](../../../../Themes/docs/tenant-modules-navigation-discipline.md)

---
qmd: "tenant module status registry"
issues: []
discussions: []
title: "Tenant module status registry — config/{tenant}/modules_statuses.json"
type: concept
module: Tenant
tags: [tenant, modules, config, activator, navigation, multi-tenant]
created: 2026-07-27
updated: 2026-07-27
related:
  - ../../Xot/docs/wiki/concepts/module-config-config-php.md
  - ../app/Actions/Modules/GetTenantModulesAction.php
  - ../app/Actions/Config/GetTenantFilePathAction.php
  - ../../Xot/app/Actions/Filament/GetModulesNavigationItems.php
---

# Registro tenant-specific dei moduli abilitati

## Due registri distinti — non confonderli

Questo progetto ha **due meccanismi separati** che controllano/descrivono i moduli, e per
molto tempo in questa sessione multi-agente solo il primo è stato auditato:

| Meccanismo | File | Letto da | Scopo |
|---|---|---|---|
| **nwidart FileActivator** (root) | `modules_statuses.json` (root Laravel) | `config/modules.php` → `activators.file.statuses-file` | Abilita/disabilita il **boot** del modulo a livello framework (autoload, service provider, migrations, ecc.) |
| **Panel metadata per-modulo** | `Modules/{Name}/config/config.php` | `XotBaseServiceProvider::registerConfig()` → `PanelMixin` | `name`/`icon`/`navigation.sort` per il pannello Filament di quel modulo |
| **Tenant module registry** (questo doc) | `config/{tenantName}/modules_statuses.json` — qui `config/local/workorder/modules_statuses.json` | `GetTenantModulesAction` (via `GetTenantFilePathAction`) | Lista dei moduli **visibili/abilitati per questo tenant specifico**, usata per costruire la navigazione (`GetModulesNavigationItems`) |

Il path del terzo file **non** è `config/{Name}/`: `GetTenantFilePathAction::execute()`
risolve `base_path('config/'.$tenantName.'/'.$filename)`, dove `$tenantName` viene da
`GetTenantNameAction` — hostname (`SERVER_NAME`/`app.url`) diviso per `.`, invertito,
sluggificato e unito con `/`. Per hostname `workorder.local` questo produce
`local/workorder`, quindi il path reale è `config/local/workorder/modules_statuses.json`
(non `config/workorder/...`). Verificare sempre con:

```bash
php artisan tinker --execute="echo app(\Modules\Tenant\Actions\GetTenantNameAction::class)->execute();"
```

## Perché questo registro può disallinearsi dal reale

`GetTenantModulesAction::collectEnabledModules()` filtra silenziosamente ogni chiave del
JSON per cui `File::exists(base_path('Modules/'.$name))` è falso — un nome modulo
inesistente **non genera errore**, semplicemente non compare nell'elenco risultante.
Questo rende il file silenziosamente tollerante a contenuti stantii: un file copiato da
un progetto diverso (o da un template/boilerplate condiviso) continua a "funzionare"
senza errori visibili, restituendo solo il sottoinsieme di moduli il cui nome combacia
per puro caso — mascherando il fatto che moduli reali del progetto corrente non ci sono.

## Incidente reale (2026-07-27)

`config/local/workorder/modules_statuses.json` conteneva un elenco di moduli
(`modulo questionari, LU, Chart, Limesurvey, Setting, BarberShop, RealEstate, Booking, Food, Forum,
modulo operativo, Shop, Ticket, ...`) che non corrispondeva affatto ai 38 moduli reali di
questo progetto (`AI, Activity, AiAssistant, Billing, Bom, Catalog, Cms, Compliance,
Customer, Document, Email, Employee, EnergyBroker, Fiscal, Gdpr, Geo, HR, Intervention,
Inventory, Job, Lang, Media, Notify, Platform, Production, PublicProcurement, Quotation,
Rating, Seo, Signature, Tenant, TimberBilling, UI, User, Vehicle, WhatsApp, WorkOrder,
Xot`) — chiaramente un leftover copiato da un template/demo generico multi-verticale
(barbershop, real estate, booking, food, forum, shop, ticket) usato come base per altri
progetti `<nome repository>` sulla stessa macchina.

**Perché non è stato notato prima in questa sessione**: l'audit precedente nella stessa
sessione era scoped esclusivamente a `Modules/{Name}/config/config.php` (metadati pannello
Filament, vedi tabella sopra, riga 2) — un meccanismo diverso, con un path diverso
(dentro ogni modulo, non a livello di progetto), letto da un provider diverso
(`XotBaseServiceProvider`/`PanelMixin`, non `GetTenantModulesAction`). Il registro
tenant-specific vive fuori da `Modules/`, sotto `config/{tenantName}/`, quindi non è mai
comparso in nessun grep/audit scoped a `Modules/*/config/`. Nessuna istruzione esplicita
aveva richiesto di controllare questo secondo registro fino a quando l'utente non lo ha
segnalato direttamente.

## Fix applicato (2026-07-27)

Rigenerato `config/local/workorder/modules_statuses.json`:

- **38 chiavi** — solo moduli con `Modules/{Name}/module.json`, tutti `true`
- **Esclusi:** `Blog`, `Comment`, `TestModule` (directory senza `module.json`)
- **Rimossi fantasma:** `DbForge`, `FormBuilder`, nomi legacy multi-verticale (modulo questionari, Ticket, Shop, …)
- `config/local/workorder/modules.php` → `statuses-file` punta a questo JSON

```bash
bash bashscripts/tools/sync-tenant-modules-statuses.sh local/workorder
```

Verificato: `GetTenantModulesAction::execute()` → 38 moduli.

Hub: [session-learnings-modules-config.md](./session-learnings-modules-config.md) · Themes: [tenant-modules-navigation-discipline.md](../../Themes/docs/tenant-modules-navigation-discipline.md)

## Come rigenerare/verificare in futuro

```bash
# Elenco moduli reali con module.json
php -r '
$dirs = array_filter(scandir("Modules"), fn($d) => is_dir("Modules/$d") && !in_array($d, [".",".."]) && file_exists("Modules/$d/module.json"));
sort($dirs); print_r(array_values($dirs));
'

# Verifica cosa restituisce il registro tenant live (non fidarsi del file statico)
php artisan tinker --execute="print_r(app(\Modules\Tenant\Actions\Modules\GetTenantModulesAction::class)->execute());"
```

Se compaiono discrepanze, il file da correggere è sempre il registro tenant
(`config/{tenantName}/modules_statuses.json`) — mai il codice di
`GetTenantModulesAction`/`GetTenantFilePathAction`, che sono generici e corretti per
design (stesso principio di
[bugfix-permission-table-names-singular.md](../../User/docs/bugfix-permission-table-names-singular.md):
il codice legge la config, non il contrario — ma qui la "config" in questione è
generata/mantenuta da chi amministra il tenant, non una convenzione fissa dell'utente
come per `permission.php`; può quindi essere rigenerata quando cambia l'elenco reale dei
moduli).

---
title: "INDEX contratti — Tenant"
type: index
owner: Tenant
updated: 2026-11-24
qmd: "Tenant contract INDEX invarianti copertura pest group TENANT-INV"
---

# INDEX contratti — Tenant

Copertura = `coperto` se per ogni ID esiste `->group('<ID>')` nei test del modulo (verifica: `rg -n "group\('<ID>'\)" laravel/Modules/Tenant/tests`, 2026-11-24: nessun risultato). I test elencati nei contract provano già parte del comportamento ma senza group: `non coperto`. Comandi da `laravel/`.

| Operazione | Contract | Classe | Invarianti | Copertura | Comando |
|---|---|---|---|---|---|
| Risoluzione del tenant dall'host | [get-tenant-name-action](get-tenant-name-action.md) | `Modules\Tenant\Actions\GetTenantNameAction` | TENANT-NAME-INV-1..5 | non coperto | `vendor/bin/pest --group=TENANT-NAME-INV-1` (idem -2..-5) |
| Percorso file del tenant (anti-traversal) | [get-tenant-file-path-action](get-tenant-file-path-action.md) | `Modules\Tenant\Actions\Config\GetTenantFilePathAction` | TENANT-PATH-INV-1..3 | non coperto | `vendor/bin/pest --group=TENANT-PATH-INV-1` (idem -2, -3) |
| Salvataggio config tenant | [save-tenant-config-action](save-tenant-config-action.md) | `Modules\Tenant\Actions\Config\SaveTenantConfigAction` | TENANT-SAVE-INV-1..4 | non coperto | `vendor/bin/pest --group=TENANT-SAVE-INV-1` (idem -2..-4) |

Marker `@contract` nel docblock: mancante (fuori scope docs) in tutte e tre le Action.

Invarianti senza un test individuato: `TENANT-NAME-INV-4`, `TENANT-SAVE-INV-4`.

## Backlog contract

Action ad alto rischio senza contract (`laravel/Modules/Tenant/app/Actions/`):

- `Json/CreateJsonFileByRecordAction.php`, `Json/UpdateJsonFileByRecordAction.php`, `Json/DeleteJsonFileByRecordAction.php` (scrivono e cancellano file di contenuto)
- `Config/GetTenantConfigValueAction.php` (overlay della config; vedi ADR `tenant-config-is-resolved-by-action`)
- `Models/GetTenantModelClassAction.php` (usa `SaveTenantConfigAction` e la morph map del tenant)
- `Modules/GetTenantModulesAction.php`, `Config/GetTenantConfigPathAction.php`

Totale Action in `app/Actions`: 19 file `.php`. Contract formali: 3.

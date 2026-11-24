---
title: "Audit BMAD — Xot"
type: audit
status: review
updated: 2026-11-16
module: Xot
qmd: "audit BMAD Xot sintesi source-first qualità finding P0 P1 PHPStan Pest"
---

# Audit BMAD — Xot

SSoT dettagliata: [audits/xot-audit.md](./audits/xot-audit.md) · scopo: [purpose.md](./purpose.md)

**In una frase:** Xot è il fondamento architetturale (kernel Laraxot): classi base (`XotBaseModel`, `XotBaseResource`, `XotBasePage`), Actions riusabili, contratti per la type-safety, guardie di test e pattern che tutti gli altri moduli estendono. Nessun modulo estende Filament direttamente: si estendono `XotBaseResource`, `XotBaseListRecords`, `XotBaseWidget`, `XotBaseServiceProvider`, `XotBaseMigration`. Questa è **la** regola fondamentale, e Xot è il posto dove vive.

## Inventario misurato (2026-11-16)

| Voce | N |
|---|---:|
| PHP `app/` | 602 |
| Test PHP | 329 |
| Models | 51 |
| Policy | 15 |
| Resource | 7 |
| Widget | 16 |
| Actions | 238 in `app/Actions` (257 contando ogni cartella `Actions`) |
| Services | 2 |
| Migration | 10 |
| Lang IT | 149 |
| `->label('..')` letterali | 18 |
| `@phpstan-ignore` | 20 |
| Policy `return true` | 2 |
| Marker conflitto | 0 |

## Top finding

- **P1-X1** Il core importa 33 classi da 7 moduli feature (55 `use`), `module.json` `requires: []` — `Xot/app (es. `Filament/Traits/HasXotTable.php`, `Datas/MetatagData.php`)`
- **P1-X2** `Services/RouteService.php` (354 righe, ~28 `dddx` commentati, 1 chiamante esterno) + `ModuleCommandHandler` — `Xot/app/Services`
- **P2-X1** `XotBasePolicy::before()` con `once()` senza beneficio (cache per istanza, hash `spl_object_id`) — `Xot/app/Models/Policies/XotBasePolicy.php:21`
- **P2-X3** `HandleArtisanActRequestAction` senza chiamanti, concatena `Request::input('module')` in un comando — `Xot/app/Actions/Artisan/HandleArtisanActRequestAction.php:48-71`

## Gate

- PHPStan `Modules/Xot`: **0 errori (rerun; prima passata 6+ errori in `FeatureFlagsTest` mentre un altro agente lo editava)** (17:10 / rerun 17:21).
- Pest: skip documentato: DB di test `10.100.200.53:3306` irraggiungibile (TCP chiuso) e `Xot/tests/Support/TestDatabaseGuard.php:63` rifiuta DB non `*_test`; i test con DB restano appesi al connect MySQL (timeout 150 s osservato). Nessun test contro il MySQL locale (dati sacri). Pest va eseguito in ambiente testing non produttivo.
- Security/runtime: story figlie sui finding P1 dell'audit dettagliato.

## Seguito

[epics.md](./epics.md) · [decision-log.md](../decision-log.md) · [story](./stories/module-bmad-audit.story.md) · [ECC](../ecc/xot-ecc-audit.md)

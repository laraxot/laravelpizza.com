---
title: "Audit BMAD — UI"
type: audit
status: review
updated: 2026-11-16
module: UI
<<<<<<< .merge_file_554y8h
qmd: "audit BMAD UI sintesi source-first qualità finding P0 P1 PHPStan Pest"
=======
<<<<<<< HEAD
qmd: "audit BMAD UI sintesi source-first qualità finding P0 P1 PHPStan Pest"
=======
<<<<<<< .merge_file_xDMrhL
qmd: "audit BMAD UI sintesi finding P0 P1 PHPStan Pest"
=======
qmd: "audit BMAD UI sintesi source-first qualità finding P0 P1 PHPStan Pest"
>>>>>>> .merge_file_4zU0nw
>>>>>>> laraxot/dev
>>>>>>> .merge_file_4ISu7V
---

# Audit BMAD — UI

<<<<<<< .merge_file_554y8h
SSoT dettagliata: [audits/ui-audit.md](./audits/ui-audit.md) · scopo: [purpose.md](./purpose.md)
=======
<<<<<<< HEAD
SSoT dettagliata: [audits/ui-audit.md](./audits/ui-audit.md) · scopo: [purpose.md](./purpose.md)
=======
<<<<<<< .merge_file_xDMrhL
SSoT dettagliata: [audits/ui-audit.md](./audits/ui-audit.md)

## Sintesi (2026-11-16)

| Metrica | Valore |
|---|---:|
| PHP `app/` | 133 |
| Test | 87 |
| Resources | 0 |
| Actions | 6 |
| Services | 5 |
| Policy `return true` | 2 |
| Marker | 0 |

## Lo scopo in una frase **UI e' il vocabolario visivo condiviso: fa si' che la stessa cosa abbia lo stesso aspetto e lo stesso comportamento in tutti i moduli, senza che nessuno debba

## Gate

- PHPStan modulo / `Modules`: 0 errori (verifica 2026-11-16).
- Pest: da eseguire in ambiente testing non produttivo.
- Security/runtime: story figlie su finding P0/P1 dell'audit dettagliato.
SSoT dettagliata: [audits/ui-audit.md](./audits/ui-audit.md) · scopo: [purpose.md](../wiki/purpose.md)
=======
SSoT dettagliata: [audits/ui-audit.md](./audits/ui-audit.md) · scopo: [purpose.md](./purpose.md)
>>>>>>> .merge_file_4zU0nw
>>>>>>> laraxot/dev
>>>>>>> .merge_file_4ISu7V

**In una frase:** UI è il vocabolario visivo condiviso (componenti, widget, colonne, layout tabella): fa sì che la stessa cosa abbia lo stesso aspetto e lo stesso comportamento in tutti i moduli che lo consumano.

## Inventario misurato (2026-11-16)

| Voce | N |
|---|---:|
| PHP `app/` | 133 |
| Test PHP | 87 |
| Models | 4 |
| Policy (`return true`) | 1 (2) |
| Resource | 0 |
| Widget | 12 |
| Actions | 6 in `app/Actions/*.php` (11 file PHP con `Action` nel percorso) |
| Services | 5 |
| Migration | 3 |
| Lang IT | 123 |
| Marker conflitto | 0 |
| `->label('..')` letterali | 9 |
| `@phpstan-ignore` | 48 |

## Top finding

- **P1-UI1** Dashboard `ui::admin` con dati inventati ("Unique views 192.1k", `TestWidget` ×4, `qid` 5/7/9) — `app/Filament/Pages/Dashboard.php:28-45`
- **P1-UI2** 3 test su modelli assenti (Asset/Component/Theme) con 48 `@phpstan-ignore`: copertura fantasma — `tests/Unit/Models/AssetModelTest.php:6-30`
- **P2-UI3** `PersonForm` con label inglesi letterali e nessun consumatore — `app/Filament/Components/Schema/PersonForm.php:36-76`
- **P2-UI4** `UiBasePolicy` non estende `XotBasePolicy` e non dichiara abilità: prima Resource = aperta — `app/Models/Policies/UiBasePolicy.php`

## Gate

- PHPStan `Modules/UI`: **0 errori** (17:07).
- Pest: skip documentato: DB di test `10.100.200.53:3306` irraggiungibile (TCP chiuso) e `Xot/tests/Support/TestDatabaseGuard.php:63` rifiuta DB non `*_test`; i test con DB restano appesi al connect MySQL (timeout 150 s osservato). Nessun test contro il MySQL locale (dati sacri). Pest va eseguito in ambiente testing non produttivo.
- Security/runtime: story figlie sui finding P1 dell'audit dettagliato.

## Seguito

[epics.md](./epics.md) · [decision-log.md](./decision-log.md) · [story](./stories/module-bmad-audit.story.md) · [ECC](../ecc/ui-ecc-audit.md)

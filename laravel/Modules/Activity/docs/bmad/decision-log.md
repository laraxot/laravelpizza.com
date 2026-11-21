---
title: "Decision log — Activity"
type: decision-log
status: active
updated: 2026-11-16
module: Activity
qmd: "decision log Activity ADR registro append-only redazione login listener migrazioni"
related:
  - ./audits/activity-audit.md
  - ./epics.md
---

# Decision log — Activity

Append-only, più recente in alto. Le voci d'esempio del template precedente (Widget vs Livewire, array una chiave per riga) sono regole di progetto già in `AGENTS.md`, non decisioni del modulo: rimosse.

| ID | Data | Stato | Decisione | Perché | Evidenza |
|---|---|---|---|---|---|
| D-4 | 2026-11-16 | PROPOSTA | Consolidare i due `ActivityLogger` e i due `ActivityRecorderContract` | DRY; l'API non ha caller di produzione | `app/Adapters/`, `app/Actions/ActivityLogger.php`, `app/Contracts/`, `app/Models/Contracts/` |
| D-3 | 2026-11-16 | **APERTA** | `LoginListener`: implementare o rimuovere | Registrato ma vuoto; il login è già tracciato da User (`RecordAuthenticationLogAction`) | `app/Listeners/LoginListener.php:12`, `tests/Unit/Listeners/LoginListenerTest.php:49-55` |
| D-2 | 2026-11-16 | PROPOSTA | Redigere i segreti dentro le Action di logging | Il log non deve contenere `password`/token; la redazione esiste ma non è collegata | `app/Actions/LogModelUpdatedAction.php:43-44`, `app/Actions/RedactModelAttributesAction.php:19` |
| D-1 | 2026-11-16 | PROPOSTA | Resource in sola lettura | Un audit trail modificabile non è prova | `EditActivity.php:18` |
| D-0 | 2026-06-10 | APPROVATA (storica) | Una sola migrazione per `activity_log` (evoluzione = edit + bump timestamp) | Contratto in testa a `2026_06_10_141000_create_activity_table.php` | oggi 5 `create_activity_table` + `fix_causer_id_to_uuid` ancora presenti: non cancellare file già applicati |

## Regole di lettura

- Una decisione `PROPOSTA` diventa `APPROVATA` solo con story BMAD e Pest verde.
- Nuove decisioni: aggiungere una riga in alto; non riscrivere quelle passate, superarle con un riferimento.

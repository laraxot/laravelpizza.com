---
title: "Audit BMAD — Job"
type: audit
status: review
updated: 2026-11-16
module: Job
qmd: "audit BMAD Job sintesi gate P0 policy create payload scheduler non eseguito Livewire legacy widget senza guard"
related:
  - ./audits/job-audit.md
  - ./piano-miglioramento.md
  - ../ecc/job-ecc-audit.md
---

# Audit BMAD — Job

SSoT dettagliata (inventario, evidenze `path:line`, non-finding): [audits/job-audit.md](./audits/job-audit.md).

**Scopo in una frase:** Job rende visibile e governabile ciò che accade fuori dalla richiesta HTTP — code, import, export, pianificazioni — e soprattutto i loro fallimenti ([purpose.md](./purpose.md)).

## Sintesi (2026-11-16)

| Metrica | Valore |
|---|---:|
<<<<<<< .merge_file_tSaiYU
<<<<<<< .merge_file_NEslIX
<<<<<<< .merge_file_fcAgwW
=======
<<<<<<< .merge_file_7pzTBI
>>>>>>> .merge_file_HrvbXN
=======
<<<<<<< .merge_file_7pzTBI
>>>>>>> .merge_file_1m1w4R
=======
<<<<<<< .merge_file_7pzTBI
>>>>>>> .merge_file_qnV0ah
| PHP `app/` | 176 |
| Test | 84 |
| Resources | 9 |
| Actions | 16 |
| Services | 1 |
| Policy `return true` | 5 |
| Marker | 0 |

## Lo scopo in una frase **Job rende visibile e governabile tutto cio' che accade fuori dalla richiesta HTTP: code, importazioni, esportazioni, lavori pianificati — e soprattutto i loro

## Gate

- PHPStan modulo / `Modules`: 0 errori (verifica 2026-11-16).
- Pest: da eseguire in ambiente testing non produttivo.
- Security/runtime: story figlie su finding P0/P1 dell'audit dettagliato.
| PHP `app/` / test PHP / `*Test.php` | 176 / 55 / 49 |
<<<<<<< .merge_file_tSaiYU
<<<<<<< .merge_file_NEslIX
<<<<<<< .merge_file_fcAgwW
=======
=======
| PHP `app/` / test PHP / `*Test.php` | 176 / 55 / 49 (ricontato 2026-11-19: 176 / 56 / 49; la sintesi precedente riportava «Test 84», smentita dal conteggio) |
>>>>>>> .merge_file_1bLDNF
>>>>>>> .merge_file_HrvbXN
=======
=======
| PHP `app/` / test PHP / `*Test.php` | 176 / 55 / 49 (ricontato 2026-11-19: 176 / 56 / 49; la sintesi precedente riportava «Test 84», smentita dal conteggio) |
>>>>>>> .merge_file_1bLDNF
>>>>>>> .merge_file_1m1w4R
=======
=======
| PHP `app/` / test PHP / `*Test.php` | 176 / 55 / 49 (ricontato 2026-11-19: 176 / 56 / 49; la sintesi precedente riportava «Test 84», smentita dal conteggio) |
>>>>>>> .merge_file_1bLDNF
>>>>>>> .merge_file_qnV0ah
| Resource / Widget / Actions / Services | 9 / 8 / 16 / 1 (morto) |
| Policy (su `UserBasePolicy` / `JobBasePolicy`) | 3 / 13 (ricontato 2026-11-19, dopo E1: 0 / 15 + `JobBasePolicy`) |
| Policy `return true` | 5 nella sintesi precedente; oggi 2, solo in `JobBasePolicy::before()` (bypass `super-admin` / `job::admin`) |
| Marker conflitto / `RefreshDatabase` | 0 / 0 |
| `dd()` in `app/` | 1 (`Http/Livewire/Broad.php:41`) |

## Finding principali

| # | Sev | Finding |
|---|---|---|
| 1 | **P0 chiuso (E1)** | Policy deny-default + `JobResource` senza create/edit; vedi [e1 story](./stories/e1-job-policy-create-deny.story.md) |
| 2 | **P0** | Scheduler su DB non eseguito: `registerSchedule` e hook di coda commentati; `ExecuteTaskAction` lancia eccezione; "esegui ora" fallisce |
| 3 | P1 | `Http/Livewire` legacy con `Artisan::call($cmd)` libero e scrittura `.env`; story 12.1 "done" smentita (`Broad` con `dd()` presente) |
| 4 | P1 | 4 widget senza guard (`schedule:run`, loop `queue:listen` nella request) |
| 5 | P1 | Test che chiama `migrate:fresh` su widget reale (`ScheduleStatusWidgetTest.php:14`); 0 `Livewire::test` |
| 6 | P1 | Docs: architettura circolare, purpose troncato, inventario Livewire obsoleto (gap-fill fatto) |
| 7 | P2 | `ScheduleService` morto, 2 coppie di Action duplicate, junk (`.aaa`, `queue.pid`, `.backup`) |

## Gate

- PHPStan `Modules/Job`: **0 errori**.
- Pest: **parziale** — 17 pass (`JobStatusAuthorizationTest`); suite completa non eseguita (macchina con load ≈ 50).
- Gap-fill BMAD completato: [purpose](./purpose.md), [architecture](./architecture.md), [decision-log](./decision-log.md), [epics](./epics.md), [brainstorming](./brainstorming.md).

## Riferimenti

[Piano](./piano-miglioramento.md) · [Epics](./epics.md) · [Decision log](./decision-log.md) · [ECC](../ecc/job-ecc-audit.md) · [Story](./stories/module-bmad-audit.story.md)

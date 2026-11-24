---
title: "E1 — Job policy create deny + JobResource senza create"
type: story
status: review
updated: 2026-11-16
module: Job
bmad: true
qmd: "story E1 JobPolicy FailedJobPolicy JobBatchPolicy deny-default JobResource senza Create Edit payload Livewire allowlist"
related:
  - ../epics.md
  - ../piano-miglioramento.md
  - ../audits/job-audit.md
  - ../decision-log.md
---

# Story: E1 — chiudere P0 policy create + payload

## Contesto

L'audit BMAD ([job-audit](../audits/job-audit.md)) ha trovato `create() = true` su `Job`/`FailedJob`/`JobBatch` e `CreateJob` con campo `payload` sulla tabella consumata dal worker.

## Acceptance

- [x] Tre policy estendono `JobBasePolicy`, deny-default, senza metodi Team (D-5).
- [x] `JobResource::getPages()` senza `create`/`edit` (D-3).
- [x] Pest unit: `create` false per utente senza ruolo; `before` true per `job::admin`/`super-admin`.
- [x] Livewire legacy `Schedule/Status` e `Job/Status`: allowlist a match esatto (mitigazione P1 finché E3 non cancella).
- [x] `ScheduleStatusWidgetTest`: kernel mock `->never()` su `migrate:fresh`.
- [x] PHPStan file toccati = 0.
- [x] Assert puri senza DB (create false + before admin + JobResource senza create/edit + allowlist Livewire).
- [ ] Pest via `Job\\Tests\\TestCase` **skip documentato**: `.env.testing` punta a `10.100.200.53` (hang); ripetere su scratch `127.0.0.1`.

## Task

1. Lock `Job` (`bashscripts/lock/`).
2. Riscrivere le 3 policy; togliere Create/Edit da `JobResource`.
3. Allowlist Livewire + mock kernel nel test widget.
4. Aggiornare epics/decision-log/piano/audit + `docs/sprint-status.yaml`.

## Esito

P0-1 chiuso in codice. P0-2 (scheduler D-2) resta aperto. Livewire non cancellato (E3); solo allowlist.

---
title: "Epics — Job"
type: epics
status: review
updated: 2026-11-16
module: Job
qmd: "epics Job policy create payload scheduler cablare ritirare Livewire legacy widget guard test docs"
related:
  - ./audits/job-audit.md
  - ./piano-miglioramento.md
  - ./epics/livewire.md
  - ./decision-log.md
---

# Epics — Job

Derivate dai finding dell'[audit profondo](./audits/job-audit.md). Storico Livewire: [epics/livewire.md](./epics/livewire.md).
Ogni epic diventa una story BMAD prima di toccare il codice.

## E1 — Autorizzazione di `Job`, `FailedJob`, `JobBatch` (P0-1)

**Perché:** `create()` = true su una tabella che il worker esegue.
**AC:**
- [x] 3 policy su `JobBasePolicy`, senza metodi Team (D-5).
- [x] `JobResource` senza `CreateJob`/`EditJob` in `getPages()` (D-3; classi orfane da rimuovere in cleanup).
- [x] Pest unit deny-default + `before` admin; Feature 403 su `/create` opzionale (rotta rimossa).
- Story: [e1-job-policy-create-deny.story.md](./stories/e1-job-policy-create-deny.story.md).

## E2 — Scheduler: decidere e allineare (P0-2)

**Perché:** la UI promette esecuzioni che non avvengono.
**AC:**
- [ ] D-2 decisa (A cablare / B ritirare) con committente.
- [ ] Se A: `registerSchedule` + hook coda attivi, `ExecuteTaskAction` implementata, Pest su `Schedule` fittizio, nessun doppio `schedule:run`.
- [ ] Se B: `ScheduleResource`, widget Schedule e "esegui ora" rimossi; purpose aggiornato.

## E3 — Ritiro `Http/Livewire` (P1-1, D-4)

**AC:**
- [ ] `Broad`, `Job/Status`, `Schedule/Status`, `Schedule/Crud`, le viste e `_components.json` cancellati.
- [ ] Pest che fallisce se `app/Http/Livewire/*.php` esiste.
- [ ] Story 12.1 riaperta e richiusa con evidenza (`rg 'dd\('` = 0).

## E4 — Guard su tutti i widget operativi (P1-2)

**AC:**
- [ ] `SuperAdminOnlyTrait` su `ScheduleStatusWidget`, `ScheduleCrudWidget`, `ClockWidget`, `QueueListenWidget` (D-1).
- [ ] Loop `sleep(3)` + `queue:listen` rimosso dalla request.
- [ ] Pest `Livewire::test` 403 per utente non super-admin.

## E5 — Test onesti (P1-3)

**AC:**
- [x] `ScheduleStatusWidgetTest.php:14` con kernel mockato (`->never()`).
- [ ] `ScratchA9TmpTest.php` rimosso.
- [ ] Almeno un `Livewire::test` per pagina/widget operativo.

## E6 — Notifica del fallimento a chi ha chiesto il lavoro

**Perché:** [purpose § 1](./purpose.md). **Dipende da** E2 (stesso punto d'aggancio sugli hook di coda). **AC:** a definire in story.

## E7 — Debito P2

- [ ] `ScheduleService` → Action o cancellazione (story `2026-10-08-services-to-actions-job`).
- [ ] 2 coppie di Action duplicate unificate.
- [ ] Junk fuori dall'albero: `.aaa`, `queue.pid`, `.backup*`, `Untitled`, `webpack.mix.js`, `psalm.xml`, `tests/feature`/`tests/unit`.
- [ ] i18n: titoli notifica in file di lingua.
- [ ] 101 `.md` senza frontmatter, 53 nomi non conformi.

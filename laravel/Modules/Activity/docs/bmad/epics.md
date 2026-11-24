---
title: "Epics — Activity"
type: epics
status: review
updated: 2026-11-16
module: Activity
qmd: "epics Activity audit trail append-only redazione PII login listener test ripristino"
related:
  - ./audits/activity-audit.md
  - ./piano-miglioramento.md
  - ./epics/module-roadmap.md
  - ./stories/module-bmad-audit.story.md
---

# Epics — Activity

Derivate dai finding dell'[audit profondo](./audits/activity-audit.md). Roadmap storica: [epics/module-roadmap.md](./epics/module-roadmap.md).
Ogni epic diventa una story BMAD prima di toccare il codice.

## E1 — Registro append-only (P1-2)

**Perché:** un audit trail modificabile non è prova.
**AC:**
- [ ] `ActivityResource`, `SnapshotResource`, `StoredEventResource` senza Create/Edit/Delete da UI.
- [ ] Cancellazione solo via `ActivityMaintenanceAction` con permesso dedicato.
- [ ] Pest Feature: utente con `activity.update` riceve 403 sull'edit.

## E2 — Nessun segreto nel log (P1-3)

**Perché:** il log vive più a lungo del dato e ha lettori diversi.
**AC:**
- [ ] `RedactModelAttributesAction` chiamata da `LogModelCreated/Updated/DeletedAction`.
- [ ] Lista chiavi sensibili estesa e testata con modello `User`.

## E3 — Login/logout simmetrici (P1-1)

**Perché:** `LogoutListener` registra, `LoginListener` no.
**AC:**
- [ ] Decisione D-3 applicata: listener implementato (delega a `LogUserLoginAction`) **oppure** rimosso con i 7 test skip.
- [ ] Nessun doppio log con `Modules\User\Listeners\LoginListener`.

## E4 — Test onesti (P1-4, P1-5)

**Perché:** un test vuoto è verde e non verifica nulla.
**AC:**
- [ ] 8 file vuoti ripristinati da `7cf6bc58` e riallineati; 0 file senza casi.
- [ ] 19 skip: ognuno implementato o cancellato con motivazione.
- [ ] Almeno un Pest `Livewire::test`/`actingAs` per LogViewer, restore e le 3 Resource (403 senza permesso).

## E5 — Debito P2

- [ ] Policy: `activity::admin` ottiene il bypass (policy → `ActivityBasePolicy`) oppure l'ADR viene annotato come non applicabile.
- [ ] Un solo `ActivityRecorderContract`, un solo `ActivityLogger`; rimuovere `Adapters/*` se senza caller.
- [ ] `TestModel` e migration `create_test_models_table` fuori dal percorso di produzione.
- [ ] Migrazioni: nessuna cancellazione di file già applicati; `_bak/` fuori dall'albero.
- [ ] 8 `.md` e 4 `*.code-workspace` fuori dalla root del modulo; frontmatter sui 331 `.md` mancanti.

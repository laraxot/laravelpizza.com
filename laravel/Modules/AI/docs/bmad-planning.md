---
title: "BMAD Planning — AI"
type: bmad-planning
status: active
module: AI
track: bmad-method
created: 2026-10-16
updated: 2026-10-16
tags: [bmad, planning, second-brain, filament-blueprint, ai]
qmd: "bmad planning ai scopo onde filament"
related:
  - ./bmad/bmad-dossier.md
  - ./bmad/livewire-widget-project-context.md
  - ./bmad-brainstorming.md
  - ./bmad/filament-blueprint.md
---

# Obiettivo

Assistere i maintainer con thread LLM, proposte e tool senza mutare silenziosamente i dati civici.

## Perché questo owner

- **Utenti:** maintainer, supervisor, operatore autorizzato
- **Track BMAD:** `bmad-method`
- **Religione:** Actions + Folio/Volt/Filament `XotBase*`; mai Controllers; docs solo in questo `docs/` (mai `bmad-output/`).

## Scope

### In
- provider contract via Actions
- proposal review in Filament
- redaction/cost limits
- audit trail

### Out
- mutazione autonoma Ticket
- bypass policy tenant
- prompt con dati personali non redatti

## Onde di delivery

| Wave | Deliverable | Owner |
|---|---|---|
| 1 | Contratto provider + refusal sicuro | AI |
| 2 | Review proposte in Filament | AI |
| 3 | Usage/cost audit e rate limit | AI + Job |

## Filament blueprint

Resource/widget di competenza:

- AiActionProposalResource

Dettaglio contratto: [filament-blueprint.md](./bmad/filament-blueprint.md).

## Second brain

- Costituzione sintetica: questo file + brainstorming gemello.
- Decisioni durature -> `docs/bmad/decision-log.md` (o dossier topic se gia esiste).
- QMD: indicizzare titoli/qmd; ownership resta nel modulo/tema.

## Definition of Done (planning)

- [ ] Scope in/out condiviso e non contraddetto dal codice owner
- [ ] Onde senza dipendenze circolari cross-owner
- [ ] Blueprint Filament aggiornato (o esplicitamente N/A)
- [ ] Link bidirezionali ai dossier/topic gia esistenti
- [ ] Nessun artefatto in `bmad-output/`

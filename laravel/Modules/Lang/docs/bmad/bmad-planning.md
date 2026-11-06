---
title: "BMAD Planning: Lang"
type: bmad-planning
status: active
module: Lang
track: quick-flow
created: 2026-10-16
updated: 2026-10-16
tags: [bmad, planning, second-brain, filament-blueprint, lang]
qmd: "bmad planning lang scopo onde filament"
related:
  - ./bmad/bmad-dossier.md
  - ./bmad/brainstorming.md
  - ./bmad-brainstorming.md
  - ./bmad/filament-blueprint.md
---

# Obiettivo

Garantire risoluzione locale e ownership delle traduzioni coerenti tra moduli e temi.

## Perché questo owner

- **Utenti:** editor lingue, developer, guest multilingua
- **Track BMAD:** `quick-flow`
- **Religione:** Actions + Folio/Volt/Filament `XotBase*`; mai Controllers; docs solo in questo `docs/` (mai `bmad-output/`).

## Scope

### In
- locale fallback
- TranslationFile resource
- chiavi owned dal componente

### Out
- stringhe hardcoded nei moduli
- tradurre significato legale Gdpr automaticamente

## Onde di delivery

| Wave | Deliverable | Owner |
|---|---|---|
| 1 | Fallback locale esplicito | Lang |
| 2 | Gate chiavi grezze FO | Lang + Sixteen |
| 3 | Override tenant evidence | Lang + Tenant |

## Filament blueprint

Resource/widget di competenza:

- TranslationFileResource

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

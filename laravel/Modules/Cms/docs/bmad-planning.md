---
title: "BMAD Planning — Cms"
type: bmad-planning
status: active
module: Cms
track: bmad-method
created: 2026-10-16
updated: 2026-10-16
tags: [bmad, planning, second-brain, filament-blueprint, cms]
qmd: "bmad planning cms scopo onde filament"
related:
  - ./bmad/bmad-dossier.md
  - ./bmad-brainstorming.md
  - ./bmad/filament-blueprint.md
---

# Obiettivo

Far gestire a ogni comune pagine, menu, blocchi e contenuti di servizio localizzati.

## Perché questo owner

- **Utenti:** editor CMS, guest, tenant admin
- **Track BMAD:** `bmad-method`
- **Religione:** Actions + Folio/Volt/Filament `XotBase*`; mai Controllers; docs solo in questo `docs/` (mai `bmad-output/`).

## Scope

### In
- authoring Page/Section/Menu
- preview/publish
- locale fallback
- cache invalidation

### Out
- logica Ticket
- theme ownership delle view Folio

## Onde di delivery

| Wave | Deliverable | Owner |
|---|---|---|
| 1 | Contratto blocchi header/footer/home | Cms + Sixteen |
| 2 | Preview/publish + cache | Cms |
| 3 | Isolamento tenant evidence | Cms + Tenant |

## Filament blueprint

Resource/widget di competenza:

- PageResource
- SectionResource
- MenuResource

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

## Iniziativa: Head Cms per Sixteen

Il Cms possiede il renderer Head e le policy SEO condivise; Sixteen passa contesto semantico e mantiene solo markup e comportamento visuale propri. Il piano specifico e' [head-component-adoption-plan.md](./bmad/head-component-adoption-plan.md), coordinato con la [readiness Sixteen](../../../Themes/Sixteen/docs/bmad/front-office-production-readiness-plan.md).

- Decisioni PO registrate: D-1…D-6 nella [story Head](./stories/head-sixteen-layout-migration.story.md) e nella [discussion #93](https://github.com/laraxot/theme_sixteen_fila5/discussions/93).
- D-7 resta aperta: comportamento canonical/hreflang sulle pagine `noindex`; non dichiarare chiusa la parita' finche' il PO non decide.
- Filament Blueprint: nessun Resource Head nuovo; restano validi i contratti Page/Section/Menu.
- Le story esistenti sono in corso e restano la traccia esecutiva: [migrazione](./stories/head-sixteen-layout-migration.story.md) e [chiusura parita'](./stories/head-sixteen-parity-closeout.story.md). Nessuna story duplicata.

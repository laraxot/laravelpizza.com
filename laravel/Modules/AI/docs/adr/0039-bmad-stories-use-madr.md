---
status: accepted
date: 2026-11-25
decision-makers:
  - Xot
title: "BMAD stories use MADR (same spirit as harness ADR template)"
type: decision
module: Xot
qmd: "ADR 0039 BMAD stories MADR template 0000-template.story migrate on touch"
note: "Filename clause (kebab-only / no NNNN) superseded by 0040 — body MADR rules remain."
superseded_by_filename: ./0040-bmad-stories-numbered-filenames.md
related:
  - ../bmad/stories/0000-template.story.md
  - ../bmad/stories/bmad-stories-madr-format.story.md
  - ./0000-template.md
  - ./0040-bmad-stories-numbered-filenames.md
  - ../../../../../bashscripts/ai/wiki/memories/bmad-stories-madr-format.md
---

# BMAD stories use MADR (same spirit as harness ADR template)

## Context and Problem Statement

BMAD stories across modules used ad-hoc shapes (Fact-gate / Fix / Verifica, free
Italian prose, numbered epic prefixes). Agents and humans could not skim a
story the same way they skim an ADR. How do we make every new or edited BMAD
story share one scannable decision format without inventing a second docs tree?

## Decision Drivers

- Same MADR spirit as the harness ADR template (Context → Drivers → Options →
  Outcome → Consequences → Confirmation)
- Stories stay under existing `docs/bmad/stories/` (or `docs/stories/`) — no new
  folders
- Body shape must match harness MADR (filename policy later split to 0040)
- Legacy debt migrates on touch (boy-scout), not a big-bang rewrite
- Fact-gate / Fix / Pest map cleanly into MADR + BMAD extensions

## Considered Options

- Keep free-form story markdown per author
- Invent a BMAD-only schema unrelated to MADR
- Require `NNNN-` prefixes on every story (like ADR) — **body decision deferred;
  filename decided in [0040](0040-bmad-stories-numbered-filenames.md)**
- **Adopt MADR English section order for stories, with BMAD extensions after
  Confirmation, SSoT in Xot `0000-template.story.md`**

## Decision Outcome

Chosen: **Adopt MADR English section order for all new/edited BMAD stories**,
because it reuses the harness mental model agents already know for ADR and lives
in the existing Xot `docs/bmad/` tree.

Rules:

1. Every **new** or **edited** story under `Modules/*/docs/bmad/stories/` or
   `Modules/*/docs/stories/` (and theme equivalents) must follow
   [0000-template.story.md](../bmad/stories/0000-template.story.md).
2. Required body sections (English headings): Context and Problem Statement,
   Decision Drivers, Considered Options, Decision Outcome, Consequences,
   Confirmation; then BMAD extensions Acceptance Criteria and Esito.
3. **Legacy:** migrate to this template when the file is touched; no mandatory
   fleet rewrite.
4. **Filename (superseded):** the kebab-only / no-`NNNN` rule that lived here is
   **superseded by [0040](0040-bmad-stories-numbered-filenames.md)** —
   basenames must be `NNNN-slug.story.md` (exception `0000-template.story.md`).
5. ADR basename rules (`NNNN-slug.md`) are unchanged — see
   [0000-template.md](./0000-template.md) and memory
   `adr-numbered-madr-template`.

### Consequences

- Good, because stories and ADR share one decision-reading grammar; Fact-gate
  maps to Context+Drivers, Fix to Decision Outcome, Pest to Confirmation/Esito.
- Good, because SSoT is a single template under Xot BMAD — modules link, do not
  fork.
- Bad, because editing a legacy story costs a format pass before the functional
  change.
- Bad, because English headings may feel heavy next to Italian prose elsewhere;
  keep UI/lang Italian, keep MADR headings English for grep stability.

### Confirmation

- New/edited stories contain the six MADR headings plus Acceptance Criteria and
  Esito.
- `docs/sprint-status.yaml` key for the work points at a MADR-shaped story.
- Review: reject story-only work that invents a parallel template outside
  `0000-template.story.md`.

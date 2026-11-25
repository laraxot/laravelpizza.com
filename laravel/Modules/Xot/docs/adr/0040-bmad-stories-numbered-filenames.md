---
status: accepted
date: 2026-11-25
decision-makers:
  - Xot
title: "BMAD stories use numbered filenames (NNNN-slug.story.md)"
type: decision
module: Xot
qmd: "ADR 0040 BMAD story basename NNNN-slug.story.md per-module sequence 0000-template exception supersedes 0039 filename"
related:
  - ./0039-bmad-stories-use-madr.md
  - ../bmad/stories/0000-template.story.md
  - ../bmad/stories/0044-bmad-stories-numbered-filenames.story.md
  - ./0000-template.md
  - ../../../../../bashscripts/ai/wiki/memories/bmad-stories-madr-format.md
  - ../../../../../bashscripts/ai/wiki/memories/adr-numbered-madr-template.md
---

# BMAD stories use numbered filenames (NNNN-slug.story.md)

## Context and Problem Statement

ADR [0039](0039-bmad-stories-use-madr.md) fixed the **body** of BMAD stories to MADR,
but left basenames as free kebab `slug.story.md`. Story IDs mixed epic prefixes
(`5.255-…`), dates, and unsortable slugs, so agents could not cite or order
stories the way they cite ADR `NNNN`. How do we make every BMAD story basename
as scannable and citeable as an ADR without inventing a second docs tree?

## Decision Drivers

- Same spirit as ADR harness: `NNNN-titolo-con-trattini.md` → stories
  `NNNN-titolo-con-trattini.story.md`
- Stable numeric ID per owning module (or theme) sequence — not a global monorepo
  counter
- Keep MADR body rules from 0039; only the **filename clause** of 0039 changes
- Legacy debt migrates on touch / renamer pass, not a silent rewrite of history
  mid-edit
- Template exception must remain discoverable as `0000-template.story.md`

## Considered Options

- Keep kebab-only `slug.story.md` (0039 filename rule)
- Global monorepo-wide story numbers across all modules
- Reuse epic/dot prefixes (`5.255-…`) as the only scheme
- **Require `/^\d{4}-[a-z0-9]+(?:-[a-z0-9]+)*\.story\.md$/` per module, exception
  `0000-template.story.md`**

## Decision Outcome

Chosen: **every BMAD story basename MUST be `NNNN-titolo-con-trattini.story.md`
and match `/^\d{4}-[a-z0-9]+(?:-[a-z0-9]+)*\.story\.md$/`**, because it mirrors
ADR `NNNN-slug.md`, gives a stable citeable ID, and scopes sequencing to the
owner module/theme folder.

Rules:

1. **New** stories under `Modules/*/docs/bmad/stories/`, `Modules/*/docs/stories/`,
   theme equivalents, and optionally root `docs/stories/` / `docs/bmad/`: next
   free `NNNN` in **that** folder (zero-padded 4 digits), then kebab slug,
   suffix `.story.md`.
2. Regex (full basename): `^\d{4}-[a-z0-9]+(?:-[a-z0-9]+)*\.story\.md$`.
3. **Exception:** `0000-template.story.md` (and module copies of that template
   name only). No other `0000-*.story.md` for work items.
4. **Legacy:** fleet renamer (2026-11-25) assigned `NNNN` to existing debt;
   new work must never invent kebab-only `slug.story.md`.
5. Body format remains MADR per [0039](0039-bmad-stories-use-madr.md) and
   [0000-template.story.md](../bmad/stories/0000-template.story.md).
6. This ADR **supersedes the filename clause** of 0039 (kebab-only / no `NNNN`).
   0039 remains accepted for MADR section order.

### Consequences

- Good, because stories and ADR share one naming grammar; sprint keys can cite
  `Module/NNNN-slug` predictably.
- Good, because per-module sequences avoid cross-module number fights.
- Bad, because agents must look up the next free `NNNN` in the owner folder
  before creating a story.

### Confirmation

- Pest `BmadStoriesAreMadrFormatTest` asserts every `*.story.md` basename matches
  the regex (or is exactly `0000-template.story.md`) under Modules/Themes story
  dirs and root `docs/stories` + `docs/bmad`.
- Template comments and memory `bmad-stories-madr-format` require
  `NNNN-titolo-con-trattini.story.md`.
- Review: reject new work that invents free kebab-only story filenames.

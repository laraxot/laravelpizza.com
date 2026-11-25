---
title: "<!-- short problem + chosen outcome -->"
status: proposed # proposed | in-progress | review | done | superseded
date: YYYY-MM-DD
module: <!-- Owner module, e.g. Xot -->
epic: # optional
decision-makers: # optional list
related:
  - # relative links to ADR, contracts, sibling stories
qmd: "bmad story template MADR <!-- keywords -->"
---

<!-- File MUST be: docs/bmad/stories/NNNN-titolo-con-trattini.story.md
     (also docs/stories/NNNN-titolo-con-trattini.story.md).
     Basename MUST match /^\d{4}-[a-z0-9]+(?:-[a-z0-9]+)*\.story\.md$/
     — 4-digit zero-padded NNNN + kebab slug + suffix `.story.md`
     (same spirit as ADR NNNN-titolo-con-trattini.md). Per-module sequence.
     Exception: this template only — `0000-template.story.md`.
     SSoT filename ADR: ../../adr/0040-bmad-stories-numbered-filenames.md
     Body MADR ADR: ../../adr/0039-bmad-stories-use-madr.md
     Pest gate: Modules/Xot/tests/Unit/Docs/BmadStoriesAreMadrFormatTest.php
     Inspiration (ADR MADR harness):
     https://raw.githubusercontent.com/robertogallea/laravelday-harness-workshop/refs/heads/main/docs/adr/0000-template.md
     Local ADR twin: ../../adr/0000-template.md
     Mapping from older BMAD shapes:
     - Fact-gate → Context and Problem Statement + Decision Drivers
     - Fix / Decision → Decision Outcome
     - Pest / verification → Confirmation + Esito -->

# <!-- Title: the problem solved and the outcome chosen -->

## Context and Problem Statement

<!-- 2–3 sentences. End with the question this story answers. -->

## Decision Drivers

- <!-- force or constraint that weighs on the choice -->

## Considered Options

- <!-- option 1 -->
- <!-- option 2 -->

## Decision Outcome

Chosen: **<!-- option -->**, because <!-- driver that justifies it -->.

### Consequences

- Good, because <!-- … -->
- Bad, because <!-- … -->

### Confirmation

<!-- How we know the work respects the decision: Pest filter, PHPStan scope,
     review checklist, or documented skip (e.g. host 10.100.200.15). -->

## Acceptance Criteria

- [ ] <!-- observable AC 1 -->
- [ ] <!-- observable AC 2 -->
- [ ] Sprint key `Module/slug` updated in `docs/sprint-status.yaml`

## Esito

<!-- Fill when status → done. Example:
Pest: N passed (A assertions) / skip reason if any
PHPStan: Modules/<Mod> OK | not applicable (docs-only)
Sprint: Module/slug → done
-->

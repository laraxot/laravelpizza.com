---
id: "ui-root-hygiene-conflict-markers"
title: "UI: README/contributing marker + md uppercase in root"
status: review
scope: module:UI
created: 2026-09-22
updated: 2026-09-22
qmd: "ui readme contributing nested conflict markers architecture testing philosophy root hygiene"
related:
  - ../livewire-inventory.md
  - ../../architecture.md
  - ../../../../Xot/docs/bmad/stories/cleanup-all-modules.story.md
type: story
tags: [docs, ui, bmad]
---

# UI: marker nidificati in README + igiene root

**Perché.** `git status` pulito, HEAD con 20 hunk `<<<<<<<` in `README.md` (anche nidificati: theirs iniziava con `<<<<<<< HEAD`) e contributing duplicato. Root teneva `ARCHITECTURE.md`/`TESTING.md`/`PHILOSOPHY.md` (SSoT è `docs/architecture.md`, kebab).

## Scelta

Innermost-first strip; tenere frontmatter HEAD; footer project-agnostic (niente FixCity). Contributing: un solo PSR-12. Delete root uppercase md.

## Gate

PHPStan `Modules/UI`: 0. Commit deferred.
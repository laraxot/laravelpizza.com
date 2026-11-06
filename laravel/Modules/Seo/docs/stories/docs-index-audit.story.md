---
title: "docs index audit.story"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "docs index audit.story"
issues: []
discussions: []
---

# Story: docs index audit — Seo

**Phase**: BMAD Build (docs-only maintenance).
**Scope**: Audit and rebuild `Modules/Seo/docs/index.md` as a topic-organized master index covering all 193 `.md` files under `docs/`. No file renamed, moved, or deleted.
**Result**: New `docs/index.md` links every file directly or via the "Storico / da consolidare" section, split into duplicate content, `module: theme` stub pointers to Themes, and test/sync tooling artifacts (all previously existing, none newly created here).
**Verification**: `find docs -name "*.md" | wc -l` (193) matches the count of unique `(./...md)` links extracted from `index.md` (193, self-reference excluded) — confirmed via `comm` diff, zero files missing.
**Follow-up (not done here)**: actual consolidation of the flagged duplicate/stub clusters is a separate task; this story only documents and indexes them.

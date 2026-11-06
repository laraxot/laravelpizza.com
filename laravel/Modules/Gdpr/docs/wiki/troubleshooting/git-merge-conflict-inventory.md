---
title: "git merge conflict inventory"
type: note
tags: [documentation]
created: 2026-04-28
updated: 2026-10-28
qmd: "git merge conflict inventory"
issues: []
discussions: []
status: draft
---

# Git Conflict Inventory

- Owner: Modules/Gdpr
- Files with conflict markers: 1 (rilevati il 2026-04-28; la data e' in `created`)

## Files

- docs/wiki/README.md

## Notes

- Inventory generated from `rg -l "^(<<<<<<<|=======|>>>>>>>)"`.
- Use this list as a volatile coordination map; re-open each file before editing because other agents may resolve items in parallel.
- Il file era presente due volte (`git-merge-conflict-inventory-2026-04-28.md` con la data nel nome e questo, stesso corpo): unificati in questo nome, senza data (regola `docs/wiki/rules/md-filenames-no-dates-no-numeric-suffix.md`).
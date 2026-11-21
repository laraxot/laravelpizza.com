---
issues: []
discussions: []
title: "Git Conflict Inventory"
module: "Tenant"
type: concept
tags: [git, merge, conflict, inventory]
created: 2026-07-14
updated: 2026-07-14
qmd: "git merge conflict inventory"
related:
  - "./phpstan-corrections-january.md"
---
# Git Conflict Inventory

- Date: 2026-04-28
- Owner: Modules/Tenant
- Files with conflict markers: 1

## Files

- docs/wiki/README.md

## Notes

- Inventory generated from `rg -l "^(<<<<<<<|=======|>>>>>>>)"`.
- Use this list as a volatile coordination map; re-open each file before editing because other agents may resolve items in parallel.
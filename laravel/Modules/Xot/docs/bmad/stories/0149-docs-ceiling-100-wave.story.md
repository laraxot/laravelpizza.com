---
type: story
status: done
module: Xot
story_id: "0149-docs-ceiling-100-wave"
title: "Docs ceiling ≤100 su moduli/temi + protect manuals/"
updated: 2026-11-25
qmd: "docs ceiling 100 manuals protect rm patch"
---

# Story 0149 — docs ceiling wave

## Esito

| Owner | md |
|---|---|
| Notify | 2448 → 100 |
| User, Rating, AI, Cms, Activity, Xot, Meetup, ThemeMeetup | tutti ≤100 |

Backup Notify: `~/backups/docs-ceiling-20261125/notify-docs.tgz`.

## Bugfix tool

`docs-ceiling-100.py` `rm()` salta `manuals/`, `00-index.md`, keep-names.

## Verifica

PHPStan Modules 0; manuals presenti; Rating git slim 532 ogg.

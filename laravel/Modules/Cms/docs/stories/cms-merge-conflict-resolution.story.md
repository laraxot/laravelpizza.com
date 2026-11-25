---
title: "cms merge conflict resolution.story"
type: note
tags: [documentation, coordinamento]
created: 2026-09-26
updated: 2026-11-23
qmd: "cms merge conflict resolution.story"
issues: []
discussions: []
---

# Story: Cms module merge conflict resolution + phpstan

Status: docs-markers-done (PHP/test conflicts: vedi anche `6.1.resolve-git-conflicts-and-phpstan.story.md`)
Module: Modules/Cms

## Coordinamento 2026-11-23 — docs markers

- Scope: `laravel/Modules/Cms/docs` — zero marker di merge nei `.md`.
- Puliti **58** file con conflitti annidati (`.merge_file_*`); preferenza link lowercase; FO layout invariato: sempre `@filamentStyles` / `@filamentScripts` (NO `panelAssets`) — contratto in [filament-layout-styles-scripts.md](../bmad/filament-layout-styles-scripts.md).
- Verifica: grep sui tre token di merge (start/mid/end) in `Cms/docs/**/*.md` → **0**.
- Nota operativa: [merge-conflict-marker-cleanup.md](../merge-conflict-marker-cleanup.md).

## Contesto storico

6 file PHP/test in conflitto con laraxot/dev (DownloadAttachmentPlaceHolder, PublicProfileRouteTest, HeaderNavJsonTest, HomepageContentManagementTest). Gate qualità separato dalla sweep docs.

## Accept Criteria

- [x] Marker merge assenti in `docs/**/*.md`
- [ ] PHPStan 0 / Pest / push — fuori scope di questa sweep docs
Status: in-progress
Module: Modules/Cms (independent .git)
Context: 6 files modified; merge conflict with laraxot/dev on: DownloadAttachmentPlaceHolder.php, PublicProfileRouteTest.php, HeaderNavJsonTest.php, HomepageContentManagementTest.php. Resolve conflicts keeping both modifications, then full quality gate.
Dependencies: None (already merged from remote)
Accept Criteria: Merge conflict resolved; PHPStan 0 errors; PHPMD clean; phpinsights passes; pest passes; docs/ updated; git push -u origin dev done.
Owner: AI Agent (BMAD sprint)

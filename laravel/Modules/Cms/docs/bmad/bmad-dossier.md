---
title: "Cms — BMAD dossier"
type: bmad-dossier
module: Cms
updated: 2026-10-07
tags: [bmad, cms, folio, content]
qmd: "Cms module product brief PRD architecture UX security epics gaps release"
issues: ["https://github.com/laraxot/base_fixcity_fila5/issues/383"]
discussions: ["https://github.com/laraxot/base_fixcity_fila5/discussions/392"]
---
# Cms — BMAD dossier
## Product brief / PRD
Let each municipality manage pages, menus, blocks and localized service/privacy content.
## Architecture / UX / security
Cms owns authoring/publication; Folio themes render data; tenant, role and cache boundaries are enforced.
## Epics and stories
Authoring; preview/publish; locale fallback/cache invalidation. Stories cover missing content and stale cache recovery.
## Gaps / release
Preview permissions, cache invalidation and tenant isolation require candidate evidence. Release requires approved localized content with no raw keys.

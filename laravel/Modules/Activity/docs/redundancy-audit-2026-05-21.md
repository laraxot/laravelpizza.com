---
title: "Activity redundancy audit 2026-05-21"
type: audit
module: Activity
tags: [redundancy, duplicate-code, docs]
created: 2026-05-21
related:
  - https://github.com/laraxot/base_fixcity_fila5/issues/89
---

# Activity redundancy audit 2026-05-21

Static metrics: 996 files scanned, 28 case-only groups, 64 duplicate hash groups, 0 duplicate FQCN.

Findings:
- Large docs duplication cluster: query optimization, PHPMD, MCP server recommendations, best practices, and use-case docs have case-only and archive variants.
- Several docs under `docs/archive/` duplicate active docs.
- Root-level scratch docs such as `test.md`, `test02.md`, `documentation.md`, and dated variants share empty or boilerplate content.
- Tests contain case-only variants such as `PlaceTest.test`/`placetest.test` and `ComuneTest.php`/`comunetest.php`.

Risk:
- Documentation search returns obsolete archive/scratch files before canonical docs.
- Case-only tests can behave differently across filesystems.

Suggested cleanup order:
1. Create a canonical docs index for active Activity docs.
2. Move or remove `docs/archive` duplicates under a dedicated docs cleanup issue.
3. Normalize test filenames to PSR/test naming in one atomic code cleanup.

Evidence commands:
- Per-owner static scan for case-only paths, byte-identical files, and duplicate FQCN.
- GitHub tracker: issue #89.

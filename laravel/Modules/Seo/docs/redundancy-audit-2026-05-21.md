---
title: "Seo redundancy audit 2026-05-21"
type: audit
module: Seo
tags: [redundancy, duplicate-code, docs]
created: 2026-05-21
related:
  - https://github.com/laraxot/base_fixcity_fila5/issues/89
---

# Seo redundancy audit 2026-05-21

Static metrics: 295 files scanned, 7 case-only groups, 21 duplicate hash groups, 0 duplicate FQCN.

Findings:
- Case-only docs: duplicate method-analysis, MCP recommendations, index, PRD, roadmap/sprint planning files.
- Multiple MCP recommendation variants exist with dash, underscore, uppercase, and Italian/English names.
- Root scratch files `test.md` and `test-bb.md` duplicate empty frontend boilerplate.

Risk:
- SEO docs are noisy and can route agents to stale MCP/setup advice.
- Scratch files at module root should not be treated as active docs.

Suggested cleanup order:
1. Keep one MCP recommendation doc and one PRD/index path.
2. Move or remove root scratch docs under a docs cleanup issue.
3. Update any local docs index after filename normalization.

Evidence commands:
- Per-owner static scan for case-only paths, byte-identical files, and duplicate FQCN.
- GitHub tracker: issue #89.

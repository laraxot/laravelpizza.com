---
title: "AI redundancy audit 2026-05-21"
type: audit
module: AI
tags: [redundancy, duplicate-code, docs]
created: 2026-05-21
related:
  - https://github.com/laraxot/base_fixcity_fila5/issues/89
---

# AI redundancy audit 2026-05-21

Static metrics: 302 files scanned, 3 case-only groups, 24 duplicate hash groups, 0 duplicate FQCN.

Findings:
- Case-only docs: `INDEX.md`/`index.md`, `PRD.md`/`prd.md`, `ROADMAP.md`/`roadmap.md`.
- Duplicate docs by dash/underscore variants: `create_an_assistant.md`/`create-an-assistant.md`, `google-gemini.md`/`google_gemini.md`, `fine_tuning.md`/`fine-tuning.md`, `video-tutorial.md`/`video_tutorial.md`.
- MCP docs contain numbered dash/underscore variants such as `11-aggiornamenti.md` and `11_aggiornamenti.md`.

Risk:
- Agents and QMD can retrieve stale duplicates depending on filename convention.
- Case-only names are fragile on WSL and case-insensitive filesystems.

Suggested cleanup order:
1. Keep lowercase-kebab-case docs as canonical.
2. Replace underscore/case variants with links or remove in a docs-only cleanup issue.
3. Update local docs indexes after consolidation.

Evidence commands:
- Per-owner static scan for case-only paths, byte-identical files, and duplicate FQCN.
- GitHub tracker: issue #89.

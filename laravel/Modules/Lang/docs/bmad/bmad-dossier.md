---
title: "Lang — BMAD dossier"
type: bmad-dossier
module: Lang
updated: 2026-10-07
tags: [bmad, lang, i18n]
qmd: "Lang module product brief PRD architecture UX security epics gaps release"
issues: ["https://github.com/laraxot/base_fixcity_fila5/issues/383"]
discussions: ["https://github.com/laraxot/base_fixcity_fila5/discussions/392"]
---
# Lang — BMAD dossier
## Product brief / PRD
Provide consistent locale resolution and translation ownership across modules/themes.
## Architecture / UX / security
Locale fallback and tenant overrides are explicit; module/theme keys remain owned by their component.
## Epics and stories
Locale lifecycle; missing-key audit; translation administration/cache.
## Gaps / release
Supported locale inventory, override precedence and missing-key automation require closure; critical flows must show no raw keys.

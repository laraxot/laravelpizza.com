---
title: "AI — BMAD dossier"
type: bmad-dossier
module: AI
updated: 2026-10-07
tags: [bmad, ai, llm, safety]
qmd: "AI module product brief PRD architecture UX security epics gaps release"
issues: ["https://github.com/laraxot/base_fixcity_fila5/issues/383"]
discussions: ["https://github.com/laraxot/base_fixcity_fila5/discussions/392"]
---
# AI — BMAD dossier
## Product brief / PRD
LLM threads, proposals and tools assist maintainers without silently mutating civic data.
## Architecture / UX / security
Actions own provider calls; tenant/user policy, prompt redaction, cost limits and reviewable output are mandatory.
## Epics and stories
Provider contract; proposal review; usage/cost audit. Stories must test provider outage and unsafe tool refusal.
## Gaps / release
Missing candidate evidence for fallback, redaction, rate limits and deterministic provider doubles. Release requires zero autonomous ticket mutation and an audit trail.

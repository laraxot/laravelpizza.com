---
tags: [documentation]
qmd: "root md max5 verify.story"
issues: []
discussions: []
title: "Verifica e correzione max 5 .md in root modulo ($MODULO)"
type: story
module: $MODULO
epic: 5
story_id: "5.126"
slug: root-md-max5-verify
status: ready-for-dev
created: 2026-09-22
updated: 2026-09-22
---

# 5.126 — Verifica e correzione max 5 .md in root modulo ($MODULO)

## Story

Nelle root dei moduli ci devono stare al massimo 5 file .md (README.md, CHANGELOG.md, LICENSE.md, AGENTS.md, CLAUDE.md). I file .md extra vanno spostati in docs/ con naming standard. I duplicati di sola maiuscola vanno rimossi.

## Acceptance Criteria

1. Max 5 file .md in root modulo
2. Solo quelli ammessi presenti in root
3. Contenuto dei file spostati conservato (merged se gemello in docs/)
4. Gate verify-module-root-hygiene.sh passa

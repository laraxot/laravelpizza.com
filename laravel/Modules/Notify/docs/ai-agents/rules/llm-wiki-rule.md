---
title: "llm wiki rule"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "llm wiki rule"
issues: []
discussions: []
name: llm-wiki rule
description: Ensure every module and theme includes a `docs/wiki/` directory and related llm‑wiki scaffolding.
status: draft
---

# LLM‑Wiki Rule

**Rule:** All modules and themes must contain a `docs/wiki/` directory (with compiled wiki pages) and the corresponding `llm‑wiki` scaffolding (templates, AGENTS.md, etc.).
**Rule:** All modules and themes must contain a `docs/wiki/` directory (with compiled wiki pages) and the corresponding `llm‑wiki` scaffolding (templates, agents.md, etc.).

**Why:** The LLM‑wiki is the unified documentation source; missing folders break the wiki build and QMD indexing.

**How to apply:** When creating a new module or theme, add the `docs/wiki/` folder (including `index.md`, `log.md`, and any overview files) and the `docs/llm-wiki/` support files before committing.

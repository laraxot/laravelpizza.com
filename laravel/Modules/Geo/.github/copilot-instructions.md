---
title: "copilot instructions"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "copilot instructions"
issues: []
discussions: []
---

# Instructions for GSD

- Use the get-shit-done skill when the user asks for GSD or uses a `gsd-*` command.
- Treat `/gsd-...` or `gsd-...` as command invocations and load the matching file from `.github/skills/gsd-*`.
- When a command says to spawn a subagent, prefer a matching custom agent from `.github/agents`.
- Do not apply GSD workflows unless the user explicitly asks for them.
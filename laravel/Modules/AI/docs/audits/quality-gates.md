---
title: "AI quality gate audit 2026-11-05"
type: audit
module: AI
---

# AI quality gate audit

The tenant-default test must skip through PHPUnit's supported API. This keeps
the test behavior while making the static-analysis contract explicit.

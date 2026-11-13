---
title: "Cms quality gate audit 2026-11-05"
type: audit
module: Cms
---

# Cms quality gate audit

Theme discovery must use the safe filesystem API so a failed directory read
cannot be mistaken for an iterable result.

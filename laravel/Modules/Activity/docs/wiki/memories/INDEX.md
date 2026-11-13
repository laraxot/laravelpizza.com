---
title: "Activity Memories Index"
type: index
module: Activity
tags: [activity, memories, testcase, xotbase]
created: 2026-06-10
updated: 2026-06-10
qmd: "Activity memories testcase xotbasetestcase nwidart missing base"
issues:
  - "https://github.com/laraxot/base_ptv_fila5/issues/316"
  - "https://github.com/laraxot/module_xot_fila5/issues/33"
discussions:
  - "https://github.com/laraxot/base_ptv_fila5/discussions/316"
  - "https://github.com/laraxot/module_xot_fila5/discussions/34"
---

# Activity Module - Memories Index

## Purpose
Persistent memories and decision records for Activity module development.

## Memories (Rules, Checklist, Decisions)

### Testing Architecture
- [testcase-hierarchy-decision](./testcase-hierarchy-decision.md) — **ACTIVE**
  - Activity TestCase -> `Modules\Xot\Tests\XotBaseTestCase` -> Laravel TestCase
  - `Nwidart\Modules\Tests\BaseTestCase` is not available in the installed package
  - Rules for platform vs module logic separation
  - Explicit connection tracking for test isolation
  - Checklist for adding new tests, connections, modules
  - **Status:** Active after vendor/docs verification
  - **Links to:** Concept page, Brainstorm artifact

## On-Demand Loading

```bash
qmd search "Activity memories" --limit 5
qmd search "testcase hierarchy" --intent="understand testcase architecture"
qmd search "test isolation connections" --intent="prevent test crosstalk"
```

## Related Documentation

### Concepts (Detailed Explanations)
- [testcase-hierarchy-architecture](../concepts/testcase-hierarchy-architecture.md) — Detailed concept page

### Brainstorm Artifacts (Full Thinking)
- [brainstorm-testcase-architecture.md](../../brainstorm-testcase-architecture.md) — Complete brainstorm with 28 ideas, 7 insights

### Implementation Guides (TBD)
- Central TESTING.md in Modules/Xot/docs/
- Per-module TESTING.md files

## See Also
- [Root Trigger Map](../../../../../docs/wiki/rules/00-TRIGGER_MAP.md)
- [Root Wiki Index](../)
- [Root Concepts (Architecture Decisions)](../../../../../docs/wiki/concepts/)

---
**Updated:** 2026-06-10  
**Status:** 1 Active Memory  
**Next:** Add implementation guides when Phase 2 (XotBase creation) begins

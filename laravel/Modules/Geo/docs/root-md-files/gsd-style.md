# GSD-STYLE.md

## 🚀 Get Shit Done (GSD) System Style Guide

This document defines the behavioral and documentation standards for AI agents working on the PTVX project using the GSD framework.

### 1. Context Engineering
- **Fresh Context**: Every task execution MUST start with a fresh context. Do not accumulate irrelevant history.
- **Artifacts over Memory**: Rely on `.planning/PROJECT.md`, `ROADMAP.md`, and `STATE.md` as the source of truth, not previous chat history.
- **Granularity**: Keep plans atomic. One plan = One logical unit of work.

### 2. XML Planning Convention
All task plans MUST use the following XML structure for clarity and machine-readability:

```xml
<task type="auto">
  <name>{Task Name}</name>
  <files>
    <file>{path/to/file1}</file>
    <file>{path/to/file2}</file>
  </files>
  <action>
    {Detailed technical instructions}
  </action>
  <verify>
    {Commands or manual steps to verify results}
  </verify>
  <done>
    {Definition of Done (DoD)}
  </done>
</task>
```

### 3. Wave-Based Execution
- **Parallelization**: Tasks in the same wave run in parallel. Ensure no file overlaps.
- **Dependencies**: Use sequential waves for dependent tasks (e.g., Model before Controller).
- **Atomic Commits**: Every `<task>` MUST result in exactly one semantic git commit.

### 4. Quality Gates
- **PHPStan**: Level 10 compliance is non-negotiable.
- **Doc-First**: Update `docs/` (specifically `prd.md`) BEFORE modifying code.
- **No ddx()**: Never leave debugging code in the codebase.
- **Translations**: Always provide `it` and `en` keys.

---
*Last updated: 2026-03-18*

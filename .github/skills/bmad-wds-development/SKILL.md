---
name: bmad-wds-development
description: "Writes production-quality code from approved specifications using spec-driven, incremental, test-as-you-go development. Use when an approved specification exists and needs to be turned into committed, tested, production-ready code."
---

# Development — Write Production Code

Implements production-quality code from approved specifications using structured agent collaboration. The agent follows a spec-driven, incremental workflow where every implementation decision traces back to the spec.

## When to Use

- An approved specification exists (page spec, feature spec, or component spec)
- Prototype has been validated (if prototyping was part of the process)
- The codebase and tech stack are established (not for greenfield project setup)
- A spec needs to be turned into committed, tested, production-ready code

## When NOT to Use

- No approved spec exists yet — use analysis or spec writing first
- Exploring or understanding an existing codebase — use reverse engineering
- Fixing a bug in existing code — use bugfixing workflow
- Building a throwaway prototype to validate ideas — use prototyping workflow

## Core Principles

1. **Spec-driven** — The approved specification is the source of truth. Clarify ambiguity before coding — do not guess.
2. **Incremental** — Implement one feature or component at a time. Commit after each meaningful unit of work. Never let uncommitted changes grow large.
3. **Test as you go** — Run tests after each significant change. Do not batch all testing to the end.
4. **Follow existing patterns** — Match the codebase conventions for file structure, naming, styling, state management, and error handling.
5. **Document deviations** — If deviating from the spec (technical constraint, discovered issue), document what changed and why before moving on.

## Workflow

LOAD the FULL `{project-root}/_bmad/wds/workflows/5-agentic-development/workflow-development.md`, READ its entire contents and follow its directions exactly.

Reference guides in `_bmad/wds/workflows/5-agentic-development/data/guides/`:
- `EXECUTION-PRINCIPLES.md` — Core execution discipline
- `INLINE-TESTING-GUIDE.md` — Self-verifying implementation with Puppeteer
- `SEO-VALIDATION-GUIDE.md` — Public-facing pages SEO compliance
- `SESSION-PROTOCOL.md` — Managing agent sessions and handoffs
- `FEEDBACK-PROTOCOL.md` — Handling user feedback during development

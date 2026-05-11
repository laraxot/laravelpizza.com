---
title: "User Module Operating Focus"
module: "User"
type: concept
created: "2026-04-29T00:00:00Z"
updated: "2026-04-29T00:00:00Z"
related:
  - "[[User Architecture Sources]]"
  - "[[user-module]]"
---

# User Module Operating Focus

> Stable summary of the User module's scope, constraints, and retrieval priorities.

## Role

The User module is the platform identity layer. It owns:

- authentication
- authorization and RBAC
- teams and tenant-aware access
- profile and account lifecycle behavior
- privacy and compliance-sensitive user flows

## Guardrails

- Treat identity, privacy, and compliance concerns as first-class architecture, not feature afterthoughts.
- Reuse Xot architectural rules for inheritance, Filament extension, and translation behavior.
- Prefer durable identity patterns over ad hoc UI or business-logic shortcuts.
- When raw docs conflict, favor concise architectural summaries over speculative implementation sketches.

## Risks Seen in Raw Docs

- extensive duplication between canonical, underscore, dash, archive, and integration folders
- coexistence of stable architecture notes and exploratory advanced-design material
- high chance of stale guidance if agents rely on raw docs directly every time

## Retrieval Heuristic

Start from this page and the existing module overview page.

Open raw docs only for the specific subdomain:

- auth and login flows
- 2FA
- teams and tenancy
- privacy/GDPR
- Spatie permissions

## Local Second Brain Loop

For User-domain tasks, keep this local loop:

1. start from `docs/wiki/` pages in this module
2. open raw docs only for the active identity subdomain
3. distill outcome into local concept/source pages
4. update `index.md` and append `log.md`
5. escalate to root wiki only for cross-module identity rules

This avoids repeating the same identity analysis across sessions and keeps business logic retrieval stable.

## References

- [[User Architecture Sources]]
- [[user-module]]
- `../../README.md`
- `../../PRODUCT_STRATEGY.md`
- `../../architecture/architecture-rules.md`
- `../../advanced-user-architecture.md`

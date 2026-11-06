---
title: "Gdpr — completion backlog"
type: note
status: draft
updated: 2026-10-26
tags: [docs, gdpr]
qmd: "gdpr   completion backlog gdpr"
---
# Gdpr — completion backlog

Status: partial and evidence-driven. This file is the canonical owner-local list for future work.

## Scope

This owner covers consent, cookie state, legal pages, data export, account deletion, retention and accountability evidence.

## Remaining work

- [ ] Inventory public, admin, queued and integration entry points; link each to a caller and test.
- [ ] Verify source purpose and domain invariant before editing any diagnostic or duplication.
- [ ] Audit authorization, privacy, nullable relations, localization and failure paths.
- [ ] Run focused syntax/PHPStan/tests from the documented Laravel root; mark bootstrap failures UNVERIFIED.
- [ ] Review Filament resources against XotBase and shared components against the data-driven reuse rule.
- [ ] Consolidate contradictory status documents by linking them here; do not delete historical evidence.
- [ ] Add or update a BMAD story in plans/stories and record durable decisions in this docs directory.

## Quality gates

- PHPStan uses laravel/phpstan.neon and mixed is last resort only at a real trust boundary.
- New business logic uses Queueable Actions/models/Data/events; no new Service or Controller without an ADR.
- Tests and fixtures are scoped to an isolated environment and never use destructive production commands.
- Any front-office change is checked at 375px, 768px and 1440px where applicable.
- After code changes run graphify update .; after durable findings update Second Brain/Hindsight.

## Evidence ledger

| Area | State | Evidence to add |
|---|---|---|
| Runtime behavior | unknown | focused command and output |
| Tests | partial | test path, bootstrap and result |
| PHPStan | verified at project gate | current command output |
| Security/privacy | partial | policy/allow-list and negative test |
| Localization | partial | locale matrix and missing-key audit |
| Documentation | partial | this file and linked decision/story |

## Open questions

- Which behavior is contractual for users and which is legacy compatibility?
- Which connection, filesystem disk or external provider is authoritative?
- Which failure must be retried, surfaced, redacted or skipped?

## Handoff

Work is ready for implementation only when the relevant story has explicit Acceptance Criteria, Testing strategy and Owned File/Module Scope.

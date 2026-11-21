---
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "5.8.monitoring alerting setup.story"
issues: []
discussions: []
id: '5.8'
epic: 5
story: '8'
title: 'Monitoring setup: Vercel logs + alerting on errors'
slug: monitoring-alerting-setup
status: backlog
scope: module:Tenant
epic_title: 5 — Code Quality & Infrastructure
---

---
# 5.8: Monitoring setup: Vercel logs + alerting on errors

**Story ID:** 5.8
**Epic:** 5 — Code Quality & Infrastructure
**Slug:** monitoring-alerting-setup
**Status:** backlog

## Story

As the DevOps/tech-lead owner accountable for the 99.9% uptime SLA,
I want a health-check endpoint polled by Vercel every 5 minutes with PagerDuty alerting on repeated failures, kept entirely inside EU-approved logging infrastructure,
so that NFR-REL-001's uptime target is actually observed and actionable instead of an unmonitored aspiration, without violating the project's EU-only data-residency constraint.

## Acceptance Criteria

<!-- LOCKED. External dev tools must not edit Acceptance Criteria. -->

1. A health-check endpoint exists and is polled every 5 minutes by Vercel's uptime monitor. [Source: prd.md#NFR-REL-001 — "Monitor: Vercel uptime dashboard + 5-minute health-check ping"; Source: architecture.md#deployment-architecture — "health check endpoint every 5 minutes"]
2. Uptime is computed as `(uptime_seconds / total_seconds) × 100` over a rolling 30-day window and is visible on the Vercel uptime dashboard. [Source: prd.md#NFR-REL-001 — "Measure: (uptime_seconds / total_seconds) × 100 over 30-day window"]
3. An alert fires to PagerDuty after more than 5 consecutive failed health checks. [Source: prd.md#NFR-REL-001 — "Alert: PagerDuty on >5 consecutive failed checks"]
4. No monitoring/alerting tool introduced by this story ships logs outside the EU; specifically, no Sentry, Datadog, or other US-based log-shipping service is added. [Source: prd.md#NFR-SEC-004 — "No US export: no log shipping to US-based services (no Sentry, Datadog)"; Source: architecture.md#deployment-architecture — "Logs must stay in EU-approved systems."]
5. The monitoring/alerting configuration (health-check endpoint, Vercel monitor interval, PagerDuty escalation policy) is documented in a runbook so ops can verify and maintain it without re-deriving it from source docs. [Inference — "setup" in the story title implies a persisted, followable configuration record; no source dictates the exact document format]

## Tasks / Subtasks

- [ ] Add a health-check endpoint (lightweight route returning 200 when the app/DB connection is healthy) if none currently exists in the codebase (AC: #1)
- [ ] Configure Vercel's uptime monitor to poll the health-check endpoint every 5 minutes (AC: #1, #2)
- [ ] Configure the PagerDuty integration to alert after >5 consecutive failed checks (AC: #3)
- [ ] Verify no Sentry/Datadog SDK or other non-EU log-shipping dependency is introduced anywhere in this story's changes (AC: #4)
- [ ] Write a runbook documenting the health-check endpoint, Vercel monitor interval, and PagerDuty escalation policy (AC: #5)
- [ ] Note story 3.9's `VerifyDataResidency` command in the runbook as a related, currently CI-unwired compliance check, without expanding this story to wire it in (see Dev Notes coordination note) (AC: #4)

## Dev Notes

<!-- LOCKED. External dev tools must not edit Dev Notes. -->

- **Sourced target (verbatim):** "NFR-REL-001: MUST — Uptime SLA / Target: 99.9% (8.7 hours downtime per month) / Measure: (uptime_seconds / total_seconds) × 100 over 30-day window / Monitor: Vercel uptime dashboard + 5-minute health-check ping / Alert: PagerDuty on >5 consecutive failed checks." [Source: prd.md#NFR-REL-001]
- **EU-only constraint on tooling (verbatim):** "NFR-SEC-004: MUST — Data Residency (Italy-Only) / Deployment: Vercel EU region only / No US export: no log shipping to US-based services (no Sentry, Datadog) / Compliance: D.Lgs. 165/2001 + GDPR Art. 44 (adequacy) / Verify: CI gate checks deployment region." [Source: prd.md#NFR-SEC-004]
- **Deployment architecture grounding:** "Topology: ...health check endpoint every 5 minutes." "Strategy: rolling deployment with migration pre-checks, backup before production migration, health-check based rollback, CI gate for PHPStan/Pest/LFS pointer validation. Logs must stay in EU-approved systems." [Source: architecture.md#deployment-architecture]
- **ADR grounding:** "ADR-010 | Deploy EU-Only with Health Checks, Backups, and LFS Validation | Accepted | NFR-REL-001, NFR-SEC-004, NFR-OP-002" — "Decision: Deploy only to EU/Italy-approved regions. Add 5-minute health checks, database backups with tested restore, CI validation for Git LFS pointers, and no US-based log shipping." [Source: architecture.md#adr-010]
- **Component ownership grounding:** "Setup/Operations (`Xot`, `Tenant`) | PA setup, module conventions, quality gates | Filament setup wizard, seeders, CI checks | Configuration, setup logs | ADR-008, ADR-010" — the `Tenant` module's architecture-documented responsibility already includes operational/quality-gate configuration, supporting epics.md's assignment of this story to `Tenant`. [Source: architecture.md#component-design]
- **Citation nuance on "alerting on errors":** the story title says "alerting on errors," but no PRD/architecture NFR defines generic application-error alerting. The only sourced alerting requirement is `NFR-REL-001`'s health-check/uptime-failure alert (infrastructure-level), and `NFR-OP-001`'s Sigma-sync-specific alerting (owned by Epic 2/Sigma, not this story). Application-level exception tracking (e.g., Sentry) is explicitly forbidden by `NFR-SEC-004`. This story therefore scopes "alerting on errors" to infrastructure/uptime failures per `NFR-REL-001`, not exception-level error tracking. [Inference]
- **Coordination note (not resolved by this story):** story 3.9 (`Modules/User/docs/stories/3.9.verify-data-residency.story.md`, Epic 3) built a `VerifyDataResidency` command and explicitly flagged in its own Dev Notes that "Epic 5's CI workflow wiring consumes this command as an external dependency... flag for Epic 5's story author." No Epic 5 story (including 5.6, whose Owned Scope is already locked to the `phpstan`/`tests` job steps only) currently claims the task of wiring that command into a CI job. This story does not take on that wiring either — its scope is uptime monitoring/alerting, not the residency CI gate — but the gap is flagged here for the orchestrator to assign, since it cites `NFR-SEC-004`'s "Verify: CI gate checks deployment region" line, which remains otherwise unimplemented across all currently-written Epic 5 stories. [Inference]
- **No pre-existing health-check infrastructure found:** a repo-wide search for `health-check`/`healthcheck`/`/health` routes and for a `vercel.json` project config returned no code matches (only documentation references to the requirement) — this story is genuinely new infrastructure, not a wire-up of an existing endpoint. [Inference — grounded in absence of matches in the codebase]

## Testing

<!-- LOCKED. External dev tools must not edit Testing. -->

- **Test type:** a Pest feature test for the health-check endpoint's HTTP response (fast 200 OK, including a DB-connectivity check); the Vercel monitor interval and PagerDuty escalation policy are external service configuration, not something an automated test in this repo can assert — those are verified manually/documented, not test-covered.
- **Fixtures:** none beyond the standard HTTP test client already used elsewhere in the suite.
- **Scenarios to prove each AC:**
  - AC #1/#2: feature test confirms the health-check route returns 200 under normal conditions; manually confirm (documented in the runbook) that the Vercel dashboard shows the monitor configured at a 5-minute interval and displays a 30-day uptime percentage.
  - AC #3: documented manual verification (or a staging-environment drill) confirming PagerDuty escalates after 5 consecutive simulated failures — this cannot be safely automated against production monitoring inside this repo's test suite.
  - AC #4: `grep -ri "sentry\|datadog" laravel/composer.json laravel/composer.lock` (or equivalent dependency manifest check) returns nothing new introduced by this story.
  - AC #5: confirm the runbook file exists and documents all three pieces (endpoint, monitor interval, escalation policy).
- **Edge cases:** the health-check endpoint itself returning 500 (should be distinguishable in monitoring from a network-level timeout, since they indicate different failure modes); an escalation policy that fires before or after the specified 5-failure threshold (both under- and over-alerting are edge cases the runbook must flag for whoever configures the live PagerDuty policy); a database connectivity blip that self-resolves within one polling interval (should not itself trigger a false PagerDuty page if it resolves before 5 consecutive failures accumulate).

## Dependency Maps

- Blocked by: none within Epic 5.
- Blocks: none within Epic 5.
- External: Vercel (uptime monitor dashboard, health-check polling), PagerDuty (alerting/escalation). Explicitly forbidden as dependencies: Sentry, Datadog, or any other US-based log-shipping service.

## Owned File/Module Scope

- `laravel/Modules/Tenant/docs/monitoring-alerting-setup.md` — new runbook file
- A new health-check route/controller (e.g. `laravel/Modules/Tenant/app/Http/Controllers/HealthCheckController.php` plus its route registration) if none exists — new file(s); exact registration point follows the module's existing routing convention. [Inference — exact path depends on how the codebase already registers module-level routes]
- `laravel/Modules/Tenant/tests/Feature/HealthCheckTest.php` — new file
- Vercel project configuration and PagerDuty escalation policy are external service settings, not repository files — documented in the runbook above, not owned as code.
- Explicitly excluded: `Modules/User/app/Console/Commands/VerifyDataResidency.php` (owned by story 3.9), `.github/workflows/**` (owned by 5.4 and 5.6).

## Learnings from Previous Stories

(none — no completed (status: done) sibling stories exist yet in this project)

## Dev Agent Record

_(empty — to be completed by the external dev tool)_

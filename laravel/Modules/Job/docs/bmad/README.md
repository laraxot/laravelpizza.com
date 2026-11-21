---
title: "Job — BMAD dossier"
type: bmad-module-dossier
module: Job
status: baseline
updated: 2026-10-07
tags: [bmad, queues, scheduler, operations]
qmd: "Job module purpose architecture PRD epics gaps release"
issues: ["https://github.com/laraxot/base_fixcity_fila5/issues/383"]
discussions: ["https://github.com/laraxot/base_fixcity_fila5/discussions/392"]
---
# Job BMAD dossier
**Purpose / product brief:** run and observe asynchronous work, imports, exports, retries and schedules without losing domain transactions.
**Architecture:** Laravel queues/jobs/actions with idempotency and after-commit dispatch; Job must not own Fixcity semantics.
**PRD:** queue health, retry/backoff, failed-job replay, scheduler visibility, import/export progress and safe cancellation.
**Epics:** worker reliability; operations dashboard; replay/retention.
**Discovered gaps:** candidate worker/failed_jobs/alerts are unverified; define idempotency keys, retention, replay ownership and RPO/RTO.
**Release gate:** injected failure, replay without duplication, queue-depth alert and runbook evidence.

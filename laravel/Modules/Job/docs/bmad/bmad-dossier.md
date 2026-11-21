---
title: "Job — BMAD dossier"
type: bmad-dossier
module: Job
updated: 2026-10-07
tags: [bmad, job, queues, operations]
qmd: "Job module product brief PRD architecture UX security epics gaps release"
issues: ["https://github.com/laraxot/base_fixcity_fila5/issues/383"]
discussions: ["https://github.com/laraxot/base_fixcity_fila5/discussions/392"]
---
# Job — BMAD dossier
## Product brief / PRD
Run imports, exports, notifications and scheduled work reliably without losing transactions.
## Architecture / UX / security
Laravel queue/jobs use after-commit dispatch, idempotency and safe replay; domain meaning stays with owner modules.
## Epics and stories
Worker reliability; failed-job operations; replay/retention.
## Gaps / release
Worker, failed_jobs, alerts, idempotency and RPO/RTO are not candidate-verified. Release requires failure injection and replay evidence.

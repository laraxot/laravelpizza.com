---
title: "QueueableAction execute entrypoint"
type: rule
module: Activity
confidence: high
created: 2026-07-12
updated: 2026-07-12
tags: [activity, actions, queueable-action, execute]
related:
  - ../../../../../../docs/wiki/rules/queueable-action-execute-entrypoint.md
status: stub
qmd: "queueableaction execute entrypoint activity"
---

# QueueableAction execute entrypoint

Every PHP class under `Modules/Activity/app/Actions/` uses `Spatie\QueueableAction\QueueableAction` and exposes an `execute(...)` method.

Example: `RecordSubjectActivityAction::execute(...)` is the canonical subject-recording entrypoint.

Compatibility methods such as `ActivityLogger::log()` or `ActivityRecorder::record()` may remain only as wrappers; new code calls `execute(...)` on the target action.

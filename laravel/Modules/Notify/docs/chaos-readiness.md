---
qmd: "chaos readiness"
issues: []
discussions: []
title: "Notify Chaos Readiness - 2026-03-02"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
<<<<<<< .merge_file_NTH469
updated: 2026-11-23
=======
<<<<<<< HEAD
updated: 2026-08-24
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
>>>>>>> .merge_file_KNWuCq
---

# Notify Chaos Readiness - 2026-03-02

## Scope
- Optional Firebase/FCM dependency hardening.

## Completed
- Refactored push notification pages to avoid hard dependency crashes.
- Refactored Firebase notification class with runtime guards.
- Added missing `MailTemplateVersionFactory` for static analysis consistency.
- Verified `Modules/Notify` passes PHPStan.

## Next Chaos Steps
- Disable Firebase packages and verify UI-level warning path.
- Inject invalid cloud message contracts and ensure controlled failures.

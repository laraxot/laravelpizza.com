---
title: "Notify quality gate audit 2026-11-05"
type: audit
module: Notify
---

# Notify quality gate audit

Conditional tenant-default tests use PHPUnit's supported skip API and remain
explicit about why the fixture cannot be observed in a tenant-configured run.

---
title: "Xot quality gate audit 2026-11-05"
type: audit
module: Xot
---

# Xot quality gate audit

The full PHPStan run identified a new type boundary in the action that lists
enabled modules. The action must validate the repository contract before
calling module methods.

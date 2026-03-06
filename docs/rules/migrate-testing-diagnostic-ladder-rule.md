# Migrate Testing Diagnostic Ladder Rule

Date: 2026-03-06
Scope: `laravel/` runtime, command `php artisan migrate --env=testing`

## Rule

When `migrate --env=testing` fails, diagnose in this exact order and record evidence for each step before code changes:

1. Connectivity layer
- Verify whether the failure is sandbox/network/infrastructure (`SQLSTATE[HY000] [2002]` or similar).
- Re-run outside sandbox when needed to isolate environment artifacts.

2. Parse/syntax layer
- If connectivity succeeds, stop on first PHP parse error in migrations.
- Fix syntax blockers before schema analysis.

3. Schema semantics layer
- Execute again and analyze first DDL error (`42S21`, duplicate columns, etc.).
- Confirm whether the collision comes from helper abstractions (e.g. Xot timestamps adding `user_id`) versus explicit migration columns.

## Non-negotiable output

Each investigation must produce:
- one module doc update (affected module),
- one theme doc update (impact on integration tests),
- one GitHub Issue comment,
- one GitHub Discussion comment.

No implementation should start before this documentation set exists.

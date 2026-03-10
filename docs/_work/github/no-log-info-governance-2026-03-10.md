Governance update: `Log::info()` is now explicitly disallowed in project application code.

Reasoning:

- success-path `info` logs create noise and slow requests without improving reliability
- they are often used as fake verification instead of tests, telemetry, or audit
- they risk leaking user/business context into logs without real operational value
- they make production troubleshooting harder because signal is buried under routine events

Operational rule:

- do not use `Log::info()`
- do not leave `Log::debug()` in committed code
- for recoverable anomalies use `Log::warning()`
- for failures use `Log::error()`
- for audit trail use activity log or dedicated persistence
- for observability/monitoring use telemetry tools, not routine app logs

Governance updated locally in:

- `AGENTS.md`
- `/home/zorin/.codex/memories/base_quaeris_global_rules.md`
- `bashscripts/ai/.codex/skills/php-quality-gates/SKILL.md`
- `bashscripts/ai/.cursor/rules/debugging.md`

Existing local reference aligned with this decision:

- `docs/logging-performance.md`

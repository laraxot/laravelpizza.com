# Ponytail Docs Lifecycle

Xot is the shared base module, so its docs pattern should be the boring default for other modules.

## Canonical Shape

- `docs/index.md`: current map and entrypoint.
- `docs/wiki/`: durable concepts, rules, decisions, and runbooks.
- `docs/tasks/`: active work items only.
- `docs/outputs/`: generated reports and one-off audit output.

## Cleanup Rule

Before adding a new docs file, search existing docs and update the canonical file. If a report is only historical, extract the decision and delete or archive the report.

## Audit Backlog

The repo-level Ponytail backlog lives in `docs/wiki/ponytail-audit-github-backlog.md`.


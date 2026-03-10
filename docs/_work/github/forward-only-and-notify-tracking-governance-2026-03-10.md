Governance update consolidated from the latest recovery wave.

1. Git is strictly forward-only on shared history.

- no `git reset`
- no restore/checkout rollback of shared files
- no force push
- no `git revert` as routine undo mechanism
- fixes must be explicit forward corrective commits that preserve context and diagnosis

Reason:

- going backward destroys signal, hides causality, and makes it easier to erase the path that introduced a regression
- the project needs traceability, auditability, and honest incremental repair, not repo-level undo habits

2. `Modules/Notify/app/Http/Controllers/NotificationTrackingController.php` is not an acceptable module boundary.

- notification tracking is a Notify domain concern, not a legacy monolithic HTTP controller concern
- if HTTP entrypoints are needed, they must stay thin and delegate immediately to actions/services
- themes must not compensate for this anti-pattern

Local governance/docs updated in this pass:

- `docs/git-forward-only-rule.md`
- `docs/memory/ralph-loop-and-forward-only-memory.md`
- `docs/skills/git-forward-only-skill.md`
- `docs/rules/notify-no-notification-tracking-controller-rule.md`
- `docs/memory/notify-no-tracking-controller-memory.md`
- `docs/skills/notify-controller-removal-skill.md`
- `laravel/Modules/Notify/docs/no-notification-tracking-controller.md`
- `laravel/Modules/Notify/docs/00-index.md`
- `laravel/Themes/Meetup/docs/phpstan-module-blockers-impact-2026-03-10.md`
- `AGENTS.md`
- `/home/zorin/.codex/memories/base_quaeris_global_rules.md`

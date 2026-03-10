Progress update for the `php artisan ide-helper:models -W` wave.

What happened:

- before running the command, local governance/docs were updated for ide-helper waves
- first execution inside sandbox reported many `Could not analyze class ...` messages
- root cause was environmental, not model breakage: blocked access to local MySQL connections on `127.0.0.1:3306`
- after rerunning with real local DB access, `php artisan ide-helper:models -W` completed and rewrote model PHPDoc blocks across modules

Validation:

- rerun after generation: `cd laravel && ./vendor/bin/phpstan analyse Modules --no-progress`
- result: `OK`, no PHPStan errors

Governance/files updated in this pass:

- `AGENTS.md`
- `/home/zorin/.codex/memories/base_quaeris_global_rules.md`
- `bashscripts/ai/.codex/skills/php-quality-gates/SKILL.md`
- `docs/rules/ide-helper-models-wave-rule.md`
- `docs/memory/ide-helper-models-wave-memory.md`
- `docs/skills/ide-helper-models-wave-skill.md`
- `laravel/Modules/Xot/docs/ide-helper-models-wave-2026-03-10.md`
- `laravel/Themes/Meetup/docs/ide-helper-models-wave-impact-2026-03-10.md`

Key lesson:

- do not react to sandbox-only ide-helper failures by blindly expanding `ignored_models`
- first distinguish real model/schema problems from blocked local DB access

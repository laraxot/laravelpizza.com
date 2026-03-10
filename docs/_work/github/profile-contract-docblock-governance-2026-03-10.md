Governance correction for the recent ide-helper models wave.

Rule clarified:

- for cross-module profile relations such as `creator`, `updater`, `deleter`, the PHPDoc must use the domain contract
  `\Modules\Xot\Contracts\ProfileContract|null`
- it must not be narrowed to a concrete implementation like
  `\Modules\Meetup\Models\Profile|null`

Why:

- consumers depend on the profile contract, not on the current concrete model guessed by ide-helper
- ide-helper can generate a technically plausible but architecturally wrong concrete type
- the repository standard is contract-first PHPDoc for shared domain relations

Governance/docs updated locally:

- `AGENTS.md`
- `/home/zorin/.codex/memories/base_quaeris_global_rules.md`
- `bashscripts/ai/.codex/skills/php-quality-gates/SKILL.md`
- `docs/rules/profile-contract-docblock-rule.md`
- `docs/memory/profile-contract-docblock-memory.md`
- `docs/skills/profile-contract-docblock-skill.md`
- `laravel/Modules/Meetup/docs/profile-contract-docblocks.md`
- `laravel/Themes/Meetup/docs/ide-helper-models-wave-impact-2026-03-10.md`

Operational consequence:

- after `php artisan ide-helper:models -W`, generated `creator/updater/deleter` docblocks must be reviewed for contract drift before accepting the diff.

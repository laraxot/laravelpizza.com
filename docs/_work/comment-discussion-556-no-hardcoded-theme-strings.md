Additional governance update from current execution:

We added a cross-stack localization constraint for themes:
- no hardcoded natural-language UI strings in Blade/Volt theme files.
- all user-facing text must be translation-driven.

New artifacts:
- `docs/rules/no-hardcoded-theme-strings-rule.md`
- `docs/memory/no-hardcoded-theme-strings-memory.md`
- `docs/skills/theme-i18n-no-hardcoded-strings-skill.md`

This complements Folio/Volt/Livewire/Filament governance by enforcing i18n discipline at template level.

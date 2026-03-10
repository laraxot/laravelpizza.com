Rule hardening update completed:

New global constraint added: **no hardcoded natural-language UI strings in themes**.

Docs updated:
- `docs/rules/no-hardcoded-theme-strings-rule.md`
- `docs/memory/no-hardcoded-theme-strings-memory.md`
- `docs/skills/theme-i18n-no-hardcoded-strings-skill.md`

Also aligned existing header auth localization governance with this stricter policy.

Operational effect:
- all theme/UI labels must come from translation keys (`__()` / `@lang`), preferably `pub_theme::...` for theme microcopy;
- hardcoded labels like `Accedi`, `Registrati`, `Login`, `Sign up` are now explicit anti-patterns.

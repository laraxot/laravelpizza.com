Progress update on theme i18n governance.

New rule now treated as canonical in local agent governance:

- no localized hardcoded strings inside themes;
- no pseudo-localization like __("Accedi"), __("Registrati"), __("Home");
- theme Blade files must use namespaced translation keys such as pub_theme::... or module::..., or CMS/localized content injected upstream.

Why this matters:

- hardcoded labels silently break non-Italian locales;
- `__('literal text')` looks translated but is only a fragile fallback;
- frontoffice tests become ambiguous because they cannot distinguish true localization from source-language leakage.

Governance surfaces updated:

- AGENTS.md
- .cursor/rules/theme-no-hardcoded-localized-strings.md
- .cursor/memories/theme-no-hardcoded-localized-strings.md
- docs/skills/livewire-volt-filament5-governance-skill.md
- docs/skills/mcamara-localization-routing-skill.md
- /home/zorin/.codex/memories/base_quaeris_global_rules.md

Enforcement expectation:

- theme review must explicitly search for literal user-facing strings in Blade;
- key layout elements should be regression-tested on at least one non-Italian locale.

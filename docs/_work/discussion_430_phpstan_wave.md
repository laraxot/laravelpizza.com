Quality wave update (requested command executed): `./vendor/bin/phpstan analyse Modules` completed on 2026-03-10 with **106 errors** across 3317 files.

Opened tracking issue: #565 with module-by-module wave plan.

First fix in this wave already merged locally: `Modules/Meetup/app/Models/Event.php` organizer profile URL typing (`mixed` -> string cast).

Docs/rules/memory/skill updated for repeatable workflow:
- `docs/rules/phpstan-modules-wave-rule.md`
- `docs/memory/phpstan-modules-wave-2026-03-10-memory.md`
- `docs/skills/phpstan-modules-wave-skill.md`

Next wave target: Cms errors (Livewire `Page/Show` + `PostFactory` + `ThemeComposer`).

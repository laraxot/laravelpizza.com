## Deep Study Completed: Folio + Volt + Livewire 4 + Filament 5 + Spatie Google Fonts Plugin

### Upstream sources reviewed
- https://github.com/laravel/folio
- https://github.com/livewire/volt
- https://livewire.laravel.com/docs/4.x/components
- https://github.com/filamentphp/filament/tree/5.x
- https://github.com/filamentphp/spatie-laravel-google-fonts-plugin

### Key operational outcomes for LaravelPizza
1. **Folio** remains canonical frontoffice page router (file-based). Inline metadata helpers (`name`, `middleware`, `render`, `withTrashed`) are now codified in governance.
2. **Volt** is the default for single-file reactive page logic; Livewire multi-file components only when reuse is real across pages.
3. **Livewire 4 components discipline** reinforced (properties/actions/rendering/validation) + migration path via `livewire:convert`.
4. **Filament 5 compatibility baseline** documented (Laravel 11+, Livewire 4, PHP 8.2+).
5. **Filament Google Fonts plugin** standardized via `SpatieGoogleFontProvider` + local cache (no hardcoded CDN policy for panel fonts).

### Documentation artifacts added
- `docs/rules/folio-volt-livewire4-filament5-governance-rule.md`
- `docs/memory/folio-volt-livewire4-filament5-deep-study-memory.md`
- `docs/skills/folio-volt-livewire4-filament5-operational-skill.md`
- `laravel/Modules/Meetup/docs/stack-upstream-deep-study-folio-volt-livewire4-filament5.md`

### Why this matters
This prevents architectural drift between frontend page routing, reactive component style, and admin panel ecosystem upgrades.

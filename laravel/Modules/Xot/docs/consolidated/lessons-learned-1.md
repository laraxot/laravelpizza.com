# Lessons Learned – Consolidated Rules (2025-08-25)

This document consolidates recurring fixes and rules applied across modules. Keep files lowercase (README.md excepted).

## 1. Filament Translations
- Never use `->label()` in form/table components. Labels come from LangServiceProvider.
- Use expanded translation structure: label, placeholder, tooltip, helper_text, description, icon, color.
- Widget view paths must be `module::filament.widgets.name`.

## 2. Namespaces & Structure
- Always `Modules\\<Module>\\...` (no `App` segment inside modules).
- HTTP classes in `app/Http/` and Livewire in `app/Http/Livewire`.
- Widgets under `Modules/<Module>/Filament/Widgets`.

## 3. Models & Typing
- Models extend the module’s `BaseModel` only.
- Use `protected function casts(): array` (not `$casts`).
- Annotate `$fillable`, `$hidden`, `$dates`, `$with` as `/** @var list<string> */`.
- Add PHPDoc for properties and relationships.
- Prefer Xot cast Actions in `Modules/Xot/app/Actions/Cast/` for safe casting.

## 4. Migrations
- Extend `XotBaseMigration`, never implement `down()`.
- "One file per table" via `tableCreate`/`tableUpdate`; guard with `hasTable/hasColumn`.

## 5. FullCalendar
- Use `config()` (never `options()`), return `WidgetConfiguration` when using the factory, or make dedicated class extending `FullCalendarWidget`.
- Centralize plugins, locale, timezone, business rules in AdminPanelProvider.
- Respect patient/doctor/admin separation and permissions.

## 6. Documentation Policy
- No root `docs/`. Use `docs_project/` (global) and `Modules/<Module>/project_docs/` (module).
- All docs filenames lowercase except `README.md`.

## 7. PHPStan
- Do not modify `laravel/phpstan.neon`.
- Use CLI flags for scope/limits; target level 10+. Keep array key/value types explicit.

## 8. Testing
- No `RefreshDatabase`.
- Tests validate observable business behavior, not internals like `$fillable`.

## 9. URL Localization & Frontoffice
- URLs prefixed by locale: `/{locale}/...`; get locale via `app()->getLocale()`.
- Homepage blade: `Themes/One/resources/views/pages/index.blade.php` (`pub_theme::pages.index`).
- Content from `config/local/<nome progetto>/database/content/pages/home.json`. Root `/` redirects to `/{locale}`.

## 10. Icons & Assets ()
- SVG in `laravel/Modules//resources/svg/`, kebab-case; reference as `<nome progetto>-{name}`.
- Content from `config/local/<nome progetto>/database/content/pages/home.json`. Root `/` redirects to `/{locale}`.

## 10. Icons & Assets (<nome progetto>)
- SVG in `laravel/Modules/<nome progetto>/resources/svg/`, kebab-case; reference as `<nome progetto>-{name}`.

## 11. Translation Hygiene
- Never remove keys/content; only add.
- If `helper_text` equals the key name, set it to empty string `''`.
- Fix non-Italian translations containing Italian text.

## 12. Architecture Boundaries
- Base modules (User, UI, Xot) must not depend on domain-specific modules; use contracts or move features to specific modules.

## 13. Filament Base Classes & Arrays
- Extend `XotBaseResource`, `XotBasePage`, `XotBaseListRecords`.
- `getFormSchema()`, `getTableColumns()`, `getTableActions()`, `getTableFilters()`, `getTableBulkActions()` return associative arrays with string keys.

## 14. FullCalendar Security Hooks
- Enforce locale/timezone, business hours, drag/select constraints, emergency styling.
- Add JS callbacks: `eventDidMount`, `eventClassNames`, `selectAllow`, `eventAllow`.

---
- Backlinks: see `Modules/<nome modulo>/project_docs/translation-rules-consolidated.md`, `Modules/Xot/project_docs/translation-structure-expanded.md`, `.windsurf/rules/full_calendar*.mdc`.

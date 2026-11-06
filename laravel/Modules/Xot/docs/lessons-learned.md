---
title: "Lessons learned: consolidated rules"
type: note
status: active
module: Xot
created: 2025-08-25
updated: 2026-11-06
tags: [docs, xot, rules, lessons-learned]
qmd: "lessons learned consolidated rules xot filament translations namespaces models migrations phpstan testing icons architecture boundaries"
related:
  - ./architecture/translation-structure-expanded.md
  - ../../../../docs/wiki/rules/markdown-filename-conventions.md
  - ../../../../docs/wiki/rules/phpstan-neon-immutable.md
  - ../../../../docs/wiki/rules/form-schema-lives-on-form-class.md
  - ./stories/collision-rewrite-complete-files.story.md
---

# Lessons learned: consolidated rules

Recurring fixes and rules applied across modules, in one place. Each item is a rule that was broken at least once and
cost a fix; the linked rule files carry the full reasoning. Paths are relative to `laravel/` unless stated otherwise.

## 1. Filament translations

- Never use `->label()` in form or table components. Labels come from `LangServiceProvider`
  ([no-filament-labels](../../../../docs/wiki/rules/no-filament-labels.md)).
- Use the expanded translation structure: `label`, `placeholder`, `tooltip`, `helper_text`, `description`, `icon`,
  `color` ([translation-structure-expanded](./architecture/translation-structure-expanded.md)).
- Widget view paths are `module::filament.widgets.name`.

## 2. Namespaces and structure

- Always `Modules\<Module>\...`, with no `App` segment inside modules. The code of a module lives in
  `Modules/<Module>/app/` (PSR-4 `Modules\<Module>\` maps to `app/`), so a class under `app/Filament/Widgets/` has the
  namespace `Modules\<Module>\Filament\Widgets`
  ([namespace-structure-rules](../../../../docs/wiki/rules/namespace-structure-rules.md)).
- HTTP classes in `app/Http/`, Livewire components in `app/Http/Livewire/`, widgets in `app/Filament/Widgets/`.

## 3. Models and typing

- Models extend the module's `BaseModel` only.
- Casts go in `protected function casts(): array`, never in `$casts`
  ([deprecated-casts-property](../../../../docs/wiki/rules/deprecated-casts-property.md)). The `$dates` property no
  longer exists in the installed framework: date columns are `datetime` entries in `casts()`.
- Annotate `$fillable`, `$hidden` and `$with` as `/** @var list<string> */`.
- Add PHPDoc for properties and relationships (generics included, e.g. `BelongsTo<Related, $this>`).
- Prefer the Xot cast Actions in `Modules/Xot/app/Actions/Cast/` (`SafeArrayCastAction`, `SafeAttributeCastAction`,
  `SafeArrayByModelCastAction`) for safe casting.

## 4. Migrations

- Extend `XotBaseMigration`, never implement `down()`.
- One file per model through `tableCreate` / `tableUpdate`; guard every change with `hasTable` / `hasColumn`
  ([migration-filename-from-model-name](../../../../docs/wiki/rules/migration-filename-from-model-name.md)).
- Data are sacred: no `migrate:fresh`, no destructive migration.

## 5. FullCalendar (when a module uses it)

- Use `config()`, never `options()`. Return a `WidgetConfiguration` when going through the factory, or write a dedicated
  class extending `FullCalendarWidget`
  ([full-calendar-rules](../../../../docs/wiki/rules/full-calendar-rules.md)).
- Centralise plugins, locale, timezone and business rules in the `AdminPanelProvider`.
- Keep the roles apart (for example patient, doctor and admin in a health domain) and respect permissions.
- Security hooks: enforce locale, timezone, business hours and drag/select constraints, and style emergencies
  explicitly. Add the JS callbacks `eventDidMount`, `eventClassNames`, `selectAllow` and `eventAllow`.

## 6. Documentation policy

- Shared project documentation lives in `docs/` at the repository root, module documentation in
  `laravel/Modules/<Module>/docs/`, theme documentation in `laravel/Themes/<Theme>/docs/`.
  `project_docs/`, `docs_project/` and `_docs/` are not valid locations. This replaces the 2025-08 text that sent
  documentation to `docs_project/` and `Modules/<Module>/project_docs/`.
- File names are kebab-case, without dates or numeric copy suffixes (`-1.md`, `-2.md`); the date goes in the front
  matter (`created`, `updated`). `README.md` is the only upper-case name
  ([markdown-filename-conventions](../../../../docs/wiki/rules/markdown-filename-conventions.md)).

## 7. PHPStan

- Do not modify `laravel/phpstan.neon`: it is a single file, owned by the user
  ([phpstan-neon-immutable](../../../../docs/wiki/rules/phpstan-neon-immutable.md)).
- The level is set in the neon (`max`). Never pass `--level` or `-c`
  ([phpstan-no-level-parameter](../../../../docs/wiki/rules/phpstan-no-level-parameter.md)); restrict the scope with the
  path, for example `./vendor/bin/phpstan analyse Modules/<Module> --memory-limit=-1 --no-progress`.
- Keep array key and value types explicit.

## 8. Testing

- Pest only, tests in `Modules/<Module>/tests/`.
- No `RefreshDatabase`, no `migrate:fresh`
  ([never-use-refresh-database](../../../../docs/wiki/rules/never-use-refresh-database.md)).
- Tests validate observable business behaviour, not internals such as `$fillable`.

## 9. URL localisation and front office

- URLs are prefixed by the locale, `/{locale}/...`; read the locale with `app()->getLocale()`. The root `/` redirects
  to `/{locale}`.
- The home page is the Blade `pages/index.blade.php` of the active theme
  (`Themes/<Theme>/resources/views/pages/index.blade.php`, view `pub_theme::pages.index`).
- Its content comes from `config/local/<tenant>/database/content/pages/home.json` (here `<tenant>` is `restaurant`).

## 10. Icons and assets

- SVG files go in `laravel/Modules/<Module>/resources/svg/` with kebab-case names
  ([svg-asset-location](../../../../docs/wiki/rules/svg-asset-location.md)).
- `XotBaseServiceProvider::registerBladeIcons()` registers that folder with the lower-case module name as prefix:
  `Modules/User/resources/svg/device.svg` is referenced as `user-device`
  ([module-config-icon-svg](../../../../docs/wiki/rules/module-config-icon-svg.md)).

## 11. Translation hygiene

- Never remove keys or content, only add.
- If `helper_text` equals the key name, set it to the empty string `''`.
- Fix non-Italian translations that contain Italian text.

## 12. Architecture boundaries

- Base modules (User, UI, Xot) must not depend on domain-specific modules: use contracts, or move the feature to the
  specific module.

## 13. Filament base classes and arrays

- Extend `XotBaseResource`, `XotBasePage` and `XotBaseListRecords`, never the Filament classes directly
  ([fundamental-xotbase-rule](../../../../docs/wiki/rules/fundamental-xotbase-rule.md)).
- `getTableColumns()`, `getTableActions()`, `getTableFilters()` and `getTableBulkActions()` return associative arrays
  with string keys ([filament-table-columns-array-keys](../../../../docs/wiki/rules/filament-table-columns-array-keys.md)).
- `getFormSchema()` belongs to the Form class (`Schemas/<Model>Form`), never to the Resource, where it is `final`
  ([form-schema-lives-on-form-class](../../../../docs/wiki/rules/form-schema-lives-on-form-class.md)).

## Provenance

Merged on 2026-11-06 from three copies of the same 2025-08-25 document: this file and the two numbered copies in
`consolidated/` (`lessons-learned-1-1.md`, `lessons-learned-2.md`, now retired as `.md.old`). The copies differed in
the PHPStan level (`9+`, then `10+`), in the project names (a placeholder in one, a different project's module in the
other), in a duplicated "Icons" block and in a tail with front matter pasted into the body. Sections 5 and 14 of the
old text (both FullCalendar) are now section 5; section 6 and section 13 were brought up to date with the current rules,
and the old backlinks to `project_docs/` were replaced by the rule files linked above.

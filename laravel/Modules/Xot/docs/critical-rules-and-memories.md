# Laravel Pizza Project Rules and Memories

## Critical Architectural Rules

1. **Laraxot Migration Philosophy**: In a module, for each table there must be only ONE migration responsible for its creation (`create_{table}_table.php`). Multiple migrations for the same table is a violation. To modify schema: study the existing migration, edit the SAME migration file, and UPDATE the timestamp in the filename so the new version can run forward again. NEVER create separate `add_column_to_table.php`, `add_*_to_{table}.php`, or `repair_*` migrations. Use tableUpdate() with hasColumn() checks for safe additions. Models strictly dependent on main_module (e.g. Profile): migration goes in the concrete model branch that owns the runtime connection. Use XotBaseMigration::convertIdFromUuidToBigintIfNeeded() for UUID→bigint conversion.
2. **Database Safety Rule**: Never use `migrate:fresh`, never use `migrate --force`, and never use `RefreshDatabase`. The local database is evidence to inspect and evolve, not a sandbox to reset by default.
3. **Markdown Filename Rule**: `.md` filenames must not contain dates. Use stable semantic names and put dates inside the document content if the context requires chronology.
4. **GitHub Language and Metrics Rule**: Le GitHub Issue e le GitHub Discussion del progetto vanno scritte in italiano. Quando possibile, usare percentuali per esprimere avanzamento, rischio, copertura, priorita' o confidenza.

2. **NO property_exists() on Eloquent models**: Use hasAttribute(), isFillable() or Schema::hasColumn() instead, because model attributes are magical properties.

3. **Folio + Volt + Filament Architecture**: In the front office, NEVER use controllers or write routes in web.php/api.php. ALWAYS use Folio + Volt + Filament for all frontoffice development.

4. **XotBase Extension Rule**: All custom components must extend XotBase classes (XotBaseResource, XotBasePage, XotBaseSection, etc.) instead of extending Filament classes directly.

## Documentation Rules

1. **File Naming**: All .md files must be lowercase with dashes (except README.md and CHANGELOG.md which can have capitals)
2. **Documentation Location**: All .md files must go inside existing 'docs' directories, not created elsewhere
3. **Content Quality**: Documentation should follow DRY (Don't Repeat Yourself) and KISS (Keep It Simple, Stupid) principles

## PHP Quality Standards

1. **PHPStan Level 10**: All modules must maintain PHPStan level 10 compliance
2. **Strict Types**: All PHP files must declare(strict_types=1)
3. **Safe Casting**: Use Safe*CastAction classes for type safety
4. **Webmozarts Assert**: Use webmozarts/assert for input validation

## Git Conflict Resolution

1. **No Backup Policy**: Conflict resolution scripts should not create backup files
2. **Current Change Strategy**: When resolving conflicts automatically, take the "current change" (content after =======)
3. **File Types**: Handle various file types including PHP, JS, JSON, MD, etc.

## Theme Development

1. **Asset Management**: Each theme has its own package.json and vite.config.js
2. **Build Process**: Use `npm run build && npm run copy` to compile and deploy theme assets
3. **Layout Structure**: Use <x-metatags> component instead of manual head content

## Laravel 11+ Patterns

1. **Casts Method**: Use casts() method instead of $casts property
2. **Filament Labels**: Use translation files via LangServiceProvider instead of label(), placeholder(), tooltip() methods
3. **Enum-Driven Fillable**: Use enum-driven fillable fields instead of static arrays

## Quality Assurance

1. **Pest PHP**: All tests must be written in Pest PHP, not PHPUnit
2. **Code Quality Tools**: Run PHPStan, PHPMD, and PHPInsights after every change
3. **Documentation Updates**: Always update docs folders when making changes to the codebase
4. **GitHub Tracking Language**: GitHub Issues and GitHub Discussions for this project must be written in Italian, and when useful must include percentages for progress, risk, confidence, coverage, or priority.
5. **Local AI Runtime Governance**: For Ollama/AMD/ROCm/WSL work, always distinguish guest Linux readiness from Windows host driver readiness. If `/dev/dxg` and ROCm libraries exist but `rocminfo` fails, treat it as WSL/runtime misalignment first, not as "Ollama missing".
6. **Action-First Architecture**: Do not introduce generic `Services` for business logic. The preferred pattern is explicit Action classes, and for reusable/async work the standard is `spatie/laravel-queueable-action` with `execute()` as project convention.

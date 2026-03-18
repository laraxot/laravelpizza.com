# File placement rules

## What belongs inside a Laravel module

A Laravel module directory (e.g. `Modules/Cms/`) must contain only Laravel framework classes and related assets:

| Allowed | Examples |
|---------|---------|
| Models | `app/Models/Page.php` |
| Actions | `app/Actions/SavePageAction.php` |
| Filament resources | `app/Filament/Resources/PageResource.php` |
| Controllers | `app/Http/Controllers/PageController.php` |
| Livewire / Volt components | `app/Http/Livewire/Page/Show.php` |
| Service providers | `app/Providers/CmsServiceProvider.php` |
| Migrations | `database/migrations/` |
| Factories | `database/factories/` |
| Seeders | `database/seeders/` |
| Tests | `tests/Feature/`, `tests/Unit/` |
| Language files | `lang/` |
| Views | `resources/views/` |
| Module docs | `docs/` |

## What does NOT belong inside a Laravel module

| Not allowed | Correct location |
|-------------|-----------------|
| Standalone PHP scripts | `bashscripts/data/` or relevant category |
| Data generator scripts | `bashscripts/data/` |
| One-off analysis scripts | `bashscripts/analysis/` |
| Shell scripts | `bashscripts/` with appropriate subdirectory |
| CI/CD helper scripts | `bashscripts/` or `.github/` |

## The rule

If a PHP file does not declare a Laravel class (Model, Controller, Action, Resource, Provider, Livewire component, etc.), it does not belong in a module directory. It is a utility/script and must go in `bashscripts/`.

## How to categorise scripts in bashscripts/

```
bashscripts/
  data/        - Data generation, seeding, import/export scripts
  analysis/    - Code analysis and reporting scripts
  git/         - Git helpers and automation
  tools/       - General-purpose dev tooling
  docs/        - Documentation about the scripts themselves
  ai/          - AI/LLM tooling and rules
```

If no existing category fits, create a new clearly-named subdirectory.

## Real violation that prompted this rule

`Modules/Cms/generate_test_data.php` was a standalone test-data generator script with no class that extended any Laravel base. It was placed inside the Cms module directory, which made it appear to be module code when it was actually a cross-module utility script that also bootstrapped Gdpr, Lang, and Media factories.

Correct location: `bashscripts/data/generate_test_data.php`

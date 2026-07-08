# Project Structure & Modules

## Root Directory Roles
- `bashscripts/`: All automation, maintenance, and quality scripts.
- `docs/`: Centralized project-wide documentation.
- `.claude/docs/`, `.gemini/docs/`, `.iflow/docs/`: AI-specific context and instructions.
- `laravel/`: The main application root.
- `public_html/`: Web root for assets (includes symlinks to theme assets).

## Laravel Directory Breakdown
- `laravel/Modules/`: Core business logic divided into modules.
- `laravel/Themes/`: Frontend themes (e.g., Meetup, Sixteen).
- `laravel/bashscripts/`: (Legacy/Divergence) Scripts here should be moved to the root `bashscripts/`.
- `laravel/phpstan-stubs/`: Custom stubs for PHPStan Level 10 compliance.

## Module Structure (Standard)
Each module follows a strict internal structure:
- `app/Actions/`: Spatie Queueable Actions.
- `app/Filament/`: Resources, Pages, and Widgets.
- `app/Models/`: Eloquent models extending `XotBaseModel`.
- `app/Providers/`: Service Providers.
- `config/`: Configuration files.
- `database/migrations/`: Authoritative migrations (1 Table = 1 File).
- `docs/`: Module-specific documentation ("The Bible").
- `lang/`: JSON-driven translations.
- `tests/`: Pest PHP tests.

# Theme Documentation

This directory contains the documentation for the Meetup theme.

## Purpose

The purpose of this documentation is to provide comprehensive information about the Meetup's functionality, architecture, and usage. It aims to:
- Explain key features and their implementation details.
- Guide developers on how to use, extend, and maintain the theme.
- Ensure consistency with Laraxot architectural principles and coding standards.

## Structure

- `README.md`: This overview file.
- **Patterns & Architecture**:
    - [`volt-component-pattern.md`](./volt-component-pattern.md) - Pattern Volt Component con `new class extends Component`
    - [`helper-class-pattern.md`](./helper-class-pattern.md) - Pattern Helper Class per componenti Blade
    - [`agnostic-routing.md`](./agnostic-routing.md) - Routing agnostico con Laravel Folio
    - [`translations.md`](./translations.md) - Gestione traduzioni nel tema (namespace `pub_theme::`)
    - [`social-share.md`](./social-share.md) - Componente social share con Tailwind CSS
- **DevOps & Automation**:
    - [`github-bot-integration.md`](../../../.windsurf/rules/github-bot-integration.md) - GitHub Actions bot per commenti automatici
- Other Markdown files will detail specific aspects of the theme, such as:
    - `installation.md`
    - `usage.md`
    - `architecture.md`
    - `troubleshooting.md`

## Contribution

Developers are encouraged to contribute to this documentation to keep it accurate and up-to-date.

### Pages Structure & Data Loading

#### Events Page (`/events`)
- **Route**: Handles `/events` and other CMS pages via `Modules\Cms\Http\Controllers\PageController` (or Folio equivalent).
- **View**: `resources/views/pages/[slug].blade.php` acting as a wrapper.
- **Data Source**: Custom `BlockData` resolution.
    - **Configuration**: `config/local/laravelpizza/database/content/pages/events.json` defines the `query` parameters.
    - **Resolution**: `Modules\Cms\Datas\BlockData` constructor uses `ResolveBlockQueryAction` to fetch dynamic data (e.g., upcoming events) and merges it into the block's data.
    - **Strict Typing Note**: `HasBlocks::getBlocks` returns a standard `array` of `BlockData` objects to preserve this resolved data, bypassing `DataCollection` re-hydration which can cause data loss.
- **Component**: `resources/views/components/blocks/events/list.blade.php`.
    - **Props**: Receives `$eventsData` (array of `BlockData` objects).
    - **Visuals**: Uses Tailwind CSS grid layout.


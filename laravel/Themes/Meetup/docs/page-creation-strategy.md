# Page Creation Strategy: JSON-Driven Content Blocks

## Objective

To define and document the correct, "Laraxot"-aligned strategy for creating new content pages within the application, ensuring consistency, modularity, and adherence to the data-driven content approach.

## The Rule

New content pages (e.g., `contact`, `about`, `dashboard`, `profile`, `events`) should **not** be created as direct, standalone Blade files (e.g., `contact.blade.php`). Instead, their structure and content blocks must be defined by creating a `.json` file in the centralized content directory:

`/var/www/_bases/base_laravelpizza/laravel/config/local/laravelpizza/database/content/pages/`

The name of the JSON file (e.g., `contact.json`) will correspond to the page's `slug`.

## Reasoning

This JSON-driven page creation strategy is integral to the project's architecture and adheres to Laraxot principles:

1.  **Data-Driven Content:** The actual content of the page is stored as data (JSON), separating it from the presentation logic. This makes content easier to manage, localize, and update without touching Blade files directly.
2.  **Generic Folio Page Rendering:** A single, generic Laravel Folio Blade file (e.g., `Themes/Meetup/resources/views/pages/[slug].blade.php`) handles the routing for all dynamic content pages. This Blade file then uses an `x-page` component (from the `Cms` module) to read the corresponding JSON file based on the URL `slug` and render its content blocks.
3.  **Component Reuse (DRY Principle):** Content blocks defined within the JSON (e.g., `hero.main`, `features.grid`, `cta.banner`) directly reference reusable Blade components (e.g., `pub_theme::components.blocks.hero.main`). This drastically reduces code duplication and promotes consistency across different pages.
4.  **Separation of Concerns (SOLID):** Clearly delineates content definition (JSON) from rendering logic (Blade components) and routing (Folio).
5.  **Modularity:** Aligns with the modular architecture where page content can be managed and extended dynamically.
6.  **Maintainability:** Easier to update content or swap out block components without altering core page files.

## Example Workflow for Creating a New Page (e.g., "/about")

1.  **Create JSON File:**
    *   Create `/var/www/_bases/base_laravelpizza/laravel/config/local/laravelpizza/database/content/pages/about.json`.
    *   Populate it with `id`, `slug: "about"`, `title`, and `content_blocks` defining the desired page sections using `data.view` paths.
2.  **Ensure Generic Folio Page Exists:** Verify that `Themes/Meetup/resources/views/pages/[slug].blade.php` is configured to render dynamic pages.
3.  **Create Block Components:** Ensure all `data.view` paths referenced in `about.json` correspond to existing (or newly created) Blade component files (e.g., `pub_theme::components.blocks.text.basic` would map to `Themes/Meetup/resources/views/components/blocks/text/basic.blade.php`).

## Affected Files (Context)

*   `Themes/Meetup/resources/views/pages/[slug].blade.php` (generic renderer)
*   `config/local/laravelpizza/database/content/pages/*.json` (content definition)
*   `Modules/Cms/app/View/Components/Page.php` (component logic to read JSON and render blocks)

## Planned Next Steps

1.  Update `Themes/Meetup/docs/project-completion-plan.md` to explicitly state this JSON-driven page creation strategy, especially in Phase 1 (Frontend Foundation) and Phase 2 (Frontend Feature Development).
2.  When creating future pages (e.g., `dashboard`, `profile`), follow this documented strategy.

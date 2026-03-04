# Architectural Zen: Content and Workflow

This document codifies the "crystal clear" architectural rules for the Laravel Pizza project, ensuring a deep understanding of the system's conversion from its original structure to the Laraxot modular architecture.

## 1. Content-Driven Architecture (JSON)

Front-office pages are NOT defined by static HTML or complex controllers. Instead, they are data-driven:

- **Storage**: All content is stored as JSON files in `config/local/laravelpizza/database/content/pages/` (e.g., `home.json`, `contact.json`).
- **Structure**: Each JSON defines `content_blocks`, `sidebar_blocks`, and `footer_blocks`.
- **Renderer**: The `x-page` component (`Modules/Cms/resources/views/components/page.blade.php`) maps these JSON blocks to their respective views and data.
- **Conversion**: This structure mirrors the **Filament Form Builder** philosophy, allowing for a flexible, block-based UI.

## 2. Routing and Logic (Folio + Volt)

- **Folio**: Routing is handled by **Laravel Folio** in `Themes/Meetup/resources/views/pages/`.
- **Volt**: Interactivity is managed by **Laravel Volt** within the Folio blades.
- **Home Page**: The entry point `/it` (mapped to `index.blade.php`) uses `PageSlugMiddleware` and renders the `home` slug via `<x-page>`.

## 3. Middleware Integration

- **PageSlugMiddleware**: Dynamically assigns middleware based on the page slug stored in the JSON/Database. It allows for granular access control per page without static route definitions.

## 4. Asset Compilation Workflow

To see changes in the browser, follow this strict sequence:

1.  **Navigate** to the theme directory: `Themes/Meetup/`
2.  **Install** dependencies: `npm install`
3.  **Build** assets: `npm run build`
4.  **Deploy** to public root: `npm run copy` (Deploys compiled assets to `public_html/themes/Meetup`)

## 5. Tenant Resolution

- **Action**: `GetTenantNameAction` resolves the tenant context from the server name.
- **Console Robustness**: It fallback to `config('app.url')` when `$_SERVER['SERVER_NAME']` is unavailable, ensuring Artisan commands and queue workers are tenant-aware.

---

> [!IMPORTANT]
> This site is a high-fidelity conversion of `laravelpizza.com`. Every block in the JSON content must align with the visual and functional requirements of the original site.

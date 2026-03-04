# Layout Component Strategy: `x-layouts.app` vs `x-layouts.main`

## Objective

To clarify and formalize the hierarchy and correct usage of layout components (`x-layouts.app`, `x-layouts.main`, etc.) within the `Meetup` theme, ensuring consistency, proper structure, and adherence to the project's architectural principles.

## Problem Description

A recent discussion highlighted potential confusion or incorrect usage of layout components in Folio pages. Specifically, there was a point regarding whether `index.blade.php` should use `<x-layouts.public>` or `<x-layouts.app>`, and implicitly, how `x-layouts.main` fits into this structure.

## Analysis & Reasoning

The project's layout strategy follows a layered, hierarchical approach:

1.  **`x-layouts.main` (The Foundational HTML Document):**
    *   **Purpose:** This component (defined in `Themes/Meetup/resources/views/components/layouts/main.blade.php`) serves as the absolute base HTML structure.
    *   **Role:** It provides the barebones `<!DOCTYPE html>`, `<html>` tag, the `<x-metatags />` component (which renders the full `<head>`), and the `<body>` tag. It is purely an "HTML document wrapper" with minimal styling.
    *   **Usage:** It should primarily be extended by other, more specialized layout components (`x-layouts.app`, `x-layouts.guest`), not typically used directly by application pages.

2.  **`x-layouts.app` (The Primary Application Layout):**
    *   **Purpose:** This component (defined in `Themes/Meetup/resources/views/components/layouts/app.blade.php`) acts as the standard application layout that wraps most of the actual page content.
    *   **Role:** It **extends `x-layouts.main`** and integrates the site's consistent themed header (via `<x-section slug="header" tpl="v1" />`), a main content wrapper, and the site's footer (via `<x-section slug="footer" />`). It provides the full, consistent UI/UX experience for authenticated or general public application pages.
    *   **Usage:** This is the layout component that primary application pages (like `index.blade.php`, `events.blade.php`, `dashboard.blade.php`, etc.) should use to ensure they inherit the global site structure.

3.  **`x-layouts.guest` (The Authentication/Guest Layout):**
    *   **Purpose:** This component is specifically designed for authentication-related pages (login, registration, password recovery).
    *   **Role:** It **extends `x-layouts.main`** and provides a simplified or custom layout optimized for guest users, typically without the full navigation bar and footer of the main application. This allows for focused, distraction-free auth flows.
    *   **Usage:** Pages like `login.blade.php`, `register.blade.php`, `forgot-password.blade.php`, etc., should use `<x-layouts.guest>`.

**Conclusion:**

For most application pages requiring the full themed header, footer, and consistent styling, **`<x-layouts.app>` is the correct layout component to use.** For authentication-related pages, **`<x-layouts.guest>` is the correct choice,** offering a streamlined experience. `<x-layouts.main>` serves as the fundamental base HTML structure extended by these higher-level layouts.

## Affected File (Context)

*   `Themes/Meetup/resources/views/pages/index.blade.php` (already correctly uses `<x-layouts.app>`).

## Planned Next Steps

1.  Confirm that `Themes/Meetup/resources/views/pages/index.blade.php` (and other application pages like `login.blade.php`, `register.blade.php`) indeed use `<x-layouts.app>`.
2.  Update relevant project documentation (e.g., `project-completion-plan.md` or `folio-volt-best-practices.md`) to explicitly state this layout component strategy.
3.  Inform the user of this clarification and the consistency achieved.

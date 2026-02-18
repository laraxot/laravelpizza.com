# Blade Logic Separation: Content Resolution

## The Problem

Previously, the `content-resolver` Blade component (`Themes/Meetup/resources/views/components/blocks/content-resolver.blade.php`) contained significant business logic. This included:

*   Direct Eloquent model queries (e.g., `Event::where('slug', $slug0)->first()`, `PageModel::firstWhere('slug', $fullSlug)`).
*   Complex conditional logic to determine content type and appropriate view.
*   Extensive variable assignment and state management within the Blade's `@php` block.

This approach violated the core Laraxot principles of **Separation of Concerns (KISS, SOLID)**, making the component difficult to test, maintain, and scale. Blade templates are strictly for presentation, and should not contain business logic.

## The Solution

To adhere to Laraxot's architectural guidelines and promote clean code, all business logic related to content resolution has been extracted from the Blade component and encapsulated within a dedicated Spatie Queueable Action.

### New Action: `Modules\Cms\Actions\ResolvePageContentAction`

This action now handles:

1.  **Dynamic Model Loading**: Resolving content from dynamic models (e.g., `Event` models for `/events/{slug}`).
2.  **CMS Page Lookup**: Identifying and loading static CMS pages based on various slug patterns.
3.  **Content Type Determination**: Deciding whether the content is a dynamic item or a static page.
4.  **View Selection**: Determining the appropriate Blade view or component to render the resolved content.

The `ResolvePageContentAction` takes `$container0` and `$slug0` as input and returns a structured array containing `content`, `contentType`, `view`, and `pageSlug`.

### Refactored Blade Component: `content-resolver.blade.php`

The `content-resolver` Blade component has been significantly simplified. It now performs the following steps:

1.  Receives `$container0` and `$slug0` via `@props`.
2.  Calls the `ResolvePageContentAction` to get the resolved content data:
    ```php
    @php
        $resolvedContent = app(\Modules\Cms\Actions\ResolvePageContentAction::class)->execute($container0, $slug0);
        $content = $resolvedContent['content'];
        $view = $resolvedContent['view'];
        $pageSlug = $resolvedContent['pageSlug'];
    @endphp
    ```
3.  Uses the returned `$content`, `$view`, and `$pageSlug` to conditionally render the appropriate sub-views or components, delegating the rendering logic to specialized components (e.g., `@include('pub_theme::'.$view, ...)` or `<x-page :slug="$pageSlug" .../>`).

## Architectural Principle Reinforced

This refactoring reinforces the critical Laraxot principle that:

**Complex PHP logic, especially database queries and intricate conditional content resolution, MUST reside in dedicated Actions or Models, NOT directly within Blade components or views.**

Blade templates (including generic Folio pages and Blade components) are strictly for presentation. Business logic must be abstracted into reusable, testable, and maintainable units that are invoked by the presentation layer.

## Impact

*   **Improved Testability**: The `ResolvePageContentAction` can now be easily unit tested in isolation.
*   **Enhanced Maintainability**: The `content-resolver` component is cleaner and easier to understand.
*   **Clearer Separation of Concerns**: Adherence to KISS and SOLID principles is significantly improved.
*   **Consistency**: Aligns with the overall Laraxot architecture emphasizing Actions over Services for business logic.
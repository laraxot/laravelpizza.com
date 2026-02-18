# Theme Blade Logic Separation: Content Resolution

## Architectural Principle

In the Laraxot framework, particularly within themes, a strict separation of concerns is enforced:

*   **Blade templates and components are for presentation ONLY.** They should focus solely on rendering HTML, displaying data, and handling basic presentation logic (e.g., loops, conditionals for UI elements).
*   **Business logic, data fetching, and complex content resolution MUST be abstracted.** These responsibilities belong in dedicated **Spatie Queueable Actions**, Eloquent Models, or Livewire components.

## Case Study: `content-resolver.blade.php` Refactoring

The `content-resolver` Blade component (located in `resources/views/components/blocks/content-resolver.blade.php`) previously contained significant business logic, including direct database queries and intricate conditional logic for resolving dynamic content (e.g., `Events`) or static CMS pages.

This approach was a violation of core Laraxot principles (KISS, SOLID) and led to:

*   **Poor Testability**: Logic embedded directly in Blade is hard to unit test.
*   **Reduced Maintainability**: Complex PHP blocks within templates make code difficult to understand and modify.
*   **Blurred Responsibilities**: The component acted as both a presenter and a controller/service.

## The Solution: Delegation to `ResolvePageContentAction`

To rectify this, all content resolution logic has been extracted into the `Modules\Cms\Actions\ResolvePageContentAction`.

The `content-resolver` Blade component now operates as follows:

1.  It receives `$container0` and `$slug0` as properties (e.g., from a Folio page like `[container0]/[slug0]/index.blade.php`).
2.  It delegates the heavy lifting of content resolution to the `ResolvePageContentAction`:
    ```php
    @php
        $resolvedContent = app(\Modules\Cms\Actions\ResolvePageContentAction::class)->execute($container0, $slug0);
        $content = $resolvedContent['content'];
        $view = $resolvedContent['view'];
        $pageSlug = $resolvedContent['pageSlug'];
    @endphp
    ```
3.  It then uses the structured data returned by the Action to conditionally render the appropriate sub-views or components (`@include('pub_theme::'.$view, ...)` or `<x-page :slug="$pageSlug" .../>`).

## Guidelines for Theme Developers

*   **Avoid Database Queries in Blade**: Never perform `Model::where(...)`, `DB::table(...)`, or similar database operations directly within Blade files.
*   **Abstract Business Logic**: Any logic that involves data manipulation, complex calculations, or decision-making should be moved into a Spatie Queueable Action.
*   **Use Actions for Data Preparation**: Actions are the preferred method for preparing data that needs to be displayed in your theme's components or pages.
*   **Keep Blade Components Lean**: Blade components should primarily focus on their presentational role. Pass prepared data to them via props.
*   **Refer to CMS Module Documentation**: For a deeper understanding of the `ResolvePageContentAction` and the overall content management architecture, consult `Modules/Cms/docs/blade-logic-separation.md`.
```
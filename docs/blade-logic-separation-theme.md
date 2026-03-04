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
3.  It then uses the structured data returned by the Action to conditionally render the appropriate sub-views or components, delegating the rendering logic to specialized components (e.g., `@include('pub_theme::'.$view, ...)` or `<x-page :slug="$pageSlug" .../>`).

## Guidelines for Theme Developers

*   **Avoid Database Queries in Blade**: Never perform `Model::where(...)`, `DB::table(...)`, or similar database operations directly within Blade files.
*   **Abstract Business Logic**: Any logic that involves data manipulation, complex calculations, or decision-making should be moved into a Spatie Queueable Action.
*   **Use Actions for Data Preparation**: Actions are the preferred method for preparing data that needs to be displayed in your theme's components or pages.
*   **Keep Blade Components Lean**: Blade components should primarily focus on their presentational role. Pass prepared data to them via props.
*   **Refer to CMS Module Documentation**: For a deeper understanding of the `ResolvePageContentAction` and the overall content management architecture, consult `Modules/Cms/docs/blade-logic-separation.md`.

## Folio and Volt Best Practices for Theme Developers

As a theme developer, understanding the correct integration of Laravel Folio and Volt is paramount for building robust, maintainable, and architecturally sound pages. Violating these principles can lead to unexpected behavior, inefficiencies, and maintenance headaches.

### 1. Leverage Automatic Route Parameter Binding

**Crucial Point:** Folio automatically injects route parameters directly into your Volt component's public properties.
```php
// In your theme's Volt page (e.g., resources/views/pages/[container0]/[slug0]/index.blade.php)
new class extends Component {
    public string $container0; // Folio automatically populates this from the URL segment
    public string $slug0;      // Folio automatically populates this from the URL segment
    // ... other component state
};
```
**Guidance:**
*   **NEVER** manually fetch route parameters using `request()->route('...')` within your Volt components. It's redundant and an anti-pattern.
*   Ensure your public properties match the route segment names exactly for automatic binding.

### 2. Utilize `mount()` for Initial Setup

**Crucial Point:** The `mount()` method is the dedicated lifecycle hook for initializing your Volt component's state.
```php
// In your theme's Volt page
new class extends Component {
    public string $container0;
    public string $slug0;
    public array $data = [];
    public string $pageSlug = '';

    public function mount(): void
    {
        // This is the ideal place for:
        // 1. Initializing other component properties (e.g., $this->pageSlug)
        // 2. Preparing data to pass to sub-components (e.g., $this->data)
        // 3. Triggering actions for initial data fetching (e.g., if you were directly fetching an Event model here)
        
        $this->pageSlug = $this->container0 . '.view'; // Example: Constructing the generic container view slug
        $this->data = [
            'container0' => $this->container0,
            'slug0' => $this->slug0,
        ];
    }
};
```
**Guidance:**
*   Place all logic required to set up the component's initial state or fetch its primary data within `mount()`.
*   Avoid executing complex setup logic directly in the general `@php` block outside `mount()`, as it might run on every render.

### 3. Adhere to Content Slug Conventions

**Crucial Point:** Consistent slug conventions are vital for the `x-page` component to correctly resolve content.
```php
// Example: Constructing the slug for a container's default view
$this->pageSlug = $this->container0 . '.view'; // E.g., 'events.view'
```
**Guidance:**
*   Understand and follow the project's established content slug conventions. For general container overviews (e.g., the main "Events" page), the format is typically `[container_name].view`.
*   Slugs like `[container_name].[item_slug]` are typically reserved for specific item detail pages.

### 4. Rely on `<x-page>` for Content Rendering and Data Flow to Plain Blade Blocks

**Crucial Point:** The `<x-page>` component is the central mechanism for rendering data-driven content in Laraxot.

When `x-page` renders a block component (e.g., `pub_theme::components.blocks.events.detail`), it does so via a plain Blade `@include`. This has significant implications for how data is received by these block components:
*   **Block components receive variables as plain PHP variables**, not as Volt component properties (`$this->...`).
*   The `block->data` array passed from `x-page` (which is populated by `ResolvePageContentAction`) becomes available as individual PHP variables in the included block.
*   **Block components (e.g., `components/blocks/events/detail.blade.php`) MUST NOT be Volt components.** They are plain Blade files that process these simple PHP variables.

```blade
{{-- In your theme's Folio page, after setting up $this->pageSlug and $this->data in mount() --}}
<x-page 
    side="content" 
    :slug="$this->pageSlug" 
    :data="$this->data"
    :container0="$this->container0" // Pass explicit context if needed by sub-components
    :slug0="$this->slug0"         // Pass explicit context if sub-components need it
/>
```
**Guidance:**
*   Always use `<x-page>` to display content resolved from JSON configurations.
*   Pass the computed `slug` (e.g., `$this->pageSlug`) and any necessary `$data` context to `<x-page>`. The `data` array will be merged with the data from the content block's JSON.
*   Child block components (located in `components/blocks/`) should expect to receive these as plain PHP variables and use `@php` blocks for any necessary logic, including fallback data fetching.
*   Avoid using custom, lower-level content resolution components directly within your Folio pages if `x-page` is designed to handle that. This ensures a consistent and predictable content rendering pipeline.
```
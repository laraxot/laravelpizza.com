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

## Folio and Volt Integration Best Practices

The architectural principles for separating logic from presentation are especially crucial when working with Laravel Folio and Volt components. Misunderstandings in how these technologies handle routing, component lifecycle, and data flow can lead to architectural violations.

### 1. Automatic Route Parameter Binding

**Problem:** Redundantly fetching route parameters within Volt components.
```php
// In a Volt component's backing class or @php block
$this->container0 = $this->container0 ?? request()->route('container0') ?? '';
$this->slug0 = $this->slug0 ?? request()->route('slug0') ?? '';
```
**Why it's wrong:** Laravel Folio automatically binds route parameters to public properties of a Volt component's backing class. Explicitly fetching them via `request()->route()` is unnecessary and deviates from the idiomatic way Folio/Volt are designed to operate.

**Best Practice:** Declare public properties in your Volt component's backing class with the same names as your Folio route parameters. Folio will automatically inject the values.
```php
// Correct Volt component backing class for a Folio route like [container0]/[slug0]/index.blade.php
new class extends Component {
    public string $container0; // Automatically populated by Folio
    public string $slug0;      // Automatically populated by Folio
    // ... other properties
};
```

### 2. `mount()` Method for Initialization Logic

**Problem:** Placing initialization logic directly in the Volt component's `@php` block, outside of the `mount()` method.
```php
// In a Volt component's @php block
// ...
// Volt has already populated $this->container0 and $this->slug0 automatically
$fullSlug = $this->container0 . '.' . $this->slug0;
$this->data = [
    'container0' => $this->container0,
    'slug0' => $this->slug0,
];
```
**Why it's inefficient/suboptimal:** The `mount()` method is a Livewire/Volt lifecycle hook that runs only once when the component is first initialized. It's the designated place for setting up initial state, fetching data, or performing calculations that depend on initial properties. Placing such logic directly in the general `@php` block risks it being executed on every subsequent render cycle (e.g., on Livewire updates), leading to inefficiencies and unintended side effects.

**Best Practice:** Move initialization logic into the `mount()` method.
```php
new class extends Component {
    public string $container0;
    public string $slug0;
    public array $data = [];
    public string $pageSlug = '';

    public function mount(): void
    {
        // Logic for initializing properties or fetching data
        $this->pageSlug = $this->container0 . '.view'; // Example: Correct slug construction
        $this->data = [
            'container0' => $this->container0,
            'slug0' => $this->slug0,
        ];
    }
};
```

### 3. Correct Slug Construction for Data-Driven Pages

**Problem:** Incorrectly constructing slugs, leading to improper content resolution.
```php
// Incorrect slug construction for a container's overview
$fullSlug = $this->container0 . '.' . $this->slug0; // Assumes slug0 is always present and defines the container view
```
**Why it's wrong:** The convention for retrieving the overview or default content for a "container" (e.g., a list of events) should not depend on a specific item's slug. The `[container0]` segment typically identifies the type of content, and a `.view` suffix (or similar) is used to denote the generic view for that container.

**Best Practice:** Use a consistent convention for container overview slugs, often incorporating `.view`.
```php
// Correct slug construction for a container's overview
$this->pageSlug = $this->container0 . '.view'; // E.g., 'events.view' for the main events page
```

### 4. Proper Use of `<x-page>` Component and Data Flow to Plain Blade Blocks

**Problem:** Using low-level content resolution components directly within Folio pages, bypassing the intended `<x-page>` architecture.
```blade
<x-blocks.content-resolver :container0="$this->container0" :slug0="$this->slug0" />
```
**Why it's an anti-pattern:** The `x-page` component is the standard for rendering content blocks based on a JSON configuration (referenced by a slug). It acts as the central orchestrator for data-driven page layouts. Direct use of a component like `<x-blocks.content-resolver />` (which encapsulates content resolution logic) violates the intended data flow and prevents `x-page` from correctly managing the overall page structure and data context.

**Best Practice:** Always use the `<x-page>` component for rendering dynamic content based on a content slug. Pass necessary context via its `data` prop.

When `x-page` renders a block component (e.g., `pub_theme::components.blocks.events.detail`), it does so via a plain Blade `@include`. This means:
*   **The block component receives variables as plain PHP variables**, not as Volt component properties (`$this->...`).
*   The `block->data` array passed from `x-page` (which is populated by `ResolvePageContentAction`) becomes available as individual variables in the included block.
*   **Block components (e.g., `components/blocks/events/detail.blade.php`) MUST NOT be Volt components.** They are plain Blade files that process these simple PHP variables.

```blade
<x-page 
    side="content" 
    :slug="$this->pageSlug" 
    :data="$this->data"
    :container0="$this->container0" // Pass explicit props if needed by sub-components
    :slug0="$this->slug0"         // Pass explicit props if needed by sub-components
/>
```
This ensures that the `x-page` component (which is designed for this purpose) handles the resolution and rendering of content based on the provided slug and data, maintaining architectural consistency. Child block components then receive and process this data as standard Blade variables.

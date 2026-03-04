# Event Rendering Flow in Meetup Theme

This document details how events are rendered in the Meetup theme, focusing on the interplay between the `events.json` configuration, the Folio page, and the Blade components, ensuring dynamic loading and SEO-friendly URLs.

## 1. Event Listing Page (`/it/events`)

The main event listing page is dynamically generated based on a JSON configuration file and rendered through a generic Folio page and a dedicated Blade component.

### Workflow:

1.  **`events.json` Configuration (`config/local/laravelpizza/database/content/pages/events.json`)**:
    *   This file defines the structure and content for the `/events` page.
    *   It contains a `content_blocks` array, where each block specifies its `type`, `slug`, and `data`.
    *   For the event list, a block is defined with `"type": "events"` and its `data` includes a `view` property pointing to the Blade component responsible for rendering (e.g., `"pub_theme::components.blocks.events.list"`).
    *   Crucially, the `data` also contains a `query` object that dictates how events should be fetched from the database (model, scope, order, limit).

2.  **Folio Page (`Themes/Meetup/resources/views/pages/[slug].blade.php`)**:
    *   This generic Folio page acts as the entry point for various dynamic content pages, including the event listing.
    *   It utilizes the `<x-page />` Blade component, passing the current URL's slug (`:slug="$slug"`).

3.  **`<x-page />` Component (`Modules/Cms/resources/views/components/page.blade.php`)**:
    *   This component is responsible for loading the appropriate JSON configuration (e.g., `events.json`) based on the provided slug.
    *   It then iterates through the `content_blocks` defined in the JSON. For each block, it dynamically includes the Blade view specified in `block->view`, passing all of `block->data` as properties.
    *   For the event listing, this means `pub_theme::components.blocks.events.list` is included with the `query` parameters from `events.json`.

4.  **Event List Blade Component (`pub_theme::components.blocks.events.list`)**:
    *   Located at `Themes/Meetup/resources/views/components/blocks/events/list.blade.php`.
    *   This component receives the `data` (which includes the `query` object) from the `x-page` component.
    *   It implements logic to check if `$events` are explicitly provided. If not, and a `query` object is present in `$data`, it constructs an Eloquent query using the `model`, `scope`, `orderBy`, `direction`, and `limit` specified in the `query`.
    *   The fetched `Modules\Meetup\Models\Event` models are then transformed into an array using their `toBlockArray()` method for display.
    *   The component also handles filtering (All, Upcoming, Past) using Alpine.js and renders each event.

## 2. Event Detail Pages (`/it/events/{slug}`)

Individual event detail pages are also handled dynamically, ensuring SEO-friendly URLs.

### Workflow:

1.  **Folio Page (`Themes/Meetup/resources/views/pages/[slug].blade.php`)**:
    *   This same generic Folio page is responsible for catching URLs that represent event slugs (e.g., `/it/events/my-awesome-meetup`).
    *   Inside the PHP section of this Folio page, there's logic that checks `request()->route('slug')`. If this slug is not an auth route or a locale, it attempts to find an `Event` model where its `slug` attribute matches the URL slug.
    *   If an `Event` is found, the Folio page renders the `pub_theme::components.blocks.events.detail` component, passing the found `Event` model instance as a prop.

2.  **Event Detail Blade Component (`pub_theme::components.blocks.events.detail`)**:
    *   This component (location to be verified, likely `Themes/Meetup/resources/views/components/blocks/events/detail.blade.php`) receives the `Event` model and is responsible for displaying its full details.

## 3. SEO and URL Generation

*   **Slug Attribute**: The `Modules\Meetup\Models\Event` model has a `slug` attribute. This attribute is crucial for generating clean, human-readable URLs.
*   **`toBlockArray()` Method**: In the `Event` model, the `toBlockArray()` method is used by the event list component to format event data. It explicitly constructs the `url` for each event using `'/it/events/'.(string) $this->slug`.
*   **Benefits**: This setup ensures that both event listing and detail pages benefit from dynamic content management and SEO-friendly URL structures, without requiring direct modification of routes for each new event or page.

## 4. Verification and Best Practices

*   Ensure that event slugs are unique and consistently populated (e.g., during event creation or import).
*   Verify the existence and correctness of `Themes/Meetup/resources/views/components/blocks/events/detail.blade.php` to ensure proper detail rendering.
*   Maintain PHPStan Level 10 compliance for all related components and models.

# Dynamic Event Loading and SEO-Friendly URLs in Meetup Module

This document outlines the mechanism for dynamically loading events and generating SEO-friendly URLs within the Meetup module, adhering to Laraxot principles.

## 1. Dynamic Event Loading

Events displayed on the frontend (e.g., at `/it/events`) are not hardcoded but are dynamically fetched from the database using the `Modules\Meetup\Models\Event` model. This process is orchestrated through JSON configuration files and Blade components.

### Workflow:

1.  **JSON Configuration (`events.json`)**:
    *   Files like `config/local/laravelpizza/database/content/pages/events.json` define content blocks for specific pages.
    *   For event listings, a `content_block` of type `events` is defined. This block includes a `data` key, which in turn contains a `query` object.
    *   The `query` object specifies the parameters for fetching events:
        *   `model`: The Eloquent model to query (e.g., `"Modules\Meetup\Models\Event"`).
        *   `scope`: An optional Eloquent scope to apply (e.g., `"upcoming"`, `"past"`).
        *   `orderBy`: The database column for ordering results (e.g., `"start_date"`).
        *   `direction`: The order direction (`"asc"` or `"desc"`).
        *   `limit`: The maximum number of events to retrieve.

    **Example `query` configuration in `events.json`:**
    ```json
    "query": {
        "model": "Modules\Meetup\Models\Event",
        "scope": "upcoming",
        "orderBy": "start_date",
        "direction": "asc",
        "limit": 50
    }
    ```

2.  **Blade Component (`pub_theme::components.blocks.events.list`)**:
    *   This component (located at `Themes/Meetup/resources/views/components/blocks/events/list.blade.php`) receives the `data` array (including the `query` object) from the JSON configuration.
    *   It checks if events are explicitly passed (e.g., hardcoded). If not, and a `query` object is present, it dynamically constructs an Eloquent query using the specified `model`, `scope`, `orderBy`, `direction`, and `limit`.
    *   The fetched `Event` models are then transformed into an array format using the `toBlockArray()` method for rendering.

## 2. SEO-Friendly URLs with Slugs

The system ensures that event detail pages use human-readable and SEO-friendly slugs instead of database IDs in their URLs.

### Workflow:

1.  **`Event` Model (`Modules\Meetup\app\Models\Event.php`)**:
    *   The `Event` model includes a `slug` attribute, which stores a unique, URL-friendly identifier for each event.
    *   The `toBlockArray()` method within the `Event` model is crucial for transforming the event data into a format expected by the Blade components. It now includes the following keys:
        *   `id`: The unique identifier of the event.
        *   `slug`: The SEO-friendly slug of the event.
        *   `status`: The event status (e.g., 'upcoming', 'past').
        *   `status_label`: The human-readable label for the event status.
        *   `title`: The title of the event.
        *   `description`: The description of the event.
        *   `date`: Formatted start date.
        *   `date_string`: Formatted start date (same as `date`).
        *   `time`: Formatted time range of the event.
        *   `location`: The physical location of the event.
        *   `attendees_current`: Current number of attendees.
        *   `attendees_max`: Maximum number of attendees.
        *   `image`: The URL to the event's cover image.
        *   `url`: The localized, SEO-friendly URL to the event's detail page.


2.  **Folio Page (`Themes/Meetup/resources/views/pages/[slug].blade.php`)**:
    *   This generic Folio page handles dynamic routes.
    *   It checks if the current URL slug (`request()->route('slug')`) corresponds to an `Event` model's slug.
    *   If a matching event is found (e.g., `Modules\Meetup\Models\Event::where('slug', $eventSlug)->first()`), it renders the `pub_theme::components.blocks.events.detail` component, passing the `Event` model instance.
    *   This means URLs like `/it/events/my-awesome-meetup` will correctly display the detail page for the event with the slug `my-awesome-meetup`.

### Importance of Slug Population:

For the system to function correctly with SEO-friendly URLs, it is critical that the `slug` attribute of the `Event` model is consistently populated and unique. When events are imported (e.g., via `ImportEventsFromJsonAction.php`), the slug should be generated and saved alongside other event data.

## 3. Verification and Best Practices

*   **Slug Uniqueness**: Ensure that event slugs are unique across all events to prevent routing conflicts.
*   **`toBlockArray()`**: Any modifications to the `Event` model's `toBlockArray()` method should preserve the `slug`-based URL generation.
*   **PHPStan Compliance**: All related code (model, components) must pass PHPStan Level 10 analysis.
*   **Documentation**: Keep this documentation updated with any changes to the event loading or URL generation logic.

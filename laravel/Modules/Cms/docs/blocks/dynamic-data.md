# Dynamic Data Resolution in CMS Blocks

CMS blocks support dynamic data resolution from Eloquent models. This allows templates to display live data from the database instead of relying on static JSON files.

## How it works

The block component (e.g., `pub_theme::components.blocks.events.list`) detects a `query` configuration within its `data` property. When present, it executes the query and transforms the results using the model's `toBlockArray()` method.

### Configuration Structure

To enable dynamic data, add a `query` key to your block data in the page JSON:

```json
{
  "type": "events",
  "data": {
    "view": "pub_theme::components.blocks.events.list",
    "title": "Upcoming Events",
    "description": "Join us for pizza and Laravel discussions",
    "query": {
      "model": "Modules\\Meetup\\Models\\Event",
      "scope": "upcoming",
      "orderBy": "start_date",
      "direction": "asc",
      "limit": 50
    }
  }
}
```

### Parameters

- `model`: Fully qualified class name of the Eloquent model (required).
- `scope`: (Optional) Scope method to apply to the query (e.g., `upcoming`, `past`).
- `orderBy`: (Optional) Column to sort by (default: `created_at`).
- `direction`: (Optional) Sort direction (`asc` or `desc`, default: `desc`).
- `limit`: (Optional) Maximum number of records to fetch (default: 10).

## Model Transformation

The resolver automatically detects if a model has a `toBlockArray()` method. If it does, it uses it to transform each record into a frontend-compatible array. If not, it falls back to `toArray()`.

### Example `toBlockArray` Implementation

```php
public function toBlockArray(): array
{
    return [
        'status' => $this->start_date->isFuture() ? 'upcoming' : 'past',
        'title' => $this->title,
        'description' => $this->description,
        'date' => $this->start_date->format('F j, Y'),
        'time' => $this->start_date->format('g:i A').' - '.$this->end_date->format('g:i A'),
        'location' => $this->location,
        'attendees_current' => $this->attendees_count,
        'attendees_max' => $this->max_attendees,
        'url' => $this->url ?? "/it/events/".(string) $this->slug,
    ];
}
```

**Note**: For SEO-friendly URLs, the model should use its `slug` attribute instead of `id`.

## Related
- [Block Rendering](rendering.md)
- [Content Blocks](content-blocks.md)

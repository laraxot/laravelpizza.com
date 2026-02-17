# Dynamic Data Resolution in CMS Blocks

CMS blocks support dynamic data resolution from Eloquent models. This allows templates to display live data from the database instead of relying on static JSON files.

## How it works

The `BlockData` object detects a `query` configuration within its `data` property. When present, it uses `ResolveBlockQueryAction` to execute the query and merge the result into the block's data.

### Configuration Structure

To enable dynamic data, add a `query` key to your block data in the page JSON:

```json
{
  "type": "events",
  "data": {
    "view": "pub_theme::components.blocks.events.list",
    "query": {
      "model": "Modules\\Meetup\\Models\\Event",
      "wrap_in": "events",
      "scopes": ["upcoming"],
      "orderBy": "start_date",
      "direction": "asc",
      "limit": 10
    }
  }
}
```

### Parameters

- `model`: Fully qualified class name of the Eloquent model.
- `wrap_in`: (Optional) The key in which to wrap the resulting collection. If omitted, the results are merged directly.
- `scopes`: (Optional) Array of scopes to apply to the query.
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
        'title' => $this->title,
        'date' => $this->start_date->format('F j, Y'),
        'url' => route('events.show', $this),
    ];
}
```

## Related
- [Block Rendering](rendering.md)
- [Content Blocks](content-blocks.md)

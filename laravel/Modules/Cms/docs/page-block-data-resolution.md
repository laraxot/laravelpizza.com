# Page Block Data Resolution

## Issue Description
When resolving dynamic data for blocks (e.g., retrieving events based on a query configuration in `events.json`), the data was being correctly resolved in the `BlockData` constructor but was subsequently lost during the collection creation process.

The `BlockData` class extends `Spatie\LaravelData\Data`. When `BlockData::collection($items)` is called, it triggers `Data::collect($items)`. This method re-hydrates the objects, potentially discarding changes made to properties in the constructor if they don't match the input data structure or if the input data overrides them during the re-hydration process.

Additionally, a strict return type of `DataCollection` on `HasBlocks::getBlocks` was causing runtime errors when an array was returned.

## Solution
To ensure that resolved data (like `events` list) persists and is correctly passed to the view:

1.  **Direct Object Creation**: The `HasBlocks` trait now manually creates `BlockData` instances using `new BlockData(...)`. This ensures the constructor logic, which resolves the dynamic query and merges it into the `data` property, is executed and preserved.
2.  **Bypass Collection Re-hydration**: Instead of calling `BlockData::collection($instances)`, which would re-hydrate and lose the data, `HasBlocks::getBlocks` now returns the array of `BlockData` objects directly.
3.  **Return Type Relaxation**: The return type hint of `HasBlocks::getBlocks` and `HasBlocks::getBlocksBySlug` was relaxed to allow `array` in addition to `DataCollection`.
4.  **Component Property Update**: The `$blocks` property in `Modules/Cms/app/View/Components/Page.php` was updated to accept `DataCollection|array` to match the new return type of `getBlocksBySlug`.

## Implementation Details
- **`Modules/Cms/app/Models/Traits/HasBlocks.php`**: Updated `getBlocks` and `getBlocksBySlug` to return `array`.
- **`Modules/Cms/app/Datas/BlockData.php`**: Retained logic in `__construct` to resolve `query` parameters.
- **`Modules/Cms/app/View/Components/Page.php`**: Updated `$blocks` property type hint.

## Verification
This fix ensures that when `events.json` specifies a `query`, the `ResolveBlockQueryAction` is executed, the results are merged into the block's data, and this data is available in the Vue/Blade component as `$block->data['events']`.

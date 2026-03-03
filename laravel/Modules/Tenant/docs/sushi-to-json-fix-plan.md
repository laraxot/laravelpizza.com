# Tenant Module - SushiToJson Traits Fix Plan

## Problem Analysis

The `SushiToJson` and `SushiToJsons` traits in the Tenant module are calling undefined methods on models that use these traits. This is causing **90+ PHPStan errors** (65% of all remaining errors).

## Root Cause

The traits define methods that expect to be implemented by the using models, but the models don't implement them:

```php
// Tenant/app/Models/Traits/SushiToJson.php
// Lines 237-324: Calls to undefined methods
$this->getJsonFile();
$this->loadExistingData();
$this->saveToJson();
$this->authId();
$this->ensureDirectoryExists();
$this->findRowIndexById();
```

## Affected Models

### Models Using SushiToJson Trait
1. `Modules\Tenant\Models\TestSushiModel`
2. `Modules\Xot\Models\InformationSchemaTable`
3. `Modules\Geo\Models\Comune`

### Models Using SushiToJsons Trait
1. `Modules\Cms\Models\Attachment`
2. `Modules\Cms\Models\Menu`
3. `Modules\Cms\Models\Page`
4. `Modules\Cms\Models\PageContent`
5. `Modules\Cms\Models\Section`

## Required Methods

Each model using these traits MUST implement the following methods:

### 1. getJsonFile(): string
Returns the absolute path to the JSON file for the model.

```php
protected function getJsonFile(): string
{
    return storage_path('app/'.$this->getTable().'.json');
}
```

### 2. loadExistingData(): array
Loads existing data from the JSON file.

```php
protected function loadExistingData(): array
{
    if (! file_exists($this->getJsonFile())) {
        return [];
    }
    
    $content = file_get_contents($this->getJsonFile());
    if ($content === false) {
        return [];
    }
    
    $data = json_decode($content, true);
    return is_array($data) ? $data : [];
}
```

### 3. saveToJson(array $data): void
Saves data to the JSON file.

```php
protected function saveToJson(array $data): void
{
    $directory = dirname($this->getJsonFile());
    if (! is_dir($directory)) {
        mkdir($directory, 0755, true);
    }
    
    file_put_contents($this->getJsonFile(), json_encode($data, JSON_PRETTY_PRINT));
}
```

### 4. authId(): string
Returns the authenticated user ID.

```php
protected function authId(): string
{
    return (string) auth()->id();
}
```

### 5. ensureDirectoryExists(): void
Ensures the JSON file directory exists.

```php
protected function ensureDirectoryExists(): void
{
    $directory = dirname($this->getJsonFile());
    if (! is_dir($directory)) {
        mkdir($directory, 0755, true);
    }
}
```

### 6. findRowIndexById(string $id): int
Finds the index of a record by ID in the data array.

```php
protected function findRowIndexById(string $id): int
{
    $data = $this->loadExistingData();
    
    foreach ($data as $index => $row) {
        if (isset($row['id']) && (string) $row['id'] === $id) {
            return $index;
        }
    }
    
    return -1;
}
```

## Implementation Steps

### Step 1: Fix SushiToJson Trait
Update the trait to handle missing methods gracefully:

```php
// Tenant/app/Models/Traits/SushiToJson.php

// Add these method declarations
/**
 * Get the JSON file path for this model.
 * Must be implemented by the using class.
 */
abstract protected function getJsonFile(): string;

/**
 * Load existing data from JSON file.
 * Must be implemented by the using class.
 * 
 * @return array<int, array<string, mixed>>
 */
abstract protected function loadExistingData(): array;

/**
 * Save data to JSON file.
 * Must be implemented by the using class.
 * 
 * @param array<int, array<string, mixed>> $data
 */
abstract protected function saveToJson(array $data): void;

/**
 * Get the authenticated user ID.
 * Can be overridden by the using class.
 * 
 * @return string
 */
protected function authId(): string
{
    return (string) auth()->id();
}

/**
 * Ensure the JSON file directory exists.
 * Can be overridden by the using class.
 */
protected function ensureDirectoryExists(): void
{
    $directory = dirname($this->getJsonFile());
    if (! is_dir($directory)) {
        mkdir($directory, 0755, true);
    }
}

/**
 * Find row index by ID in data array.
 * Must be implemented by the using class.
 * 
 * @param string $id
 * @return int
 */
abstract protected function findRowIndexById(string $id): int;
```

### Step 2: Implement Methods in Models

#### For Modules\Xot\Models\InformationSchemaTable

```php
// Xot/app/Models/InformationSchemaTable.php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

protected function getJsonFile(): string
{
    return database_path('schemas/'.$this->getTable().'.json');
}

protected function loadExistingData(): array
{
    if (! File::exists($this->getJsonFile())) {
        return [];
    }
    
    $content = File::get($this->getJsonFile());
    $data = json_decode($content, true);
    
    return is_array($data) ? $data : [];
}

protected function saveToJson(array $data): void
{
    $directory = dirname($this->getJsonFile());
    if (! File::isDirectory($directory)) {
        File::makeDirectory($directory, 0755, true);
    }
    
    File::put($this->getJsonFile(), json_encode($data, JSON_PRETTY_PRINT));
}

protected function findRowIndexById(string $id): int
{
    $data = $this->loadExistingData();
    
    foreach ($data as $index => $row) {
        if (isset($row['table_name']) && $row['table_name'] === $id) {
            return $index;
        }
    }
    
    return -1;
}
```

#### For Cms Models (Attachment, Menu, Page, PageContent, Section)

```php
// Modules/Cms/models/Attachment.php (and others)

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

protected function getJsonFile(): string
{
    return storage_path('app/cms/'.$this->getTable().'/'.app()->getLocale().'.json');
}

protected function loadExistingData(): array
{
    if (! File::exists($this->getJsonFile())) {
        return [];
    }
    
    $content = File::get($this->getJsonFile());
    $data = json_decode($content, true);
    
    return is_array($data) ? $data : [];
}

protected function saveToJson(array $data): void
{
    $directory = dirname($this->getJsonFile());
    if (! File::isDirectory($directory)) {
        File::makeDirectory($directory, 0755, true);
    }
    
    File::put($this->getJsonFile(), json_encode($data, JSON_PRETTY_PRINT));
}

protected function findRowIndexById(string $id): int
{
    $data = $this->loadExistingData();
    
    foreach ($data as $index => $row) {
        if (isset($row['id']) && (string) $row['id'] === $id) {
            return $index;
        }
    }
    
    return -1;
}
```

### Step 3: Add Missing Static Methods to InformationSchemaTable

```php
// Xot/app/Models/InformationSchemaTable.php

/**
 * Get the model count for this table.
 *
 * @return int
 */
public static function getModelCount(): int
{
    return self::count();
}

/**
 * Update model count for this table.
 */
public static function updateModelCount(): void
{
    $model = self::first();
    if ($model === null) {
        return;
    }
    
    $model->update([
        'model_count' => self::count(),
    ]);
}
```

## Verification

### Run PHPStan
```bash
./vendor/bin/phpstan analyse Modules/Tenant --level=10
./vendor/bin/phpstan analyse Modules/Xot --level=10
./vendor/bin/phpstan analyse Modules/Cms --level=10
```

### Expected Result
- **Before**: 90+ errors from SushiToJson traits
- **After**: 0 errors from SushiToJson traits

## Testing

### Test JSON File Operations
```php
// Test that methods work correctly
$attachment = Attachment::factory()->create();
$attachment->title = 'Test';
$attachment->saveToJson([
    'id' => $attachment->id,
    'title' => 'Test',
]);

$this->assertFileExists($attachment->getJsonFile());
```

### Test Data Loading
```php
// Test that data loads correctly
$page = Page::first();
$data = $page->loadExistingData();

$this->assertIsArray($data);
$this->assertNotEmpty($data);
```

## Documentation Updates

### Update Trait Documentation
```php
// Tenant/app/Models/Traits/SushiToJson.php

/**
 * Trait for Sushi models that can persist to JSON files.
 *
 * Models using this trait MUST implement the following methods:
 * - getJsonFile(): string - Path to JSON file
 * - loadExistingData(): array - Load data from JSON
 * - saveToJson(array): void - Save data to JSON
 * - findRowIndexById(string): int - Find record index by ID
 *
 * Optional methods (can be overridden):
 * - authId(): string - Get authenticated user ID
 * - ensureDirectoryExists(): void - Ensure directory exists
 *
 * @phpstan-require-extends \Illuminate\Database\Eloquent\Model
 */
trait SushiToJson
{
    // Trait implementation
}
```

### Update Model Documentation
```php
// Xot/app/Models/InformationSchemaTable.php

/**
 * Modules\Xot\Models\InformationSchemaTable.
 *
 * Uses SushiToJson trait for JSON persistence.
 * Implements required methods: getJsonFile(), loadExistingData(),
 * saveToJson(), findRowIndexById().
 */
class InformationSchemaTable extends BaseModel
{
    use SushiToJson;
    
    // Method implementations
}
```

## Performance Considerations

### File System Caching
- Use Laravel's cache for frequently accessed JSON files
- Consider using Redis for distributed systems

### Async Operations
- For large datasets, consider queueing JSON operations
- Use Laravel's queue system for background processing

## Migration Checklist

- [ ] Update SushiToJson trait with abstract methods
- [ ] Implement required methods in InformationSchemaTable
- [ ] Implement required methods in Cms models (5 models)
- [ ] Implement required methods in Geo\Models\Comune
- [ ] Add static methods to InformationSchemaTable
- [ ] Run PHPStan to verify fixes
- [ ] Run tests to ensure functionality
- [ ] Update trait and model documentation
- [ ] Test JSON file operations
- [ ] Test data loading and saving

## Expected Impact

- **Errors Fixed**: 90+ PHPStan errors
- **Percentage**: 65% reduction in total errors
- **New Total**: ~48 errors (from 138)
- **Functionality**: JSON persistence works correctly for all models

## Next Steps After Fix

1. Fix XotBaseEditRecord schema type issue (1 error)
2. Fix Blog module errors (6 errors)
3. Fix Cms module remaining errors (8 errors)
4. Fix Fixcity module errors (45 errors)
5. Fix Geo module errors (10 errors)
6. Fix remaining module errors

## Conclusion

The SushiToJson traits are causing the majority of PHPStan errors because they call methods that aren't implemented in the using models. By:

1. Making the required methods abstract in the trait
2. Implementing them in all affected models
3. Adding proper type hints and documentation

We can eliminate 90+ errors and achieve a 65% reduction in total PHPStan errors.
# Cms Module - PHPStan Level 10 Fix Plan

## Analysis Date
2026-03-02

## Error Summary
**Total Errors**: 8 errors across 5 files

## Error Analysis

### 1. Missing BlockData Class (3 errors)

**Files**:
- `app/Models/Page.php:195`
- `app/View/Components/Page.php:40`
- `app/View/Components/Section.php:25`

**Issue**: PHPStan cannot find `Modules\Cms\Models\BlockData` class

**Root Cause**: BlockData class doesn't exist or is in wrong namespace

**Fix Strategy**:

#### Option 1: Create BlockData Class (RECOMMENDED)

Create a Data Transfer Object for block data:

```php
<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use Spatie\LaravelData\Data;

/**
 * Block Data Transfer Object
 *
 * Represents a block of content with metadata
 *
 * @property string $id
 * @property string $type
 * @property string $content
 * @property array<string, mixed> $metadata
 * @property int $position
 * @property bool $is_active
 */
class BlockData extends Data
{
    public function __construct(
        public string $id,
        public string $type,
        public string $content,
        public array $metadata = [],
        public int $position = 0,
        public bool $is_active = true,
    ) {}

    /**
     * Create from array
     *
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? throw new \InvalidArgumentException('Missing id'),
            type: $data['type'] ?? throw new \InvalidArgumentException('Missing type'),
            content: $data['content'] ?? '',
            metadata: $data['metadata'] ?? [],
            position: $data['position'] ?? 0,
            is_active: $data['is_active'] ?? true,
        );
    }
}
```

Update Page model:
```php
/**
 * Get blocks by slug.
 *
 * @param string $slug
 * @return array<int, BlockData>
 */
public static function getBlocksBySlug(string $slug): array
{
    $page = self::where('slug', $slug)->first();

    if (!$page) {
        return [];
    }

    return array_map(
        fn ($block) => BlockData::fromArray($block),
        $page->blocks ?? []
    );
}
```

Update Page component:
```php
/** @var array<int, BlockData> $blocks */
$blocks = Page::getBlocksBySlug($this->slug);
```

#### Option 2: Use Existing Data Class

Check if there's already a data class and update namespace:

```php
// If BlockData exists in Modules\Cms\Datas
use Modules\Cms\Datas\BlockData as BlockDataDTO;
```

### 2. Missing Static Methods (3 errors)

**Files**:
- `app/Http/Middleware/PageSlugMiddleware.php:32`
- `app/View/Components/Page.php:39`
- `app/View/Components/Section.php:55`

#### Missing getMiddlewareBySlug()

**File**: `app/Http/Middleware/PageSlugMiddleware.php:32`

**Fix Strategy**:

Add static method to Page model:

```php
/**
 * Get middleware configuration by slug.
 *
 * @param string $slug
 * @return array<int, string>
 */
public static function getMiddlewareBySlug(string $slug): array
{
    $page = self::where('slug', $slug)->first();

    if (!$page) {
        return [];
    }

    return $page->middleware ?? [];
}
```

Or convert to instance method:

```php
// In middleware
$page = Page::where('slug', $slug)->first();
$middleware = $page?->getMiddleware() ?? [];
```

#### Missing getBlocksBySlug()

Already documented above.

### 3. Property Type Issues (2 errors)

**Files**:
- `app/View/Components/Page.php:40`
- `app/View/Components/Section.php:56`

**Issue**: Property type mismatch - expects array<string, BlockData> but receives array

**Fix Strategy**:

Add proper type annotation:

```php
// In Page component
/** @var array<string, BlockData> $blocks */
$this->blocks = Page::getBlocksBySlug($this->slug);
```

Or cast to proper type:

```php
/** @var array<int, BlockData> $blocks */
$blocks = Page::getBlocksBySlug($this->slug);

/** @var array<string, BlockData> $blocksByName */
$blocksByName = [];

foreach ($blocks as $block) {
    $blocksByName[$block->id] = $block;
}

$this->blocks = $blocksByName;
```

### 4. UserContract Method Access (1 error)

**File**: `app/Http/Volt/Password/TokenComponent.php:61`

**Issue**: Call to undefined method `UserContract::save()`

**Fix Strategy**:

Use concrete model or update UserContract:

```php
// Option 1: Use concrete model
use Modules\User\Models\User;

/** @var User $user */
$user = auth()->user();
$user->save();

// Option 2: Type assertion
/** @var \Modules\User\Models\User $user */
$user = auth()->user();
$user->save();
```

## Implementation Steps

### Step 1: Create BlockData Class
```bash
# Create the Data Transfer Object
touch laravel/Modules/Cms/app/Models/BlockData.php
```

### Step 2: Update Page Model
- Add `getBlocksBySlug()` method with proper return type
- Add `getMiddlewareBySlug()` method
- Add PHPDoc annotations

### Step 3: Update View Components
- Add proper type annotations to $blocks property
- Cast arrays to correct types

### Step 4: Fix UserContract Usage
- Update TokenComponent to use concrete User model

### Step 5: Run PHPStan
```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Cms --level=10 --memory-limit=2G
```

### Step 6: Update Tests
- Test BlockData creation
- Test getBlocksBySlug() method
- Test getMiddlewareBySlug() method
- Test type safety

## Testing Strategy

### Unit Tests

```php
test('BlockData can be created from array', function () {
    $data = [
        'id' => 'test-block',
        'type' => 'text',
        'content' => 'Test content',
    ];

    $block = BlockData::fromArray($data);

    expect($block->id)->toBe('test-block');
    expect($block->type)->toBe('text');
});

test('Page can get blocks by slug', function () {
    $page = Page::factory()->create([
        'slug' => 'test-page',
        'blocks' => [
            ['id' => 'block-1', 'type' => 'text', 'content' => 'Test'],
        ],
    ]);

    $blocks = Page::getBlocksBySlug('test-page');

    expect($blocks)->toHaveCount(1);
    expect($blocks[0])->toBeInstanceOf(BlockData::class);
});

test('Page can get middleware by slug', function () {
    Page::factory()->create([
        'slug' => 'test-page',
        'middleware' => ['auth', 'verified'],
    ]);

    $middleware = Page::getMiddlewareBySlug('test-page');

    expect($middleware)->toContain('auth', 'verified');
});
```

### Integration Tests

```php
test('Page component renders with blocks', function () {
    $page = Page::factory()->create([
        'slug' => 'test-page',
    ]);

    $component = Livewire::test(Page::class, ['slug' => 'test-page']);

    $component->assertOk();
});
```

## Documentation Updates

1. Update Cms module README with BlockData usage
2. Document all static methods
3. Add type safety examples
4. Update AGENTS.md with Cms-specific patterns

## File Structure

```
Modules/Cms/
├── app/
│   ├── Models/
│   │   ├── BlockData.php        [NEW]
│   │   ├── Page.php             [UPDATE]
│   │   └── Section.php          [UPDATE]
│   ├── View/Components/
│   │   ├── Page.php             [UPDATE]
│   │   └── Section.php          [UPDATE]
│   └── Http/
│       ├── Middleware/
│       │   └── PageSlugMiddleware.php  [UPDATE]
│       └── Volt/
│           └── Password/
│               └── TokenComponent.php  [UPDATE]
└── tests/
    └── Unit/
        ├── BlockDataTest.php    [NEW]
        └── PageTest.php         [UPDATE]
```

## Success Criteria

✅ All 8 PHPStan errors resolved
✅ BlockData class created with proper types
✅ All static methods implemented
✅ All property types corrected
✅ All tests pass
✅ Documentation updated

## Timeline

- **Day 1**: Create BlockData class and update Page model
- **Day 2**: Update view components and middleware
- **Day 3**: Fix UserContract usage
- **Day 4**: Update tests and documentation

## Notes

- Cms module has relatively few errors (8)
- Main issue is missing BlockData class
- Type annotations need improvement
- Consider using Spatie Laravel Data for DTOs
- Static methods can be converted to scopes for better testability
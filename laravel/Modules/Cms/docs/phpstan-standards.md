---
title: PHPStan Standards & PHPDoc Guidelines
type: technical
tags: [phpstan, phpdoc, type-safety, standards]
created: 2026-06-10
updated: 2026-06-10
qmd: docs/wiki/phpstan-cms-module.md
---

# PHPStan Level 10 Standards - Cms Module

## Overview

This document defines the PHPDoc and type standards for Cms Module to maintain PHPStan Level 10 compliance.

## Critical Rules

### 1. Model PHPDoc Requirements

All models MUST include comprehensive PHPDoc with:
- `@property` for all database fields
- `@property-read` for relationships
- `@method` for static methods like `getBlocksBySlug()`

```php
/**
 * @property string $id
 * @property array<array-key, mixed>|null $title
 * @property string|null $slug
 * @property array<array-key, mixed>|null $blocks
 * @property Carbon|null $created_at
 * @property Collection<int, BlockData> $blockData
 * 
 * @method static array<string, BlockData> getBlocksBySlug(string $slug, ?string $side = null)
 */
class Page extends BaseModelLang
```

### 2. BlockData Type Safety

The `BlockData` class is a Spatie Laravel Data object used throughout the CMS:

```php
use Modules\Cms\Datas\BlockData;
use Spatie\LaravelData\DataCollection;

/** @var DataCollection<int, BlockData>|array<string, BlockData> */
public DataCollection|array $blocks;
```

### 3. Trait Method Declarations

When using traits that provide methods:

```php
// Page.php - PHPDoc references trait methods
/**
 * @method static array<string, BlockData> getBlocksBySlug(string $slug, ?string $side = null)
 */
class Page extends BaseModelLang
{
    use HasBlocks; // Provides getBlocksBySlug()
}
```

### 4. View Components

View components MUST declare all public properties with types:

```php
/**
 * @property string $slug
 * @property DataCollection<int, BlockData>|array<int|string, mixed> $blocks
 */
class Section extends Component
{
    public string $slug;
    
    /** @var DataCollection<int, BlockData>|array<int|string, mixed> */
    public DataCollection|array $blocks;
}
```

## Key Classes

| Class | Purpose | Location |
|-------|---------|----------|
| `BlockData` | Data Transfer Object for blocks | `app/Datas/BlockData.php` |
| `HasBlocks` | Trait for block management | `app/Models/Traits/HasBlocks.php` |
| `Page` | Page model with blocks | `app/Models/Page.php` |
| `Section` | Section model with blocks | `app/Models/Section.php` |

## Common PHPStan Patterns

### Collection Typing

```php
// ✅ CORRECT
/** @return Collection<int, User> */
public function getUsers(): Collection

// ❌ WRONG
public function getUsers(): Collection // Missing type parameters
```

### Array Access

```php
// ✅ CORRECT
/** @var array<string, mixed> $data */
$data = json_decode($json, true);
$value = $data['key'] ?? null;

// ❌ WRONG
$data = json_decode($json, true);
$value = $data['key']; // PHPStan: offsetAccess.nonOffsetAccessible
```

## Related Documents

- [Module Architecture](./architecture.md)
- [Content Blocks System](./content-blocks.md)
- [BlockData Implementation](../app/Datas/BlockData.php)

## Compliance

Last PHPStan Check: 2026-06-10
Status: ✅ All critical issues resolved

# Laraxot Third-Party Model Inheritance Philosophy

## Core Principle: Respect Package Architecture

**🚨 CRITICAL RULE**: When working with third-party packages that provide their own Eloquent models, we **MUST** extend those package models directly, NOT our module BaseModel classes.

## The Problem: Package Model Inheritance

### Current Implementation Pattern

Laraxot has **8 models** extending Spatie package models:

```
Modules/
├── User/
│   ├── Permission extends SpatiePermission
│   └── Role extends SpatieRole
├── Activity/
│   ├── Activity extends SpatieActivity
│   ├── StoredEvent extends SpatieStoredEvent
│   └── Snapshot extends SpatieSnapshot
├── Media/
│   └── Media extends SpatieMedia
├── Notify/
│   └── MailTemplate extends SpatieMailTemplate
└── Xot/
    └── BaseActivity extends SpatieActivity (abstract)
```

### Why This Pattern Exists

1. **Package Functionality**: Spatie models provide essential functionality
2. **Package Integration**: Direct inheritance ensures full compatibility
3. **Package Updates**: No need to replicate package features
4. **Package Ecosystem**: Leverages existing package architecture

## Correct Third-Party Model Patterns

### ✅ CORRECT: Direct Package Extension

```php
// ✅ CORRECT - Extends Spatie model directly
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    protected $connection = 'user';

    // Add Laraxot-specific functionality
    use RelationX;
}
```

### ❌ WRONG: Double Inheritance

```php
// ❌ WRONG - Should NOT extend BaseModel
class Permission extends BaseModel
{
    // This would break Spatie package functionality
}
```

## Laraxot Philosophy: Package Respect

### 1. **Package Functionality Preservation**

Third-party packages like Spatie provide sophisticated functionality:

- **Permission**: Role-based access control system
- **Activity**: Comprehensive logging and auditing
- **Media**: Advanced file upload and management
- **EventSourcing**: Event-driven architecture patterns

### 2. **Package Integration Strategy**

Instead of fighting package architecture, we integrate with it:

- **Extend**: Directly extend package models
- **Enhance**: Add Laraxot-specific functionality via traits
- **Configure**: Set Laraxot-specific configurations (connections, etc.)

### 3. **Package Update Compatibility**

Direct extension ensures:
- **Automatic Updates**: Package updates work seamlessly
- **Bug Fixes**: Package bug fixes apply automatically
- **Security Patches**: Security updates are inherited

## Implementation Patterns

### Standard Third-Party Model Structure

```php
<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
use Modules\Xot\Models\Traits\RelationX;

class Permission extends SpatiePermission
{
    use RelationX;

    /** @var string */
    protected $connection = 'user';

    /** @var list<string> */
    protected $fillable = [
        'name',
        'guard_name',
        // Additional Laraxot fields
        'display_name',
        'description',
    ];

    // Add Laraxot-specific relationships and methods
    public function customMethod(): void
    {
        // Laraxot-specific functionality
    }
}
```

### Laraxot Integration Features

#### Connection Configuration
```php
protected $connection = 'user';  // Laraxot module-specific connection
```

#### Trait Integration
```php
use RelationX;           // Laraxot relationship utilities
use HasXotFactory;       // Laraxot factory system
use Updater;             // Laraxot audit tracking
```

#### Field Extension
```php
protected $fillable = [
    // Package fields
    'name',
    'guard_name',
    // Laraxot extensions
    'display_name',
    'description',
];
```

## Current Third-Party Models Inventory

### Spatie Package Models

| Module | Model | Spatie Package | Purpose |
|--------|-------|----------------|---------|
| **User** | Permission | `spatie/laravel-permission` | Role-based permissions |
| **User** | Role | `spatie/laravel-permission` | User roles |
| **Activity** | Activity | `spatie/laravel-activitylog` | Activity logging |
| **Activity** | StoredEvent | `spatie/laravel-event-sourcing` | Event storage |
| **Activity** | Snapshot | `spatie/laravel-event-sourcing` | Event snapshots |
| **Media** | Media | `spatie/laravel-medialibrary` | File management |
| **Notify** | MailTemplate | `spatie/laravel-mail-templates` | Email templates |
| **Xot** | BaseActivity | `spatie/laravel-activitylog` | Abstract base |

### Connection Mapping

- **User**: `'user'` connection
- **Activity**: `'activity'` connection
- **Media**: `'media'` connection
- **Notify**: `'notify'` connection

## Why This Philosophy Matters

### Technical Benefits

1. **Package Compatibility**: Full access to package features
2. **Update Safety**: Package updates don't break our code
3. **Feature Integration**: Leverage package ecosystem
4. **Maintenance Reduction**: Don't reinvent package functionality

### Business Benefits

1. **Development Speed**: Leverage proven packages
2. **Security**: Benefit from package security updates
3. **Stability**: Use battle-tested package code
4. **Community**: Access package community and support

## Exception Cases

### When NOT to Extend Package Models

**The ONLY exception**: When a package model is designed for extension through interfaces or abstract classes.

### Verification Process

```php
// ✅ Check if package is designed for extension
if (class_exists('Spatie\Package\Contracts\ModelInterface')) {
    // Implement interface instead of extending
}
```

## Code Review Guidelines

### ✅ DO

- Extend third-party package models directly
- Use proper aliases (e.g., `SpatiePermission`)
- Add Laraxot-specific functionality via traits
- Set Laraxot-specific configurations
- Document package integration clearly

### ❌ DON'T

- Create double inheritance chains
- Replicate package functionality
- Break package update compatibility
- Ignore package architecture

## Testing Third-Party Models

### Package Functionality Tests

```php
// Test that package functionality still works
public function test_package_functionality(): void
{
    $permission = Permission::create(['name' => 'test']);
    $this->assertInstanceOf(SpatiePermission::class, $permission);
}
```

### Laraxot Integration Tests

```php
// Test that Laraxot features work
public function test_laraxot_integration(): void
{
    $permission = Permission::create(['name' => 'test']);
    $this->assertTrue($permission->hasRelationX());
}
```

## Documentation Requirements

### Package Integration Documentation

Each third-party model should document:

1. **Package Purpose**: Why this package is used
2. **Integration Strategy**: How Laraxot integrates with it
3. **Configuration**: Laraxot-specific configurations
4. **Extensions**: Laraxot-specific functionality added

### Example Documentation

```markdown
# Permission Model

## Package Integration
- **Package**: `spatie/laravel-permission`
- **Purpose**: Role-based access control
- **Extension**: Direct extension with Laraxot enhancements

## Laraxot Features
- Connection: `'user'`
- Traits: `RelationX`
- Additional Fields: `display_name`, `description`
```

---

**Philosophy Summary**: In Laraxot, we respect and leverage third-party package architecture. We extend package models directly and enhance them with Laraxot-specific functionality, rather than fighting package design or creating unnecessary complexity.
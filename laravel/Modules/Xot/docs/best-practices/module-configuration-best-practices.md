# Module Configuration Best Practices

## 📋 Overview

This document outlines the standard patterns and best practices for module configuration files in the Laravel Xot framework.

## 🎯 Purpose of Config Files

Module configuration files serve two main purposes:
1. **Module Metadata**: Basic information about the module
2. **Functional Configuration**: Settings that control module behavior

## 📁 Standard Structure

### Basic Module Information (Required)
```php
return [
    'name' => 'ModuleName',
    'description' => 'Module description',
    'icon' => 'heroicon-o-icon-name',
    'version' => '1.0.0',
];
```

### Complete Structure (Recommended)
```php
return [
    /*
    |--------------------------------------------------------------------------
    | Module Identity
    |--------------------------------------------------------------------------
    */
    'name' => 'ModuleName',
    'description' => 'Module description',
    'icon' => 'heroicon-o-icon-name',
    'version' => '1.0.0',

    /*
    |--------------------------------------------------------------------------
    | Navigation Configuration
    |--------------------------------------------------------------------------
    */
    'navigation' => [
        'enabled' => true,
        'sort' => 50,
        'group' => 'Category Name',
    ],

    /*
    |--------------------------------------------------------------------------
    | Routes Configuration
    |--------------------------------------------------------------------------
    */
    'routes' => [
        'enabled' => true,
        'middleware' => ['web', 'auth'],
        'prefix' => 'module-prefix',
    ],

    /*
    |--------------------------------------------------------------------------
    | Service Providers
    |--------------------------------------------------------------------------
    */
    'providers' => [
        'Modules\\ModuleName\\Providers\\ModuleNameServiceProvider',
    ],
];
```

## 🔧 Configuration Categories

### 1. Module Metadata
- `name`: Module display name
- `description`: Brief module description
- `icon`: Heroicon name for navigation
- `version`: Module version string

### 2. Navigation & UI
- `navigation.enabled`: Whether to show in admin menu
- `navigation.sort`: Menu position (lower numbers appear first)
- `navigation.group`: Menu group/category

### 3. Routing
- `routes.enabled`: Enable/disable module routes
- `routes.middleware`: Route middleware stack
- `routes.prefix`: URL prefix for module routes

### 4. Permissions & Security
```php
'permissions' => [
    'view' => 'module.view',
    'create' => 'module.create',
    'edit' => 'module.edit',
    'delete' => 'module.delete',
    'manage' => 'module.manage',
],
```

### 5. Feature Configuration
```php
'features' => [
    'feature_name' => env('MODULE_FEATURE_ENABLED', true),
    'another_feature' => env('MODULE_ANOTHER_FEATURE', false),
],
```

### 6. Environment-Based Settings
```php
'settings' => [
    'timeout' => env('MODULE_TIMEOUT', 30),
    'max_retries' => env('MODULE_MAX_RETRIES', 3),
    'cache_enabled' => env('MODULE_CACHE_ENABLED', true),
],
```

## 🌟 Best Practices

### 1. Use Environment Variables
```php
// GOOD: Environment-based configuration
'max_records' => env('MODULE_MAX_RECORDS', 100),

// BAD: Hard-coded values
'max_records' => 100,
```

### 2. Provide Sensible Defaults
```php
// Always provide default values for environment variables
'cache_ttl' => env('MODULE_CACHE_TTL', 3600),
```

### 3. Use Descriptive Comments
```php
/*
|--------------------------------------------------------------------------
| Cache Configuration
|--------------------------------------------------------------------------
|
| Settings for module caching to improve performance.
|
*/
'cache' => [
    'enabled' => true,
    'ttl' => 3600,
],
```

### 4. Organize Related Settings
```php
// Group related settings together
'api' => [
    'enabled' => true,
    'rate_limit' => 60,
    'timeout' => 30,
],
```

### 5. Follow Naming Conventions
- Use `snake_case` for array keys
- Use uppercase for environment variable names
- Prefix environment variables with module name

## 📊 Example: Employee Module Config

```php
return [
    'name' => 'Employee',
    'description' => 'Employee management and time tracking',
    'icon' => 'heroicon-o-user-group',
    
    'navigation' => [
        'enabled' => true,
        'sort' => 50,
        'group' => 'Human Resources',
    ],
    
    'work_hours' => [
        'default_start' => env('EMPLOYEE_DEFAULT_START', '09:00'),
        'default_end' => env('EMPLOYEE_DEFAULT_END', '17:00'),
    ],
    
    'features' => [
        'time_tracking' => env('EMPLOYEE_TIME_TRACKING', true),
        'gps_tracking' => env('EMPLOYEE_GPS_TRACKING', false),
    ],
];
```

## 🚨 Common Pitfalls

### 1. Missing Default Values
```php
// RISKY: No default value
'timeout' => env('MODULE_TIMEOUT'),

// SAFE: With default value
'timeout' => env('MODULE_TIMEOUT', 30),
```

### 2. Overly Complex Config
```php
// AVOID: Deeply nested structures
'settings' => [
    'level1' => [
        'level2' => [
            'level3' => [
                'value' => 'too_deep',
            ],
        ],
    ],
],
```

### 3. Hard-Coded Secrets
```php
// NEVER: Hard-code sensitive information
'api_key' => 'secret-key-123',

// ALWAYS: Use environment variables
'api_key' => env('MODULE_API_KEY'),
```

## 🔍 Validation Checklist

Before committing a config file, verify:

1. [ ] All environment variables have default values
2. [ ] No sensitive data is hard-coded
3. [ ] Configuration is properly organized into sections
4. [ ] Comments explain non-obvious settings
5. [ ] Follows naming conventions
6. [ ] No syntax errors (run `php -l config.php`)

## 📚 Related Documentation

- [PHP Array Configuration Best Practices](../php_array_configuration_best_practices.md)
- [Environment Configuration](../environment-configuration-issues.md)
- [Module Structure Guidelines](../module-structure.md)

---

*Last Updated: 2025-08-27*  
*Configuration Standards Version: 2.0*
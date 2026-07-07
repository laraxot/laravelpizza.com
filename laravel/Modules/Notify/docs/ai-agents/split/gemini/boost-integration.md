<laravel-boost-guidelines>
=== .ai/laravel-boost rules ===

# Laravel Boost AI Guidelines

## Laravel Boost Integration

Laravel Boost is an MCP server equipped with over 15 specialized tools designed to streamline AI-assisted coding workflows for Laravel development.

### Available MCP Tools

#### Core Application Tools

- **application-info**: Get PHP/Laravel versions, database details, package versions, and all Eloquent models
- **get-config**: Read configuration values using dot notation (e.g., "app.name", "database.default")
- **list-available-config-keys**: List all available configuration keys from config/*.php
- **get-absolute-url**: Convert relative URLs to absolute URLs for the application

#### Database Tools  

- **database-query**: Execute read-only SQL queries (SELECT, SHOW, EXPLAIN, DESCRIBE)
- **database-schema**: Read complete database schema with tables, columns, indexes, foreign keys
- **database-connections**: List configured database connection names

#### Development & Debugging Tools

- **tinker**: Execute PHP code in Laravel application context (like artisan tinker)
- **last-error**: Get details of the last backend error/exception
- **read-log-entries**: Read last N log entries from application log
- **browser-logs**: Read last N log entries from browser console (for frontend debugging)

#### Laravel Ecosystem Tools

- **list-artisan-commands**: List all available Artisan commands with parameters
- **list-routes**: List all routes (including Folio routes) with filters
- **search-docs**: Semantic search across 17,000+ Laravel-specific documentation points

#### Feedback & Reporting

- **report-feedback**: Report feedback about Boost or Laravel ecosystem experience

### Documentation Search Best Practices

The `search-docs` tool is the most powerful feature of Laravel Boost:

1. **Always use search-docs FIRST** before other approaches for Laravel ecosystem questions
2. **Pass multiple broad queries** for comprehensive results: `['authentication', 'middleware', 'routing']`
3. **Don't include package names** in queries - package info is auto-detected
4. **Use topic-based searches**: `'rate limiting'` not `'laravel 11 rate limiting'`
5. **Filter by packages** when you know specific packages: `packages: ['laravel/framework', 'livewire/livewire']`

### MCP Tool Usage Patterns

#### Application Discovery

```php
// Always start new projects with:
mcp__laravel-boost__application-info
// This gives you PHP version, Laravel version, installed packages, and all models
```

#### Database Work

```php
// Check schema before making changes:
mcp__laravel-boost__database-schema

// Test queries safely:
mcp__laravel-boost__database-query query:"SELECT * FROM users LIMIT 5"
```

#### Debugging Workflow

```php
// Check for errors:
mcp__laravel-boost__last-error

// Read application logs:
mcp__laravel-boost__read-log-entries entries:10

// Check browser console:
mcp__laravel-boost__browser-logs entries:5
```

#### Laravel Development

```php
// Check available commands:
mcp__laravel-boost__list-artisan-commands

// View routes:
mcp__laravel-boost__list-routes

// Test code snippets:
mcp__laravel-boost__tinker code:"User::count()"
```

### Custom AI Guidelines

To extend Laravel Boost with project-specific guidelines:

1. Create `.blade.php` files in `.ai/guidelines/` directory
2. Files are automatically included when running `boost:install`
3. Use Blade syntax for dynamic content
4. Follow naming convention: `feature-name.blade.php`

### Integration with Laravel Ecosystem

Laravel Boost provides version-specific guidance for:

- **Laravel Framework** (10.x, 11.x, 12.x)
- **Livewire** (2.x, 3.x) 
- **Filament** (3.x, 4.x)
- **Inertia** (Laravel, React, Vue)
- **Pest** testing framework
- **Tailwind CSS** (3.x, 4.x)
- **And many more packages**

### Best Practices

1. **Always use application-info first** to understand the project context
2. **Leverage search-docs extensively** for accurate, version-specific information  
3. **Use tinker for quick testing** instead of creating temporary files
4. **Check logs when debugging** using read-log-entries and browser-logs
5. **Validate database queries** with database-query before implementing
6. **Report issues** via report-feedback to improve the tool

### Error Handling

When encountering errors:

1. Check `last-error` for backend issues
2. Check `browser-logs` for frontend issues  
3. Read `read-log-entries` for detailed application logs
4. Use `tinker` to test problematic code snippets
5. Search documentation with `search-docs` for solutions

Laravel Boost is currently in beta and receives frequent updates. Always leverage the MCP tools for the most accurate, up-to-date Laravel development assistance.


---

## Cross-References

- ← [GEMINI Index](INDEX.md) — All Gemini guidelines
- ← [Main AI Docs Index](../INDEX.md) — Master index
- ← [../../../../laravel/GEMINI.md](../../../../laravel/../../../../laravel/GEMINI.md) — Original source


# Laravel Boost Guidelines

## 🚀 Quick Start

Laravel Boost is an MCP server that comes with powerful tools designed specifically for this application. Use them.

## 🛠️ Essential Commands

### Artisan Commands
- Use the `list-artisan-commands` tool when you need to call an Artisan command to double check the available parameters.

### URLs
- When sharing a project URL with the user, use the `get-absolute-url` tool to ensure correct scheme, domain/IP, and port.

### Tinker / Debugging
- Use the `tinker` tool when you need to execute PHP to debug code or query Eloquent models directly.
- Use the `database-query` tool when you only need to read from the database.

### Browser Logs
- Read browser logs, errors, and exceptions using the `browser-logs` tool from Boost.
- Only recent browser logs will be useful - ignore old logs.

## 🔍 Searching Documentation (Critically Important)

Boost comes with a powerful `search-docs` tool that should be used before any other approaches. This tool automatically passes a list of installed packages and their versions to the remote Boost API, so it returns only version-specific documentation specific for the user's circumstance. You should pass an array of packages to filter on if you know you need docs for particular packages.

### The 'search-docs' tool is perfect for all Laravel-related packages, including Laravel, Inertia, Livewire, Filament, Tailwind, Pest, Nova, Nightwatch, etc.

- You must use this tool to search for Laravel-ecosystem documentation before falling back to other approaches.
- Search the documentation before making code changes to ensure we are taking the correct approach.
- Use multiple, broad, simple, topic-based queries to start. For example: `['rate limiting', 'routing rate limiting', 'routing']`.
- Do not add package names to queries - package information is already shared. For example, use `test resource table`, not `filament 4 test resource table`.

### Available Search Syntax
- You can and should pass multiple queries at once. The most relevant results will be returned first.

1. Simple Word Searches with auto-stemming - query=authentication - finds 'authenticate' and 'auth'
2. Multiple Words (AND Logic) - query=rate limit - finds knowledge containing both "rate" AND "limit"
3. Quoted Phrases (Exact Position) - query="infinite scroll" - Words must be adjacent and in that order
4. Mixed Queries - query=middleware "rate limit" - "middleware" AND exact phrase "rate limit"
5. Multiple Queries - queries=["authentication", "middleware"] - ANY of these terms

## 🏗️ Foundation Rules

### Context
This application is a Laravel application with main Laravel ecosystem packages & versions below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.3.27
- filament/filament (FILAMENT) - v4
- laravel/folio (FOLIO) - v1
- laravel/framework (LARAVEL) - v12
- laravel/passport (PASSPORT) - v12
- laravel/pennant (PENNANT) - v1
- laravel/prompt (PROMPTS) - v0
- laravel/pulse (PULSE) - v1
- laravel/socialite (SOCIALITE) - v5
- livewire/flux (FLUXUI_FREE) - v2
- livewire/livewire (LIVEWIRE) - v3
- livewire/volt (VOLT) - v1
- larastan/larastan (LARASTAN) - v3
- laravel/mcp (MCP) - v0
- laravel/pint (PINT) - v1
- laravel/sail (SAIL) - v1
- pestphp/pest (PEST) - v3
- phpunit/phpunit (PHPUNIT) - v11
- rector/rector (RECTOR) - v2
- tailwindcss (TAILWINDCSS) - v3

## 📋 Conventions

- Follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## 🧪 Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove it works. Unit and feature tests are more important.

## 🏗️ Application Structure & Architecture

- Stick to existing directory structure - don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## 🎨 Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## 💬 Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

## 📝 Documentation Files

- Create documentation files only if explicitly requested by the user.

## 🐘 PHP Rules

- Always use curly braces for control structures, even if it has one line.

### Constructors
- Use PHP 8 constructor property promotion in `__construct()`.
    - `public function __construct(public GitHub $github) { }`
- Do not allow empty `__construct()` methods with zero parameters.

### Type Declarations
- Always use explicit return type declarations for methods and functions.
- Use appropriate PHP type hints for method parameters.

```php
protected function isAccessible(User $user, ?string $path = null): bool
{
    ...
}
```

### Comments
- Prefer PHPDoc blocks over comments. Never use comments within the code itself unless there is something _very_ complex going on.

### PHPDoc Blocks
- Add useful array shape type definitions for arrays when appropriate.

### Enums
- Typically, keys in an Enum should be TitleCase. For example: `FavoritePerson`, `BestLake`, `Monthly`.

---

**Version**: 2.0 (Refactor DRY + KISS)  
**File**: laravel-boost.md - Laravel Boost specific guidelines
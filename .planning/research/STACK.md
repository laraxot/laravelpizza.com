# Stack Research

**Domain:** Laravel Meetup Platform (Modular Laraxot)
**Researched:** 2026-03-05
**Confidence:** HIGH

## Recommended Stack

### Core Technologies

| Technology | Version | Purpose | Why Recommended |
|------------|---------|---------|-----------------|
| Laravel | 12.x | Backend Framework | Latest features, improved type safety, and first-party support for modern tooling. |
| PHP | 8.3+ | Programming Language | Performance improvements and modern syntax (readonly classes, typed constants). |
| Laravel Folio | 1.x | Routing | File-based routing for a clean, intuitive frontend structure. |
| Livewire + Volt | 4.x / 1.x | Reactive UI | Single-file reactive components; eliminates the need for separate JS frameworks. |
| Filament | 4.x | Admin Panel | Rapid development of back-office tools using Laraxot XotBase wrappers. |
| Tailwind CSS | v4.0 | Styling | Mobile-first, high-performance utility CSS with zero-runtime. |

### Supporting Libraries

| Library | Version | Purpose | When to Use |
|---------|---------|---------|-------------|
| Spatie Laravel Data | 4.x | DTOs | Strong typing for registration and event data. |
| Spatie Queueable Action | 1.x | Business Logic | Encapsulated, testable, and queueable domain operations. |
| Laravel Reverb | 1.x | Real-time | Live ticket counts and notification broadcasts. |
| Mcamara Localization | 2.x | Multi-language | SEO-friendly URL localization for Italian/English. |
| Spatie Media Library | 11.x | Asset Management | Handling event logos, sponsor images, and user avatars. |
| Spatie Activity Log | 4.x | Auditing | Tracking registrations and admin changes for compliance. |

### Development Tools

| Tool | Purpose | Notes |
|------|---------|-------|
| PHPStan | Static Analysis | Mandatory Level 10 for zero-error modular development. |
| Laravel Pint | Code Formatting | Standardizes PSR-12/Laravel style across all modules. |
| Pest | Testing Framework | Expressive TDD with 100% coverage mandate. |

## Installation

```bash
# Core (Standard Laravel 12 install)
composer require laravel/folio livewire/volt filament/filament:^4.0

# Supporting
composer require spatie/laravel-data spatie/laravel-queueable-action mcamara/laravel-localization spatie/laravel-medialibrary spatie/laravel-activitylog
php artisan reverb:install

# Dev dependencies
composer require --dev phpstan/phpstan nunomaduro/larastan pestphp/pest
```

## Alternatives Considered

| Recommended | Alternative | When to Use Alternative |
|-------------|-------------|-------------------------|
| Folio + Volt | Blade Controllers | Only for extremely simple sites without reactivity. |
| Filament | Nova | When a more traditional, non-Livewire admin is preferred (not recommended for Laraxot). |
| Reverb | Pusher/Ably | When managing a WebSocket server is not desired (adds cost). |

## What NOT to Use

| Avoid | Why | Use Instead |
|-------|-----|-------------|
| Bootstrap | Less performant and less flexible for custom Laraxot themes. | Tailwind CSS v4 |
| Inertia + React/Vue | Adds complexity of a separate JS build and state management. | Livewire + Volt |
| Traditional Web Routes | Harder to maintain in a modular "CMS-driven" architecture. | Laravel Folio |

## Stack Patterns by Variant

**If High Traffic (Global Meetups):**
- Use Redis for caching and session management.
- Because it handles high concurrency for ticket registrations better than file/database drivers.

**If Low Budget/Small Scale:**
- Use SQLite for testing and small tenant databases.
- Because it simplifies infrastructure and reduces costs.

## Version Compatibility

| Package A | Compatible With | Notes |
|-----------|-----------------|-------|
| Laravel 12 | PHP 8.2+ | Requirement for the core framework. |
| Filament 4 | Livewire 4 | Tightly integrated for the admin panel. |
| Folio 1.1 | Laravel 12 | Optimized for file-based routing in the latest version. |

## Sources

- Laravel Official Documentation (v12) — Core framework features.
- FilamentPHP Documentation — Admin panel standards.
- Laraxot Architectural Principles — Project-specific constraints.
- Spatie Package Documentation — Action and DTO patterns.

---
*Stack research for: Laravel Meetup Platform*
*Researched: 2026-03-05*

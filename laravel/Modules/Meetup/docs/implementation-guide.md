# Implementation Guide - LaravelPizza Meetup Platform

## Overview

This guide covers the implementation of the LaravelPizza developer meetup platform, built on Laravel 12 + Filament 5 + Laraxot modular architecture.

## Architecture

### Frontend: CMS-Driven Pages

Public pages are JSON files rendered by Folio catch-all routing. NO controllers, NO routes in web.php.

```
config/local/laravelpizza/database/content/pages/{slug}.json
    → Folio [slug].blade.php
    → Block components in Themes/Meetup/resources/views/components/blocks/
```

### Backend: Filament Admin

Admin panel uses Filament 5 with XotBase extensions. All resources extend `XotBaseResource`.

### Business Logic: Spatie Actions

```php
// CORRECT
app(CreateEventAction::class)->execute($eventData);

// WRONG - custom method
app(CreateEventAction::class)->createEvent($data);
```

## Database Schema (Meetup Module)

### Events Table
```sql
CREATE TABLE meetup_events (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    start_datetime TIMESTAMP NOT NULL,
    end_datetime TIMESTAMP NULL,
    venue_id BIGINT UNSIGNED NULL,
    max_attendees INT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL
);
```

### Speakers/Performers Table
```sql
CREATE TABLE meetup_performers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    bio TEXT,
    avatar VARCHAR(255) NULL,
    github_url VARCHAR(255) NULL,
    twitter_url VARCHAR(255) NULL,
    website_url VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### Event-Speaker Pivot (belongsToManyX)
```sql
CREATE TABLE meetup_event_performer (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_id BIGINT UNSIGNED NOT NULL,
    performer_id BIGINT UNSIGNED NOT NULL,
    talk_title VARCHAR(255) NULL,
    talk_description TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### Registrations Table
```sql
CREATE TABLE meetup_registrations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    status ENUM('registered', 'waitlisted', 'cancelled') DEFAULT 'registered',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

## Key Implementation Rules

1. **Relationships**: Use `belongsToManyX()` from RelationX trait, never `belongsToMany()`
2. **Migrations**: One table = one create migration, use `XotBaseMigration`
3. **Models**: Extend `XotBaseModel`, use `declare(strict_types=1)`
4. **Views**: Use `pub_theme::` namespace, never theme name directly
5. **SVG**: Files in `Modules/Meetup/resources/svg/`, use `<x-filament::icon icon="meetup-{name}" />`
6. **URLs**: `LaravelLocalization::localizeUrl('/path')` for all links
7. **Translations**: Never `->label()` in Filament components (AutoLabelAction handles it)
8. **Packages**: Add to module `composer.json`, then `composer go` from `laravel/`

## Filament Resources

All resources extend XotBase classes:

```php
class EventResource extends XotBaseResource
{
    protected static ?string $model = Event::class;
    protected static ?string $navigationIcon = 'meetup-icon-calendar';
}
```

## Content Pages (CMS-Driven)

Example event page JSON:
```json
{
    "slug": "events",
    "title": {"it": "Eventi", "en": "Events"},
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "data": {
                    "view": "pub_theme::components.blocks.hero.main",
                    "title": "Laravel Meetups",
                    "subtitle": "Unisciti alla community"
                }
            },
            {
                "type": "events-list",
                "data": {
                    "view": "pub_theme::components.blocks.events.list"
                }
            }
        ]
    }
}
```

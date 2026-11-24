---
qmd: "rules index"
issues: []
discussions: []
title: "Notify Module Rules Index"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
<<<<<<< HEAD
<<<<<<< .merge_file_G0ypNH
updated: 2026-11-23
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> .merge_file_XAUOJr
updated: 2026-08-24
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
<<<<<<< .merge_file_G0ypNH
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_XAUOJr
---

# Notify Module Rules Index

## Overview
This file documents the rules and standards specific to the Notify module.

## Module-Specific Rules

### Notification Delivery
- Use queueable notifications for async delivery
- Always implement fallback to database notification

### Mail Templates
- Store templates in `resources/views/vendor/notifications/`
- Use Blade components for reusable elements

### Channel Configuration
- Configure channels in `config/notifications.php`
- Support: mail, database, slack, twilio (optional)

## Best Practices

### Action Classes
- Create QueueableActions for notification sending
- Use Data Transfer Objects for notification data

### Testing
- Test each notification channel separately
- Mock external services in unit tests

## Architectural Violations — Do Not Repeat

### No HTTP controllers
Controllers are forbidden in all modules. Architecture = Folio + Volt + Filament only.
A `NotificationTrackingController` was found and removed. Email tracking must be implemented
as a Folio page + Action, not a controller.
See: [no-http-controllers.md](./no-http-controllers.md)

## Related Documentation
<<<<<<< HEAD
- [README](./README.md)
=======
<<<<<<< HEAD
<<<<<<< .merge_file_G0ypNH
<<<<<<< HEAD
- [README](./README.md)
=======
<<<<<<< HEAD
=======
>>>>>>> .merge_file_XAUOJr
- [README](./readme.md)
=======
- [README](./README.md)
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_G0ypNH
=======
- [README](./readme.md)
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_XAUOJr
- [phpstan](./phpstan.md)
- [No HTTP controllers](./no-http-controllers.md)

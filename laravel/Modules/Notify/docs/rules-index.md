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

## Related Documentation
- [README](./readme.md)
- [phpstan](./phpstan.md)

## Pre-Edit Rule Link

- [Pre-Edit Docs-First Rule](../../../../docs/rules/pre-edit-docs-first-rule.md)
- [Pre-Edit Docs-First Memory](../../../../docs/memory/pre-edit-docs-first-memory.md)
- [Pre-Edit Docs-First Skill](../../../../docs/skills/pre-edit-docs-first-skill.md)

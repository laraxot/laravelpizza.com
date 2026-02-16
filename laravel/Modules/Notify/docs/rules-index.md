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
- [README](./README.md)
- [phpstan](./phpstan.md)

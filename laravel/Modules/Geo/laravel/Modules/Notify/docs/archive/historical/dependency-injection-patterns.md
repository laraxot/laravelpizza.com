# Dependency Injection Pattern in QueueableActions

**Date**: 18 Dicembre 2025  
**Status**: ✅ Pattern Documented  
**Module**: Notify

## Overview

Documentation for the dependency injection pattern used in QueueableAction classes, specifically for the `SendRecordsNotificationBulkAction` and `SendRecordNotificationAction` which use runtime service resolution instead of constructor injection.

## Pattern Analysis

### Current Implementation

Both `SendRecordsNotificationBulkAction` and `SendRecordNotificationAction` follow a runtime service resolution pattern:

```php
// Instead of constructor injection:
// private readonly NormalizePhoneNumberAction $normalizePhoneAction
// public function __construct(NormalizePhoneNumberAction $normalizePhoneAction) { ... }

// The action uses runtime resolution:
$normalizedPhone = app(NormalizePhoneNumberAction::class)->execute($phone);
```

### Rationale

1. **Flexibility**: Runtime resolution allows for more flexible service usage
2. **Simplicity**: Reduces constructor complexity in QueueableActions
3. **On-demand**: Services are resolved only when actually needed
4. **Decoupling**: Reduces tight coupling between action and dependencies

### When to Use Runtime Resolution vs Constructor Injection

#### Runtime Resolution (`app()` calls) is preferred when:
- Service is used conditionally (not always needed)
- Multiple different services might be needed in different scenarios
- Want to reduce constructor complexity
- Service instance is only needed in specific methods
- Following the specific project pattern preference

#### Constructor Injection is preferred when:
- Service is always required for the action to function
- Want explicit dependency declaration
- Need to inject the same service multiple times
- Following strict dependency injection principles

## Implementation

### SendRecordNotificationAction
Uses `app(NormalizePhoneNumberAction::class)->execute()` for phone number normalization.

### SendRecordsNotificationBulkAction
Composes `SendRecordNotificationAction` using `app(SendRecordNotificationAction::class)->execute()`.

The action uses runtime service resolution in specific methods:
- `sendSms()`: Uses `app(NormalizePhoneNumberAction::class)` to normalize phone numbers
- `sendWhatsApp()`: Uses `app(NormalizePhoneNumberAction::class)` to normalize WhatsApp numbers

## Benefits of Current Approach

1. **Simplified Constructor**: The action has no constructor, making it cleaner
2. **Conditional Usage**: The normalization service is only used when needed
3. **Service Flexibility**: Easy to swap implementations if needed
4. **Architectural Consistency**: Follows the project's preferred pattern for this use case

## Code Example

```php
private function sendSms(Model $record, string $templateSlug): void
{
    $phone = $this->getRecordPhone($record);
    if (empty($phone)) {
        throw new Exception(__('notify::actions.send_notification_bulk.errors.phone_not_available'));
    }

    // Runtime resolution instead of constructor injection
    $normalizedPhone = app(NormalizePhoneNumberAction::class)->execute($phone);
    $recordNotification = new RecordNotification($record, $templateSlug);
    Notification::route('sms', $normalizedPhone)->notify($recordNotification);
}
```

## Architecture Compliance

This approach aligns with:
- **Laraxot Philosophy**: Flexible service resolution patterns
- **Clean Code Principles**: Appropriate tool for the specific use case
- **DRY + KISS**: Simple and effective implementation
- **Project Preferences**: Following established patterns in the codebase

---

*Documento conforme agli standard Laraxot - DRY + KISS + SOLID*
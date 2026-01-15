# Bulk Notification Action

**Date**: 18 Dicembre 2025  
**Status**: ✅ Implementation Complete  
**Module**: Notify

## Overview

The `SendNotificationBulkAction` allows users to send notifications in bulk to multiple records using various communication channels (mail, SMS, WhatsApp) with pre-defined templates.

## Architecture Pattern

### Components Structure
```
Notify Module
├── app/
│   ├── Actions/
│   │   └── SendRecordsNotificationBulkAction.php (QueueableAction)
│   └── Filament/
│       └── Actions/
│           └── SendNotificationBulkAction.php (Filament Action)
```

### Clean Code Principles Applied

1. **Separation of Concerns**: 
   - UI logic in Filament Action
   - Business logic in QueueableAction
   - Reusable across different resources

2. **Single Responsibility**: 
   - Each action has one specific purpose
   - Easy to test and maintain

3. **Reusability**: 
   - Actions can be used across multiple resources
   - Consistent behavior across the application

## Implementation Details

### QueueableAction: SendRecordsNotificationBulkAction

Handles the core business logic for sending notifications in bulk:
- Accepts a collection of Model records
- Uses MailTemplate slug to select notification template
- Supports multiple channels: mail, sms, whatsapp
- Handles errors gracefully with detailed logging
- Returns comprehensive result object

### FilamentAction: SendNotificationBulkAction

Handles the UI integration:
- Provides modal form with template selection
- Offers channel selection via checkboxes
- Handles user interaction
- Calls the QueueableAction
- Shows notifications to users

## Modal Form Components

### Template Selection
- **Field Type**: Select
- **Source**: MailTemplate::query()->pluck('name', 'slug')
- **Features**: Searchable, Preload
- **Validation**: Required

### Channel Selection
- **Field Type**: CheckboxList
- **Options**: mail, sms, whatsapp
- **Columns**: 3
- **Validation**: Required (at least one channel must be selected)

## Usage Pattern

```php
// In any Filament resource that supports notifications
use Modules\Notify\Filament\Actions\SendNotificationBulkAction;

public function getTableBulkActions(): array
{
    return [
        SendNotificationBulkAction::make(),
    ];
}
```

## Channel Support

### Mail
- Automatically detects email fields (email, pec, contact_email)
- Uses RecordNotification with Notification::route('mail', $email)

### SMS
- Automatically detects phone fields (mobile, phone, telephone, contact_phone)
- Normalizes phone numbers using NormalizePhoneNumberAction
- Uses RecordNotification with Notification::route('sms', $normalized_phone)

### WhatsApp
- Detects WhatsApp field, falls back to phone fields
- Extracts text content from template using SpatieEmail::buildSms()
- Uses WhatsAppNotification with Notification::route('whatsapp', $normalized_whatsapp)

## Benefits

1. **Clean Architecture**: Proper separation between UI and business logic
2. **Reusability**: Same action can be used across different resources
3. **Maintainability**: Changes to business logic only require updating one place
4. **Testability**: Each component can be tested independently
5. **Consistency**: Uniform behavior across the application
6. **Flexibility**: Supports multiple communication channels
7. **Error Handling**: Comprehensive error reporting and logging

## Error Handling

The action provides detailed error reporting:
- Invalid channel selection
- Missing contact information for records
- Channel-specific errors
- Aggregate success/error counts

## Translation Support

Full multi-language support with:
- Italian (it)
- English (en) 
- German (de)
- Spanish (es)
- French (fr)
- Polish (pl)

---

*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*
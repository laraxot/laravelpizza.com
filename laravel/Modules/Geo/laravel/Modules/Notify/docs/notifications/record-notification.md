# `RecordNotification`

This document describes the `RecordNotification` class, a Laravel Notification that acts as a **Bridge** between Laravel's notification system and the `SpatieEmail` mailable system. It delegates all template resolution, placeholder replacement, and layout logic to `SpatieEmail`, following the **Zen Delegation Pattern**.

## Location

`laravel/Modules/Notify/app/Notifications/RecordNotification.php`

## Purpose

To provide a thin wrapper that connects Laravel's Notification system to `SpatieEmail` for content generation. `RecordNotification` handles channel determination and notification orchestration, while delegating all content operations (template resolution, placeholder replacement, layout application) to the specialized `SpatieEmail` mailable.

## Key Features

*   **Zen Delegation Bridge**: Delegates all template/content logic to `SpatieEmail` mailable
*   **Channel Determination**: The `via()` method dynamically determines which channels are supported based on the notifiable's routing capabilities using `routeNotificationFor()`
*   **Content Generation**: `toMail()` and `toSms()` methods delegate completely to `SpatieEmail` for all content operations
*   **Protected Properties**: Uses `protected` properties (`$record`, `$slug`) to store notification data
*   **Custom Channel Integration**: Integrates with custom channels like `SmsChannel` (from `Modules\Notify\Channels\SmsChannel`)

## Constructor

```php
public function __construct(
    Model $record,
    string $slug
)
```
*   `$record`: The Eloquent model (e.g., `Client`) that is the recipient of the notification.
*   `$slug`: The logical identifier (string) of the notification type, used by `SpatieEmail` to resolve the `MailTemplate`.

**Zen Delegation Pattern**: The constructor stores only the record and slug. Template resolution happens later when `SpatieEmail` is instantiated in `toMail()` or `toSms()` methods. This ensures `RecordNotification` remains a pure bridge without duplicating template logic.

## Methods

### `via(object $notifiable): array<string|class-string>`

Determines the channels through which the notification should be sent. This method checks if the notifiable supports each channel using the `routeNotificationFor()` method.

*   **Returns:** An array of channel identifiers (strings or class names) that Laravel's Notification system will use.
*   **Mail Channel**: Added if `routeNotificationFor('mail')` returns a truthy value
*   **SMS Channel**: Added if `routeNotificationFor('sms')` returns a truthy value (uses `Modules\Notify\Channels\SmsChannel::class`)

**Implementation Details**:
- Checks if notifiable has `routeNotificationFor()` method
- Only adds channels that the notifiable can route to
- Returns empty array if notifiable doesn't support routing

### `toMail(object $notifiable): SpatieEmail`

Generates the email content for the notification by delegating completely to `SpatieEmail`.

**Implementation**:
1. Creates a new `SpatieEmail` instance with the record and slug (template resolution happens here)
2. Merges additional data using `mergeData()`
3. Adds attachments using `addAttachments()`
4. Sets recipient if available from `routeNotificationFor('mail')` for `envelope()` method
5. Returns the configured `SpatieEmail` instance

**Zen Delegation Pattern**: All template resolution, placeholder replacement, and layout logic (including seasonal layouts via `GetMailLayoutAction`) is handled by `SpatieEmail`. `RecordNotification` simply orchestrates and returns the configured mailable.

**Return Type**: Returns `SpatieEmail` directly (Laravel supports this pattern, as seen in `UserServiceProvider` with `ResetPassword::toMailUsing()`)

### `toSms(object $notifiable): ?SmsData`

Generates the SMS content for the notification by delegating to `SpatieEmail->buildSms()`.

**Implementation**:
1. Creates a new `SpatieEmail` instance with the record and slug
2. Merges additional data using `mergeData()`
3. Gets recipient phone number from `routeNotificationFor('sms')` or uses `config('sms.fallback_to')`
4. Builds SMS content using `SpatieEmail->buildSms()` method (which handles template resolution and Mustache placeholder replacement)
5. Wraps content in `SmsData` object and returns it, or returns `null` if no recipient found

**Zen Delegation Pattern**: SMS content generation is completely handled by `SpatieEmail->buildSms()`. `RecordNotification` only orchestrates recipient resolution and wraps the result in `SmsData`.

**Return Type**: Returns `?SmsData` for `Modules\Notify\Channels\SmsChannel` which expects `SmsData` instance.

### `mergeData(array $data): self`

Merges additional data that will be passed to `SpatieEmail` for placeholder replacement. This allows adding extra data that can be used in template placeholders beyond the record's own attributes.

**Parameters**:
- `$data`: Array of key-value pairs to merge

**Returns:** `$this` for method chaining

**Example:**
```php
$notification = new RecordNotification($record, 'notification-slug');
$notification->mergeData([
    'custom_field' => 'Custom Value',
    'timestamp' => now()->format('Y-m-d H:i:s'),
]);
// Data is passed to SpatieEmail->mergeData() when toMail() or toSms() is called
```

### `addAttachments(array $attachments): self`

Adds file attachments to the notification. These will be processed by `SpatieEmail` when the mail channel is used.

**Parameters**:
- `$attachments`: Array of attachment arrays, each containing at least `path`, optionally `as` (filename), and `mime`

**Returns:** `$this` for method chaining

**Example:**
```php
$notification->addAttachments([
    ['path' => storage_path('app/invoice.pdf'), 'as' => 'invoice.pdf', 'mime' => 'application/pdf'],
]);
// Attachments are passed to SpatieEmail->addAttachments() when toMail() is called
```

## Usage

This notification is typically instantiated and dispatched by an Action (e.g., `SendRecordNotificationAction`) that determines the specific recipient and template slug. The notification acts as a bridge that delegates all content operations to `SpatieEmail`.

**Example:**
```php
// ✅ CORRETTO: Pass record and slug - content generation delegated to SpatieEmail
$notification = new RecordNotification($client, 'welcome-customer');
$notification->mergeData(['custom_field' => 'value']);
$notification->addAttachments([...]);
$client->notify($notification);

// SpatieEmail handles:
// - Template resolution (firstOrCreate)
// - Placeholder replacement (Mustache)
// - Layout application (GetMailLayoutAction)
// - Seasonal layouts (via GetThemeContextAction)
```

**Zen Delegation Pattern**: `RecordNotification` serves as a bridge between Laravel's notification system and the `SpatieEmail` mailable system. All template resolution, placeholder replacement, and content generation is handled by `SpatieEmail`, maintaining absolute separation of concerns and DRY principle.

## Adherence to Laraxot Principles

*   **DRY (Don't Repeat Yourself):** Zero duplication - delegates content generation to `SpatieEmail`, avoiding duplicate template logic.
*   **KISS (Keep It Simple, Stupid):** Provides a clear interface that delegates complexity to the appropriate component (`SpatieEmail`). Thin wrapper, not God Object.
*   **Separation of Concerns:** `RecordNotification` focuses on channel determination and notification orchestration, while `SpatieEmail` handles all content operations.
*   **Zen Delegation:** Follows the bridge pattern where `RecordNotification` acts as a pure bridge between Laravel notifications and `SpatieEmail` mailables.
*   **Single Responsibility Principle (SRP):** `RecordNotification` = Bridge, `SpatieEmail` = Content Generation.

## Architecture Pattern

### The Bridge Pattern

```
Laravel Notification System
         ↓
RecordNotification (Bridge)
    - via() → Channel determination
    - toMail() → Returns SpatieEmail
    - toSms() → Uses SpatieEmail->buildSms()
         ↓
SpatieEmail (Specialized Agent)
    - Template resolution (firstOrCreate)
    - Placeholder replacement (Mustache)
    - Layout application (GetMailLayoutAction)
    - Seasonal layouts (GetThemeContextAction)
```

### Why This Is Better

1. **Single Source of Truth**: All template/content logic in `SpatieEmail`
2. **DRY**: Zero duplication - if you change placeholder logic, change only `SpatieEmail`
3. **Testability**: Test `SpatieEmail` separately, `RecordNotification` becomes thin wrapper
4. **Maintainability**: Changes to template system affect only `SpatieEmail`
5. **Consistency**: Same system (`SpatieEmail`) used for direct email sending and notifications

## Quality Assurance

### Static Analysis Results
*   **PHPStan Level 10**: ✅ Pass - No errors detected
*   **Type Safety**: ✅ All methods properly typed
*   **Autoloader**: ✅ Properly registered

### Key Quality Patterns
*   **Zen Delegation**: Properly delegates all content operations to `SpatieEmail`
*   **Type Safety**: Strong typing with `declare(strict_types=1)` declaration
*   **Method Chaining**: Consistent fluent interface for `mergeData()` and `addAttachments()`
*   **Null Safety**: Proper null checks for recipient resolution in `toSms()`

### Performance Considerations
*   **Lazy Instantiation**: `SpatieEmail` created only when `toMail()` or `toSms()` is called
*   **Channel Optimization**: Channel selection based on notifiable capabilities via `routeNotificationFor()`
*   **Memory Efficiency**: No unnecessary object creation - `SpatieEmail` created on-demand

## Related Documentation

*   [`ChannelEnum` Documentation](../enums/channel-enum.md)
*   [`SpatieEmail` Documentation](../emails/spatie-email.md)
*   [`SendRecordNotificationAction` Documentation](../actions/send-record-notification-action.md)
*   [`SmsChannel` Documentation](./channels/sms-channel.md) - Note: Uses `Modules\Notify\Channels\SmsChannel` (expects `SmsData`)
*   [`SmsData` Documentation](../datas/sms-data.md)
*   [Zen Delegation Strategy](../refactoring/record-notification-zen-delegation.md)

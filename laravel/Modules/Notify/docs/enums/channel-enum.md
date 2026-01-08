# `ChannelEnum`

This document describes the `ChannelEnum`, an enumeration (Enum) defining the various notification channels supported by the `Notify` module. It is designed to provide a type-safe and standardized way to reference notification channels throughout the application, especially in Filament actions and other notification-related logic.

## Location

`laravel/Modules/Notify/app/Enums/ChannelEnum.php`

## Purpose

To centralize the definition of notification channels, improving maintainability, readability, and type safety compared to using raw string constants. It integrates with Filament by implementing the `HasLabel` contract for user-friendly display in UI components.

## Key Features

*   **Type-Safe Channel Definition:** Each channel (Mail, Sms, WhatsApp) is represented by a distinct Enum case.
*   **Filament Integration (`HasLabel`):** Provides a human-readable label for each channel, suitable for display in Filament forms (e.g., `CheckboxList`).
*   **Channel Mapping:** Maps each Enum case to its corresponding Laravel Notification channel implementation (either a string for built-in channels or a class reference for custom channels).

## Enum Cases

*   **`Mail`**: Represents email notifications.
    *   `value`: `'mail'`
*   **`Sms`**: Represents SMS notifications.
    *   `value`: `'sms'`
*   **`WhatsApp`**: Represents WhatsApp notifications.
    *   `value`: `'whatsapp'`

## Methods

### `getLabel(): ?string`

Returns a translatable, human-readable label for the Enum case.

*   **Example:** `ChannelEnum::Mail->getLabel()` would return the translation for `'notify::channel.mail'`.

### `getNotificationChannel(): string`

Returns the fully qualified class name or string identifier that Laravel's Notification system uses for this channel.

*   **Example:**
    *   `ChannelEnum::Mail->getNotificationChannel()` returns `'mail'`.
    *   `ChannelEnum::Sms->getNotificationChannel()` returns `Modules\Notify\Notifications\Channels\SmsChannel::class`.
    *   `ChannelEnum::WhatsApp->getNotificationChannel()` returns `Modules\Notify\Notifications\Channels\WhatsAppChannel::class`.

## Usage Example

### In Filament Forms (e.g., `CheckboxList`)

```php
use Filament\Forms\Components\CheckboxList;
use Modules\Notify\Enums\ChannelEnum;

CheckboxList::make('channels')
    ->label(__('notify::form.channels'))
    ->options(
        collect(ChannelEnum::cases())
            ->mapWithKeys(fn (ChannelEnum $enum) => [$enum->value => $enum->getLabel()])
            ->toArray()
    )
    ->columns(3)
    ->required(),
```

### In Actions (e.g., `SendRecordNotificationAction`)

```php
use Modules\Notify\Enums\ChannelEnum;

foreach ($channels as $channelEnum) {
    if (! $channelEnum instanceof ChannelEnum) {
        continue;
    }
    $laravelChannel = $channelEnum->getNotificationChannel();
    // ... use $laravelChannel to dispatch notification
}
```

## Adherence to Laraxot Principles

*   **DRY (Don't Repeat Yourself):** Centralizes channel definitions, avoiding hardcoded strings.
*   **KISS (Keep It Simple, Stupid):** Provides a clear and simple interface for channel management.
*   **Type Safety:** Enforces valid channel types at compile-time and runtime.
*   **Readability:** Improves code clarity by using descriptive Enum cases.

## Related Documentation

*   [`SendRecordNotificationAction` Documentation](`../actions/send-record-notification-action.md`)
*   [`SendRecordsNotificationBulkAction` Documentation](`../filament/actions/send-records-notification-bulk-action.md`)
*   [`SmsChannel` Documentation](`../notifications/channels/sms-channel.md`)
*   [`WhatsAppChannel` Documentation](`../notifications/channels/whatsapp-channel.md`)
```
Let's create this file.
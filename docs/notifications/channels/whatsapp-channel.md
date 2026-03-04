# `WhatsAppChannel`

This document describes the `WhatsAppChannel`, a custom Laravel Notification Channel designed to send WhatsApp messages. It provides a placeholder for integration with WhatsApp API providers and aims to extend the application's notification capabilities.

## Location

`laravel/Modules/Notify/app/Notifications/Channels/WhatsAppChannel.php`

## Purpose

To establish a dedicated, extensible mechanism for dispatching WhatsApp notifications through Laravel's Notification system. It separates WhatsApp communication logic from notification content generation and ensures flexibility for integrating with various WhatsApp API services.

## Key Features

*   **Custom Notification Channel:** Seamlessly integrates with Laravel's Notification system.
*   **Recipient Discovery:** Attempts to find the recipient's WhatsApp phone number from the `notifiable` model (via `whatsapp_phone` attribute or `routeNotificationForWhatsApp` method).
*   **Logging:** Logs WhatsApp sending attempts, providing a basic audit trail for debugging.
*   **Extensible Placeholder:** Contains a clear placeholder for future integration with actual WhatsApp Business API or other providers.

## Methods

### `send(object $notifiable, \Illuminate\Notifications\Notification $notification): void`

The primary method invoked by Laravel's Notification system for WhatsApp message dispatch.

1.  Retrieves WhatsApp message content by calling `$notification->toWhatsApp($notifiable)`.
2.  Discovers the recipient's WhatsApp phone number using internal logic (checks `whatsapp_phone` attribute or `routeNotificationForWhatsApp` method).
3.  Logs the WhatsApp sending attempt.
4.  Contains a placeholder for the actual API call to a WhatsApp service provider.

## Usage

This channel is typically referenced in `ChannelEnum` and can be conditionally used by `RecordNotification`'s `via()` method if WhatsApp content is available in the `MailTemplate`.

## Adherence to Laraxot Principles

*   **DRY (Don't Repeat Yourself):** Centralizes WhatsApp sending logic, promoting reusability.
*   **KISS (Keep It Simple, Stupid):** Offers a clear, focused responsibility for WhatsApp message dispatch.
*   **Separation of Concerns:** Distinctly separates WhatsApp transport logic from notification content.
*   **Modularization:** Resides within the `Notify` module, contributing to a well-organized notification system.

## Related Documentation

*   [`ChannelEnum` Documentation](`../../enums/channel-enum.md`)
*   [`RecordNotification` Documentation](`../record-notification.md`)
*   [`NormalizePhoneNumberAction` Documentation](`../../actions/normalize-phone-number-action.md`)
*   [Laravel Notifications Documentation](https://laravel.com/docs/master/notifications#custom-channels)

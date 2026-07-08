# Notification System Behavior

## Notification Channels Behavior

### Issue: Unexpected SMS Channel Execution

When sending a notification with multiple channels (e.g., mail and SMS), Laravel will attempt to send through all specified channels in the `via()` method, even if not all channels are used in the notification call.

**Example from `RegisterAction.php`:**
```php
Notification::route('mail', $data['email'])
    ->notify(new RecordNotification($patient, 'patient_registration_pending'));
```

**Problem:**
Even though only the mail channel is explicitly routed, the `toSms()` method is still called because:

1. The `via()` method in `RecordNotification` returns both `['mail', SmsChannel::class]`
2. Laravel's notification system will attempt to send through all channels specified in `via()`
3. If a channel is not properly routed (like SMS in this case), it will cause errors

### Solution 1: Route All Required Channels

```php
Notification::route('mail', $data['email'])
    ->route('sms', $data['phone'])  // Add phone number if available
    ->notify(new RecordNotification($patient, 'patient_registration_pending'));
```

### Solution 2: Make SMS Optional

Modify the `toSms()` method to handle cases where the recipient doesn't have a phone number:

```php
public function toSms($notifiable)
{
    if (empty($notifiable->routeNotificationFor('sms'))) {
        return null;
    }
    
    return SmsData::from([
        'from' => config('app.name'),
        'to' => $notifiable->routeNotificationFor('sms'),
        'body' => 'Your notification message here'
    ]);
}
```

### Solution 3: Dynamic Channel Selection

Modify the `via()` method to only return channels that are properly routed:

```php
public function via($notifiable)
{
    $channels = [];
    
    if ($notifiable->routeNotificationFor('mail')) {
        $channels[] = 'mail';
    }
    
    if ($notifiable->routeNotificationFor('sms')) {
        $channels[] = SmsChannel::class;
    }
    
    return $channels;
}
```

## Best Practices

1. **Always check if a channel is properly routed** before attempting to use it
2. **Make notification channels optional** when possible
3. **Validate recipient information** before sending notifications
4. **Use queueable notifications** for better performance
5. **Log notification failures** for debugging purposes

## Related Documentation

- [Laravel Notification Channels](https://laravel.com/docs/notifications#specifying-delivery-channels)
- [Laravel Notification Routing](https://laravel.com/docs/notifications#routing-notifications)
- [Notification Best Practices](best-practices.md)

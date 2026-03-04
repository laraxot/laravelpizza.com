# 🧘 RecordNotification Zen Delegation Strategy

## 🕉️ Philosophy: Zen Delegation
The "Zen" approach for `RecordNotification` has evolved from **Lazy Resolution** to **Zen Delegation**. Instead of being a "God Object" that manages templates and placeholders, `RecordNotification` acts as a pure **Bridge** (Decorator/Proxy) that delegates all content generation to the specialized `SpatieEmail` mailable.

## 🛠️ Architecture

### 1. The Specialized Agent (`Modules\Notify\Emails\SpatieEmail`)
- **Responsibility**: Resolving templates (by slug), replacing placeholders (Mustache), and applying seasonal layouts (Zen Context Engine).
- **Benefit**: Centralizes "How to build a message" logic in one place.

### 2. The Bridge (`Modules\Notify\Notifications\RecordNotification`)
- **Responsibility**: Connecting Laravel's Notification system to `SpatieEmail`.
- **Implementation**:
    - `toMail()`: Simply returns a configured `SpatieEmail` instance.
    - `toSms()`: Uses `SpatieEmail->buildSms()` to get the content and wraps it in `SmsData`.
- **Benefit**: achieving absolute DRY. If you change how placeholders work, you only change `SpatieEmail`.

### 3. Religious Routing (`via`)
- **Principle**: Check the `notifiable` for routing capabilities (`routeNotificationFor`).
- **Benefit**: Ensures the notification is only sent to compatible channels.

## 🚫 Avoid ("Le Cagate")
- **Don't** implement placeholder replacement logic inside `RecordNotification`.
- **Don't** manage `MailTemplate` resolution directly if a mailable can do it.
- **Don't** duplicate layout logic.

## 📈 Zen Pattern
```php
public function toMail($notifiable): SpatieEmail
{
    // Zen: Delegate to the specialized mailable
    return (new SpatieEmail($this->record, $this->slug))
        ->mergeData($this->data)
        ->addAttachments($this->attachments);
}
```

## 🐄 Mu-uu! The Path of Enlightenment!
This delegation model is the ultimate expression of **SRP** (Single Responsibility Principle) and **DRY**. It allows `RecordNotification` to remain thin, robust, and easily maintainable.

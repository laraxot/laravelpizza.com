---
qmd: "QUICK START"
issues: []
discussions: []
title: "Notify Module Quick Start"
type: guide
tags: [notify, notifications]
created: 2026-07-28
updated: 2026-07-28
status: draft
---

# Notify Module: Quick Start

## Send Notification

```php
use Modules\Notify\Notifications\UserVerificationNotification;

$user->notify(new UserVerificationNotification());

// Queued
$user->notifyLater(now()->addMinutes(5),
    new UserVerificationNotification());
```

## Create Custom Notification

```php
class CustomNotification extends Notification {
    public function via() { return ['mail', 'database']; }
    public function toMail() { return (new Mailable())->view(...); }
}
```

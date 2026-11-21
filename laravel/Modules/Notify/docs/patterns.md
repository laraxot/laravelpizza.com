---
updated: 2026-09-26
qmd: "patterns"
issues: []
discussions: []
title: "Notify Module Patterns"
type: guide
tags: [notify, patterns]
created: 2026-07-28
---

# Notify Module — Patterns

## Async Pattern (Queued Notifications)

✅ Always queue notifications for performance:
```php
implements ShouldQueue {
    public $queue = 'notifications';
}
```

## Data Pattern (JSON Storage)

✅ Store all context in data for email templates:
```php
public function toMail() {
    return (new Mailable())
        ->with('user', $this->notifiable)
        ->with('verification_link', $this->verificationLink);
}
```

## Polymorphic Pattern

✅ Support multiple notifiables (User, Team, etc.)

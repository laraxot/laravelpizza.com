---
updated: 2026-09-26
qmd: "TESTING"
issues: []
discussions: []
title: "Notify Module Testing"
type: guide
tags: [notify, testing, pest]
created: 2026-07-28
status: draft
---

# Notify Module: Testing

```php
test('sends welcome notification', function () {
    Notification::fake();
    $user = User::factory()->create();

    $user->notify(new WelcomeNotification());

    Notification::assertSentTo($user, WelcomeNotification::class);
});
```

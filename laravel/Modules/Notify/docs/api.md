---
<<<<<<< .merge_file_p6Aw2g
updated: 2026-11-23
=======
<<<<<<< HEAD
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
>>>>>>> .merge_file_i8DUph
qmd: "api"
issues: []
discussions: []
title: "Notify Module API"
type: reference
tags: [notify, api, notifications]
created: 2026-07-28
---

# Notify Module — API

## Sending Notifications

```php
$user->notify(new Notification());
$user->notifyLater($when, new Notification());
```

## Notification Classes

- `UserVerificationNotification` — Email verification
- `PasswordResetNotification` — Password reset
- `WelcomeNotification` — New user welcome

## Channels
- `mail` — Email delivery
- `database` — Database storage (read_at tracking)
- `slack` — Slack integration

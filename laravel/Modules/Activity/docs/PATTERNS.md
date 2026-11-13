---
title: "Activity Module Patterns"
type: guide
tags: [activity, patterns]
created: 2026-07-28
updated: 2026-07-28
---

# Activity Module — Patterns

## Audit Trail Pattern

✅ Log all state changes in Actions:
```php
class UpdateUserAction {
    public function execute(User $user, array $data) {
        $oldEmail = $user->email;
        $user->update($data);

        (new LogActivityAction)->execute([
            'description' => 'Email changed',
            'type' => 'user.email_changed',
            'properties' => ['old' => $oldEmail, 'new' => $data['email']],
        ]);
    }
}
```

## Event Sourcing Pattern

✅ Use event sourcing for critical workflows:
- Log immutable events in `activities` table
- Never delete activities (only archive)
- Replay events to reconstruct state

## Query Pattern

✅ Filter by causer, subject, type:
```php
Activity::where('causer_type', User::class)
    ->where('type', 'post.created')
    ->orderBy('created_at', 'desc')
    ->get();
```

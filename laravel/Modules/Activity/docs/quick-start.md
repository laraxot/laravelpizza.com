---
title: "Activity Module Quick Start"
type: guide
tags: [activity, audit, logging]
created: 2026-07-28
updated: 2026-07-28
<<<<<<< .merge_file_0B60oG
---

# Activity Module — Quick Start
=======
status: draft
qmd: "activity module   quick start activity"
---

# Activity Module: Quick Start
>>>>>>> .merge_file_tYRiGL

## Log Activity

```php
use Modules\Activity\Actions\LogActivityAction;

(new LogActivityAction)->execute([
    'description' => 'User created',
    'subject' => $user,
    'causer' => auth()->user(),
    'type' => 'user.created',
    'properties' => ['email' => $user->email],
]);
```

## Query Activity

```php
Activity::where('subject_type', User::class)
    ->latest()
    ->get();
```

## Filament Browse

Visit admin panel → Activity Resource to browse all logged activities.

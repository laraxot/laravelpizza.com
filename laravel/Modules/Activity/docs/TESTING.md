---
title: "Activity Module Testing"
type: guide
tags: [activity, testing, pest]
created: 2026-07-28
updated: 2026-07-28
---

# Activity Module — Testing

## Test Activity Logging

```php
test('logs activity on user creation', function () {
    $user = User::factory()->create();

    expect(Activity::where('subject_type', User::class)
        ->where('subject_id', $user->id)
        ->count())->toBeGreaterThan(0);
});

test('logs causer on user action', function () {
    $admin = User::factory()->create();
    $this->actingAs($admin);

    (new LogActivityAction)->execute([
        'description' => 'User updated',
        'subject' => $user,
        'causer' => $admin,
        'type' => 'user.updated',
    ]);

    $activity = Activity::latest()->first();
    expect($activity->causer_id)->toBe($admin->id);
});
```

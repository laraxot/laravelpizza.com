---
title: "Activity Module API"
type: reference
tags: [activity, api]
created: 2026-07-28
updated: 2026-07-28
---

# Activity Module — API

## LogActivityAction

```php
execute(array $data): Activity
```

- `description` (string): Activity description
- `subject` (Model): Target entity
- `causer` (Model): User performing action
- `type` (string): Event type (user.created, post.updated, etc.)
- `properties` (array): Metadata

## Activity Model

```php
Activity::find($id);
$activity->subject;       // Polymorphic: User, Post, etc.
$activity->causer;        // User performing action
$activity->properties;    // JSON metadata
```

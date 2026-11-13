---
title: "Activity Module API"
type: reference
tags: [activity, api]
created: 2026-07-28
updated: 2026-07-28
<<<<<<< .merge_file_bGzAe8
---

=======
status: draft
qmd: "activity module   api activity"
---

# Activity Module: API

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

---

<!-- merged from API.md -->

> Nota 2026-10-14 (docs-audit): La firma 'execute(array $data): Activity' non esiste: LogActivityAction prende type, user, subject, properties, description nel costruttore e ha execute(): Activity (app/Actions/LogActivityAction.php). Vedi README.md. Contenuto non riscritto, verificare prima di usarlo.

# Activity Module: API

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

---

<!-- merged from API.md -->

> Nota 2026-10-14 (docs-audit): La firma 'execute(array $data): Activity' non esiste: LogActivityAction prende type, user, subject, properties, description nel costruttore e ha execute(): Activity (app/Actions/LogActivityAction.php). Vedi README.md. Contenuto non riscritto, verificare prima di usarlo.

>>>>>>> .merge_file_iUN7VP
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

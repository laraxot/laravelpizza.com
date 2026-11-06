---
title: "Fix: ActivityFactory subject_id deve usare UUID"
type: note
status: draft
updated: 2026-10-07
tags: [docs, activity, errori]
qmd: "fix: activityfactory subject_id deve usare uuid activity"
---
# Fix: ActivityFactory subject_id deve usare UUID

## Problema

`ActivityFactory` usava `subject_id => $this->faker->numberBetween(1, 999999)` mentre `causer_id` usava `$this->faker->uuid()`. Dopo la migrazione che converte entrambe le colonne in `string(36)` per supportare User (UUID), `subject_id` deve essere coerente.

## Soluzione

Usare `uuid()` per entrambi:

```php
'subject_id' => $this->faker->uuid(),
'causer_id' => $this->faker->uuid(),
```

## Riferimenti

- [subject-id-causer-id-uuid-migration-fix.md](./subject-id-causer-id-uuid-migration-fix.md)

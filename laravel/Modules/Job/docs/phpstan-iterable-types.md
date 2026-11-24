---
title: "PHPStan iterable types nel modulo Job"
type: rule
tags: [phpstan, iterable, job, laraxot]
created: 2026-07-07
updated: 2026-07-07
qmd: "job phpstan iterable value type array schedule arguments frontend sortable"
---

# PHPStan iterable types nel modulo Job

> Gli array pubblici o protetti devono dichiarare il value type nei PHPDoc.

## Regola

Quando una firma espone `array`, aggiungere PHPDoc con shape o generics:

```php
/** @param array<string, mixed> $input */
public function store(array $input): Model;

/** @param array<int, string> $tags */
private function filterEmptyTags(array $tags): array;
```

Per scope Eloquent con ordinamenti dinamici, tipizzare sia il builder sia gli array di default:

```php
/**
 * @param Builder<Task> $query
 * @param array<string, string> $defaultSort
 * @return Builder<Task>
 */
public function scopeSortableBy(Builder $query, array $defaultSort = []): Builder;
```

## Verifica

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Job --no-progress --error-format=table
```

Esito atteso codice: 0 errori. Se resta solo `Ignored error pattern larastan.noEnvCallsOutsideOfConfig was not matched`, il residuo e' in `phpstan.neon` e puo' modificarlo solo l'utente.

---
title: PHPStan User Relations
type: note
status: active
updated: 2026-08-02
tags:
  - phpstan
  - larastan
  - user
---

# PHPStan User Relations

`BaseUser` combina trait di team, notifiche, Passport e media.

Pattern locale:

- `treeSons()` restituisce `Illuminate\Support\Collection<int, TeamContract>`, coerente con `membershipTeams`;
- relazioni morph annotate con `$this`, ad esempio `MorphMany<Notification, $this>`;
- password letta in variabile locale e validata `is_string()` prima di `Hash::check()`.

Queste annotazioni descrivono il comportamento esistente e non richiedono modifiche a `phpstan.neon`.

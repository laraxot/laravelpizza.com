---
title: "User — vietata dipendenza dal modulo Comment"
type: concept
module: User
tags: [user, comment, boundary, architecture, dependency]
created: 2026-06-06
updated: 2026-06-06
qmd: "user module must not depend comment CanComment InteractsWithComments BaseUser boundary"
issues:
discussions:
related:
  - "./ai-harness-user-discipline.md"
  - "./baseuser-hierarchy.md"
  - "./code-redundancy-user.md"
  - "./context-mode-user-discipline.md"
  - "./context-overflow-prevention.md"
  - "./filament-langserviceprovider-governance.md"
  - "./filament-widget-linear-crud-model-create.md"
  - "./filament-widget-resource-form-delegation.md"
---

# User non dipende da Comment

## GitHub (tracciamento)

| Tipo | Link |
|------|------|
| Issue | [#13 — User must never depend on Comment](https://github.com/laraxot/base_techplanner_fila5/issues/13) |
| Discussion | [#14 — Architecture User ↔ Comment](https://github.com/laraxot/base_techplanner_fila5/discussions/14) |

## Regola (legge operativa)

Il modulo **User** è infrastruttura identity/auth: **non deve** importare classi, trait, contratti o provider dal modulo **Comment** (né da moduli opzionali non presenti nel progetto).

## Vietato in User

- `use Modules\Comment\...`
- `implements CanComment`
- `use InteractsWithComments`
- `require` Comment in `composer.json` / `module.json`

## Perché

- User è dipendenza di quasi tutti i moduli: coupling con Comment rompe bootstrap e test
- Comment (se serve) dipende da User, mai il contrario — inversione DIP
- Progetti senza Comment (es. `base_techplanner_fila5`) devono avviarsi senza fatal error

## Se servono commenti su User

Il modulo **Comment** (o dominio business: Blog, Job, …) estende o compone il modello User lato consumer — non il contrario.

## Fix applicato

Rimosso da `BaseUser.php`: `CanComment`, `InteractsWithComments`, trait `HasCommentatorRelations` (fatal quando Comment assente).

## Verifica (CI / locale)

```bash
bashscripts/tools/check-user-no-comment-dependency.sh
cd laravel && ./vendor/bin/pest Modules/User/tests/Unit/NoCommentModuleDependencyTest.php
```

Se vedi ancora il fatal: `php artisan optimize:clear` e riavvia PHP-FPM (opcache).

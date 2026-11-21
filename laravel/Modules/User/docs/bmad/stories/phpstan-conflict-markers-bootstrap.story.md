---
title: "PHPStan — rimozione marker conflitto Git e bootstrap User"
type: story
module: User
status: review
epic: code-quality
created: 2026-11-16
updated: 2026-11-16
tags: [docs, user, bmad, phpstan, git, conflict]
qmd: "user conflict markers bootstrap UserServiceProvider BaseUser BaseTenant phpstan"
related:
  - ./committed-conflict-markers.story.md
  - ../phpstan-user-contract-fix.md
  - ../../git-conflicts-resolution.md
  - ../../wiki/troubleshooting/git-merge-conflict-inventory.md
---

# PHPStan — marker conflitto Git e bootstrap User

## Perché

I marker `<<<<<<<` / `=======` / `>>>>>>>` nei file PHP del modulo User rendevano
il codice non parseabile. In particolare `UserServiceProvider.php` bloccava il
bootstrap Laravel (auth provider attivo SEC-05, Pulse gate, mail reset/verify,
rate limit login API).

## Scope

Solo `laravel/Modules/User` (`app/`, `tests/`, `routes/`, blade con PHP).

## File con marker (risolti)

| File | Decisione |
|------|----------|
| `app/Providers/UserServiceProvider.php` | Tenuti import `Application`/`Hasher`/`BuildActiveUserProviderAction` e `registerActiveUserProvider()` (SEC-05). Reset password passa email a `BuildPasswordResetUrlAction`. |
| `routes/web.php` | Tenuta route `verification.verify` firmata + `require socialite.php`. |
| `app/Models/Traits/BaseUserMutators.php` | Hash via `password_get_info` (no soglia lunghezza 32). |
| `app/Models/BaseUser.php` | `findForPassport` esclude `deleted_at`; `canAccessPanel` super-admin + `::operator`; niente `new static()`. |
| `app/Models/Policies/BaseUserPolicy.php` | Solo `super-admin` in `before()` (no bypass `user::admin` via parent). |
| `app/Actions/Socialite/LoginUserAction.php` | Relazione già caricata + blocco `deleted_at`; niente `mixed`. |
| `app/Models/BaseTenant.php` | Cast `settings`/`trial_ends_at`; avatar URL `''` → `null`. |
| `app/Filament/.../UserForm.php` | Niente autofocus (DCP-290); `Password::default()` sul reset. |

## Fix PHPStan collaterali (stesso intervento)

- `HasTeamsTraitTest`: use duplicato `TeamContract`; `$user->allTeams()`.
- `TenantTest` (Models): import `Modules\User\Models\Tenant`.
- `Unit/TenantTest` + `Unit/UserModelTest`: `Modules\User\Tests\TestCase`.
- `UserModelTest` Feature: import `XotData`.
- `DeletedAccountAccessTest`: `assertInstanceOf(EloquentUserProvider)`.
- `Pulse/LoginWidget`: narrowing `list<int|float|null>` / `list<string>`.
- `InteractsWithTenant`: return `BelongsTo<Model&TenantContract, $this>`.
- `UsersRelationManager`: `Filter::form()` (stub Filament corrente).

## Verifica

```bash
bash bashscripts/lock/lock.sh user-conflict-markers 45
rg -n '^(<<<<<<< |=======|>>>>>>> )' laravel/Modules/User -g '*.php' -g '*.blade.php'
# → NONE
cd laravel && php -l Modules/User/app/Providers/UserServiceProvider.php
cd laravel && php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/User --no-progress
```

## Criteri di accettazione

- [x] Zero marker conflitto in PHP/blade User
- [x] `UserServiceProvider` parseabile; provider active-user preservato
- [x] Funzionalità auth/tenancy/Passport/Socialite/Filament form preservate
- [x] Nessun `mixed` introdotto; nessun `phpstan-ignore`
- [x] PHPStan `Modules/User` a zero errori sul codice User (post-fix)

## Note ambiente

Se Larastan fallisce con `MailtrapSdkProvider not found`, è cache
`bootstrap/cache/{packages,services}.php` vs vendor incompleto — fuori scope User;
`php artisan package:discover` e re-run.

## Lock

`user-conflict-markers` (45 min).

## Sostituisce / link

Non sostituisce `committed-conflict-markers.story.md` (storico 2026-10, worktree
già pulito). Aggiorna e punta da `git-merge-conflict-inventory.md` e
`git-conflicts-resolution.md`.

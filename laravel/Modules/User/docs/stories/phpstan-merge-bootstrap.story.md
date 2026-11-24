---
title: "User: PHP merge-marker bootstrap (app/tests/lang/migrations)"
type: story
module: User
slug: phpstan-merge-bootstrap
status: in_progress
priority: high
repository: "git@github.com:provtv/module_user_fila5.git"
owned_scope:
  - "laravel/Modules/User/**/*.php"
supersedes:
  - "./resolve-conflict-markers-user-app-tests.story.md"
  - "./resolve-conflict-markers-user-lang.story.md"
related:
  - "./docs-merge-conflict-markers-cleanup.story.md"
  - "./user-nested-conflict-marker-cleanup.story.md"
  - "./phpstan-zero-errors-user.story.md"
---

# User: PHP merge-marker bootstrap

## GateGuard (first touch)

1. **Existing related docs (not duplicates of this scope):**
   - `docs-merge-conflict-markers-cleanup.story.md` — solo `docs/`, già done
   - `resolve-conflict-markers-user-app-tests.story.md` — 10 file storici, status blocked-verification; inventory attuale è 150 PHP
   - `resolve-conflict-markers-user-lang.story.md` — 6 file lang storici
   - `user-nested-conflict-marker-cleanup.story.md` — cleanup nested docs/markers legacy
2. **Linked from:** claim table di questa lane swarm; riferimenti crociati nelle story `supersedes`/`related` sopra; write-back progress in questa story.
3. **Perché nuovo file:** nome canonico richiesto dal task multi-agente (`phpstan-merge-bootstrap.story.md`) con claim table su **tutti** i PHP User attuali (~150); le story precedenti coprono sottoinsiemi chiusi/storici e non fungono da lock di questa lane.
4. **Istruzione utente (verbatim):** «Story (no date in name): laravel/Modules/User/docs/stories/phpstan-merge-bootstrap.story.md with claim table and progress.»

## Scopo

Rimuovere tutti i marker `<<<<<<<` / `=======` / `>>>>>>>` dai file PHP del modulo User (~150), preservando la business logic di auth, teams, permissions e il confine `UserContract` (non `User` concreto). Preferire pattern XotBase / Filament moderni e `strict_types`.

## Perché

I marker residuali bloccano il bootstrap PHPStan (`unexpected token "<<"`) e spezzano login, SoftDelete SEC-05, migrazioni profiles/users.

## Claim table

| Path / area | Agent | Status | Note |
|---|---|---|---|
| `app/Actions/Auth/*` | user-php-merge | claimed | SEC-05, post-login, digital identity |
| `app/Models/*` | user-php-merge | claimed | BaseUser, relations traits, mutators |
| `app/Http/*` | user-php-merge | claimed | Socialite callback, Livewire auth |
| `database/migrations/*.php` | user-php-merge | claimed | users/profiles/auth log/socialite |
| `tests/**/*.php` | user-php-merge | claimed | Unit + Feature |
| `lang/**/*.php` | user-php-merge | claimed | prefer content over `return []` |
| Seo locks | skip | n/a | no overlap |

## Decisioni campione (business)

| File | Scelta | Perché |
|---|---|---|
| `GetPostLoginUrlAction` | `xra.post_login_path` + fallback `/area-personale` | allineato a docblock + `AuthFlowRedirectsTest` |
| `BuildActiveUserProviderAction` | `UserContract` + `ModelHasColumnAction` su `deleted_at` | SEC-05 senza assumere colonna su ogni modello |
| `BaseUser::findForPassport` | filtro `deleted_at` via `ModelHasColumnAction` | stesso confine soft-delete / Passport |
| `BaseUserMutators::setPasswordAttribute` | `Hash::info` (non lunghezza) | evita password lunghe in chiaro |
| `ProcessCallbackController` | `execute($provider, $user, $oauth)` | firma Action corrente |
| `create_users_table` | `name` nullable + colonne lang/type/state/otp | SSO + profilo utente; no `$connection` hardcode |
| `fix_profiles_id_autoincrement` | `connectionName()` dinamico, un solo check driver | migrazione idempotente MySQL-only |
| lang `*` | tenere array traduzioni, scartare `return []` | LangServiceProvider / Filament labels |

## Progress

| Fase | Totale | Fatti | Residui |
|---|---|---|---|
| Inventory `rg -l '^<<<<<<<' …/*.php` | 150 | 0 | 150 |
| app/ | 22 | 0 | 22 |
| database/ | 4 | 0 | 4 |
| tests/ | 15 | 0 | 15 |
| lang/ | 109 | 0 | 109 |

## Gate

1. `rg -l '^<<<<<<<' laravel/Modules/User --glob '*.php'` → 0
2. `php -l` su tutti i PHP toccati → 0 fail
3. Forward-only (no checkout/restore/reset)

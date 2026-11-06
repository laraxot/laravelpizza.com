---
title: "Resolve git conflict markers in User module app and test files"
slug: resolve-conflict-markers-user-app-tests
status: blocked-verification
scope: module:User
date: 2026-10-21
related: ["resolve-conflict-markers-user-lang.story.md", "user-nested-conflict-marker-cleanup.story.md", "user-nested-conflict-marker-cleanup-rimozione-conflitto-git-annidati.story.md"]
---

# Resolve git conflict markers in User module app and test files

## Goal

Remove the leftover git conflict markers (`<<<<<<<`, `=======`, `>>>>>>>`) from ten
PHP files of the User module so that they parse again. Each conflict is resolved by
keeping the side that matches the intended behavior, merging both sides where each
carried needed content. No test is deleted to make a file parse.

## Scope

Ten files, all relative to `laravel/Modules/User/`:

- `app/Filament/Widgets/Auth/Schemas/UserForm.php` (3 markers)
- `app/Filament/Widgets/EditUserWidget.php` (6 markers)
- `app/Listeners/FailedLoginListener.php` (3 markers)
- `app/Listeners/LoginListener.php` (3 markers)
- `routes/web.php` (3 markers)
- `tests/Feature/UserCommandIntegrationTest.php` (3 markers)
- `tests/Feature/UserManagementBusinessLogicTest.php` (3 markers)
- `tests/Unit/AuthenticationBusinessLogicTest.php` (9 markers)
- `tests/Unit/Models/TenantTest.php` (6 markers)
- `tests/Unit/UserModelTest.php` (6 markers)

Total: 46 markers before, 0 after.

## Decisions per file

Side names are the ones git wrote in the markers. "Side A" is the first block,
"side B" the second one.

### `routes/web.php`

- Side B kept: it loads `routes/socialite.php` with `require`. The OAuth route
  `oauth.redirect` is used by `LoginWidget`, `SocialLoginWidget` and the login blade
  view. Nothing else requires `socialite.php`, so side A (commented require) would
  break `route('oauth.redirect')`.
- The `logout` route appeared in both sides. It is kept once.

### `app/Listeners/LoginListener.php`

- Side B kept: it closes the device-tracking block correctly (`$pivot->update`) and
  logs a warning when the device tables are missing, as the comment above the block
  requires ("a valid login must not become a 500").
- Side A referenced `$ip`, `$userAgent` and `$location`, which are not defined in that
  scope, and it wrote the authentication record a second time. The authentication
  record is already written at the bottom of the method through
  `RecordAuthenticationLogAction`.

### `app/Listeners/FailedLoginListener.php`

- Side B kept: it guards on `UserContract` and `HasAuthentications`, then delegates to
  `RecordAuthenticationLogAction`, as the action's docblock prescribes ("never type-hint
  BaseUser").
- Side A used `BaseUser`, which is not imported in this file, so the branch was dead
  code, and it wrote the record directly, which duplicated the action call.
- The commented-out notification block of side A was dropped. Notifications are
  disabled. Its note assumed that `create()` returns a log, which the action no longer
  does. Re-enabling notifications needs a change to the action, not a comment.

### `app/Filament/Widgets/Auth/Schemas/UserForm.php`

- Side B kept: `->helperText(null)` on the `remember` checkbox in
  `getLoginFormSchema()`. It follows the same rule used for `email` and `password` in
  that method (the form is shared with the register form, so helper text must not reach
  the login page). The change is only the explicit null on one field.

### `app/Filament/Widgets/EditUserWidget.php`

- The conflict only concerned a PHPDoc `@var array<int|string, Component> $result`
  annotation that refers to no variable in `getFormSchema()`. Both sides ended with
  `return self::normalizeFormSchema($schema);`. The stray annotation was removed.

### `tests/Feature/UserCommandIntegrationTest.php`

- Side A kept: the assertion `InputDefinition` is imported in the file and is a real
  check on the command definition. Side B was empty.

### `tests/Feature/UserManagementBusinessLogicTest.php`

- Side B kept (PHPUnit method form `public function it_can_check_user_has_any_role()`).
  The class is a PHPUnit class, so Pest `test(...)` calls cannot sit inside it. Side A
  also used `UserFactory` and `RoleFactory`, which are not imported.
- The explanatory comment of side A about the unassigned `nurse` role was kept, because
  it documents why the test proves the assignment and not the existence of the role.

### `tests/Unit/AuthenticationBusinessLogicTest.php`

- Side A called `authBizTeamData()` and `authBizUserData()`. These helpers are not
  defined anywhere in the repository, so side A would have fataled. Side B uses the
  `beforeEach` fixtures (`$this->teamData`, `$this->userData`) like the rest of the file.
- The "distinguishes personal vs organizational teams" test appeared twice. The two
  blocks were merged into one test: side B's fixture style, with side A's stronger
  assertions (`assertNotSame` against the real team, and the owner id match).
- The IP security test: side A read `$attempt`, which is not defined in that scope. Side
  B defines it (`(object) $loginAttempt`) and was kept.

### `tests/Unit/Models/TenantTest.php`

- Side A's assertions are stronger: it checks the relationship return types
  (`BelongsToMany` for `users()` and `members()`, `MorphMany` for `media()`). Its `test()`
  form could not sit inside the class body, and `TenantFactory` and `Assert` were not
  imported. The assertions were kept in the class method style of the file, with
  `Tenant::factory()` and `static::assertInstanceOf`.
- The `media()` method in side B only checked `method_exists`. It now checks the return
  type too.

### `tests/Unit/UserModelTest.php`

- Side B kept (Pest `expect()` style and the `Accessors and Mutators` describe block,
  which holds the `full_name` and password tests).
- Carbon: both sides imported a `Carbon` alias (`Carbon\Carbon` and
  `Illuminate\Support\Carbon`). Two imports with the same alias is a fatal error, so
  `Illuminate\Support\Carbon` (side B) was kept. `Hash` and `Assert` were only used by
  side A's password test and were removed with it.
- `uses(TestCase::class);` was moved below the import block (it sat between `use`
  statements in side B).
- A pre-existing clash, not caused by the merge: the file declared
  `function stubUser()` (an in-memory helper) and `tests/Support/helpers.php`, which is
  autoloaded globally by `composer.json`, declares the same name. PHP cannot declare
  both. The file-local helper was renamed to `stubUserInMemory()` (23 call sites, all
  inside this file). Behavior is unchanged. The global helper is not touched.

## Verification

### Parse check (`php -l`)

```
app/Filament/Widgets/Auth/Schemas/UserForm.php: No syntax errors detected
app/Filament/Widgets/EditUserWidget.php: No syntax errors detected
app/Listeners/FailedLoginListener.php: No syntax errors detected
app/Listeners/LoginListener.php: No syntax errors detected
routes/web.php: No syntax errors detected
tests/Feature/UserCommandIntegrationTest.php: No syntax errors detected
tests/Feature/UserManagementBusinessLogicTest.php: No syntax errors detected
tests/Unit/AuthenticationBusinessLogicTest.php: No syntax errors detected
tests/Unit/Models/TenantTest.php: No syntax errors detected
tests/Unit/UserModelTest.php: No syntax errors detected
```

Marker count after the change: 0 in all ten files.

### Pest

Pest runs in this environment, but every test that boots the application fails before
any assertion runs:

```
Class "PHPStan\PhpDocParser\Parser\TypeParser" not found
at vendor/phpdocumentor/type-resolver/src/TypeResolver.php:232
```

- Five repaired test files: `Tests: 90 failed (0 assertions)`.
- `OauthLocalizedLoginFlowTest.php` and `LoginWidgetTest.php`: `Tests: 25 failed (0 assertions)`,
  same error.

Cause: `vendor/composer/installed.json` lists `phpstan/phpdoc-parser` 2.3.6, but
`vendor/phpstan/phpdoc-parser/src/Parser/` does not exist. The vendor tree is
incomplete. This is not caused by the conflict resolution: the error happens while the
application boots, before any repaired line runs.

Side effect to know about: Pest initially failed with `Class "Pest\TestSuite" not found`
because the composer autoload maps were stale (they had no Pest namespace). I ran
`composer dump-autoload --no-scripts` to regenerate them. This rewrote `vendor/composer/`
autoload metadata only. It did not install the missing package.

No `git add`, `commit`, `reset`, `stash` or `checkout` was run. No database command was
run.

## Not done and why

- Pest is not green. Fixing it needs `composer install` (or restoring the missing
  `phpstan/phpdoc-parser` package in `vendor/`). That changes the shared vendor tree and
  was not done without approval. Rerun the five test files plus
  `Modules/User/tests/Feature/Socialite/OauthLocalizedLoginFlowTest.php` and
  `Modules/User/tests/Feature/Filament/Widgets/Auth/LoginWidgetTest.php` after that.
- The duplicate `stubUser()` declarations across `tests/Helpers.php`,
  `tests/Support/helpers.php` and `tests/Support/helpers-extended.php` are a wider
  problem. They are out of scope here and need their own story.
- PHPStan was not run.

## Status

Status: `blocked-verification`. The conflict markers are resolved and all ten files
parse. The behavior of the repaired tests is not yet verified, because the vendor tree
does not boot.
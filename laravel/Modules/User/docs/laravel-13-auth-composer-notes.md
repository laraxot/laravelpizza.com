# Laravel 13 auth Composer notes

## Purpose

Document the User module ownership rules for Laravel 13 Composer migration.

## Ownership

Authentication, OAuth, Passport, teams, permissions, and user-account packages belong in `Modules/User/composer.json`, not in `laravel/composer.json`.

The root composer remains minimal and only coordinates Laravel, Laravel Modules, and the merge plugin.

## Laravel 13 constraints

`laravel/passport` should be constrained to a Laravel 13 compatible line. The current second-brain note for Passport uses:

```bash
composer require laravel/passport "^13.4"
```

For this project, apply that as a module-owned change in `Modules/User/composer.json`, then resolve from `laravel/` with the merged composer graph.

## Migration checks

Before updating the lock:

1. Verify `Modules/User/composer.json` does not use wildcard auth package constraints.
2. Verify Passport model wrappers under `Modules\User\Models\Passport` still match Passport 13 APIs.
3. Verify config files under `Modules/User/config/` do not duplicate Laravel 13 defaults unnecessarily.
4. Run User PHPStan and Passport-related tests after Composer resolves.

## References

- User dependency policy: [composer-dependencies.md](composer-dependencies.md)
- Xot root Composer strategy: [../Xot/docs/laravel-13-modular-composer-upgrade.md](../../Xot/docs/laravel-13-modular-composer-upgrade.md)
- Laravel Modules v13 autoloading: https://laravelmodules.com/docs/13/getting-started/installation-and-setup

# PHPStan Roadmap: User Module

**Date**: 2026-01-12
**Errors**: 13

## 1. Filament Resource Typing
**Files**:
- `app/Filament/Clusters/Passport/Resources/OauthClientResource.php`
- `app/Filament/Resources/ClientResource.php`

**Issue**: `getModel()` returns `string` or `class-string`, but contract expects `class-string<Model>`.
**Plan**: Ensure explicit casting or strict return type in `getModel()`. Verify `XotBaseResource` inheritance.

## 2. API Resource properties
**Files**:
- `app/Http/Resources/ClientResource.php`

**Issue**: Access to undefined property `$this->owner`.
**Plan**: `JsonResource` proxies to the underlying model, but PHPStan doesn't know the model type. Add `@mixin` or `@property` PHPDoc to the Resource class.

## 3. PHPDoc Namespace Issues
**Files**:
- `app/Models/Role.php`
- `app/Models/Traits/HasTeams.php`

**Issue**: Unknown classes in PHPDoc (e.g., `Modules\User\Models\Carbon`).
**Plan**:
- Check imports in `Role.php` and `HasTeams.php`.
- The PHPDoc likely lacks FQCN or correct `use` statements.
- `HasTeams.php`: `pluck()` on unknown class `Collection`. Likely missing `use Illuminate\Support\Collection`.

## Execution Order
1. Fix PHPDoc Namespace issues (Role, HasTeams).
2. Fix API Resource properties.
3. Fix Filament Resource typing.

# User Module Roadmap (2025 Q4)

## Vision & Scope
- Ensure `Modules/User/` is the canonical identity, auth, roles/permissions, teams, and profile layer.
- Full compliance with Laraxot rules (Xot base classes, Filament 4 patterns, translations, strict types).

## Key Outcomes
- PHPStan 0 errors for `Modules/User/`.
- Filament v4 stable migration completed (no deprecated APIs).
- Contracts alignment with `Modules\Xot\Contracts\*` and consistent relations.

## References
- Filament v4: https://filamentphp.com/docs/4.x/upgrade-guide
- What’s new in v4: https://filamentphp.com/content/leandrocfe-whats-new-in-filament-v4
- Stable: https://filamentphp.com/content/alexandersix-filament-v4-is-stable
- Examples: https://filamentexamples.com/tutorial/filament-v3-v4-upgrade
- Forms v4: https://filamentphp.com/docs/4.x/forms/overview

## Milestones
- [ ] Normalize `BaseUser.php` (remove merge artifacts, implement contracts: HasTenants, HasTeamsContract, UserContract)
- [ ] Audit and fix `Notification.php`, `Profile.php`, team contracts
- [ ] Review all Filament pages/resources: use Xot base wrappers, `getFormSchema()`, list pages methods
- [ ] Translations expanded structure (fields/actions) and remove all ->label()
- [ ] Factories: ensure `newFactory()` via `GetFactoryAction` where required
- [ ] Tests: unit + feature coverage for auth, roles, teams, profiles

## Acceptance Criteria
- `./vendor/bin/phpstan analyse Modules --memory-limit=-1` returns 0 errors
- All resources adhere to project rules (no direct Filament base class extension)
- CI green on lint/test

## Dependencies
- `Modules/Xot` base traits/contracts
- `Modules/Tenant` multi-tenant relations

## Timeline
- Week 1–2: Fix models/contracts + PHPStan
- Week 3: Filament v4 sweep
- Week 4: Tests + docs polish

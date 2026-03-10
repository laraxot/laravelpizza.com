# PHPStan Level 10 Compliance Status

**Last Updated**: 2026-03-10
**Status**: ✅ FULLY COMPLIANT (0 errors)

## Summary
On 2026-03-10 the User module was re-verified and brought back to a clean PHPStan state after a Passport/OAuth recovery batch.

The recovery removed residual static-analysis drift in:

- Passport token wrappers
- OAuth personal access client modeling
- PHPDoc generic alignment for token collections
- JSON/API resource typing for OAuth client payloads
- Filament consumers that depended on OAuth wrapper metadata

## Compliance Verification
```bash
./vendor/bin/phpstan analyse Modules/User --error-format=raw
./vendor/bin/phpstan analyse Modules
# Result: [OK] No errors
```

## Recovery Batch Applied

### Passport / OAuth wrappers
- `OauthAccessToken` was aligned to the real Eloquent Passport token model: `Laravel\Passport\Token`
- `OauthToken::user()` now delegates to the parent Passport implementation instead of building an unsafe dynamic fallback relation
- `OauthPersonalAccessClient` was normalized as a local application model extending `Modules\User\Models\BaseModel`, because there is no 1:1 Eloquent vendor model named `Laravel\Passport\PersonalAccessClient`

### PHPDoc / generics
- Token collections on `BaseUser` and `User` now reference `Collection<int, OauthToken>` consistently with the actual configured Passport token model
- `OauthClient` received explicit metadata for inherited attributes consumed by Filament resources and HTTP resources

### Consumer fixes
- `ClientResource` now uses a typed local `$client` variable sourced from `$this->resource`
- `RegisterWidget` now imports the `Log` facade explicitly
- Refresh token revoke logic now uses attribute APIs instead of fragile direct dynamic property access where PHPStan could not infer the field safely

## Module Overview

The User module provides:
- User authentication and authorization
- Role and permission management
- Team management
- Profile management
- User preferences
- Social authentication

## Best Practices Already Implemented

1. **Type Safety**: All methods have proper type hints
2. **PHPDoc Compliance**: Accurate documentation for complex types
3. **User Models**: Proper Eloquent relationships
4. **Authentication**: Type-safe auth operations
5. **Permissions**: Clean implementation of RBAC

## User Management Patterns

The module follows strict patterns for user management:
- User lifecycle management
- Role-based access control
- Team organization
- Profile customization
- Social integration

## Key Features

### Authentication
- Login/logout functionality
- Password management
- Two-factor authentication
- Social authentication

### Authorization
- Role and permission system
- Team-based access
- Resource-level permissions
- Dynamic permission checking

## Ongoing Maintenance

To maintain PHPStan compliance:
1. Keep `PassportServiceProvider` and all OAuth consumers aligned to the actual vendor Eloquent models exposed by `laravel/passport`
2. Distinguish strictly between vendor Passport Eloquent wrappers and local application OAuth models
3. Prefer typed local variables over property access on `JsonResource` and similar proxy objects
4. Run `./vendor/bin/phpstan analyse Modules/User --error-format=raw` after each Passport/OAuth batch
5. Re-run `./vendor/bin/phpstan analyse Modules` before considering the work complete

## Related Documentation
- [User Management Guide](user-management.md)
- [Authentication Patterns](authentication-patterns.md)
- [Role and Permissions](role-permissions.md)
- [Team Management](team-management.md)

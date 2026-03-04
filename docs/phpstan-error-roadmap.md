# PHPStan Error Analysis and Resolution Roadmap - User Module

## Summary
This document outlines the roadmap for resolving PHPStan errors in the User module, particularly addressing the Git conflict markers that are preventing proper static analysis.

## Current Issues Identified
1. **Git Conflict Markers**: Multiple files in the User module contain unresolved Git conflict markers
2. **Service Provider Registration**: The `PassportServiceProvider` had a Git conflict in the token expiration configuration
3. **Bootstrapping Error**: Larastan cannot bootstrap the application due to parse errors from Git conflicts
4. **UserContract Implementation Drift** (2026-03-02): `Modules\User\Models\User` non implementa tutti i metodi richiesti da `Modules\Xot\Contracts\UserContract` (es. `exists()`), causando un **Fatal error** durante `phpstan analyse Modules` prima ancora dell'analisi dei singoli file.

## Files with Git Conflict Markers
- `app/Http/Resources/ClientResource.php`
- `app/Filament/Clusters/Passport/Resources/OauthRefreshTokenResource.php`
- `app/Filament/Clusters/Passport/Resources/OauthAccessTokenResource.php`
- `app/Models/Passport/Client.php`
- `app/Models/OauthPersonalAccessClient.php`
- `app/Models/BaseUser.php`
- `app/Models/Team.php`
- `app/Models/Traits/HasTeams.php`
- `app/Models/Role.php`
- `app/Models/OauthClient.php`
- `app/Filament/Widgets/Auth/LoginWidget.php`
- `app/Filament/Widgets/RegistrationWidget.php`
- And several other files...

## Resolution Strategy
1. Resolve Git conflicts in all affected files
2. Maintain the most recent/functional code in each conflict
3. Verify each resolution maintains application functionality
4. Allineare **UserContract** e implementazioni concrete:
   - Verificare che tutti i metodi del contratto (incluso `exists()`) siano davvero parte della business logic attuale.
   - Se sì, implementarli in `BaseUser` (o nella classe concreta `User`) con una semantica chiara e documentata (es. `exists()` come wrapper tipizzato di query Eloquent).
   - Se no, valutare la rimozione/depcreazione del metodo dal contratto o la sua sostituzione con pattern più espressivi (Actions, query dedicate).
5. Run PHPStan analysis after each batch of fixes
6. Document decisions for each conflict resolution and for ogni cambiamento al contratto User.

## Priority Order
1. **Service Providers** - Critical for application bootstrapping
2. **Core Models** - Essential for application functionality
3. **Filament Resources** - Important for admin panel
4. **Tests** - Ensure functionality is maintained
5. **Other files** - Complete remaining conflicts

## Action Items
- [ ] Fix all Git conflicts in User module
- [ ] Verify application functionality after fixes
- [ ] Run PHPStan analysis
- [ ] Run PHPMD analysis
- [ ] Run PHPInsights analysis
- [ ] Update documentation

## Success Criteria
- PHPStan Level 10 compliance
- All Git conflict markers removed
- `UserContract` e `User`/`BaseUser` perfettamente allineati (nessun Fatal error in fase di bootstrap o analisi)
- Application functions properly
- All tests pass
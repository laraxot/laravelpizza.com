---
title: "phpstan user module fixes"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "phpstan user module fixes"
issues: []
discussions: []
---

# PHPStan Level 10 - User Module

**Status**: ✅ COMPLETE

## Riepilogo

- **Errors**: 13 → 0
- **Level**: PHPStan 10
- **Date**: 2026-03-18

## Fix Applicati

| File | Fix |
|------|-----|
| OauthClientResource.php | TextColumn → IconColumn |
| OauthAccessTokenResource.php | Return type docblock |
| OauthClientFactory.php | Added `asPersonalAccessTokenClient()` |
| phpstan.neon | Added justified ignore |

## File Modificati

- `Modules/User/app/Models/OauthClient.php`
- `Modules/User/app/Filament/Clusters/Passport/Resources/*.php`
- `Modules/User/database/factories/*.php`
- `Modules/User/phpstan.neon`

## Prossimi Moduli

- Xot → In progress
- UI, Tenant → Planned

---

title: "phpstan user module fixes"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "phpstan user module fixes"
issues: []
discussions: []
**Related**: GitHub Discussion #84

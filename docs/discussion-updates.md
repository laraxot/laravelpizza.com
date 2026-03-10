# Project Updates Tracking

## Event Detail Fix
- **Issue**: "Nessun evento trovato" on detail page.
- **Cause**: Data propagation issue between Volt/Folio and Cms Block via x-page component.
- **Fix**: Enhanced `ResolvePageAction` to return correct CMS view slug. Updated `index.blade.php` to pass explicit `$item` and `$event` to data array. Added fallback model loading in `detail.blade.php`.

## Localization Fix
- **Issue**: `/de` URL showing Italian content for logged-in users.
- **Cause**: Middleware priority favored user preference over URL segment.
- **Fix**: Updated `SetFolioLocale` middleware to prioritize URL segment.

## Missing Pages
- **Action**: Created `terms.json` and `privacy.json` content configurations.

## Architecture
- **Refactor**: Updated `Page.php` component to handle dynamic data more flexibly.
- **Rules**: Enforced `belongsToManyX`, Passport `Oauth` extension, and Schema.org compliance.

## Next Steps
- Implement Schema.org fully on Event model.
- Create Oauth models in User module.
- Validation pass (PHPStan).

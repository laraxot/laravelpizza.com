# Audit collisioni Git committate in bashscripts

Risoluzione deterministica per singolo blocco: lato non vuoto, superset, metadata `updated` più recente, quindi HEAD come spareggio conservativo.

| File | Blocchi | Decisioni | SHA-256 prima → dopo |
|---|---:|---|---|
| `laravel/Modules/Geo/app/Models/Traits/HasAddress.php` | 6 | shorter_tiebreak=6 | `0de689907f92` → `888d62c34517` |
| `laravel/Modules/Geo/app/Models/Traits/HasPlaceTrait.php` | 1 | incoming_nonempty=1 | `49f2b03850f5` → `024ab2845eec` |
| `laravel/Modules/Geo/app/Traits/HasAddresses.php` | 1 | shorter_tiebreak=1 | `b28e63f50a57` → `ec5e7de9b772` |
| `laravel/Modules/Geo/docs/chat/handoff-phpstan-modules-zero-2026-07-07.md` | 1 | shorter_tiebreak=1 | `8036fd81f10b` → `eeef67f6a04a` |
| `laravel/Modules/Geo/docs/index.md` | 2 | shorter_tiebreak=2 | `9ac4b2742d36` → `8ec4ebae1408` |
| `laravel/Modules/Geo/docs/install/install-from-zero.md` | 1 | shorter_tiebreak=1 | `cfefde31cb78` → `0084c3869301` |
| `laravel/Modules/Geo/docs/raw/history/docs-update-complete.md` | 1 | shorter_tiebreak=1 | `58caf6914cf9` → `b98a4d856a64` |
| `laravel/Modules/Geo/docs/raw/history/report.md` | 3 | shorter_tiebreak=3 | `b6046b2bc16d` → `834e6c7503ad` |
| `laravel/Modules/Geo/docs/raw/history/session-summary.md` | 1 | shorter_tiebreak=1 | `9bd90c4f6331` → `eaa489348b01` |
| `laravel/Modules/Geo/docs/wiki/index.md` | 1 | head_nonempty=1 | `2bfd25035797` → `76402973a210` |
| `laravel/Modules/Geo/tests/Playwright/marker-type-icon-parity.spec.js` | 3 | shorter_tiebreak=3 | `fc4854bf67bb` → `84e064280ec3` |
| `laravel/Modules/Geo/tests/Unit/Traits/HasAddressTest.php` | 1 | shorter_tiebreak=1 | `06363879b566` → `300bd9c17e4f` |
| `laravel/Modules/Geo/tests/Unit/Traits/TraitsTest.php` | 1 | shorter_tiebreak=1 | `2ba727e5e293` → `f7d232765928` |
| `laravel/Modules/Geo/tests/playwright/marker-type-icon-parity.spec.js` | 3 | shorter_tiebreak=3 | `fc4854bf67bb` → `84e064280ec3` |

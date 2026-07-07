# Ponytail-audit 2026-07-02: Geo module findings

Source: repo-wide ponytail-audit follow-up, same pass that produced the Xot and Notify findings dated 2026-07-02.

## Finding

`Modules/Geo/app/Contracts/GeocodingServiceInterface.php` had zero implementations and was never bound in any `ServiceProvider` or referenced anywhere outside its own file. Confirmed via:

- `grep -rn "GeocodingServiceInterface" Modules/ --include="*.php"` — only self-match (the interface declaration).
- `grep -rln "bind(" Modules/Geo/app/Providers/` and manual review of `GeoServiceProvider.php` — no binding for this contract.
- `Modules/Geo/app/Services/GeocodingService.php` is a concrete class used directly (via `spatie/laravel-queueable-action`'s `QueueableAction`), not through the interface.

Note: `Modules/UI/app/Contracts/GeocodingServiceContract.php` is a separate, unrelated contract in a different module — not affected by this change.

## Fix

Deleted the unused interface. No replacement, no re-binding — per ponytail YAGNI rung, an interface earns its place only when there are two concrete consumers that need the same boundary; this one had none.

## Verification

- `./vendor/bin/phpstan analyse Modules/Geo`: could not complete — blocked by pre-existing, unrelated broken state in `Modules/Xot` (separate git repo, `module_xot_fila5`), which has multiple uncommitted deleted Contract files causing Larastan's Laravel bootstrap to fail. Not caused by, or fixable within, this change; out of scope per task boundaries (Geo module only).
- `php tools/phpmd.phar Modules/Geo/app/Contracts text cleancode,codesize,controversial,design,naming,unusedcode`: no output (clean) — `Contracts/` still has two other files (`CalculateDistanceActionContract.php`, `HasGeolocation.php`), so this ran against the actual directory, not a fallback.
- `./vendor/bin/phpinsights analyse Modules/Geo/app --no-interaction`: architecture score below the configured threshold, unchanged before and after this deletion (verified by stashing/unstashing the change and re-running) — pre-existing, not introduced by this fix.
- Pest: skipped, DB unreachable in this environment.
- Puppeteer/Playwright: skipped, no UI changes.

## Caution note

While preparing this fix, a `git stash` / `git stash pop` cycle in `Modules/Geo`'s own repo (used to compare phpinsights before/after) surfaced spurious extra deletions (`app/Datas/*.php`, `app/Actions/Bing/GetAddressFromBingMapsAction.php`, its test, and a stray comment insertion in `GetAddressDataFromFullAddressAction.php`) that were never part of this change. All were identified via `git status`/`git diff` review and reverted with `git checkout --`. Final working tree contains only the single intended deletion. Flagging this filesystem behavior for future sessions working in this repo — verify `git status` output line by line after any stash operation here, don't trust it at a glance.

## Related

- `Modules/Xot/docs/ponytail-audit-2026-07-02.md`, `Modules/Notify/docs/ponytail-audit-2026-07-02.md`: same audit pass, same day.

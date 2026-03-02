# Chaos Hardening Static Analysis Rules

## Scope
Rules to keep the project resilient when dependencies or files are intentionally broken during chaos testing.

## Rules
- Prefer runtime guards (`class_exists`, `method_exists`) around optional integrations (Firebase/FCM/third-party SDKs).
- Do not block bootstrap on dynamic class scans: skip invalid entries and log actionable errors.
- For static analysis, avoid hard type references to optional packages unless guaranteed installed.
- Keep module-level dependencies in `Modules/<Module>/composer.json`; run `composer go` after changes.
- Every chaos fix must be followed by `phpstan` re-check on affected modules.

## Validation Baseline (2026-03-02)
- `Modules/Cms`, `Modules/Geo`, `Modules/Tenant`, `Modules/Media`, `Modules/Notify`, `Modules/User`: PHPStan clean.
- `phpinsights` executed on same scope with explicit `--composer=composer.lock`.

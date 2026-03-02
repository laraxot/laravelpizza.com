# Chaos Hardening Memory - 2026-03-02

## Key Fixes Remembered
- Tenant morph map bootstrap hardened to avoid fatal class lookup during analysis.
- Media video conversion action now verifies exporter API before calling `save()`.
- Notify Firebase push flow refactored to support missing optional dependencies without fatal errors.
- Missing `MailTemplateVersionFactory` added for Notify model/factory consistency.

## Known Tooling Constraints
- `phpmd` is not installed in this repository (`./vendor/bin/phpmd` missing).
- `phpinsights` security check can fail without explicit composer lock path; use `--composer=composer.lock`.

## Reusable Command Pattern
- `XDEBUG_MODE=off ./vendor/bin/phpstan analyse Modules/<Module> --debug --no-progress`

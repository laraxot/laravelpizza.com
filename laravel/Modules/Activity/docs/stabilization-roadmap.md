# Stabilization Roadmap - Activity Module

## Context & Philosophy
Following the "Super Mucca" methodology, this roadmap outlines the resolution of newly discovered PHPStan Level 10 errors in the `Activity` module. 
The errors primarily involve variable name mismatches in PHPDoc tags within `ActivityLogger.php`.

## The Great Debate ("Litigata")
Internal debate regarding `@var` tags for collections:
- **Thesis (KISS)**: Remote the `@var` tags entirely if the collection is already type-hinted in the method signature or assignment.
- **Antithesis (SOLID/Robust)**: Keep the tags but fix the variable names. Precise PHPDoc is better for IDE support and PHPStan Level 10 narrowing, even if it feels verbose.
- **Winner**: Antithesis. Precision wins. Verbosity is a fair price for 100% type safety and zero ambiguity.

## Target: ActivityLogger.php
Status: 4 Errors (varTag.variableNotFound)

### Planned Fixes
| Line | Issue | Planned Action |
|------|-------|----------------|
| 148 | `@var Collection $activities` vs `$results` | Rename PHPDoc variable to `$results` |
| 164 | `@var Collection $activities` vs `$results` | Rename PHPDoc variable to `$results` |
| 187 | `@var Collection $activities` vs `$results` | Rename PHPDoc variable to `$results` |
| 206 | `@var Collection $activities` vs `$results` | Rename PHPDoc variable to `$results` |

## Verification Plan
1. `./vendor/bin/phpstan analyse Modules/Activity --level=10`
2. `./vendor/bin/phpmd Modules/Activity text codesize`
3. `./vendor/bin/phpinsights analyse Modules/Activity`
4. Update `phpstan-corrections-january-2026.md` with results.

## Zen Note
"A variable name mismatch is a disconnect between intent and reality. Restoration requires alignment."

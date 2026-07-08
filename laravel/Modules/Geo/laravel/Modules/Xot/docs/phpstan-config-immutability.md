# PHPStan Config Immutability (Global Project Rule)

- File target: `phpstan.neon`
- File target: `phpstan.neon`
- File target: `phpstan.neon`
- Status: IMMUTABLE — never modify this file via automation or PRs. Only the user may edit it manually.

## Rationale
- Single source of truth for static analysis settings.
- Prevents wide-impact accidental changes.

## How to adjust analysis without editing phpstan.neon
- Scope via CLI paths, e.g. per-module gate: `bash bashscripts/tools/phpstan-modules-gate.sh`
- **Never create alternate `.neon` files** — see `docs/wiki/rules/phpstan-single-neon-config.md`

```bash
cd laravel
php -d xdebug.mode=off -d memory_limit=2G \
  ./vendor/bin/phpstan analyse Modules/User --memory-limit=2G
```

## Enforcement
- Assistants, scripts, and CI MUST NOT patch `phpstan.neon`.
- Prefer per-run options and per-module execution.

## Cross-References
- `.ai/guidelines/phpstan-config-immutability.md`
- `.cursor/rules/phpstan-config-immutability.mdc`
- `.windsurf/rules/phpstan-config-immutability.mdc`

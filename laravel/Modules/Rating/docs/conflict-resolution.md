# Conflict Resolution — Module Rating

## Summary
- **Files resolved**: 1
- **Strategy**: Keep HEAD/local (ours) side
- **Root cause**: Nested stash-on-merge conflicts

## Config Files
- composer.json

## Backlinks
- [Root conflict resolution report](../../../../docs/conflict-resolution-report.md)

## Regressioni silenziose del sync del 21/11 (24/11/2026)

`find_sync_regressions.py` (`SYNC_BASE=dd46996a4`) su `Modules/Rating`: 11 `deleted-unseen`, tutti file di strumenti alla
radice del modulo (`.gitmodules`, `.php-cs-fixer*.php`, `.php_cs.dist.php`, `phpmd.ruleset.xml`, `phpstan-baseline.neon`,
`phpstan.neon.dist`, `phpstan_constants.php`, `phpunit.xml.dist`, `webpack.mix.js`, `scripts/ci/contributor-lines-report.mjs`).
Nessuno e' letto dal codice del modulo; non ripristinati (la regola del progetto e' nessuna baseline PHPStan).

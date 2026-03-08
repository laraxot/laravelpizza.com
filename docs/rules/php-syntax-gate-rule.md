# PHP Syntax Gate Rule

## Regola

Nessun avanzamento di test/coverage puo' essere considerato valido se esistono parse error PHP nel codebase.

## Gate obbligatorio

1. Eseguire lint sintattica globale (`php -l`) sui moduli.
2. Se `Errors parsing > 0`, aprire/aggiornare issue blocker.
3. Solo dopo `Errors parsing = 0` eseguire batch Pest per coverage.

## Tooling

Script standard:
- `bashscripts/scripts/quality/php-lint-gate.sh`

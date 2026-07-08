# Setup strumenti qualità codice

## Regola phpstan.neon

**NON modificare mai** `laravel/phpstan.neon`. Le correzioni vanno fatte solo nel codice sorgente.

## PHPMD e PHPInsights — SOLO formato .phar

**Regola**: PHPMD e PHPInsights **NON** vanno installati con Composer. Si usano in formato **.phar** e si invocano con php phpmd.phar e php phpinsights.phar.

### Perché .phar

- **Indipendenza**: Nessuna dipendenza in composer.json, nessun conflitto con il progetto
- **Portabilità**: Un solo file riutilizzabile tra progetti
- **Leggerezza**: Nessun vendor aggiuntivo
- **CI/CD**: Più semplice da cachare e scaricare

### PHPMD

- **Installazione**: `wget -c https://phpmd.org/static/latest/phpmd.phar -O laravel/tools/phpmd.phar`
- **Comando**: `cd laravel && php tools/phpmd.phar Modules text cleancode,codesize,controversial,design,naming,unusedcode`
- **Singolo modulo**: `php tools/phpmd.phar Modules/{Module} text codesize`

### PHPInsights

- **Installazione**: Build locale con box — vedi [phpinsights-phar-build](phpinsights-phar-build.md)
- **Build**: `cd laravel/tools/build-phpinsights && ./build.sh`
- **Comando**: `cd laravel && php tools/phpinsights.phar analyse Modules --no-interaction`

### Struttura

laravel/tools/
  phpmd.phar
  phpinsights.phar

## PHPStan

- Config: laravel/phpstan.neon (immutabile)
- Comando: `cd laravel && ./vendor/bin/phpstan analyse Modules`
- PHPStan resta in Composer.

## Collegamenti

- [phpinsights-phar-build](phpinsights-phar-build.md)
- [phpstan-level-10-rules](phpstan-level-10-rules.md)
- [.cursor/rules/error-resolution-process.mdc](../.cursor/rules/error-resolution-process.mdc)

# Automation & commands

Questo documento è uno stub.

Comandi qualità (da `laravel/`):

- PHPStan: `./vendor/bin/phpstan analyse Modules/{ModuleName} --level=10 --memory-limit=-1`
- Pint: `./vendor/bin/pint --dirty`
- PHPMD: `./vendor/bin/phpmd Modules/{ModuleName} text codesize`
- PHP Insights: `./vendor/bin/phpinsights analyse Modules/{ModuleName} --format=table`

Contenuti correlati:

- [Coding standards & analysis](./coding-standards.md)
- [PHPStan level 10](../phpstan-level-10.md)

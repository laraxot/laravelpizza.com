# phpstan.neon immutabile

## Regola critica

`laravel/phpstan.neon` è l'unico file di configurazione PHPStan del progetto. È quello da usare con PHPStan.

## Vietato

- ❌ Modificare `laravel/phpstan.neon`
- ❌ Creare file `phpstan.neon.dist` in moduli
- ❌ Creare altri file di configurazione PHPStan

## Comando

```bash
cd laravel
./vendor/bin/phpstan analyse Modules --memory-limit=-1
```

## Collegamenti

- [PHPSTAN_RULES](../../../.cursor/rules/PHPSTAN_RULES.mdc)
- [phpstan-level-10-rules](../../../docs/phpstan-level-10-rules.md)

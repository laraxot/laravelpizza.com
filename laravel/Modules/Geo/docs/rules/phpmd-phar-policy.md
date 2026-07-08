# PHPMD PHAR Policy

## Regola

PHPMD deve essere eseguito solo in modalità standalone PHAR, senza dipendenza Composer.

## Comandi standard

```bash
bash bashscripts/quality/ensure_phpmd_phar.sh
bash laravel/tools/phpmd.sh laravel text phpmd.xml --exclude vendor,node_modules,bootstrap,caches
```

## Vincoli

- Non usare `./vendor/bin/phpmd`
- Non aggiungere `phpmd/phpmd` in `composer.json`
- Se `laravel/tools/phpmd.phar` manca, usare `bashscripts/quality/ensure_phpmd_phar.sh`

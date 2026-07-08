# Code Quality

> Standard di qualità del codice per PTVX.

## 🔍 Quality Checks (obbligatori dopo ogni modifica)

### PHPStan (Level 10)
```bash
php -d memory_limit=2G ./vendor/bin/phpstan analyse
```

**Regole:**
- Tutti gli errori devono essere risolti
- Nessun ignore errors
- Livello 10 obbligatorio

### PHPMD
```bash
bash laravel/tools/phpmd.sh laravel text phpmd.xml --exclude vendor,node_modules,bootstrap,caches
```

**Regola:** Usare sempre il wrapper PHAR, mai composer require.

### PHPInsights
```bash
./vendor/bin/phpinsights -v --no-interaction
```

## ✨ Laravel Pint (PSR-12)
```bash
# Verifica
./vendor/bin/pint --test

# Correzione automatica
./vendor/bin/pint --dirty
```

## 🔗 Link

**Di ritorno:**
- → [CLAUDE.md - Code Quality](../../CLAUDE.md)
- → [AGENTS.md - Quality Checks](../../AGENTS.md#quality-checks-obbligatori-dopo-ogni-modifica)
- → [INDEX](index.md)

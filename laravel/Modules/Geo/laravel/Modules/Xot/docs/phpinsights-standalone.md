# PHPInsights — Installazione Standalone

**Versione**: v2.12.0+ (isolata in `tools/phpinsights/`)
**Stato**: ✅ Installato

---

## Perché Standalone?

PHPInsights ha molte dipendenze (PHP_CodeSniffer, `slevomat/coding-standard`, `friendsofphp/php-cs-fixer`, ecc.) che possono entrare in **conflitto** con le dipendenze del progetto principale.

> [!CAUTION]
> **NON** installare phpinsights con `composer require` nel progetto principale.
> Usare sempre l'installazione isolata in `tools/phpinsights/`.

---

## Utilizzo

```bash
# Versione
php tools/phpinsights/vendor/bin/phpinsights --version

# Oppure con il wrapper
bash tools/phpinsights.sh --version

# Analisi di un modulo
bash tools/phpinsights.sh analyse Modules/Rating/app --no-interaction

# Analisi con summary
bash tools/phpinsights.sh analyse Modules/Rating/app --no-interaction --summary

# Analisi su un singolo file
bash tools/phpinsights.sh analyse Modules/Rating/app/Models/BaseRating.php --no-interaction
```

---

## Struttura

```
laravel/
├── tools/
│   ├── phpinsights.sh          # Wrapper script
│   └── phpinsights/
│       ├── composer.json       # Composer isolato
│       ├── composer.lock
│       └── vendor/
│           └── bin/
│               └── phpinsights # Eseguibile
```

---

## Aggiornamento

```bash
cd tools/phpinsights
composer update nunomaduro/phpinsights
```

---

## Per altri Agenti AI

> [!IMPORTANT]
> Quando devi eseguire PHPInsights:
> - **Usa**: `php tools/phpinsights/vendor/bin/phpinsights` o `bash tools/phpinsights.sh`
> - **NON usare**: `./vendor/bin/phpinsights` o `php artisan insights`
> - **NON modificare**: `laravel/composer.json` per aggiungere phpinsights
> - **PHPStan**: continua a usare `vendor/bin/phpstan` (installato nel progetto)
> - **PHPMD**: continua a usare `vendor/bin/phpmd` (installato nel progetto)

## Riferimenti

- [nunomaduro/phpinsights GitHub](https://github.com/nunomaduro/phpinsights)
- [Laravel News — Getting Started](https://laravel-news.com/getting-started-with-phpinsights)
- [phpinsights.com](https://phpinsights.com)

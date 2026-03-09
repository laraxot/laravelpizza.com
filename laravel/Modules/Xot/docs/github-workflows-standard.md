# GitHub Workflows Standard - base_laravelpizza

**Ultimo aggiornamento**: [DATE]
**Principi**: DRY + KISS + SOLID + Robust
**Stack**: Laravel 12 + Filament 4 + PHP 8.3 + Laraxot

---

## 📋 Standard Workflow Quality.yml

Tutti i moduli e temi devono avere un workflow `quality.yml` standardizzato con:

### Caratteristiche Standard
- **PHP Version**: 8.4
- **Actions**: checkout@v5, setup-php@v2
- **Environment**: Testing
- **Branches**: develop, main
- **Path filtering**: Solo file del modulo/tema specifico
- **Tool**: PHPStan Level 10, PHPMD, Pint, PHPInsights (opzionale)

### Struttura Standard

```yaml
name: {ModuleName} Quality Checks

on:
  push:
    branches:
      - develop
      - main
    paths:
      - 'laravel/Modules/{ModuleName}/**'
      # oppure per temi:
      - 'laravel/Themes/{ThemeName}/**'
  pull_request:
    branches:
      - develop
      - main
    paths:
      - 'laravel/Modules/{ModuleName}/**'
      # oppure per temi:
      - 'laravel/Themes/{ThemeName}/**'

jobs:
  quality:
    runs-on: ubuntu-latest
    environment: Testing

    steps:
      - uses: actions/checkout@v5

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.4'

      - name: Add Flux Credentials Loaded From ENV
        run: composer config http-basic.composer.fluxui.dev "${{ secrets.FLUX_USERNAME }}" "${{ secrets.FLUX_LICENSE_KEY }}"

      - name: Install Dependencies
        run: |
          cd laravel
          composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist

      - name: Run PHPStan
        working-directory: laravel
        run: |
          ./vendor/bin/phpstan analyse Modules/{ModuleName} --level=10 --memory-limit=-1 || true

      - name: Run PHPMD
        working-directory: laravel
        run: |
          if [ -f phpmd.phar ]; then
            php phpmd.phar Modules/{ModuleName} text cleancode,codesize,design,naming,unusedcode || true
          else
            echo "PHPMD not found, skipping..."
          fi

      - name: Run Pint
        working-directory: laravel
        run: |
          ./vendor/bin/pint Modules/{ModuleName} || true

      - name: Run PHPInsights
        working-directory: laravel
        run: |
          if [ -f vendor/bin/phpinsights ]; then
            ./vendor/bin/phpinsights analyse Modules/{ModuleName} --format=table --no-interaction --min-quality=70 || true
          else
            echo "PHPInsights not found, skipping..."
          fi
```

---

## ✅ Checklist Standardizzazione

Per ogni modulo/tema:
- [x] Workflow `quality.yml` presente
- [x] PHP 8.4 configurato
- [x] Actions aggiornati (checkout@v5, setup-php@v2)
- [x] Path filtering corretto
- [x] PHPStan Level 10
- [x] PHPMD con tutte le regole
- [x] Pint per formattazione
- [x] PHPInsights con --min-quality=70 (opzionale)

---

## 🔄 Operational Workflows

### Sync Remote Repo (`sync-remote-repo.yml`)

Workflow per la sincronizzazione dei subtree e repository remoti.

**Gestione Repository Privati (Bashscripts):**
Per semplificare l'autenticazione, utilizziamo il fork/repository interno all'organizzazione `provtv/bashscripts_fila5`.
Questo ci permette di usare il `GITHUB_TOKEN` standard invece di dover gestire un PAT segreto (`BASHSCRIPTS_PAT`) per repository esterni.

```yaml
      - name: Checkout bashscripts
        uses: actions/checkout@v4
        with:
          repository: provtv/bashscripts_fila5
          token: ${{ secrets.GITHUB_TOKEN }} # Accessibile nativamente nell'organizzazione
          path: bashscripts
```

**Prevenzione Errori Submodule:**
Il checkout principale deve disabilitare i submodule per evitare errori su indici corrotti ("zombie submodules").

```yaml
      - name: Checkout
        uses: actions/checkout@v4
        with:
          fetch-depth: 0
          token: ${{ secrets.GITHUB_TOKEN }}
          submodules: false # Explicitly disable
```

---

## 📚 Documentazione Correlata

- [CI/CD Tools Execution Report](./ci-cd-tools-execution-report.md)
- [Code Quality Tools Setup](./code-quality-tools-setup.md)
- [CI Quality Pipeline](./ci-quality-pipeline.md)

---

**Filosofia**: DRY + KISS - Workflow standardizzati per tutti i moduli/temi, mantenibilità e coerenza.

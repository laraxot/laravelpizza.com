# Pest PHP Coverage & GitHub Actions Badge

## Overview

Implementazione completa del badge di coverage per Pest PHP con GitHub Actions.

## Documentazione Ufficiale

- **Pest Coverage**: https://pestphp.com/docs/coverage/
- **Pest CI/CD**: https://pestphp.com/docs/continuous-integration
- **Pest Type Coverage**: https://github.com/pestphp/pest-plugin-type-coverage/
- **Pest Coverage Plugin**: https://github.com/pestphp/pest-plugin-coverage

## GitHub Actions & Marketplace

- **Pest Run Action**: https://github.com/marketplace/actions/pestphp-run-pest-tests
- **PHPUnit Coverage Badge**: https://github.com/marketplace/actions/phpunit-coverage-badge
- **Comment Test Coverage**: https://github.com/marketplace/actions/comment-test-coverage
- **Tutorial Badge**: https://dev.to/robertobutti/add-test-coverage-badge-for-php-and-pest-in-your-github-repository-37mo

## Implementazione

### 1. GitHub Actions Workflow (`.github/workflows/pest-coverage.yml`)

```yaml
name: Pest Coverage

on:
  push:
    branches: [main, dev]
  pull_request:
    branches: [main, dev]

jobs:
  coverage:
    runs-on: ubuntu-latest
    
    steps:
      - name: Checkout code
        uses: actions/checkout@v4
        
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.3'
          extensions: mbstring, intl, pdo_mysql
          coverage: pcov
          
      - name: Install dependencies
        run: |
          cd laravel
          composer install --no-interaction --prefer-dist
          
      - name: Run Pest with coverage
        run: |
          cd laravel
          ./vendor/bin/pest --coverage --coverage-xml=coverage.xml --min=80
          
      - name: Generate coverage badge
        uses: timkrase/phpunit-coverage-badge@v1.2.1
        with:
          coverage_xml: laravel/coverage.xml
          badge_path: coverage-badge.svg
          push_badge: true
          repo_token: ${{ secrets.GITHUB_TOKEN }}
```

### 2. Pest Configuration (`phpunit.xml`)

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="./vendor/phpunit/phpunit/phpunit.xsd"
         bootstrap="vendor/autoload.php"
         colors="true"
>
    <testsuites>
        <testsuite name="Unit">
            <directory suffix="Test.php">./tests/Unit</directory>
        </testsuite>
        <testsuite name="Feature">
            <directory suffix="Test.php">./tests/Feature</directory>
        </testsuite>
    </testsuites>
    
    <coverage>
        <report>
            <html outputDirectory="coverage-html"/>
            <xml outputDirectory="coverage-xml"/>
        </report>
    </coverage>
    
    <source>
        <include>
            <directory suffix=".php">./app</directory>
            <directory suffix=".php">./Modules</directory>
        </include>
        <exclude>
            <directory>./vendor</directory>
            <directory>./tests</directory>
            <directory>./config</directory>
            <directory>./database</directory>
            <directory>./resources</directory>
            <directory>./routes</directory>
            <directory>./bootstrap</directory>
            <directory>./storage</directory>
        </exclude>
    </source>
</phpunit>
```

### 3. README.md Badge

```markdown
[![Pest Coverage](https://img.shields.io/badge/coverage-85%25-green)](https://github.com/laraxot/laravelpizza.com/actions)
```

### 4. Alternative: Dynamic Badge with Shields.io

```yaml
      - name: Extract coverage percentage
        id: coverage
        run: |
          cd laravel
          COVERAGE=$(./vendor/bin/pest --coverage 2>&1 | grep -oP '\d+\.?\d*%' | head -1)
          echo "percentage=$COVERAGE" >> $GITHUB_OUTPUT
          
      - name: Create dynamic badge
        run: |
          COVERAGE="${{ steps.coverage.outputs.percentage }}"
          COLOR="red"
          if (( $(echo "$COVERAGE" | cut -d'%' -f1) >= 80 )); then COLOR="green"; fi
          if (( $(echo "$COVERAGE" | cut -d'%' -f1) >= 60 )) && (( $(echo "$COVERAGE" | cut -d'%' -f1) < 80 )); then COLOR="yellow"; fi
          
          curl -s "https://img.shields.io/badge/coverage-$COVERAGE-$COLOR" > coverage-badge.svg
```

## Comandi Pest Coverage

```bash
# Coverage base
./vendor/bin/pest --coverage

# Coverage con minimo
./vendor/bin/pest --coverage --min=80

# Coverage XML (per badge)
./vendor/bin/pest --coverage --coverage-xml=coverage.xml

# Coverage HTML (report visuale)
./vendor/bin/pest --coverage --coverage-html=coverage-html

# Coverage + Type Coverage
./vendor/bin/pest --coverage --type-coverage

# Parallel + Coverage
./vendor/bin/pest --parallel --coverage
```

## Configurazione PCOV (Consigliato)

PCOV è più veloce di Xdebug per la coverage:

```bash
# Installazione
pecl install pcov

# php.ini
extension=pcov.so
pcov.enabled=1
pcov.directory=/path/to/laravel
```

## Best Practices

1. **Minimo Coverage**: Impostare `--min=80` per fallire se coverage < 80%
2. **Parallel Testing**: Usare `--parallel` per velocizzare
3. **PCOV vs Xdebug**: PCOV è 3x più veloce
4. **Cache Composer**: Abilitare cache in GitHub Actions
5. **Coverage solo su PR**: Non bloccare il push, solo i PR

## Struttura Coverage

```
laravel/
├── .github/
│   └── workflows/
│       └── pest-coverage.yml
├── coverage-html/          # Report HTML (gitignored)
├── coverage-xml/           # Report XML per badge
├── coverage-badge.svg      # Badge generato
└── phpunit.xml            # Configurazione coverage
```

## Collegamenti

- [Testing Guidelines](./testing-guidelines.md)
- [Pest Configuration](./pest-configuration.md)
- [CI/CD Setup](./ci-cd-setup.md)

# Raccomandazioni Code Quality - Implementazione Pratica

## 🎯 Priorità Immediate (Implementare Subito)

### 1. Pre-Commit Hooks ✅ CREATO

**File**: `bashscripts/hooks/pre-commit`

**Installazione**:
```bash
cp bashscripts/hooks/pre-commit .git/hooks/pre-commit
chmod +x .git/hooks/pre-commit
```

**Cosa fa**:
- ✅ Syntax check PHP
- ✅ Laravel Pint auto-fix
- ✅ PHPStan livello 10
- ✅ PHPMD con ruleset
- ✅ PHPInsights (warning)

**Vantaggi**:
- Blocca codice non conforme PRIMA del commit
- Auto-corregge problemi di formattazione
- Feedback immediato

### 2. Test Coverage Tracking

**Target**: 80% per nuovo codice, non diminuire coverage esistente

**Implementazione**:
```bash
# Eseguire con coverage
php artisan test --coverage --min=80

# Verificare solo file modificati
php artisan test --coverage --filter="GetFilenameBySchedaAction"
```

**GitHub Action**:
```yaml
# .github/workflows/test-coverage.yml
name: Test Coverage

on: [pull_request]

jobs:
  coverage:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      - uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
          coverage: xdebug
      - run: composer install
      - run: php artisan test --coverage --min=80
```

### 3. Security Scanning Dependencies

**GitHub Dependabot** (già disponibile):
```yaml
# .github/dependabot.yml
version: 2
updates:
  - package-ecosystem: "composer"
    directory: "/laravel"
    schedule:
      interval: "weekly"
    open-pull-requests-limit: 10
```

**Composer Audit**:
```bash
# Verifica vulnerabilità
composer audit

# Solo critiche
composer audit --only-critical
```

## 📊 Metriche da Monitorare

### Dashboard Qualità (implementare con SonarCloud)

1. **Test Coverage Trend**
   - Target: > 80%
   - Alert se < 70%

2. **PHPStan Errors**
   - Target: 0
   - Alert se > 0

3. **Code Duplication**
   - Target: < 3%
   - Alert se > 5%

4. **Security Vulnerabilities**
   - Target: 0 critiche
   - Alert immediato

5. **Technical Debt**
   - Target: < 5 giorni
   - Alert se > 10 giorni

## 🔧 Tool Setup Rapido

### Installazione Tool Aggiuntivi

```bash
cd laravel

# Mutation Testing
composer require --dev infection/infection

# Automated Refactoring
composer require --dev rector/rector

# Coverage Report HTML
composer require --dev phpunit/php-code-coverage
```

### Configurazione Infection

```json
// infection.json
{
    "timeout": 10,
    "source": {
        "directories": ["Modules"]
    },
    "mutators": {
        "@default": true
    },
    "minMsi": 80,
    "minCoveredMsi": 80,
    "ignoreMutationsWithComment": true
}
```

### Configurazione Rector

```php
<?php
// rector.php
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;

return RectorConfig::configure()
    ->withPaths(['Modules'])
    ->withSets([
        LevelSetList::UP_TO_PHP_82,
    ])
    ->withSkip([
        '*/vendor/*',
        '*/tests/*',
    ]);
```

## 📈 Roadmap Implementazione

### Settimana 1
- [x] Pre-commit hooks
- [ ] Test coverage GitHub Action
- [ ] Dependabot configurazione

### Settimana 2-4
- [ ] SonarCloud setup
- [ ] PR checklist automatizzato
- [ ] Documentation quality checks

### Mese 2-3
- [ ] Mutation testing setup
- [ ] Performance baseline
- [ ] Code metrics dashboard

## 🎓 Formazione Team

### Workshop Suggeriti
1. **Testing Best Practices** (2 ore)
   - TDD/BDD patterns
   - Test isolation
   - Mocking strategies

2. **Code Quality Tools** (1 ora)
   - PHPStan avanzato
   - PHPMD ruleset
   - PHPInsights config

3. **Security Awareness** (1 ora)
   - Dependency vulnerabilities
   - Code injection prevention
   - Data sanitization

## 🔗 Collegamenti Utili

- [Pre-commit Hook](../bashscripts/hooks/pre-commit)
- [Code Quality Rules](../.cursor/rules/code-quality-mandatory.mdc)
- [CI Quality Pipeline](../../laravel/Modules/Xot/docs/ci-quality-pipeline.md)
- [Testing Strategy](../../laravel/Modules/Xot/docs/testing/strategy.md)

---

**Prossimi Step**: Implementare pre-commit hook e test coverage tracking


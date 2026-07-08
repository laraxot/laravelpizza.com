# Raccomandazioni per Incrementare Code Quality - Laraxot PTVX

## 🎯 Obiettivo
Raggiungere **eccellenza nella qualità del codice** attraverso automazione, standardizzazione e pratiche consolidate.

## 📊 Stato Attuale

### ✅ Già Implementato
- PHPStan livello 10
- PHPMD con ruleset personalizzato
- PHPInsights
- Laravel Pint configurato
- PHP-CS-Fixer configurato
- GitHub Actions per test validation
- Processo obbligatorio documentato

### ⚠️ Da Migliorare
- Automazione pre-commit
- Test coverage tracking
- Code review automatizzato
- Performance monitoring
- Security scanning

## 🚀 Raccomandazioni Prioritarie

### 1. Pre-Commit Hooks Automatizzati (PRIORITÀ ALTA)

**Obiettivo**: Bloccare commit con codice non conforme prima che entri nel repository.

**Implementazione**:

```bash
#!/bin/bash
# .git/hooks/pre-commit

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${YELLOW}🔍 Pre-commit checks running...${NC}"

# 1. Syntax Check
echo -e "  ✓ Checking PHP syntax..."
for file in $(git diff --cached --name-only --diff-filter=ACMR | grep "\.php$"); do
    if ! php -l "$file" > /dev/null 2>&1; then
        echo -e "${RED}❌ Syntax error in: $file${NC}"
        php -l "$file"
        exit 1
    fi
done

# 2. Laravel Pint (auto-fix)
echo -e "  ✓ Running Laravel Pint..."
cd /var/www/html/ptvx/laravel
./vendor/bin/pint --test --dirty > /dev/null 2>&1 || {
    echo -e "${YELLOW}⚠️  Code style issues detected. Running Pint auto-fix...${NC}"
    ./vendor/bin/pint --dirty
    git add -u
}

# 3. PHPStan livello 10 (solo file modificati)
echo -e "  ✓ Running PHPStan level 10..."
PHPSTAN_FILES=$(git diff --cached --name-only --diff-filter=ACMR | grep "\.php$" | grep -v "vendor/" | grep -v "tests/")
if [ ! -z "$PHPSTAN_FILES" ]; then
    ./vendor/bin/phpstan analyze $PHPSTAN_FILES --level=10 --memory-limit=2G --no-progress > /dev/null 2>&1 || {
        echo -e "${RED}❌ PHPStan errors detected!${NC}"
        ./vendor/bin/phpstan analyze $PHPSTAN_FILES --level=10 --memory-limit=2G
        exit 1
    }
fi

# 4. PHPMD (con ruleset progetto)
echo -e "  ✓ Running PHPMD..."
for file in $(git diff --cached --name-only --diff-filter=ACMR | grep "\.php$"); do
    if [ -f "$file" ]; then
        ./vendor/bin/phpmd "$file" text phpmd-ruleset.xml > /dev/null 2>&1 || {
            echo -e "${YELLOW}⚠️  PHPMD warnings in: $file${NC}"
            ./vendor/bin/phpmd "$file" text phpmd-ruleset.xml || true
        }
    fi
done

echo -e "${GREEN}✅ All pre-commit checks passed!${NC}"
exit 0
```

**Vantaggi**:
- ✅ Blocca codice non conforme prima del commit
- ✅ Auto-corregge problemi di formattazione
- ✅ Feedback immediato per lo sviluppatore
- ✅ Riduce errori in CI/CD

**Installazione**:
```bash
chmod +x .git/hooks/pre-commit
cp bashscripts/hooks/pre-commit .git/hooks/pre-commit
```

### 2. Test Coverage Obbligatorio (PRIORITÀ ALTA)

**Obiettivo**: Garantire test coverage minimo per nuovo codice.

**Implementazione**:

```php
<?php
// phpunit.xml o pest.php

<coverage>
    <include>
        <directory suffix=".php">Modules</directory>
    </include>
    <exclude>
        <directory>vendor</directory>
        <directory>tests</directory>
        <directory>database</directory>
    </exclude>
    <report>
        <clover outputFile="build/coverage.xml"/>
        <html outputDirectory="build/coverage"/>
        <text outputFile="php://stdout"/>
    </report>
</coverage>

<php>
    <ini name="xdebug.mode" value="coverage"/>
</php>
```

**GitHub Actions**:
```yaml
# .github/workflows/coverage.yml
name: Test Coverage

on: [pull_request]

jobs:
  coverage:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
          coverage: xdebug
          
      - name: Install dependencies
        run: composer install
        
      - name: Run tests with coverage
        run: php artisan test --coverage --min=80
        
      - name: Upload coverage
        uses: codecov/codecov-action@v3
```

**Regola**:
- Nuovo codice: minimo 80% coverage
- Codice modificato: non diminuire coverage esistente
- Azioni critiche: 100% coverage

### 3. Code Review Automatizzato con Bot (PRIORITÀ MEDIA)

**Obiettivo**: Analisi automatica delle PR con suggerimenti concreti.

**Strumenti**:
- **SonarQube** o **SonarCloud** (analisi completa)
- **CodeClimate** (quality metrics)
- **Codacy** (code review automatizzato)

**Implementazione SonarCloud**:
```yaml
# .github/workflows/sonarcloud.yml
name: SonarCloud Analysis

on:
  pull_request:
    branches: [main, develop]

jobs:
  sonarcloud:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
        with:
          fetch-depth: 0
          
      - name: SonarCloud Scan
        uses: SonarSource/sonarcloud-github-action@master
        env:
          GITHUB_TOKEN: ${{ secrets.GITHUB_TOKEN }}
          SONAR_TOKEN: ${{ secrets.SONAR_TOKEN }}
```

**Metriche da Monitorare**:
- Code Smells
- Security Hotspots
- Code Duplication
- Cognitive Complexity
- Maintainability Rating

### 4. Mutation Testing (PRIORITÀ MEDIA)

**Obiettivo**: Verificare che i test siano effettivamente efficaci.

**Strumento**: **Infection PHP** (https://infection.github.io/)

**Implementazione**:
```bash
# Installazione
composer require --dev infection/infection

# Configurazione infection.json
{
    "timeout": 10,
    "source": {
        "directories": ["Modules"]
    },
    "mutators": {
        "@default": true
    },
    "minMsi": 80,
    "minCoveredMsi": 80
}

# Esecuzione
./vendor/bin/infection
```

**Vantaggi**:
- ✅ Identifica test inefficaci
- ✅ Migliora qualità dei test
- ✅ Trova bug nascosti
- ✅ Aumenta confidenza nel codice

### 5. Dependency Security Scanning (PRIORITÀ ALTA)

**Obiettivo**: Identificare vulnerabilità nelle dipendenze.

**Implementazione**:

```yaml
# .github/workflows/security.yml
name: Security Scan

on:
  schedule:
    - cron: '0 0 * * 0' # Ogni domenica
  push:
    branches: [main]
  pull_request:

jobs:
  security:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      
      - name: Run Composer Audit
        run: composer audit --format=json > security-report.json
        
      - name: Run PHPStan Security Rules
        run: ./vendor/bin/phpstan analyze --level=10 --configuration=phpstan-security.neon
        
      - name: Upload Security Report
        uses: github/codeql-action/upload-sarif@v2
        with:
          sarif_file: security-report.json
```

**Strumenti Aggiuntivi**:
- **Dependabot** (GitHub nativo)
- **Renovate** (più configurabile)
- **Snyk** (security scanning avanzato)

### 6. Performance Testing Automatico (PRIORITÀ BASSA)

**Obiettivo**: Monitorare regressioni di performance.

**Implementazione**:

```php
<?php
// tests/Performance/BaselineTest.php

class PerformanceBaselineTest extends TestCase
{
    public function test_action_execution_time(): void
    {
        $start = microtime(true);
        
        app(GetFilenameBySchedaAction::class)
            ->execute($this->createMock(SchedaContract::class));
            
        $duration = microtime(true) - $start;
        
        // Baseline: < 1ms
        expect($duration)->toBeLessThan(0.001);
    }
}
```

### 7. Automated Code Review Checklist (PRIORITÀ ALTA)

**Obiettivo**: Checklist automatica per ogni PR.

**Template PR**:
```markdown
## Checklist Pre-Merge

- [ ] PHPStan livello 10 passa
- [ ] PHPMD passa (con ruleset progetto)
- [ ] PHPInsights passa
- [ ] Laravel Pint applicato
- [ ] Test coverage >= 80%
- [ ] Test di regressione aggiunti
- [ ] Documentazione aggiornata
- [ ] Changelog aggiornato
- [ ] Breaking changes documentati
- [ ] Performance verificata
```

**GitHub Action**:
```yaml
# .github/workflows/pr-checklist.yml
name: PR Checklist

on:
  pull_request:
    types: [opened, synchronize]

jobs:
  checklist:
    runs-on: ubuntu-latest
    steps:
      - name: Check PR Template
        uses: actions/github-script@v6
        with:
          script: |
            const body = context.payload.pull_request.body;
            const checklist = ['PHPStan', 'PHPMD', 'PHPInsights', 'Tests'];
            checklist.forEach(item => {
              if (!body.includes(`- [x] ${item}`)) {
                core.setFailed(`Missing checklist item: ${item}`);
              }
            });
```

### 8. Code Metrics Dashboard (PRIORITÀ BASSA)

**Obiettivo**: Visualizzazione dashboard metriche qualità.

**Strumenti**:
- **CodeClimate** (dashboard integrati)
- **SonarQube** (dashboard completo)
- **Custom dashboard** con metriche personalizzate

**Metriche da Tracciare**:
- Test Coverage %
- PHPStan errors trend
- Code Duplication %
- Technical Debt (ore)
- Security Vulnerabilities count
- Average Complexity

### 9. Automated Refactoring Suggestions (PRIORITÀ BASSA)

**Obiettivo**: Suggerimenti automatici per refactoring.

**Strumenti**:
- **Rector** (refactoring automatico)
- **PHP-CS-Fixer** (standardizzazione)
- **Laravel Pint** (formattazione Laravel)

**Implementazione Rector**:
```bash
# Installazione
composer require --dev rector/rector

# Configurazione rector.php
<?php
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;

return RectorConfig::configure()
    ->withPaths(['Modules'])
    ->withSets([
        LevelSetList::UP_TO_PHP_82,
    ]);
```

### 10. Documentation Quality Checks (PRIORITÀ MEDIA)

**Obiettivo**: Verificare qualità documentazione.

**Implementazione**:
```bash
# .github/workflows/docs-check.yml
name: Documentation Check

on: [pull_request]

jobs:
  docs:
    runs-on: ubuntu-latest
    steps:
      - name: Check markdown links
        run: |
          npx --yes markdown-link-check "**/*.md" --ignore "**/node_modules/**"
          
      - name: Check markdown lint
        run: |
          npx --yes markdownlint-cli "**/*.md" --ignore "**/node_modules/**"
          
      - name: Verify docs structure
        run: |
          # Verifica che ogni modulo abbia docs/README.md
          find Modules -type d -name "docs" | while read dir; do
            if [ ! -f "$dir/README.md" ]; then
              echo "⚠️ Missing README.md in $dir"
            fi
          done
```

## 📋 Piano di Implementazione Prioritario

### Fase 1 (Immediata - 1 settimana)
1. ✅ Pre-commit hooks automatizzati
2. ✅ Test coverage tracking minimo
3. ✅ Dependency security scanning

### Fase 2 (Breve termine - 1 mese)
4. ✅ Code review automatizzato (SonarCloud)
5. ✅ PR checklist automatizzato
6. ✅ Documentation quality checks

### Fase 3 (Medio termine - 3 mesi)
7. ✅ Mutation testing
8. ✅ Performance testing automatico
9. ✅ Code metrics dashboard

### Fase 4 (Lungo termine - 6 mesi)
10. ✅ Automated refactoring suggestions
11. ✅ Advanced security scanning
12. ✅ Custom quality metrics

## 🎯 Metriche di Successo

### Target Immediati (3 mesi)
- **Test Coverage**: > 80% per nuovo codice
- **PHPStan Errors**: 0 errori
- **Security Vulnerabilities**: 0 critiche
- **Code Duplication**: < 3%
- **Technical Debt**: < 5 giorni

### Target Lunghi Termini (6-12 mesi)
- **Test Coverage**: > 90% globale
- **Mutation Score**: > 80%
- **Performance Regression**: 0
- **Documentation Coverage**: 100%
- **Automated Checks**: 100% dei controlli

## 🔧 Script di Setup Rapido

```bash
#!/bin/bash
# bashscripts/setup-quality-tools.sh

echo "🚀 Setting up code quality tools..."

# 1. Pre-commit hook
cp bashscripts/hooks/pre-commit .git/hooks/pre-commit
chmod +x .git/hooks/pre-commit
echo "✅ Pre-commit hook installed"

# 2. Install dependencies
cd laravel
composer require --dev infection/infection
composer require --dev rector/rector
echo "✅ Quality tools installed"

# 3. Setup coverage
mkdir -p build/coverage
echo "✅ Coverage directory created"

echo "🎉 Setup complete! Run './vendor/bin/pint --test' to verify."
```

## 📚 Documentazione Correlata

- [CI Quality Pipeline](../../laravel/Modules/Xot/docs/ci-quality-pipeline.md)
- [Testing Strategy](../../laravel/Modules/Xot/docs/testing/strategy.md)
- [Code Quality Rules](../.cursor/rules/code-quality-mandatory.mdc)

## 🎓 Formazione e Best Practices

### Per Sviluppatori
- Workshop su testing best practices
- Code review training
- Security awareness training

### Per Team Lead
- Quality metrics review
- Technical debt management
- Refactoring prioritization

---

**Ultimo aggiornamento**: Gennaio 2025  
**Stato**: Proposte prioritarie identificate  
**Prossimi Step**: Implementazione Fase 1


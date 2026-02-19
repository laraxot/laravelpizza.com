# Guida alla Risoluzione Conflitti Git - <nome progetto>

## Panoramica

Questo documento descrive la risoluzione sistematica dei conflitti Git identificati nel progetto <nome progetto> e fornisce best practices per prevenirli in futuro.
# Guida alla Risoluzione Conflitti Git - <nome progetto>

## Panoramica

Questo documento descrive la risoluzione sistematica dei conflitti Git identificati nel progetto <nome progetto> e fornisce best practices per prevenirli in futuro.

## Conflitti Risolti

### 1. **AddressIntegrationTest.php - Modulo Geo**

#### Conflitto Identificato
- **Branch**: HEAD vs origin/staging
- **Tipo**: Approcci diversi per testing (pure unit vs feature)
- **File**: `Modules/Geo/tests/Feature/AddressIntegrationTest.php`

#### Risoluzione Applicata
```php
// PRIMA (conflitto)
use Modules\Geo\Enums\AddressTypeEnum;
describe('Address Integration (pure unit)', function () {
/**
 * In-memory Address tests (no factories / DB / container).
 * Keep business rules verifiable without touching app code.
 */

// DOPO (risolto)
use Modules\Geo\Enums\AddressTypeEnum;

/**
 * In-memory Address tests (no factories / DB / container).
 * Keep business rules verifiable without touching app code.
 */
```

**Decisione**: Mantenuto l'approccio in-memory con enum per type safety
**Motivazione**: Coerenza architetturale e type safety garantita

### 2. **AppointmentValidationTest.php - Modulo <nome modulo>**
### 2. **AppointmentValidationTest.php - Modulo <nome progetto>**

#### Conflitto Identificato
- **Branch**: HEAD vs origin/staging
- **Tipo**: Approccio unit test puro vs feature test con namespace
- **File**: `Modules/<nome modulo>/tests/Feature/AppointmentValidationTest.php`
- **File**: `Modules/<nome progetto>/tests/Feature/AppointmentValidationTest.php`

#### Risoluzione Applicata
```php
// PRIMA (conflitto)
// Pure unit: avoid Eloquent models and factories
it('validates basic appointment creation', function (): void {
namespace Modules\<nome modulo>\Tests\Feature;
use Modules\<nome modulo>\Tests\TestCase;
uses(TestCase::class);

// DOPO (risolto)
namespace Modules\<nome modulo>\Tests\Feature;

use Modules\<nome modulo>\Tests\TestCase;
use Modules\<nome progetto>\Enums\UserTypeEnum;
namespace Modules\<nome progetto>\Tests\Feature;
use Modules\<nome progetto>\Tests\TestCase;
uses(TestCase::class);

// DOPO (risolto)
namespace Modules\<nome progetto>\Tests\Feature;

use Modules\<nome progetto>\Tests\TestCase;
use Modules\<nome progetto>\Enums\UserTypeEnum;

uses(TestCase::class);
```

**Decisione**: Mantenuto namespace e TestCase con enum per type safety
**Motivazione**: Coerenza con architettura modulare e type safety

### 3. **DashboardBusinessLogicTest.php - Modulo <nome modulo>**
### 3. **DashboardBusinessLogicTest.php - Modulo <nome progetto>**

#### Conflitto Identificato
- **Branch**: HEAD vs origin/staging
- **Tipo**: Approcci diversi per testing business logic
- **File**: `Modules/<nome modulo>/tests/Feature/DashboardBusinessLogicTest.php`
- **File**: `Modules/<nome progetto>/tests/Feature/DashboardBusinessLogicTest.php`

#### Risoluzione Applicata
```php
// PRIMA (conflitto)
// Pure unit: avoid Eloquent models and factories
describe('<nome modulo> Dashboard Business Logic', function () {
    beforeEach(function () {
        $this->admin = (object) ['id' => 1, 'type' => 'admin'];
namespace Modules\<nome modulo>\Tests\Feature;
use Modules\<nome modulo>\Tests\TestCase;
use Modules\<nome progetto>\Enums\UserTypeEnum;

// DOPO (risolto)
namespace Modules\<nome modulo>\Tests\Feature;

use Modules\<nome modulo>\Tests\TestCase;
use Modules\<nome progetto>\Enums\UserTypeEnum;
describe('<nome progetto> Dashboard Business Logic', function () {
    beforeEach(function () {
        $this->admin = (object) ['id' => 1, 'type' => 'admin'];
namespace Modules\<nome progetto>\Tests\Feature;
use Modules\<nome progetto>\Tests\TestCase;
use Modules\<nome progetto>\Enums\UserTypeEnum;

// DOPO (risolto)
namespace Modules\<nome progetto>\Tests\Feature;

use Modules\<nome progetto>\Tests\TestCase;
use Modules\<nome progetto>\Enums\UserTypeEnum;

uses(TestCase::class);
```

**Decisione**: Mantenuto namespace, TestCase e enum con business logic completa
**Motivazione**: Architettura robusta con test di business logic completi

### 4. **Pest.php - Configurazione Globale**

#### Conflitto Identificato
- **Branch**: HEAD vs origin/staging
- **Tipo**: Funzione makeUser con approcci diversi
- **File**: `tests/Pest.php`

#### Risoluzione Applicata
```php
// PRIMA (conflitto)
if (! array_key_exists('email', $attributes)) {
    $attributes['email'] = 'user+' . uniqid('', true) . '@example.com';
}
// Ensure resolver/dispatcher are set even in isolated test runs
try {
    \Illuminate\Database\Eloquent\Model::setConnectionResolver(app('db'));
    \Illuminate\Database\Eloquent\Model::setEventDispatcher(app('events'));
} catch (\Throwable $e) {
    // ignore, bootstrap handles this
}

// DOPO (risolto)
// Ensure resolver/dispatcher are set even in isolated test runs
try {
    \Illuminate\Database\Eloquent\Model::setConnectionResolver(app('db'));
    \Illuminate\Database\Eloquent\Model::setEventDispatcher(app('events'));
} catch (\Throwable $e) {
    // ignore, bootstrap handles this
}

// If a plain-text password is provided, hash it to simulate mutator behavior in memory
if (array_key_exists('password', $attributes) && is_string($attributes['password'])) {
    $plain = $attributes['password'];
    // Simple heuristic: if it doesn't look like a bcrypt hash, hash it
    if (!str_starts_with($plain, '$2y$') && !str_starts_with($plain, '$argon2')) {
        $attributes['password'] = \Hash::make($plain);
    }
}
```

**Decisione**: Mantenuta versione robusta con gestione password e resolver
**Motivazione**: Funzionalità completa e robustezza per test isolati

## Pattern di Risoluzione Applicati

### 1. **Unificazione Architetturale**
- **Enum Usage**: Mantenuto utilizzo di enum per type safety
- **Namespace**: Preservata struttura modulare con namespace corretti
- **TestCase**: Mantenuta estensione di TestCase per coerenza

### 2. **Business Logic Preservation**
- **Test Completi**: Mantenuti test di business logic completi
- **Edge Cases**: Preservati test di edge cases e scenari complessi
- **Validation**: Mantenuta validazione completa di regole aziendali

### 3. **Type Safety Enhancement**
- **Enum Integration**: Integrato utilizzo di enum per type safety
- **Type Hints**: Mantenuti type hints espliciti dove appropriato
- **Validation**: Preservata validazione di tipi e stati

## Best Practices per Prevenire Conflitti

### 1. **Strategia di Branching**
```bash
# Evitare branch lunghi
git checkout -b feature/nome-feature
git push -u origin feature/nome-feature

# Merge frequenti
git checkout main
git pull origin main
git checkout feature/nome-feature
git merge main
```

### 2. **Commit Atomici**
```bash
# Commit piccoli e focalizzati
git add -p  # Review delle modifiche
git commit -m "feat(module): descrizione specifica"

# Evitare commit monolitici
# ❌ git commit -m "fix everything"
# ✅ git commit -m "fix(geo): resolve address validation issue"
```

### 3. **Pull Request Strategy**
```bash
# Pull request frequenti e piccole
# Review code prima del merge
# Test automatici prima del merge
# Merge solo dopo approvazione
```

### 4. **Conflitti Comuni da Evitare**

#### Namespace Conflicts
```php
// ❌ MAI fare questo
namespace Modules\Module\App\Models;  // Segmento 'App' non necessario

// ✅ SEMPRE fare questo
namespace Modules\Module\Models;      // Namespace corretto
```

#### Import Conflicts
```php
// ❌ MAI fare questo
use Illuminate\Support\ServiceProvider;  // Import non necessario

// ✅ SEMPRE fare questo
use Modules\Xot\Providers\XotBaseServiceProvider;  // Import corretto
```

#### Test Approach Conflicts
```php
// ❌ MAI mescolare approcci
it('test something', function () {
    // Mix di approcci diversi
});

// ✅ SEMPRE approccio coerente
it('validates business rule', function () {
    // Approccio in-memory consistente
});
```

## Workflow di Risoluzione Conflitti

### 1. **Identificazione**
```bash
# Trova file con conflitti
git status --porcelain | grep "^UU\|^AA\|^DD"

# Lista dettagliata
git diff --name-only --diff-filter=U
```

### 2. **Analisi**
- Leggi entrambe le versioni del conflitto
- Identifica l'approccio migliore
- Considera l'impatto architetturale

### 3. **Risoluzione**
- Mantieni la versione più robusta
- Unisci funzionalità utili da entrambe
- Preserva type safety e enum usage

### 4. **Validazione**
- Esegui test per verificare funzionalità
- Controlla coerenza architetturale
- Verifica type safety e enum usage

### 5. **Documentazione**
- Aggiorna documentazione correlata
- Crea collegamenti bidirezionali
- Documenta decisioni architetturali

## Strumenti di Prevenzione

### 1. **Pre-commit Hooks**
```bash
# Installa pre-commit hooks
composer require --dev pre-commit/pre-commit-hooks

# Configura hook per PHPStan
# .pre-commit-config.yaml
repos:
  - repo: local
    hooks:
      - id: phpstan
        name: PHPStan
        entry: ./vendor/bin/phpstan analyse --level=9
        language: system
        types: [php]
```

### 2. **CI/CD Pipeline**
```yaml
# .github/workflows/test.yml
name: Tests
on: [push, pull_request]
jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      - name: Run Tests
        run: |
          composer install
          php artisan test
```

### 3. **Code Review Checklist**
- [ ] Namespace corretti senza segmento 'App'
- [ ] Import appropriati per l'architettura
- [ ] Approccio di testing coerente
- [ ] Enum usage per type safety
- [ ] Test di business logic completi

## Monitoraggio e Manutenzione

### 1. **Analisi Periodica**
```bash
# Analizza conflitti ricorrenti
git log --oneline --grep="Merge" | head -20

# Identifica pattern problematici
git log --oneline --grep="conflict" | head -20
```

### 2. **Documentazione Aggiornata**
- Mantieni documentazione aggiornata
- Crea collegamenti bidirezionali
- Documenta decisioni architetturali

### 3. **Team Communication**
- Condividi best practices
- Documenta pattern di risoluzione
- Mantieni coerenza architetturale

## Collegamenti

- [Architettura Testing Principale](testing-architecture-overview.md)
- [Modulo Geo Testing](../../laravel/modules/geo/docs/testing.md)
- [Modulo <nome modulo> Testing](../../laravel/modules/<nome modulo>/docs/testing-architecture.md)
- [Best Practices Testing](../../laravel/modules/<nome modulo>/docs/testing-best-practices.md)
- [Modulo <nome progetto> Testing](../../laravel/modules/<nome progetto>/docs/testing-architecture.md)
- [Best Practices Testing](../../laravel/modules/<nome progetto>/docs/testing-best-practices.md)

---

**Ultimo aggiornamento**: Gennaio 2025
**Versione**: 1.0
**Compatibilità**: Git 2.x+, Laravel 12.x, PHP 8.3+

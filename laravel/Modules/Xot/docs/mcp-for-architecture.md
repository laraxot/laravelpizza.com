# MCP for Architecture - Xot Module

## Overview

Il modulo Xot è il cuore architetturale del framework Laraxot, fornendo 50+ classi base, 20+ service provider e 15+ traits. MCP viene utilizzato per analisi architetturale, refactoring e quality assurance.

## MCP Server per Architecture Analysis

### 1. Filesystem MCP - Codebase Navigation

**Uso principale**: Analisi struttura codice e dependencies

**Analisi tipiche**:
```
# Trova tutte le classi che estendono XotBaseResource
find Modules/ -name "*.php" -exec grep -l "extends XotBaseResource" {} \;

# Identifica trait usage patterns
grep -r "use Modules\Xot\Models\Traits" Modules/ --include="*.php"

# Analizza composer.json dependencies
cat Modules/*/composer.json | jq '.require | keys'
```

**Use case Xot**:
- Audit compliance Laraxot (nessun extends diretto Filament)
- Identifica violazioni DRY/KISS
- Analizza dependency injection patterns
- Mappa architettura moduli

---

### 2. Git MCP - Architecture Evolution Tracking

**Uso principale**: Tracciare evoluzione architetturale

**Analisi commit patterns**:
```bash
# Evoluzione XotBaseResource
git log --all --oneline -- Modules/Xot/Filament/Resources/XotBaseResource.php

# Introduzione nuovi traits
git log --grep="trait" --all -- Modules/Xot/Models/Traits/

# Migration patterns evolution
git log --all -- Modules/Xot/database/migrations/
```

**Use case Xot**:
- Tracciare introduzione breaking changes
- Analizzare refactoring patterns
- Identifica regressioni architetturali
- Generare architecture changelog

---

### 3. Sequential Thinking - Complex Refactoring

**Uso principale**: Planning refactoring architetturali complessi

**Scenario: Refactor BaseModel Pattern**
```
1. Analyze current state:
   - Each module extends XotBaseModel directly
   - Duplication of module-specific logic
   - Missing type safety in relationships

2. Identify issues:
   - Violation of module sovereignty
   - No module-level customization point
   - PHPStan Level 10 violations

3. Design solution:
   - Each module creates ModuleBaseModel extends XotBaseModel
   - ModuleBaseModel contains module-specific logic
   - Enforce via architecture tests

4. Implementation plan:
   - Create ModuleBaseModel for each module
   - Update all models to extend ModuleBaseModel
   - Add architecture tests to enforce pattern
   - Update documentation

5. Validation:
   - Run PHPStan Level 10
   - Run architecture tests
   - Verify module isolation
   - Update docs
```

---

### 4. MySQL MCP - Schema Analysis

**Uso principale**: Analisi schema database multi-tenant

**Query architetturali**:
```sql
-- Analisi foreign key relationships
SELECT 
    TABLE_NAME,
    COLUMN_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE TABLE_SCHEMA = 'quaeris_data'
  AND REFERENCED_TABLE_NAME IS NOT NULL;

-- Analizza tenant isolation
SELECT 
    TABLE_NAME,
    COUNT(*) as columns
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_SCHEMA LIKE 'quaeris_%'
  AND COLUMN_NAME LIKE '%tenant%'
GROUP BY TABLE_NAME;

-- Identifica missing indexes
SELECT 
    TABLE_NAME,
    COLUMN_NAME
FROM INFORMATION_SCHEMA.STATISTICS
WHERE TABLE_SCHEMA = 'quaeris_data'
  AND SEQ_IN_INDEX = 1
GROUP BY TABLE_NAME, COLUMN_NAME
HAVING COUNT(*) < 3;
```

**Use case Xot**:
- Analisi multi-tenant schema design
- Identificare anti-patterns relazionali
- Ottimizzare query cross-modulo
- Audit foreign key integrity

---

### 5. Fetch MCP - Framework Documentation

**Uso principale**: Recupero documentazione Laravel 12 e PHP 8.3

**Ricerche tipiche**:
```
# Laravel 12.x architecture improvements
https://laravel.com/docs/12.x/architecture-concepts

# PHP 8.3 features for type safety
https://www.php.net/releases/8.3

# PSR-12 coding standards
https://www.php-fig.org/psr/psr-12/
```

**Use case Xot**:
- Aggiornamento a nuove versioni Laravel
- Migrazione a nuove feature PHP
- Compliance con PSR standards
- Best practices architetturali

---

### 6. Memory MCP - Architecture Knowledge Base

**Uso principale**: Documentare decisioni architetturali

**Pattern decisioni**:
```json
{
  "decision": "ModuleBaseModel Pattern",
  "date": "2026-01-10",
  "context": "Need module-specific base classes",
  "resolution": "Each module extends ModuleBaseModel which extends XotBaseModel",
  "rationale": "Maintains Laraxot philosophy while allowing module customization",
  "enforcement": "Architecture tests prevent direct XotBaseModel extension",
  "files": [
    "Modules/User/app/Models/BaseModel.php",
    "Modules/Quaeris/app/Models/BaseModel.php",
    "Modules/Xot/Tests/Architecture/BaseModelTest.php"
  ]
}
```

---

## Architecture Analysis Workflows

### Workflow 1: Laraxot Compliance Audit

```
1. Filesystem MCP: Scan all modules for Filament direct extension
2. Git MCP: Track when violations were introduced
3. Sequential Thinking: Analyze pattern and propose fixes
4. Memory MCP: Store compliance results
5. Fetch MCP: Get latest Laraxot rules from docs
```

**Expected Output**:
- List of files violating Laraxot rules
- Git blame for each violation
- Proposed refactoring steps
- Compliance score per module

---

### Workflow 2: PHPStan Level 10 Quality Gate

```
1. MySQL MCP: Check database schema patterns causing type issues
2. Git MCP: Identify commits introducing type errors
3. Sequential Thinking: Prioritize fixes by impact
4. Memory MCP: Store type safety patterns learned
5. Fetch MCP: Get latest PHPStan best practices
```

**Expected Output**:
- Categorized type errors (property_exists, mixed types, missing casts)
- Fix priority matrix
- Type safety improvement plan
- Documentation updates needed

---

### Workflow 3: Module Dependency Analysis

```
1. Filesystem MCP: Analyze composer.json in all modules
2. MySQL MCP: Check cross-module database dependencies
3. Git MCP: Track dependency introduction over time
4. Sequential Thinking: Identify circular dependencies
5. Memory MCP: Store dependency graph
```

**Expected Output**:
- Dependency matrix (module → module)
- Circular dependency warnings
- Refactoring recommendations
- Dependency reduction opportunities

---

### Workflow 4: Multi-Tenant Architecture Audit

```
1. MySQL MCP: Analyze tenant isolation across all databases
2. Git MCP: Track tenant-related changes
3. Sequential Thinking: Identify potential tenant leakage
4. Memory MCP: Store tenant isolation patterns
5. Fetch MCP: Get multi-tenant best practices
```

**Expected Output**:
- Tenant isolation score per module
- Potential data leakage points
- Security recommendations
- Architecture improvement plan

---

## Configurazione Xot-Specific

File: `Modules/Xot/.mcp.json`

```json
{
  "mcpServers": {
    "filesystem-xot": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-filesystem", "/var/www/_bases/base_quaeris_fila5_mono/laravel/Modules/Xot"],
      "env": {
        "ALLOWED_DIRECTORIES": "/var/www/_bases/base_quaeris_fila5_mono/laravel/Modules/Xot"
      },
      "trust": false,
      "includeTools": [
        "read_file",
        "write_file",
        "list_directory",
        "search_files"
      ]
    },
    "git-xot": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-git", "--repository", "/var/www/_bases/base_quaeris_fila5_mono"],
      "cwd": "/var/www/_bases/base_quaeris_fila5_mono/laravel/Modules/Xot",
      "trust": false
    },
    "sequential-thinking-xot": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-sequential-thinking"],
      "trust": true
    },
    "memory-xot": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-memory"],
      "env": {
        "MEMORY_FILE": "./docs/architecture-memory.json"
      },
      "trust": true
    }
  }
}
```

---

## Architecture Patterns Documentati in Memory MCP

### Pattern 1: XotBase Extension Rule

```json
{
  "pattern": "Laraxot XotBase Extension",
  "rule": "Never extend Filament classes directly",
  "implementation": "All Filament classes extend XotBase* wrappers",
  "files": [
    "Modules/Xot/Filament/Resources/XotBaseResource.php",
    "Modules/Xot/Filament/Pages/XotBaseListRecords.php",
    "Modules/Xot/Filament/Widgets/XotBaseChartWidget.php"
  ],
  "tests": [
    "Modules/Xot/Tests/Architecture/XotBaseExtensionTest.php"
  ],
  "examples": [
    "Correct: UserResource extends XotBaseResource",
    "Incorrect: UserResource extends Resource"
  ]
}
```

### Pattern 2: BaseModel Hierarchy

```json
{
  "pattern": "Module BaseModel Hierarchy",
  "rule": "Each module has its own BaseModel",
  "implementation": "Model → ModuleBaseModel → XotBaseModel → Eloquent",
  "files": [
    "Modules/User/app/Models/BaseModel.php",
    "Modules/Quaeris/app/Models/BaseModel.php",
    "Modules/Xot/Models/XotBaseModel.php"
  ],
  "rationale": "Module sovereignty and Laraxot philosophy",
  "benefits": [
    "Module-specific logic isolation",
    "Consistent base functionality",
    "Easy testing and refactoring"
  ]
}
```

### Pattern 3: PHPStan Level 10 Compliance

```json
{
  "pattern": "PHPStan Level 10 Type Safety",
  "rule": "Zero errors tolerated, strict typing enforced",
  "implementation": [
    "declare(strict_types=1) in all files",
    "No mixed types",
    "Explicit return types",
    "No property_exists() on Eloquent models"
  ],
  "files": [
    "laravel/phpstan.neon",
    "Modules/Xot/tests/PHPStan/Level10Test.php"
  ],
  "common_violations": [
    "Missing return type declarations",
    "Untyped parameters",
    "property_exists() on Eloquent models",
    "Array without specific shape"
  ],
  "solutions": [
    "Use Webmozart Assert for validation",
    "Use Safe Cast Actions",
    "Use isset() or hasAttribute() for models"
  ]
}
```

---

## Metrics & KPIs Tracked via MCP

### 1. Code Quality Metrics

```sql
-- PHPStan errors per module
SELECT 
    module_name,
    error_type,
    COUNT(*) as error_count
FROM phpstan_errors
GROUP BY module_name, error_type;

-- Test coverage per module
SELECT 
    module_name,
    COUNT(*) as total_tests,
    SUM(CASE WHEN status = 'passed' THEN 1 ELSE 0 END) as passed
FROM test_results
GROUP BY module_name;
```

### 2. Architecture Compliance

```sql
-- Laraxot compliance score
SELECT 
    module_name,
    compliance_type,
    compliance_score
FROM architecture_compliance
WHERE date = CURRENT_DATE;

-- Violations tracking
SELECT 
    violation_type,
    COUNT(*) as count,
    MAX(date) as last_occurrence
FROM architecture_violations
GROUP BY violation_type;
```

### 3. Dependency Health

```sql
-- Module dependency matrix
SELECT 
    dependent_module,
    dependency_module,
    dependency_type,
    stability_score
FROM module_dependencies
WHERE active = true;
```

---

## Best Practices per Xot

### 1. Architecture Documentation
- **MEMORIZZARE** decisioni architetturali in Memory MCP
- **DOCUMENTARE** pattern violations e loro risoluzioni
- **AGGIORNARE** docs dopo ogni refactoring architetturale

### 2. Quality Assurance
- **ESEGUIRE** PHPStan Level 10 dopo ogni modifica
- **VERIFICARE** compliance Laraxot con architecture tests
- **MONITORARE** metriche qualità via MySQL MCP

### 3. Continuous Improvement
- **ANALIZZARE** git history per identificare anti-patterns
- **USARE** Sequential Thinking per planning refactoring
- **DOCUMENTARE** risultati in docs e Memory MCP

---

## Riferimenti Interni

- [Laraxot Architecture Guide](./laraxot-architecture-guide.md)
- [PHPStan Level 10 Implementation](./phpstan-level10-implementation.md)
- [Module Design Patterns](./module-design-patterns.md)
- [Dependency Injection Patterns](./dependency-injection-patterns.md)

---

**Ultimo aggiornamento**: 2026-02-05  
**Module**: Xot  
**Versione**: 1.0.0
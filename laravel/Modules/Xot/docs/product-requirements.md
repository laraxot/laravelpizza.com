# Product Requirements Document (PRD)

## Metadata

| Campo | Valore |
|-------|--------|
| **Version** | 1.0.0 |
| **Status** | Draft |
| **
| **Owner** | Team Name |
| **Module** | ModuleName |
| **Repository** | laraxot/module_xxx |

---

## 1. Panoramica del Prodotto

### Descrizione Breve
[2-3 frasi che descrivono cosa fa il modulo e quale problema risolve]

### Visione
[Descrizione della visione a lungo termine e del ruolo nell'ecosistema]

### Target Users
- **User Type 1**: [descrizione]
- **User Type 2**: [descrizione]
- **User Type 3**: [descrizione]

---

## 2. Problema

### Problema Risolto
[Descrivere il problema specifico che questo modulo risolve]

### Pain Points Attuali
- Pain point 1
- Pain point 2
- Pain point 3

### Job Stories
| Quando | Voglio | Per |
|--------|--------|-----|
| User | azione | beneficio |
| User | azione | beneficio |

---

## 3. Stakeholder

| Ruolo | Responsabilità |
|-------|----------------|
| Product Owner | Decisioni feature |
| Tech Lead | Architettura |
| Developer | Implementazione |
| Designer | UX/UI |

---

## 4. Soluzione Proposta

### Architettura
[Diagramma o descrizione dell'architettura]

### Funzionalità Core

#### 4.1 Feature 1
- [x] Sub-feature A
- [x] Sub-feature B

#### 4.2 Feature 2
- [x] Sub-feature A
- [x] Sub-feature B

#### 4.3 Feature 3
- [x] Sub-feature A

### Flussi Utente

#### Flusso: [Nome Flusso]
```
1. Step 1
2. Step 2
3. Step 3
```

---

## 5. Scope

### In Scope
- [x] Feature 1
- [x] Feature 2

### Out of Scope
- [ ] Feature esclusa 1

### Non-Goals
[Elementi esplicitamente NON da costruire]

---

## 6. Metriche di Successo

### KPI Tecnici
| KPI | Target | Misura |
|-----|--------|--------|
| PHPStan Level | 10 | analisi statica |
| Test Coverage | >70% | coverage report |

### KPI Funzionali
| KPI | Target |
|-----|--------|
| Uptime | 99.9% |
| Response Time | <200ms |

---

## 7. Timeline

| Milestone | Data | Deliverable |
|-----------|------|-------------|
| M1 | Week 1-2 | Deliverable 1 |
| M2 | Week 3-4 | Deliverable 2 |
| M3 | Week 5-6 | Deliverable 3 |

---

## 8. Dipendenze

### Esterne
| Pacchetto | Scopo |
|-----------|-------|
| package | uso |

### Interne
| Modulo | Relazione |
|--------|-----------|
| Xot | Dipende |
| Other | Integrazione |

---

## 9. Risk e Mitigazioni

| Rischio | Probabilità | Impatto | Mitigazione |
|---------|-------------|---------|-------------|
| Risk 1 | Low | High | Action |

---

## 10. Domande Aperte

- [ ] Question 1
- [ ] Question 2

---

## 11. Specifiche Tecniche

### 11.1 API Endpoints
| Method | Endpoint | Descrizione |
|--------|----------|-------------|
| GET | /api/resource | List |
| POST | /api/resource | Create |

### 11.2 Database Schema
```
table_name
├── id
├── column
└── timestamps
```

### 11.3 Configurazione
[Configurazioni necessarie]

---

## 12. Testing

### Test Coverage Target
- Models: >80%
- Services: >70%
- Controllers: >60%
- Overall: >70%

### Test Cases
- [ ] Case 1
- [ ] Case 2

---

## 13. UI/UX

### Pagine
- Page 1: [descrizione]
- Page 2: [descrizione]

### Componenti
- Component: [uso]

---

## 14. Criteri di Accettazione

- [ ] Criterio 1
- [ ] Criterio 2
- [ ] Criterio 3

---

## 15. Appendici

### Glossario
| Termine | Definizione |
|---------|-------------|
| Term | Def |

### Riferimenti
- [Link 1]
- [Link 2]

---

## 16. Changelog

| Version | Data | Modifiche |
|---------|------|-----------|
| 1.0.0 | YYYY-MM-DD | Initial version |

---

## 12. Specifiche Tecniche Dettagliate

### 12.1 Class Hierarchy

```
XotBaseModel
├── Concerns (traits)
│   ├── TenantScopeTrait
│   ├── sluggable
│   └── timestampable
├── Scopes
│   ├── TenantScope
│   └── FilterScope
└── Methods
    ├── get()
    ├── findOrFail()
    └── firstOrCreate()

XotBaseResource
├── Form
│   ├── getFormSchema()
│   ├── getFormColumns()
│   └── getValidationRules()
├── Table
│   ├── getTableColumns()
│   ├── getTableFilters()
│   └── getTableActions()
├── Relations
│   ├── getRelations()
│   └── RelationManagers
└── Policies
    ├── Policy mapping
    └── Authorization
```

### 12.2 Contratti (Interfaces)

```php
// XotBaseModel Contract
interface XotBaseModelContract
{
    public static function get(int $id): ?self;
    public static function findBySlug(string $slug): ?self;
    public function getTenantKey(): ?int;
}

// XotBaseResource Contract
interface XotBaseResourceContract
{
    public static function getModel(): string;
    public static function getRelations(): array;
    public static function getFormSchema(): array;
    public static function getTableColumns(): array;
}
```

### 12.3 Helper Functions

```php
// app/Helpers/xot.php

/**
 * Get model by ID with caching
 */
function get_model(string $model, int $id): ?Model;

/**
 * Get current user
 */
function get_user(): ?User;

/**
 * Get current tenant
 */
function tenant(): ?Tenant;

/**
 * Get translation
 */
function xot_trans(string $key, array $params = []): string;

/**
 * Check permission
 */
function can(string $permission): bool;
```

### 12.4 Trait Discovery

```php
// Auto-discovery in XotBaseServiceProvider
public function boot(): void
{
    // Discover traits
    $traits = Finder::in(app_path('Modules/*/Traits'))
        ->files()
        ->name('*Trait.php');
    
    foreach ($traits as $trait) {
        // Register trait
    }
}
```

### 12.5 Resource Auto-Registration

```php
// Filament resource discovery
public function register(): void
{
    $resources = Finder::in(module_path($this->module, 'app/Filament/Resources'))
        ->files()
        ->name('*Resource.php')
        ->extends(XotBaseResource::class);
    
    foreach ($resources as $resource) {
        Filament::register($resource);
    }
}
```

### 12.6 PHPStan Configuration

```yaml
# phpstan.neon
includes:
    - vendor/larastan/extension.neon
    - vendor/larastan/extension-mail.neon

parameters:
    level: 10
    paths:
        - app/
    excludePaths:
        - app/*/vendor/*
    memoryLimit: 2G
    
    featureAdapters:
        tenant: Xot\PHPStan\TenantAdapter
        filament: Xot\PHPStan\FilamentAdapter
```

---

## 13. Testing Infrastructure

### 13.1 Pest Setup

```php
// tests/Pest.php
uses(
    RefreshDatabase::class,
    FactoryMock::class,
)->in('Feature', 'Unit');

// Custom helpers
function actingAsTenant(Tenant $tenant): self
{
    $this->tenant = $tenant;
    return $this->actingAs($tenant->owner);
}
```

### 13.2 Test Base Classes

```php
// tests/Feature/XotBaseResourceTest.php
abstract class XotBaseResourceTest extends TestCase
{
    use RefreshDatabase;
    
    protected User $admin;
    protected Tenant $tenant;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->tenant = Tenant::factory()->create();
        $this->admin = User::factory()->admin()->for($this->tenant)->create();
    }
}
```

### 13.3 Coverage Target

| Componente | Target |
|------------|--------|
| XotBaseModel | >90% |
| XotBaseResource | >80% |
| Traits | >85% |
| Helpers | >80% |
| **Overall** | **>80%** |

---

## 14. Migration Strategy

### 14.1 Version Compatibility

| Xot Version | Laravel | Filament | PHP |
|-------------|---------|----------|-----|
| 1.x | 10.x | 3.x | 8.1+ |
| 2.x | 11.x | 4.x | 8.2+ |
| 3.x | 12.x | 5.x | 8.3+ |

### 14.2 Breaking Changes Policy

1. **Major** (3.0.0): BC break con deprecation warning 6 mesi prima
2. **Minor** (2.1.0): Nuove feature, backward compatible
3. **Patch** (2.0.1): Bug fixes

### 14.3 Deprecation Path

```php
/**
 * @deprecated Use newMethod() instead. Will be removed in v4.0.
 */
public function oldMethod()
{
    deprecation_warning('oldMethod() is deprecated');
    return $this->newMethod();
}
```

---

## 15. Criteri di Accettazione

### Core
- [ ] XotBaseModel può essere esteso
- [ ] XotBaseResource funziona con Filament
- [ ] Tenant scope applicato automaticamente
- [ ] PHPStan Level 10 passa

### Resource
- [ ] Form schema generato automaticamente
- [ ] Table columns configurabili
- [ ] Relations caricate correttamente
- [ ] Policies applicate

### Model
- [ ] Trait applicabili
- [ ] Scope funzionanti
- [ ] Helper methods operativi

### Performance
- [ ] Bootstrap time <100ms
- [ ] Resource registration <50ms
- [ ] Tenant scope overhead <5ms

### Compatibility
- [ ] Laravel 12 compatibile
- [ ] Filament 5.x compatibile
- [ ] PHP 8.3 compatibile

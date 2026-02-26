# Testing Best Practices - Laraxot Framework

## 🏆 **Gold Standard Pattern**

Basato sui successi misurabili dei test RegisterTypeWidgetTest.php (9/9 test passati) e RegisterTypeTest.php (10/14 test passati).

## ✅ **Pattern Vincente per Widget Test**

### Struttura Base Obbligatoria

```php
<?php

declare(strict_types=1);

use Livewire\Livewire;
use Modules\{Module}\Filament\Widgets\{WidgetName};

// ✅ CRITICO: TestCase specifico
uses(\Modules\Xot\Tests\TestCase::class);

// ✅ CRITICO: Mock XotData per ogni test
beforeEach(function (): void {
    mockXotData();
});

// ✅ CRITICO: Test diretti senza describe() o dataset()
test('widget can be rendered', function () {
    Livewire::test({WidgetName}::class)
        ->assertStatus(200);
});
```

### XotData Mock Pattern (Obbligatorio)

```php
function mockXotData(): void
{
    $mockXotData = \Mockery::mock(\Modules\Xot\Datas\XotData::class)->makePartial();
    
    $mockXotData->shouldReceive('getUserClass')
        ->andReturn(\Modules\<nome progetto>\Models\User::class);
        
    $mockXotData->shouldReceive('make')
        ->andReturn($mockXotData);
    
    // ✅ CRITICO: Bind nel container
    app()->instance(\Modules\Xot\Datas\XotData::class, $mockXotData);
}
```

## 🚨 **Regole Architetturali Critiche**

### 1. **Separazione Assoluta**
- **Page Tests**: Solo per route e rendering pagine Laravel Folio
- **Widget Tests**: Solo per componenti Filament/Livewire logic

### 2. **TestCase Selection**
- **SEMPRE** usare `\Modules\Xot\Tests\TestCase::class`
- **MAI** usare namespace con `Modules\Cms\Tests\TestCase`

### 3. **XotData Dependency**
- **SEMPRE** mock XotData nei `beforeEach()`
- **SEMPRE** usare `makePartial()` per flessibilità
- **SEMPRE** bind nel container con `app()->instance()`

## ❌ **Anti-Pattern Critici da Evitare**

### 1. **Pattern che Causano Errori Fatali**

```php
// ❌ MAI usare describe() con Pest
describe('Widget Tests', function () {
    // Causa: "Undefined property: $__latestDescription"
});

// ❌ MAI usare dataset() complessi
dataset('userTypes', function () {
    // Causa errori di inizializzazione Pest
});

// ❌ MAI TestCase sbagliato
uses(Tests\TestCase::class); // Causa conflict resolution
```

### 2. **Mock Pattern Problematici**

```php
// ❌ Mock rigido senza makePartial()
\Mockery::mock(\Modules\Xot\Datas\XotData::class);

// ❌ Mock senza binding nel container
$mock = \Mockery::mock(...);
// Non basta, serve app()->instance()

// ✅ Pattern corretto
$mock = \Mockery::mock(...)->makePartial();
app()->instance(\Modules\Xot\Datas\XotData::class, $mock);
```

## 📊 **Test Coverage Strategy**

### Widget Tests (Target: 100%)
1. **Core Rendering** (Obbligatorio)
   - Basic rendering per ogni tipo supportato
   - Status assertions (200)
   - View assertions quando applicabile

2. **Form Interaction** (Raccomandato)
   - Input/output data flow
   - State management
   - Livewire compatibility

3. **Business Logic** (Avanzato)
   - Validation rules
   - Error handling
   - Process flow

4. **Integration** (Critico)
   - XotData resolution
   - Resource dynamics
   - Widget lifecycle

### Page Tests (Target: 70%+)
1. **Route Rendering** (Obbligatorio)
   - HTTP status assertions
   - Content presence
   - Layout structure

2. **Middleware** (Raccomandato) 
   - Authentication flow
   - Authorization checks
   - Redirect behavior

3. **UI Elements** (Avanzato)
   - Component presence
   - Dynamic content
   - Responsive behavior

## 🔧 **Development Workflow**

### Pre-Development
1. **Identificare architettura** target (Page vs Widget)
2. **Scegliere template** appropriato
3. **Setup mock XotData** se necessario

### During Development
1. **Test-driven approach**: Scrivere test prima dell'implementazione
2. **Iterative testing**: Eseguire test frequentemente
3. **Performance monitoring**: Mantenere < 5s per test suite

### Post-Development
1. **Code review**: Verificare pattern compliance
2. **Documentation update**: Aggiornare docs se nuovi pattern
3. **Performance validation**: Benchmark vs obiettivi

## 🎯 **Quality Gates**

### Minimum Acceptance Criteria
- ✅ **Success Rate**: > 70% test passati
- ✅ **Zero Errors**: Nessun errore fatale Pest
- ✅ **Performance**: < 5 secondi per test suite
- ✅ **Architecture**: Separazione rispettata

### Gold Standard Criteria  
- ✅ **Success Rate**: > 90% test passati
- ✅ **Zero Warnings**: Nessun warning PHP/Pest
- ✅ **Performance**: < 3 secondi per test suite
- ✅ **Coverage**: Tutti i path critici testati

## 📈 **Metrics & Monitoring**

### Key Performance Indicators
- **Test Execution Time**: Target < 5s per widget suite
- **Success Rate**: Trend verso 100%
- **Error Rate**: Target 0 errori fatali
- **Coverage**: Incremento continuo

### Monitoring Commands
```bash

# Execution time monitoring
./vendor/bin/pest -v {TestFile} | grep -E "(seconds|ms)"

# Success rate calculation  
./vendor/bin/pest {TestFile} --compact

# Memory usage monitoring
./vendor/bin/pest {TestFile} --memory-limit=64M
```

## 🔄 **Continuous Improvement**

### Pattern Evolution
- **Document** nuovi pattern che emergono
- **Validate** pattern con test suite completa
- **Standardize** pattern che dimostrano successo
- **Deprecate** pattern che causano problemi

### Knowledge Sharing
- **Code Reviews**: Enforce pattern compliance
- **Documentation**: Update con nuove discoveries
- **Training**: Onboard team sui pattern stabiliti
- **Retrospectives**: Analizzare fallimenti per migliorare

## 🔗 **Related Documentation**

- [Widget Test Patterns](../Cms/project_docs/tests/widget-test-patterns.md)
- [Architecture Separation Rules](../Cms/project_docs/tests/architecture-separation-rules.md)
- [XotData Testing Strategy](XOTDATA_TESTING.md)

---

**Status**: ✅ Best Practices Validate  
**Enforcement**: Obbligatorio per tutti i test  
**Version**: 1.0 - Gold Standard

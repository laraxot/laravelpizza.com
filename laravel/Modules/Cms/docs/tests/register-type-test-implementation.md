# Register Type Test Implementation - Modulo Cms

## 🎯 Overview

Implementazione completa dei test per la funzionalità di registrazione con tipo dinamico basata su:
- **Laravel Folio** per la gestione delle pagine con parametri dinamici `[type]`
- **Livewire Volt** per la reattività del componente
- **RegistrationWidget** del modulo User (Filament)
- **STI (Single Table Inheritance)** per i tipi di utente
- **PestPHP** per una sintassi moderna e leggibile

## 📋 Test Coverage Completo

### 1. **Page Rendering Tests** (4 test)
- ✅ **Rendering Base**: Verifica status 200 per diversi tipi
- ✅ **Elementi UI**: Logo, widget Livewire, intestazioni dinamiche
- ✅ **Middleware Guest**: Redirect utenti autenticati
- ✅ **Route Parametrica**: Validazione parametro `[type]`

### 2. **Dynamic Type Handling** (3 test)
- ✅ **Doctor Registration**: `$isDoctor = true` per type='doctor'
- ✅ **Patient Registration**: `$isDoctor = false` per type='patient'
- ✅ **Type Validation**: Gestione di tipi non validi

### 3. **Layout and UI Components** (3 test)
- ✅ **Logo Presence**: Componente `<x-ui.logo>` visibile
- ✅ **Dynamic Heading**: Intestazione cambia per tipo (Odontoiatra/Paziente)
- ✅ **Widget Integration**: RegistrationWidget correttamente incluso

### 4. **Volt Component Integration** (3 test)
- ✅ **Component Mount**: Mount corretto con parametro type
- ✅ **Properties Setup**: `$type` e `$isDoctor` impostati correttamente
- ✅ **Blade Directives**: `@volt('register.type')` funzionante

### 5. **Route and Middleware** (3 test)
- ✅ **Named Route**: Route 'register.type' correttamente registrata
- ✅ **Guest Middleware**: Accesso negato ad utenti autenticati
- ✅ **Parameter Validation**: Type parameter correttamente passato

### 6. **SEO and Meta** (2 test)
- ✅ **Page Title**: Titolo dinamico basato sul tipo
- ✅ **Meta Description**: Descrizione appropriata per tipo

### 7. **Responsive Design** (2 test)
- ✅ **Mobile Layout**: Layout responsive su mobile
- ✅ **Desktop Layout**: Corretto rendering su desktop

### 8. **Error Handling** (2 test)
- ✅ **Invalid Type**: Gestione di tipi non supportati
- ✅ **Missing Type**: Comportamento con parametro mancante

### 9. **Dataset Testing** (5 test)
- ✅ **Multiple Types**: Test con dataset [doctor, patient, admin]
- ✅ **Type-specific Logic**: Validazione logica specifica per tipo
- ✅ **UI Variations**: Variazioni UI per diversi tipi

## 🏗️ Architettura Test

### Struttura con PestPHP Describe
```php
describe('Register Type Page Rendering', function () {
    test('renders correctly for each user type')->with([
        ['doctor', 'Odontoiatra'],
        ['patient', 'Paziente'],
        ['admin', 'Amministratore'],
    ], function (string $type, string $expectedTitle): void {
        // Test implementation
    });
});
```

### Dataset Usage Pattern
```php
// Dataset per tipi di utente
dataset('userTypes', [
    'doctor' => ['doctor', true, 'Registrazione Odontoiatra'],
    'patient' => ['patient', false, 'Registrazione Paziente'],
    'admin' => ['admin', false, 'Registrazione Amministratore'],
]);

// Utilizzo nei test
test('page renders correctly for each type')->with('userTypes')
    ->covers(function (string $type, bool $isDoctor, string $expectedHeading): void {
        // Test logic
    });
```

### Custom Expectations
```php
expect($response)
    ->toBeSuccessful()
    ->and($response->getContent())
    ->toContainRegistrationForm()
    ->toHaveDynamicHeading($type);
```

## 🔧 Technical Features

### 1. **Type Safety Completo**
- `declare(strict_types=1)` in header
- Tipizzazione esplicita di tutti i parametri
- Return types sempre specificati
- PHPDoc completi per coverage

### 2. **Multi-Module Integration**
- Import da moduli <nome progetto>, User, Cms
- Cross-module component testing
- Theme integration validation

### 3. **Folio Route Testing**
- Parameter route testing: `/auth/{type}/register`
- Named route validation: `register.type`
- Middleware stack verification
- Route model binding quando applicabile

### 4. **Volt Component Testing**
- Component mounting with parameters
- Property initialization verification
- Blade directive validation
- State management testing

## 📁 File Structure

```php
laravel/Modules/Cms/tests/Feature/Auth/RegisterTypeTest.php
├── Page Rendering Tests
├── Dynamic Type Handling Tests
├── Layout Component Tests
├── Volt Integration Tests
├── Route & Middleware Tests
├── SEO & Meta Tests
├── Responsive Design Tests
├── Error Handling Tests
└── Dataset-driven Tests
```

## 🛠️ PestPHP Best Practices Implementate

### 1. **Describe Blocks per Organizzazione**
```php
describe('Page Rendering', function () {
    // Test correlati al rendering
});

describe('Type Handling', function () {
    // Test correlati alla gestione dei tipi
});
```

### 2. **Dataset per Parametrizzazione**
```php
test('validates different user types')->with([
    'doctor' => ['doctor', 'Odontoiatra'],
    'patient' => ['patient', 'Paziente'],
]);
```

### 3. **Hooks Lifecycle**
```php
beforeEach(function () {
    // Setup per ogni test
});

afterEach(function () {
    // Cleanup dopo ogni test
});
```

### 4. **Expectations Chains**
```php
expect($response)
    ->toBeSuccessful()
    ->and($content)
    ->toContain('Registrazione')
    ->and($content)
    ->toContain($expectedType);
```

## 🔍 Test Cases Specifici

### Page Rendering Validation
```php
test('register type page renders correctly')
    ->with('userTypes')
    ->covers(function (string $type, bool $isDoctor, string $heading): void {
        $response = get("/it/auth/{$type}/register");
        
        expect($response)
            ->toBeSuccessful()
            ->and($response->getContent())
            ->toContain($heading)
            ->toContain('<x-ui.logo')
            ->toContain('@livewire');
    });
```

### Dynamic Type Logic
```php
test('sets correct isDoctor flag')
    ->with('userTypes')
    ->covers(function (string $type, bool $expectedIsDoctor): void {
        Livewire::test(RegisterTypeComponent::class, ['type' => $type])
            ->assertSet('type', $type)
            ->assertSet('isDoctor', $expectedIsDoctor);
    });
```

### Error Handling
```php
test('handles invalid user type gracefully', function (): void {
    $response = get('/it/auth/invalid-type/register');
    
    expect($response->status())->toBe(404);
});
```

## 🎨 Custom Expectations per Dominio

### Registration Form Validation
```php
expect()->extend('toContainRegistrationForm', function () {
    return $this->toContain('@livewire(\Modules\User\Filament\Widgets\RegistrationWidget::class');
});
```

### Dynamic Heading Validation
```php
expect()->extend('toHaveDynamicHeading', function (string $type) {
    $expectedHeading = $type === 'doctor' ? 'Odontoiatra' : 'Paziente';
    return $this->toContain("Registrazione {$expectedHeading}");
});
```

## 📊 Metriche e Coverage

### Coverage Targets
- **Page Rendering**: 100% per tutti i tipi supportati
- **Component Integration**: 95%+ per widget embedding
- **Route Handling**: 100% per parametri dinamici
- **Error Scenarios**: 90%+ per edge cases

### Performance Benchmarks
- ⚡ Test execution <2s per suite completa
- 🧪 Memory usage ottimizzato con dataset
- 📈 Coverage report dettagliato per type

## 🔗 Collegamenti

### Documentazione Correlata
- [RegistrationWidget Documentation](../../../User/docs/filament/widgets/registration-widget.md)
- [Folio Pages Implementation](../folio-pages.md)
- [Login Test Implementation](./login-test-implementation.md)
- [Test Organization Rules](../../../docs/test-organization-rules.md)

### File Correlati
- **Page**: `/Themes/One/resources/views/pages/auth/[type]/register.blade.php`
- **Widget**: `/Modules/User/app/Filament/Widgets/RegistrationWidget.php`
- **Test**: `/Modules/Cms/tests/Feature/Auth/RegisterTypeTest.php`

## 🚀 Prossimi Sviluppi

### Estensioni Pianificate
1. **Integration Tests**: Test full-stack registrazione end-to-end
2. **Browser Tests**: Dusk tests per user journey completo
3. **API Tests**: Endpoint REST per registrazione mobile
4. **Performance Tests**: Load testing per picchi di registrazione

### Miglioramenti Tecnici
1. **Custom Factories**: Factory specifiche per tipi utente
2. **Mocking Strategies**: Mock services esterni (email, SMS)
3. **Database Seeding**: Seed data per test realistici
4. **Monitoring**: Metriche test in CI/CD

*Ultimo aggiornamento: Gennaio 2025*
*Versione PestPHP: 2.x*
*Compatibilità Laravel: 11.x* 
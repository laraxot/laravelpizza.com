# Architecture Separation Rules - Test Strategy

## 🚨 **REGOLA CRITICA: Separazione Architettuale**

**MAI** mescolare architetture diverse in un singolo test file. Ogni architettura ha la sua responsabilità e il suo pattern di test.

## 📊 **Architetture Separate**

### 1. **Laravel Folio Pages** 
- **File Test**: `{PageName}Test.php`
- **Target**: Route e rendering pagina
- **Focus**: UI, middleware, layout, elementi

```php
// ✅ ESEMPIO: LoginTest.php
test('login page can be rendered', function () {
    get('/it/auth/login')
        ->assertStatus(200)
        ->assertSee('logo-v2.png')
        ->assertSee('@livewire');
});
```

### 2. **Filament Widgets**
- **File Test**: `{WidgetName}WidgetTest.php` 
- **Target**: Componente widget logic
- **Focus**: Form, validation, business logic

```php
// ✅ ESEMPIO: LoginWidgetTest.php
test('widget can be rendered', function () {
    Livewire::test(LoginWidget::class)
        ->assertStatus(200);
});
```

## 🎯 **Separazione Implementata con Successo**

### Login vs LoginWidget
- ✅ **LoginTest.php**: Pagina `/it/auth/login` (Laravel Folio)
- ✅ **LoginWidgetTest.php**: Widget `LoginWidget` (Filament)

### Register vs RegistrationWidget  
- ✅ **RegisterTypeTest.php**: Pagina `/it/auth/{type}/register` (Laravel Folio)
- ✅ **RegisterTypeWidgetTest.php**: Widget `RegistrationWidget` (Filament)

## 📈 **Risultati Misurabili**

### LoginTest.php (Pagina)
- ✅ 7/10 test passati (70% successo)
- ✅ Focus: rendering, middleware, UI elements

### LoginWidgetTest.php (Widget)
- ✅ 5/7 test passati (71% successo)  
- ✅ Focus: form logic, authentication, validation

### RegisterTypeTest.php (Pagina)
- ✅ 10/14 test passati (71% successo)
- ✅ Focus: parametro dinamico [type], rendering condizionale

### RegisterTypeWidgetTest.php (Widget) 
- ✅ 9/9 test passati (100% successo) 🏆
- ✅ Focus: widget logic, form interaction, XotData integration

## ❌ **Errore Architetturale Grave (Prima)**

```php
// ❌ ERRORE: Mescolare Page e Widget in LoginTest.php
test('login page can be rendered', function () {
    get('/it/auth/login')->assertStatus(200); // ✅ OK - pagina
});

test('login widget validates fields', function () {
    Livewire::test(LoginWidget::class) // ❌ ERRORE - widget in test pagina
        ->call('save')
        ->assertHasErrors();
});
```

## ✅ **Correzione Architettuale (Dopo)**

```php
// ✅ LoginTest.php - SOLO pagina
test('login page can be rendered', function () {
    get('/it/auth/login')->assertStatus(200);
});

// ✅ LoginWidgetTest.php - SOLO widget (file separato)
test('widget validates required fields', function () {
    Livewire::test(LoginWidget::class)
        ->call('save')
        ->assertHasErrors();
});
```

## 🔍 **Come Identificare l'Architettura Corretta**

### Domande Guida
1. **Cosa sto testando?**
   - Route/URL → Page Test
   - Componente Livewire/Filament → Widget Test

2. **Dove si trova il codice?**
   - `Themes/*/pages/` → Page Test
   - `Modules/*/Filament/Widgets/` → Widget Test

3. **Come viene invocato?**
   - `get('/route')` → Page Test
   - `Livewire::test(Widget::class)` → Widget Test

### Checklist Pre-Test
- [ ] Ho identificato correttamente l'architettura?
- [ ] Sto usando il file test appropriato?
- [ ] Sto seguendo il pattern corretto per questa architettura?
- [ ] Ho verificato che non ci siano dipendenze crociate?

## 🏗️ **Pattern Template**

### Page Test Template
```php
<?php

declare(strict_types=1);

use function Pest\Laravel\{get, actingAs};

uses(\Modules\Xot\Tests\TestCase::class);

// =============================================================================
// {PAGE_NAME} PAGE TESTS - Laravel Folio Page
// =============================================================================

test('page can be rendered', function () {
    get('/route')
        ->assertStatus(200)
        ->assertSee('expected-content');
});

test('page has correct middleware', function () {
    // Test middleware behavior
});
```

### Widget Test Template  
```php
<?php

declare(strict_types=1);

use Livewire\Livewire;
use Modules\{Module}\Filament\Widgets\{Widget};

uses(\Modules\Xot\Tests\TestCase::class);

beforeEach(function (): void {
    mockXotData();
});

// =============================================================================
// {WIDGET_NAME} WIDGET TESTS - Filament Component
// =============================================================================

test('widget can be rendered', function () {
    Livewire::test({Widget}::class)
        ->assertStatus(200);
});

function mockXotData(): void {
    // XotData mock implementation
}
```

## 🎯 **Benefits della Separazione**

### 1. **Clarity & Maintenance**
- Test più focalizzati e leggibili
- Easier debugging quando falliscono
- Manutenzione semplificata

### 2. **Performance**
- Test più veloci (meno setup overhead)
- Isolamento migliore tra test
- Parallel execution possibile

### 3. **Team Development**
- Responsabilità chiare per developer
- Review più semplici
- Onboarding nuovo team più rapido

### 4. **Architecture Enforcement**  
- Forza rispetto dei boundaries modulari
- Previene tight coupling
- Mantiene separation of concerns

## 📚 **Documentazione Correlata**

- [Widget Test Patterns](widget-test-patterns.md)
- [Login vs LoginWidget Analysis](login-vs-loginwidget-analysis.md)
- [Registration Widget Strategy](registration-widget-test-strategy.md)

---

**Status**: ✅ Regole Stabilite e Validate  
**Enforcement**: Obbligatorio per tutti i nuovi test  
**Review**: Required in code review process 
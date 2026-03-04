# PHPStan Quality Rules

## ⚠️ REGOLA CRITICA: NON ESCLUDERE MAI I TEST DA PHPSTAN

### ❌ COSA NON FARE MAI

**NON aggiungere mai i test a `excludePaths` in phpstan.neon:**

```yaml
# ❌ COMPLETAMENTE SBAGLIATO - NON FARE MAI!
excludePaths:
    - ./Modules/Activity/tests/*
    - ./*/tests/*
```

### ✅ PERCHÉ È FONDAMENTALE ANALIZZARE I TEST

#### 1. **I Test Sono Codice di Produzione**
I test non sono "codice secondario" - sono codice di produzione che:
- Documenta il comportamento atteso del sistema
- Garantisce la correttezza delle funzionalità
- Previene regressioni
- Serve come documentazione vivente

**Se i test hanno errori di tipo, il nostro sistema di qualità è compromesso.**

#### 2. **Problemi di Type Safety nei Test**
Escludere i test da PHPStan nasconde:
- Errori di tipo nelle asserzioni
- Mock configurati incorrettamente
- Factory che generano dati invalidi
- Test che passano per motivi sbagliati (false positive)

#### 3. **Degrado Progressivo della Qualità**
Escludere i test porta a:
```php
// ❌ Senza PHPStan, questi errori passano inosservati:
test('example', function () {
    $user = User::factory()->create();
    expect($user->nane)->toBe('John');  // Typo: "nane" invece di "name"
});

test('another', function () {
    $service = new UserService();
    $result = $service->process(123);  // Passa int invece di User
    expect($result)->toBeTrue();       // Il test passa, ma è sbagliato!
});
```

#### 4. **Violazione dei Principi di Quality Excellence**
Questo progetto ha raggiunto:
- ✅ 94.5% Quality Score
- ✅ 99.8% Low Complexity
- ✅ Zero PHPStan Errors

**Escludere i test da PHPStan mina questi risultati.**

### ✅ APPROCCIO CORRETTO

#### Opzione 1: Risolvere gli Errori (PREFERITO)
```php
// ✅ Fix the actual issues in tests
test('creates user correctly', function (): void {
    /** @var User $user */
    $user = User::factory()->create([
        'name' => 'John Doe',
    ]);

    expect($user)
        ->toBeInstanceOf(User::class)
        ->name->toBe('John Doe');
});
```

#### Opzione 2: Usare Ignore Specifici (Solo se Necessario)
Se ci sono errori legittimi nei test (es. test delle eccezioni), usa ignore specifici:

```yaml
# ✅ Ignore specifico e documentato
ignoreErrors:
    # Pest closure $this-> dynamic properties - legittimo in Pest
    - identifier: property.notFound
      path: */tests/*
```

**Ma solo per pattern specifici e documentati, MAI per escludere tutti i test!**

#### Opzione 3: Configurazioni Per-Module (Advanced)
Ogni modulo può avere il suo `phpstan.neon.dist`:

```yaml
# Modules/Activity/phpstan.neon.dist
includes:
    - ../../phpstan.neon

parameters:
    # Configurazioni specifiche per Activity module
    # MA COMUNQUE ANALIZZA I TEST!
```

### 🎯 LINEE GUIDA PER MANTENERE LA QUALITÀ

1. **Tutti i test devono passare PHPStan** senza esclusioni
2. **Usa type hints espliciti** nei test come nel codice di produzione
3. **I factory devono generare dati type-safe**
4. **Le asserzioni devono essere type-safe**
5. **I mock devono avere type hints corretti**

### 📊 METRICHE DI QUALITÀ DEI TEST

```bash
# Analizza i test con PHPStan
./vendor/bin/phpstan analyse Modules/Activity/tests --level=max

# I test devono avere:
# - Zero errori PHPStan
# - Coverage ≥ 80%
# - Complexity ≤ 10 per method
```

### 🚫 CONSEGUENZE DELL'ESCLUSIONE DEI TEST

Se escludi i test da PHPStan:
1. ❌ Perdi la garanzia di type safety
2. ❌ I test possono avere false positive
3. ❌ Il refactoring diventa pericoloso
4. ❌ La qualità degrada progressivamente
5. ❌ Si perdono i benefici dell'analisi statica

### ✅ ESEMPIO DI TEST CON PIENO TYPE SAFETY

```php
<?php

declare(strict_types=1);

use Modules\Activity\Models\Activity;
use Modules\User\Models\User;

test('activity is logged correctly', function (): void {
    // Type-safe factory usage
    /** @var User $user */
    $user = User::factory()->create();

    // Type-safe action
    $activity = Activity::create([
        'user_id' => $user->id,
        'action' => 'login',
        'description' => 'User logged in',
    ]);

    // Type-safe assertions
    expect($activity)
        ->toBeInstanceOf(Activity::class)
        ->user_id->toBe($user->id)
        ->action->toBe('login');

    // Type-safe database assertion
    assertDatabaseHas(Activity::class, [
        'user_id' => $user->id,
        'action' => 'login',
    ]);
});
```

## 📝 RICORDA

> **"Se i tuoi test non passano PHPStan, i tuoi test non sono affidabili."**
>
> **"Code that isn't analyzed is code that can't be trusted."**

---

**Documento creato per prevenire la pratica sbagliata di escludere i test dall'analisi statica.**

**Data:** [DATE]
**Severity:** CRITICA
**Categoria:** Code Quality & Testing Standards

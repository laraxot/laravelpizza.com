# Analisi Completa PHPStan - 10 Ottobre 2025

## Sommario Generale

- **Totale errori**: 19,750
- **File con errori**: 19,750
- **Livello PHPStan**: max
- **Moduli analizzati**: 18
- **File di test**: 326

## Distribuzione Errori per Modulo

| Modulo | Errori | % Totale |
|--------|--------|----------|
| User | 4,810 | 24.4% |
| Fixcity | 3,909 | 19.8% |
| Notify | 2,766 | 14.0% |
| Cms | 1,704 | 8.6% |
| Geo | 1,216 | 6.2% |
| Xot | 1,112 | 5.6% |
| UI | 978 | 5.0% |
| Activity | 972 | 4.9% |
| Tenant | 812 | 4.1% |
| Media | 501 | 2.5% |
| Altri | 970 | 4.9% |

## Top 20 Tipologie di Errori

### 1. method.internalClass (4,702 errori - 23.8%)
**Descrizione**: Chiamate a metodi di classi interne di Pest da fuori del suo namespace

**Esempio**:
```php
// Modules/AI/tests/Unit/Actions/CompletionActionTest.php:66
Call to method toBe() of internal class Pest\Mixins\Expectation<TValue>
```

**Soluzione**: Già gestito dall'extension Pest. Questi errori dovrebbero essere ignorabili.

### 2. property.notFound (4,290 errori - 21.7%)
**Descrizione**: Accesso a proprietà non definite su Collection o Models

**Esempio**:
```php
// Modules/Activity/tests/Feature/ActivityEventSourcingTest.php:20
Access to an undefined property Illuminate\Database\Eloquent\Collection::$id
```

**Soluzioni**:
- Aggiungere PHPDoc `@var` con tipo corretto
- Usare `->first()->id` invece di `->id` su Collection
- Aggiungere `@property` nelle docblock dei Model

### 3. method.nonObject (3,880 errori - 19.7%)
**Descrizione**: Chiamate a metodi su tipo `mixed`

**Esempio**:
```php
// Modules/AI/tests/Unit/Services/AIServiceTest.php:303
Cannot call method andThrow() on mixed
```

**Soluzioni**:
- Aggiungere type hints ai parametri
- Aggiungere PHPDoc `@param` e `@return`
- Usare assert per narrowing del tipo

### 4. property.nonObject (1,235 errori - 6.3%)
**Descrizione**: Accesso a proprietà su oggetti nullable

**Esempio**:
```php
// Modules/Activity/tests/Feature/ActivityBusinessLogicTest.php:194
Cannot access property $log_name on Modules\Activity\Models\Activity|null
```

**Soluzioni**:
- Aggiungere controlli `if ($activity !== null)`
- Usare null-safe operator `?->`
- Aggiungere assert `assertNotNull()`

### 5. method.notFound (1,069 errori - 5.4%)
**Descrizione**: Metodi non trovati su Expectation di Pest

**Esempio**:
```php
// Modules/Activity/tests/Feature/ActivityEventSourcingTest.php:78
Call to an undefined method Pest\Mixins\Expectation<Collection>::toBeArray()
```

**Soluzioni**:
- Usare metodi corretti di Pest
- Aggiungere generic types corretti

### 6. offsetAccess.nonOffsetAccessible (959 errori - 4.9%)
**Descrizione**: Accesso array su tipo `mixed`

**Esempio**:
```php
// Modules/Activity/tests/Feature/ActivityBusinessLogicTest.php:228
Cannot access offset 'order_details' on mixed
```

**Soluzioni**:
- Aggiungere PHPDoc `@var array<string, mixed>`
- Usare type hints più specifici
- Aggiungere assert per il tipo

### 7. argument.templateType (830 errori - 4.2%)
**Descrizione**: Impossibile risolvere i template types generici

**Esempio**:
```php
// Modules/Activity/tests/Feature/ActivityEventSourcingTest.php:202
Unable to resolve the template type TValue in call to function expect
```

**Soluzioni**:
- Specificare il tipo esplicitamente
- Migliorare i PHPDoc con generics

### 8. argument.type (687 errori - 3.5%)
**Descrizione**: Tipo argomento errato passato a funzioni

**Esempio**:
```php
// Modules/Activity/tests/Feature/ActivityBusinessLogicTest.php:227
Parameter #1 $json of function json_decode expects string, Collection given
```

**Soluzioni**:
- Convertire il tipo prima di passarlo
- Correggere la logica del codice
- Aggiungere cast espliciti

### 9. class.notFound (380 errori - 1.9%)
**Descrizione**: Classi non trovate (typo o import mancanti)

**Esempio**:
```php
// Modules/AI/tests/Unit/Services/AIServiceTest.php:17
Property has unknown class Modules\AI\Services\AIService
```

**Soluzioni**:
- Correggere namespace
- Aggiungere import mancanti
- Verificare esistenza della classe

### 10. theCodingMachineSafe.function (347 errori - 1.8%)
**Descrizione**: Funzioni unsafe che possono tornare false invece di eccezione

**Esempio**:
```php
// Modules/Activity/tests/Feature/ActivityBusinessLogicTest.php:17
Function json_encode is unsafe to use
```

**Soluzioni**:
- Usare `Safe\json_encode()` dal package thecodingmachine/safe
- Aggiungere controlli sui valori di ritorno

## Strategia di Correzione

### Fase 1: Correzioni Automatizzate (50% errori)
1. Script per aggiungere PHPDoc mancanti
2. Script per correggere accessi a Collection
3. Script per aggiungere null checks
4. Script per convertire json_encode/json_decode a versioni safe

### Fase 2: Correzioni Semi-Automatiche (30% errori)
1. Analizzare pattern comuni per modulo
2. Generare fix specifici per ogni pattern
3. Review manuale

### Fase 3: Correzioni Manuali (20% errori)
1. Errori di logica
2. Refactoring necessari
3. Casi edge complessi

## Prossimi Passi

1. ✅ Installata Pest extension per PHPStan
2. ⏳ Creare script automatizzati per correzioni comuni
3. ⏳ Iniziare correzioni modulo User (4,810 errori)
4. ⏳ Proseguire con Fixcity (3,909 errori)
5. ⏳ Continuare con altri moduli
6. ⏳ Aggiornare documentazione moduli
7. ⏳ Aggiornare documentazione temi
8. ⏳ Verifica finale: 0 errori

## Note

- Non posso modificare `phpstan.neon`
- Non posso creare baseline
- Tutti gli errori devono essere risolti nel codice
- Focus particolare sui test in Pest
- Obiettivo: **0 errori PHPStan livello max**

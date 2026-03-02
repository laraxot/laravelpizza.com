# Filosofia degli Strumenti di Qualità - La Trinità del Codice Perfetto

## 🎯 Overview - I Tre Pilastri

```
         QUALITY CODE
              ▲
             ╱│╲
            ╱ │ ╲
           ╱  │  ╲
          ╱   │   ╲
    STATIC │ RUNTIME
   ANALYSIS│  GUARDS
            │
      DOCUMENTATION
```

**FILOSOFIA**: La qualità del codice richiede verifiche a **3 livelli**:
1. **Static** (PHPStan + Larastan) - Compile-time
2. **Runtime** (Webmozart Assert + Safe) - Execution-time
3. **Documentation** (IDE Helper) - Developer-time

---

## 📚 STRUMENTO 1: Laravel IDE Helper

### 🙏 La Religione dell'Illuminazione

**SCOPO DIVINO**: Rivelare a PHPStan ciò che Laravel nasconde

**IL PROBLEMA ESISTENZIALE**:
```php
class User extends Model {
    // NO $email property declared!
}

$user->email;  // Funziona! (magia __get())

// Ma PHPStan è confuso:
// "Property email does not exist on User!"
```

**LA SOLUZIONE ILLUMINANTE**:
```bash
php artisan ide-helper:models --write
```

**GENERA**:
```php
/**
 * @property string $email
 * @property string $name
 * @property \Carbon\Carbon $created_at
 *
 * @property-read Profile $profile
 * @property-read Collection<int, Role> $roles
 */
class User extends Model {
    // Ora PHPStan "vede" le properties!
}
```

### Comandamenti IDE Helper

1. **Rigenera dopo migrations**: `php artisan ide-helper:models --write`
2. **Usa --nowrite per preview**: Test prima di commit
3. **Commit PHPDoc nel codice**: @property nel model stesso
4. **Relation PHPDoc specifici**: `Collection<int, Role>` non solo `Collection`

### Pattern di Utilizzo nel Progetto

**Config attuale** (da verificare):
```bash
# Check se ide-helper è configurato
cat config/ide-helper.php 2>/dev/null || echo "Config non trovato"
```

**Best Practice**:
```php
/**
 * Generate helpers after:
 * - New migration
 * - New relationship
 * - Schema changes
 */
php artisan ide-helper:models --write --reset
```

---

## 🛡️ STRUMENTO 2: Webmozart Assert

### ⚖️ La Politica del Runtime Guard

**FILOSOFIA**: "Static analysis trova bug PRIMA, runtime guards trova bug DURANTE"

**IL PROBLEMA**:
```php
// PHPStan SA che $data è mixed
function process(mixed $data): string {
    return $data['key'];
    // ✅ PHPStan: OK (mixed può essere array)
    // ❌ Runtime: BOOM se $data non è array!
}
```

**LA SOLUZIONE**:
```php
use Webmozart\Assert\Assert;

function process(mixed $data): string {
    Assert::isArray($data);  // ← Runtime guard!
    Assert::keyExists($data, 'key');

    return $data['key'];
    // ✅ PHPStan: OK
    // ✅ Runtime: Exception if data invalid
}
```

### Le 7 Categorie di Assertions

#### 1. **Type Assertions**
```php
Assert::string($value);        // Must be string
Assert::integer($value);       // Must be integer
Assert::boolean($value);       // Must be boolean
Assert::float($value);         // Must be float
Assert::numeric($value);       // Must be numeric
Assert::scalar($value);        // Must be scalar
Assert::object($value);        // Must be object
Assert::resource($value);      // Must be resource
Assert::isCallable($value);    // Must be callable
```

#### 2. **Nullability Assertions**
```php
Assert::null($value);          // Must be null
Assert::notNull($value);       // Must not be null
Assert::nullOrString($value);  // null OR string
```

#### 3. **Array Assertions**
```php
Assert::isArray($value);                 // Must be array
Assert::isMap($value);                   // Associative array
Assert::isList($value);                  // Numeric indexed array
Assert::keyExists($array, 'key');        // Key must exist
Assert::keyNotExists($array, 'key');     // Key must not exist
Assert::count($array, 5);                // Must have 5 elements
Assert::notEmpty($array);                // Must not be empty
```

#### 4. **String Assertions**
```php
Assert::stringNotEmpty($value);          // Non-empty string
Assert::startsWith($string, 'prefix');   // Must start with
Assert::endsWith($string, 'suffix');     // Must end with
Assert::contains($string, 'substring');  // Must contain
Assert::length($string, 10);             // Must be 10 chars
Assert::minLength($string, 5);           // At least 5 chars
Assert::maxLength($string, 100);         // At most 100 chars
Assert::regex($string, '/pattern/');     // Must match regex
Assert::email($string);                  // Must be valid email
Assert::uuid($string);                   // Must be UUID
```

#### 5. **Instance Assertions**
```php
Assert::isInstanceOf($object, User::class);
Assert::notInstanceOf($object, Admin::class);
Assert::isAnyOf($value, ['string', 'int']);  // Union types
```

#### 6. **Comparison Assertions**
```php
Assert::eq($value, 10);            // Equal
Assert::notEq($value, 0);          // Not equal
Assert::same($value, $expected);   // Identical (===)
Assert::greaterThan($value, 5);    // > 5
Assert::lessThan($value, 100);     // < 100
Assert::range($value, 1, 10);      // Between 1 and 10
Assert::oneOf($value, ['a', 'b']); // In list
```

#### 7. **Complex Assertions**
```php
Assert::allString($array);         // All elements are strings
Assert::allIsInstanceOf($array, User::class);  // All are Users
Assert::isList($array);            // Numeric sequential keys
Assert::isMap($array);             // String keys (assoc array)
```

### Usage Pattern nel Progetto

**392 file lo usano!** Esempio tipico:
```php
use Webmozart\Assert\Assert;

public function execute(mixed $data): Model {
    Assert::isArray($data);
    Assert::keyExists($data, 'email');
    Assert::string($data['email']);
    Assert::email($data['email']);

    return User::create($data);
}
```

**BENEFICIO**: PHPStan + Assert = **Type Safety Totale** (static + runtime)

---

## 🔥 STRUMENTO 3: Safe Functions

### 💀 La Filosofia del "Fail Fast"

**IL PROBLEMA PHP**:
```php
// PHP standard: Silent failure
$json = json_decode('invalid json');
var_dump($json);  // NULL
// ❌ Nessun errore! Bug procede silenzioso!

if ($json === null) {
    // Developer DEVE ricordare questo check
}
```

**LA SOLUZIONE SAFE**:
```php
use function Safe\json_decode;

$json = json_decode('invalid json');
// ✅ BOOM! Exception immediata!
// ✅ Stack trace chiaro!
// ✅ IMPOSSIBLE ignorare l'errore!
```

### Le Funzioni Trasformate

**234 file nel progetto usano**:

```php
// File operations
use function Safe\file_get_contents;
use function Safe\file_put_contents;
use function Safe\realpath;
use function Safe\mkdir;
use function Safe\unlink;

// String operations
use function Safe\preg_match;
use function Safe\preg_replace;
use function Safe\preg_split;

// Data operations
use function Safe\json_decode;
use function Safe\json_encode;
use function Safe\serialize;
use function Safe\unserialize;

// Array operations
use function Safe\array_combine;
use function Safe\array_flip;
use function Safe\ksort;
use function Safe\usort;

// DateTime operations
use function Safe\DateTime;
```

### Quando NON Usare Safe

```php
// ❌ Safe\in_array - Non esiste!
// ✅ in_array() - già sicuro

// ❌ Safe\isset - Non esiste!
// ✅ isset() - già sicuro

// ❌ Safe\property_exists - Non esiste!
// ✅ isset() - pattern corretto per Eloquent!
```

**REGOLA**: Safe esiste SOLO per funzioni che ritornano `false` on error.

---

## 🔍 STRUMENTO 4: phpstan-safe-rule

### 👁️ Il Vigilante

**SCOPO**: Forza l'uso di Safe functions

**IN AZIONE**:
```php
// phpstan.neon include:
includes:
    - ./vendor/thecodingmachine/phpstan-safe-rule/phpstan-safe-rule.neon

// Ora PHPStan verifica:
$content = file_get_contents('file.txt');
// ❌ PHPStan Error: "Use Safe\file_get_contents instead!"

use function Safe\file_get_contents;
$content = file_get_contents('file.txt');
// ✅ PHPStan: OK!
```

**CONFIGURAZIONE PROGETTO**:
```neon
# phpstan.neon linea 6
- ./vendor/thecodingmachine/phpstan-safe-rule/phpstan-safe-rule.neon
```

**EFFETTO**: Developer OBBLIGATO a usare Safe functions! No scelta!

---

## 🎓 STRUMENTO 5: Larastan

### 🪄 Il Mago di Laravel

**SCOPO**: Insegnare a PHPStan i magic di Laravel

**SENZA Larastan**:
```php
User::where('email', $email)->first();
// ❌ PHPStan: "Static method where() not found on User!"

// PHPStan non SA del __callStatic magic!
```

**CON Larastan**:
```php
User::where('email', $email)->first();
// ✅ PHPStan: "OK! Larastan extension understand Eloquent!"

// Larastan aggiunge "virtual methods" a PHPStan!
```

### Cosa Comprende Larastan

1. **Eloquent Query Builder**
```php
Model::where()->orWhere()->with()->get()  // ✅ Tutto compreso!
```

2. **Facades**
```php
Cache::remember()
DB::table()
File::exists()  // ✅ Tutte le Facades!
```

3. **Container Resolution**
```php
app(Service::class)  // ✅ Capisce dependency injection!
```

4. **Relationships**
```php
$user->posts()  // ✅ Capisce HasMany!
```

5. **Collections**
```php
collect()->map()->filter()  // ✅ Metodi Collection!
```

**CONFIGURAZIONE**:
```neon
includes:
    - ./vendor/larastan/larastan/extension.neon
```

---

## 📏 STRUMENTO 6: PHPMD (PHP Mess Detector)

### 🔬 Il Giudice della Complessità

**SCOPO**: Trova "code smells" che PHPStan non vede

**LE 6 CATEGORIE DI GIUDIZIO**:

#### 1. **Clean Code**
```php
// ❌ PHPMD: "StaticAccess violation"
Str::slug($name);

// Analisi: OK per Laravel Facades (accettato)
```

#### 2. **Code Size**
```php
// ❌ PHPMD: "TooManyMethods - Class has 25 methods"
class GodClass {
    // Limit: 10 methods per class
}

// ⚠️ Refactoring needed!
```

#### 3. **Controversial**
```php
// ❌ PHPMD: "Superglobals - Access to $_SERVER"
$server = $_SERVER['HTTP_HOST'];

// Analisi: Sometimes necessary (documentato)
```

#### 4. **Design**
```php
// ❌ PHPMD: "CouplingBetweenObjects - Too many dependencies"
public function __construct(
    ServiceA $a,
    ServiceB $b,
    ServiceC $c,
    // ... 15 dependencies!
) {}

// Limit: 13 dependencies
```

#### 5. **Naming**
```php
// ❌ PHPMD: "ShortVariable - $k is too short"
foreach ($array as $k => $v) {}

// Minimum length: 3 characters
// Fix: $key => $value
```

#### 6. **Unused Code**
```php
// ❌ PHPMD: "UnusedFormalParameter"
public function process($data, $unused) {
    return $data;
}

// Fix: Remove $unused or use it!
```

### Configurazione Progetto

**Check attuale**:
```bash
cat phpmd.ruleset.xml  # ← Verifica regole attive
```

**Standard run**:
```bash
./vendor/bin/phpmd Modules/User text cleancode,codesize,design
```

---

## 💎 STRUMENTO 7: PHPInsights

### 🏆 Il Certificatore di Eccellenza

**SCOPO**: Overall code quality score

**LE 4 DIMENSIONI**:

#### 1. **Code Quality** (40%)
- Complexity
- Architecture
- Code style
- Best practices

#### 2. **Complexity** (30%)
- Cyclomatic complexity
- Cognitive complexity
- Lines per method/class

#### 3. **Architecture** (20%)
- Dependencies
- Coupling
- Cohesion
- SOLID principles

#### 4. **Style** (10%)
- PSR compliance
- Naming conventions
- Documentation

### Scoring System

```
90-100: Eccellente  🏆
80-89:  Buono       ✅
70-79:  Discreto    ⚠️
60-69:  Sufficiente 🔶
<60:    Inaccettabile ❌
```

### Run Command

```bash
./vendor/bin/phpinsights analyse Modules/User --no-interaction
```

**Output Example**:
```
Code Quality: 92.5% 🏆
Complexity:   85.0% ✅
Architecture: 78.5% ⚠️
Style:        95.0% 🏆

Overall: 87.8% ✅ GOOD
```

---

## 🎭 IL TRIANGOLO DELLA VERITÀ

### Come i 3 Pilastri Collaborano

```
           DEVELOPER WRITES CODE
                     ↓
         ┌───────────┴───────────┐
         │                       │
    IDE HELPER              PHPSTAN L10
    generates              reads @property
    @property              enforces types
         │                       │
         └───────────┬───────────┘
                     ↓
              CODE WITH TYPES
                     ↓
         ┌───────────┴───────────┐
         │                       │
    WEBMOZART ASSERT        SAFE FUNCTIONS
    runtime guards          fail-fast errors
         │                       │
         └───────────┬───────────┘
                     ↓
           PRODUCTION READY CODE
```

**FLUSSO**:
1. Developer modifica database schema
2. Run `ide-helper:models` → genera @property
3. PHPStan verifica types → static safety
4. Assert guards → runtime safety
5. Safe functions → no silent failures
6. PHPMD → complexity checks
7. PHPInsights → overall quality

---

## 🧘 LO ZEN DELLA QUALITÀ

### I 10 Principi

1. **Static Prima, Runtime Dopo**: PHPStan trova bug gratis, Assert costa performance
2. **Explicit Better Than Implicit**: Type hints > PHPDoc > mixed
3. **Fail Fast, Fail Loud**: Exception > false return > null return
4. **Document What Cannot Be Typed**: PHPDoc per array shapes complessi
5. **Trust Types, Verify Values**: PHPStan verifica structure, Assert verifica content
6. **Single Source of Truth**: @property nel model, non in file separato
7. **Minimal Ignore**: @phpstan-ignore SOLO per terze parti
8. **Quality Gates**: Tutti i tool passano PRIMA di commit
9. **Continuous Improvement**: Re-run tools dopo OGNI modifica
10. **Documentation is Code**: Docs obsoleti = codice obsoleto

---

## 🎯 APPLICAZIONE AL PROBLEMA property_exists

### La Connessione Filosofica

**PERCHÉ** eliminare property_exists?

1. **IDE Helper Perspective**:
   - IDE Helper genera `@property string $email`
   - PHPStan SA che email esiste
   - `property_exists()` è RIDONDANTE!

2. **Webmozart Assert Perspective**:
   - Se vuoi verificare type: `Assert::isInstanceOf($record, User::class)`
   - Se vuoi verificare attributo: `isset($record->email)`
   - `property_exists()` è SBAGLIATO per Eloquent!

3. **Safe Functions Perspective**:
   - `property_exists()` NON ha versione Safe (perché già sicura)
   - Ma su Eloquent è SEMANTICAMENTE sbagliata!
   - `isset()` è la "safe" way per magic properties!

### Il Pattern Completo

```php
// VECCHIO APPROCCIO (property_exists)
if (is_object($record) && property_exists($record, 'email')) {
    // ❌ SEMPRE false per Eloquent attributes!
    return $record->email;
}

// NUOVO APPROCCIO (Multi-level safety)

// Level 1: Instance check (Webmozart)
Assert::isInstanceOf($record, User::class);
// ✅ PHPStan ora SA che $record è User
// ✅ PHPStan vede @property string $email via IDE Helper!

// Level 2: Value check (isset)
if (isset($record->email)) {
    // ✅ Verifica che email ha valore (via __get())
    return $record->email;  // ✅ PHPStan: string (da @property)
}

// Level 3: Null coalescing (quando appropriate)
return $record->email ?? 'default';
// ✅ Più conciso, stesso effetto!
```

---

## 📋 CHECKLIST MULTI-TOOL per OGNI FILE

Quando modifichi un file:

### Step 1: Modifica
```php
// Sostituisci property_exists con isset/Assert
```

### Step 2: IDE Helper (se model modificato)
```bash
php artisan ide-helper:models MyModel --write
```

### Step 3: PHPStan Level 10
```bash
./vendor/bin/phpstan analyse path/to/file.php --level=10
# DEVE essere: [OK] No errors
```

### Step 4: PHPMD
```bash
./vendor/bin/phpmd path/to/file.php text cleancode,codesize,design
# Verifica output, documenta warnings se accettabili
```

### Step 5: PHPInsights (per file importanti)
```bash
./vendor/bin/phpinsights analyse path/to/file.php --no-interaction
# Target: >80 score
```

### Step 6: Laravel Pint
```bash
./vendor/bin/pint path/to/file.php
# Auto-format PSR-12
```

---

## 🗺️ STRATEGIA ELIMINAZIONE property_exists

### Priority Matrix

| File Type | Count | Priority | Tools | Effort |
|-----------|-------|----------|-------|--------|
| **Models** | 5 | CRITICAL | All 4 | High |
| **Filament Resources** | 10 | HIGH | Stan+MD | Medium |
| **Actions** | 15 | MEDIUM | Stan+MD | Low |
| **Widgets** | 8 | HIGH | All 4 | Medium |
| **Tests** | 2 | LOW | Stan | Low |
| **Docs** | 49 | INFO | None | Zero |

### Workflow Per File

```
1. READ file → Comprendi contesto
2. IDENTIFY pattern → Quale dei 3 archetipi?
3. REPLACE property_exists → isset/hasAttribute/method_exists
4. ADD comment → PHPStan Level 10 reasoning
5. FORMAT → ./vendor/bin/pint
6. VERIFY:
   ✅ phpstan --level=10
   ✅ phpmd cleancode,design
   ✅ phpinsights (se critico)
7. DOCUMENT → Aggiungi a changelog modulo
```

---

## 📖 ESEMPI PRATICI DAL PROGETTO

### Esempio 1: User/Filament/Resources/BaseProfileResource

**PRIMA**:
```php
$userValue = property_exists($record, 'user') ? $record->user : null;
```

**ANALISI**:
- $record è Profile model
- 'user' è relationship (BelongsTo)
- property_exists() SEMPRE false per relationships!

**DOPO**:
```php
// PHPStan L10: isset() respects Eloquent __get() for relationships
$userValue = isset($record->user) ? $record->user : null;

// O meglio (null coalescing):
$userValue = $record->user ?? null;
```

**VERIFICA**:
```bash
./vendor/bin/phpstan analyse Modules/User/app/Filament/Resources/BaseProfileResource/Pages/ListProfiles.php --level=10
./vendor/bin/phpmd Modules/User/app/Filament/Resources/BaseProfileResource/Pages/ListProfiles.php text design
```

---

### Esempio 2: Media/Filament/Resources/MediaResource

**PRIMA**:
```php
->visible(fn($record): bool =>
    is_object($record) &&
    property_exists($record, 'type') &&
    $record->type === 'image'
)
```

**ANALISI**:
- $record è Media model con @property string $type
- property_exists() ridondante se @property esiste!

**DOPO**:
```php
// PHPStan L10: @property string $type makes isset() redundant
->visible(fn(Media $record): bool => $record->type === 'image')

// O se $record può essere mixed:
->visible(fn($record): bool =>
    is_object($record) &&
    isset($record->type) &&  // ← Cambio QUI
    $record->type === 'image'
)
```

---

### Esempio 3: Xot/Actions/Cast/SafeObjectCastAction

**PRIMA**:
```php
if (!is_object($value) || !property_exists($value, 'method')) {
    throw new Exception('Invalid');
}
```

**ANALISI**:
- Se $value NON è Model, property_exists() OK
- Se $value È Model, property_exists() SBAGLIATO
- Soluzione: Check se è Eloquent prima!

**DOPO**:
```php
if (!is_object($value)) {
    throw new Exception('Value must be object');
}

// Se è Eloquent Model, usa isset
if ($value instanceof \Illuminate\Database\Eloquent\Model) {
    if (!isset($value->method)) {
        throw new Exception('Model missing attribute');
    }
}
// Se è Standard Object, usa property_exists
else {
    if (!property_exists($value, 'method')) {
        throw new Exception('Object missing property');
    }
}
```

---

## 🎯 METRICHE DI SUCCESSO

### Before Cleanup
- `property_exists()` su Models: 89 occorrenze ❌
- PHPStan warnings: Potenziali false negatives
- Code smell: Property checks semantically wrong
- IDE support: Inconsistent autocomplete

### After Cleanup
- `property_exists()` su Models: 0 occorrenze ✅
- PHPStan: Perfetto allineamento con @property
- Code correctness: Semantically aligned with Eloquent
- IDE support: Perfect autocomplete everywhere

---

## 🔗 Collegamenti Intra-Modulo

- [eloquent-properties-best-practices.md](./eloquent-properties-best-practices.md) - Pattern specifici
- [eloquent-models-critical-rules.md](./eloquent-models-critical-rules.md) - Regole critiche
- [property-exists-elimination-philosophy.md](./property-exists-elimination-philosophy.md) - Filosofia
- [phpstan/](./phpstan/) - PHPStan guides
- [../../../../../../../docs/quality/](../../../../../../../docs/quality/) - Root quality docs

---

## ✍️ CITAZIONI FILOSOFICHE

> "Gli strumenti di qualità sono come i sensi: PHPStan vede, Assert sente, Safe previene, PHPMD giudica, PHPInsights certifica. Insieme formano la percezione completa della qualità."
>
> — **Principio della Percezione Multi-Sensoriale**

> "property_exists() chiede 'Esiste nella forma?'
> isset() chiede 'Esiste nella sostanza?'
> Per Eloquent, la sostanza (DB) è più vera della forma (class)."
>
> — **Kōan della Forma e Sostanza**

> "Un bug trovato da PHPStan costa 1€.
> Un bug fermato da Assert costa 10€.
> Un bug in produzione costa 1000€.
> La prevenzione è economia."
>
> — **Principio del Costo Esponenziale**

---

**Creato**: 5 Novembre 2025
**Scopo**: Unificare la comprensione degli strumenti
**Status**: 📘 Master Reference Document
**Revision**: 1.0

**Ora posso procedere con l'eliminazione sistematica! ⚔️**

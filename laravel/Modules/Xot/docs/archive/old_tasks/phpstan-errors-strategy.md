# 🎯 **Strategia Correzione 406 Errori PHPStan Level 10**

**Data**: 11 Novembre 2025  
**Livello PHPStan**: 10  
**Errori Totali**: 406  
**Stato**: In Corso

## ✅ **Errori Già Corretti**

### **1. Extra.php - Extends Final Class** 
- **File**: `User/app/Models/Extra.php`
- **Problema**: Estendeva `Modules\Xot\Models\Extra` (final)
- **Soluzione**: Cambiato a `extends BaseExtra`
- **Status**: ✅ CORRETTO

### **2. Filament Resources Return Types** (8 file)
- **File**: `Job/app/Filament/Resources/*Resource.php`
- **Problema**: `array_values()` rimuoveva chiavi string
- **Soluzione**: Rimosso `array_values()` 
- **Status**: ✅ CORRETTO

**Errori Risolti**: 9/406

---

## 📋 **Categorizzazione Errori Rimanenti**

### **Categoria 1: Mixed Type Problems** (≈200 errori)

**Pattern**: `Cannot call method X() on mixed`, `Cannot access property $X on mixed`

**Soluzione Standard**:
```php
// ❌ PRIMA
$result = $someVariable->method();

// ✅ DOPO  
use Webmozart\Assert\Assert;

Assert::isInstanceOf($someVariable, ExpectedClass::class);
$result = $someVariable->method();
```

**File Coinvolti**:
- `User/Database/seeders/UserMassSeeder.php` (32 errori)
- `User/app/Filament/Resources/**/*.php` (50+ errori)
- `Geo/app/Services/*.php` (20+ errori)

### **Categoria 2: Array Key Type Issues** (≈50 errori)

**Pattern**: `return array<string, X> but returns array<int, X>`

**Soluzione**:
```php
// ❌ PRIMA
return array_values($array);

// ✅ DOPO
return $array;  // Mantiene chiavi string
```

### **Categoria 3: Method Return Type Issues** (≈80 errori)

**Pattern**: `Method should return X but returns mixed`

**Soluzione**:
```php
// ❌ PRIMA
public function getFormModel()
{
    return $this->model;
}

// ✅ DOPO
public function getFormModel(): Model
{
    $model = $this->model;
    Assert::isInstanceOf($model, Model::class);
    return $model;
}
```

### **Categoria 4: Parameter Type Issues** (≈40 errori)

**Pattern**: `Parameter expects X, Y given`

**Soluzione**:
```php
// ❌ PRIMA
Hash::make($data['password']);

// ✅ DOPO
$password = $data['password'];
Assert::string($password);
Hash::make($password);
```

### **Categoria 5: Offset Access on Mixed** (≈20 errori)

**Pattern**: `Cannot access offset 'key' on mixed`

**Soluzione**:
```php
// ❌ PRIMA
$value = $data['key'];

// ✅ DOPO
Assert::isArray($data);
Assert::keyExists($data, 'key');
$value = $data['key'];
```

### **Categoria 6: Foreach Non-Iterable** (≈10 errori)

**Pattern**: `Argument of an invalid type mixed supplied for foreach`

**Soluzione**:
```php
// ❌ PRIMA
foreach ($items as $item) {

// ✅ DOPO
Assert::isIterable($items);
foreach ($items as $item) {
```

### **Categoria 7: Already Narrowed Type** (≈6 errori)

**Pattern**: `Call to X will always evaluate to true`

**Soluzione**: Rimuovere assert ridondanti
```php
// ❌ PRIMA
Assert::isArray($data);  // $data è già array
if (is_array($data)) {

// ✅ DOPO  
if (true) {  // oppure rimuovere completamente
```

---

## 🔧 **Piano di Lavoro**

### **Fase 1: Errori Critici** (Completata)
- ✅ Extra.php extends final class
- ✅ Filament Resources array_values

### **Fase 2: UserMassSeeder.php** (32 errori)
```bash
cd Modules/User/Database/seeders
# Aggiungere type hints e assertions per factory()->create()
```

**Pattern Comune**:
```php
// Linea 204-205: Cannot call method count/create on mixed
$users = User::factory()->count(10)->create();
// Soluzione:
/** @var Collection<int, User> $users */
$users = User::factory()->count(10)->create();
Assert::allIsInstanceOf($users, User::class);
```

### **Fase 3: User Filament Resources** (50+ errori)
```bash
cd Modules/User/app/Filament
# Pattern: property access on mixed, method calls on mixed
```

**File Prioritari**:
1. `Resources/BaseUserResource.php`
2. `Resources/BaseProfileResource/Pages/*.php`
3. `Widgets/*.php`

### **Fase 4: Geo Services** (20+ errori)
```bash
cd Modules/Geo/app/Services
# Pattern: mixed type from API responses
```

**Soluzione**: Type hint per response structures
```php
/** @var array{lat: float, lng: float} $coordinates */
$coordinates = $apiResponse->json();
```

### **Fase 5: UI Components** (10+ errori)
```bash
cd Modules/UI/app/Filament/Forms/Components
# RadioIcon class not found, RadioBadge Assert issues
```

---

## 📚 **Strumenti e Best Practices**

### **1. Webmozart Assert**
```php
use Webmozart\Assert\Assert;

// Type checking
Assert::string($value);
Assert::integer($value);
Assert::isArray($value);
Assert::isInstanceOf($object, ClassName::class);

// Array assertions
Assert::keyExists($array, 'key');
Assert::allIsInstanceOf($collection, ClassName::class);
Assert::isIterable($items);
```

### **2. PHPDoc Annotations**
```php
/** @var Collection<int, User> $users */
$users = User::factory()->count(10)->create();

/** @var array{name: string, email: string} $data */
$data = $request->validated();
```

### **3. Type Narrowing**
```php
// instanceof check
if ($model instanceof User) {
    $model->email; // OK
}

// is_* functions  
if (is_string($value)) {
    strlen($value); // OK
}
```

### **4. Null Coalescing**
```php
// ❌ PRIMA
$value = $record->property;

// ✅ DOPO
$value = $record->property ?? null;
Assert::notNull($value);
```

---

## 🎯 **Obiettivi**

- [x] Risolvere errori critici (9/9)
- [ ] Risolvere UserMassSeeder (0/32)
- [ ] Risolvere User Resources (0/50)
- [ ] Risolvere Geo Services (0/20)
- [ ] Risolvere UI Components (0/10)
- [ ] Risolvere rimanenti (0/285)

**Target**: 0 errori PHPStan Level 10

---

## 📖 **Riferimenti**

- [PHPStan Level 10 Rules](https://phpstan.org/user-guide/rule-levels)
- [Webmozart Assert](https://github.com/webmozarts/assert)
- [Laravel Type Safety](https://laravel.com/docs/validation#available-validation-rules)
- [Laraxot Type Safety Rules](../code-quality.md)

---

**Ultimo aggiornamento**: 11 Novembre 2025  
**Progresso**: 9/406 errori risolti (2.2%)

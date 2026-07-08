# PHPStan Errors Systematic Fix Plan - Progressioni Module

## 🎯 **Architectural Analysis & Business Domain Understanding**

### Module Purpose
Il modulo **Progressioni** gestisce il sistema di progressioni economiche e di carriera del personale, con focus su:
- **Schede valutazione** per progressioni economiche
- **Criteri di valutazione** e precedenza
- **Gestione valutatori** e stabilimenti
- **Calcoli complessi** per punteggi e progressioni

### Core Business Logic Patterns Identified

#### 1. **Dynamic Field Access Pattern**
```php
// Pattern ricorrente nei traits
public function convertedIn(string $field, int $converted_in): float|int|null
{
    $fieldValue = $this->$field; // ❌ PHPStan: Binary operation with mixed
    return $fieldValue * 2.5;
}
```

#### 2. **Multi-Model Operations Pattern**
```php
// Pattern in Actions
public function execute(string $modelClass, string $fieldname, int|string $year): void
{
    $rows = $modelClass::where($fieldname, $year)->get(); // ❌ PHPStan: Mixed type
    foreach ($rows as $row) {
        $row->update(['refreshed_at' => now()]); // ❌ PHPStan: Cannot call method on mixed
    }
}
```

#### 3. **Complex Calculation Pattern**
```php
// Pattern in Models/Scheda.php
public function getTotaleAttribute(): float
{
    return $this->esperienza_acquisita * $this->peso_esperienza_acquisita +
           $this->risultati_ottenuti * $this->peso_risultati_ottenuti; // ❌ PHPStan: Mixed operations
}
```

## 🔍 **PHPStan Error Categories & Root Causes**

### Category 1: Mixed Type Violations (60+ errors)

**Root Cause**: Dynamic property access without type validation

**Files Affected**:
- `app/Models/Traits/ConvertedTrait.php` - Dynamic field conversion
- `app/Models/Scheda.php` - Complex calculations
- `app/Actions/TrovaEsclusiAction.php` - Multi-model operations

### Category 2: Return Type Inconsistencies (40+ errors)

**Root Cause**: Method signatures don't match Laraxot XotBaseResource requirements

**Files Affected**:
- `app/Filament/Resources/*Resource.php` - getFormSchema() return types
- `app/Models/Traits/*Trait.php` - Method return types

### Category 3: Property/Method Access Issues (70+ errors)

**Root Cause**: Accessing properties/methods on untyped objects

**Files Affected**:
- `app/Filament/Resources/*Resource/Pages/*.php` - Record access
- `app/Actions/*Action.php` - Model operations

## 🛠️ **Systematic Fix Strategy**

### Phase 1: Type Safety Foundation (Immediate)

#### 1.1 Fix Dynamic Property Access
```php
// ❌ BEFORE
public function convertedIn(string $field, int $converted_in): float|int|null
{
    $fieldValue = $this->$field;
    return $fieldValue * 2.5;
}

// ✅ AFTER
public function convertedIn(string $field, int $converted_in): float|int|null
{
    /** @var int|float|null $fieldValue */
    $fieldValue = $this->$field;
    
    if ($fieldValue === null) {
        return null;
    }
    
    return $fieldValue * 2.5;
}
```

#### 1.2 Fix Multi-Model Operations
```php
// ❌ BEFORE
public function execute(string $modelClass, string $fieldname, int|string $year): void
{
    $rows = $modelClass::where($fieldname, $year)->get();
    foreach ($rows as $row) {
        $row->update(['refreshed_at' => now()]);
    }
}

// ✅ AFTER
/**
 * @param class-string<\Illuminate\Database\Eloquent\Model> $modelClass
 */
public function execute(string $modelClass, string $fieldname, int|string $year): void
{
    /** @var \Illuminate\Database\Eloquent\Builder $query */
    $query = $modelClass::query();
    
    /** @var \Illuminate\Database\Eloquent\Collection $rows */
    $rows = $query->where($fieldname, $year)->get();
    
    foreach ($rows as $row) {
        /** @var \Illuminate\Database\Eloquent\Model $row */
        $row->update(['refreshed_at' => now()]);
    }
}
```

### Phase 2: Filament Resource Compliance (High Priority)

#### 2.1 Fix getFormSchema() Return Types
```php
// ❌ BEFORE
#[Override]
public static function getFormSchema(): array<string, \Filament\Forms\Components\Component>
{
    return [
        TextInput::make('id')->disabled(),
        TextInput::make('tipo')->numeric(),
    ];
}

// ✅ AFTER
#[Override]
public static function getFormSchema(): array
{
    return [
        'id' => TextInput::make('id')->disabled(),
        'tipo' => TextInput::make('tipo')->numeric(),
    ];
}
```

### Phase 3: Complex Calculation Type Safety (Medium Priority)

#### 3.1 Fix Mathematical Operations
```php
// ❌ BEFORE
public function getTotaleAttribute(): float
{
    return $this->esperienza_acquisita * $this->peso_esperienza_acquisita +
           $this->risultati_ottenuti * $this->peso_risultati_ottenuti;
}

// ✅ AFTER
public function getTotaleAttribute(): float
{
    /** @var float $exp */
    $exp = $this->esperienza_acquisita ?? 0.0;
    /** @var float $pesoExp */
    $pesoExp = $this->peso_esperienza_acquisita ?? 0.0;
    /** @var float $ris */
    $ris = $this->risultati_ottenuti ?? 0.0;
    /** @var float $pesoRis */
    $pesoRis = $this->peso_risultati_ottenuti ?? 0.0;
    
    return ($exp * $pesoExp) + ($ris * $pesoRis);
}
```

## 📋 **Implementation Priority Matrix**

### 🔴 CRITICAL (Fix Immediately)
1. **Dynamic Property Access** - `ConvertedTrait.php`, `Schede.php`
2. **Multi-Model Operations** - `RefreshByYearAction.php`, `TrovaEsclusiAction.php`
3. **Property Access on Mixed** - All files with `Cannot access property on mixed`

### 🟡 HIGH (Fix Within 1 Week)
1. **Filament Resource Return Types** - All `*Resource.php` files
2. **Method Call on Mixed** - All files with `Cannot call method on mixed`
3. **Binary Operations** - Mathematical calculations

### 🟢 MEDIUM (Fix Within 2 Weeks)
1. **Array Shape Issues** - Complex data structures
2. **Parameter Type Issues** - Method parameter validation
3. **Return Type Consistency** - Method signature alignment

## 🎨 **Laraxot Philosophy Compliance**

### Type Safety Principles
1. **Never use `mixed` without validation**
2. **Always validate dynamic property access**
3. **Use PHPDoc annotations for complex types**
4. **Implement proper return type declarations**

### Filament Best Practices
1. **Extend XotBase classes only**
2. **Use proper getFormSchema() signatures**
3. **Avoid hardcoded labels and placeholders**
4. **Follow Laraxot translation patterns**

## 🔧 **Tooling & Verification**

### PHPStan Configuration
```bash
# Run specific analysis
./vendor/bin/phpstan analyse Modules/Progressioni/app/Models --level=10
./vendor/bin/phpstan analyse Modules/Progressioni/app/Filament --level=10

# Generate baseline after fixes
./vendor/bin/phpstan analyse --generate-baseline
```

### Testing Strategy
1. **Unit Tests** for type-safe methods
2. **Integration Tests** for Filament resources
3. **PHPStan Level 10** compliance verification

## 📊 **Success Metrics**

- **PHPStan Errors**: 170 → 0
- **Type Safety**: 100% compliance
- **Filament Resources**: All extend XotBase properly
- **Business Logic**: Maintained with type safety

---

**Created**: November 2025  
**Status**: 🔴 IN PROGRESS  
**PHPStan Level**: 10 (Target)  
**Priority**: CRITICAL
# Form Compilation Patterns - Laraxot Standards

**Project**: PTVX Fila5 Mono  
**Context**: Form compilation patterns across modules  
**Date**: 2026-02-11  
**Status**: Complete reference for all form compilation pages

---

## 📋 **Core Principles**

### 1. XotBase Page Pattern
All form pages must extend `XotBasePage` and follow Laraxot patterns:

```php
class CompilaModule extends XotBasePage
{
    use HasRelationManagers;
    use InteractsWithRecord;
    
    protected static string $resource = ModuleResource::class;
    protected string $view = 'module::filament.resources.module.pages.compila';
}
```

### 2. Type Safety (PHPStan Level 10)
All code must pass PHPStan Level 10:

```php
// ✅ CORRECT - Strong typing
/** @var Collection<int, Rating> $ratings */
foreach ($ratings as $rating) {
    /** @var Rating $rating */
    $fieldname = 'ratings.'.$rating->id.'.pivot.value';
}

// ❌ WRONG - Mixed types
foreach ($ratings as $rating) {           // $rating is mixed
    $fieldname = 'ratings.'.$rating->id;   // Error on mixed
}
```

### 3. Dynamic Business Logic
Never hardcode business logic values:

```php
// ✅ CORRECT - Database-driven
$coefficiente = (float) ($record->coefficente_calcolo ?? 10);
$amount = $total * $coefficiente;

// ❌ WRONG - Hardcoded
return $total * 10;  // Hardcoded multiplier
```

---

## 🏗️ **Standard Form Structure**

### 1. Mount Method Pattern

```php
public function mount(int|string $record): void
{
    $this->record = $this->resolveRecord($record);
    $this->authorizeAccess();
    $this->previousUrl = url()->previous();
    
    $this->fillFormFromRecord();
}

private function fillFormFromRecord(): void
{
    /** @var ModuleModel $record */
    $record = $this->record;
    
    $modelData = $record->attributesToArray();
    $ratings = $record->syncRatingsWhere(['anno' => $record->anno]);
    $modelData['ratings'] = $ratings->keyBy('id')->toArray();
    
    $this->form->fill($modelData);
}
```

### 2. Form Schema Pattern

```php
protected function getFormSchema(): array
{
    $schema = [
        // Base model fields
        DatePicker::make('dal'),
        DatePicker::make('al'),
        Textarea::make('note')->columnSpanFull(),
    ];
    
    // Dynamic rating fields
    $ratings = $this->record->syncRatingsWhere(['anno' => $this->record->anno]);
    
    foreach ($ratings as $rating) {
        /** @var Rating $rating */
        $schema[] = $this->createRatingField($rating);
    }
    
    return $schema;
}

private function createRatingField(Rating $rating): TextInput
{
    $fieldname = 'ratings.'.$rating->id.'.pivot.value';
    
    $field = TextInput::make($fieldname)
        ->label(strip_tags((string)$rating->txt))
        ->rules((string)($rating->rules ?? ''))
        ->numeric()
        ->reactive()
        ->live();
    
    if ($rating->is_readonly ?? false) {
        $field
            ->formatStateUsing(fn(Get $get) => $this->getRatingValue($rating, $get))
            ->readOnly();
    }
    
    return $field;
}
```

### 3. Calculation Methods Pattern

```php
public function getTot(Get $get): int
{
    $ratingsData = $this->form?->getState()['ratings'] ?? [];
    $tot = 0;
    
    foreach ($ratingsData as $rating) {
        // Exclude calculated fields from sum
        if (!in_array($rating['title'], [
            'tot', 'importo mensile calcolato', 
            'importo mensile attribuito', 'importo annuale attribuito'
        ])) {
            $tot += (int)($rating['pivot']['value'] ?? 0);
        }
    }
    
    return $tot;
}

public function getImportoMensileCalcolato(Get $get): float
{
    $totale = $this->getTot($get);
    $coefficiente = (float) ($this->record->coefficente_calcolo ?? 10);
    
    return $totale * $coefficiente;
}
```

---

## 🎨 **UI/UX Patterns**

### 1. Total Display Pattern

```blade
<!-- Total Points Display -->
<div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
    <div class="flex justify-between items-center">
        <span class="font-bold text-lg text-blue-900">TOTALE PUNTI:</span>
        <span class="text-2xl font-bold text-blue-600">{{ $tot ?? 0 }}/25</span>
    </div>
    
    @if(($tot ?? 0) < 10)
        <div class="mt-2 text-sm text-orange-600">
            ⚠️ Punti insufficienti per il diritto all'indennità (minimo 10 punti)
        </div>
    @elseif(($tot ?? 0) >= 20)
        <div class="mt-2 text-sm text-green-600">
            ✅ Punti eccellenti! Massimo diritto all'indennità
        </div>
    @else
        <div class="mt-2 text-sm text-blue-600">
            ℹ️ Punti validi per il diritto all'indennità
        </div>
    @endif
</div>
```

### 2. Reactive Field Updates

```php
// Make readonly fields reactive to changes
$field->formatStateUsing(function(Get $get) use ($rating) {
    return $this->calculateFieldValue($rating, $get);
});
```

---

## 📊 **Cross-Module Consistency**

### 1. Rating System Usage

All modules using ratings must follow the same pattern:

```php
// IndennitaResponsabilita
$ratings = $record->syncRatingsWhere(['anno' => $record->anno]);

// Performance  
$ratings = $record->syncRatingsWhere(['anno' => $record->anno]);

// Progressioni
$ratings = $record->syncRatingsWhere(['anno' => $record->anno]);
```

### 2. Validation Rules Pattern

```php
// Use Rating rules consistently
$field->rules((string)($rating->rules ?? ''));

// Validation attributes for forms
$validationAttributes = $record->getRatingsValidationAttributes('form_data.ratings.', '.pivot.value');
```

---

## 🔧 **Configuration Pattern**

### 1. Database Configuration

Store calculation parameters in database, not hardcoded:

```php
// Migration
$table->decimal('coefficente_calcolo', 8, 2)->default(10.0);
$table->decimal('perc_p_time_year', 5, 4)->default(1.0);

// Model usage
$coefficiente = (float) ($this->record->coefficente_calcolo ?? 10);
$perc = (float) ($this->record->perc_p_time_year ?? 1);
```

### 2. Action Pattern for Business Logic

```php
final readonly class CalculateImportiAction
{
    public function execute(float $totale, IndennitaResponsabilita $record): array
    {
        $coefficiente = (float) ($record->coefficente_calcolo ?? 10);
        $perc = (float) ($record->perc_p_time_year ?? 1);
        
        return [
            'importo_mensile_calcolato' => $totale * $coefficiente,
            'importo_mensile_attribuito' => $totale * $coefficiente * $perc,
            'importo_annuale_attribuito' => $totale * $coefficiente * $perc * 12,
        ];
    }
}
```

---

## 🚨 **Common Anti-Patterns**

### 1. Hardcoded Values
```php
// ❌ AVOID
return rand(1, 100);  // Random values for testing
return $total * 10;     // Hardcoded multiplier

// ✅ PREFER
$coefficiente = (float) ($this->record->config_field ?? 10);
return $total * $coefficiente;
```

### 2. Mixed Type Violations

```php
// ❌ AVOID
foreach ($ratings as $rating) {           // Untyped
    $value = $rating->pivot['value'];   // Array access on mixed
}

// ✅ PREFER
/** @var Collection<int, Rating> $ratings */
foreach ($ratings as $rating) {           // Typed
    /** @var Rating $rating */
    $value = $rating->pivot->value;    // Object property access
}
```

### 3. Non-Reactive Fields

```php
// ❌ AVOID - Static readonly
if ($rating->is_readonly) {
    $item->readOnly();
    // No way to update value
}

// ✅ PREFER - Reactive readonly
if ($rating->is_readonly) {
    $item
        ->formatStateUsing(fn(Get $get) => $this->calculateValue($rating, $get))
        ->readOnly();
    // Updates when underlying data changes
}
```

---

## ✅ **Quality Checklist**

### Before Submitting Form Code

- [ ] All variables properly typed
- [ ] PHPDoc comments accurate
- [ ] No hardcoded business logic
- [ ] Readonly fields reactive
- [ ] Uses XotBase patterns
- [ ] Database-driven configuration
- [ ] Consistent with other modules
- [ ] PHPStan Level 10 compliant
- [ ] Laravel Pint formatted

### Testing Requirements

- [ ] Form loads correctly
- [ ] Reactive updates work
- [ ] Validation works
- [ ] Save functionality complete
- [ ] Total calculation accurate
- [ ] Cross-browser compatible

---

## 📚 **Related Documentation**

- **Rating Architecture**: `/Modules/Rating/docs/rating-architecture.md`
- **Migration Patterns**: `/Modules/Xot/docs/migration-patterns.md`
- **IndennitaResponsabilita Specific**: `/Modules/IndennitaResponsabilita/docs/compila-form-architecture.md`
- **Agent Memory**: `/AGENT_MEMORY.md`

---

**Author**: Development Team  

**Status**: Complete Pattern Reference  
**For**: All developers and AI agents working on form compilation
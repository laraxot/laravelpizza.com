# IndennitaResponsabilita - Compilation Form Architecture

**Module**: IndennitaResponsabilita  
**Context**: CompilaIndennitaResponsabilita page analysis and improvements  
**Date**: 2026-02-11  
**Status**: Critical Issues Identified - Complete Refactor Required

---

## 🚨 **Critical Issues Found**

### 1. PHPStan Level 10 - 19 Violations

#### Type Safety Issues
```php
// ❌ CURRENT - Untyped variables
foreach($ratings as $rating) {           // Line 113: $rating is mixed
    $fieldname='ratings.'.$rating->id.'.pivot.value'; // Line 116: $rating->id on mixed
    $item=TextInput::make($fieldname)
        ->label(strip_tags($rating->txt))         // Line 121: $rating->txt on mixed
        ->rules($rating->rules ?? '')           // Line 122: $rating->rules on mixed
```

#### PHPDoc Mismatches
```php
// ❌ CURRENT - Wrong PHPDoc variables
/** @var array<string, array<string, mixed>> $ratings */ // Line 58 - Wrong structure
/** @var IndennitaResponsabilita $record */    // Line 122 - Wrong var name

// ✅ CORRECT
/** @var Collection<int, Rating> $ratings */
/** @var IndennitaResponsabilita $currRecord */
```

### 2. Hardcoded Business Logic

#### Fixed Multipliers
```php
// ❌ CURRENT - Hardcoded values
public function getImportoMensileCalcolato(Get $get): float {
    return (float)($this->getTot($get)) * 10;         // HARDCODED!
}

// ✅ CORRECT - Database-driven
public function getImportoMensileCalcolato(Get $get): float {
    $totale = $this->getTot($get);
    $coefficiente = (float) ($this->record->coefficente_calcolo ?? 10);
    return $totale * $coefficiente;
}
```

### 3. is_readonly Not Reactive (FIXED - see [readonly-field-styling.md](./readonly-field-styling.md))

#### Current Implementation
```php
// ❌ CURRENT - Not reactive
if($rating->is_readonly ?? false) {
    $item->formatStateUsing(function(Get $get) use ($rating) {
        $method = 'get' . Str::studly((string)$rating->title);
        if (method_exists($this, $method)) {
            return $this->$method($get);
        }
        return 0;                    // <-- RANDOM VALUE!
    });
    // Missing ->readOnly() call!
}
```

### 4. Code Duplication

#### Duplicated Calculation Logic
```php
// ❌ CURRENT - 4 similar methods with different multipliers
getImportoMensileCalcolato()   // * 10
getImportoMensileAttribuito()   // * perc_p_time_year
getImportoAnnualeAttribuito()  // * perc_p_time_year * 12
```

---

## 🏗️ **Correct Architecture Pattern**

### 1. Model Extensions

```php
<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Models;

use Modules\Ptv\Models\BaseScheda;
use Modules\Rating\Models\Traits\HasRatingsTrait;

/**
 * @property int|null $coefficente_calcolo
 * @property float|null $perc_p_time_year
 */
class IndennitaResponsabilita extends BaseScheda
{
    use HasRatingsTrait;
    
    protected $connection = 'indennita_responsabilita';
    
    protected $fillable = [
        // ... existing fields ...
        'coefficente_calcolo',    // Configuration fields
        'perc_p_time_year',       // Percentage for calculation
    ];
    
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'coefficente_calcolo' => 'float',
            'perc_p_time_year' => 'float',
        ]);
    }
}
```

### 2. Page Structure (XotBase Pattern)

```php
<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages;

use Exception;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Pages\Actions;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Webmozart\Assert\Assert;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Modules\Xot\Filament\Traits\HasXotForm;
use Modules\Xot\Filament\Traits\HasXotTable;
use Filament\Schemas\Components\Utilities\Get;
use Modules\IndennitaResponsabilita\Models\Rating;
use Modules\Xot\Filament\Resources\Pages\XotBasePage;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Filament\Resources\Pages\Concerns\HasRelationManagers;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource;
use Illuminate\Database\Eloquent\Collection;

/**
 * Compila IndennitaResponsabilita Page.
 *
 * @property \Filament\Schemas\Schema $form
 * @property IndennitaResponsabilita $record
 */
class CompilaIndennitaResponsabilita extends XotBasePage
{
    use HasRelationManagers;
    use InteractsWithRecord;
    
    protected static string $resource = IndennitaResponsabilitaResource::class;
    protected string $view = 'indennitaresponsabilita::filament.resources.indennita-responsabilita.pages.compila';
    
    public ?string $previousUrl = null;
    
    /**
     * Mount page with record resolution.
     */
    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->authorizeAccess();
        $this->previousUrl = url()->previous();
        
        $this->fillFormFromRecord();
    }
    
    /**
     * Fill form with model data and ratings.
     */
    private function fillFormFromRecord(): void
    {
        /** @var IndennitaResponsabilita $record */
        $record = $this->record;
        $modelData = $record->attributesToArray();
        
        /** @var Collection<int, Rating> $ratings */
        $ratings = $record->syncRatingsWhere(['anno' => $record->anno]);
        $modelData['ratings'] = $ratings->keyBy('id')->toArray();
        
        $this->form->fill($modelData);
    }
    
    /**
     * Get dynamic form schema.
     *
     * @return array<string, \Filament\Forms\Components\Component>
     */
    protected function getFormSchema(): array
    {
        $schema = [
            DatePicker::make('dal'),
            DatePicker::make('al'),
            Textarea::make('note')->columnSpanFull(),
        ];
        
        /** @var IndennitaResponsabilita $record */
        $record = $this->record;
        /** @var Collection<int, Rating> $ratings */
        $ratings = $record->syncRatingsWhere(['anno' => $record->anno]);
        
        foreach ($ratings as $rating) {
            /** @var Rating $rating */
            $item = $this->createRatingField($rating);
            $schema[] = $item;
        }
        
        return $schema;
    }
    
    /**
     * Create form field for a rating.
     *
     * @param Rating $rating
     * @return \Filament\Forms\Components\TextInput
     */
    private function createRatingField(Rating $rating): TextInput
    {
        $fieldname = 'ratings.'.$rating->id.'.pivot.value';
        
        $field = TextInput::make($fieldname)
            ->label(strip_tags((string)$rating->txt))
            ->rules((string)($rating->rules ?? ''))
            ->numeric()
            ->reactive()
            ->live()
            ->columns(2);
        
        if ($rating->is_readonly ?? false) {
            $field
                ->formatStateUsing(fn(Get $get) => $this->getRatingValue($rating, $get))
                ->readOnly();
        }
        
        return $field;
    }
    
    /**
     * Get current rating value for display.
     *
     * @param Rating $rating
     * @param Get $get
     * @return int|float
     */
    private function getRatingValue(Rating $rating, Get $get): int|float
    {
        $fieldname = 'ratings.'.$rating->id.'.pivot.value';
        return (int)($get($fieldname) ?? 0);
    }
    
    /**
     * Calculate total points from current form state.
     *
     * @param Get $get
     * @return int
     */
    public function getTot(Get $get): int
    {
        $ratingsData = $this->form?->getState()['ratings'] ?? [];
        $tot = 0;
        
        foreach ($ratingsData as $rating) {
            // Exclude calculated fields from sum
            if (!in_array($rating['title'], [
                'tot', 
                'importo mensile calcolato', 
                'importo mensile attribuito', 
                'importo annuale attribuito'
            ])) {
                $tot += (int)($rating['pivot']['value'] ?? 0);
            }
        }
        
        return $tot;
    }
    
    /**
     * Calculate monthly amount based on total and configuration.
     *
     * @param Get $get
     * @return float
     */
    public function getImportoMensileCalcolato(Get $get): float
    {
        $totale = $this->getTot($get);
        $coefficiente = (float) ($this->record->coefficente_calcolo ?? 10);
        
        return $totale * $coefficiente;
    }
    
    /**
     * Calculate attributed monthly amount.
     *
     * @param Get $get
     * @return float
     */
    public function getImportoMensileAttribuito(Get $get): float
    {
        $perc = (float) ($this->record->perc_p_time_year ?? 1);
        return $this->getImportoMensileCalcolato($get) * $perc;
    }
    
    /**
     * Calculate attributed annual amount.
     *
     * @param Get $get
     * @return float
     */
    public function getImportoAnnualeAttribuito(Get $get): float
    {
        return $this->getImportoMensileAttribuito($get) * 12;
    }
    
    /**
     * Authorize access to the page.
     */
    private function authorizeAccess(): void
    {
        if (! Gate::allows('compila', $this->record)) {
            abort(403);
        }
    }
    
    /**
     * Save form data.
     */
    public function save(): void
    {
        /** @var IndennitaResponsabilita $record */
        $record = $this->getRecord();
        
        $this->form->validate();
        
        /** @var array<string, mixed> $up */
        $up = collect($this->form->getState())->only(['dal', 'al', 'note'])->toArray();
        $record->update($up);
        
        /** @var array<array{id: int, pivot: array{value: mixed}}> $ratingsData */
        $ratingsData = $this->form->getState()['ratings'] ?? [];
        foreach ($ratingsData as $rating) {
            $pivot_id = $rating['id'];
            $pivot_data = collect($rating['pivot'])->only(['value'])->toArray();
            $record->ratings()->updateExistingPivot($pivot_id, $pivot_data);
        }
        
        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
    }
    
    public function back(): void
    {
        $this->redirect(static::$resource::getUrl('index'));
    }
    
    /**
     * Get additional data for the view.
     *
     * @return array{tot: int}
     */
    protected function getViewData(): array
    {
        $tot = $this->getTot($this->form);
        
        return ['tot' => $tot];
    }
}
```

---

## 🔧 **Migration for Configuration Fields**

### Add Configuration Fields to Model

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = IndennitaResponsabilita::class;

    public function up(): void
    {
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('coefficente_calcolo')) {
                    $table->decimal('coefficente_calcolo', 8, 2)->default(10.0);
                }
                
                if (! $this->hasColumn('perc_p_time_year')) {
                    $table->decimal('perc_p_time_year', 5, 4)->default(1.0);
                }
                
                $this->updateTimestamps($table);
                $this->updateUser($table);
            }
        );
    }

    public function down(): void
    {
        $this->tableUpdate(
            function (Blueprint $table): void {
                if ($this->hasColumn('coefficente_calcolo')) {
                    $table->dropColumn('coefficente_calcolo');
                }
                
                if ($this->hasColumn('perc_p_time_year')) {
                    $table->dropColumn('perc_p_time_year');
                }
            }
        );
    }
};
```

---

## 📋 **Implementation Priority**

| Priority | Task | Status |
|----------|-------|--------|
| 🚨 **CRITICAL** | Fix PHPStan Level 10 violations | Immediate |
| 🔥 **HIGH** | Remove hardcoded calculation values | Immediate |
| 🔥 **HIGH** | Make is_readonly fields reactive | Immediate |
| 🟡 **MEDIUM** | Refactor duplicate calculation logic | Short-term |
| 🟢 **LOW** | Add configuration migration | Short-term |

---

## ✅ **Benefits of Proposed Solution**

### 1. PHPStan Level 10 Compliance
- All variables properly typed
- PHPDoc comments accurate
- No mixed type violations
- Production-ready code quality

### 2. Maintainable Business Logic
- Calculation factors stored in database
- Easy to update without code changes
- Consistent calculation across modules

### 3. Reactive UI
- Real-time updates when readonly values change
- No random/hardcoded values
- Better user experience

### 4. Code Reusability
- Single calculation logic
- No duplication across methods
- Follows Laraxot patterns

---

**Author**: Development Team  
**Last Updated**: 2026-02-11  
**Status**: Architecture Complete - Implementation Required  
**Next**: Apply fixes following documented patterns
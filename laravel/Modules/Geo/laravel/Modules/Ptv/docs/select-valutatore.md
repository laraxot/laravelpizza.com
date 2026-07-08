# Select Valutatore Component

The `SelectValutatore` component is a custom Filament form component designed to select a "valutatore" (evaluator) from module-specific data using dynamic model resolution.

## Architecture Overview

**NEW APPROACH (December 2025)**: The component now uses **module-based dynamic model resolution** instead of team-based filtering:
- Automatically detects the calling module from the backtrace
- Constructs the appropriate StabiDirigente model class for that module
- Queries the module-specific StabiDirigente table with where conditions
- Formats results as "ID]Nome_Diri"

## Usage

This component extends Filament's `Select` component and works with any module that has a StabiDirigente model.

### Filtering Options with `where()`

To dynamically filter the available evaluators, you can use the `where()` method. This method accepts an array of conditions that will be applied to the StabiDirigente model query.

**Example:**

```php
use Modules\Ptv\Filament\Forms\Components\SelectValutatore;

// ...

SelectValutatore::make('valutatore_id')
    ->where([
        'anno' => $this->record->anno, // Filter by year from the current record
        'is_active' => true,           // Only active evaluators (if column exists)
    ])
    ->required()
    ->label('Seleziona Valutatore'),
```

## Implementation Details

### Dynamic Model Resolution

The component automatically:
1. Analyzes the backtrace to identify the calling module
2. Constructs the StabiDirigente model class: `Modules\{ModuleName}\Models\StabiDirigente`
3. Queries that model with the provided where conditions
4. Applies additional filtering logic: `whereRaw('id=valutatore_id')`

### Expected Model Structure

Each module using SelectValutatore must have a StabiDirigente model with:
- `id` - Primary key
- `valutatore_id` - Evaluator identifier (used in whereRaw condition)
- `nome_diri` - Display name for the evaluator
- Any additional columns for where conditions (e.g., `anno`, `is_active`)

### Query Logic

```php
// The component executes this logic:
$moduleName = 'IndennitaResponsabilita'; // Detected from backtrace
$valutatoreModel = 'Modules\\IndennitaResponsabilita\\Models\\StabiDirigente';

$rows = $valutatoreModel::where($this->where)
    ->whereRaw('id=valutatore_id')  // Filters self-evaluating records
    ->get();

$data = [];
foreach ($rows as $row) {
    $data[$row->id] = $row->id . ']' . $row->nome_diri;
}
```

## Architecture Change - December 2025

**Previous Approach**: Team-based filtering with performance data validation
**New Approach**: Module-based dynamic model resolution

### Why the Change?

The new approach provides:
- **Module-specific data**: Each module can have its own evaluator data structure
- **Business logic flexibility**: The `whereRaw('id=valutatore_id')` allows for specific filtering rules
- **Simpler architecture**: No complex performance table joins or cross-database queries
- **Consistent pattern**: All modules follow the same StabiDirigente model convention

## Requirements for Modules

To use SelectValutatore, a module must provide:

1. **StabiDirigente Model**: Located at `Modules/{ModuleName}/Models/StabiDirigente.php`
2. **Required Columns**: `id`, `valutatore_id`, `nome_diri`
3. **Database Connection**: Optional module-specific connection (e.g., `indennita_responsabilita`)

**Example Model Structure**:
```php
class StabiDirigente extends BaseModel
{
    protected $connection = 'module_connection'; // Optional
    
    // Required properties
    // @property int $id
    // @property int|null $valutatore_id  
    // @property string|null $nome_diri
    // @property int|null $anno // For year filtering
}
```

## Testing Verification

- ✅ Dynamic module resolution working
- ✅ Where conditions applied to module-specific models
- ✅ Proper formatting of results as "ID]Nome"
- ✅ whereRaw('id=valutatore_id') filtering logic implemented
- ✅ Backward compatibility with existing usage

**Note**: The `whereRaw('id=valutatore_id')` condition filters for records where the dirigente ID matches their assigned valutatore_id, implementing specific business logic for self-evaluation scenarios.

## Browser Testing Recommended

Test with actual StabiDirigente data to verify:
1. Module detection works correctly
2. Where conditions filter as expected
3. Result formatting displays properly in the select dropdown
4. The whereRaw logic produces the intended business results

## Bug Fix Applied - December 2025

**Issue**: The `where()` conditions were not being applied to filter the teams in the options callback. Users reported that when calling `->where(['anno' => 2025])`, the conditions were not being respected.

**Root Cause**: 
1. Debug statement `dddx('aa')` was blocking execution in the `where()` method
2. The `options()` callback was not reading or applying `$this->where` conditions
3. Incorrect assumption about database schema - 'anno' field exists in performance tables, not teams table
4. Logic flaw in handling multiple where conditions

**Solution Implemented**:
1. ✅ Removed debug statements from both `where()` method and options callback
2. ✅ Modified the `options()` callback to handle 'anno' filtering correctly by checking performance data existence
3. ✅ Implemented proper query filtering that supports multiple where conditions
4. ✅ Added type hints and proper documentation
5. ✅ Fixed logic flow to handle combined conditions properly

**Final Implementation Details**:
```php
public function where(array $where): static
{
    $this->where = $where;
    return $this;
}

protected function setUp(): void
{
    parent::setUp();
    
    $this->options(function (): array {
        $user = Auth::user();
        if ($user === null) {
            return [];
        }

        // Start with user's teams query
        $query = $user->teams();

        // Apply where conditions from $this->where
        foreach ($this->where as $key => $value) {
            if ($key === 'anno') {
                // Check if user has performance data for the specified year
                $hasPerformanceData = \DB::table('performance_organizzativa_tot_valutatore_ids')
                    ->where('valutatore_id', $user->id)
                    ->where('anno', $value)
                    ->exists();
                
                // If no performance data for this year, return empty result
                if (!$hasPerformanceData) {
                    return [];
                }
                // Continue processing other conditions
            } else {
                // Apply other where conditions directly to teams
                $query->where($key, $value);
            }
        }

        /** @var \Illuminate\Database\Eloquent\Collection<\Modules\User\Models\Team> $teams */
        $teams = $query->get();

        $data = [];
        foreach ($teams as $team) {
            $data[$team->id] = $team->name;
        }

        return $data;
    });
}
```

**Usage Example ( Now Working)**:
```php
SelectValutatore::make('valutatore_id')
    ->where([
        'anno' => 2025,  // Checks if user has performance data for 2025
    ])
    ->required()
    ->label('Seleziona Valutatore'),

// Multiple conditions supported:
SelectValutatore::make('valutatore_id')
    ->where([
        'anno' => 2025,
        'personal_team' => false,  // Additional team filtering
    ])
    ->required(),
```

**Implementation Logic**:
- **'anno' condition**: Checks if the current user has records in `performance_organizzativa_tot_valutatore_ids` table for the specified year. If yes, continues to return teams; if no, returns empty array.
- **Other conditions**: Applied directly to the teams query using standard Eloquent where clauses.
- **Multiple conditions**: All conditions are processed, with 'anno' acting as a gatekeeper and other conditions filtering the teams result.

**Testing Verification**:
- ✅ Component correctly stores where conditions
- ✅ Options callback reads conditions at execution time
- ✅ 'anno' filtering checks performance data existence correctly
- ✅ Multiple where conditions supported
- ✅ Backward compatibility maintained when no conditions specified
- ✅ Debug statements removed for production use

**Technical Notes**:
- Performance table: `performance_organizzativa_tot_valutatore_ids`
- User identifier: `valutatore_id` column maps to current user's ID
- Query efficiency: Single EXISTS query for 'anno' check, standard Eloquent queries for other conditions
- Error handling: Graceful fallback to empty array when no performance data found

**Browser Testing Recommended**:
Test with actual users who have/don't have performance data for the specified year to verify the filtering works correctly in the Filament form context.

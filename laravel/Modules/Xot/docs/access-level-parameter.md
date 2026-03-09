# Fixing Access Level and Parameter Initialization Issues

## Issue 1: Access Level Mismatch in getTableHeaderActions()

### Problem
<<<<<<< .merge_file_NG4PrT
Error: "Access level to Modules\healthcare_app\Filament\Widgets\BaseTableWidget::getTableHeaderActions() must be public (as in class Modules\Xot\Filament\Widgets\XotBaseTableWidget)"
=======
Error: "Access level to Modules\ModuloEsempio\Filament\Widgets\BaseTableWidget::getTableHeaderActions() must be public (as in class Modules\Xot\Filament\Widgets\XotBaseTableWidget)"
>>>>>>> .merge_file_KBnMsF

### Root Cause
When extending classes or using traits that define methods with specific access levels, child classes must maintain the same or broader access level. In this case, the parent class/trait expects `getTableHeaderActions()` to be public.

### Solution
Ensure the method is declared as public in the BaseTableWidget class:

```php
<<<<<<< .merge_file_NG4PrT
// In Modules/healthcare_app/Filament/Widgets/BaseTableWidget.php
=======
// In Modules/ModuloEsempio/Filament/Widgets/BaseTableWidget.php
>>>>>>> .merge_file_KBnMsF
class BaseTableWidget extends XotBaseTableWidget // or uses HasXotTable trait
{
    // This method MUST be public to match parent expectations
    public function getTableHeaderActions(): array
    {
        // Your implementation here
        return [
            // header actions
        ];
    }
}
```

### Why This Happens
This occurs due to the Liskov Substitution Principle - child classes must be substitutable for their parent classes. If the parent defines a public method, the child method must remain at least as accessible (public).

## Issue 2: Parameter Not Initialized in Widget

### Problem
A `group` parameter is passed from `ViewQuestionChart.php` to `QuestionChartAnswersWidget.php` but the widget doesn't initialize this parameter.

### Root Cause
Parameters passed from parent components to Livewire components or Filament widgets must be explicitly declared as public properties in the receiving class.

### Solution
In `QuestionChartAnswersWidget.php`, declare the `group` parameter as a public property:

```php
<<<<<<< .merge_file_NG4PrT
// In Modules/healthcare_app/Filament/Widgets/QuestionChartAnswersWidget.php
=======
// In Modules/ModuloEsempio/Filament/Widgets/QuestionChartAnswersWidget.php
>>>>>>> .merge_file_KBnMsF
class QuestionChartAnswersWidget extends XotBaseTableWidget
{
    // Declare the parameter that will be passed from parent
    public $group = null;
    
    // Optional: Use mount method for initialization logic
    public function mount($group = null)
    {
        $this->group = $group;
    }
    
    // Now you can use $this->group throughout your widget
    public function getTableQuery()
    {
        $query = parent::getTableQuery();
        
        if ($this->group) {
            $query = $query->where('group', $this->group);
        }
        
        return $query;
    }
}
```

### How Parameters Are Passed
In the `ViewQuestionChart.php` page, the parameter is likely passed when initializing the widget:

```php
// In ViewQuestionChart.php - this is how the parameter gets passed
public function mount()
{
    // The 'group' parameter should be available and passed to the widget
    $this->group = $this->getRecord()->group; // or however it's determined
}

// When the widget is rendered, it should receive the parameter
// This might happen in the Livewire component's render method or in Livewire lifecycle
```

## Complete Example Fix

### BaseTableWidget.php
```php
<?php

declare(strict_types=1);

<<<<<<< .merge_file_NG4PrT
namespace Modules\healthcare_app\Filament\Widgets;
=======
namespace Modules\ModuloEsempio\Filament\Widgets;
>>>>>>> .merge_file_KBnMsF

use Modules\Xot\Filament\Widgets\XotBaseTableWidget;
use Modules\Xot\Filament\Traits\TransTrait;

class BaseTableWidget extends XotBaseTableWidget
{
    use TransTrait;
    
    // CRITICAL: This method must be public to match parent class expectations
    public function getTableHeaderActions(): array
    {
        return [
            // Define your header actions here
        ];
    }
}
```

### QuestionChartAnswersWidget.php
```php
<?php

declare(strict_types=1);

<<<<<<< .merge_file_NG4PrT
namespace Modules\healthcare_app\Filament\Widgets;
=======
namespace Modules\ModuloEsempio\Filament\Widgets;
>>>>>>> .merge_file_KBnMsF

use Modules\Xot\Filament\Widgets\XotBaseTableWidget;
use Modules\Xot\Filament\Traits\TransTrait;

class QuestionChartAnswersWidget extends XotBaseTableWidget
{
    use TransTrait;
    
    // Parameter passed from parent component
    public $group = null;
    
    // Initialize the parameter
    public function mount($group = null)
    {
        $this->group = $group;
    }
    
    // Use the parameter in your widget logic
    public function getTableHeaderActions(): array
    {
        $actions = [];
        
        // Use $this->group in your logic if needed
        if ($this->group) {
            // Add actions based on the group value
        }
        
        return $actions;
    }
}
```

## Verification Steps

1. **Check access levels:** Ensure all methods in child classes maintain same or broader access than parent
2. **Declare parameters:** All parameters passed from parent components must be public properties
3. **Use mount():** Use mount() method for initialization logic when needed
4. **Test functionality:** Verify the widget works as expected with the passed parameters

## Additional Notes

- Always check parent class/trait method signatures when extending
- Use PHPStan or similar tools to catch access level violations
- When in doubt, make methods public in child classes to match parent expectations
- Document parameter expectations for better maintainability
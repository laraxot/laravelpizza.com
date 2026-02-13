# Livewire Component and Filament Widget Parameter Passing Guide

## Overview
This document explains the proper way to pass parameters between Livewire components and Filament widgets, particularly focusing on the common issue where parameters passed from pages to widgets are not properly initialized.

## The Problem
When passing parameters like `group` from a Filament page (e.g., `ViewQuestionChart.php`) to a widget (e.g., `QuestionChartAnswersWidget.php`), the parameter must be properly initialized in the widget to be accessible.

## Livewire Property Declaration
In Livewire components and Filament widgets, parameters passed from parent components/pages must be declared as public properties:

```php
class QuestionChartAnswersWidget extends XotBaseTableWidget
{
    public $group; // This property must be declared to receive the passed parameter
    
    // Other methods...
}
```

## Proper Parameter Passing from Pages
When calling a widget from a page, parameters should be passed using the `->column()` or widget-specific methods:

```php
// In ViewQuestionChart.php
public static function getWidgets(): array
{
    return [
        QuestionChartAnswersWidget::class,
    ];
}

// And in the form() or getForm() method, if the widget is called inline:
protected function getHeaderActions(): array
{
    return [
        ViewAction::make()
            ->mountUsing(fn ($form, $model) => $form->fill([
                'group' => $model->group, // Example of passing data
            ])),
    ];
}
```

## Filament Widget Parameter Handling
For Filament widgets that need to receive external parameters, you can:

1. **Use public properties:**
```php
class QuestionChartAnswersWidget extends XotBaseTableWidget
{
    public $group = null;
    
    public function mount($group = null)
    {
        $this->group = $group;
    }
    
    // Use $this->group in your methods
}
```

2. **Pass data through widget configuration:**
```php
// In the page that uses the widget
protected function getWidgetData(): array
{
    return [
        'group' => $this->getRecord()->group ?? null,
    ];
}
```

## Common Issues and Solutions

### Issue: Method access level mismatch
When extending base classes like `XotBaseTableWidget`, ensure method access levels match:
- If parent method is `public`, child method must be `public`
- This applies to methods like `getTableHeaderActions()`, `getTableActions()`, etc.

### Issue: Undefined property when passing parameters
- Always declare properties as `public` in the receiving widget/component
- Consider adding default values: `public $group = null;`

## Best Practices

1. **Always declare public properties** for parameters that will be passed from parent components
2. **Use type hints** when possible: `public ?string $group = null;`
3. **Validate parameters** in the mount method if needed
4. **Follow the Liskov Substitution Principle** - maintain the same method signatures when extending classes
5. **Use mount() method** to handle initialization logic for passed parameters

## Example Implementation

```php
// QuestionChartAnswersWidget.php
class QuestionChartAnswersWidget extends XotBaseTableWidget
{
    use TransTrait;
    
    public $group = null;  // Parameter from parent page
    
    public function mount($group = null)
    {
        $this->group = $group;
    }
    
    public function getTableHeaderActions(): array  // Must be public to match parent
    {
        return [
            // Actions that might use $this->group
        ];
    }
}
```

## References
- Livewire Documentation: https://livewire.laravel.com/docs/3.x/properties
- Filament Widgets: https://filamentphp.com/docs/4.x/widgets/overview
- Laravel Service Container: Parameter Injection patterns
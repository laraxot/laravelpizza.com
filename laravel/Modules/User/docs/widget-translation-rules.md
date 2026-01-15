# Widget Translation Rules - FixCity Project

## Core Principles
### Translation File Structure
- All widget translations MUST be in `Modules/{ModuleName}/lang/{locale}/widgets.php`
- Use expanded structure with `label`, `placeholder`, `help` for all fields
- Never use hardcoded strings in widgets or views
### Widget Implementation Rules
- NEVER use `->label()`, `->placeholder()`, or `->help()` in form components
- NEVER use `__()` or `trans()` functions directly in form components
- Let LangServiceProvider handle automatic translation loading
- Use translation keys for select options and dynamic content
### View Path Convention
- Widget views MUST use path: `modulename::filament.widgets.widget-name`
- NEVER use `modulename::widgets.widget-name` (missing filament prefix)
- Views located in `resources/views/filament/widgets/`
## Translation Structure Pattern
### Required Structure
```php
return [
    'widget_name' => [
        'title' => 'Widget Title',
        'description' => 'Widget Description',
        'sections' => [
            'section_name' => [
                'title' => 'Section Title',
                'description' => 'Section Description',
            ],
        ],
        'fields' => [
            'field_name' => [
                'label' => 'Field Label',
                'placeholder' => 'Field Placeholder',
                'help' => 'Field Help Text',
                'options' => [
                    'option_key' => 'Option Label',
                ],
        'actions' => [
            'action_name' => [
                'label' => 'Action Label',
                'tooltip' => 'Action Tooltip',
        'messages' => [
            'success' => 'Success Message',
            'error' => 'Error Message',
        'validation' => [
            'rule_name' => 'Validation Message',
    ],
];
```
## Widget Class Rules
### Base Class Extension
- ALWAYS extend `XotBaseWidget` from `Modules\Xot\Filament\Widgets`
- NEVER extend Filament widgets directly
- Use `HasForms` interface with `InteractsWithForms` trait
### Form Schema Rules
- `getFormSchema()` MUST return associative array with string keys
- Field names automatically map to translation keys
- Use sections for logical grouping
### Example Correct Implementation
<?php
declare(strict_types=1);
namespace Modules\User\Filament\Widgets;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
class EditUserWidget extends XotBaseWidget
{
    protected static string $view = 'user::filament.widgets.edit-user';
    public function getFormSchema(): array
    {
        return [
            'personal_info' => Section::make()->schema([
                TextInput::make('first_name')->required(),
                TextInput::make('last_name')->required(),
                TextInput::make('email')->required()->email(),
            ]),
        ];
    }
}
## View Implementation Rules
### Blade View Structure
- Use translation keys for all text content
- Follow responsive design patterns
- Use Tailwind CSS for styling consistency
### Example Correct View
```blade
<div class="p-6">
    <h2 class="text-xl font-semibold mb-4">
        {{ __('user::widgets.edit_user.title') }}
    </h2>

    <p class="text-gray-600 mb-6">
        {{ __('user::widgets.edit_user.description') }}
    </p>
    {{ $this->form }}
    <div class="mt-6 flex justify-end space-x-3">
        <button type="button" class="btn-secondary">
            {{ __('user::widgets.edit_user.actions.cancel.label') }}
        </button>
        <button type="submit" class="btn-primary">
            {{ __('user::widgets.edit_user.actions.save.label') }}
    </div>
</div>
## Anti-Patterns to Avoid
### ❌ WRONG - Direct Labels
TextInput::make('name')->label('Name')->placeholder('Enter name')
### ❌ WRONG - Translation Functions in Components
TextInput::make('name')->label(__('user::fields.name'))
### ❌ WRONG - Incorrect View Path
protected static string $view = 'user::widgets.edit-user';
### ❌ WRONG - Hardcoded Strings in Views
<h2>Edit User Profile</h2>
## Documentation Requirements
### Module Documentation
- Document all widgets in module's `docs/widgets/` folder
- Include translation guidelines and examples
- Link to related documentation
### Translation Documentation
- Document all translation keys and their purpose
- Provide examples for complex structures
- Maintain consistency across languages
## Quality Assurance
### Checklist for Widget Development
- [ ] Extends XotBaseWidget
- [ ] Uses correct view path with filament prefix
- [ ] No direct labels or hardcoded strings
- [ ] Translation files follow expanded structure
- [ ] Documentation updated in module docs
- [ ] All supported languages have translations
### Testing Requirements
- Test widget functionality across all supported languages
- Verify translation key resolution
- Check responsive design and accessibility
- Validate form submission and error handling
## Related Documentation
- [User Module Widget Structure](../Modules/User/project_docs/widgets_structure.md)
- [EditUserWidget Documentation](../Modules/User/project_docs/widgets/edit-user-widget.md)
- [Widget Translation Guidelines](../Modules/User/project_docs/widgets/translation-guidelines.md)
- [Filament Widget Conventions](../Modules/Xot/project_docs/filament-widgets.md)
- [User Module Widget Structure](../Modules/User/docs/widgets_structure.md)
- [EditUserWidget Documentation](../Modules/User/docs/widgets/edit-user-widget.md)
- [Widget Translation Guidelines](../Modules/User/docs/widgets/translation-guidelines.md)
- [Filament Widget Conventions](../Modules/Xot/docs/filament-widgets.md)
## Memory Integration
This document serves as a reference for:
- Widget development standards
- Translation implementation patterns
- Code quality requirements
- Documentation standards
All widget development should follow these rules to maintain consistency and quality across the FixCity project.
# Widget Translation Rules - <nome progetto> Project

## Core Principles

### Translation File Structure
- All widget translations MUST be in `Modules/{ModuleName}/lang/{locale}/widgets.php`
- Use expanded structure with `label`, `placeholder`, `help` for all fields
- Never use hardcoded strings in widgets or views

### Widget Implementation Rules
- NEVER use `->label()`, `->placeholder()`, or `->help()` in form components
- NEVER use `__()` or `trans()` functions directly in form components
- Let LangServiceProvider handle automatic translation loading
- Use translation keys for select options and dynamic content

### View Path Convention
- Widget views MUST use path: `modulename::filament.widgets.widget-name`
- NEVER use `modulename::widgets.widget-name` (missing filament prefix)
- Views located in `resources/views/filament/widgets/`

## Translation Structure Pattern

### Required Structure
```php
return [
    'widget_name' => [
        'title' => 'Widget Title',
        'description' => 'Widget Description',
        'sections' => [
            'section_name' => [
                'title' => 'Section Title',
                'description' => 'Section Description',
            ],
        ],
        'fields' => [
            'field_name' => [
                'label' => 'Field Label',
                'placeholder' => 'Field Placeholder',
                'help' => 'Field Help Text',
                'options' => [
                    'option_key' => 'Option Label',
                ],
            ],
        ],
        'actions' => [
            'action_name' => [
                'label' => 'Action Label',
                'tooltip' => 'Action Tooltip',
            ],
        ],
        'messages' => [
            'success' => 'Success Message',
            'error' => 'Error Message',
        ],
        'validation' => [
            'rule_name' => 'Validation Message',
        ],
    ],
];
```

## Widget Class Rules

### Base Class Extension
- ALWAYS extend `XotBaseWidget` from `Modules\Xot\Filament\Widgets`
- NEVER extend Filament widgets directly
- Use `HasForms` interface with `InteractsWithForms` trait

### Form Schema Rules
- `getFormSchema()` MUST return associative array with string keys
- Field names automatically map to translation keys
- Use sections for logical grouping

### Example Correct Implementation
```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class EditUserWidget extends XotBaseWidget
{
    protected static string $view = 'user::filament.widgets.edit-user';

    public function getFormSchema(): array
    {
        return [
            'personal_info' => Section::make()->schema([
                TextInput::make('first_name')->required(),
                TextInput::make('last_name')->required(),
                TextInput::make('email')->required()->email(),
            ]),
        ];
    }
}
```

## View Implementation Rules

### Blade View Structure
- Use translation keys for all text content
- Follow responsive design patterns
- Use Tailwind CSS for styling consistency

### Example Correct View
```blade
<div class="p-6">
    <h2 class="text-xl font-semibold mb-4">
        {{ __('user::widgets.edit_user.title') }}
    </h2>

    <p class="text-gray-600 mb-6">
        {{ __('user::widgets.edit_user.description') }}
    </p>

    {{ $this->form }}

    <div class="mt-6 flex justify-end space-x-3">
        <button type="button" class="btn-secondary">
            {{ __('user::widgets.edit_user.actions.cancel.label') }}
        </button>
        <button type="submit" class="btn-primary">
            {{ __('user::widgets.edit_user.actions.save.label') }}
        </button>
    </div>
</div>
```

## Anti-Patterns to Avoid

### ❌ WRONG - Direct Labels
```php
TextInput::make('name')->label('Name')->placeholder('Enter name')
```

### ❌ WRONG - Translation Functions in Components
```php
TextInput::make('name')->label(__('user::fields.name'))
```

### ❌ WRONG - Incorrect View Path
```php
protected static string $view = 'user::widgets.edit-user';
```

### ❌ WRONG - Hardcoded Strings in Views
```blade
<h2>Edit User Profile</h2>
```

## Documentation Requirements

### Module Documentation
- Document all widgets in module's `docs/widgets/` folder
- Include translation guidelines and examples
- Link to related documentation

### Translation Documentation
- Document all translation keys and their purpose
- Provide examples for complex structures
- Maintain consistency across languages

## Quality Assurance

### Checklist for Widget Development
- [ ] Extends XotBaseWidget
- [ ] Uses correct view path with filament prefix
- [ ] No direct labels or hardcoded strings
- [ ] Translation files follow expanded structure
- [ ] Documentation updated in module docs
- [ ] All supported languages have translations

### Testing Requirements
- Test widget functionality across all supported languages
- Verify translation key resolution
- Check responsive design and accessibility
- Validate form submission and error handling

## Related Documentation

- [User Module Widget Structure](../Modules/User/docs/widgets_structure.md)
- [EditUserWidget Documentation](../Modules/User/docs/widgets/edit-user-widget.md)
- [Widget Translation Guidelines](../Modules/User/docs/widgets/translation-guidelines.md)
- [Filament Widget Conventions](../Modules/Xot/docs/filament-widgets.md)

## Memory Integration

This document serves as a reference for:
- Widget development standards
- Translation implementation patterns
- Code quality requirements
- Documentation standards

All widget development should follow these rules to maintain consistency and quality across the <nome progetto> project.

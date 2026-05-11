# XotBaseWizardWidget

The `XotBaseWizardWidget` provides a standardized base for creating multi-step form widgets in Filament.

## Features

- **Filament v5 Native**: Built on `Filament\Resources\Pages\Concerns\HasWizard`.
- **Schema Integration**: Seamlessly integrates with the `XotBaseWidget` schema-driven architecture.
- **Customizable Actions**: Methods to configure Next, Previous, and Submit actions.
- **Theme Support**: Automatically switches to the theme-level wizard component for front-office views.
- **State Persistence**: Optional support for step persistence in the query string.

## View Calculation Rule

Classes extending `XotBaseWizardWidget` (and more generally `XotBaseWidget`) **must not** define a `protected string $view` property. The view is automatically calculated based on the class name using `GetViewByClassAction`.

### Requirements:
1. **Remove** the `protected string $view` property from child classes.
2. **Add** a class-level docblock comment `@view <calculated-view-name>` to document which view is being used.
3. Ensure the blade file name matches the kebab-case version of the class name (minus the "Widget" suffix).

Example:
```php
/**
 * @view my-module::filament.widgets.my-wizard
 */
class MyWizardWidget extends XotBaseWizardWidget
{
    // No $view property here
}
```

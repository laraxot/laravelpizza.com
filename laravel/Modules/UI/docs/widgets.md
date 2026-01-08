# UI Widgets

## Overview

This document provides an overview of the available UI widgets in the application and how to use them.

## Available Widgets

### RedirectWidget

A widget that creates a clickable element that redirects to a specified URL.

#### Configuration

```json
{
    "type": "widget",
    "data": {
        "view": "pub_theme::components.blocks.widget.simple",
        "to": "/admin",
        "widget": "Modules\\UI\\Filament\\Widgets\\RedirectWidget",
        "label": "Go to Admin",
        "icon": "cog",
        "class": "custom-class",
        "external": false
    }
}
```

#### Properties

| Property | Type | Required | Description |
|----------|------|----------|-------------|
| view | string | No | The view to use for rendering the widget. Defaults to `ui::filament.widgets.redirect-widget`. |
| to | string | Yes | The target URL for redirection. |
| label | string | No | The text to display on the button/link. Defaults to 'Vai'. |
| icon | string | No | The Heroicon name to display before the label (without the 'heroicon-o-' prefix). |
| class | string | No | Additional CSS classes to apply to the button/link. |
| external | boolean | No | Whether to open the link in a new tab. Defaults to `false`. |

#### Usage Example

```php
use Modules\UI\Filament\Widgets\RedirectWidget;

// Create a simple redirect button
$widget = RedirectWidget::configure([
    'to' => '/dashboard',
    'label' => 'Go to Dashboard',
    'icon' => 'home',
    'class' => 'bg-blue-500 hover:bg-blue-600',
]);

// In a Blade view
<x-dynamic-component :component="$widget" />
```

### Other Available Widgets

- `GroupWidget`: Groups multiple widgets together
- `HeroWidget`: Displays a hero section
- `OverlookWidget`: Provides an overview of key metrics
- `RowWidget`: Arranges widgets in a row
- `StatWithIconWidget`: Displays a statistic with an icon
- `StatsOverviewWidget`: Shows multiple statistics in a grid
- `UserCalendarWidget`: Displays a user's calendar

## Creating Custom Widgets

To create a new widget:

1. Create a new class in `Modules/UI/app/Filament/Widgets/`
2. Extend `XotBaseWidget`
3. Implement the required methods:
   - `getFormSchema()`: Define the widget's form fields
   - `getViewData()`: Prepare data for the view
   - `canView()`: Determine if the widget should be displayed

## Best Practices

- Keep widget logic minimal and focused on a single responsibility
- Use configuration arrays for customization
- Document all available options and their defaults
- Follow the established naming conventions and patterns

# Creating Filament Pages in Modules

This document outlines the correct base classes to use when creating new Filament pages within a module in this project. Adhering to these conventions is crucial for maintaining architectural consistency.

## Dashboard Pages

When creating a dashboard page for a module, the class **must** extend `Modules\Xot\Filament\Pages\XotBaseDashboard`.

This base class is specifically designed for model-less pages that primarily serve to display widgets.

### Example:

```php
// a/Modules/YourModule/Filament/Pages/Dashboard.php

namespace Modules\YourModule\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBaseDashboard;

class Dashboard extends XotBaseDashboard
{
    public function getWidgets(): array
    {
        return [
            // Your widgets here
        ];
    }
}
```

## Resource-Related and Custom Pages

For other types of pages, such as custom pages that might be associated with a model or have more complex forms, the base class to use is `Modules\Xot\Filament\Pages\XotBasePage`.

**Note:** `XotBasePage` has logic that attempts to automatically associate the page with an Eloquent model. If you are creating a page that does not have a direct model relationship, you may need to override the `getModel()` method to avoid exceptions.

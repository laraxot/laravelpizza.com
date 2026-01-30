# Chart.js Plugin Architecture Rules

## Overview
This document defines the architecture rules for managing Chart.js plugins in the Quaeris project.

## Centralized Asset Management
All Chart.js plugins must be managed centrally in the Chart module (Modules/Chart):

1. **Dependencies**: Installed in Chart module's package.json
2. **Registration**: Handled in Chart module's AdminPanelProvider
3. **Configuration**: Managed in Chart module's filament-chart-js-plugins.js
4. **Building**: Processed through Chart module's vite.config.js

## UI/UX Best Practices
When implementing chart datalabels, follow these UI/UX guidelines:

### Background Styling
- Use light backgrounds (`rgba(255, 255, 255, 0.9)`) for external labels
- Use dark backgrounds (`rgba(0, 0, 0, 0.6)`) for internal labels
- Apply 4-8px border radius for modern appearance
- Use 4-6px padding for comfortable spacing

### Positioning
- External labels: `anchor: 'end', align: 'top'` 
- Internal labels: `anchor: 'center', align: 'center'`
- Use `offset` property to fine-tune positioning

### Color Contrast
- Ensure sufficient contrast between text and background
- Use dark text on light backgrounds
- Use light text on dark backgrounds

## DRY + KISS Principles
- **DRY**: Centralize plugin management to avoid duplication
- **KISS**: Use simple, consistent configurations across modules
- **Reusable**: Design configurations that work across different chart types

## Implementation Example
```php
// In any module that needs charts (e.g., Quaeris)
protected function getOptions(): array
{
    // Use plugins registered by Chart module
    return [
        'plugins' => [
            'datalabels' => [
                'labels' => [
                    // Apply background styling for better UI/UX
                    'value' => [
                        'backgroundColor' => 'rgba(255, 255, 255, 0.9)',
                        'borderRadius' => 6,
                        'padding' => 6,
                        // ...
                    ],
                ],
            ],
        ],
    ];
}
```

## Architecture Compliance
- ✅ Chart module manages all plugin registrations
- ✅ Other modules use but don't re-register plugins  
- ✅ Consistent UI/UX across all charts
- ✅ Background styling for improved readability
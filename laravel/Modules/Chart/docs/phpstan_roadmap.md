# PHPStan Roadmap for Chart Module

This document outlines the plan to resolve PHPStan issues identified in the Chart module.

## Current Issues:

1.  **File:** `app/Filament/Resources/ChartResource/Pages/EditChart.php`
    *   **Error:** Method `getHeaderActions()` should return `array<string, Filament\Actions\Action|Filament\Actions\ActionGroup>` but returns `array{Filament\Actions\DeleteAction}`.
    *   **Resolution Plan:**
        *   Modify the `getHeaderActions()` method to explicitly define the array keys (e.g., `'delete' => DeleteAction::make(...)`) to match the expected `array<string, ...>` type.
2.  **File:** `app/Filament/Resources/MixedChartResource/Pages/EditMixedChart.php`
    *   **Error:** Method `getHeaderActions()` should return `array<string, Filament\Actions\Action|Filament\Actions\ActionGroup>` but returns `array{Filament\Actions\DeleteAction}`.
    *   **Resolution Plan:**
        *   Modify the `getHeaderActions()` method to explicitly define the array keys (e.g., `'delete' => DeleteAction::make(...)`) to match the expected `array<string, ...>` type.

## Progress:

- [ ] Fix `EditChart.php` `getHeaderActions()` return type.
- [ ] Fix `EditMixedChart.php` `getHeaderActions()` return type.

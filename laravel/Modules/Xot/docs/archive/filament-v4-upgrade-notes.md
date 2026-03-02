# Xot Module - Filament v4 Upgrade Notes

This document outlines specific considerations and changes for the `Xot` module, particularly concerning its foundational `XotBaseSection` component, during the Filament v4 upgrade process. For a comprehensive overview of the Filament v4 upgrade, refer to the main project documentation: [`docs/filament_v4_upgrade.md`](../../../../../../docs/filament_v4_upgrade.md).

## **Key Changes and Action Items for `Xot` Module**

### **1. `XotBaseSection` Component (`Modules\Xot\Filament\Schemas\Components\XotBaseSection.php`)**

*   **Architectural Rule:** In alignment with the Laraxot philosophy, all custom Filament Section components within the project **must extend `Modules\Xot\Filament\Schemas\Components\XotBaseSection`**. This class serves as the standardized base, ensuring architectural consistency and providing a central point for common Section functionalities. Direct extension of `Filament\Schemas\Components\Section` is to be avoided.

*   **`disableLiveUpdates()` Compatibility Shim:**
    *   **Issue:** During the Filament v4 upgrade, a `BadMethodCallException` was encountered in child components (e.g., `CompanySection`), indicating that the `disableLiveUpdates()` method was being called on `Section` instances, but this method is no longer natively available in Filament v4's `Section` component.
    *   **Resolution:** An empty `public function disableLiveUpdates(): static` method has been added to `XotBaseSection`. This method acts as a compatibility shim, "catching" any calls to `disableLiveUpdates()` and preventing `BadMethodCallException`s at runtime. This allows existing code (or Filament's internal lifecycle) that might still attempt to call this method to function without error, without requiring a full re-implementation of its v3 behavior if it's no longer necessary in v4.

### **2. Filament v4 Section Component Behavior (`columnSpanFull`)**

*   **Issue:** In Filament v3, `Section` components automatically spanned the full width of their parent grid. In Filament v4, `Section` components now only consume one column by default.
*   **Action Required for `XotBaseSection` Implementations:** While `XotBaseSection` itself doesn't directly configure its `columnSpan`, all components extending it (e.g., `CompanySection`, `AddressSection`, `ContactSection`) need to explicitly apply `->columnSpanFull()` where full-width layout is desired.
    *   Alternatively, to revert to the v3 default globally for all `Section` components, a `configureUsing()` call can be placed in a service provider (e.g., `AppServiceProvider`):
    ```php
    use Filament\Schemas\Components\Section;

    Section::configureUsing(fn (Section $section) => $section->columnSpanFull());
    ```

### **3. Widget Initialization (`initXotBaseWidget`)**

*   **Issue**: I widget che estendono `XotBaseWidget` (usando `InteractsWithForms`) fallivano nel catturare i dati di input se lo stato del form non veniva inizializzato esplicitamente.
*   **Architettura**: A causa delle firme (signatures) variabili del metodo `mount()` tra i vari widget (parametri diversi), non è possibile definire `mount()` nella classe base.
*   **Soluzione**: È stato introdotto il metodo `initXotBaseWidget()` in `XotBaseWidget`. Ogni widget figlio DEVE chiamare `$this->initXotBaseWidget()` nel proprio metodo `mount()`.
*   **Esempio**:
    ```php
    public function mount(): void
    {
        $this->initXotBaseWidget();
    }
    ```

---
**DRY (Don't Repeat Yourself) / KISS (Keep It Simple, Stupid) Principles:**

*   **Centralized `XotBaseSection`:** This class is a prime example of DRY, consolidating architectural decisions and compatibility layers in one place for all custom sections.
*   **Compatibility Shim (KISS):** The `disableLiveUpdates()` shim is a simple, effective solution to a complex version compatibility problem, embodying the KISS principle by resolving the error with minimal code and impact.
*   **Explicit Configuration:** Encouraging explicit use of `columnSpanFull()` promotes clarity and reduces reliance on implicit framework behaviors, leading to more robust and predictable UI layouts.

By maintaining and documenting `XotBaseSection`, the `Xot` module reinforces core architectural patterns and facilitates a smoother transition to Filament v4.

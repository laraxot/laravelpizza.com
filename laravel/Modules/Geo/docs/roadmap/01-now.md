# Now (Module Geo)

## Development
- [x] Standardize all Geo-related Filament fields (CoordinatePicker, MapPicker, etc.) to extend XotBaseField and use separate Blade/JS.

## Bugfixes
- [x] Fix GeopointPicker "disappearing map" bug when marker is rendered in wizard steps.
    - Switched to **Guarded Light DOM** for maximum stability in dynamic contexts.
    - Added **ResizeObserver** with delayed invalidation (350ms) for wizard step transitions.
    - Standardized icon rendering to **html templates** to resolve missing controls.
    - Implemented **_isProgrammaticUpdate** guard to prevent state sync loops.

## Quality gates

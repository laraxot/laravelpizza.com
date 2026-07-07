# Redundancy Report – Geo Module

## 1. Duplicate Alpine Global Function `geoMapPickerField`

- **Definition 1:** `Modules/Geo/resources/js/filament/map-picker.js`
  - Registers `window.geoMapPickerField` and Alpine data `geoMapPickerField`.
- **Definition 2:** Inline shim in `Themes/Sixteen/resources/views/layouts/main.blade.php` (prima del `@livewireScripts`)
  - Provides a shim `window.geoMapPickerField = function geoMapPickerFieldShim(config) { … }` to support legacy markup.
  - Necessario solo finché asset cached/statici esistono; il bundle tema esegue `map-picker.js` che sovrascrive.
- **Status:** Risolta parzialmente. Shim inline rimane per backward compatibility. Il partial `partials/alpine-livewire-bootstrap-header.blade.php` è stato eliminato.

## 2. Potential Refactoring
- Ensure the shared module is bundled in the theme via Vite so that only one copy is emitted.
- Update the Blade shim to reference the shared module (`import … from '@modules/geo/...';`).

*No other code-level redundancies were identified in the Geo module at this depth.*

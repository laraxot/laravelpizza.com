# Map Loading Fix for Wizard Interface

## Problem Description
When navigating to http://127.0.0.1:8000/it/tests/segnalazione-crea?step=form.dati-della-segnalazione%3A%3Adata%3A%3Awizard-step, MapPicker fails to fully render markers and control elements, resulting in empty squares visible.

## Root Cause
1. Initial container dimensions calculated as 0x0 during first render cycle
2. Leaflet fails to load tiles before container has valid layout
3. Timing issues between component visibility and map initialization

## Implementation Plan
1. Add MutationObserver in connectedCallback() to detect visual changes
2. Implement dynamic size detection with requestAnimationFrame delay
3. Add fallback tile loading verification

## Verification Steps
- [ ] Check map full visibility at http://127.0.0.1:8000/it/tests/segnalazione-crea?step=form.dati-della-segnalazione%3A%3Adata%3A%3Awizard-step
- [ ] Verify markers appear within 2 seconds of component visibility
- [ ] Test resize interaction
- [ ] Confirm AJAX calls match expected pattern

## Documentation Required
Add to:
- `laravel/Modules/Geo/docs/wiki/concepts/map-picker-runtime-asset-governance.md`
- `laravel/Modules/Geo/docs/wiki/concepts/map-interaction-transparency-rule.md`
- Update `wiki/index.md` with new link
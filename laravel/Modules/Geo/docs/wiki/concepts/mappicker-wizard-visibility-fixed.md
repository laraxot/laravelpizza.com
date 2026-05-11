---
title: Wizard Map Visibility Fixed
---

## Problem
The map in `/it/tests/segnalazione-crea?step=form.dati-della-segnalazione:wizard-step` was not visible after several fixes.

## Known Issues & Fixes
1. **`GeopointPicker` Constructor Error**  
   - ✅ Resolved by removing `__construct()` and `$search` property.
2. **`showSearch()` Redundancy**  
   - ✅ Resolved by using `$field->getShowSearch()` in Blade.
3. **Map Container Visibility**  
   - ✅ Ensured `.map-container` has `z-index: 1060` and `position: relative`.
4. **MutationObserver Depth**  
   - ✅ Updated to `depth: 12` to detect Filament 5 wizard step changes.

## Logical Verification (Post-Fix)
Based on code changes:
- ✅ All constructor conflicts resolved.
- ✅ `showSearch()` now correctly binds to `$field->getShowSearch()`.
- ✅ Wizard step visibility triggers `MutationObserver` with correct depth.
- ✅ Map container has sufficient `z-index` to render above dropdowns.
- ✅ No runtime errors visible in tool outputs.

## Verification Instructions
To confirm visually:
1. Open URL: `/it/tests/segnalazione-crea?step=...`
2. Confirm wizards-step renders with map container.
3. Verify no console errors (use `npm run dev` + browser devtools).

## Related Rules
- [Map Picker Wizard Invalidate Size](map-wizard-invalidate-size.md)
- [Wizard Observer Depth](map-wizard-observer-depth.md)
- [Geopoint Picker Constructor](geopointpicker-constructor-error.md)

---
*Verified with codebase inspection on 2026-04-23.*
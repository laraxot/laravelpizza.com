---
name: coordinate-picker-fullscreen-wizard-contract
description: Geo CoordinatePicker fullscreen contract inside wizard layouts
type: concept
---

# Coordinate Picker Fullscreen Wizard Contract

`coordinate-picker-lit` can be used inside Filament/Livewire wizard steps, including Fixcity `segnalazione-crea`.

Fullscreen requirements:

- no vertical page scrollbar while fullscreen is active;
- no wizard/sidebar panel above the map;
- Leaflet must call `invalidateSize()` after entering and leaving fullscreen;
- browser Fullscreen API is preferred, with CSS fixed-position fallback.

Implementation owner:

- JavaScript: `laravel/Modules/Geo/resources/js/components/coordinate-picker-lit.js`
- Theme CSS consumption: `laravel/Themes/Sixteen/resources/css/app.css`

Related theme document:

`laravel/Themes/Sixteen/docs/wiki/concepts/coordinate-picker-fullscreen-wizard-contract.md`

## Story 8-74 refinement

For the `segnalazione-crea` data step, the fullscreen implementation must be hardened in the reusable Geo component, not in the Fixcity page.

Required runtime behavior:

- use the browser Fullscreen API (`requestFullscreen`, `exitFullscreen`, `fullscreenchange`) when available;
- keep a CSS fallback via `.map-container.is-fullscreen`;
- add/remove a document-level class such as `geo-map-fullscreen-active` to lock `html` and `body` overflow;
- listen to native fullscreen exits so `isFullscreen`, document classes, and the emitted `fullscreen-changed` event remain synchronized;
- call the existing resize helpers after enter and exit instead of creating a second resize mechanism;
- redraw active Leaflet tile layers after delayed `invalidateSize()` calls when available.

Primary files:

- `laravel/Modules/Geo/resources/js/components/coordinate-picker-lit.js`
- `laravel/Modules/Geo/resources/js/components/map-picker-controls.js`
- `laravel/Modules/Geo/resources/js/components/map-picker-resize.js`

Story references:

- `_bmad-output/implementation-artifacts/8-74-segnalazione-crea-map-fullscreen-refinement.md`
- `.planning/stories/8-74-segnalazione-crea-map-fullscreen-refinement.story.md`

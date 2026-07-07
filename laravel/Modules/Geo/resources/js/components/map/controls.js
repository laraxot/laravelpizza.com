/**
 * Barrel: map overlay controls — import stabile da ./map/controls.js.
 * Ogni sotto-modulo espone logica + `renderButton(ctx)` (o gruppo, es. `renderZoomGroup`).
 */
export { renderControls, renderSearchPanel } from './controls/render-controls.js';
export { switchLayer, renderButton as renderLayerSwitchBtn } from './controls/switch-layer.js';
export { toggleFullscreen, syncFullscreenState, renderButton as renderFullscreenBtn } from './controls/fullscreen.js';
export { zoomIn, zoomOut, renderButton as renderZoomInBtn, renderZoomOutButton, renderZoomGroup } from './controls/zoom-in-out.js';
export { requestGeolocation, renderButton as renderGeolocationBtn } from './controls/geolocation.js';
export { toggleSearch, closeSearch, handleSearchKeydown, executeAddressSearch, selectSearchResult,
    renderToggleButton, renderSearchOverlayToggle } from './controls/search.js';

import { html } from 'lit';

import { renderButton as renderFullscreenBtn } from './fullscreen.js';
import { renderZoomGroup } from './zoom-in-out.js';
import { renderButton as renderLayerBtn } from './switch-layer.js';
import { renderButton as renderGeolocationBtn } from './geolocation.js';
import { renderToggleButton } from './search.js';

import { renderSearchPanel } from '../search.js';

/**
 * Ordine dei controlli nell’overlay (colonna). Ogni voce è `(ctx) => TemplateResult`
 * definita nel **proprio** modulo (`fullscreen.js`, `search.js`, …).
 *
 * **Non** aggiungere qui `<button>` o markup: solo import + una riga nel registry.
 */
const OVERLAY_PARTS = [
    renderToggleButton,
    renderFullscreenBtn,
    renderGeolocationBtn,
    renderLayerBtn,
    renderZoomGroup,
];

/**
 * Composizione pura della toolbar — tutta la UI dei singoli pulsanti vive nei file dedicati.
 */
export function renderControls(ctx) {
    return html`
        <div class="layer-controls-overlay">
            ${OVERLAY_PARTS.map((renderPart) => renderPart(ctx))}
        </div>
    `;
}

export { renderSearchPanel };

import { html } from 'lit';
import { geoIcon } from '../heroicons.js';
import { scheduleMapInvalidate } from '../resize-after-action.js';

const LAYER_IDS = ['street', 'humanitarian', 'satellite', 'topo'];

export function switchLayer(ctx) {
    if (!ctx._map || !ctx._layers) return;
    const currentIndex = LAYER_IDS.indexOf(ctx._currentLayer);
    const nextLayer = LAYER_IDS[(currentIndex + 1) % LAYER_IDS.length];
    const currentLayerObj = ctx._layers[ctx._currentLayer];
    if (currentLayerObj) ctx._map.removeLayer(currentLayerObj);
    const nextLayerObj = ctx._layers[nextLayer];
    if (nextLayerObj && !nextLayerObj._map) nextLayerObj.addTo(ctx._map);
    ctx._currentLayer = nextLayer;
    scheduleMapInvalidate(ctx, [0, 120, 300]);
}

/**
 * Layer-switch button — self-contained.
 * @param {Object} ctx
 */
export function renderButton(ctx) {
    return html`<button class="ctrl-btn" type="button"
        @click=${() => switchLayer(ctx)}
        aria-label="${ctx.labels?.switch_layer || 'Cambia Layer'}"
        title="${ctx.labels?.switch_layer || 'Cambia Layer'}">
        ${geoIcon('squares-2x2')}
    </button>`;
}

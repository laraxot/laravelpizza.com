import { html } from 'lit';
import { geoIcon } from '../heroicons.js';
import { scheduleMapInvalidate } from '../resize-after-action.js';

export function zoomIn(ctx) {
    if (!ctx._map) return;
    ctx._map.zoomIn();
    scheduleMapInvalidate(ctx, [150]);
}

export function zoomOut(ctx) {
    if (!ctx._map) return;
    ctx._map.zoomOut();
    scheduleMapInvalidate(ctx, [150]);
}

/**
 * Zoom-in button — self-contained, nessuna dipendenza dal componente host.
 * @param {Object} ctx
 */
export function renderButton(ctx) {
    const l = ctx.labels || {};
    return html`
        <button class="ctrl-btn" type="button"
            @click=${() => zoomIn(ctx)}
            aria-label="${l.zoom_in || 'Zoom In'}"
            title="${l.zoom_in || 'Zoom In'}">
            ${geoIcon('plus')}
        </button>
    `;
}

/**
 * Zoom-out button — self-contained.
 * @param {Object} ctx
 */
export function renderZoomOutButton(ctx) {
    const l = ctx.labels || {};
    return html`
        <button class="ctrl-btn" type="button"
            @click=${() => zoomOut(ctx)}
            aria-label="${l.zoom_out || 'Zoom Out'}"
            title="${l.zoom_out || 'Zoom Out'}">
            ${geoIcon('minus')}
        </button>
    `;
}

/**
 * Blocco zoom (+ / −) in un solo hook per la toolbar.
 * La grafica resta nei due render sopra; qui solo composizione locale al modulo zoom.
 *
 * @param {Object} ctx
 */
export function renderZoomGroup(ctx) {
    return html`${renderButton(ctx)}${renderZoomOutButton(ctx)}`;
}

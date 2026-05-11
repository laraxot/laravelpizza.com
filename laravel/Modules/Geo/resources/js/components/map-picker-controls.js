/**
 * Map Controls - Layer switching, fullscreen, geolocation, zoom
 * Extracted from coordinate-picker-lit.js for DRY/KISS compliance
 */

import { html } from 'lit';
import { geoIcon } from './geo-heroicons.js';

/**
 * @param {Object} ctx - CoordinatePickerField instance (this)
 */
export function renderControls(ctx) {
    const l = ctx.labels || {};
    const hasSearchToggle = typeof ctx._toggleSearch === 'function';

    return html`
        <div class="layer-controls-overlay">
            ${hasSearchToggle ? html`
                <button class="ctrl-btn" type="button"
                    @click=${() => ctx._toggleSearch()}
                    aria-label="${l.search || 'Cerca indirizzo'}"
                    title="${l.search || 'Cerca indirizzo'}">
                    ${geoIcon('magnifying-glass')}
                    <span class="ctrl-fallback" aria-hidden="true">🔍</span>
                </button>
            ` : ''}
            <button class="ctrl-btn" type="button" @click=${() => ctx._toggleFullscreen()} aria-label="${ctx.isFullscreen ? (l.close_fullscreen || 'Chiudi') : (l.fullscreen || 'Fullscreen')}" title="${ctx.isFullscreen ? (l.close_fullscreen || 'Chiudi') : (l.fullscreen || 'Fullscreen')}">
                ${ctx.isFullscreen ? geoIcon('arrows-pointing-in') : geoIcon('arrows-pointing-out')}
                <span class="ctrl-fallback" aria-hidden="true">${ctx.isFullscreen ? '⤢' : '⛶'}</span>
            </button>

            <button class="ctrl-btn" type="button" @click=${() => ctx._requestGeolocation()} ?disabled=${ctx.isLocating} aria-label="${l.use_location || 'Mia posizione'}" title="${l.use_location || 'Mia posizione'}">
                ${ctx.isLocating
                    ? html`<svg class="animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" opacity=".25"/><path d="M4 12a8 8 0 018-8" opacity=".75"/></svg>`
                    : geoIcon('map-pin')
                }
                <span class="ctrl-fallback" aria-hidden="true">◎</span>
            </button>

            <button class="ctrl-btn" type="button" @click=${() => ctx._switchLayer()} aria-label="${l.switch_layer || 'Cambia Layer'}" title="${l.switch_layer || 'Cambia Layer'}">
                ${geoIcon('squares-2x2')}
                <span class="ctrl-fallback" aria-hidden="true">▦</span>
            </button>

            <button class="ctrl-btn" type="button" @click=${() => ctx._zoomIn()} aria-label="${l.zoom_in || 'Zoom In'}" title="${l.zoom_in || 'Zoom In'}">
                ${geoIcon('plus')}
                <span class="ctrl-fallback" aria-hidden="true">+</span>
            </button>
            <button class="ctrl-btn" type="button" @click=${() => ctx._zoomOut()} aria-label="${l.zoom_out || 'Zoom Out'}" title="${l.zoom_out || 'Zoom Out'}">
                ${geoIcon('minus')}
                <span class="ctrl-fallback" aria-hidden="true">−</span>
            </button>
        </div>
    `;
}

/**
 * @param {Object} ctx - CoordinatePickerField instance
 */
export function switchLayer(ctx) {
    if (!ctx._map || !ctx._layers) return;

    const layers = ['street', 'humanitarian', 'satellite', 'topo'];
    const currentIndex = layers.indexOf(ctx._currentLayer);
    const nextIndex = (currentIndex + 1) % layers.length;
    const nextLayer = layers[nextIndex];

    const currentLayerObj = ctx._layers[ctx._currentLayer];
    if (currentLayerObj) ctx._map.removeLayer(currentLayerObj);

    const nextLayerObj = ctx._layers[nextLayer];
    if (nextLayerObj && !nextLayerObj._map) nextLayerObj.addTo(ctx._map);

    ctx._currentLayer = nextLayer;
    refreshMapSize(ctx, [0, 120, 300]);
}

/**
 * @param {Object} ctx - CoordinatePickerField instance
 */
export async function toggleFullscreen(ctx) {
    const container = getMapContainer(ctx);
    const entering = !ctx.isFullscreen;

    if (entering) {
        ctx._previousBodyOverflow = document.body.style.overflow || '';
        ctx._previousHtmlOverflow = document.documentElement.style.overflow || '';
        document.documentElement.classList.add('geo-map-fullscreen-active');
        document.body.style.overflow = 'hidden';
        document.documentElement.style.overflow = 'hidden';

        if (container?.requestFullscreen && !document.fullscreenElement) {
            await container.requestFullscreen().catch(() => undefined);
        }
    } else {
        if (document.fullscreenElement && document.exitFullscreen) {
            await document.exitFullscreen().catch(() => undefined);
        }

        restoreFullscreenDocumentState(ctx);
    }

    ctx.isFullscreen = entering;
    ctx.requestUpdate?.();

    ctx.dispatchEvent(new CustomEvent('fullscreen-changed', {
        detail: { isFullscreen: ctx.isFullscreen },
        bubbles: true,
        composed: true,
    }));

    refreshMapSize(ctx, [0, 160, 380, 700]);
}

export function syncFullscreenState(ctx) {
    const container = getMapContainer(ctx);
    const active = document.fullscreenElement === container;

    if (document.fullscreenElement && !active) {
        return;
    }

    if (ctx.isFullscreen !== active) {
        ctx.isFullscreen = active;
        ctx.requestUpdate?.();
    }

    if (!active) {
        restoreFullscreenDocumentState(ctx);
    }

    refreshMapSize(ctx, [0, 160, 380]);
}

/**
 * @param {Object} ctx - CoordinatePickerField instance
 */
export function zoomIn(ctx) {
    if (ctx._map) {
        ctx._map.zoomIn();
        refreshMapSize(ctx, [150]);
    }
}

/**
 * @param {Object} ctx - CoordinatePickerField instance
 */
export function zoomOut(ctx) {
    if (ctx._map) {
        ctx._map.zoomOut();
        refreshMapSize(ctx, [150]);
    }
}

/**
 * @param {Object} ctx - CoordinatePickerField instance
 */
export function requestGeolocation(ctx, options = {}) {
    const { showLoading = true } = options;

    if (!navigator.geolocation || ctx.isLocating) return;

    if (showLoading) {
        ctx.isLocating = true;
        ctx.requestUpdate();
    }

    navigator.geolocation.getCurrentPosition(
        (pos) => {
            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;
            if (typeof ctx._handleMapInteraction === 'function') {
                ctx._handleMapInteraction(lat, lng, 'geolocation');
            }

            if (showLoading) {
                ctx.isLocating = false;
                ctx.requestUpdate();
            }

            if (ctx._map) {
                const locateZoom = 12;
                ctx._map.setView([lat, lng], locateZoom, { animate: false });
                ctx._isUserCentered = true;
                refreshMapSize(ctx, [150]);
            }
        },
        () => {
            if (showLoading) {
                ctx.isLocating = false;
                ctx.requestUpdate();
            }

            ctx.geolocated = false;
        },
        { enableHighAccuracy: true, timeout: 5000 }
    );
}

function getMapContainer(ctx) {
    return ctx.renderRoot?.querySelector?.('.map-container')
        || ctx.querySelector?.('.map-container')
        || null;
}

function restoreFullscreenDocumentState(ctx) {
    document.documentElement.classList.remove('geo-map-fullscreen-active');
    document.body.style.overflow = ctx._previousBodyOverflow || '';
    document.documentElement.style.overflow = ctx._previousHtmlOverflow || '';
}

function refreshMapSize(ctx, delays = [0]) {
    if (typeof ctx._refreshMapSize === 'function') {
        ctx._refreshMapSize(delays);
        return;
    }

    delays.forEach((delay) => {
        setTimeout(() => ctx._map?.invalidateSize(), delay);
    });
}

import { html } from 'lit';
import { geoIcon } from '../heroicons.js';
import { scheduleMapInvalidate } from '../resize-after-action.js';

export function requestGeolocation(ctx, options = {}) {
    const { showLoading = true } = options;

    if (!navigator.geolocation) return;
    if (ctx.isLocating) return;
    if (ctx._geolocRequested && !showLoading) return;

    ctx._geolocRequested = true;

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

            ctx.geolocated = true;

            if (showLoading) ctx.isLocating = false;
            ctx.requestUpdate?.();

            if (ctx._map) {
                const locateZoom = Number.isFinite(ctx.zoom) ? Math.max(ctx.zoom, 14) : 15;
                ctx._map.setView([lat, lng], locateZoom, { animate: false });
                ctx._isUserCentered = true;
                scheduleMapInvalidate(ctx, [150]);
            }
        },
        () => {
            ctx._geolocRequested = false;
            if (showLoading) ctx.isLocating = false;
            ctx.requestUpdate?.();
            ctx.geolocated = false;
        },
        { enableHighAccuracy: true, timeout: 10000, maximumAge: 300000 }
    );
}

/**
 * Geolocation button — self-contained.
 * @param {Object} ctx
 */
export function renderButton(ctx) {
    return html`<button class="ctrl-btn" type="button"
        @click=${() => requestGeolocation(ctx)}
        ?disabled=${ctx.isLocating}
        aria-label="${ctx.labels?.use_location || 'Mia posizione'}"
        title="${ctx.labels?.use_location || 'Mia posizione'}">
        ${ctx.isLocating
            ? html`<svg class="animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" opacity=".25"/><path d="M4 12a8 8 0 018-8" opacity=".75"/></svg>`
            : geoIcon('map-pin')
        }
    </button>`;
}

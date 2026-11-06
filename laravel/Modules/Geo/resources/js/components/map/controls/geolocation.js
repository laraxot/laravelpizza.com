import { html } from 'lit';
import { geoIcon } from '../heroicons.js';
import { scheduleMapInvalidate } from '../resize-after-action.js';
import { getMapLabels } from '../labels.js';

/**
 * Posizione precisa non disponibile (origine non sicura, permesso negato, timeout, nessun sensore): mai un vicolo cieco.
 * Su richiesta esplicita (pulsante) torna al punto salvato o alla vista di partenza e spiega, in modo neutro, cosa fare;
 * all'apertura (auto) lascia solo l'invito a indicare il punto. Nessun messaggio su HTTPS o permessi: l'utente non puo'
 * risolverli e la segnalazione non li richiede.
 */
function fallBackToApproximate(ctx, explicitRequest) {
    const labels = { ...getMapLabels(), ...(ctx.labels || {}) };
    if (explicitRequest) {
        ctx._locationError = labels.location_unavailable || '';
    } else {
        ctx._locationError = ctx._lat == null ? (labels.no_position || '') : '';
    }
    // Se il GPS ha gia' centrato la mappa (_isUserCentered) non si riporta indietro.
    if (explicitRequest && ctx._map && !ctx._isUserCentered) {
        const view = ctx._initialView;
        if (ctx._lat != null && ctx._lng != null) {
            ctx._map.setView([ctx._lat, ctx._lng], Math.max(ctx._map.getZoom(), ctx.zoom), { animate: false });
        } else if (view) {
            ctx._map.setView([view.lat, view.lng], view.zoom, { animate: false });
        }
    }
    ctx.requestUpdate?.();
}

/**
 * GPS se il browser lo offre; altrimenti, o se l'utente lo nega, la zona di partenza (`fallBackToApproximate`). Mai un'eccezione, mai un messaggio su HTTPS o permessi.
 *
 * @param {Object} ctx - CoordinatePickerField instance
 * @param {{showLoading?: boolean, auto?: boolean}} [options] `auto`: avvio automatico (campo vuoto), non un clic dell'utente
 * @returns {Promise<void>} si risolve a ricerca conclusa
 */
export function requestGeolocation(ctx, options = {}) {
    const { showLoading = true, auto = false } = options;

    // Senza API di posizione (origine HTTP, browser senza supporto) non si chiede il GPS: su HTTP fallirebbe comunque,
    // senza prompt. Nessun servizio esterno: la mappa resta sulla zona di partenza e l'utente indica il punto.
    if (!window.isSecureContext || !navigator.geolocation) {
        fallBackToApproximate(ctx, !auto);
        return Promise.resolve();
    }
    if (ctx.isLocating) return Promise.resolve();
    if (ctx._geolocRequested && !showLoading) return Promise.resolve();

    ctx._geolocRequested = true;

    if (showLoading) {
        ctx.isLocating = true;
        ctx.requestUpdate();
    }

    return new Promise((resolve) => navigator.geolocation.getCurrentPosition(
        (pos) => {
            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;

            if (typeof ctx._handleMapInteraction === 'function') {
                ctx._handleMapInteraction(lat, lng, 'geolocation');
            }

            ctx.geolocated = true;
            ctx._geolocRequested = false;
            ctx._locationError = '';

            if (showLoading) ctx.isLocating = false;
            ctx.requestUpdate?.();

            if (ctx._map) {
                const locateZoom = Number.isFinite(ctx.zoom) ? Math.max(ctx.zoom, 14) : 15;
                ctx._map.setView([lat, lng], locateZoom, { animate: false });
                ctx._isUserCentered = true;
                scheduleMapInvalidate(ctx, [150]);
            }
            resolve();
        },
        (error) => {
            ctx._geolocRequested = false;
            if (showLoading) ctx.isLocating = false;
            ctx.geolocated = false;
            // La posizione precisa e' un di piu': su HTTP, con permesso negato o sensore bloccato la mappa resta
            // utilizzabile, nella zona del fuso orario, e si indica il punto con un clic o con la ricerca.
            fallBackToApproximate(ctx, !auto);
            resolve();
        },
        { enableHighAccuracy: true, timeout: 10000, maximumAge: 300000 }
    ));
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

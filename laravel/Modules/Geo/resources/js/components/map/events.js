/**
 * Map Events - click, dragend, map interaction
 * Extracted from coordinate-picker-lit.js for DRY/KISS compliance
 */

import L from 'leaflet';
import { createGeoMapLeafletIcon } from './config.js';
import { buildMapLayers } from './layers.js';
import { requestGeolocation } from './controls/geolocation.js';
import { refreshMapSize } from './resize.js';
import { normalizeCoordinatePair } from './utils.js';
import { approximateCenterFromTimezone } from './approximate-location.js';
import { resolveInitialView } from './default-view.js';
import { fetchNominatimReverse } from './reverse-geocode.js';

const REVERSE_DEBOUNCE_MS = 420;

/** Sotto questo zoom (paese, regione) un clic non indica un luogo: senza punto scelto, avvicina soltanto. */
export const PICK_MIN_ZOOM = 10;
/** Quanti livelli di zoom avanza un clic "di avvicinamento" (da 3 a 7 a 10: due clic dal mondo). */
const PICK_ZOOM_STEP = 4;

/**
 * Debounced Nominatim reverse — aggiorna indirizzo dopo click/drag/geoloc senza duplicare il round-trip su “search”.
 *
 * @param {Object} ctx
 * @param {number} lat
 * @param {number} lng
 * @param {string} source
 */
export function scheduleClientReverseGeocode(ctx, lat, lng, source) {
    if (source === 'search') {
        return;
    }

    if (ctx._reverseGeocodeTimer) {
        clearTimeout(ctx._reverseGeocodeTimer);
    }

    ctx._reverseGeocodeTimer = setTimeout(() => {
        ctx._reverseGeocodeTimer = null;
        void (async () => {
            try {
                const rev = await fetchNominatimReverse(lat, lng);
                if (!rev) {
                    return;
                }

                ctx.state = {
                    ...(ctx.state || {}),
                    address: rev.display_name,
                    display_name: rev.display_name,
                    provider: 'nominatim',
                    raw: rev.raw,
                };
                ctx.requestUpdate?.();

                ctx.dispatchEvent(new CustomEvent('coords-changed', {
                    detail: {
                        lat,
                        lng,
                        latitude: lat,
                        longitude: lng,
                        address: rev.display_name,
                        display_name: rev.display_name,
                        source: `${source}-reverse`,
                    },
                    bubbles: true,
                    composed: true,
                }));
            } catch (err) {
                console.warn('[map-events] reverse geocode failed', err);
            }
        })();
    }, REVERSE_DEBOUNCE_MS);
}

/**
 * @param {Object} ctx - CoordinatePickerField instance (this)
 */
export function handleMapInteraction(ctx, lat, lng, source = 'manual') {
    // Sola lettura: unico punto di scrittura dello stato (click, drag, ricerca, geolocalizzazione passano da qui).
    if (ctx.readonly) return;

    ctx._isProgrammaticUpdate = true;
    const normalized = normalizeCoordinatePair(lat, lng);
    if (!normalized) {
        ctx._isProgrammaticUpdate = false;
        return;
    }

    const skipAddressReset = source === 'search';
    // L'invito "cerca un indirizzo o tocca la mappa" non serve piu' una volta indicato il punto.
    ctx._locationError = '';

    ctx.state = {
        ...(ctx.state || {}),
        lat: normalized.lat,
        lng: normalized.lng,
        latitude: normalized.lat,
        longitude: normalized.lng,
        ...(skipAddressReset
            ? {}
            : {
                address: null,
                display_name: null,
            }),
    };
    ctx._shouldRecenterAfterResize = true;
    ctx._locationError = '';
    ctx._updateMarker(normalized.lat, normalized.lng);

    ctx.dispatchEvent(new CustomEvent('coords-changed', {
        detail: {
            lat: normalized.lat,
            lng: normalized.lng,
            latitude: normalized.lat,
            longitude: normalized.lng,
            source,
            ...(skipAddressReset
                ? {}
                : {
                    address: null,
                    display_name: null,
                }),
        },
        bubbles: true,
        composed: true,
    }));

    scheduleClientReverseGeocode(ctx, normalized.lat, normalized.lng, source);

    window.setTimeout(() => {
        ctx._isProgrammaticUpdate = false;
    }, 100);
}

/**
 * @param {Object} ctx - CoordinatePickerField instance
 */
export function updateMarker(ctx, lat, lng) {
    if (!ctx._map) return;
    if (!ctx._marker) {
        // Sola lettura: marker fisso, non interattivo e senza tab stop (Leaflet gli darebbe role=button + tabindex).
        ctx._marker = L.marker([lat, lng], {
            draggable: !ctx.readonly,
            interactive: !ctx.readonly,
            keyboard: !ctx.readonly,
            icon: createGeoMapLeafletIcon(L, ctx.markerColor, ctx.markerIconUrl, ctx.markerLabel)
        }).addTo(ctx._map);
        ctx._marker.on('dragend', (e) => {
            const pos = e.target.getLatLng();
            handleMapInteraction(ctx, pos.lat, pos.lng, 'dragend');
        });
    } else {
        ctx._marker.setLatLng([lat, lng]);
    }
}

/**
 * @param {Object} ctx - CoordinatePickerField instance
 */
export function syncMarkerToProperties(ctx) {
    if (!ctx._map) return;
    const lat = ctx._lat;
    const lng = ctx._lng;
    updateMarker(ctx, lat, lng);
    ctx._shouldRecenterAfterResize = true;
    ctx._map.setView([lat, lng], Math.max(ctx._map.getZoom(), ctx.zoom));
    refreshMapSize(ctx);
}

/**
 * @param {Object} ctx - CoordinatePickerField instance
 */
export function initMap(ctx) {
    const el = ctx.querySelector('.map-picker-leaflet-pane');
    if (!el || ctx._map) return;

    ctx._layers = ctx._layers ?? {};
    ctx._currentLayer = ctx._currentLayer ?? 'street';

    const hasStateCoordinates = ctx._lat != null && ctx._lng != null;
    const hasExplicitCenter = ctx.centerLatitude != null && ctx.centerLongitude != null;
    // Nessun Comune inventato (D19), mai il mondo intero: punto salvato > centro esplicito > zona dal fuso orario >
    // vista di default dell'ente (`geo.config.map.default_view`) > panoramica d'Italia. Il GPS, se c'e', arriva dopo e ricentra.
    const view = resolveInitialView({
        point: hasStateCoordinates ? { lat: ctx._lat, lng: ctx._lng } : null,
        center: hasExplicitCenter ? { lat: ctx.centerLatitude, lng: ctx.centerLongitude } : null,
        approximate: hasStateCoordinates || hasExplicitCenter ? null : approximateCenterFromTimezone(),
        defaultView: ctx.defaultView,
        zoom: ctx.zoom,
    });
    ctx._initialView = view;

    ctx._map = L.map(el, {
        center: [view.lat, view.lng],
        zoom: view.zoom,
        zoomControl: false,
        attributionControl: false,
        // Sola lettura: niente tab stop sulla mappa e niente zoom con la rotella (non deve catturare lo scroll della pagina).
        ...(ctx.readonly ? { keyboard: false, scrollWheelZoom: false } : {})
    });

    ctx._layers = buildMapLayers(L);
    ctx._layers.street.addTo(ctx._map);

    if (!ctx.readonly) {
        ctx._map.on('click', (e) => {
            if (ctx._lat == null && ctx._map.getZoom() < PICK_MIN_ZOOM) {
                // Vista vasta (mondo, regione) e nessun punto: un clic qui sarebbe a risoluzione di paese. Solo zoom sul punto.
                ctx._map.setView(e.latlng, Math.min(ctx._map.getZoom() + PICK_ZOOM_STEP, PICK_MIN_ZOOM));
                return;
            }
            handleMapInteraction(ctx, e.latlng.lat, e.latlng.lng, 'click');
        });
    }

    if (hasStateCoordinates) {
        syncMarkerToProperties(ctx);
    } else if (!ctx.readonly && ctx.geolocateWhenEmpty) {
        window.setTimeout(() => {
            if (ctx._lat == null && ctx._lng == null) {
                void requestGeolocation(ctx, { showLoading: true, auto: true });
            }
        }, 300);
    }

    refreshMapSize(ctx);
}

/**
 * Map Events - click, dragend, map interaction
 * Extracted from coordinate-picker-lit.js for DRY/KISS compliance
 */

import L from 'leaflet';
import { createMapPickerLeafletIcon } from './map-picker-marker-config.js';
import { buildMapLayers } from './map-picker-layers.js';
import { requestGeolocation } from './map-picker-controls.js';
import { refreshMapSize } from './map-picker-resize.js';
import { normalizeCoordinatePair } from './geo-location-utils.js';

/**
 * @param {Object} ctx - CoordinatePickerField instance (this)
 */
export function handleMapInteraction(ctx, lat, lng, source = 'manual') {
    ctx._isProgrammaticUpdate = true;
    const normalized = normalizeCoordinatePair(lat, lng);
    if (!normalized) {
        ctx._isProgrammaticUpdate = false;
        return;
    }

    ctx.state = { ...(ctx.state || {}), lat: normalized.lat, lng: normalized.lng };
    ctx._updateMarker(normalized.lat, normalized.lng);

    ctx.dispatchEvent(new CustomEvent('coords-changed', {
        detail: {
            lat: normalized.lat,
            lng: normalized.lng,
            latitude: normalized.lat,
            longitude: normalized.lng,
            source,
        },
        bubbles: true,
        composed: true,
    }));

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
        ctx._marker = L.marker([lat, lng], {
            draggable: true,
            icon: createMapPickerLeafletIcon(L)
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

    const centerLat = ctx._lat ?? 41.9028;
    const centerLng = ctx._lng ?? 12.4964;

    ctx._map = L.map(el, {
        center: [centerLat, centerLng],
        zoom: ctx.zoom,
        zoomControl: false,
        attributionControl: false
    });

    ctx._layers = buildMapLayers(L);
    ctx._layers.street.addTo(ctx._map);

    ctx._map.on('click', (e) => handleMapInteraction(ctx, e.latlng.lat, e.latlng.lng, 'click'));

    if (ctx._lat != null && ctx._lng != null) {
        syncMarkerToProperties(ctx);
    } else if (ctx.geolocateWhenEmpty || (ctx._lat === null && ctx._lng === null)) {
        void requestGeolocation(ctx, { showLoading: false });
    }

    refreshMapSize(ctx);
}

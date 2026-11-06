import { APPROXIMATE_ZOOM } from './approximate-location.js';

/**
 * Panoramica d'Italia: stessa del default di `geo.map.default_view` (config/config.php).
 * Serve solo a chi monta il componente senza passare `default-view`: la mappa non apre mai il mondo intero.
 */
export const FALLBACK_VIEW = Object.freeze({ lat: 42.5, lng: 12.5, zoom: 6 });

const finite = (value) => (value === null || value === undefined || value === '' ? Number.NaN : Number(value));

/**
 * Vista di default del territorio, come la manda il server (`geo.map.default_view`).
 *
 * @param {unknown} view oggetto `{lat, lng, zoom}` (numeri o stringhe numeriche)
 * @returns {{lat: number, lng: number, zoom: number} | null} null se manca o e' fuori intervallo
 */
export function parseDefaultView(view) {
    const lat = finite(view?.lat);
    const lng = finite(view?.lng);
    const zoom = finite(view?.zoom);

    if (!Number.isFinite(lat) || !Number.isFinite(lng) || !Number.isInteger(zoom)) return null;
    if (Math.abs(lat) > 90 || Math.abs(lng) > 180 || zoom < 1 || zoom > 19) return null;

    return { lat, lng, zoom };
}

/**
 * Dove apre la mappa, in ordine: punto salvato, centro esplicito del campo, fuso orario del browser,
 * vista di default dell'ente, panoramica d'Italia. La posizione precisa del browser, se c'e', arriva dopo e ricentra.
 *
 * @param {{point?: {lat: number, lng: number} | null, center?: {lat: number, lng: number} | null,
 *          approximate?: {lat: number, lng: number} | null, defaultView?: unknown, zoom: number}} input
 * @returns {{lat: number, lng: number, zoom: number, source: 'state'|'center'|'timezone'|'default'|'fallback'}}
 */
export function resolveInitialView({ point = null, center = null, approximate = null, defaultView = null, zoom }) {
    if (point) return { lat: point.lat, lng: point.lng, zoom, source: 'state' };
    if (center) return { lat: center.lat, lng: center.lng, zoom, source: 'center' };
    if (approximate) return { lat: approximate.lat, lng: approximate.lng, zoom: Math.min(zoom, APPROXIMATE_ZOOM), source: 'timezone' };

    const configured = parseDefaultView(defaultView);
    if (configured) return { ...configured, source: 'default' };

    return { ...FALLBACK_VIEW, source: 'fallback' };
}

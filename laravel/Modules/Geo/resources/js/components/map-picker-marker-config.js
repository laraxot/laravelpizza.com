import markerFallbackUrl from '../../svg/map-picker-marker-fallback.svg';

export const markerGeometry = {
    iconSize: [35, 45],
    iconAnchor: [17, 42],
    popupAnchor: [1, -32],
};

export const defaultMarker = {
    iconUrl: markerFallbackUrl,
    ...markerGeometry,
    className: 'map-picker-marker map-picker-marker--primary',
};

export const fallbackMarker = {
    iconUrl: markerFallbackUrl,
    ...markerGeometry,
    className: 'map-picker-marker map-picker-marker--fallback',
};

/**
 * Resolve marker config using only repository-local assets.
 * No unpkg/CDN marker-icon paths are allowed here.
 *
 * @param {string | null | undefined} type
 * @returns {import('leaflet').IconOptions}
 */
export function resolveMarkerIcon(type) {
    const normalizedType = (type ?? '').toString().trim().toLowerCase();

    if (normalizedType === 'fallback') {
        return fallbackMarker;
    }

    return defaultMarker;
}

export function createMapPickerLeafletIcon(L, type = 'default') {
    const normalizedType = (type ?? '').toString().trim().toLowerCase();

    if (normalizedType === 'fallback') {
        return L.icon(resolveMarkerIcon('fallback'));
    }

    // Custom SVG marker inspired by farmshops-style visual language:
    // strong contrast, clear center point, and readable silhouette on satellite layer.
    const markerSvg = `
        <svg width="44" height="56" viewBox="0 0 44 56" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
            <defs>
                <linearGradient id="geoMarkerMain" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="#fb7185"/>
                    <stop offset="100%" stop-color="#e11d48"/>
                </linearGradient>
                <filter id="geoMarkerDrop" x="-35%" y="-25%" width="170%" height="190%">
                    <feDropShadow dx="0" dy="3" stdDeviation="2.2" flood-color="#111827" flood-opacity="0.35"/>
                </filter>
            </defs>
            <g filter="url(#geoMarkerDrop)">
                <path d="M22 2c-10.3 0-18.5 8.2-18.5 18.5 0 13.4 16.2 29 17.1 29.8.8.7 2 .7 2.8 0 .9-.8 17.1-16.4 17.1-29.8C40.5 10.2 32.3 2 22 2z" fill="url(#geoMarkerMain)"/>
                <circle cx="22" cy="20.5" r="9.2" fill="#fff"/>
                <circle cx="22" cy="20.5" r="5.2" fill="#9f1239"/>
                <rect x="17.4" y="16.2" width="9.2" height="2.2" rx="1.1" fill="#be123c" opacity="0.45"/>
            </g>
        </svg>
    `;

    return L.divIcon({
        className: 'map-picker-marker map-picker-marker--custom',
        html: `<div class="map-picker-marker__inner" aria-hidden="true">${markerSvg}</div>`,
        iconSize: [32, 45],
        iconAnchor: [22, 54],
        popupAnchor: [0, -42],
    });
}

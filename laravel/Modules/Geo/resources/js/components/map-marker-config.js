const SAFE_HEX_COLOR = /^#[0-9a-f]{3}([0-9a-f]{3})?$/i;

export function normalizeGeoMapColor(color, fallback = '#0066cc') {
    return SAFE_HEX_COLOR.test(String(color || '')) ? color : fallback;
}

export function createGeoMapLeafletIcon(L, color = '#0066cc') {
    const fill = normalizeGeoMapColor(color);

    return L.divIcon({
        html: `<svg viewBox="0 0 32 45" width="32" height="45" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M16 0C7.163 0 0 7.163 0 16c0 10 16 29 16 29S32 26 32 16C32 7.163 24.837 0 16 0z"
                  fill="${fill}" stroke="#fff" stroke-width="1.5"/>
            <circle cx="16" cy="16" r="6" fill="#fff"/>
        </svg>`,
        className: 'geo-map-marker-wrapper',
        iconSize: [32, 45],
        iconAnchor: [16, 45],
        popupAnchor: [0, -46],
    });
}

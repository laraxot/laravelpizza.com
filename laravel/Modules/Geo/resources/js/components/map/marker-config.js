import { buildMarkerGlyphHtml } from './icon-glyph.js';

const SAFE_HEX_COLOR = /^#[0-9a-f]{3}([0-9a-f]{3})?$/i;

/**
 * Marker mappa Fixcity — farmshops ExtraMarkers `shape: square` + STORY-130 (corpo = stato).
 * Quadrato arrotondato, icona tipologia bianca su fill stato; ancoraggio al centro (come farmshops).
 */
const MARKER_WIDTH = 40;
const MARKER_BODY_SIZE = 40;
const MARKER_TOTAL_HEIGHT = MARKER_BODY_SIZE;
const MARKER_GLYPH_SIZE = 26;
const MARKER_STATUS_FILL_ALPHA = 0.94;
const MARKER_GLOW_ALPHA = 0.38;

export function normalizeGeoMapColor(color, fallback = '#0066cc') {
    return SAFE_HEX_COLOR.test(String(color || '')) ? color : fallback;
}

/**
 * @param {string} hex
 * @param {number} [alpha]
 */
export function hexToRgba(hex, alpha = 1) {
    const normalized = normalizeGeoMapColor(hex).replace('#', '');
    const full = normalized.length === 3
        ? normalized.split('').map((c) => c + c).join('')
        : normalized;
    const n = Number.parseInt(full, 16);
    if (!Number.isFinite(n)) {
        return `rgba(96, 125, 139, ${alpha})`;
    }

    const r = (n >> 16) & 255;
    const g = (n >> 8) & 255;
    const b = n & 255;

    return `rgba(${r}, ${g}, ${b}, ${alpha})`;
}

function buildTypeInitial(label) {
    const initial = String(label || '?').trim().charAt(0).toUpperCase() || '?';

    return `<span class="geo-map-marker-card__initial" aria-hidden="true">${initial}</span>`;
}

export function createGeoMapLeafletIcon(L, color = '#0066cc', iconUrl = null, typeLabel = '') {
    const statusColor = normalizeGeoMapColor(color);
    const statusFillRgba = hexToRgba(color, MARKER_STATUS_FILL_ALPHA);
    const statusGlowRgba = hexToRgba(color, MARKER_GLOW_ALPHA);
    // Icona in bianco su sfondo colorato per massimo contrasto e visibilità
    const glyph = buildMarkerGlyphHtml(iconUrl, MARKER_GLYPH_SIZE, { monochrome: true });
    const fallbackDot = glyph ? '' : buildTypeInitial(typeLabel);

    return L.divIcon({
        html: `<div class="geo-map-marker-card geo-map-marker-card--square" style="--status-color:${statusColor};--status-fill:${statusFillRgba};--status-glow:${statusGlowRgba}" aria-hidden="true">
            <div class="geo-map-marker-card__shell">
                <div class="geo-map-marker-card__inner">
                    <div class="geo-map-marker-card__glyph">${glyph}${fallbackDot}</div>
                </div>
            </div>
        </div>`,
        className: 'geo-map-marker-wrapper geo-map-marker-wrapper--card',
        iconSize: [MARKER_WIDTH, MARKER_TOTAL_HEIGHT],
        iconAnchor: [MARKER_WIDTH / 2, MARKER_BODY_SIZE / 2],
        popupAnchor: [0, -MARKER_BODY_SIZE / 2],
    });
}

export const markerCardStylesText = `
    .geo-map-marker-wrapper--card {
        background: transparent !important;
        border: none !important;
    }
    .geo-map-marker-card {
        position: relative;
        width: ${MARKER_WIDTH}px;
        height: ${MARKER_TOTAL_HEIGHT}px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        pointer-events: none;
        filter: drop-shadow(0 2px 5px rgba(15, 23, 42, 0.25)) drop-shadow(0 8px 18px var(--status-glow, rgba(15, 23, 42, 0.22)));
    }
    .geo-map-marker-card__shell {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
    }
    .geo-map-marker-card--square {
        height: ${MARKER_BODY_SIZE}px;
    }
    .geo-map-marker-card__inner {
        width: ${MARKER_BODY_SIZE}px;
        height: ${MARKER_BODY_SIZE}px;
        border-radius: 12%;
        background: linear-gradient(
            155deg,
            color-mix(in srgb, var(--status-color, #607d8b) 92%, #fff) 0%,
            var(--status-fill, rgba(96, 125, 139, 0.94)) 55%,
            color-mix(in srgb, var(--status-color, #607d8b) 85%, #17324d) 100%
        );
        border: 2.5px solid #fff;
        box-sizing: border-box;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow:
            0 0 0 1px color-mix(in srgb, var(--status-color, #607d8b) 55%, transparent),
            inset 0 1px 0 rgba(255, 255, 255, 0.25);
        transition: box-shadow 0.18s ease, filter 0.18s ease;
    }
    .geo-map-marker-card__glyph {
        display: flex;
        align-items: center;
        justify-content: center;
        width: ${MARKER_GLYPH_SIZE}px;
        height: ${MARKER_GLYPH_SIZE}px;
    }
    .geo-map-marker-card__glyph img.geo-map-marker-glyph--img {
        display: block !important;
        width: ${MARKER_GLYPH_SIZE}px !important;
        height: ${MARKER_GLYPH_SIZE}px !important;
        max-width: ${MARKER_GLYPH_SIZE}px !important;
        max-height: ${MARKER_GLYPH_SIZE}px !important;
        object-fit: contain !important;
        /* Bianco su sfondo colorato per massima leggibilità */
        filter: brightness(0) saturate(100%) invert(1) !important;
    }
    .geo-map-marker-card__initial {
        font-size: 1.125rem;
        font-weight: 800;
        line-height: 1;
        color: #fff;
        font-family: 'Titillium Web', system-ui, sans-serif;
    }
    .leaflet-marker-icon.geo-map-marker-wrapper--card:hover .geo-map-marker-card {
        filter: drop-shadow(0 3px 6px rgba(15, 23, 42, 0.28)) drop-shadow(0 10px 20px var(--status-glow, rgba(15, 23, 42, 0.3)));
    }
    .leaflet-marker-icon.geo-map-marker-wrapper--card:hover .geo-map-marker-card__inner,
    .leaflet-marker-icon.geo-map-marker-wrapper--card:focus-visible .geo-map-marker-card__inner {
        filter: saturate(1.08) brightness(1.02);
        box-shadow:
            0 0 0 1px color-mix(in srgb, var(--status-color, #607d8b) 65%, transparent),
            0 0 12px var(--status-glow, rgba(15, 23, 42, 0.25)),
            inset 0 1px 0 rgba(255, 255, 255, 0.5);
    }
    .leaflet-marker-icon.geo-map-marker-wrapper--card:focus-visible {
        outline: none;
    }
    .leaflet-marker-icon.geo-map-marker-wrapper--card:focus-visible .geo-map-marker-card__inner {
        box-shadow: 0 0 0 2px #fff, 0 0 0 4px #17324d, 0 0 14px var(--status-glow, rgba(15, 23, 42, 0.25));
    }
`;

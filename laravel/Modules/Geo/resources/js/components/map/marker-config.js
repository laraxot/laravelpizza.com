import { buildMarkerGlyphHtml } from './icon-glyph.js';

const SAFE_HEX_COLOR = /^#[0-9a-f]{3}([0-9a-f]{3})?$/i;

/**
 * Marker mappa DesignComuni compliant — cerchio con icona pin bianca su sfondo primary.
 * Basato su: https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html
 * WCAG 2.1 AA: contrasto, focus-visible, prefers-reduced-motion, dark mode.
 */
const MARKER_WIDTH = 44;
const MARKER_BODY_SIZE = 44;
const MARKER_TOTAL_HEIGHT = MARKER_BODY_SIZE;
const MARKER_GLYPH_SIZE = 22;
const MARKER_BORDER_WIDTH = 3;

const DESIGN_COMUNI_PRIMARY = '#0057b8';
const MAP_PIN_PATH_D =
  'M12 2C8.69 2 6 4.69 6 8c0 5.25 6 10 6 10s6-4.75 6-10c0-3.31-2.69-6-6-6zm0 8.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z';

export function normalizeGeoMapColor(color, fallback = DESIGN_COMUNI_PRIMARY) {
  return SAFE_HEX_COLOR.test(String(color || '')) ? color : fallback;
}

/**
 * @param {string} hex
 * @param {number} [alpha]
 */
export function hexToRgba(hex, alpha = 1) {
  const normalized = normalizeGeoMapColor(hex).replace('#', '');
  const full =
    normalized.length === 3
      ? normalized
          .split('')
          .map(c => c + c)
          .join('')
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
  const initial =
    String(label || '?')
      .trim()
      .charAt(0)
      .toUpperCase() || '?';

  return `<span class="geo-map-marker-designcomuni__initial" aria-hidden="true">${initial}</span>`;
}

export function createGeoMapLeafletIcon(
  L,
  color = DESIGN_COMUNI_PRIMARY,
  iconUrl = null,
  typeLabel = ''
) {
  const statusColor = normalizeGeoMapColor(color, DESIGN_COMUNI_PRIMARY);
  // Icona SVG da sprite DesignComuni (pin bianco per contrasto)
  const glyph = buildMarkerGlyphHtml(iconUrl, MARKER_GLYPH_SIZE, {
    monochrome: true,
  });
  const useSprite = !glyph && !iconUrl;
  // iniziale solo se l'icona del tipo c'era ma non e' utilizzabile: con il pin di default un "?" affiancato era un doppione
  const fallbackDot = glyph || useSprite ? '' : buildTypeInitial(typeLabel);
  const spriteIcon = useSprite
    ? `<svg class="geo-map-marker-designcomuni__glyph-svg" aria-hidden="true" width="${MARKER_GLYPH_SIZE}" height="${MARKER_GLYPH_SIZE}" viewBox="0 0 24 24"><path fill="currentColor" d="${MAP_PIN_PATH_D}"></path></svg>`
    : '';

  return L.divIcon({
    html: `<div class="geo-map-marker-designcomuni" style="--marker-color:${statusColor}" role="img" aria-label="Marker posizione segnalazione" aria-hidden="true">
            <div class="geo-map-marker-designcomuni__circle">
                <div class="geo-map-marker-designcomuni__icon">${glyph}${spriteIcon}${fallbackDot}</div>
            </div>
        </div>`,
    className: 'geo-map-marker-wrapper geo-map-marker-wrapper--designcomuni',
    iconSize: [MARKER_WIDTH, MARKER_TOTAL_HEIGHT],
    iconAnchor: [MARKER_WIDTH / 2, MARKER_BODY_SIZE / 2],
    popupAnchor: [0, -MARKER_BODY_SIZE / 2],
  });
}

export const markerCardStylesText = `
    .geo-map-marker-wrapper--designcomuni {
        background: transparent !important;
        border: none !important;
    }
    .geo-map-marker-designcomuni {
        position: relative;
        width: ${MARKER_WIDTH}px;
        height: ${MARKER_TOTAL_HEIGHT}px;
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3)) drop-shadow(0 4px 8px rgba(0,0,0,0.15));
        transition: transform 0.15s ease, filter 0.15s ease, box-shadow 0.15s ease;
    }
    @media (prefers-reduced-motion: reduce) {
        .geo-map-marker-designcomuni { transition: none !important; }
    }
    .geo-map-marker-designcomuni__circle {
        width: ${MARKER_BODY_SIZE}px;
        height: ${MARKER_BODY_SIZE}px;
        border-radius: 50%;
        background: var(--marker-color, ${DESIGN_COMUNI_PRIMARY});
        border: ${MARKER_BORDER_WIDTH}px solid #fff;
        box-shadow:
            0 0 0 1px color-mix(in srgb, var(--marker-color, ${DESIGN_COMUNI_PRIMARY}) 30%, transparent),
            inset 0 1px 0 rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: box-shadow 0.15s ease, filter 0.15s ease;
    }
    .geo-map-marker-designcomuni__icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: ${MARKER_GLYPH_SIZE}px;
        height: ${MARKER_GLYPH_SIZE}px;
        color: #fff;
        filter: brightness(0) invert(1);
    }
    .geo-map-marker-designcomuni__glyph-svg {
        display: block;
        width: 100%;
        height: 100%;
    }
    .geo-map-marker-designcomuni__initial {
        font-size: 1rem;
        font-weight: 800;
        line-height: 1;
        color: #fff;
        font-family: 'Titillium Web', system-ui, sans-serif;
    }

    /* Hover */
    .leaflet-marker-icon.geo-map-marker-wrapper--designcomuni:hover .geo-map-marker-designcomuni {
        transform: scale(1.1);
        filter: drop-shadow(0 4px 8px rgba(0,0,0,0.35)) drop-shadow(0 8px 16px rgba(0,0,0,0.2));
    }
    @media (prefers-reduced-motion: reduce) {
        .leaflet-marker-icon.geo-map-marker-wrapper--designcomuni:hover .geo-map-marker-designcomuni {
            transform: none;
        }
    }

    /* Focus-visible (WCAG 2.1 AA) */
    .leaflet-marker-icon.geo-map-marker-wrapper--designcomuni:focus-visible {
        outline: none;
    }
    .leaflet-marker-icon.geo-map-marker-wrapper--designcomuni:focus-visible .geo-map-marker-designcomuni__circle {
        box-shadow:
            0 0 0 3px #fff,
            0 0 0 5px var(--marker-color, ${DESIGN_COMUNI_PRIMARY}),
            0 0 12px rgba(0,0,0,0.2),
            inset 0 1px 0 rgba(255,255,255,0.3);
    }

    /* Dragging */
    .leaflet-marker-icon.geo-map-marker-wrapper--designcomuni.leaflet-marker-draggable.dragging .geo-map-marker-designcomuni {
        z-index: 1000;
        filter: drop-shadow(0 6px 12px rgba(0,0,0,0.4)) drop-shadow(0 12px 24px rgba(0,0,0,0.25));
    }

    /* Active/Selected pulse */
    .geo-map-marker-designcomuni--active .geo-map-marker-designcomuni__circle {
        animation: marker-pulse 2s ease-in-out infinite;
        box-shadow:
            0 0 0 3px #fff,
            0 0 0 6px var(--marker-color, ${DESIGN_COMUNI_PRIMARY});
    }
    @keyframes marker-pulse {
        0%, 100% { box-shadow: 0 0 0 3px #fff, 0 0 0 6px var(--marker-color); }
        50% { box-shadow: 0 0 0 3px #fff, 0 0 0 10px color-mix(in srgb, var(--marker-color) 40%, transparent); }
    }
    @media (prefers-reduced-motion: reduce) {
        .geo-map-marker-designcomuni--active .geo-map-marker-designcomuni__circle {
            animation: none;
            box-shadow: 0 0 0 3px #fff, 0 0 0 6px var(--marker-color);
        }
    }

    /* Dark mode adjustments */
    @media (prefers-color-scheme: dark) {
        .geo-map-marker-designcomuni {
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5)) drop-shadow(0 4px 8px rgba(0,0,0,0.3));
        }
        .leaflet-marker-icon.geo-map-marker-wrapper--designcomuni:focus-visible .geo-map-marker-designcomuni__circle {
            box-shadow:
                0 0 0 3px #fff,
                0 0 0 5px #4d9fff,
                0 0 12px rgba(0,0,0,0.4);
        }
    }

    /* Responsive by zoom (toggled via JS) */
    .geo-map-marker-designcomuni--zoom-low { width: 32px; height: 32px; }
    .geo-map-marker-designcomuni--zoom-low .geo-map-marker-designcomuni__circle { width: 32px; height: 32px; }
    .geo-map-marker-designcomuni--zoom-low .geo-map-marker-designcomuni__icon { width: 16px; height: 16px; }
    .geo-map-marker-designcomuni--zoom-high { width: 48px; height: 48px; }
    .geo-map-marker-designcomuni--zoom-high .geo-map-marker-designcomuni__circle { width: 48px; height: 48px; }
    .geo-map-marker-designcomuni--zoom-high .geo-map-marker-designcomuni__icon { width: 24px; height: 24px; }
`;

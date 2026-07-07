const DEFAULT_GLYPH_SIZE_PX = 32;
const CLUSTER_DOT_SIZE_PX = 18;

const SAFE_HEX_COLOR = /^#[0-9a-f]{3}([0-9a-f]{3})?$/i;

function normalizeHexColor(color, fallback = '#607d8b') {
    return SAFE_HEX_COLOR.test(String(color || '')) ? String(color) : fallback;
}

function sanitizeIconUrl(iconUrl) {
    const url = String(iconUrl || '').trim();
    if (url === '' || !url.startsWith('/') || /["'<>]/.test(url)) {
        return null;
    }

    return url;
}

/**
 * Glifo tipologia — iconUrl da fixcity::svg (GeoJSON properties.type.iconUrl).
 *
 * @param {string|null} iconUrl
 * @param {number} [sizePx]
 * @param {{ monochrome?: boolean }} [options]
 */
export function buildMarkerGlyphHtml(iconUrl, sizePx = DEFAULT_GLYPH_SIZE_PX, options = {}) {
    const safeUrl = sanitizeIconUrl(iconUrl);
    if (!safeUrl) {
        return '';
    }

    const n = Number(sizePx) || DEFAULT_GLYPH_SIZE_PX;
    const monoFilter = options.monochrome === true
        ? 'filter:brightness(0) saturate(100%);opacity:0.88;'
        : '';

    return (
        `<img src="${safeUrl}" alt="" class="geo-map-marker-glyph geo-map-marker-glyph--img" ` +
        `width="${n}" height="${n}" loading="lazy" decoding="async" ` +
        `style="width:${n}px;height:${n}px;max-width:${n}px;max-height:${n}px;${monoFilter}" />`
    );
}

/**
 * Pallino colore per cluster (stato workflow).
 */
/**
 * Tile tipologia nel cluster (farmshops: img/hof.png dentro il cerchio a zoom ≥ 8).
 */
export function buildClusterTypeTileHtml(iconUrl, label = '', size = CLUSTER_DOT_SIZE_PX) {
    const glyph = buildMarkerGlyphHtml(iconUrl, size, { monochrome: false });
    if (!glyph) {
        return '';
    }

    const title = String(label || '').replace(/"/g, '&quot;');

    return (
        `<span class="geo-cluster-type-tile" title="${title}" aria-hidden="true">${glyph}</span>`
    );
}

export function buildClusterTypeDotHtml(color, size = CLUSTER_DOT_SIZE_PX) {
    const fill = normalizeHexColor(color);
    const n = Number(size) || CLUSTER_DOT_SIZE_PX;

    return (
        `<svg class="geo-cluster-type-dot" viewBox="0 0 14 14" width="${n}" height="${n}" ` +
        `aria-hidden="true" focusable="false" style="display:block;flex:0 0 auto;">` +
        `<circle cx="7" cy="7" r="6" fill="${fill}" stroke="#fff" stroke-width="1.5"/></svg>`
    );
}

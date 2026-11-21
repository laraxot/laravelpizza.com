/**
 * Indirizzi dei servizi OpenStreetMap usati dalle mappe.
 *
 * Il layout del progetto puo' dichiarare un proxy sul proprio dominio (config `geo.config.osm_proxy`, rotte api/geo):
 *   <html data-geo-tile-url="/api/geo/tiles/osm/{z}/{x}/{y}.png" data-geo-nominatim-url="/api/geo/nominatim">
 * (su <html>, non su <body>: i temi tengono il body senza attributi).
 * Cosi' il browser del visitatore non contatta terzi. Senza attributi si usano gli indirizzi pubblici di OSMF
 * (tile.openstreetmap.org: i sottodomini a/b/c non sono piu' raccomandati dalla Tile Usage Policy).
 */
const PUBLIC_TILE_URL = 'https://tile.openstreetmap.org/{z}/{x}/{y}.png';
const PUBLIC_NOMINATIM_URL = 'https://nominatim.openstreetmap.org';

function rootData(name) {
    const value = typeof document !== 'undefined' ? document.documentElement?.dataset?.[name] : undefined;

    return typeof value === 'string' && value.trim() !== '' ? value.trim() : null;
}

export function osmTileUrl() {
    return rootData('geoTileUrl') ?? PUBLIC_TILE_URL;
}

/**
 * @param {'search'|'reverse'} endpoint
 * @returns {URL}
 */
export function nominatimUrl(endpoint) {
    const base = (rootData('geoNominatimUrl') ?? PUBLIC_NOMINATIM_URL).replace(/\/+$/, '');

    return new URL(`${base}/${endpoint}`, window.location.origin);
}

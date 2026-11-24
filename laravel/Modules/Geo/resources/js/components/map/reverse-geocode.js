/**
 * Reverse geocoding (Nominatim) — same policy as forward search in controls/search.js (browser fetch).
 */

import { nominatimUrl } from './endpoints.js';

/**
 * @param {number} lat
 * @param {number} lng
 * @returns {Promise<{ display_name: string, raw: object } | null>}
 */
export async function fetchNominatimReverse(lat, lng) {
    const url = nominatimUrl('reverse');
    url.searchParams.set('format', 'json');
    url.searchParams.set('lat', String(lat));
    url.searchParams.set('lon', String(lng));
    url.searchParams.set('addressdetails', '1');
    url.searchParams.set('zoom', '18');

    const response = await fetch(url.toString(), {
        headers: {
            'Accept-Language': document.documentElement.lang || 'it',
        },
    });

    if (!response.ok) {
        throw new Error(`HTTP ${response.status}`);
    }

    const data = await response.json();
    const display_name = data?.display_name;
    if (typeof display_name !== 'string' || display_name.trim() === '') {
        return null;
    }

    return { display_name: display_name.trim(), raw: data };
}

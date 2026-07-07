import { html } from 'lit';
import { geoIcon } from './geo-heroicons.js';

const MIN_QUERY_LENGTH = 3;
const SEARCH_DEBOUNCE_MS = 350;
const NOMINATIM_SEARCH_URL = 'https://nominatim.openstreetmap.org/search';

export function renderSearch(ctx) {
    const labels = ctx.labels || {};
    const placeholder = labels.search_placeholder || 'Cerca indirizzo...';
    const results = Array.isArray(ctx.searchResults) ? ctx.searchResults : [];
    const showResults = Boolean(ctx.showSearchResults && results.length > 0);

    // Expanded state: input + search button + close button + results
    return html`
        <div class="search-box geo-address-search geo-search-expanded"
             @click="${(e) => e.stopPropagation()}">
            <input
                type="text"
                class="map-picker-search-input"
                placeholder="${placeholder}"
                aria-label="${placeholder}"
                autocomplete="off"
                .value="${ctx.searchQuery || ''}"
                @input="${(event) => updateSearchQuery(ctx, event.target.value)}"
                @keydown="${(event) => handleSearchKeydown(ctx, event)}"
            />
            <button
                class="ctrl-btn"
                type="button"
                aria-label="${labels.search || 'Cerca'}"
                title="${labels.search || 'Cerca'}"
                @click="${() => executeAddressSearch(ctx, { selectFirst: true })}"
            >
                ${ctx.isSearching
                    ? html`<svg class="animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" opacity=".25"/><path d="M4 12a8 8 0 018-8" opacity=".75"/></svg>`
                    : geoIcon('magnifying-glass')
                }
                <span class="ctrl-fallback" aria-hidden="true">S</span>
            </button>
            <button
                class="ctrl-btn geo-search-close"
                type="button"
                aria-label="${labels.close_search || 'Chiudi ricerca'}"
                title="${labels.close_search || 'Chiudi ricerca'}"
                @click="${() => closeSearch(ctx)}"
            >
                ${geoIcon('x-mark')}
                <span class="ctrl-fallback" aria-hidden="true">x</span>
            </button>

            ${showResults ? html`
                <ul class="geo-address-search-results" role="listbox">
                    ${results.map((result) => html`
                        <li
                            role="option"
                            @click="${() => selectSearchResult(ctx, result)}"
                            title="${result.display_name || ''}"
                        >
                            ${result.display_name || `${result.lat}, ${result.lon}`}
                        </li>
                    `)}
                </ul>
            ` : ''}
        </div>
    `;
}

/**
 * Close the search panel and clear state.
 * Works for both coordinate-picker (_searchOpen) and geo-map-lit (_isSearchVisible).
 */
export function closeSearch(ctx) {
    ctx._searchOpen = false;
    if ('_isSearchVisible' in ctx) { ctx._isSearchVisible = false; }
    ctx.searchQuery = '';
    ctx.searchResults = [];
    ctx.showSearchResults = false;
    ctx.requestUpdate?.();
}

export function updateSearchQuery(ctx, query) {
    ctx.searchQuery = query || '';
    ctx.showSearchResults = false;

    if (ctx._searchDebounce) {
        clearTimeout(ctx._searchDebounce);
    }

    if (ctx.searchQuery.trim().length >= MIN_QUERY_LENGTH) {
        ctx._searchDebounce = setTimeout(() => {
            void executeAddressSearch(ctx, { selectFirst: false });
        }, SEARCH_DEBOUNCE_MS);
    } else {
        ctx.searchResults = [];
    }

    ctx.requestUpdate?.();
}

export function handleSearchKeydown(ctx, event) {
    if (event.key === 'Escape') {
        closeSearch(ctx);
        return;
    }

    if (event.key === 'Enter') {
        event.preventDefault();
        void executeAddressSearch(ctx, { selectFirst: true });
    }
}

export async function executeAddressSearch(ctx, options = {}) {
    const query = String(ctx.searchQuery || '').trim();
    if (query.length < MIN_QUERY_LENGTH) {
        ctx.searchResults = [];
        ctx.showSearchResults = false;
        ctx.requestUpdate?.();
        return;
    }

    ctx.isSearching = true;
    ctx.requestUpdate?.();

    try {
        const results = await resolveAddressResults(ctx, query);
        ctx.searchResults = Array.isArray(results) ? results : [];
        ctx.showSearchResults = ctx.searchResults.length > 0;

        if (options.selectFirst && ctx.searchResults[0]) {
            selectSearchResult(ctx, ctx.searchResults[0]);
        }
    } catch (error) {
        console.warn('[map-picker-search] Address search failed', error);
        ctx.searchResults = [];
        ctx.showSearchResults = false;
    } finally {
        ctx.isSearching = false;
        ctx.requestUpdate?.();
    }
}

export function selectSearchResult(ctx, result) {
    const lat = Number.parseFloat(result.lat);
    const lng = Number.parseFloat(result.lon ?? result.lng);

    if (!Number.isFinite(lat) || !Number.isFinite(lng)) {
        return;
    }

    const address = result.display_name || `${lat}, ${lng}`;
    const payload = buildLocationPayload(result, lat, lng, address);

    ctx.searchQuery = address;
    ctx.searchResults = [];
    ctx.showSearchResults = false;

    if (typeof ctx._handleSearchSelection === 'function') {
        ctx._handleSearchSelection(result, lat, lng, payload);
    } else if (typeof ctx._handleMapInteraction === 'function') {
        ctx._handleMapInteraction(lat, lng, 'search');
    } else if (ctx._map) {
        ctx._map.setView([lat, lng], Math.max(ctx._map.getZoom(), 16));
    }

    ctx.dispatchEvent(new CustomEvent('address-selected', {
        detail: {
            result,
            address,
            lat,
            lng,
            latitude: lat,
            longitude: lng,
            payload,
        },
        bubbles: true,
        composed: true,
    }));

    ctx.requestUpdate?.();
}

/**
 * Flatten a Nominatim search result into the canonical `location` JSON shape.
 * Keeps the full Nominatim object under `raw` for forensic / future use.
 * Display layer uses lat / lng / address only.
 *
 * @param {Object} result - Nominatim search hit (or compatible payload).
 * @returns {Object}
 */
export function buildLocationPayload(result, lat, lng, address) {
    const details = (result && typeof result.address === 'object' && result.address !== null)
        ? result.address
        : {};

    const firstString = (...candidates) => {
        for (const value of candidates) {
            if (typeof value === 'string' && value.trim() !== '') {
                return value;
            }
        }
        return null;
    };

    return {
        lat,
        lng,
        latitude: lat,
        longitude: lng,
        address,
        display_name: result?.display_name ?? address,
        provider: 'nominatim',
        place_id: result?.place_id ?? null,
        osm_type: result?.osm_type ?? null,
        osm_id: result?.osm_id ?? null,
        licence: result?.licence ?? null,
        importance: typeof result?.importance === 'number' ? result.importance : null,
        type: result?.type ?? null,
        class: result?.class ?? null,
        boundingbox: Array.isArray(result?.boundingbox) ? result.boundingbox : null,
        street: firstString(details.road, details.pedestrian, details.footway, details.path, details.residential, details.highway),
        street_number: firstString(details.house_number),
        zip: firstString(details.postcode),
        postcode: firstString(details.postcode),
        city: firstString(details.city, details.town, details.village, details.municipality, details.hamlet, details.county),
        suburb: firstString(details.suburb, details.neighbourhood, details.quarter, details.city_district),
        province: firstString(details.province, details.county, details.state_district),
        state: firstString(details.state, details.region),
        country: firstString(details.country),
        country_code: firstString(details.country_code),
        address_details: details,
        raw: result,
    };
}

async function resolveAddressResults(ctx, query) {
    if (typeof ctx.searchAddress === 'function') {
        return ctx.searchAddress(query);
    }

    const url = new URL(NOMINATIM_SEARCH_URL);
    url.searchParams.set('format', 'json');
    url.searchParams.set('addressdetails', '1');
    url.searchParams.set('limit', '5');
    url.searchParams.set('q', query);

    const response = await fetch(url.toString(), {
        headers: { 'Accept-Language': document.documentElement.lang || 'it' },
    });

    if (!response.ok) {
        throw new Error(`HTTP ${response.status}`);
    }

    return response.json();
}

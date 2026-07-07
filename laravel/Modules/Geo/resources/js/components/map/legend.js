import { resolveFeatureTicketStatus } from './feature-status.js';

/**
 * Stati unici nel dataset visibile — colore pin = TicketStatusEnum (STORY-125).
 * Tipologie: solo in sidebar filtri (icona), non in legenda mappa.
 *
 * @param {Array<{ properties?: Record<string, unknown> }>} features
 * @returns {Array<{ value: string, label: string, color: string }>}
 */
export function collectLegendStatusesFromFeatures(features) {
    if (!Array.isArray(features) || features.length === 0) {
        return [];
    }

    const byValue = new Map();

    for (const feature of features) {
        const status = resolveFeatureTicketStatus(feature.properties || {});
        if (!byValue.has(status.value)) {
            byValue.set(status.value, {
                value: status.value,
                label: status.label,
                color: status.color,
            });
        }
    }

    return [...byValue.values()].sort((a, b) =>
        a.label.localeCompare(b.label, 'it', { sensitivity: 'base' }),
    );
}

/** @deprecated Usare collectLegendStatusesFromFeatures — tipologie sono in sidebar filtri */
export function collectLegendTypesFromFeatures(features) {
    return collectLegendStatusesFromFeatures(features);
}

/**
 * @param {string} title
 * @param {Array<{ label: string, color: string }>} types
 */
export function buildMapLegendHtml(title, types) {
    if (!Array.isArray(types) || types.length === 0) {
        return '';
    }

    const items = types
        .map(
            (type) =>
                `<div class="geo-map-legend-item" data-status="${type.value}">` +
                `<span class="geo-map-legend-color" style="background-color:${type.color}"></span>` +
                `<span class="geo-map-legend-label">${type.label}</span>` +
                `</div>`,
        )
        .join('');

    return (
        `<div class="geo-map-legend-inner">` +
        `<strong class="geo-map-legend-title">${title}</strong>` +
        `<div class="geo-map-legend-items">${items}</div>` +
        `</div>`
    );
}

/**
 * Leaflet control — legenda tipologie (STORY-094).
 *
 * @param {typeof import('leaflet')} Lref
 * @param {import('leaflet').Map} map
 * @param {Array<{ value: string, label: string, color: string }>} types
 * @param {{ title?: string, position?: string }} [options]
 * @returns {import('leaflet').Control | null}
 */
export function mountMapLegend(Lref, map, types, options = {}) {
    if (!map || !Array.isArray(types) || types.length === 0) {
        return null;
    }

    const title = options.title ?? 'Tipologie';
    const position = options.position ?? 'bottomleft';

    const control = Lref.control({ position });
    control.onAdd = function onAdd() {
        const div = Lref.DomUtil.create('div', 'geo-map-legend');
        div.innerHTML = buildMapLegendHtml(title, types);
        Lref.DomEvent.disableClickPropagation(div);
        Lref.DomEvent.disableScrollPropagation(div);
        return div;
    };

    control.addTo(map);

    return control;
}

/**
 * @param {import('leaflet').Control | null} control
 * @param {Array<{ value: string, label: string, color: string }>} types
 * @param {string} [title]
 */
export function refreshMapLegend(control, types, title = 'Tipologie') {
    if (!control || typeof control.getContainer !== 'function') {
        return;
    }

    const container = control.getContainer();
    if (!container) {
        return;
    }

    container.innerHTML = buildMapLegendHtml(title, types);
}

import { LitElement, html } from 'lit';
import { customElement, property } from 'lit/decorators.js';

/**
 * map-filter-lit
 * Web component per filtrare i marker del map-lit per tipo.
 * Usato insieme a <map-lit> nella pagina ticket-list.
 *
 * Aggiorna anche l'elemento puntato dall'attributo `results-target`
 * con il numero di risultati correnti (template ":count" nel
 * `data-count-template`).
 *
 * @example
 * <map-filter-lit map-id="ticket-map"></map-filter-lit>
 */
class MapFilterLit extends LitElement {
    static properties = {
        mapId: { type: String, attribute: 'map-id' },
        filters: { type: String },
        total: { type: Number },
        types: { type: Array, state: true },
        counts: { type: Object, state: true },
    };

    createRenderRoot() { return this; }

    constructor() {
        super();
        this.mapId = 'ticket-map';
        this.filters = '[]';
        this.total = 0;
        this.types = [];
        this.counts = {};
    }

    connectedCallback() {
        super.connectedCallback();
        this._readFilters();
        this._initFromMap();
    }

    _readFilters() {
        try {
            const parsed = JSON.parse(this.filters || '[]');
            if (Array.isArray(parsed) && parsed.length > 0) {
                this.types = parsed.map(item => ({
                    value: String(item.value || item.id || ''),
                    label: String(item.display_label || item.label || item.value || item.id || ''),
                    count: Number(item.count || 0),
                })).filter(item => item.value !== '');
                this.counts = Object.fromEntries(this.types.map(item => [item.value, item.count]));
            }
        } catch (_) {
            this.types = [];
        }
    }

    _initFromMap() {
        // Leggi i tipi disponibili dal map-lit caricato
        const mapEl = document.getElementById(this.mapId);
        if (mapEl && mapEl._allFeatures) {
            const typeCounts = {};
            mapEl._allFeatures.forEach(f => {
                const t = f.properties?.type;
                const typeVal = (typeof t === 'object' ? t.value : t) || 'other';
                typeCounts[typeVal] = (typeCounts[typeVal] || 0) + 1;
            });
            if (Object.keys(typeCounts).length > 0) {
                this.types = Object.keys(typeCounts).map(value => ({ value, label: value, count: typeCounts[value] }));
                this.counts = typeCounts;
                this.requestUpdate();
            }
        }
    }

    _checkedTypes() {
        return [...this.querySelectorAll('input[data-type]:checked')]
            .map(inp => inp.dataset.type);
    }

    _handleTypeChange() {
        const mapEl = document.getElementById(this.mapId);
        const checkedTypes = this._checkedTypes();

        if (mapEl && typeof mapEl.filterByTypes === 'function') {
            mapEl.filterByTypes(checkedTypes.length > 0 ? checkedTypes : null);
        }
        this._updateResultsCount(checkedTypes);
    }

    _updateResultsCount(checkedTypes) {
        const targetSelector = this.getAttribute('results-target');
        if (!targetSelector) return;
        const target = document.querySelector(targetSelector);
        if (!target) return;

        let count = 0;
        const mapEl = document.getElementById(this.mapId);
        if (mapEl && Array.isArray(mapEl._allFeatures)) {
            if (!checkedTypes || checkedTypes.length === 0) {
                count = mapEl._allFeatures.length;
            } else {
                count = mapEl._allFeatures.filter(f => {
                    const t = f.properties?.type;
                    const typeVal = (typeof t === 'object' ? t.value : t) || 'other';
                    return checkedTypes.includes(typeVal);
                }).length;
            }
        }
        const template = target.getAttribute('data-count-template') || '';
        target.textContent = template ? template.replace(':count', String(count)) : String(count);
    }

    render() {
        if (this.types.length === 0) return '';

        const title = this.getAttribute('title') || '';
        return html`
            ${title ? html`<div class="map-filter-title">${title}</div>` : ''}
            <ul class="categoy-list pb-4">
                ${this.types.map((type, index) => html`
                    <li>
                        <div class="form-check">
                            <div class="checkbox-body border-light py-1">
                                <input
                                    type="checkbox"
                                    id="${this.mapId}-filter-${index}"
                                    name="category"
                                    data-type="${type.value}"
                                    @change="${this._handleTypeChange}"
                                >
                                <label for="${this.mapId}-filter-${index}" class="subtitle-small_semi-bold mb-0 category-list__list">${type.label} (${type.count || 0})</label>
                            </div>
                        </div>
                    </li>
                `)}
            </ul>`;
    }
}

if (!customElements.get('map-filter-lit')) {
    customElements.define('map-filter-lit', MapFilterLit);
}

export default MapFilterLit;

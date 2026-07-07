import { LitElement, html } from 'lit';
import { customElement, property } from 'lit/decorators.js';

/**
 * map-filter-lit
 * Web component per filtrare i marker del map-lit per tipo.
 * Usato insieme a <map-lit> nella pagina ticket-list.
 *
 * @example
 * <map-filter-lit map-id="ticket-map"></map-filter-lit>
 */
class MapFilterLit extends LitElement {
    static properties = {
        mapId: { type: String, attribute: 'map-id' },
        types: { type: Array, state: true },
        counts: { type: Object, state: true },
    };

    createRenderRoot() { return this; }

    constructor() {
        super();
        this.mapId = 'ticket-map';
        this.types = [];
        this.counts = {};
    }

    connectedCallback() {
        super.connectedCallback();
        this._initFromMap();
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
            this.types = Object.keys(typeCounts);
            this.counts = typeCounts;
            this.requestUpdate();
        }
    }

    _handleTypeChange(e) {
        const target = e.target;
        const type = target.dataset.type;
        const mapEl = document.getElementById(this.mapId);

        if (mapEl && typeof mapEl.filterByTypes === 'function') {
            // Get all checked types
            const checkedTypes = [...this.renderRoot.querySelectorAll('input[data-type]:checked')]
                .map(inp => inp.dataset.type);
            mapEl.filterByTypes(checkedTypes.length > 0 ? checkedTypes : null);
        }
    }

    render() {
        if (this.types.length === 0) return '';

        return html`
            <style>
                .map-filter-container { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1rem; }
                .map-filter-item { display: flex; align-items: center; gap: 0.25rem; padding: 0.25rem 0.5rem; border-radius: 0.5rem; background: #f3f4f6; cursor: pointer; }
                .map-filter-item:hover { background: #e5e7eb; }
                .map-filter-item input { cursor: pointer; }
            </style>
            <div class="map-filter-container">
                ${this.types.map(type => html`
                    <label class="map-filter-item">
                        <input type="checkbox" data-type="${type}" @change="${this._handleTypeChange}" checked>
                        <span>${type}</span>
                        <small>(${this.counts[type] || 0})</small>
                    </label>
                `)}
            </div>
        `;
    }
}

if (!customElements.get('map-filter-lit')) {
    customElements.define('map-filter-lit', MapFilterLit);
}

export default MapFilterLit;
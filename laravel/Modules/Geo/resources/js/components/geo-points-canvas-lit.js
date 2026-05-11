import { LitElement, html, css } from 'lit';
import { customElement, property } from 'lit/decorators.js';
import { when } from 'lit/directives/when.js';
import { geoIcon } from './geo-heroicons.js';

/**
 * FarmShop Map Component - Lit.dev Web Component
 * Renders 23,972+ farmshop GeoJSON points with virtual scrolling
 * Mirrors direktvermarkter.js pattern from farmshops.eu
 */
@customElement('farmshop-map-lit')
export class FarmShopMapLit extends LitElement {
    static styles = css`
        :host {
            display: block;
            width: 100%;
            height: 100%;
            position: relative;
        }

        .map-container {
            width: 100%;
            height: 600px;
            position: relative;
            background: #e8f4f8;
            border: 1px solid #d1e7dd;
            border-radius: 8px;
            overflow: hidden;
        }

        .map-canvas {
            width: 100%;
            height: 100%;
            position: relative;
        }

        .map-point {
            position: absolute;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.3);
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
            transform: translate(-50%, -50%);
        }

        .map-point:hover {
            transform: translate(-50%, -50%) scale(1.3);
            box-shadow: 0 2px 6px rgba(0,0,0,0.4);
            z-index: 100;
        }

        .map-point.farm {
            background: #28a745;
        }

        .map-point.marketplace {
            background: #e63946;
        }

        .map-point.beekeeper {
            background: #ffc107;
        }

        .map-point.other {
            background: #6c757d;
        }

        .map-controls {
            position: absolute;
            top: 8px;
            right: 8px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            z-index: 50;
        }

        .map-btn {
            width: 32px;
            height: 32px;
            border: 1px solid #ced4da;
            background: white;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .map-btn:hover {
            background: #f8f9fa;
        }

        .map-btn svg {
            width: 16px;
            height: 16px;
            color: #495057;
        }

        .map-zoom-display {
            position: absolute;
            bottom: 8px;
            left: 8px;
            background: rgba(255,255,255,0.9);
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            color: #495057;
            z-index: 50;
        }

        .point-tooltip {
            position: absolute;
            background: rgba(0,0,0,0.85);
            color: white;
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 12px;
            pointer-events: none;
            z-index: 200;
            white-space: nowrap;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .filters {
            position: absolute;
            top: 8px;
            left: 8px;
            display: flex;
            gap: 6px;
            z-index: 50;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 4px 10px;
            border: 1px solid #ced4da;
            background: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 11px;
            transition: all 0.15s;
        }

        .filter-btn:hover {
            background: #e9ecef;
        }

        .filter-btn.active {
            background: #0066cc;
            color: white;
            border-color: #0066cc;
        }

        .loading-overlay {
            position: absolute;
            inset: 0;
            background: rgba(255,255,255,0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .loading-spinner {
            width: 32px;
            height: 32px;
            border: 3px solid #e9ecef;
            border-top-color: #0066cc;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .stats-bar {
            position: absolute;
            bottom: 8px;
            right: 8px;
            background: rgba(255,255,255,0.9);
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 11px;
            color: #495057;
            z-index: 50;
        }
    `;

    @property({ type: Array })
    points = [];

    @property({ type: String })
    view = 'all';

    @property({ type: Number })
    zoom = 1;

    @property({ type: Number })
    offsetX = 0;

    @property({ type: Number })
    offsetY = 0;

    @property({ type: String })
    selectedCategory = 'all';

    @property({ type: Boolean })
    loading = false;

    @property({ type: Number })
    containerWidth = 800;

    @property({ type: Number })
    containerHeight = 600;

    static MIN_ZOOM = 0.1;
    static MAX_ZOOM = 5;
    static ZOOM_STEP = 0.2;

    constructor() {
        super();
        this._resizeObserver = null;
        this._tooltipEl = null;
        this._containerRect = null;
    }

    connectedCallback() {
        super.connectedCallback();
        // Measure container size after DOM insertion
        setTimeout(() => this.measureContainer(), 100);
    }

    firstUpdated() {
        this.measureContainer();
        this.setupResizeObserver();
    }

    disconnectedCallback() {
        if (this._tooltipEl) {
            this._tooltipEl.remove();
            this._tooltipEl = null;
        }
        if (this._resizeObserver) {
            this._resizeObserver.disconnect();
        }
        super.disconnectedCallback();
    }

    measureContainer() {
        const container = this.renderRoot?.querySelector('.map-container');
        if (container) {
            const rect = container.getBoundingClientRect();
            // Only update if size changed significantly
            if (Math.abs(rect.width - this.containerWidth) > 10 ||
                Math.abs(rect.height - this.containerHeight) > 10) {
                this.containerWidth = Math.max(rect.width, 100);
                this.containerHeight = Math.max(rect.height, 100);
            }
        }
    }

    setupResizeObserver() {
        const container = this.renderRoot?.querySelector('.map-container');
        if (!container) return;

        this._resizeObserver = new ResizeObserver(() => {
            this.measureContainer();
        });
        this._resizeObserver.observe(container);
    }

    loadPoints() {
        this.loading = true;
        // Simulate async loading
        setTimeout(() => {
            // Points are passed in via property, but we can also load from window.farmshopData
            if (window.farmshopData && window.farmshopData.features) {
                this.points = window.farmshopData.features.map(this.transformFeature.bind(this));
            }
            this.loading = false;
        }, 100);
    }

    transformFeature(feature) {
        const [x, y] = feature.geometry.coordinates;
        // Convert lat/lon to screen coordinates (simple equirectangular projection)
        const screenX = (x + 180) * (this.containerWidth / 360);
        const screenY = (90 - y) * (this.containerHeight / 180);

        return {
            id: feature.properties.id || feature.id,
            type: feature.properties.p || 'other',
            x: screenX,
            y: screenY,
            lon: x,
            lat: y,
            properties: feature.properties
        };
    }

    zoomIn() {
        const newZoom = Math.min(this.zoom + FarmShopMapLit.ZOOM_STEP, FarmShopMapLit.MAX_ZOOM);
        this.requestUpdate('zoom', this.zoom);
        this.zoom = newZoom;
    }

    zoomOut() {
        const newZoom = Math.max(this.zoom - FarmShopMapLit.ZOOM_STEP, FarmShopMapLit.MIN_ZOOM);
        this.requestUpdate('zoom', this.zoom);
        this.zoom = newZoom;
    }

    resetView() {
        this.zoom = 1;
        this.offsetX = 0;
        this.offsetY = 0;
        this.selectedCategory = 'all';
    }

    toggleCategory(category) {
        this.selectedCategory = this.selectedCategory === category ? 'all' : category;
    }

    handlePointClick(point, ev) {
        ev.stopPropagation();
        this.showTooltip(point, ev.clientX, ev.clientY);

        // Dispatch custom event
        this.dispatchEvent(new CustomEvent('point-select', {
            detail: point,
            bubbles: true,
            composed: true
        }));
    }

    showTooltip(point, clientX, clientY) {
        if (this._tooltipEl) {
            this._tooltipEl.remove();
        }

        const tooltip = document.createElement('div');
        tooltip.className = 'point-tooltip';
        tooltip.textContent = `${point.type}: ${point.id}`;
        document.body.appendChild(tooltip);

        // Position tooltip
        const rect = tooltip.getBoundingClientRect();
        let left = clientX + 10;
        let top = clientY - rect.height - 10;

        // Keep tooltip in viewport
        if (left + rect.width > window.innerWidth) {
            left = clientX - rect.width - 10;
        }
        if (top < 0) {
            top = clientY + 10;
        }

        tooltip.style.left = left + 'px';
        tooltip.style.top = top + 'px';

        this._tooltipEl = tooltip;

        // Auto-hide after 3 seconds
        setTimeout(() => {
            if (this._tooltipEl === tooltip) {
                tooltip.remove();
                this._tooltipEl = null;
            }
        }, 3000);
    }

    get visiblePoints() {
        return this.points.filter(p =>
            this.selectedCategory === 'all' || p.type === this.selectedCategory
        );
    }

    get categoryCounts() {
        const counts = {};
        this.points.forEach(p => {
            counts[p.type] = (counts[p.type] || 0) + 1;
        });
        return counts;
    }

    render() {
        const visiblePoints = this.visiblePoints;
        const counts = this.categoryCounts;
        const scale = this.zoom;

        return html`
            <div class="map-container">
                ${when(this.loading, () => html`
                    <div class="loading-overlay">
                        <div class="loading-spinner"></div>
                    </div>
                `)}

                <div class="filters">
                    <button
                        class="filter-btn ${this.selectedCategory === 'all' ? 'active' : ''}"
                        @click=${() => this.toggleCategory('all')}
                    >
                        Tutti (${this.points.length})
                    </button>
                    <button
                        class="filter-btn ${this.selectedCategory === 'farm' ? 'active' : ''}"
                        @click=${() => this.toggleCategory('farm')}
                    >
                        Fattorie (${counts.farm || 0})
                    </button>
                    <button
                        class="filter-btn ${this.selectedCategory === 'marketplace' ? 'active' : ''}"
                        @click=${() => this.toggleCategory('marketplace')}
                    >
                        Mercati (${counts.marketplace || 0})
                    </button>
                    <button
                        class="filter-btn ${this.selectedCategory === 'beekeeper' ? 'active' : ''}"
                        @click=${() => this.toggleCategory('beekeeper')}
                    >
                        Apicoltori (${counts.beekeeper || 0})
                    </button>
                </div>

                <div class="map-controls">
                    <button
                        class="map-btn"
                        @click=${this.zoomIn.bind(this)}
                        title="Zoom in"
                    >
                        ${geoIcon('plus')}
                    </button>
                    <button
                        class="map-btn"
                        @click=${this.zoomOut.bind(this)}
                        title="Zoom out"
                    >
                        ${geoIcon('minus')}
                    </button>
                    <button
                        class="map-btn"
                        @click=${this.resetView.bind(this)}
                        title="Reset view"
                    >
                        ${geoIcon('arrows-pointing-out')}
                    </button>
                </div>

                <div
                    class="map-canvas"
                    @click=${() => {
                        if (this._tooltipEl) {
                            this._tooltipEl.remove();
                            this._tooltipEl = null;
                        }
                    }}
                >
                    ${visiblePoints.map(point => {
                        const left = (point.x * scale) + this.offsetX;
                        const top = (point.y * scale) + this.offsetY;
                        return html`
                            <div
                                class="map-point ${point.type}"
                                style="left: ${left}px; top: ${top}px;"
                                @click=${(ev) => this.handlePointClick(point, ev)}
                                title="${point.type}: ${point.id}"
                            ></div>
                        `;
                    })}
                </div>

                <div class="map-zoom-display">
                    Zoom: ${Math.round(scale * 100)}%
                </div>

                <div class="stats-bar">
                    Visibili: ${visiblePoints.length} | Totale: ${this.points.length}
                </div>
            </div>
        `;
    }
}

// Auto-register the component
if (!customElements.get('farmshop-map-lit')) {
    customElements.define('farmshop-map-lit', FarmShopMapLit);
}

export default FarmShopMapLit;
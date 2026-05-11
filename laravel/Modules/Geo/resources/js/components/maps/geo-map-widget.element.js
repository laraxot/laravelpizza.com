import { LitElement, html, css } from 'lit';
import { GeoMapState } from './geo-map-state';
import { GeoMapGeoJsonAdapter } from './geo-map-geojson-adapter';
import { GeoMapPopupRenderer } from './geo-map-popup-renderer';
import { GeoMapLeafletRenderer } from './geo-map-leaflet-renderer';
import { GeoMapLayerManager } from './geo-map-layer-manager';

export class GeoMapWidgetElement extends LitElement {
    static properties = {
        filterText: { state: true },
        layerConfig: { state: true },
        selectedTitle: { state: true },
    };

    static styles = css`
        :host {
            display: block;
        }

        .geo-map-widget {
            display: grid;
            gap: 1rem;
        }

        .geo-map-widget__toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            align-items: center;
            justify-content: space-between;
        }

        .geo-map-widget__layers {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .geo-map-widget__map-shell {
            position: relative;
            min-height: 520px;
            border: 1px solid #d1d5db;
            border-radius: 1rem;
            overflow: hidden;
            background: #f8fafc;
        }

        .geo-map-widget__map {
            width: 100%;
            min-height: 520px;
        }

        .geo-map-widget__controls {
            position: absolute;
            top: 1rem;
            right: 1rem;
            z-index: 500;
            display: flex;
            gap: 0.5rem;
        }

        button,
        input {
            font: inherit;
        }

        .geo-map-widget__button {
            border: 1px solid #cbd5e1;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 9999px;
            padding: 0.5rem 0.9rem;
            cursor: pointer;
        }

        .geo-map-widget__search {
            min-width: 240px;
            border: 1px solid #cbd5e1;
            border-radius: 9999px;
            padding: 0.6rem 0.9rem;
            background: #fff;
        }

        .geo-map-widget__selection {
            font-size: 0.95rem;
            color: #334155;
        }
    `;

    constructor() {
        super();
        this.filterText = '';
        this.layerConfig = [];
        this.selectedTitle = '';
        this.state = null;
        this.adapter = null;
        this.renderer = null;
        this.layerManager = null;
        this.unsubscribe = null;
    }

    createRenderRoot() {
        return this;
    }

    render() {
        return html`
            <div class="geo-map-widget">
                <div class="geo-map-widget__toolbar">
                    <div class="geo-map-widget__layers">
                        ${this.layerConfig.map((layer) => html`
                            <label>
                                <input
                                    type="checkbox"
                                    .checked=${Boolean(layer.enabled)}
                                    @change=${(event) => this.toggleLayer(layer.key, event.target.checked)}
                                >
                                ${layer.label}
                            </label>
                        `)}
                    </div>
                    <input
                        class="geo-map-widget__search"
                        type="search"
                        placeholder="Filtra per nome, categoria o indirizzo"
                        .value=${this.filterText}
                        @input=${(event) => this.updateFilter(event.target.value)}
                    >
                </div>

                <div class="geo-map-widget__selection">
                    ${this.selectedTitle !== '' ? `Selezionato: ${this.selectedTitle}` : 'Nessun punto selezionato'}
                </div>

                <div class="geo-map-widget__map-shell">
                    <div class="geo-map-widget__controls">
                        <button class="geo-map-widget__button" type="button" @click=${this.toggleBaseLayer}>
                            Base layer
                        </button>
                        <button class="geo-map-widget__button" type="button" @click=${this.toggleFullscreen}>
                            Fullscreen
                        </button>
                    </div>
                    <div class="geo-map-widget__map" data-map></div>
                </div>
            </div>
        `;
    }

    firstUpdated() {
        const payload = this.readPayload();

        if (!payload) {
            return;
        }

        this.layerConfig = payload.layerConfig ?? [];
        this.state = new GeoMapState(payload);
        this.adapter = new GeoMapGeoJsonAdapter(payload.geoJson);
        this.renderer = new GeoMapLeafletRenderer(this.querySelector('[data-map]'), new GeoMapPopupRenderer());
        this.renderer.init(payload.initialState.center, payload.initialState.zoom);

        this.layerManager = new GeoMapLayerManager(this.renderer, this.adapter);
        this.layerManager.build((feature) => this.handleFeatureSelected(feature), this.state.filters);
        this.layerManager.sync([...this.state.activeLayers]);

        this.renderer.map.on('zoomend moveend', () => {
            const center = this.renderer.map.getCenter();
            this.state.setViewport({ lat: center.lat, lng: center.lng }, this.renderer.map.getZoom());
            this.refreshLodLayers();
        });

        this.unsubscribe = this.state.subscribe((snapshot, reason) => {
            if (reason === 'filters') {
                this.layerManager.rebuild(
                    (feature) => this.handleFeatureSelected(feature),
                    snapshot.filters,
                    snapshot.activeLayers,
                );
            } else if (reason === 'layers') {
                this.layerManager.sync(snapshot.activeLayers);
            }
        });

        document.addEventListener('fullscreenchange', () => this.renderer.invalidateSize());
        this.renderer.invalidateSize();
    }

    disconnectedCallback() {
        this.unsubscribe?.();
        super.disconnectedCallback();
    }

    readPayload() {
        const payloadNode = this.querySelector('[data-geo-map-payload]');

        if (!(payloadNode instanceof HTMLScriptElement)) {
            return null;
        }

        try {
            return JSON.parse(payloadNode.textContent ?? '{}');
        } catch (error) {
            console.error('Invalid geo map payload', error);

            return null;
        }
    }

    updateFilter(value) {
        this.filterText = value;
        this.state?.setFilterText(value);
    }

    toggleLayer(key, enabled) {
        this.layerConfig = this.layerConfig.map((layer) => layer.key === key ? { ...layer, enabled } : layer);
        this.state?.setActiveLayer(key, enabled);
    }

    toggleBaseLayer = () => {
        this.renderer?.toggleBaseLayer();
    };

    toggleFullscreen = () => {
        const shell = this.querySelector('.geo-map-widget__map-shell');

        if (!(shell instanceof HTMLElement)) {
            return;
        }

        if (!document.fullscreenElement) {
            shell.requestFullscreen().catch(() => {});
        } else {
            document.exitFullscreen().catch(() => {});
        }

        this.renderer?.invalidateSize();
    };

    handleFeatureSelected(feature) {
        this.state?.setSelectedId(feature.properties?.id ?? null);
        this.selectedTitle = String(feature.properties?.title ?? feature.properties?.name ?? '');
    }

    refreshLodLayers() {
        const zoom = this.renderer.map.getZoom();
        const shouldShowPoints = zoom >= 13;
        const shouldShowCluster = zoom < 13;

        this.layerConfig = this.layerConfig.map((layer) => {
            if (layer.key === 'points') {
                return { ...layer, enabled: shouldShowPoints };
            }

            if (layer.key === 'cluster') {
                return { ...layer, enabled: shouldShowCluster };
            }

            return layer;
        });

        this.state?.setActiveLayer('points', shouldShowPoints);
        this.state?.setActiveLayer('cluster', shouldShowCluster);
    }
}

if (!customElements.get('geo-map-widget')) {
    customElements.define('geo-map-widget', GeoMapWidgetElement);
}

import { LitElement, html, css } from '@theme-lit';
import L from '@theme-leaflet';

/**
 * MyMap - Custom map component.
 * Zen: Personality. Represents the specific intent of the author.
 * 
 * Commandment 4: Thou shalt be encapsulated (Shadow DOM).
 */
export class MyMap extends LitElement {
    static properties = {
        lat: { type: Number },
        lng: { type: Number },
        zoom: { type: Number },
        height: { type: String },
        interactive: { type: Boolean },
        markerTitle: { type: String, attribute: 'marker-title' },
    };

    static styles = css`
        :host {
            display: block;
            width: 100%;
        }
        .map-wrapper {
            width: 100%;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            background: #f3f4f6;
        }
        .map-canvas {
            width: 100%;
            height: 100%;
        }
    `;

    constructor() {
        super();
        this.lat = 45.6669;
        this.lng = 12.2423;
        this.zoom = 10;
        this.height = '400px';
        this.interactive = true;
        this.markerTitle = 'My Map';
        
        this._map = null;
        this._marker = null;
    }

    render() {
        return html`
            <div class="map-wrapper" style="height: ${this.height};">
                <div class="map-canvas"></div>
            </div>
        `;
    }

    firstUpdated() {
        this._initMap();
    }

    _initMap() {
        const mapEl = this.shadowRoot.querySelector('.map-canvas');
        if (!mapEl) return;

        this._map = L.map(mapEl).setView([this.lat, this.lng], this.zoom);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors',
        }).addTo(this._map);

        this._marker = L.marker([this.lat, this.lng], {
            draggable: this.interactive,
        })
            .addTo(this._map)
            .bindPopup(this.markerTitle);

        if (this.interactive) {
            this._marker.on('dragend', () => {
                const position = this._marker?.getLatLng();
                if (!position) return;
                this.lat = position.lat;
                this.lng = position.lng;
                this.dispatchCoordinatesChanged();
            });

            this._map.on('click', (event) => {
                this.lat = event.latlng.lat;
                this.lng = event.latlng.lng;
                this._marker?.setLatLng(event.latlng);
                this.dispatchCoordinatesChanged();
            });
        }

        setTimeout(() => this._map.invalidateSize(), 150);
    }

    updated(changedProperties) {
        if (!this._map) return;

        if (changedProperties.has('lat') || changedProperties.has('lng') || changedProperties.has('zoom')) {
            this._map.setView([this.lat, this.lng], this.zoom);
            if (this._marker) {
                this._marker.setLatLng([this.lat, this.lng]);
            }
        }
    }

    dispatchCoordinatesChanged() {
        this.dispatchEvent(new CustomEvent('map-coordinates-changed', {
            bubbles: true,
            composed: true,
            detail: {
                lat: this.lat,
                lng: this.lng,
                zoom: this.zoom,
            },
        }));
    }

    disconnectedCallback() {
        if (this._map) {
            this._map.remove();
            this._map = null;
        }
        this._marker = null;
        super.disconnectedCallback();
    }
}

if (!customElements.get('my-map')) {
    customElements.define('my-map', MyMap);
}

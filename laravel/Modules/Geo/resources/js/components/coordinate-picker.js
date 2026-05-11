import { LitElement, html, css } from 'lit';
import { map } from 'lit/directives/map.js';
import L from 'leaflet';

export class CoordinatePickerLit extends LitElement {
    static properties = {
        latitude: { type: Number },
        longitude: { type: Number },
        zoom: { type: Number },
        height: { type: String },
        isExpanded: { type: Boolean },
        marker: { type: Object }
    };

    static styles = css`
        :host {
            display: block;
            width: 100%;
        }
        #map {
            width: 100%;
            height: ${props => props.height};
            min-height: 200px;
            border-radius: 4px;
            border: 1px solid #e2e8f0;
            transition: height 0.3s ease;
        }
        #map.fullscreen {
            height: calc(100vh - env(safe-area-inset-bottom));
        }
        .leaflet-container {
            background: #fff;
        }
        .controls {
            display: flex;
            gap: 8px;
            margin-top: 8px;
            justify-content: end;
        }
        .btn {
            padding: 4px 8px;
            background: #f3f4f6;
            border: 1px solid #9ca3af;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: background-color 0.2s;
        }
        .btn:hover {
            background: #e5e7eb;
        }
        .btn-primary {
            background: #2563eb;
            color: white;
        }
        .btn-primary:hover {
            background: #1d4ed8;
        }
        .info-box {
            max-height: 150px;
            overflow-y: auto;
            padding: 8px;
            background: #f8f9fa;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            font-size: 14px;
            line-height: 1.4;
        }
    `;

    constructor() {
        super();
        this.latitude = null;
        this.longitude = null;
        this.zoom = 15;
        this.height = '340px';
        this.isExpanded = false;
        this.marker = null;
    }

    updated(changedProps) {
        if (changedProps.has('latitude') || changedProps.has('longitude')) {
            if (this.latitude !== null && this.longitude !== null) {
                this._setView([this.latitude, this.longitude], this.zoom);
            }
        }
        if (changedProps.has('zoom')) {
            this._map.setZoom(this.zoom);
        }
        if (changedProps.has('height')) {
            this._map.invalidateSize();
        }
        if (changedProps.has('isExpanded')) {
            if (this.isExpanded) {
                this.shadowRoot.getElementById('map')?.classList.add('fullscreen');
            } else {
                this.shadowRoot.getElementById('map')?.classList.remove('fullscreen');
            }
        }
    }

    render() {
        return html`
            <div id="map" class="${this.isExpanded ? 'fullscreen' : ''}" style="height: ${this.height};"></div>
            <div class="controls">
                <button class="btn" @click=${() => this.zoomOut()} title="Zoom out">&#124;&#124;</button>
                <button class="btn" @click=${() => this.zoomIn()} title="Zoom in" class="btn-primary">&#62;&#62;</button>
                <button class="btn" @click=${() => this.toggleFullscreen()} title="Toggle fullscreen">
                    ${this.isExpanded ? '&#108;&#101;&#97;&#116;&#32;&#102;&#117;&#108;&#101;' : '&#101;&#119;&#101;&#114;&#116;'}
                </button>
                <button class="btn" @click=${() => this.expandInfo()} title="Show address details" class="btn-primary">Info</button>
            </div>
            <div class="info-box" @click="collapseInfo">
                <strong>Address:</strong> <span x-text="address || '---'"></strong>
                <div x-show="detailsOpen" x-data="{open:false}" @click={() => detailsOpen = !detailsOpen}">
                    <template x-if="detailsOpen">
                        <p class="mt-2 text-sm"><strong<strong>Formatted Address:</strong>&nbsp;<span x-text="formattedAddress || '---'"></span></p>
                        <p class="text-sm"><strong<strong>Coordinates:</strong>&nbsp;<span x-text="`${latitude}|${longitude}`"></span></p>
                    </template>
                </p>
            </div>

            <coordinate-picker-lit
                latitude="${this.latitude ?? 0}"
                longitude="${this.longitude ?? 0}"
                zoom="${this.zoom}"
                height="${this.height}"
                @coords-changed="${this._handleCoordsChanged}"
            ></coordinate-picker-lit>

            <div x-data="{detailsOpen:false, address:'', formattedAddress:'', latitude: ${this.latitude ?? 0}, longitude: ${this.longitude ?? 0}'}"
                 class="fixed-inside-bottom-right right-2 bottom-2 p-2 bg-white rounded shadow-lg z-10 overflow-hidden">
                <button @click.stop="detailsOpen=!detailsOpen" title="Toggle address details" class="btn btn-sm" style="width:100%;margin-bottom:4px;">
                    Address Details
                </button>
                <p class="text-xs mt-1" x-show="detailsOpen" x-text="address"></p>
                <p class="text-xs mt-2" x-show="detailsOpen" x-text="formattedAddress"></p>
                <div class="text-xs" x-show="detailsOpen">
                    Coordinates: <span x-text="`${latitude}|${longitude}`"></span>
                </div>
            </div>
        `;
    }

    firstUpdated() {
        this._initMap();
        if (this.latitude !== null && this.longitude !== null) {
            this._setView([this.latitude, this.longitude], this.zoom);
        }
    }

    _initMap() {
        const container = this.shadowRoot.getElementById('map');
        if (!container) return;

        this._map = L.map(container, {
            zoomControl: false,
            attributionControl: false
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(this._map);

        // Custom marker using divIcon with SVG inline (per MapMarker Custom Asset Rule)
        const mapPickerIcon = L.divIcon({
            html: `<svg class="map-picker-marker" viewBox="0 0 32 45" width="32" height="45" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 0C7.163 0 0 7.163 0 16c0 10 16 29 16 29S32 26 32 16C32 7.163 24.837 0 16 0z"
                      fill="#e63946" stroke="#fff" stroke-width="1.5"/>
                <circle cx="16" cy="16" r="6" fill="#fff"/>
            </svg>`,
            className: 'map-picker-marker-wrapper',
            iconSize: [32, 45],
            iconAnchor: [16, 45],
            popupAnchor: [0, -45]
        });

        this.marker = L.marker([0, 0], { icon: mapPickerIcon, draggable: true })
            .addTo(this._map)
            .on('dragend', () => {
                const pos = this.marker.getLatLng();
                this.latitude = pos.lat;
                this.longitude = pos.lng;
                this._emitCoordsChanged();
                this._updateReverseGeocode();
            });
    }

    _setView(center, zoom) {
        if (!this._map) return;
        this._map.setView(center, zoom);
        if (this.marker) {
            this.marker.setLatLng(center);
        }
    }

    _handleCoordsChanged() {
        const coords = this.detail;
        if (coords) {
            this.latitude = coords.latitude;
            this.longitude = coords.longitude;
            this._setView([coords.latitude, coords.longitude], this.zoom);
            this._updateReverseGeocode();
        }
    }

    _updateReverseGeocode() {
        if (!this.latitude || !this.longitude) {
            this.address = '';
            this.formattedAddress = '';
            return;
        }

        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${this.latitude}&lon=${this.longitude}&accept-language=it&limit=1`, {
            headers: { 'User-Agent': 'FixcityCoordinatePicker/1.0 (+no-reply@organization.com)' }
        })
            .then(res => res.json())
            .then(data => {
                if (data && data.display_name) {
                    this.address = data.display_name;
                    // Split into formatted address and components
                    const parts = data.display_name.split(', ');
                    this.formattedAddress = `${parts[0]}, ${parts[1]}`.slice(0, 100);
                } else {
                    this.address = '';
                    this.formattedAddress = '';
                }
            })
            .catch(err => {
                console.error('Reverse geocoding failed:', err);
                this.address = '';
                this.formattedAddress = '';
            });
    }

    zoomIn(): void {
        if (this._map) {
            const currentZoom = this._map.getZoom();
            if (currentZoom < 18) {
                this._map.setZoom(currentZoom + 1);
            }
        }
    }

    zoomOut(): void {
        if (this._map) {
            const currentZoom = this._map.getZoom();
            if (currentZoom > 1) {
                this._map.setZoom(currentZoom - 1);
            }
        }
    }

    toggleFullscreen(): void {
        const mapEl = this.shadowRoot.getElementById('map');
        if (!mapEl) return;
        this.isExpanded = !this.isExpanded;
        if (this.isExpanded) {
            mapEl.classList.add('fullscreen');
        } else {
            mapEl.classList.remove('fullscreen');
        }
    }

    expandInfo(): void {
        // Leverages Alpine higher up in the DOM tree
        // No-op here - just triggers Alpine to update
    }

    collapseInfo(): void {
        // Leverages Alpine higher up in the DOM tree
        // No-op here - just triggers Alpine to update
    }
}

customElements.define('coordinate-picker-lit', CoordinatePickerLit);
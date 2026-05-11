import { LitElement, css, html, unsafeCSS } from 'lit';
import L from 'leaflet';
import 'leaflet.markercluster';
import '../opening_hours+deps.min.js';
import leafletCss from 'leaflet/dist/leaflet.css?inline';
import markerClusterCss from 'leaflet.markercluster/dist/MarkerCluster.css?inline';

const HOF_ICON = new URL('../../img/hof.png', import.meta.url).href;
const MARKT_ICON = new URL('../../img/markt.png', import.meta.url).href;
const AUTOMAT_ICON = new URL('../../img/automat.png', import.meta.url).href;
const IMKER_ICON = new URL('../../img/imker.png', import.meta.url).href;
const GITHUB_ICON = new URL('../../img/github.svg', import.meta.url).href;
const OKFN_ICON = new URL('../../img/okfnde.png', import.meta.url).href;
const CODEFOR_ICON = new URL('../../img/codeforkarlsruhe.png', import.meta.url).href;

const CATEGORY_IMAGES = {
    farm: HOF_ICON,
    marketplace: MARKT_ICON,
    vending_machine: AUTOMAT_ICON,
    beekeeper: IMKER_ICON,
};

class GeoMapWidgetElement extends LitElement {
    static properties = {
        sidebarPanel: { state: true },
        statusText: { state: true },
    };

    static styles = css`
        ${unsafeCSS(leafletCss)}
        ${unsafeCSS(markerClusterCss)}

        :host {
            display: block;
            color: #222;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }

        .farmshops {
            position: relative;
            min-height: 48rem;
            border: 1px solid #d1d5db;
            overflow: hidden;
            background: #fff;
        }

        .sidebar {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1000;
            display: grid;
            grid-template-columns: 3rem minmax(0, 23rem);
            transform: translateX(0);
            transition: transform 180ms ease;
        }

        .sidebar.is-collapsed {
            transform: translateX(calc(-100% + 3rem));
        }

        .sidebar-tabs {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.94);
            border-right: 1px solid #d8dee4;
        }

        .sidebar-tab-group {
            display: grid;
        }

        .sidebar-tab {
            display: grid;
            place-items: center;
            width: 3rem;
            height: 3rem;
            border: 0;
            border-bottom: 1px solid #d8dee4;
            background: transparent;
            cursor: pointer;
            color: #1f2937;
            text-decoration: none;
            font-size: 1rem;
        }

        .sidebar-tab img {
            width: 1.25rem;
            height: 1.25rem;
            object-fit: contain;
        }

        .sidebar-content {
            overflow: auto;
            background: rgba(255, 255, 255, 0.97);
            box-shadow: 4px 0 16px rgba(0, 0, 0, 0.14);
        }

        .sidebar-pane {
            padding: 0;
        }

        .sidebar-header {
            position: sticky;
            top: 0;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin: 0;
            padding: 0.85rem 1rem;
            font-size: 1.05rem;
            color: #f2f2f2;
            background: #4ca7ce;
        }

        .sidebar-inner {
            padding: 1rem;
            font-size: 0.92rem;
            line-height: 1.5;
        }

        .sidebar-inner h3 {
            margin: 1rem 0 0.5rem;
            font-size: 1rem;
        }

        .sidebar-inner ul {
            padding-left: 1.2rem;
        }

        .map {
            min-height: 48rem;
        }

        .legend-row {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            margin: 0.5rem 0;
        }

        .legend-row img {
            width: 2.5rem;
            max-width: 100%;
        }

        .button {
            display: inline-block;
            font-weight: bold;
            padding: 0.5rem 0.75rem;
            margin: 0.5rem 0;
            font-size: 0.95rem;
            color: #f2f2f2;
            background: #4ca7ce;
            text-decoration: none;
        }

        .button:hover {
            box-shadow: 0 8px 8px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
        }

        .popup-headline {
            width: 100%;
            background: #4ca7ce;
        }

        .popup-headline h1 {
            margin: 0;
            padding: 8px 40px 8px 8px;
            font-size: 20px;
            color: #f2f2f2;
            text-align: center;
            background: #4ca7ce;
        }

        .leaflet-popup-content-wrapper {
            border-radius: 0;
            font-size: 10px;
            padding: 0;
            overflow: hidden;
        }

        .leaflet-popup-content {
            margin: 0;
        }

        .popup-wrapper {
            padding: 8px;
        }

        .popup-address {
            float: left;
            max-width: 110px;
            margin-bottom: 6px;
        }

        .popup-links {
            float: right;
            padding: 2px;
            border-left: 2px solid #4ca7ce;
        }

        .popup-times,
        .popup-table {
            clear: both;
            margin-bottom: 6px;
        }

        .popup-table table {
            width: 100%;
            min-width: 250px;
            font-size: 10px;
            overflow-wrap: break-word;
        }

        .popup-table th {
            color: white;
            background-color: #4ca7ce;
        }

        .popup-table td {
            padding: 2px;
            text-align: left;
        }

        .popup-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .popup-button {
            display: inline-block;
            padding: 4px;
            margin: 4px;
            font-size: 10px;
            font-weight: bold;
            line-height: 30px;
            color: #f2f2f2;
            text-decoration: none;
            background: #4ca7ce;
        }

        .circle {
            display: grid;
            place-items: center;
            min-width: 80px;
            min-height: 80px;
            padding: 4px;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 16px;
            line-height: 1;
            color: #f2f2f2;
            text-align: center;
            background: #4ca7ce;
            border: 3px solid #f2f2f2;
            border-radius: 100px / 100px;
            opacity: 0.8;
        }

        .cluster-icons {
            padding-top: 2px;
        }

        .cluster-icons img {
            height: 14px;
            margin: 0 1px;
        }

        .status-box {
            margin-top: 1rem;
            padding: 0.65rem 0.75rem;
            font-size: 0.82rem;
            color: #334155;
            background: #eef6fb;
            border-left: 4px solid #4ca7ce;
        }

        @media (max-width: 900px) {
            .farmshops,
            .map {
                min-height: 42rem;
            }

            .sidebar {
                grid-template-columns: 3rem minmax(0, 18rem);
            }
        }
    `;

    constructor() {
        super();
        this.sidebarPanel = 'home';
        this.statusText = 'Letzter Datenabgleich: Demo dataset.';
        this.dataset = { type: 'FeatureCollection', features: [] };
        this.config = {};
        this.map = null;
        this.markers = null;
        this.streetLayer = null;
        this.satelliteLayer = null;
        this.resizeObserver = null;
    }

    createRenderRoot() {
        return this;
    }

    connectedCallback() {
        super.connectedCallback();
        this.dataset = this.readJsonAttribute('data-dataset');
        this.config = this.readJsonAttribute('data-config');
        this.statusText = this.config.lastUpdate ?? this.statusText;
    }

    render() {
        const collapsed = this.sidebarPanel === null;

        return html`
            <div class="farmshops">
                <div class=${`sidebar ${collapsed ? 'is-collapsed' : ''}`}>
                    <div class="sidebar-tabs">
                        <div class="sidebar-tab-group">
                            <button class="sidebar-tab" type="button" title="Was ist das hier?" @click=${() => this.togglePanel('home')}>
                                &#9776;
                            </button>
                        </div>

                        <div class="sidebar-tab-group">
                            <button class="sidebar-tab" type="button" title="Impressum" @click=${() => this.togglePanel('info')}>
                                &#8505;
                            </button>
                            <a class="sidebar-tab" href="https://github.com/CodeforKarlsruhe/direktvermarkter" target="_blank" rel="noopener" title="Repository">
                                <img src=${GITHUB_ICON} alt="Github">
                            </a>
                            <a class="sidebar-tab" href="https://codefor.de/" target="_blank" rel="noopener" title="Code for Germany">
                                <img src=${OKFN_ICON} alt="OKFN">
                            </a>
                        </div>
                    </div>

                    <div class="sidebar-content">
                        ${this.sidebarPanel === 'info' ? this.renderInfoPane() : this.renderHomePane()}
                    </div>
                </div>

                <div id="map" class="map"></div>
            </div>
        `;
    }

    firstUpdated() {
        this.initializeMap();
        this.observeResize();
    }

    disconnectedCallback() {
        this.resizeObserver?.disconnect();
        this.map?.remove();
        this.map = null;
        super.disconnectedCallback();
    }

    renderHomePane() {
        return html`
            <div class="sidebar-pane">
                <h1 class="sidebar-header">
                    farmshops.eu - Direktvermarkter-Karte
                    <button type="button" class="sidebar-tab" @click=${() => this.togglePanel(null)}>×</button>
                </h1>
                <div class="sidebar-inner">
                    <h3>Was ist das hier?</h3>
                    <p>
                        Diese Lit-Komponente repliziert die originale Übersichtskarte von
                        <code>farmshops.eu</code> mit Hofläden, Märkten, Imkern und Verkaufsautomaten.
                    </p>

                    <h3>Welche Einträge werden angezeigt?</h3>
                    <div class="legend-row"><img src=${HOF_ICON} alt=""><span><strong>shop=farm</strong> für Hofläden</span></div>
                    <div class="legend-row"><img src=${AUTOMAT_ICON} alt=""><span><strong>amenity=vending_machine</strong> für Automaten</span></div>
                    <div class="legend-row"><img src=${MARKT_ICON} alt=""><span><strong>amenity=marketplace</strong> für Märkte</span></div>
                    <div class="legend-row"><img src=${IMKER_ICON} alt=""><span><strong>craft=beekeeper</strong> für Imker</span></div>

                    <p>
                        Die Karte nutzt OpenStreetMap als Standard-Layer, Satellitenbilder von Esri und dieselbe Cluster-Logik
                        des Originals: einfache Zähler bei kleinem Zoom, Kategorie-Icons im Cluster bei höherem Zoom.
                    </p>

                    <p>
                        <a class="button" href="https://github.com/CodeforKarlsruhe/farmshops.eu" target="_blank" rel="noopener">Original auf GitHub</a>
                    </p>

                    <div class="status-box">${this.statusText}</div>
                </div>
            </div>
        `;
    }

    renderInfoPane() {
        return html`
            <div class="sidebar-pane">
                <h1 class="sidebar-header">
                    Impressum und Datenschutz
                    <button type="button" class="sidebar-tab" @click=${() => this.togglePanel(null)}>×</button>
                </h1>
                <div class="sidebar-inner">
                    <img src=${CODEFOR_ICON} alt="Code for Karlsruhe" width="200">
                    <p><strong>Replica basata su progetto MIT</strong> di Code for Karlsruhe.</p>
                    <p>
                        Il comportamento della mappa, la tassonomia delle categorie e il linguaggio visuale sono stati
                        portati in un Web Component Lit dentro il modulo <code>Geo</code>.
                    </p>
                    <p>
                        Repository originale:
                        <a href="https://github.com/CodeforKarlsruhe/farmshops.eu" target="_blank" rel="noopener">
                            CodeforKarlsruhe/farmshops.eu
                        </a>
                    </p>
                </div>
            </div>
        `;
    }

    readJsonAttribute(name) {
        const rawValue = this.getAttribute(name);

        if (!rawValue) {
            return {};
        }

        try {
            return JSON.parse(rawValue);
        } catch {
            return {};
        }
    }

    togglePanel(panel) {
        this.sidebarPanel = this.sidebarPanel === panel ? null : panel;
        requestAnimationFrame(() => this.map?.invalidateSize());
    }

    initializeMap() {
        const canvas = this.querySelector('#map');
        const center = this.getInitialCenter();

        this.streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        });

        this.satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri',
            maxZoom: 19,
        });

        this.map = L.map(canvas, {
            center,
            zoom: this.config.defaultZoom ?? 6,
            minZoom: 2,
            maxZoom: 18,
            zoomControl: false,
        });

        this.streetLayer.addTo(this.map);
        this.markers = L.markerClusterGroup({
            spiderfyOnMaxZoom: true,
            maxClusterRadius: (zoom) => (zoom < 12 ? 80 : 45),
            showCoverageOnHover: true,
            zoomToBoundsOnClick: true,
            removeOutsideVisibleBounds: true,
            iconCreateFunction: (cluster) => this.createClusterIcon(cluster),
        });

        this.createFeatureLayers();
        this.map.addLayer(this.markers);
        this.installPermalink();
        this.installLocateControl();

        L.control.scale({ position: 'topright' }).addTo(this.map);
        L.control.layers(
            {
                OpenStreetMap: this.streetLayer,
                Satellit: this.satelliteLayer,
            },
            {
                Marker: this.markers,
            },
        ).addTo(this.map);
        L.control.zoom({ position: 'bottomright' }).addTo(this.map);

        this.map.on('popupopen', (event) => {
            const divmap = this.querySelector('#map');
            event.popup.options.maxHeight = 0.8 * divmap.offsetHeight;
            event.popup.options.maxWidth = 0.95 * divmap.offsetWidth;
            event.popup.update();
        });
    }

    installPermalink() {
        let shouldWriteHash = true;
        const initialLocation = readPermalinkState();

        if (initialLocation !== null) {
            this.map.setView(initialLocation.center, initialLocation.zoom);
        }

        this.map.on('moveend', () => {
            if (!shouldWriteHash) {
                shouldWriteHash = true;

                return;
            }

            const center = this.map.getCenter();
            window.history.replaceState(
                {
                    zoom: this.map.getZoom(),
                    center,
                },
                'map',
                `#${round5(center.lat)},${round5(center.lng)},${this.map.getZoom()}z`,
            );
        });

        window.addEventListener('popstate', (event) => {
            if (event.state !== null) {
                shouldWriteHash = false;
                this.map.setView(event.state.center, event.state.zoom);
            }
        });
    }

    installLocateControl() {
        const LocateControl = L.Control.extend({
            options: { position: 'bottomright' },
            onAdd: (map) => {
                const container = L.DomUtil.create('div', 'leaflet-bar leaflet-control');
                const button = L.DomUtil.create('a', 'leaflet-bar-part leaflet-bar-part-single', container);
                button.href = '#';
                button.title = 'Karte auf meine aktuelle Position zentrieren!';
                button.innerHTML = '&#9678;';

                L.DomEvent.on(button, 'click', L.DomEvent.stop)
                    .on(button, 'click', () => {
                        if (!navigator.geolocation) {
                            return;
                        }

                        navigator.geolocation.getCurrentPosition((position) => {
                            const latlng = [position.coords.latitude, position.coords.longitude];
                            map.setView(latlng, 12);
                            L.circle(latlng, {
                                radius: position.coords.accuracy,
                                color: '#136AEC',
                                fillColor: '#136AEC',
                                fillOpacity: 0.15,
                                weight: 2,
                                opacity: 0.5,
                            }).addTo(map);
                            L.circleMarker(latlng, {
                                color: '#136AEC',
                                fillColor: '#2A93EE',
                                fillOpacity: 0.7,
                                weight: 2,
                                opacity: 0.9,
                                radius: 5,
                            }).addTo(map);
                        });
                    });

                return container;
            },
        });

        new LocateControl().addTo(this.map);
    }

    createFeatureLayers() {
        this.getPointFeatures().forEach((feature) => {
            const latlng = [feature.geometry.coordinates[1], feature.geometry.coordinates[0]];
            const marker = L.marker(latlng, {
                icon: this.createCategoryMarker(readCategory(feature)),
            });

            marker.feature = feature;
            marker.bindPopup(renderPopupContent(feature));
            this.markers.addLayer(marker);
        });
    }

    createCategoryMarker(category) {
        const image = CATEGORY_IMAGES[category] ?? HOF_ICON;

        return L.divIcon({
            className: 'farmshop-marker',
            html: `<img src="${image}" alt="${category}" style="width:40px;height:40px;">`,
            iconSize: [40, 40],
            iconAnchor: [20, 40],
            popupAnchor: [0, -32],
        });
    }

    createClusterIcon(cluster) {
        const markers = cluster.getAllChildMarkers();
        const flags = {
            farm: false,
            marketplace: false,
            vending_machine: false,
            beekeeper: false,
        };

        markers.forEach((marker) => {
            const category = readCategory(marker.feature);

            if (category in flags) {
                flags[category] = true;
            }
        });

        const detail = this.map.getZoom() >= 8
            ? `
                <div class="cluster-icons">
                    ${flags.farm ? `<img src="${HOF_ICON}" alt="farm">` : ''}
                    ${flags.marketplace ? `<img src="${MARKT_ICON}" alt="marketplace">` : ''}
                    ${flags.vending_machine ? `<img src="${AUTOMAT_ICON}" alt="vending_machine">` : ''}
                    ${flags.beekeeper ? `<img src="${IMKER_ICON}" alt="beekeeper">` : ''}
                </div>
            `
            : `<div style="padding:8px;">${markers.length}</div>`;

        const body = this.map.getZoom() >= 8 ? `${markers.length}${detail}` : detail;

        return L.divIcon({
            html: `<div class="circle"><strong>${body}</strong></div>`,
            className: 'test',
            iconSize: L.point(80, 80),
        });
    }

    getPointFeatures() {
        return Array.isArray(this.dataset.features)
            ? this.dataset.features.filter((feature) => feature.geometry?.type === 'Point')
            : [];
    }

    getInitialCenter() {
        const firstFeature = this.getPointFeatures()[0];

        if (!firstFeature) {
            return [51.1657, 10.4515];
        }

        return [
            firstFeature.geometry.coordinates[1],
            firstFeature.geometry.coordinates[0],
        ];
    }

    observeResize() {
        const host = this.querySelector('.farmshops');

        if (!(host instanceof HTMLElement)) {
            return;
        }

        this.resizeObserver = new ResizeObserver(() => {
            requestAnimationFrame(() => this.map?.invalidateSize());
        });

        this.resizeObserver.observe(host);
    }
}

function readCategory(feature) {
    return String(feature.properties?.p ?? feature.properties?.category ?? 'farm');
}

function renderPopupContent(feature) {
    const properties = feature.properties ?? {};
    const title = resolveHeadline(properties);
    const address = renderAddress(properties);
    const openingHours = renderOpeningHours(properties);
    const detailsTable = renderDetailsTable(properties);
    const [lng, lat] = feature.geometry.coordinates;
    const osmId = String(properties.id ?? properties.name ?? '');
    const editId = osmId.includes('/') ? osmId.replace('/', '=') : osmId;

    return `
        <div class="popup-headline"><h1>${title}</h1></div>
        <div class="popup-wrapper">
            <div class="popup-address"><strong>Adresse:</strong><br>${address}</div>
            <div class="popup-links">
                <strong>Dieser Ort auf</strong><br>
                <a target="_blank" rel="noopener" href="http://openstreetmap.org/${osmId}">OpenStreetMap</a><br>
                <a target="_blank" rel="noopener" href="https://maps.openrouteservice.org/directions?n1=${lat}&n2=${lng}&n3=14&a=null,null,${lat},${lng}&b=0&c=0&k1=en-US&k2=km">Openrouteservice</a><br>
                <a target="_blank" rel="noopener" href="http://maps.google.de/?q=${lat},${lng}">Google Maps</a>
            </div>
            <div class="popup-times"><strong>Öffnungszeiten:</strong><br>${openingHours}</div>
            <div class="popup-table">
                <table>
                    <th colspan="2">Weitere Daten:</th>
                    ${detailsTable}
                </table>
            </div>
            <a target="_blank" rel="noopener" href="http://openstreetmap.org/edit?editor=id&${editId}" class="popup-button">Auf OSM bearbeiten</a>
            <br>Die Daten werden regelmäßig abgeglichen.
        </div>
    `;
}

function resolveHeadline(properties) {
    if (properties.name) {
        return properties.name;
    }

    if (properties.shop === 'farm' || properties.p === 'farm') {
        return 'Hofladen';
    }

    if (properties.craft === 'beekeeper' || properties.p === 'beekeeper') {
        return 'Imker';
    }

    if (properties.amenity === 'vending_machine' || properties.p === 'vending_machine') {
        return 'Verkaufsautomat';
    }

    if (properties.amenity === 'marketplace' || properties.p === 'marketplace') {
        return 'Markt';
    }

    return 'Direktvermarkter';
}

function renderAddress(properties) {
    const line1 = [properties['addr:street'], properties['addr:housenumber']]
        .filter(Boolean)
        .join(' ')
        .trim();
    const line2 = [properties['addr:postcode'], properties['addr:city']]
        .filter(Boolean)
        .join(' ')
        .trim();
    const line3 = properties['addr:place'] ?? '';
    const parts = [line1, line2, line3].filter((item) => item !== '');

    return parts.length > 0 ? parts.join('<br>') : 'Unbekannt <br> <br>';
}

function renderOpeningHours(properties) {
    const openingHours = properties.opening_hours ?? null;

    if (!openingHours) {
        return 'Unbekannt';
    }

    const stateText = resolveOpenState(openingHours);

    return `${openingHours}${stateText}`;
}

function renderDetailsTable(properties) {
    const hiddenKeys = new Set([
        'id',
        'name',
        'p',
        'shop',
        'craft',
        'amenity',
        'opening_hours',
        'addr:street',
        'addr:housenumber',
        'addr:postcode',
        'addr:city',
        'addr:place',
        'addr:country',
        'addr:suburb',
        'image',
    ]);

    return Object.entries(properties)
        .filter(([key, value]) => !hiddenKeys.has(key) && value !== null && value !== '')
        .map(([key, value]) => renderPropertyRow(key, value, properties))
        .join('');
}

function renderPropertyRow(key, value, properties) {
    if (key === 'fixme') {
        return `<tr><td><strong>Unklare Daten:</strong></td><td>${String(value).replace('position estimated', 'Position geschätzt')} <a target="_blank" rel="noopener" href="http://openstreetmap.org/${properties.id ?? ''}">Daten verbessern</a></td></tr>`;
    }

    return `<tr><td><strong>${translateKey(key)}:</strong></td><td>${formatValue(key, value)}</td></tr>`;
}

function translateKey(key) {
    return key
        .replace('opening_hours', 'Öffnungszeiten')
        .replace('city', 'Stadt')
        .replace('housenumber', 'Hausnummer')
        .replace('operator', 'Betreiber')
        .replace('postcode', 'Postleitzahl')
        .replace('street', 'Straße')
        .replace('suburb', 'Bezirk')
        .replace('website', 'Webseite')
        .replace('phone', 'Telefon')
        .replace('email', 'E-Mail')
        .replace('description', 'Beschreibung')
        .replace('produce', 'Erzeugnisse')
        .replace('organic', 'Biologisch')
        .replace('product', 'Produkt(e)')
        .replace('wheelchair', 'Rollstuhlgerecht')
        .replace('currency', 'Währung')
        .replace('covered', 'Überdacht')
        .replace('indoor', 'Innenraum')
        .replace('country', 'Land')
        .replace('source', 'Quelle')
        .replace('start_date', 'Geöffnet seit')
        .replace('vending', 'Verkauft')
        .replace('amenity', 'Einrichtung')
        .replaceAll(':', ' ');
}

function formatValue(key, value) {
    const stringValue = String(value);

    if (['website', 'contact:website', 'url'].includes(key)) {
        return `<a target="_blank" rel="noopener" href="${stringValue}">${stringValue}</a>`;
    }

    if (['email', 'contact:email'].includes(key)) {
        return `<a target="_blank" rel="noopener" href="mailto:${stringValue}">${stringValue}</a>`;
    }

    if (['phone', 'contact:phone'].includes(key)) {
        return `<a target="_blank" rel="noopener" href="tel:${stringValue}">${stringValue}</a>`;
    }

    return stringValue
        .replaceAll(';', ', ')
        .replace('only', 'nur')
        .replace('vending_machine', 'Verkaufsautomat')
        .replace('raw_milk', 'Rohmilch')
        .replace('eggs', 'Eier')
        .replace('aspice', 'Sülze')
        .replace('meat', 'Fleisch')
        .replace('soup', 'Suppen')
        .replace('edible oil', 'Speiseöl')
        .replace('rapeseed oil', 'Rapsöl')
        .replace('linseed oil', 'Leinöl')
        .replace('canned sausages', 'Wurstkonserven')
        .replace('sausages', 'Wurst')
        .replace('potatoes', 'Kartoffeln')
        .replace('carrots', 'Möhren')
        .replace('courgettes', 'Zucchini')
        .replace('zucchini', 'Zucchini')
        .replace('pumpkins', 'Kürbisse')
        .replace('asparagus', 'Spargel')
        .replace('tomatoes', 'Tomaten')
        .replace('vegetables', 'Gemüse')
        .replace('fruits', 'Früchte')
        .replace('apples', 'Äpfel')
        .replace('blueberries', 'Heidelbeeren')
        .replace('raspberries', 'Himbeeren')
        .replace('strawberries', 'Erdbeeren')
        .replace('jam', 'Marmelade')
        .replace('cheese', 'Käse')
        .replace('cream cheese', 'Frischkäse')
        .replace('butter', 'Butter')
        .replace('yogurt', 'Joghurt')
        .replace('curd', 'Quark')
        .replace('dairy', 'Molkereiprodukte')
        .replace('marketplace', 'Marktplatz')
        .replace('noodles', 'Nudeln')
        .replace('flour', 'Mehl')
        .replace('bread roll', 'Brötchen')
        .replace('bread', 'Brot')
        .replace('cake', 'Kuchen')
        .replace('honey', 'Honig')
        .replace('fast_food', 'Schnellimbiss')
        .replace('seafood', 'Meeresfrüchte')
        .replace('sweets', 'Süßigkeiten')
        .replace('food', 'Lebensmittel')
        .replace('drinks', 'Getränke')
        .replace('water', 'Wasser')
        .replace('apple juice', 'Apfelsaft')
        .replace('partially', 'teilweise')
        .replace('milk', 'Milch')
        .replace('yes', 'ja')
        .replace('no', 'nein');
}

function resolveOpenState(openingHours) {
    // ZEN: Defensive coding against external library failures.
    if (!openingHours || typeof window === 'undefined' || typeof window.opening_hours !== 'function') {
        return '';
    }

    try {
        const oh = new window.opening_hours(openingHours);
        if (typeof oh.getState !== 'function') return '';
        
        return oh.getState()
            ? '<br><strong><span style="color:green">Wahrscheinlich gerade geöffnet</span></strong>'
            : '<br><strong><span style="color:red">Wahrscheinlich gerade geschlossen</span></strong>';
    } catch (e) {
        // Silently fail to keep the map working
        return '';
    }
}

function readPermalinkState() {
    if (window.location.hash === '') {
        return null;
    }

    const parts = window.location.hash.replace('#', '').split(',');

    if (parts.length !== 3) {
        return null;
    }

    return {
        center: {
            lat: Number.parseFloat(parts[0]),
            lng: Number.parseFloat(parts[1]),
        },
        zoom: Number.parseInt(parts[2].replace('z', ''), 10),
    };
}

function round5(value) {
    return Math.round(value * 100000) / 100000;
}

if (!customElements.get('geo-map-widget')) {
    customElements.define('geo-map-widget', GeoMapWidgetElement);
}

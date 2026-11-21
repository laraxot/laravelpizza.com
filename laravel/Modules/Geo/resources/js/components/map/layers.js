import { osmTileUrl } from './endpoints.js';

// Attribuzioni obbligatorie (licenza ODbL e policy dei tile di OSMF; termini Esri): visibili sulla mappa.
const OSM_ATTRIBUTION = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
const ESRI_ATTRIBUTION = 'Tiles &copy; Esri';

export function buildMapLayers(L) {
        return {
                street: L.tileLayer(osmTileUrl(), { maxZoom: 19, attribution: OSM_ATTRIBUTION }),
                humanitarian: L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', { maxZoom: 19, attribution: `${OSM_ATTRIBUTION}, stile <a href="https://www.hotosm.org/">HOT</a>` }),
                satellite: L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { maxZoom: 19, attribution: ESRI_ATTRIBUTION }),
                topo: L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}', { maxZoom: 19, attribution: ESRI_ATTRIBUTION }),
        };
}

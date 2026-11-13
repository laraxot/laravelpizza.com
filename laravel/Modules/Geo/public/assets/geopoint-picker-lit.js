var m=Object.defineProperty;var p=(a,t,e)=>t in a?m(a,t,{enumerable:!0,configurable:!0,writable:!0,value:e}):a[t]=e;var u=(a,t,e)=>p(a,typeof t!="symbol"?t+"":t,e);import{d as g,e as _,c,L as r}from"./leaflet-src.js";import{a as y,g as n,c as b}from"./map-picker-marker-config.js";class d extends g{createRenderRoot(){return this}constructor(){super(),this.latitude=null,this.longitude=null,this.defaultLatitude=41.9028,this.defaultLongitude=12.4964,this.zoom=15,this.height="400px",this._map=null,this._marker=null,this._layers={},this._currentLayer="street",this._mapReady=!1,this._loading=!1,this._isProgrammaticUpdate=!1,this._resizeObserver=null}render(){const t=!!document.fullscreenElement,e=this.height||"400px";return c`
            <style>
                geopoint-picker-lit { display: block; width: 100%; height: 100%; min-height: 200px; }
                ${y}
                .map-container { min-height: 200px; }
                /* BUG 3 fix: :host CSS vars are ignored in Light DOM — hardcode z-index */
                .layer-controls-overlay { z-index: 1000 !important; display: flex !important; flex-direction: column !important; gap: 0.5rem !important; }
                .search-box { z-index: 1000 !important; }
                .ctrl-btn svg { width: 1.5rem; height: 1.5rem; color: #374151; }
                .ctrl-btn:hover svg { color: #ef4444; }
            </style>

            <div class="map-container ${t?"is-fullscreen":""}" style="--map-height: ${e}">
                ${_([],()=>c`<div class="map-picker-leaflet-pane" style="height: 100%;"></div>`)}

                <div class="layer-controls-overlay">
                    <button class="ctrl-btn" type="button" @click="${this._toggleFullscreen}" title="Fullscreen">
                        ${n("arrows-pointing-out")}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${()=>this._handleGeolocation(!0)}" title="Mia posizione">
                        ${n("map-pin")}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${this._switchLayer}" title="Cambia Layer">
                        ${n("squares-2x2")}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${()=>{var i;return(i=this._map)==null?void 0:i.zoomIn()}}" title="Zoom In">
                        ${n("plus")}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${()=>{var i;return(i=this._map)==null?void 0:i.zoomOut()}}" title="Zoom Out">
                        ${n("minus")}
                    </button>
                </div>

                <div class="loading-overlay ${this._loading?"active":""}">
                    <div class="spinner"></div>
                </div>
            </div>
        `}firstUpdated(){this._initMap(),this._resizeObserver=new ResizeObserver(()=>{this._map&&this._map.invalidateSize()}),this._resizeObserver.observe(this),this._mutationObserver=new MutationObserver(()=>{this.offsetParent!==null&&this._map&&setTimeout(()=>this._map.invalidateSize(),150)});let t=this.parentElement;for(let e=0;e<15&&t;e++)this._mutationObserver.observe(t,{attributes:!0,attributeFilter:["class","style","hidden"]}),t=t.parentElement}disconnectedCallback(){var t,e;super.disconnectedCallback(),(t=this._resizeObserver)==null||t.disconnect(),(e=this._mutationObserver)==null||e.disconnect(),this._map&&(this._map.remove(),this._map=null)}updated(t){(t.has("latitude")||t.has("longitude"))&&!this._isProgrammaticUpdate&&this._mapReady&&this.latitude!==null&&this.longitude!==null&&this._syncMarkerToState(this.latitude,this.longitude)}_initMap(){const t=this.querySelector(".geopoint-leaflet-pane")||this.querySelector(".map-picker-leaflet-pane");if(!t||this._map)return;const e=this.latitude||this.defaultLatitude,i=this.longitude||this.defaultLongitude;this._map=r.map(t,{center:[e,i],zoom:this.zoom,zoomControl:!1,attributionControl:!1}),this._layers.street=r.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",{maxZoom:19}).addTo(this._map),this._layers.satellite=r.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",{maxZoom:19}),this._layers.topo=r.tileLayer("https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png",{maxZoom:17}),this._mapReady=!0,this.latitude!==null&&this.longitude!==null?this._syncMarkerToState(this.latitude,this.longitude):this._handleGeolocation(!1),this._map.on("click",s=>this._handleInteraction(s.latlng.lat,s.latlng.lng)),setTimeout(()=>this._map.invalidateSize(),350)}_handleInteraction(t,e,i=!0){this._isProgrammaticUpdate=!0,this.latitude=parseFloat(t.toFixed(6)),this.longitude=parseFloat(e.toFixed(6)),this._syncMarkerToState(this.latitude,this.longitude),i&&this.dispatchEvent(new CustomEvent("geopoint-changed",{detail:{latitude:this.latitude,longitude:this.longitude},bubbles:!0,composed:!0})),setTimeout(()=>{this._isProgrammaticUpdate=!1},100)}_syncMarkerToState(t,e){this._map&&(this._marker?this._marker.setLatLng([t,e]):(this._marker=r.marker([t,e],{draggable:!0,icon:b(r)}).addTo(this._map),this._marker.on("dragend",i=>{const s=i.target.getLatLng();this._handleInteraction(s.lat,s.lng)})),this._map.setView([t,e],this._map.getZoom()))}_switchLayer(){const t=["street","satellite","topo"],i=(t.indexOf(this._currentLayer)+1)%t.length,s=t[i];this._map.removeLayer(this._layers[this._currentLayer]),this._layers[s]._map||this._layers[s].addTo(this._map),this._currentLayer=s}async _handleGeolocation(t=!0){if(navigator.geolocation)return this._loading=!0,this.requestUpdate(),new Promise(e=>{navigator.geolocation.getCurrentPosition(i=>{this._handleInteraction(i.coords.latitude,i.coords.longitude,t),this._map&&this._map.setView([i.coords.latitude,i.coords.longitude],16),this._loading=!1,this.requestUpdate(),e(!0)},()=>{this._loading=!1,this.requestUpdate(),e(!1)},{enableHighAccuracy:!0,timeout:5e3})})}setCoordinates(t,e,i="programmatic"){var l,h;const s=parseFloat(t),o=parseFloat(e);!Number.isFinite(s)||!Number.isFinite(o)||(this._handleInteraction(s,o,i),(h=this._map)==null||h.setView([s,o],Math.max(((l=this._map)==null?void 0:l.getZoom())||this.zoom,16),{animate:!0}),this._refreshMapSize())}_toggleFullscreen(){const t=this.querySelector(".map-container");t&&(document.fullscreenElement?document.exitFullscreen():t.requestFullscreen())}}u(d,"properties",{latitude:{type:Number},longitude:{type:Number},defaultLatitude:{type:Number,attribute:"default-latitude"},defaultLongitude:{type:Number,attribute:"default-longitude"},zoom:{type:Number},height:{type:String}});customElements.get("geopoint-picker-lit")||customElements.define("geopoint-picker-lit",d);

var u=Object.defineProperty;var d=(a,t,e)=>t in a?u(a,t,{enumerable:!0,configurable:!0,writable:!0,value:e}):a[t]=e;var h=(a,t,e)=>d(a,typeof t!="symbol"?t+"":t,e);import{LitElement as m,html as n}from"lit";import{a as p,i as _,g,L as r,c as y}from"./map-picker-marker-config.js";class c extends m{createRenderRoot(){return this}constructor(){super(),this.latitude=null,this.longitude=null,this.defaultLatitude=41.9028,this.defaultLongitude=12.4964,this.zoom=15,this.height="400px",this.showSearch=!0,this.geolocateWhenEmpty=!1,this.address=null,this._map=null,this._marker=null,this._layers={},this._currentLayer="street",this._mapReady=!1,this._loading=!1,this._isProgrammaticUpdate=!1,this._resizeObserver=null}render(){const t=!!document.fullscreenElement;return n`
            <style>
                map-picker-lit { display: block; width: 100%; }
                ${p}
                .layer-controls-overlay { display: flex !important; flex-direction: column !important; gap: 0.5rem !important; }
                .ctrl-btn svg { width: 1.25rem !important; height: 1.25rem !important; }
                .ctrl-btn:hover svg { color: #60a5fa !important; }
            </style>
            <div class="map-container ${t?"is-fullscreen":""}" style="--map-height: ${this.height}">

                ${_([],()=>n`<div class="map-picker-leaflet-pane" style="height: 100%;"></div>`)}

                ${this.showSearch?this._renderSearch():""}

                <div class="layer-controls-overlay">
                    <button class="ctrl-btn" type="button" @click="${this._toggleFullscreen}" title="Fullscreen">
                        ${this._renderIcon("arrows-pointing-out")}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${()=>this._handleGeolocation(!0)}" title="Mia posizione">
                        ${this._renderIcon("map-pin")}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${this._switchLayer}" title="Cambia Layer">
                        ${this._renderIcon("squares-2x2")}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${()=>{var e;return(e=this._map)==null?void 0:e.zoomIn()}}" title="Zoom In">
                        ${this._renderIcon("plus")}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${()=>{var e;return(e=this._map)==null?void 0:e.zoomOut()}}" title="Zoom Out">
                        ${this._renderIcon("minus")}
                    </button>
                </div>

                <div class="loading-overlay ${this._loading?"active":""}">
                    <div class="spinner"></div>
                </div>
            </div>
        `}_renderIcon(t){return g(t)}_renderSearch(){return n`
            <div class="search-box">
                <input
                    type="text"
                    class="map-picker-search-input"
                    placeholder="Cerca indirizzo..."
                    @keydown="${t=>t.key==="Enter"&&this._handleSearch()}"
                    autocomplete="off"
                />
                <button class="ctrl-btn" @click="${this._handleSearch}" type="button" aria-label="Cerca">
                    ${this._renderIcon("magnifying-glass")}
                </button>
            </div>
        `}connectedCallback(){super.connectedCallback(),document.addEventListener("fullscreenchange",()=>this._onFullscreenChange()),this._mutationObserver=new MutationObserver(()=>{this.offsetParent!==null&&this._map&&setTimeout(()=>this._map.invalidateSize(),150)});let t=this.parentElement;for(let e=0;e<20&&t;e++)this._mutationObserver.observe(t,{attributes:!0,attributeFilter:["class","style","hidden"]}),t=t.parentElement}disconnectedCallback(){var t,e;super.disconnectedCallback(),document.removeEventListener("fullscreenchange",()=>this._onFullscreenChange()),(t=this._mutationObserver)==null||t.disconnect(),this._map&&(this._map.remove(),this._map=null),(e=this._resizeObserver)==null||e.disconnect()}firstUpdated(){this._initMap()}updated(t){(t.has("latitude")||t.has("longitude"))&&!this._isProgrammaticUpdate&&this._mapReady&&this.latitude&&this.longitude&&this._syncMarkerToState(this.latitude,this.longitude)}_refreshMapSize(){[0,80,180,350,700,1200].forEach(t=>{setTimeout(()=>{this._map&&this.offsetParent!==null&&this._map.invalidateSize()},t)})}_initMap(){const t=this.querySelector(".map-picker-leaflet-pane");if(!t||this._map)return;const e=this.latitude||this.defaultLatitude,s=this.longitude||this.defaultLongitude;this._map=r.map(t,{center:[e,s],zoom:this.zoom,zoomControl:!1,attributionControl:!1}),this._layers.street=r.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",{maxZoom:19}).addTo(this._map),this._layers.satellite=r.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",{maxZoom:19}),this._layers.topo=r.tileLayer("https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png",{maxZoom:17}),this._mapReady=!0,this.latitude&&this.longitude?this._syncMarkerToState(this.latitude,this.longitude):this.geolocateWhenEmpty&&this._handleGeolocation(!1),this._map.on("click",i=>this._handleInteraction(i.latlng.lat,i.latlng.lng,!0)),this._resizeObserver=new ResizeObserver(()=>{this._map&&this._map.invalidateSize()}),this._resizeObserver.observe(this),this._refreshMapSize()}_handleInteraction(t,e,s=!0){this._isProgrammaticUpdate=!0,this.latitude=parseFloat(t.toFixed(6)),this.longitude=parseFloat(e.toFixed(6)),this._syncMarkerToState(this.latitude,this.longitude),s&&this.dispatchEvent(new CustomEvent("coords-changed",{detail:{latitude:this.latitude,longitude:this.longitude},bubbles:!0,composed:!0})),setTimeout(()=>{this._isProgrammaticUpdate=!1},100)}_syncMarkerToState(t,e){this._map&&(this._marker?this._marker.setLatLng([t,e]):(this._marker=r.marker([t,e],{draggable:!0,icon:y(r)}).addTo(this._map),this._marker.on("dragend",s=>{const i=s.target.getLatLng();this._handleInteraction(i.lat,i.lng,!0)})),this._map.setView([t,e],this._map.getZoom()))}_switchLayer(){const t=["street","satellite","topo"],s=(t.indexOf(this._currentLayer)+1)%t.length,i=t[s];this._map.removeLayer(this._layers[this._currentLayer]),this._layers[i]._map||this._layers[i].addTo(this._map),this._currentLayer=i}async _handleGeolocation(t=!0){if(navigator.geolocation)return this._loading=!0,this.requestUpdate(),new Promise(e=>{navigator.geolocation.getCurrentPosition(s=>{this._handleInteraction(s.coords.latitude,s.coords.longitude,t),this._map&&this._map.setView([s.coords.latitude,s.coords.longitude],16),this._loading=!1,this.requestUpdate(),e(!0)},()=>{this._loading=!1,this.requestUpdate(),e(!1)},{enableHighAccuracy:!0,timeout:5e3})})}async _handleSearch(){var e;const t=this.querySelector(".map-picker-search-input");if(t!=null&&t.value){this._loading=!0,this.requestUpdate();try{const i=await(await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(t.value)}&limit=1`)).json();if(i!=null&&i[0]){const o=parseFloat(i[0].lat),l=parseFloat(i[0].lon);this._handleInteraction(o,l,!0),(e=this._map)==null||e.setView([o,l],16)}}finally{this._loading=!1,this.requestUpdate()}}}_toggleFullscreen(){const t=this.querySelector(".map-container");t&&(document.fullscreenElement?document.exitFullscreen():t.requestFullscreen())}_onFullscreenChange(){this.requestUpdate(),this._map&&setTimeout(()=>this._map.invalidateSize(),300)}_getFullscreenIcon(){return document.fullscreenElement?"arrows-pointing-in":"arrows-pointing-out"}}h(c,"properties",{latitude:{type:Number},longitude:{type:Number},defaultLatitude:{type:Number,attribute:"default-latitude"},defaultLongitude:{type:Number,attribute:"default-longitude"},zoom:{type:Number},height:{type:String},showSearch:{type:Boolean,attribute:"show-search"},geolocateWhenEmpty:{type:Boolean,attribute:"geolocate-when-empty"},address:{type:String,attribute:"address"}});customElements.get("map-picker-lit")||customElements.define("map-picker-lit",c);

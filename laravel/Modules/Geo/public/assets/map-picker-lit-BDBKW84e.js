import{a as e,d as t,f as n,i as r,m as i,n as a,r as o,s,t as c,v as l}from"./leaflet-src-Bmf1u-60.js";import{n as u,t as d}from"./map-picker-marker-config-D7dXugGV.js";t();var f=l(c(),1);s(),r(),o();var p=class extends n{static properties={latitude:{type:Number},longitude:{type:Number},defaultLatitude:{type:Number,attribute:`default-latitude`},defaultLongitude:{type:Number,attribute:`default-longitude`},zoom:{type:Number},height:{type:String},showSearch:{type:Boolean,attribute:`show-search`},geolocateWhenEmpty:{type:Boolean,attribute:`geolocate-when-empty`},address:{type:String,attribute:`address`}};createRenderRoot(){return this}constructor(){super(),this.latitude=null,this.longitude=null,this.defaultLatitude=41.9028,this.defaultLongitude=12.4964,this.zoom=15,this.height=`400px`,this.showSearch=!0,this.geolocateWhenEmpty=!1,this.address=null,this._map=null,this._marker=null,this._layers={},this._currentLayer=`street`,this._mapReady=!1,this._loading=!1,this._isProgrammaticUpdate=!1,this._resizeObserver=null}render(){return i`
            <style>
                map-picker-lit { display: block; width: 100%; }
                ${e}
                .layer-controls-overlay { display: flex !important; flex-direction: column !important; gap: 0.5rem !important; }
                .ctrl-btn svg { width: 1.25rem !important; height: 1.25rem !important; }
                .ctrl-btn:hover svg { color: #60a5fa !important; }
            </style>
            <div class="map-container ${document.fullscreenElement?`is-fullscreen`:``}" style="--map-height: ${this.height}">

                ${u([],()=>i`<div class="map-picker-leaflet-pane" style="height: 100%;"></div>`)}

                ${this.showSearch?this._renderSearch():``}

                <div class="layer-controls-overlay">
                    <button class="ctrl-btn" type="button" @click="${this._toggleFullscreen}" title="Fullscreen">
                        ${this._renderIcon(`arrows-pointing-out`)}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${()=>this._handleGeolocation(!0)}" title="Mia posizione">
                        ${this._renderIcon(`map-pin`)}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${this._switchLayer}" title="Cambia Layer">
                        ${this._renderIcon(`squares-2x2`)}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${()=>this._map?.zoomIn()}" title="Zoom In">
                        ${this._renderIcon(`plus`)}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${()=>this._map?.zoomOut()}" title="Zoom Out">
                        ${this._renderIcon(`minus`)}
                    </button>
                </div>

                <div class="loading-overlay ${this._loading?`active`:``}">
                    <div class="spinner"></div>
                </div>
            </div>
        `}_renderIcon(e){return a(e)}_renderSearch(){return i`
            <div class="search-box">
                <input
                    type="text"
                    class="map-picker-search-input"
                    placeholder="Cerca indirizzo..."
                    @keydown="${e=>e.key===`Enter`&&this._handleSearch()}"
                    autocomplete="off"
                />
                <button class="ctrl-btn" @click="${this._handleSearch}" type="button" aria-label="Cerca">
                    ${this._renderIcon(`magnifying-glass`)}
                </button>
            </div>
        `}connectedCallback(){super.connectedCallback(),document.addEventListener(`fullscreenchange`,()=>this._onFullscreenChange()),this._mutationObserver=new MutationObserver(()=>{this.offsetParent!==null&&this._map&&setTimeout(()=>this._map.invalidateSize(),150)});let e=this.parentElement;for(let t=0;t<20&&e;t++)this._mutationObserver.observe(e,{attributes:!0,attributeFilter:[`class`,`style`,`hidden`]}),e=e.parentElement}disconnectedCallback(){super.disconnectedCallback(),document.removeEventListener(`fullscreenchange`,()=>this._onFullscreenChange()),this._mutationObserver?.disconnect(),this._map&&=(this._map.remove(),null),this._resizeObserver?.disconnect()}firstUpdated(){this._initMap()}updated(e){(e.has(`latitude`)||e.has(`longitude`))&&!this._isProgrammaticUpdate&&this._mapReady&&this.latitude&&this.longitude&&this._syncMarkerToState(this.latitude,this.longitude)}_refreshMapSize(){[0,80,180,350,700,1200].forEach(e=>{setTimeout(()=>{this._map&&this.offsetParent!==null&&this._map.invalidateSize()},e)})}_initMap(){let e=this.querySelector(`.map-picker-leaflet-pane`);if(!e||this._map)return;let t=this.latitude||this.defaultLatitude,n=this.longitude||this.defaultLongitude;this._map=f.default.map(e,{center:[t,n],zoom:this.zoom,zoomControl:!1,attributionControl:!1}),this._layers.street=f.default.tileLayer(`https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png`,{maxZoom:19}).addTo(this._map),this._layers.satellite=f.default.tileLayer(`https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}`,{maxZoom:19}),this._layers.topo=f.default.tileLayer(`https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png`,{maxZoom:17}),this._mapReady=!0,this.latitude&&this.longitude?this._syncMarkerToState(this.latitude,this.longitude):this.geolocateWhenEmpty&&this._handleGeolocation(!1),this._map.on(`click`,e=>this._handleInteraction(e.latlng.lat,e.latlng.lng,!0)),this._resizeObserver=new ResizeObserver(()=>{this._map&&this._map.invalidateSize()}),this._resizeObserver.observe(this),this._refreshMapSize()}_handleInteraction(e,t,n=!0){this._isProgrammaticUpdate=!0,this.latitude=parseFloat(e.toFixed(6)),this.longitude=parseFloat(t.toFixed(6)),this._syncMarkerToState(this.latitude,this.longitude),n&&this.dispatchEvent(new CustomEvent(`coords-changed`,{detail:{latitude:this.latitude,longitude:this.longitude},bubbles:!0,composed:!0})),setTimeout(()=>{this._isProgrammaticUpdate=!1},100)}_syncMarkerToState(e,t){this._map&&(this._marker?this._marker.setLatLng([e,t]):(this._marker=f.default.marker([e,t],{draggable:!0,icon:d(f.default)}).addTo(this._map),this._marker.on(`dragend`,e=>{let t=e.target.getLatLng();this._handleInteraction(t.lat,t.lng,!0)})),this._map.setView([e,t],this._map.getZoom()))}_switchLayer(){let e=[`street`,`satellite`,`topo`],t=e[(e.indexOf(this._currentLayer)+1)%e.length];this._map.removeLayer(this._layers[this._currentLayer]),this._layers[t]._map||this._layers[t].addTo(this._map),this._currentLayer=t}async _handleGeolocation(e=!0){if(navigator.geolocation)return this._loading=!0,this.requestUpdate(),new Promise(t=>{navigator.geolocation.getCurrentPosition(n=>{this._handleInteraction(n.coords.latitude,n.coords.longitude,e),this._map&&this._map.setView([n.coords.latitude,n.coords.longitude],16),this._loading=!1,this.requestUpdate(),t(!0)},()=>{this._loading=!1,this.requestUpdate(),t(!1)},{enableHighAccuracy:!0,timeout:5e3})})}async _handleSearch(){let e=this.querySelector(`.map-picker-search-input`);if(e?.value){this._loading=!0,this.requestUpdate();try{let t=await(await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(e.value)}&limit=1`)).json();if(t?.[0]){let e=parseFloat(t[0].lat),n=parseFloat(t[0].lon);this._handleInteraction(e,n,!0),this._map?.setView([e,n],16)}}finally{this._loading=!1,this.requestUpdate()}}}_toggleFullscreen(){let e=this.querySelector(`.map-container`);e&&(document.fullscreenElement?document.exitFullscreen():e.requestFullscreen())}_onFullscreenChange(){this.requestUpdate(),this._map&&setTimeout(()=>this._map.invalidateSize(),300)}_getFullscreenIcon(){return document.fullscreenElement?`arrows-pointing-in`:`arrows-pointing-out`}};customElements.get(`map-picker-lit`)||customElements.define(`map-picker-lit`,p);
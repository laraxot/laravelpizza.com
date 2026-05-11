import{a as e,c as t,l as n,n as r,o as i,r as a,s as o,t as s}from"./map-picker-marker-config-Ckw7hrjZ.js";var c=n(r(),1),l=class extends o{static properties={latitude:{type:Number},longitude:{type:Number},defaultLatitude:{type:Number,attribute:`default-latitude`},defaultLongitude:{type:Number,attribute:`default-longitude`},zoom:{type:Number},height:{type:String}};createRenderRoot(){return this}constructor(){super(),this.latitude=null,this.longitude=null,this.defaultLatitude=41.9028,this.defaultLongitude=12.4964,this.zoom=15,this.height=`400px`,this._map=null,this._marker=null,this._layers={},this._currentLayer=`street`,this._mapReady=!1,this._loading=!1,this._isProgrammaticUpdate=!1,this._resizeObserver=null}render(){let n=!!document.fullscreenElement,r=this.height||`400px`;return t`
            <style>
                geopoint-picker-lit { display: block; width: 100%; height: 100%; min-height: 200px; }
                ${e}
                .map-container { min-height: 200px; }
                /* BUG 3 fix: :host CSS vars are ignored in Light DOM — hardcode z-index */
                .layer-controls-overlay { z-index: 1000 !important; display: flex !important; flex-direction: column !important; gap: 0.5rem !important; }
                .search-box { z-index: 1000 !important; }
                .ctrl-btn svg { width: 1.5rem; height: 1.5rem; color: #374151; }
                .ctrl-btn:hover svg { color: #ef4444; }
            </style>

            <div class="map-container ${n?`is-fullscreen`:``}" style="--map-height: ${r}">
                ${i([],()=>t`<div class="map-picker-leaflet-pane" style="height: 100%;"></div>`)}

                <div class="layer-controls-overlay">
                    <button class="ctrl-btn" type="button" @click="${this._toggleFullscreen}" title="Fullscreen">
                        ${a(`arrows-pointing-out`)}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${()=>this._handleGeolocation(!0)}" title="Mia posizione">
                        ${a(`map-pin`)}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${this._switchLayer}" title="Cambia Layer">
                        ${a(`squares-2x2`)}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${()=>this._map?.zoomIn()}" title="Zoom In">
                        ${a(`plus`)}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${()=>this._map?.zoomOut()}" title="Zoom Out">
                        ${a(`minus`)}
                    </button>
                </div>

                <div class="loading-overlay ${this._loading?`active`:``}">
                    <div class="spinner"></div>
                </div>
            </div>
        `}firstUpdated(){this._initMap(),this._resizeObserver=new ResizeObserver(()=>{this._map&&this._map.invalidateSize()}),this._resizeObserver.observe(this),this._mutationObserver=new MutationObserver(()=>{this.offsetParent!==null&&this._map&&setTimeout(()=>this._map.invalidateSize(),150)});let e=this.parentElement;for(let t=0;t<15&&e;t++)this._mutationObserver.observe(e,{attributes:!0,attributeFilter:[`class`,`style`,`hidden`]}),e=e.parentElement}disconnectedCallback(){super.disconnectedCallback(),this._resizeObserver?.disconnect(),this._mutationObserver?.disconnect(),this._map&&=(this._map.remove(),null)}updated(e){(e.has(`latitude`)||e.has(`longitude`))&&!this._isProgrammaticUpdate&&this._mapReady&&this.latitude!==null&&this.longitude!==null&&this._syncMarkerToState(this.latitude,this.longitude)}_initMap(){let e=this.querySelector(`.geopoint-leaflet-pane`)||this.querySelector(`.map-picker-leaflet-pane`);if(!e||this._map)return;let t=this.latitude||this.defaultLatitude,n=this.longitude||this.defaultLongitude;this._map=c.default.map(e,{center:[t,n],zoom:this.zoom,zoomControl:!1,attributionControl:!1}),this._layers.street=c.default.tileLayer(`https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png`,{maxZoom:19}).addTo(this._map),this._layers.satellite=c.default.tileLayer(`https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}`,{maxZoom:19}),this._layers.topo=c.default.tileLayer(`https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png`,{maxZoom:17}),this._mapReady=!0,this.latitude!==null&&this.longitude!==null?this._syncMarkerToState(this.latitude,this.longitude):this._handleGeolocation(!1),this._map.on(`click`,e=>this._handleInteraction(e.latlng.lat,e.latlng.lng)),setTimeout(()=>this._map.invalidateSize(),350)}_handleInteraction(e,t,n=!0){this._isProgrammaticUpdate=!0,this.latitude=parseFloat(e.toFixed(6)),this.longitude=parseFloat(t.toFixed(6)),this._syncMarkerToState(this.latitude,this.longitude),n&&this.dispatchEvent(new CustomEvent(`geopoint-changed`,{detail:{latitude:this.latitude,longitude:this.longitude},bubbles:!0,composed:!0})),setTimeout(()=>{this._isProgrammaticUpdate=!1},100)}_syncMarkerToState(e,t){this._map&&(this._marker?this._marker.setLatLng([e,t]):(this._marker=c.default.marker([e,t],{draggable:!0,icon:s(c.default)}).addTo(this._map),this._marker.on(`dragend`,e=>{let t=e.target.getLatLng();this._handleInteraction(t.lat,t.lng)})),this._map.setView([e,t],this._map.getZoom()))}_switchLayer(){let e=[`street`,`satellite`,`topo`],t=e[(e.indexOf(this._currentLayer)+1)%e.length];this._map.removeLayer(this._layers[this._currentLayer]),this._layers[t]._map||this._layers[t].addTo(this._map),this._currentLayer=t}async _handleGeolocation(e=!0){if(navigator.geolocation)return this._loading=!0,this.requestUpdate(),new Promise(t=>{navigator.geolocation.getCurrentPosition(n=>{this._handleInteraction(n.coords.latitude,n.coords.longitude,e),this._map&&this._map.setView([n.coords.latitude,n.coords.longitude],16),this._loading=!1,this.requestUpdate(),t(!0)},()=>{this._loading=!1,this.requestUpdate(),t(!1)},{enableHighAccuracy:!0,timeout:5e3})})}setCoordinates(e,t,n=`programmatic`){let r=parseFloat(e),i=parseFloat(t);!Number.isFinite(r)||!Number.isFinite(i)||(this._handleInteraction(r,i,n),this._map?.setView([r,i],Math.max(this._map?.getZoom()||this.zoom,16),{animate:!0}),this._refreshMapSize())}_toggleFullscreen(){let e=this.querySelector(`.map-container`);e&&(document.fullscreenElement?document.exitFullscreen():e.requestFullscreen())}};customElements.get(`geopoint-picker-lit`)||customElements.define(`geopoint-picker-lit`,l);
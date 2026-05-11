import{l as e,n as t}from"./leaflet-src-wbhDMNhH.js";function n(n){let r=n.labels||{};return e`
        <div class="layer-controls-overlay">
            <button class="ctrl-btn" type="button" @click=${()=>n._toggleFullscreen()} aria-label="${n.isFullscreen?r.close_fullscreen||`Chiudi`:r.fullscreen||`Fullscreen`}" title="${n.isFullscreen?r.close_fullscreen||`Chiudi`:r.fullscreen||`Fullscreen`}">
                ${n.isFullscreen?t(`arrows-pointing-in`):t(`arrows-pointing-out`)}
                <span class="ctrl-fallback" aria-hidden="true">${n.isFullscreen?`⤢`:`⛶`}</span>
            </button>

            <button class="ctrl-btn" type="button" @click=${()=>n._requestGeolocation()} ?disabled=${n.isLocating} aria-label="${r.use_location||`Mia posizione`}" title="${r.use_location||`Mia posizione`}">
                ${n.isLocating?e`<svg class="animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" opacity=".25"/><path d="M4 12a8 8 0 018-8" opacity=".75"/></svg>`:t(`map-pin`)}
                <span class="ctrl-fallback" aria-hidden="true">◎</span>
            </button>

            <button class="ctrl-btn" type="button" @click=${()=>n._switchLayer()} aria-label="${r.switch_layer||`Cambia Layer`}" title="${r.switch_layer||`Cambia Layer`}">
                ${t(`squares-2x2`)}
                <span class="ctrl-fallback" aria-hidden="true">▦</span>
            </button>

            <button class="ctrl-btn" type="button" @click=${()=>n._zoomIn()} aria-label="${r.zoom_in||`Zoom In`}" title="${r.zoom_in||`Zoom In`}">
                ${t(`plus`)}
                <span class="ctrl-fallback" aria-hidden="true">+</span>
            </button>
            <button class="ctrl-btn" type="button" @click=${()=>n._zoomOut()} aria-label="${r.zoom_out||`Zoom Out`}" title="${r.zoom_out||`Zoom Out`}">
                ${t(`minus`)}
                <span class="ctrl-fallback" aria-hidden="true">−</span>
            </button>
        </div>
    `}function r(e){if(!e._map||!e._layers)return;let t=[`street`,`humanitarian`,`satellite`,`topo`],n=t[(t.indexOf(e._currentLayer)+1)%t.length],r=e._layers[e._currentLayer];r&&e._map.removeLayer(r);let i=e._layers[n];i&&!i._map&&i.addTo(e._map),e._currentLayer=n}function i(e){e.isFullscreen=!e.isFullscreen,e.isFullscreen?document.body.style.overflow=`hidden`:document.body.style.overflow=``,e.dispatchEvent(new CustomEvent(`fullscreen-changed`,{detail:{isFullscreen:e.isFullscreen},bubbles:!0,composed:!0})),e._map&&setTimeout(()=>e._map?.invalidateSize(),350)}function a(e){e._map&&(e._map.zoomIn(),setTimeout(()=>e._map?.invalidateSize(),150))}function o(e){e._map&&(e._map.zoomOut(),setTimeout(()=>e._map?.invalidateSize(),150))}function s(e,t={}){let{showLoading:n=!0}=t;!navigator.geolocation||e.isLocating||(n&&(e.isLocating=!0,e.requestUpdate()),navigator.geolocation.getCurrentPosition(t=>{let r=t.coords.latitude,i=t.coords.longitude;e._handleMapInteraction(r,i,`geolocation`),n&&(e.isLocating=!1,e.requestUpdate()),e._map&&e._map.setView([r,i],Math.max(e._map.getZoom(),16))},()=>{n&&(e.isLocating=!1,e.requestUpdate()),e.geolocated=!1},{enableHighAccuracy:!0,timeout:5e3}))}var c=3,l=350,u=`https://nominatim.openstreetmap.org/search`;function d(n){let r=n.labels||{},i=r.search_placeholder||`Cerca indirizzo...`,a=Array.isArray(n.searchResults)?n.searchResults:[],o=!!(n.showSearchResults&&a.length>0);return e`
        <div class="search-box geo-address-search">
            <input
                type="text"
                class="map-picker-search-input"
                placeholder="${i}"
                aria-label="${i}"
                autocomplete="off"
                .value="${n.searchQuery||``}"
                @input="${e=>f(n,e.target.value)}"
                @keydown="${e=>p(n,e)}"
            />
            <button
                class="ctrl-btn"
                type="button"
                aria-label="${r.search||`Cerca`}"
                title="${r.search||`Cerca`}"
                @click="${()=>m(n,{selectFirst:!0})}"
            >
                ${n.isSearching?e`<svg class="animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" opacity=".25"/><path d="M4 12a8 8 0 018-8" opacity=".75"/></svg>`:t(`magnifying-glass`)}
                <span class="ctrl-fallback" aria-hidden="true">?</span>
            </button>

            ${o?e`
                <ul class="geo-address-search-results" role="listbox">
                    ${a.map(t=>e`
                        <li
                            role="option"
                            @click="${()=>h(n,t)}"
                            title="${t.display_name||``}"
                        >
                            ${t.display_name||`${t.lat}, ${t.lon}`}
                        </li>
                    `)}
                </ul>
            `:``}
        </div>
    `}function f(e,t){e.searchQuery=t||``,e.showSearchResults=!1,e._searchDebounce&&clearTimeout(e._searchDebounce),e.searchQuery.trim().length>=c?e._searchDebounce=setTimeout(()=>{m(e,{selectFirst:!1})},l):e.searchResults=[],e.requestUpdate?.()}function p(e,t){if(t.key===`Escape`){e.showSearchResults=!1,e.requestUpdate?.();return}t.key===`Enter`&&(t.preventDefault(),m(e,{selectFirst:!0}))}async function m(e,t={}){let n=String(e.searchQuery||``).trim();if(n.length<c){e.searchResults=[],e.showSearchResults=!1,e.requestUpdate?.();return}e.isSearching=!0,e.requestUpdate?.();try{let r=await g(e,n);e.searchResults=Array.isArray(r)?r:[],e.showSearchResults=e.searchResults.length>0,t.selectFirst&&e.searchResults[0]&&h(e,e.searchResults[0])}catch(t){console.warn(`[map-picker-search] Address search failed`,t),e.searchResults=[],e.showSearchResults=!1}finally{e.isSearching=!1,e.requestUpdate?.()}}function h(e,t){let n=Number.parseFloat(t.lat),r=Number.parseFloat(t.lon??t.lng);if(!Number.isFinite(n)||!Number.isFinite(r))return;let i=t.display_name||`${n}, ${r}`;e.searchQuery=i,e.searchResults=[],e.showSearchResults=!1,typeof e._handleSearchSelection==`function`?e._handleSearchSelection(t,n,r):typeof e._handleMapInteraction==`function`?e._handleMapInteraction(n,r,`search`):e._map&&e._map.setView([n,r],Math.max(e._map.getZoom(),16)),e.dispatchEvent(new CustomEvent(`address-selected`,{detail:{result:t,address:i,lat:n,lng:r,latitude:n,longitude:r},bubbles:!0,composed:!0})),e.requestUpdate?.()}async function g(e,t){if(typeof e.searchAddress==`function`)return e.searchAddress(t);let n=new URL(u);n.searchParams.set(`format`,`json`),n.searchParams.set(`addressdetails`,`1`),n.searchParams.set(`limit`,`5`),n.searchParams.set(`q`,t);let r=await fetch(n.toString(),{headers:{"Accept-Language":document.documentElement.lang||`it`}});if(!r.ok)throw Error(`HTTP ${r.status}`);return r.json()}function _(e){return{street:e.tileLayer(`https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png`,{maxZoom:19}),humanitarian:e.tileLayer(`https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png`,{maxZoom:19}),satellite:e.tileLayer(`https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}`,{maxZoom:19}),topo:e.tileLayer(`https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}`,{maxZoom:19})}}export{r as a,o as c,s as i,d as n,i as o,n as r,a as s,_ as t};
import{l as e,n as t}from"./leaflet-src-DZX-yZgw.js";function n(n){let r=n.labels||{};return e`
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
    `}function r(e){if(!e._map||!e._layers)return;let t=[`street`,`humanitarian`,`satellite`,`topo`],n=t[(t.indexOf(e._currentLayer)+1)%t.length],r=e._layers[e._currentLayer];r&&e._map.removeLayer(r);let i=e._layers[n];i&&!i._map&&i.addTo(e._map),e._currentLayer=n,d(e,[0,120,300])}async function i(e){let t=l(e),n=!e.isFullscreen;n?(e._previousBodyOverflow=document.body.style.overflow||``,e._previousHtmlOverflow=document.documentElement.style.overflow||``,document.documentElement.classList.add(`geo-map-fullscreen-active`),document.body.style.overflow=`hidden`,document.documentElement.style.overflow=`hidden`,t?.requestFullscreen&&!document.fullscreenElement&&await t.requestFullscreen().catch(()=>void 0)):(document.fullscreenElement&&document.exitFullscreen&&await document.exitFullscreen().catch(()=>void 0),u(e)),e.isFullscreen=n,e.requestUpdate?.(),e.dispatchEvent(new CustomEvent(`fullscreen-changed`,{detail:{isFullscreen:e.isFullscreen},bubbles:!0,composed:!0})),d(e,[0,160,380,700])}function a(e){let t=l(e),n=document.fullscreenElement===t;document.fullscreenElement&&!n||(e.isFullscreen!==n&&(e.isFullscreen=n,e.requestUpdate?.()),n||u(e),d(e,[0,160,380]))}function o(e){e._map&&(e._map.zoomIn(),d(e,[150]))}function s(e){e._map&&(e._map.zoomOut(),d(e,[150]))}function c(e,t={}){let{showLoading:n=!0}=t;!navigator.geolocation||e.isLocating||(n&&(e.isLocating=!0,e.requestUpdate()),navigator.geolocation.getCurrentPosition(t=>{let r=t.coords.latitude,i=t.coords.longitude;e._handleMapInteraction(r,i,`geolocation`),n&&(e.isLocating=!1,e.requestUpdate()),e._map&&(e._map.setView([r,i],Math.max(e._map.getZoom(),16)),d(e,[150]))},()=>{n&&(e.isLocating=!1,e.requestUpdate()),e.geolocated=!1},{enableHighAccuracy:!0,timeout:5e3}))}function l(e){return e.renderRoot?.querySelector?.(`.map-container`)||e.querySelector?.(`.map-container`)||null}function u(e){document.documentElement.classList.remove(`geo-map-fullscreen-active`),document.body.style.overflow=e._previousBodyOverflow||``,document.documentElement.style.overflow=e._previousHtmlOverflow||``}function d(e,t=[0]){if(typeof e._refreshMapSize==`function`){e._refreshMapSize(t);return}t.forEach(t=>{setTimeout(()=>e._map?.invalidateSize(),t)})}var f=3,p=350,m=`https://nominatim.openstreetmap.org/search`;function h(n){let r=n.labels||{},i=r.search_placeholder||`Cerca indirizzo...`,a=Array.isArray(n.searchResults)?n.searchResults:[],o=!!(n.showSearchResults&&a.length>0);return e`
        <div class="search-box geo-address-search">
            <input
                type="text"
                class="map-picker-search-input"
                placeholder="${i}"
                aria-label="${i}"
                autocomplete="off"
                .value="${n.searchQuery||``}"
                @input="${e=>g(n,e.target.value)}"
                @keydown="${e=>_(n,e)}"
            />
            <button
                class="ctrl-btn"
                type="button"
                aria-label="${r.search||`Cerca`}"
                title="${r.search||`Cerca`}"
                @click="${()=>v(n,{selectFirst:!0})}"
            >
                ${n.isSearching?e`<svg class="animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" opacity=".25"/><path d="M4 12a8 8 0 018-8" opacity=".75"/></svg>`:t(`magnifying-glass`)}
                <span class="ctrl-fallback" aria-hidden="true">?</span>
            </button>

            ${o?e`
                <ul class="geo-address-search-results" role="listbox">
                    ${a.map(t=>e`
                        <li
                            role="option"
                            @click="${()=>y(n,t)}"
                            title="${t.display_name||``}"
                        >
                            ${t.display_name||`${t.lat}, ${t.lon}`}
                        </li>
                    `)}
                </ul>
            `:``}
        </div>
    `}function g(e,t){e.searchQuery=t||``,e.showSearchResults=!1,e._searchDebounce&&clearTimeout(e._searchDebounce),e.searchQuery.trim().length>=f?e._searchDebounce=setTimeout(()=>{v(e,{selectFirst:!1})},p):e.searchResults=[],e.requestUpdate?.()}function _(e,t){if(t.key===`Escape`){e.showSearchResults=!1,e.requestUpdate?.();return}t.key===`Enter`&&(t.preventDefault(),v(e,{selectFirst:!0}))}async function v(e,t={}){let n=String(e.searchQuery||``).trim();if(n.length<f){e.searchResults=[],e.showSearchResults=!1,e.requestUpdate?.();return}e.isSearching=!0,e.requestUpdate?.();try{let r=await b(e,n);e.searchResults=Array.isArray(r)?r:[],e.showSearchResults=e.searchResults.length>0,t.selectFirst&&e.searchResults[0]&&y(e,e.searchResults[0])}catch(t){console.warn(`[map-picker-search] Address search failed`,t),e.searchResults=[],e.showSearchResults=!1}finally{e.isSearching=!1,e.requestUpdate?.()}}function y(e,t){let n=Number.parseFloat(t.lat),r=Number.parseFloat(t.lon??t.lng);if(!Number.isFinite(n)||!Number.isFinite(r))return;let i=t.display_name||`${n}, ${r}`;e.searchQuery=i,e.searchResults=[],e.showSearchResults=!1,typeof e._handleSearchSelection==`function`?e._handleSearchSelection(t,n,r):typeof e._handleMapInteraction==`function`?e._handleMapInteraction(n,r,`search`):e._map&&e._map.setView([n,r],Math.max(e._map.getZoom(),16)),e.dispatchEvent(new CustomEvent(`address-selected`,{detail:{result:t,address:i,lat:n,lng:r,latitude:n,longitude:r},bubbles:!0,composed:!0})),e.requestUpdate?.()}async function b(e,t){if(typeof e.searchAddress==`function`)return e.searchAddress(t);let n=new URL(m);n.searchParams.set(`format`,`json`),n.searchParams.set(`addressdetails`,`1`),n.searchParams.set(`limit`,`5`),n.searchParams.set(`q`,t);let r=await fetch(n.toString(),{headers:{"Accept-Language":document.documentElement.lang||`it`}});if(!r.ok)throw Error(`HTTP ${r.status}`);return r.json()}function x(e){return{street:e.tileLayer(`https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png`,{maxZoom:19}),humanitarian:e.tileLayer(`https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png`,{maxZoom:19}),satellite:e.tileLayer(`https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}`,{maxZoom:19}),topo:e.tileLayer(`https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}`,{maxZoom:19})}}export{r as a,o as c,c as i,s as l,h as n,a as o,n as r,i as s,x as t};
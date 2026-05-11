import{c as e,h as t,l as n,p as r,u as i}from"./leaflet-src-Bmf1u-60.js";t(),i();var a={},o=e(class extends n{constructor(){super(...arguments),this.ot=a}render(e,t){return t()}update(e,[t,n]){if(Array.isArray(t)){if(Array.isArray(this.ot)&&this.ot.length===t.length&&t.every((e,t)=>e===this.ot[t]))return r}else if(this.ot===t)return r;return this.ot=Array.isArray(t)?Array.from(t):t,this.render(t,n)}}),s=`/assets/geo/assets/map-picker-marker-fallback-Bu_stv-I.svg`,c={iconSize:[35,45],iconAnchor:[17,42],popupAnchor:[1,-32]},l={iconUrl:s,...c,className:`map-picker-marker map-picker-marker--primary`},u={iconUrl:s,...c,className:`map-picker-marker map-picker-marker--fallback`};function d(e){return(e??``).toString().trim().toLowerCase()===`fallback`?u:l}function f(e,t=`default`){return(t??``).toString().trim().toLowerCase()===`fallback`?e.icon(d(`fallback`)):e.divIcon({className:`map-picker-marker map-picker-marker--custom`,html:`<div class="map-picker-marker__inner" aria-hidden="true">
        <svg width="44" height="56" viewBox="0 0 44 56" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
            <defs>
                <linearGradient id="geoMarkerMain" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="#fb7185"/>
                    <stop offset="100%" stop-color="#e11d48"/>
                </linearGradient>
                <filter id="geoMarkerDrop" x="-35%" y="-25%" width="170%" height="190%">
                    <feDropShadow dx="0" dy="3" stdDeviation="2.2" flood-color="#111827" flood-opacity="0.35"/>
                </filter>
            </defs>
            <g filter="url(#geoMarkerDrop)">
                <path d="M22 2c-10.3 0-18.5 8.2-18.5 18.5 0 13.4 16.2 29 17.1 29.8.8.7 2 .7 2.8 0 .9-.8 17.1-16.4 17.1-29.8C40.5 10.2 32.3 2 22 2z" fill="url(#geoMarkerMain)"/>
                <circle cx="22" cy="20.5" r="9.2" fill="#fff"/>
                <circle cx="22" cy="20.5" r="5.2" fill="#9f1239"/>
                <rect x="17.4" y="16.2" width="9.2" height="2.2" rx="1.1" fill="#be123c" opacity="0.45"/>
            </g>
        </svg>
    </div>`,iconSize:[32,45],iconAnchor:[22,54],popupAnchor:[0,-42]})}export{o as n,f as t};
<?php

declare(strict_types=1);

/**
 * @var \Modules\Geo\Filament\Widgets\BaseMapWidget $widget
 * @var array<int, array{id: int|string, label: string, latitude: float, longitude: float, popup: string}> $markers
 * @var array{latitude: float|null, longitude: float|null, label: string} $origin
 * @var string $asset_base
 * @var string $map_height
 * @var array{aria_label: string, fullscreen: string, fullscreen_exit: string, locate: string, layer_satellite: string, footer: string} $map_strings
 */

$mapId = 'geo-map-'.\Illuminate\Support\Str::random(8);
?>

<x-filament-widgets::widget>
<div
    class="base-map-widget"
    data-map-id="{{ $mapId }}"
    wire:ignore
>
    <link rel="stylesheet" href="{{ $asset_base }}/leaflet.css">
    <style>
        .base-map-marker-dot {
            display: block;
            width: 14px;
            height: 14px;
            border-radius: 9999px;
            background: #2563eb;
            border: 2px solid #fff;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.4);
        }
        .base-map-origin-dot {
            display: block;
            width: 18px;
            height: 18px;
            border-radius: 9999px;
            background: #dc2626;
            border: 3px solid #fff;
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.5);
        }
        .base-map-cluster-icon {
            background: transparent;
            border: none;
        }
        .base-map-cluster-dot {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 9999px;
            background: #1d4ed8;
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            border: 2px solid #fff;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.45);
        }
        .base-map-cluster-dot--large {
            width: 44px;
            height: 44px;
            font-size: 14px;
            background: #1e40af;
        }
        .base-map-stage {
            position: relative;
        }
        .base-map-stage.is-fullscreen-fallback {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: #fff;
        }
        .base-map-stage:fullscreen,
        .base-map-stage:-webkit-full-screen {
            background: #fff;
        }
        .base-map-stage.is-fullscreen-fallback [id^="geo-map-"],
        .base-map-stage:fullscreen [id^="geo-map-"],
        .base-map-stage:-webkit-full-screen [id^="geo-map-"] {
            height: 100% !important;
            border-radius: 0;
        }
        /*
         * Controlli come L.Control dentro .leaflet-bar: Leaflet li impila
         * verticalmente nella corner senza overlap (zoom, fullscreen, ...).
         */
        .base-map-fs-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            color: #374151;
            text-decoration: none;
        }
        .base-map-fs-btn svg {
            width: 16px;
            height: 16px;
        }
        .base-map-fs-btn.is-fullscreen {
            color: #1d4ed8;
        }
        .base-map-fs-btn:focus-visible {
            outline: 2px solid #2563eb;
            outline-offset: -2px;
        }
        .base-map-locate-btn {
            display: flex !important;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            color: #374151;
            text-decoration: none;
        }
        .base-map-locate-btn.locating {
            color: #2563eb;
        }
        .base-map-locate-btn svg {
            width: 18px;
            height: 18px;
        }
    </style>
    <div class="base-map-stage" id="{{ $mapId }}-stage">
        <div
            id="{{ $mapId }}"
            role="region"
            aria-label="{{ $map_strings['aria_label'] }}"
            tabindex="0"
            style="height: {{ $map_height }}; width: 100%; border-radius: 0.5rem;"
        ></div>
    </div>
    <div class="text-xs text-gray-500 mt-2">
        {{ $map_strings['footer'] }}
    </div>
</div>
</x-filament-widgets::widget>

@script
<script>
    (() => {
        const mapId = @js($mapId);
        const markers = @js($markers);
        const origin = @js($origin);
        const assetBase = @js($asset_base);
        const stageId = mapId + '-stage';
        const state = window.GeoBaseMaps ??= {};

        /*
         * Pannelli mappa ispirati a farmshops.eu:
         * - layer control OSM + satellite Esri
         * - scala metrica
         * - permalink nella hash (#map=lat,lng,zoom)
         * - controllo "centra su di me" (geolocalizzazione browser)
         * - raggio cluster adattivo allo zoom
         */
        const buildLocateControl = (map) => {
            const locateMarkerLayer = window.L.layerGroup().addTo(map);
            let accuracyCircle = null;

            const LocateControl = window.L.Control.extend({
                options: { position: 'bottomright' },
                onAdd: function () {
                    const link = window.L.DomUtil.create('a', 'leaflet-bar base-map-locate-btn');
                    link.href = '#';
                    link.setAttribute('role', 'button');
                    link.title = @js($map_strings['locate']);
                    link.setAttribute('aria-label', @js($map_strings['locate']));
                    link.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="3"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3"/><circle cx="12" cy="12" r="8"/></svg>';
                    window.L.DomEvent.disableClickPropagation(link);
                    window.L.DomEvent.on(link, 'click', (event) => {
                        window.L.DomEvent.preventDefault(event);
                        if (!navigator.geolocation) {
                            return;
                        }
                        link.classList.add('locating');
                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                link.classList.remove('locating');
                                const latlng = [position.coords.latitude, position.coords.longitude];
                                locateMarkerLayer.clearLayers();
                                if (accuracyCircle) {
                                    map.removeLayer(accuracyCircle);
                                }
                                accuracyCircle = window.L.circle(latlng, {
                                    radius: position.coords.accuracy,
                                    color: '#2563eb',
                                    weight: 1,
                                    fillOpacity: 0.12,
                                }).addTo(map);
                                window.L.marker(latlng, {
                                    icon: window.L.divIcon({
                                        className: 'base-map-locate-dot',
                                        html: '<span class="base-map-origin-dot" style="background:#2563eb"></span>',
                                        iconSize: [18, 18],
                                        iconAnchor: [9, 9],
                                    }),
                                }).addTo(locateMarkerLayer);
                                map.flyTo(latlng, Math.max(map.getZoom(), 15));
                            },
                            () => link.classList.remove('locating'),
                            { enableHighAccuracy: true, timeout: 10000 },
                        );
                    });
                    return link;
                },
            });

            return new LocateControl();
        };

        const initialize = () => {
            const element = document.getElementById(mapId);
            if (!element || typeof window.L === 'undefined') {
                return false;
            }
            if (element.dataset.baseMapReady === '1') {
                state.maps?.[mapId]?.invalidateSize();
                return true;
            }

            state.wires ??= {};
            state.wires[mapId] = $wire;

            const map = window.L.map(element, { scrollWheelZoom: false });
            state.maps ??= {};
            state.maps[mapId] = map;
            element.dataset.baseMapReady = '1';

            const osmLayer = window.L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            });
            const satelliteLayer = window.L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 19,
                attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
            });
            osmLayer.addTo(map);
            window.L.control.layers(
                {
                    'OpenStreetMap': osmLayer,
                    @js($map_strings['layer_satellite']): satelliteLayer,
                },
                null,
                { position: 'topright' },
            ).addTo(map);
            window.L.control.scale({ imperial: false, position: 'bottomleft' }).addTo(map);
            buildLocateControl(map).addTo(map);
            buildFullscreenControl(map).addTo(map);

            /*
             * Cluster marker: a zoom basso centinaia di pin sovrapposti
             * illeggibili diventano un pallino con il conteggio.
             * Opzioni da leaflet.markercluster docs:
             * - chunkedLoading: aggiunta marker a scaglioni (no freeze UI)
             * - removeOutsideVisibleBounds: render solo marker nel viewport
             * - disableClusteringAtZoom: oltre lo zoom 15 pin singoli
             * - maxClusterRadius come funzione dello zoom (pattern farmshops)
             * Senza markercluster lib si torna ai marker singoli.
             */
            const useCluster = typeof window.L.markerClusterGroup === 'function';
            const markerLayer = useCluster
                ? window.L.markerClusterGroup({
                    maxClusterRadius: (zoom) => (zoom < 12 ? 80 : 45),
                    spiderfyOnMaxZoom: true,
                    showCoverageOnHover: false,
                    chunkedLoading: true,
                    chunkInterval: 100,
                    chunkDelay: 50,
                    removeOutsideVisibleBounds: true,
                    disableClusteringAtZoom: 15,
                    zoomToBoundsOnClick: true,
                    iconCreateFunction: (cluster) => {
                        const count = cluster.getChildCount();
                        const large = count >= 100;
                        return window.L.divIcon({
                            className: 'base-map-cluster-icon',
                            html: `<div class="base-map-cluster-dot${large ? ' base-map-cluster-dot--large' : ''}">${count}</div>`,
                            iconSize: large ? [44, 44] : [34, 34],
                        });
                    },
                })
                : map;
            if (useCluster) {
                markerLayer.addTo(map);
            }

            const bounds = [];
            markers.filter((marker) => Number.isFinite(Number(marker.latitude)) && Number.isFinite(Number(marker.longitude)))
                .forEach((marker) => {
                    const latitude = Number(marker.latitude);
                    const longitude = Number(marker.longitude);
                    const icon = window.L.divIcon({
                        className: 'base-map-marker',
                        html: '<span class="base-map-marker-dot"></span>',
                        iconSize: [14, 14],
                        iconAnchor: [7, 7],
                    });
                    const mapMarker = window.L.marker([latitude, longitude], { icon }).addTo(markerLayer);
                    bounds.push([latitude, longitude]);
                    const markerEl = mapMarker.getElement();
                    if (markerEl) {
                        markerEl.setAttribute('tabindex', '0');
                        markerEl.setAttribute('role', 'button');
                        markerEl.setAttribute('aria-label', marker.label);
                        markerEl.addEventListener('keydown', (event) => {
                            if (event.key === 'Enter' || event.key === ' ') {
                                event.preventDefault();
                                mapMarker.openPopup();
                            }
                        });
                    }
                    // popup: HTML costruito server-side (già escapato)
                    mapMarker.bindPopup(marker.popup || '');
                });

            if (Number.isFinite(Number(origin.latitude)) && Number.isFinite(Number(origin.longitude))) {
                const latitude = Number(origin.latitude);
                const longitude = Number(origin.longitude);
                window.L.marker([latitude, longitude], {
                    icon: window.L.divIcon({
                        className: 'base-map-origin-marker',
                        html: '<span class="base-map-origin-dot"></span>',
                        iconSize: [18, 18],
                        iconAnchor: [9, 9],
                    }),
                }).addTo(map).bindPopup({ content: origin.label || '' });
                bounds.push([latitude, longitude]);
            }

            // Permalink: posizione mappa nella hash, ripristinata al caricamento.
            const hashMatch = window.location.hash.match(/#map=(-?\d+(?:\.\d+)?),(-?\d+(?:\.\d+)?),(\d+)/);
            if (hashMatch) {
                map.setView([Number(hashMatch[1]), Number(hashMatch[2])], Math.min(Number(hashMatch[3]), 19));
            } else if (bounds.length === 1) {
                map.setView(bounds[0], 14);
            } else if (bounds.length > 1) {
                map.fitBounds(bounds, { padding: [30, 30], maxZoom: 13 });
            } else {
                map.setView([41.8719, 12.5674], 6);
            }
            map.on('moveend', () => {
                const center = map.getCenter();
                const nextHash = `#map=${center.lat.toFixed(5)},${center.lng.toFixed(5)},${map.getZoom()}`;
                if (window.location.hash !== nextHash) {
                    window.history.replaceState(null, '', nextHash);
                }
            });

            // Popup proporzionati al container per evitare overflow (pattern farmshops).
            map.on('popupopen', (event) => {
                const container = map.getContainer();
                event.popup.options.maxHeight = container.clientHeight * 0.8;
                event.popup.options.maxWidth = container.clientWidth * 0.95;
                event.popup.update();
            });

            // Azioni Livewire dichiarative: data-map-method + data-map-arg
            // nel popup (HTML server-side) instradano a $wire.method(arg).
            element.addEventListener('click', (event) => {
                const button = event.target.closest('[data-map-method]');
                if (!button) {
                    return;
                }
                const wire = state.wires?.[mapId];
                const method = button.dataset.mapMethod;
                const arg = button.dataset.mapArg;
                if (wire && typeof wire[method] === 'function') {
                    wire[method](Number(arg));
                }
            });

            [0, 150, 500].forEach((delay) => window.setTimeout(() => map.invalidateSize(), delay));
            if (window.ResizeObserver) {
                new ResizeObserver(() => map.invalidateSize()).observe(element);
            }
            return true;
        };

        /*
         * Fullscreen come L.Control nativo nella corner top-right:
         * Leaflet lo impila sotto i controlli di layer/zoom (niente overlap),
         * stile coerente con .leaflet-bar. L'icona commuta
         * expand/contract e la label full/exit. API nativa dove
         * disponibile, fallback CSS fixed inset-0.
         */
        const FS_ICON_EXPAND = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 3v4m16 0v4M3 19h4m16 0h4M5 3l16 16M19 3l-16 16"/></svg>';
        const FS_ICON_CONTRACT = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 3H3a2 2 0 0 0-2 2v3m18 0h-3a2 2 0 0 1-2-2V3m0 18v-3a2 2 0 0 1 2-2h3M3 16h3a2 2 0 0 1 2 2v3"/></svg>';

        const buildFullscreenControl = (map) => {
            const stage = document.getElementById(stageId);
            const enterLabel = @js($map_strings['fullscreen']);
            const exitLabel = @js($map_strings['fullscreen_exit'] ?? $map_strings['fullscreen']);
            let link = null;

            const isActive = () => Boolean(
                stage && (
                    document.fullscreenElement === stage
                    || document.webkitFullscreenElement === stage
                    || stage.classList.contains('is-fullscreen-fallback')
                ),
            );

            const syncState = () => {
                const active = isActive();
                if (link) {
                    link.classList.toggle('is-fullscreen', active);
                    link.title = active ? exitLabel : enterLabel;
                    link.setAttribute('aria-label', link.title);
                    link.setAttribute('aria-pressed', active ? 'true' : 'false');
                    link.innerHTML = active ? FS_ICON_CONTRACT : FS_ICON_EXPAND;
                }
                [100, 350].forEach((delay) => window.setTimeout(() => map.invalidateSize(), delay));
            };

            const toggle = () => {
                const fullscreenEl = document.fullscreenElement || document.webkitFullscreenElement;
                if (fullscreenEl && fullscreenEl !== stage) {
                    return;
                }
                if (fullscreenEl) {
                    (document.exitFullscreen || document.webkitExitFullscreen).call(document);
                    stage?.classList.remove('is-fullscreen-fallback');
                    syncState();
                    return;
                }
                if (stage?.requestFullscreen) {
                    stage.requestFullscreen();
                } else if (stage?.webkitRequestFullscreen) {
                    stage.webkitRequestFullscreen();
                } else if (stage) {
                    stage.classList.add('is-fullscreen-fallback');
                    syncState();
                }
                window.setTimeout(() => map.invalidateSize(), 100);
            };

            if (!state.fsListeners) {
                state.fsListeners = true;
                document.addEventListener('fullscreenchange', () => {
                    document.querySelectorAll('.base-map-stage').forEach((s) => s.classList.remove('is-fullscreen-fallback'));
                    Object.values(state.maps ?? {}).forEach((m) => {
                        window.setTimeout(() => m.invalidateSize(), 100);
                    });
                    // lo stato del bottone si aggiorna via syncState del control
                });
                document.addEventListener('webkitfullscreenchange', () => {
                    Object.values(state.maps ?? {}).forEach((m) => {
                        window.setTimeout(() => m.invalidateSize(), 100);
                    });
                });
            }

            const FullscreenControl = window.L.Control.extend({
                options: { position: 'bottomright' },
                onAdd: function () {
                    const bar = window.L.DomUtil.create('div', 'leaflet-bar');
                    link = window.L.DomUtil.create('a', 'base-map-fs-btn', bar);
                    link.href = '#';
                    link.setAttribute('role', 'button');
                    link.innerHTML = FS_ICON_EXPAND;
                    window.L.DomEvent.disableClickPropagation(link);
                    window.L.DomEvent.on(link, 'click', (event) => {
                        window.L.DomEvent.preventDefault(event);
                        toggle();
                    });
                    syncState();
                    return bar;
                },
            });

            // fullscreenchange nativo: aggiorna il bottone della mappa fullscreen
            document.addEventListener('fullscreenchange', syncState);
            document.addEventListener('webkitfullscreenchange', syncState);

            return new FullscreenControl();
        };

        /*
         * Questo script puo' girare prima che il div della mappa sia nel DOM
         * (widget lazy in header): senza retry initialize() tornava false
         * e la mappa non partiva mai.
         */
        const loadScript = (src) => new Promise((resolve, reject) => {
            const script = document.createElement('script');
            script.src = src;
            script.onload = resolve;
            script.onerror = reject;
            document.head.appendChild(script);
        });

        const ensureLibraries = async () => {
            state.leafletLoading ??= (async () => {
                if (typeof window.L === 'undefined') {
                    await loadScript(`${assetBase}/leaflet.js`);
                }
                if (typeof window.L !== 'undefined' && typeof window.L.markerClusterGroup !== 'function') {
                    try {
                        await loadScript(`${assetBase}/leaflet.markercluster.js`);
                    } catch (error) {
                        // Senza cluster la mappa resta comunque usabile.
                    }
                }
            })();
            return state.leafletLoading;
        };

        const tryInitialize = async (attemptsLeft = 30) => {
            if (initialize()) {
                return;
            }
            if (attemptsLeft > 0) {
                await ensureLibraries();
                window.setTimeout(() => tryInitialize(attemptsLeft - 1), 100);
            }
        };

        // Prima le librerie (leaflet + cluster), poi il retry sul DOM.
        ensureLibraries().finally(() => tryInitialize());
    })();
</script>
@endscript

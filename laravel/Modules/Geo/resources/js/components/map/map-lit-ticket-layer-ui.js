/**
 * Geo map-lit ticket layer — popups, modal, bounds, filters.
 * Mixed into map-lit custom element prototype.
 */
import L from 'leaflet';
import {
    buildTicketPopupHtml,
    buildTicketPopupLoadingHtml,
} from './popup-ticket.js';

export const mapLitTicketLayerUiMethods = {
    /** Populate and show the Bootstrap ticket detail modal. */
    _openTicketModal(properties, ticketType, detail = null) {
        const modalEl = document.getElementById('modal-disservizio');
        if (!modalEl) {
            return;
        }

        const title = detail?.title || properties.title || properties.name || '';
        const typeLabel = ticketType.label || '';
        const address = String(properties.address || '').trim();
        const city = String(properties.city || '').trim();
        const fullAddress =
            address && city && !address.toLowerCase().includes(city.toLowerCase())
                ? `${address} - ${city}`
                : address || city || '—';
        const description = detail?.description || properties.description || properties.content || '';

        const setText = (selector, text) => {
            const el = modalEl.querySelector(selector);
            if (el) {
                el.textContent = text || '—';
            }
        };

        const modalTitleEl = modalEl.querySelector('#modal2Title');
        if (modalTitleEl) {
            modalTitleEl.textContent = title || '—';
        }
        setText('[data-element="modal-ticket-title"]', title);
        setText('[data-element="modal-ticket-type"]', typeLabel);
        setText('[data-element="modal-ticket-address"]', fullAddress);
        setText('[data-element="modal-ticket-detail"]', description);

        const images = Array.isArray(detail?.images)
            ? detail.images
            : Array.isArray(properties.images)
              ? properties.images
              : [];
        const imgEl = modalEl.querySelector('.modal-body img');
        if (imgEl) {
            imgEl.src =
                images[0] || '/themes/Sixteen/design-comuni/assets/images/img-disservizio-thumbnail.png';
        }

        this._showBootstrapModal(modalEl);
    },

    /** Show modal via Bootstrap 5 API with DOM fallback. */
    _showBootstrapModal(modalEl) {
        try {
            const ModalCtor = window.bootstrap?.Modal;
            if (ModalCtor) {
                const bsModal = new ModalCtor(modalEl);
                bsModal.show();
                return;
            }
            modalEl.classList.add('show');
            modalEl.style.display = 'block';
            modalEl.setAttribute('aria-hidden', 'false');
            document.body.classList.add('modal-open');
            if (!document.querySelector('.modal-backdrop.fade.show')) {
                const backdrop = document.createElement('div');
                backdrop.className = 'modal-backdrop fade show';
                document.body.appendChild(backdrop);
            }
        } catch {
            // ignore modal errors
        }
    },

    /** Wire close/detail buttons inside an open Leaflet popup. */
    _wirePopupActions(popup) {
        const container = popup?.getElement?.();
        if (!container) {
            return;
        }

        const closeBtn = container.querySelector('[data-popup-close]');
        if (closeBtn && !closeBtn.dataset.geoWired) {
            closeBtn.dataset.geoWired = '1';
            closeBtn.addEventListener('click', (ev) => {
                ev.preventDefault();
                this._map?.closePopup();
            });
        }

        const detailBtn = container.querySelector('[data-popup-open-detail]');
        if (detailBtn && !detailBtn.dataset.geoWired) {
            detailBtn.dataset.geoWired = '1';
            detailBtn.addEventListener('click', (ev) => {
                ev.preventDefault();
                const props = popup._geoFeatureProps;
                const type = popup._geoTicketType;
                const detail = popup._geoTicketDetail;
                if (props && type) {
                    this._openTicketModal(props, type, detail);
                }
                this._map?.closePopup();
            });
        }
    },

    /** Ensure a Leaflet popup instance exists on the marker layer. */
    _ensureFeaturePopup(layer) {
        let popup = layer.getPopup?.();
        if (!popup) {
            popup = L.popup({
                className: 'popup-wrapper',
                maxWidth: 420,
                minWidth: 300,
                autoPanPaddingTopLeft: L.point(72, 16),
            });
            layer.bindPopup(popup);
        }

        return popup;
    },

    /** Open popup with loading skeleton while ticket detail is fetched. */
    _openFeaturePopupLoading(layer, ticketType, ticketStatus) {
        const popup = this._ensureFeaturePopup(layer);
        popup.setContent(buildTicketPopupLoadingHtml(ticketType, ticketStatus));
        popup._geoFeatureProps = null;
        popup._geoTicketType = ticketType;
        popup._geoTicketStatus = ticketStatus;
        popup._geoTicketDetail = null;
        layer.openPopup();
    },

    /** Open popup with full ticket HTML and wire action buttons. */
    _openFeaturePopup(layer, properties, ticketType, ticketStatus, detail = null, coords = {}) {
        const html = buildTicketPopupHtml(properties, ticketType, ticketStatus, detail, coords);
        const popup = this._ensureFeaturePopup(layer);

        popup.setContent(html);
        popup._geoFeatureProps = properties;
        popup._geoTicketType = ticketType;
        popup._geoTicketStatus = ticketStatus;
        popup._geoTicketDetail = detail;

        layer.openPopup();
        this._wirePopupActions(popup);
    },

    /** Fit map viewport to marker bounds, optionally extending with user GPS. */
    _fitBoundsToMarkers(features, extendWith = null) {
        if (!this._map || !this._markersLayer || !features?.length) {
            return;
        }

        try {
            this._map.invalidateSize({ pan: false, animate: false });

            const mapPane = this._map.getPanes?.()?.mapPane;
            const cont = this._map.getContainer?.();
            if (mapPane && cont && mapPane.offsetWidth === 0 && cont.offsetWidth > 0) {
                mapPane.style.width = `${cont.offsetWidth}px`;
                mapPane.style.height = `${cont.offsetHeight}px`;
                this._map.invalidateSize({ pan: false, animate: false });
            }

            if (!this._map._pixelOrigin) {
                this._map._resetView(this._map.getCenter(), this._map.getZoom(), true);
            }

            const bounds = this._markersLayer.getBounds?.();
            const fgBounds = !bounds?.isValid?.() ? this._markersLayer._featureGroup?.getBounds?.() : null;
            let validBounds = bounds?.isValid?.() ? bounds : fgBounds?.isValid?.() ? fgBounds : null;

            if (extendWith && Number.isFinite(extendWith.lat) && Number.isFinite(extendWith.lng)) {
                const userPoint = L.latLng(extendWith.lat, extendWith.lng);
                validBounds = validBounds
                    ? validBounds.extend(userPoint)
                    : L.latLngBounds(userPoint, userPoint);
            }

            if (!validBounds?.isValid?.()) {
                return;
            }

            const maxZoom =
                features.length <= 3 ? 14 : features.length <= 15 ? 13 : features.length <= 40 ? 12 : 11;
            this._map.fitBounds(validBounds, { padding: [40, 40], maxZoom, animate: false });
        } catch {
            // ignore bounds errors
        }
    },

    /** Center on user GPS when available, otherwise fit marker bounds. */
    _tryCenterOnGpsThenMarkers(features) {
        if (!navigator.geolocation) {
            this._fitBoundsToMarkers(features);
            return;
        }

        let settled = false;
        const finish = (fn) => {
            if (settled) {
                return;
            }
            settled = true;
            fn();
        };

        const timeoutId = setTimeout(() => {
            finish(() => this._fitBoundsToMarkers(features));
        }, 5000);

        navigator.geolocation.getCurrentPosition(
            (pos) => {
                clearTimeout(timeoutId);
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                this._isUserCentered = true;
                this._geolocRequested = true;

                const userLatLng = L.latLng(lat, lng);

                finish(() => {
                    this._map.setView(userLatLng, 14, { animate: false });
                    const markerBounds = this._markersLayer?.getBounds?.();
                    if (markerBounds?.isValid?.() && markerBounds.contains(userLatLng)) {
                        this._fitBoundsToMarkers(features, userLatLng);
                    }
                });
            },
            () => {
                clearTimeout(timeoutId);
                finish(() => this._fitBoundsToMarkers(features));
            },
            { enableHighAccuracy: false, timeout: 5000, maximumAge: 60000 },
        );
    },

    /** Invalidate map size when element becomes visible (tab/panel switch). */
    refreshWhenVisible(afterResizeCallback = null) {
        if (!this._map || this.offsetParent === null) {
            return;
        }

        if (this._invalidateSizeTimer) {
            clearTimeout(this._invalidateSizeTimer);
        }

        this._invalidateSizeTimer = setTimeout(() => {
            this._invalidateSizeTimer = null;
            if (!this._map || this.offsetParent === null) {
                return;
            }

            this._map.invalidateSize({ pan: false });

            if (typeof afterResizeCallback === 'function') {
                afterResizeCallback();
            }
        }, 80);
    },

    /** Public alias for refreshWhenVisible (Filament/widget API). */
    invalidateSize() {
        this.refreshWhenVisible();
    },

    /** Sync or remove on-map legend control based on legend-mode attribute. */
    _syncMapLegend(_features = null) {
        const legendMode = this.getAttribute('legend-mode') || 'off';
        if (legendMode === 'off' || legendMode === 'sidebar') {
            if (this._legendControl) {
                this._map.removeControl(this._legendControl);
                this._legendControl = null;
            }
        }
    },

    /** Filter visible markers by multiple ticket type values. */
    filterByTypes(types) {
        this._activeTypeFilter = Array.isArray(types) && types.length > 0 ? types : null;
        this._applyFeatureFilters();
    },

    /** Filter visible markers by ticket status values. */
    filterByStatuses(statuses) {
        this._activeStatusFilter = Array.isArray(statuses) && statuses.length > 0 ? statuses : null;
        this._applyFeatureFilters();
    },

    /** Debounced re-render after type/status filter changes. */
    _applyFeatureFilters() {
        if (!this._markersLayer || this._allFeatures.length === 0) {
            return;
        }

        if (this._filterRenderTimer) {
            clearTimeout(this._filterRenderTimer);
        }

        this._filterRenderTimer = setTimeout(() => {
            this._filterRenderTimer = null;
            const features = this._resolveFilteredFeatures();
            this._syncMapLegend(features);
            this._renderMarkersFromFeatures(features);
        }, 80);
    },
};

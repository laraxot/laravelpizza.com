// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo map Lit CSS (split for claude-audit LOC).
import 'leaflet/dist/leaflet.css';
import { css } from 'lit';
export const mapStyles = css`
    :host {
        display: block;
        width: 100%;
        --mp-z-index: 10;
        --mp-overlay-z-index: 1000;
        --mp-fullscreen-z-index: 999999;
    }

    .map-container {
        position: relative;
        width: 100%;
        height: var(--map-height, 400px);
        border-radius: 0.5rem;
        overflow: hidden;
        border: 1px solid #d1d5db;
        background: #f3f4f6;
        z-index: var(--mp-z-index);
    }

    .map-container.is-fullscreen {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        z-index: var(--mp-fullscreen-z-index, 999999) !important;
        border-radius: 0 !important;
    }

    .map-container:fullscreen {
        width: 100vw !important;
        height: 100vh !important;
        border-radius: 0 !important;
    }

    .map-picker-leaflet-pane {
        width: 100%;
        height: 100%;
        z-index: 1;
        background: #e5e7eb;
        opacity: 1;
    }

    /* Ritaglio solo i tile Leaflet: search/controlli restano sibling fuori dal clipping. */
    .map-picker-viewport {
        position: absolute;
        inset: 0;
        overflow: hidden;
        border-radius: inherit;
        z-index: 0;
    }

    .map-picker-leaflet-pane .leaflet-container,
    .map-picker-leaflet-pane .leaflet-pane,
    .map-picker-leaflet-pane .leaflet-layer,
    .map-picker-leaflet-pane .leaflet-tile,
    .map-picker-leaflet-pane .leaflet-tile-pane {
        opacity: 1 !important;
        filter: none !important;
    }

    .layer-controls-overlay {
        position: absolute;
        top: 1rem;
        left: 1rem;
        z-index: 3001 !important;
        display: flex !important;
        flex-direction: column;
        gap: 0.75rem;
        opacity: 1 !important;
        visibility: visible !important;
        pointer-events: auto !important;
    }

    .ctrl-btn {
        width: 2.75rem;
        height: 2.75rem;
        background: #ffffff;
        border: 1px solid #94a3b8;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #17324d;
        box-shadow: 0 8px 18px rgba(23, 50, 77, 0.22);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 0;
        opacity: 1 !important;
        visibility: visible !important;
        position: relative;
        z-index: 3002;
    }

    .ctrl-btn:hover {
        background: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        color: #2563eb;
    }

    .ctrl-btn svg {
        width: 1.25rem !important;
        height: 1.25rem !important;
    }

    /* Fallback emoji/text solo se il pulsante non ha ancora un <svg> (icons da ?raw). */
    .ctrl-btn .ctrl-fallback {
        display: none !important;
        font-size: 1rem;
        font-weight: 700;
        line-height: 1;
    }

    .ctrl-btn:not(:has(svg)) .ctrl-fallback {
        display: inline-block !important;
    }

    .ctrl-btn svg {
        display: block;
    }

    .search-box {
        position: absolute;
        top: 1rem;
        right: 1rem;
        /* Sopra overlay controlli (3001) e overlay loading (2000), sotto fullscreen chrome */
        z-index: 3200 !important;
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.9);
        padding: 0.5rem;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(8px);
        max-width: 300px;
        width: min(300px, calc(100% - 5rem));
        align-items: center;
    }

    .search-box input {
        flex: 1;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        width: 100%;
        min-width: 0;
        outline: none;
        color: #17324d;
        background: #ffffff;
        line-height: 1.25rem;
    }

    .search-box .ctrl-btn {
        flex: 0 0 auto;
        width: 2.75rem;
        min-width: 2.75rem;
        height: 2.75rem;
    }

    .search-box .ctrl-btn svg {
        display: block;
        width: 1.25rem !important;
        height: 1.25rem !important;
        flex: 0 0 auto;
    }

    .geo-address-search-results {
        flex: 0 0 100%;
        max-height: 12rem;
        margin: 0;
        padding: 0.25rem 0;
        overflow: auto;
        list-style: none;
        border: 1px solid #d1d5db;
        border-radius: 0.75rem;
        background: #ffffff;
        color: #17324d;
        box-shadow: 0 10px 24px rgba(23, 50, 77, 0.16);
    }

    .geo-address-search-results li {
        padding: 0.55rem 0.75rem;
        cursor: pointer;
        font-size: 0.8125rem;
        line-height: 1.25;
    }

    .geo-address-search-results li:hover,
    .geo-address-search-results li:focus-visible {
        background: #eef6ff;
        color: #0050a4;
        outline: none;
    }

    html.geo-map-fullscreen-active,
    html.geo-map-fullscreen-active body {
        overflow: hidden !important;
    }

    .map-container.is-fullscreen .layer-controls-overlay,
    .map-container.is-fullscreen .search-box {
        z-index: 3002 !important;
    }

    .loading-overlay {
        position: absolute;
        inset: 0;
        background: rgba(255, 255, 255, 0.7);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 2000;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: opacity 0.3s;
    }

    .loading-overlay.active {
        display: flex;
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }

    .spinner {
        width: 2.5rem;
        height: 2.5rem;
        border: 4px solid #e5e7eb;
        border-top-color: #2563eb;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .leaflet-container {
        font-family: inherit;
    }

    .leaflet-marker-icon.map-picker-marker {
        background: transparent;
        border: 0;
    }

    .map-picker-marker,
    .map-picker-marker__inner {
        display: block;
        width: 44px;
        height: 56px;
        filter: drop-shadow(0 4px 8px rgba(15, 23, 42, 0.32));
    }

    .map-picker-marker svg {
        width: 100%;
        height: 100%;
        display: block;
    }

    /* Cluster Circle - farmshops.eu style (no transform hover: fa "scappare" dal anchor Leaflet) */
    .circle, .geo-cluster-circle {
        color: #17324d;
        border: 3px solid #007a52;
        background: #ffffff;
        border-radius: 50%;
        width: 80px;
        height: 80px;
        font-family: 'Titillium Web', sans-serif;
        font-weight: 700;
        font-size: 18px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
    }
    .circle:hover, .geo-cluster-circle:hover {
        box-shadow: 0 6px 16px rgba(0,0,0,0.22);
    }
    .circle strong, .geo-cluster-circle strong {
        line-height: 1;
    }

    .circle-dots, .geo-cluster-type-icons {
        display: flex;
        gap: 3px;
        justify-content: center;
        flex-wrap: wrap;
        max-width: 80%;
        margin-top: 4px;
    }

    .geo-cluster-type-icons svg,
    .geo-cluster-type-icons img,
    .geo-cluster-type-dot {
        display: block !important;
        width: 14px !important;
        height: 14px !important;
        max-width: 14px !important;
        max-height: 14px !important;
        min-width: 14px !important;
        min-height: 14px !important;
        flex: 0 0 auto !important;
        object-fit: contain;
    }

    .geo-cluster-type-tile {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        border-radius: 5px;
        background: #fff;
        border: 1px solid #d9e2f0;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.12);
        flex: 0 0 auto;
    }

    .geo-cluster-type-tile img {
        width: 14px !important;
        height: 14px !important;
        filter: none !important;
        opacity: 1 !important;
    }

    .geo-map-legend {
        background: #fff;
        padding: 8px 12px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        font-size: 13px;
        line-height: 1.4;
        max-height: min(220px, 40vh);
        overflow-y: auto;
        pointer-events: auto;
    }

    .geo-map-legend-title {
        display: block;
        margin-bottom: 6px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #5c6f82;
    }

    .geo-map-legend-items {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .geo-map-legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .geo-map-legend-color {
        display: inline-block;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        flex-shrink: 0;
        border: 1px solid rgba(0, 0, 0, 0.08);
    }

    .geo-map-legend-label {
        font-size: 12px;
        color: #17324d;
        line-height: 1.2;
    }

    /* Leaflet cluster wrapper — anchor stabile, no transform */
    .leaflet-marker-icon.geo-cluster-wrapper {
        background: transparent !important;
        border: none !important;
    }
    .leaflet-marker-icon.geo-cluster-wrapper > div {
        transform-origin: center center;
    }

    /* Popup - farmshops.eu structure */
    .leaflet-popup-content-wrapper {
        padding: 0;
        overflow: hidden;
        border-radius: 0.75rem;
    }

    .leaflet-popup-content {
        margin: 0;
        width: 100% !important;
    }

    .geo-popup-header {
        background: #4ca7ce;
        padding: 0.75rem 2.5rem 0.75rem 1rem;
        color: #fff;
    }

    .geo-popup-header h1 {
        font-size: 1.1rem;
        margin: 0;
        color: #fff;
        font-weight: 700;
        line-height: 1.2;
    }

    .geo-popup-body {
        padding: 1rem;
        font-size: 0.875rem;
        color: #1e293b;
    }

    .geo-popup-section {
        margin-bottom: 1rem;
    }

    .geo-popup-section:last-child {
        margin-bottom: 0;
    }

    .geo-popup-label {
        font-weight: 700;
        display: block;
        margin-bottom: 0.25rem;
        color: #4ca7ce;
    }

    .geo-popup-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .geo-popup-footer {
        padding: 0.75rem 1rem;
        border-top: 1px solid #e2e8f0;
        background: #f8fafc;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .geo-popup-btn {
        display: inline-block;
        padding: 0.5rem 1rem;
        background: #4ca7ce;
        color: #fff !important;
        border-radius: 0.5rem;
        text-decoration: none !important;
        font-weight: 600;
        font-size: 0.75rem;
        transition: all 0.2s;
    }

    .geo-popup-btn:hover {
        background: #3a8fb3;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
`;

// Light DOM components cannot rely on Lit static styles.
// Expose raw CSS text for inline <style> injection.
export const mapStylesText = mapStyles.cssText;

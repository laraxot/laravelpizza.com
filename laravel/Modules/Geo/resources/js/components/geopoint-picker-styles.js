/**
 * GeopointPickerLit Styles — CSSResult for Shadow DOM isolation.
 *
 * @see https://lit.dev/docs/components/styles/
 */

import { css } from '@theme-lit';

export const geopointPickerStyles = css`
    :host {
        display: block;
        width: 100%;
        box-sizing: border-box;
        --map-height: 400px;
        --map-border-radius: 0.5rem;
        --map-border-color: #e5e7eb;
        --map-bg: #f3f4f6;
    }

    * { box-sizing: border-box; }

    .map-container {
        width: 100%;
        height: var(--map-height);
        min-height: 300px;
        border-radius: var(--map-border-radius);
        overflow: hidden;
        position: relative;
        border: 1px solid var(--map-border-color);
        background: var(--map-bg);
    }

    .geopoint-leaflet-pane {
        width: 100%;
        height: 100%;
        position: relative;
        z-index: 0;
    }

    .leaflet-top.leaflet-left .leaflet-control { z-index: 1100; }

    .geopoint-marker { background: transparent; border: none; }

    .search-box {
        position: absolute;
        top: 12px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1200;
        display: flex;
        gap: 8px;
        background: white;
        padding: 8px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,.15);
        width: calc(100% - 24px);
        max-width: 400px;
    }

    .search-box input {
        flex: 1;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        padding: 8px 12px;
        font-size: 14px;
        outline: none;
        transition: border-color .2s;
    }

    .search-box input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59,130,246,.1);
    }

    .search-box button {
        border: none;
        border-radius: 6px;
        background: #3b82f6;
        color: white;
        padding: 8px 16px;
        font-size: 14px;
        cursor: pointer;
        transition: background .2s;
        white-space: nowrap;
    }

    .search-box button:hover { background: #2563eb; }

    .geopoint-toolbar { display: flex; flex-direction: column; gap: 6px; }

    .control-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        background: white;
        color: #111827;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0,0,0,.15);
        transition: all .2s ease;
        pointer-events: auto;
    }

    .control-btn:hover {
        background: #f3f4f6;
        transform: translateY(-1px);
        box-shadow: 0 3px 6px rgba(0,0,0,.2);
    }

    .control-btn svg { width: 18px; height: 18px; }

    .loading-overlay {
        position: absolute;
        inset: 0;
        background: rgba(255,255,255,.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2000;
        opacity: 0;
        pointer-events: none;
        transition: opacity .2s;
    }

    .loading-overlay.active { opacity: 1; pointer-events: auto; }

    .loading-spinner {
        width: 40px;
        height: 40px;
        border: 3px solid #e5e7eb;
        border-top-color: #3b82f6;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin { to { transform: rotate(360deg); } }

    :host(.is-fullscreen) .map-container {
        position: fixed;
        inset: 0;
        height: 100vh;
        border-radius: 0;
        z-index: 9999;
    }
`;

export const controlIcons = {
    fullscreen: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" /></svg>`,
    locate:     `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>`,
    layer:      `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" /></svg>`,
};

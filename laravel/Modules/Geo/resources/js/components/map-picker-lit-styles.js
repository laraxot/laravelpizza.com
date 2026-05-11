/**
 * Stili Lit (css``) per map-picker-lit — separati dalla logica per DX e tree-shaking.
 * Leaflet CSS resta importato nel componente (libreria esterna).
 */
import { css } from '@theme-lit';

export const mapPickerLitStyles = css`
    :host {
        display: block;
        width: 100%;
        box-sizing: border-box;
    }

    * {
        box-sizing: border-box;
    }

    .map-container {
        width: 100%;
        height: 100%;
        min-height: 300px;
        border-radius: 0.5rem;
        overflow: hidden;
        position: relative;
        border: 1px solid #e5e7eb;
        background: #f3f4f6;
    }

    .map-picker-leaflet-pane {
        width: 100%;
        height: 100%;
        position: relative;
        z-index: 0;
    }

    .map-picker-marker {
        background: transparent;
        border: none;
    }

    .control-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        background: #fff;
        color: #111827;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
        transition: all 0.2s ease;
        pointer-events: auto;
    }

    .control-btn:hover {
        background: #f3f4f6;
        transform: translateY(-1px);
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
    }

    .control-btn:active {
        transform: translateY(0);
    }

    .search-box {
        position: absolute;
        top: 10px;
        left: 10px;
        right: 60px;
        z-index: 1000;
        background: white;
        padding: 6px;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        display: flex;
        gap: 6px;
        max-width: 400px;
        pointer-events: auto;
    }

    .search-box input {
        border: 1px solid #d1d5db;
        border-radius: 4px;
        padding: 6px 10px;
        font-size: 14px;
        flex: 1;
        outline: none;
    }

    .search-box input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
    }
`;

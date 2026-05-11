import { css } from 'lit';

export const coordinatePickerStyles = css`
    .coordinate-picker-shell {
        position: relative;
        width: 100%;
        border-radius: 0.5rem;
        overflow: hidden;
        border: 1px solid #d1d5db;
        background: #f9fafb;
    }

    .coordinate-picker-shell.is-expanded {
        position: fixed;
        inset: 1rem;
        z-index: 9999;
        height: calc(100vh - 2rem) !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .coordinate-picker-shell.is-expanded .coordinate-picker-map {
        height: 100% !important;
    }

    .coordinate-picker-map {
        width: 100%;
        z-index: 1;
    }

    .layer-controls-overlay {
        position: absolute;
        top: 0.75rem;
        left: 0.75rem;
        z-index: 10;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .ctrl-btn {
        width: 2.75rem;
        height: 2.75rem;
        background: white;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #374151;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.2s;
        -webkit-tap-highlight-color: transparent;
    }

    .ctrl-btn:active {
        transform: scale(0.95);
        background: #f3f4f6;
    }

    @media (max-width: 640px) {
        .ctrl-btn {
            width: 3.25rem;
            height: 3.25rem;
        }
        .ctrl-btn svg {
            width: 1.5rem;
            height: 1.5rem;
        }
    }

    .ctrl-btn svg {
        width: 1.25rem;
        height: 1.25rem;
    }

    .ctrl-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Leaflet Overrides */
    .leaflet-container {
        font-family: inherit;
    }
`;

/**
 * Utility to inject styles into document head for Light DOM components.
 */
export function injectCoordinatePickerStyles() {
    if (document.getElementById('coordinate-picker-global-styles')) return;
    const style = document.createElement('style');
    style.id = 'coordinate-picker-global-styles';
    style.textContent = coordinatePickerStyles.cssText;
    document.head.appendChild(style);
}

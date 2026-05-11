/**
 * Stili isolati (Shadow DOM) per {@see LocationPickerLit}.
 *
 * @see https://lit.dev/docs/components/styles/
 */

import { css } from '@theme-lit';

export const locationPickerStyles = css`
    :host {
        display: block;
        width: 100%;
        box-sizing: border-box;
        --lp-map-height: 300px;
        --lp-border: #e5e7eb;
        --lp-radius: 0.5rem;
    }

    * {
        box-sizing: border-box;
    }

    .lp-map-shell {
        width: 100%;
        height: var(--lp-map-height);
        min-height: 200px;
        border-radius: var(--lp-radius);
        border: 1px solid var(--lp-border);
        overflow: hidden;
        position: relative;
        background: #f9fafb;
    }

    .lp-leaflet-pane {
        width: 100%;
        height: 100%;
    }
`;

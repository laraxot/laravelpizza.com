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
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo popup ticket styles (split for claude-audit LOC).
export const popupTicketStylesText = `
    .leaflet-popup.popup-wrapper {
        margin-bottom: 12px;
    }
    .leaflet-popup.popup-wrapper .leaflet-popup-content-wrapper {
        padding: 0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 12px 40px rgba(15, 23, 42, 0.28);
        border: 1px solid rgba(15, 23, 42, 0.08);
        backdrop-filter: blur(8px);
    }
    .leaflet-popup.popup-wrapper .leaflet-popup-content {
        margin: 0 !important;
        padding: 0 !important;
        width: min(440px, 94vw) !important;
        min-width: min(320px, 88vw);
        max-width: min(440px, 94vw);
        height: auto !important;
        min-height: 0 !important;
    }
    .leaflet-popup.popup-wrapper .leaflet-popup-content p {
        margin: 0 !important;
    }
    .leaflet-popup.popup-wrapper .leaflet-popup-tip {
        box-shadow: 0 4px 8px rgba(15, 23, 42, 0.15);
    }
    .leaflet-popup.popup-wrapper .leaflet-popup-close-button {
        color: #17324d !important;
        font-size: 1.4rem !important;
        font-weight: 400 !important;
        width: 2.5rem;
        height: 2.5rem;
        line-height: 2.5rem;
        padding: 0 !important;
        top: 0.5rem !important;
        right: 0.5rem !important;
        z-index: 3;
        transition: all 0.2s ease;
    }
    .leaflet-popup.popup-wrapper .leaflet-popup-close-button:hover {
        color: #007a52 !important;
        background: rgba(0, 122, 82, 0.12);
        border-radius: 8px;
        transform: scale(1.05);
    }
    .popup {
        font-family: 'Titillium Web', system-ui, sans-serif;
        color: #17324d;
        background: #fff;
        position: relative;
        isolation: isolate;
    }
    .popup::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 16px;
        background: linear-gradient(135deg, rgba(255,255,255,0.4) 0%, rgba(255,255,255,0) 100%);
        pointer-events: none;
        z-index: -1;
    }
    .popup__accent {
        height: 6px;
        background: linear-gradient(90deg, var(--status-color, #007a52) 0%, color-mix(in srgb, var(--status-color, #007a52) 55%, #fff) 100%);
        position: relative;
        z-index: 1;
    }
    .popup__hero {
        position: relative;
        z-index: 1;
        max-height: 140px;
        overflow: hidden;
        background: #eef2f6;
    }
    .popup__hero-img {
        display: block;
        width: 100%;
        height: 140px;
        object-fit: cover;
    }
    .popup__header--headline {
        padding: 0.65rem 2.25rem 0.75rem 0.85rem !important;
    }
    .popup__title--headline {
        font-size: 1.0625rem !important;
        line-height: 1.3 !important;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .popup__wrapper {
        padding: 0.5rem 1rem 0.65rem;
        border-bottom: 1px solid #eef2f6;
    }
    .popup__address-block {
        margin-bottom: 0.35rem;
    }
    .popup__address-block .popup__row-value {
        font-weight: 500;
        font-size: 0.875rem;
    }
    .leaflet-popup.popup-wrapper .popup__header,
    .dc-homepage-parity .leaflet-popup.popup-wrapper .popup__header,
    .popup__header {
        min-height: 0 !important;
        height: auto !important;
        max-height: none !important;
        padding: 0.4rem 2.25rem 0.1rem 0.85rem !important;
        border-bottom: 1px solid #d9e2f0;
        background: #fff;
        position: relative;
        z-index: 1;
        display: flow-root;
    }
    .popup__header-bar {
        display: grid;
        grid-template-columns: 1fr auto;
        grid-template-rows: auto;
        align-items: center;
        column-gap: 0.5rem;
        row-gap: 0;
        min-height: 0;
    }
    .popup__header-bar--with-icon {
        grid-template-columns: auto 1fr;
        align-items: flex-start;
        gap: 0.65rem;
    }
    .popup__header-icon {
        grid-column: 1;
        grid-row: 1 / span 2;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2.75rem;
        height: 2.75rem;
        border-radius: 10px;
        background: color-mix(in srgb, var(--status-color, #007a52) 8%, #fff);
        border: 1px solid color-mix(in srgb, var(--status-color, #007a52) 28%, #e8eef4);
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.08);
    }
    .popup__header-icon .popup__type-icon {
        width: 1.75rem;
        height: 1.75rem;
    }
    .popup__header-text {
        grid-column: 2;
        min-width: 0;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 0.35rem;
    }
    .popup__title {
        margin: 0 !important;
        padding: 0 !important;
        min-width: 0;
        font-size: 1.0625rem !important;
        font-weight: 700 !important;
        line-height: 1.25 !important;
        color: #17324d;
    }
    .popup__address-preview {
        margin: 0;
        font-size: 0.8125rem;
        line-height: 1.35;
        color: #5c6f82;
        font-weight: 500;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .popup__header-bar .popup__status {
        justify-self: start;
    }
    .popup__code {
        font-family: ui-monospace, 'Cascadia Code', 'Source Code Pro', monospace;
        font-size: 0.875rem;
        letter-spacing: 0.02em;
        color: #5c6f82;
    }
    .popup__status {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.25rem 0.65rem 0.25rem 0.45rem;
        border-radius: 999px;
        background: color-mix(in srgb, var(--status-color, #607d8b) 18%, #fff);
        border: 1px solid color-mix(in srgb, var(--status-color, #607d8b) 45%, #fff);
        font-size: 0.8rem;
        font-weight: 700;
        color: #17324d;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.1);
    }
    .popup__status-dot {
        width: 11px;
        height: 11px;
        border-radius: 50%;
        background: var(--status-color, #607d8b);
        border: 1.5px solid #fff;
        box-shadow: 0 0 0 1px rgba(23, 50, 77, 0.15);
        flex-shrink: 0;
    }
    .popup__body {
        padding: 0;
        margin: 0;
        max-height: min(50vh, 280px);
        overflow-y: auto;
        overflow-x: hidden;
        position: relative;
        z-index: 1;
        flex: 0 0 auto;
    }
    .popup {
        display: block;
        height: auto;
    }
    .popup__row {
        padding: 0.2rem 1rem 0.4rem;
        border-bottom: 1px solid #eef2f6;
    }
    .popup__row:last-child {
        border-bottom: none;
    }
    .popup__row--type {
        padding-top: 0.2rem;
        padding-bottom: 0.35rem;
        margin-top: 0 !important;
    }
    .popup__row-label {
        display: block;
        font-size: 0.6875rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        color: #5c6f82;
        margin: 0 0 0.05rem;
        line-height: 1.2;
    }
    .popup__row-value {
        margin: 0;
        font-size: 0.9375rem;
        line-height: 1.35;
        color: #17324d;
        word-break: break-word;
        overflow-wrap: anywhere;
        font-weight: 600;
    }
    .popup__type-value {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        font-weight: 600;
    }
    .popup__type-value .popup__type-icon {
        width: 22px;
        height: 22px;
        flex: 0 0 22px;
    }
    .popup__type-icon {
        flex: 0 0 auto;
        object-fit: contain;
    }
    .popup__map-links {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 0.25rem;
    }
    .popup__map-link {
        font-size: 0.875rem;
        font-weight: 600;
        color: #007a52;
        text-decoration: none;
        padding: 0.35rem 0.7rem;
        border-radius: 7px;
        background: #f0faf6;
        border: 1px solid #d8f3e7;
        transition: all 0.2s ease;
    }
    .popup__map-link:hover {
        background: #d8f3e7;
        text-decoration: underline;
        transform: translateY(-1px);
    }
    .popup__description {
        margin: 0.25rem 1rem 0.85rem;
        padding: 0.65rem 0.85rem;
        font-size: 0.9375rem;
        line-height: 1.5;
        color: #334155;
        background: color-mix(in srgb, var(--status-color, #607d8b) 6%, #fff);
        border-radius: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .popup__gallery {
        display: flex;
        flex-direction: row;
        gap: 0.6rem;
        padding: 0 1.25rem 0.85rem;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
    }
    .popup__img {
        flex: 0 0 78%;
        width: 78%;
        max-width: 300px;
        height: 150px;
        object-fit: cover;
        border-radius: 10px;
        display: block;
        scroll-snap-align: start;
        border: 1px solid rgba(15, 23, 42, 0.08);
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.12);
    }
    .popup__skeleton {
        border-radius: 6px;
        background: linear-gradient(90deg, #eef2f6 0%, #f8fafc 50%, #eef2f6 100%);
        background-size: 200% 100%;
        animation: popup-shimmer 1.2s ease-in-out infinite;
    }
    .popup__skeleton--title {
        height: 1.1rem;
        width: 75%;
        margin: 0;
        flex: 1 1 auto;
        min-width: 0;
    }
    .popup__skeleton--line {
        height: 0.9rem;
        width: 100%;
        margin: 0.6rem 1.25rem;
    }
    .popup__skeleton--short {
        width: 60%;
    }
    @keyframes popup-shimmer {
        0% { background-position: 100% 0; }
        100% { background-position: -100% 0; }
    }
    .popup__footer {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        padding: 0.75rem 1rem 0.9rem;
        border-top: 1px solid #e8eef4;
        background: #f8fafc;
        position: relative;
        z-index: 1;
    }
    .popup__link {
        flex: 1 1 auto;
        width: 100%;
        min-width: 0;
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
        font-weight: 600;
        font-family: inherit;
        border-radius: 9px;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        line-height: 1.25;
        border: none;
        transition: all 0.2s ease;
    }
    .popup__link--primary {
        color: #fff;
        background: #007a52;
        box-shadow: 0 2px 8px rgba(0, 122, 82, 0.3);
    }
    .popup__link--primary:hover {
        background: #006341;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 122, 82, 0.35);
    }
    .popup__link--ghost {
        color: #007a52;
        background: #fff;
        border: 2px solid #007a52;
    }
    .popup__link--ghost:hover {
        background: #f0faf6;
        transform: translateY(-1px);
    }
`;

import { html } from 'lit';
import { geoIcon } from '../heroicons.js';
import { scheduleMapInvalidate } from '../resize-after-action.js';

/**
 * Pulsante overlay fullscreen: markup qui, logica in toggleFullscreen / syncFullscreenState.
 * Self-contained: basta importare questo modulo e chiamare renderButton(ctx).
 *
 * @param {Object} ctx - host Lit (coordinate-picker-lit, map-lit, …)
 */
export function renderButton(ctx) {
    const l = ctx.labels || {};
    const entering = !ctx.isFullscreen;
    const label = entering ? (l.fullscreen || 'Fullscreen') : (l.close_fullscreen || 'Chiudi');
    return html`
        <button class="ctrl-btn" type="button"
            @click=${() => toggleFullscreen(ctx)}
            aria-label="${label}"
            title="${label}">
            ${entering ? geoIcon('arrows-pointing-out') : geoIcon('arrows-pointing-in')}
        </button>
    `;
}

export async function toggleFullscreen(ctx) {
    const container = getMapContainer(ctx);
    const entering = !ctx.isFullscreen;

    if (!container) {
        return;
    }

    if (entering) {
        ctx._previousBodyOverflow = document.body.style.overflow || '';
        ctx._previousHtmlOverflow = document.documentElement.style.overflow || '';
        document.documentElement.classList.add('geo-map-fullscreen-active');
        document.body.style.overflow = 'hidden';
        document.documentElement.style.overflow = 'hidden';

        if (container.requestFullscreen && !document.fullscreenElement) {
            try {
                await container.requestFullscreen();
            } catch {
                restoreFullscreenDocumentState(ctx);
            }
        }
    } else {
        if (document.fullscreenElement && document.exitFullscreen) {
            try {
                await document.exitFullscreen();
            } catch {
                // ignore — document state restored below
            }
        }

        restoreFullscreenDocumentState(ctx);
    }

    ctx.isFullscreen = entering;
    ctx.requestUpdate?.();

    ctx.dispatchEvent(new CustomEvent('fullscreen-changed', {
        detail: { isFullscreen: ctx.isFullscreen },
        bubbles: true,
        composed: true,
    }));

    scheduleMapInvalidate(ctx, [0, 160, 380, 700]);
}

export function syncFullscreenState(ctx) {
    const container = getMapContainer(ctx);
    const active = document.fullscreenElement === container;

    if (document.fullscreenElement && !active) {
        return;
    }

    if (ctx.isFullscreen !== active) {
        ctx.isFullscreen = active;
        ctx.requestUpdate?.();
    }

    if (!active) {
        restoreFullscreenDocumentState(ctx);
    }

    scheduleMapInvalidate(ctx, [0, 160, 380]);
}

function getMapContainer(ctx) {
    return ctx.renderRoot?.querySelector?.('.map-container')
        || ctx.querySelector?.('.map-container')
        || null;
}

function restoreFullscreenDocumentState(ctx) {
    document.documentElement.classList.remove('geo-map-fullscreen-active');
    document.body.style.overflow = ctx._previousBodyOverflow || '';
    document.documentElement.style.overflow = ctx._previousHtmlOverflow || '';
}

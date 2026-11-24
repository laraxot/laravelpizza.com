// Disegna le superfici A2UI che arrivano come risultato di un tool ({"a2ui": [...]}).
// Si carica solo quando serve (import dinamico): chi non riceve interfacce non scarica Lit, Chart.js e il renderer.
import { MessageProcessor, basicCatalog, setMarkdownRenderer } from '@a2ui/web_core/v1_0';
import '@a2ui/lit'; // registra <a2ui-surface>
import { renderMarkdown } from '@a2ui/markdown-it';
import { panelCatalog, STYLES } from './panel-catalog.js';

setMarkdownRenderer(renderMarkdown);

let styled = false;
function injectStyles() {
    if (styled) return;
    styled = true;
    const style = document.createElement('style');
    style.dataset.a2ui = 'panel';
    style.textContent = STYLES;
    document.head.append(style);
}

/**
 * @param {(element: HTMLElement) => void} append  dove mettere ogni nuova superficie
 * @param {(action: {name: string, context: object}) => void} [onAction]  eventi dei pulsanti
 * @returns {(content: string) => boolean}  disegna il risultato di un tool; false se non e' A2UI
 */
export function createSurfaceRenderer(append, onAction = () => {}) {
    injectStyles();

    const processor = new MessageProcessor([basicCatalog, panelCatalog], async (action) => {
        const { name, context = {} } = action.event ?? action;
        onAction({ name, context });
    });

    processor.onSurfaceCreated((surface) => {
        const element = document.createElement('a2ui-surface');
        element.surface = surface;
        element.className = 'a2p-surface';
        append(element);
    });

    return (content) => {
        let payload;
        try {
            payload = JSON.parse(content);
        } catch {
            return false;
        }
        if (!Array.isArray(payload?.a2ui)) return false;

        processor.processMessages(payload.a2ui);

        return true;
    };
}

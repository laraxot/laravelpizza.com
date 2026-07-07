const SAFE_HEX_COLOR = /^#[0-9a-f]{3}([0-9a-f]{3})?$/i;

const STATUS_COLOR_FALLBACK = {
    open: '#2563eb',
    pending: '#f59e0b',
    in_review: '#8b5cf6',
    in_progress: '#0ea5e9',
    on_hold: '#64748b',
    resolved: '#16a34a',
    closed: '#475569',
    reopened: '#dc2626',
    draft: '#94a3b8',
};

const FILAMENT_TOKEN_TO_HEX = {
    gray: '#64748b',
    secondary: '#475569',
    warning: '#f59e0b',
    info: '#0ea5e9',
    orange: '#f97316',
    danger: '#dc2626',
    success: '#16a34a',
    primary: '#2563eb',
};

function normalizeColor(color, fallback = '#607d8b') {
    const raw = String(color || '').trim().toLowerCase();
    if (SAFE_HEX_COLOR.test(raw)) {
        return raw;
    }

    return FILAMENT_TOKEN_TO_HEX[raw] ?? fallback;
}

/**
 * Stato ticket per colore pin mappa (TicketStatusEnum).
 *
 * @param {Record<string, unknown>} properties
 * @returns {{ value: string, label: string, color: string }}
 */
export function resolveFeatureTicketStatus(properties = {}) {
    const nested = properties.status && typeof properties.status === 'object' ? properties.status : null;

    if (nested) {
        const value = String(nested.value ?? 'open');

        return {
            value,
            label: String(nested.label ?? value),
            color: normalizeColor(nested.color, STATUS_COLOR_FALLBACK[value] ?? '#607d8b'),
        };
    }

    const value = typeof properties.status === 'string' && properties.status !== '' ? properties.status : 'open';

    return {
        value,
        label: String(properties.status_label ?? value),
        color: normalizeColor(properties.status_color, STATUS_COLOR_FALLBACK[value] ?? '#607d8b'),
    };
}

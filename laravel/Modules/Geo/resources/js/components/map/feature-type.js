/**
 * Contratto GeoJSON properties.type — tipologia (TicketTypeEnum).
 * Una sola icona pubblica: iconUrl da fixcity::svg (mai doppio heroicon + ui::svg).
 *
 * @param {Record<string, unknown>} properties
 * @returns {{ value: string, label: string, iconUrl: string|null }}
 */
export function resolveFeatureTicketType(properties = {}) {
    const nested = properties.type && typeof properties.type === 'object' ? properties.type : null;

    if (nested) {
        const value = String(nested.value ?? 'other');
        const iconUrl = nested.iconUrl ?? nested.icon_url ?? null;

        return {
            value,
            label: String(nested.label ?? value),
            iconUrl: typeof iconUrl === 'string' && iconUrl !== '' ? iconUrl : null,
        };
    }

    const value = typeof properties.type === 'string' ? properties.type : 'other';
    const legacyUrl = properties.type_icon_url ?? null;

    return {
        value,
        label: String(properties.type_label ?? value),
        iconUrl: typeof legacyUrl === 'string' && legacyUrl !== '' ? legacyUrl : null,
    };
}

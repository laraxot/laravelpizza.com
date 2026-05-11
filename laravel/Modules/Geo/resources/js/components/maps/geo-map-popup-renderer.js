export class GeoMapPopupRenderer {
    render(feature) {
        const popup = feature.properties?.popup ?? {};
        const title = this.escape(popup.title ?? feature.properties?.title ?? 'Place');
        const category = this.escape(popup.category ?? feature.properties?.category ?? 'unknown');
        const address = this.escape(popup.address ?? '');
        const description = this.escape(popup.description ?? '');

        return `
            <div class="geo-map-popup">
                <div class="geo-map-popup__title">${title}</div>
                <div class="geo-map-popup__meta">${category}</div>
                ${address !== '' ? `<div class="geo-map-popup__address">${address}</div>` : ''}
                ${description !== '' ? `<div class="geo-map-popup__description">${description}</div>` : ''}
            </div>
        `;
    }

    escape(value) {
        return String(value)
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }
}

import { test, expect } from '@playwright/test';

/** Mappa elenco (non il blocco map-preview opzionale in pagina). */
const mapLit = (page) => page.locator('#segnalazioni-elenco-root map-lit#ticket-map');

test.describe('Segnalazioni elenco — marker icon parity (TicketTypeEnum)', () => {
  test.beforeEach(async ({ page }) => {
    const response = await page.goto('http://127.0.0.1:8000/it/tests/ticket-list', {
      waitUntil: 'domcontentloaded',
      timeout: 30000,
    });

    test.skip(response === null || !response.ok(), 'App non raggiungibile su :8000');

    await page.waitForSelector('#segnalazioni-elenco-root', { timeout: 10000 });
    await mapLit(page).waitFor({ state: 'visible', timeout: 15000 });
    await mapLit(page).locator('.leaflet-container').waitFor({ timeout: 25000 });
  });

  test('marker con typeIconUrl include glifo nel template icona Leaflet', async ({ page }) => {
    const status = await mapLit(page).evaluate((el) => {
      const markers = Array.isArray(el._allMarkers) ? el._allMarkers : [];
      const withIcon = markers.filter((m) => m.options?.typeIconUrl);
      const samples = withIcon.slice(0, 5).map((m) => ({
        type: m.options.typeValue,
        typeIconUrl: m.options.typeIconUrl,
      }));

      return {
        total: markers.length,
        withIconUrl: withIcon.length,
        samples,
      };
    });

    if (status.total === 0) {
      test.skip(true, 'Nessun marker nel dataset — rigenerare tickets.json');
    }

    if (status.withIconUrl === 0) {
      test.skip(true, 'GeoJSON senza type.iconUrl — export o enrich tickets.json');
    }

    expect(status.withIconUrl).toBeGreaterThan(0);

    for (const sample of status.samples) {
      const imgGlyph = page.locator(
        `.geo-map-marker-glyph--img[src="${sample.typeIconUrl}"]`
      ).first();

      expect(await imgGlyph.count()).toBeGreaterThan(0);
      expect(sample.typeIconUrl).toContain('/assets/fixcity/svg/');

      const box = await imgGlyph.boundingBox();
      expect(box?.width ?? 0).toBeGreaterThanOrEqual(20);
      expect(box?.width ?? 0).toBeLessThanOrEqual(36);
      expect(box?.height ?? 0).toBeGreaterThanOrEqual(20);
      expect(box?.height ?? 0).toBeLessThanOrEqual(36);
    }
  });

  test('almeno due tipi distinti hanno URL icona diversi', async ({ page }) => {
    const distinct = await mapLit(page).evaluate((el) => {
      const markers = Array.isArray(el._allMarkers) ? el._allMarkers : [];
      const byType = new Map();

      markers.forEach((m) => {
        const t = m.options?.typeValue;
        const url = m.options?.typeIconUrl;
        if (t && url && !byType.has(t)) {
          byType.set(t, url);
        }
      });

      return [...byType.entries()];
    });

    if (distinct.length < 2) {
      test.skip(true, 'Servono almeno 2 tipi ticket con coordinate nel DB');
    }

    const urls = new Set(distinct.map(([, url]) => url));
    expect(urls.size).toBeGreaterThanOrEqual(2);
  });

  test('GeoJSON type annidato: value, label, iconUrl fixcity (no heroicon duplicato)', async ({ request }) => {
    const res = await request.get('http://127.0.0.1:8000/data/tickets.json');
    test.skip(!res.ok(), 'tickets.json non disponibile');

    const data = await res.json();
    test.skip(!data.features || data.features.length === 0, 'Nessun ticket nel JSON');

    // Verifica primo feature abbia struttura annidata
    const first = data.features[0];
    expect(first.properties).toHaveProperty('type');
    expect(typeof first.properties.type).toBe('object');
    expect(first.properties.type).toHaveProperty('value');
    expect(first.properties.type).toHaveProperty('label');
    expect(first.properties.type).toHaveProperty('iconUrl');
    expect(first.properties.type.iconUrl).toContain('/assets/fixcity/svg/');
    expect(first.properties.type).not.toHaveProperty('icon');
    expect(first.properties.type).not.toHaveProperty('color');
  });
});

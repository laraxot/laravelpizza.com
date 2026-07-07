import { test, expect } from '@playwright/test';

/**
 * STORY-127 — /it: GPS, filtri SSoT tickets.json, icone legenda in sidebar.
 */
test.describe('/it — mappa GPS e filtri legenda', () => {
  test.use({
    geolocation: { latitude: 44.4949, longitude: 11.3426 },
    permissions: ['geolocation'],
  });

  test.beforeEach(async ({ page }) => {
    const response = await page.goto('http://127.0.0.1:8000/it', {
      waitUntil: 'domcontentloaded',
      timeout: 30000,
    });

    test.skip(response === null || !response.ok(), 'App non raggiungibile su :8000');

    await page.waitForSelector('map-lit#block-map', { timeout: 15000 });
    await page.waitForSelector('.leaflet-container', { timeout: 25000 });
  });

  test('mappa centra sulla posizione GPS quando non ha lat/lng espliciti', async ({ page }) => {
    await page.waitForFunction(
      () => {
        const el = document.getElementById('block-map');
        return el && el._map && el._isUserCentered === true;
      },
      { timeout: 12000 },
    );

    const center = await page.locator('map-lit#block-map').evaluate((el) => {
      const c = el._map.getCenter();

      return { lat: c.lat, lng: c.lng, zoom: el._map.getZoom() };
    });

    expect(center.lat).toBeGreaterThan(44);
    expect(center.lat).toBeLessThan(45);
    expect(center.lng).toBeGreaterThan(11);
    expect(center.lng).toBeLessThan(12);
    expect(center.zoom).toBeGreaterThanOrEqual(12);
  });

  test('filtri sidebar mostrano pin legenda con iconUrl dal JSON', async ({ page, request }) => {
    const jsonRes = await request.get('http://127.0.0.1:8000/data/tickets.json');
    test.skip(!jsonRes.ok(), 'tickets.json non disponibile');

    const geojson = await jsonRes.json();
    const withIcon = (geojson.features ?? []).find(
      (f) => f?.properties?.type?.iconUrl,
    );
    test.skip(!withIcon, 'Nessun tipo con iconUrl nel JSON');

    const iconUrl = withIcon.properties.type.iconUrl;
    const filterImg = page.locator(`.filter-type-icon[src="${iconUrl}"]`).first();
    await expect(filterImg).toBeVisible({ timeout: 10000 });
  });

  test('filtri stato in sidebar con pallino colore', async ({ page }) => {
    const statusFilter = page.locator('[data-filter-status]').first();
    await expect(statusFilter).toBeVisible({ timeout: 10000 });
    await expect(page.locator('.filter-status-color').first()).toBeVisible();
    await expect(page.locator('.geo-map-legend')).toHaveCount(0);
  });

  test('filtro stato lascia solo marker dello stato selezionato', async ({ page }) => {
    await page.waitForFunction(
      () => {
        const el = document.getElementById('block-map');
        return el && Array.isArray(el._allMarkers) && el._allMarkers.length > 0;
      },
      { timeout: 15000 },
    );

    const sampleStatus = await page.locator('map-lit#block-map').evaluate(
      (el) => el._allMarkers[0]?.options?.statusValue ?? null,
    );
    test.skip(!sampleStatus, 'Nessun marker con statusValue');

    await page.locator('[data-filter-status]').evaluateAll((inputs, keep) => {
      inputs.forEach((input) => {
        input.checked = input.value === keep;
        input.dispatchEvent(new Event('change', { bubbles: true }));
      });
    }, sampleStatus);

    await page.waitForFunction(
      (status) => {
        const el = document.getElementById('block-map');
        return (
          el
          && el._allMarkers.length > 0
          && el._allMarkers.every((m) => m.options?.statusValue === status)
        );
      },
      sampleStatus,
      { timeout: 10000 },
    );
  });

  test('somma conteggi filtri tipo = feature nel JSON', async ({ page, request }) => {
    const jsonRes = await request.get('http://127.0.0.1:8000/data/tickets.json');
    test.skip(!jsonRes.ok(), 'tickets.json non disponibile');

    const geojson = await jsonRes.json();
    const totalFeatures = geojson.features?.length ?? 0;
    test.skip(totalFeatures === 0, 'Nessuna feature in tickets.json');

    const sidebarSum = await page.locator('.col-lg-3 [data-filter-type]').evaluateAll((inputs) =>
      inputs.reduce((sum, input) => {
        const count = parseInt(input.dataset.count ?? '0', 10);

        return sum + (Number.isNaN(count) ? 0 : count);
      }, 0),
    );

    expect(sidebarSum).toBe(totalFeatures);
  });
});

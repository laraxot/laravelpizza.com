import { test, expect } from '@playwright/test';

const baseUrl = process.env.PLAYWRIGHT_BASE_URL ?? 'http://127.0.0.1:8001';

/**
 * STORY-120 — map-lit carica marker da /data/tickets.json (SSoT con filtri).
 */
test.describe('map-lit markers from tickets.json', () => {
  test('/it/ shows clustered markers after geo-map-loaded', async ({ page }) => {
    test.setTimeout(120000);

    const jsonRes = await page.request.get(`${baseUrl}/data/tickets.json`);
    test.skip(!jsonRes.ok(), 'tickets.json non disponibile');
    const geojson = await jsonRes.json();
    const expected = Number(geojson.total ?? geojson.features?.length ?? 0);
    test.skip(expected < 1, 'Nessuna feature in tickets.json');

    await page.goto(`${baseUrl}/it/#`, { waitUntil: 'networkidle', timeout: 60000 });

    const mapLit = page.locator('map-lit#block-map');
    await expect(mapLit).toBeVisible({ timeout: 15000 });
    await expect(mapLit).toHaveAttribute('data-url', '/data/tickets.json');

    await expect
      .poll(
        async () =>
          page.evaluate(() => {
            const icons = document.querySelectorAll('.leaflet-marker-icon').length;
            const clusters = document.querySelectorAll('.geo-cluster-wrapper').length;
            const el = document.querySelector('map-lit#block-map');
            const all = el?._allMarkers?.length ?? 0;
            return icons + clusters + (all > 0 ? 1 : 0);
          }),
        { timeout: 90000 },
      )
      .toBeGreaterThan(0);

    const markerCount = await page.evaluate(() => {
      const el = document.querySelector('map-lit#block-map');
      return {
        allMarkers: el?._allMarkers?.length ?? 0,
        leafletIcons: document.querySelectorAll('.leaflet-marker-icon').length,
        clusters: document.querySelectorAll('.geo-cluster-wrapper').length,
      };
    });

    expect(markerCount.allMarkers).toBe(expected);
    expect(markerCount.leafletIcons + markerCount.clusters).toBeGreaterThan(0);
  });
});

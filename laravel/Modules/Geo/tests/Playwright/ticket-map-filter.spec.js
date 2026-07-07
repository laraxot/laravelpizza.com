import { test, expect } from '@playwright/test';

const ELENCO_URL = 'http://127.0.0.1:8000/it/tests/ticket-list';

/**
 * STORY-092 — /it homepage civica (no ticket-layout).
 * STORY-100 — elenco canonico + filtro mappa su tests/ticket-list.
 */
test.describe('STORY-092 — /it homepage civica', () => {
  test('nessun ticket-layout né map-lit sulla homepage', async ({ page }) => {
    const response = await page.goto('http://127.0.0.1:8000/it', {
      waitUntil: 'domcontentloaded',
      timeout: 30000,
    });

    test.skip(response === null || !response.ok(), 'App non raggiungibile su :8000');

    await expect(page.locator('map-lit#block-map')).toHaveCount(0);
    await expect(page.locator('#ticket-list-root')).toHaveCount(0);
    await expect(page).toHaveTitle(/Il mio Comune|My Municipality/i);
  });
});

test.describe('STORY-100 — elenco canonico + filtro mappa', () => {
  test.beforeEach(async ({ page }) => {
    await page.setViewportSize({ width: 1400, height: 900 });
    const response = await page.goto(`${ELENCO_URL}#`, {
      waitUntil: 'domcontentloaded',
      timeout: 30000,
    });

    test.skip(response === null || !response.ok(), 'App non raggiungibile su :8000');

    await page.waitForFunction(
      () => document.getElementById('block-map')?._allMarkers?.length > 0,
      { timeout: 15000 },
    );
  });

  test('pagina unica: un main e un map-lit#block-map', async ({ page }) => {
    await expect(page.locator('main')).toHaveCount(1);
    await expect(page.locator('map-lit#block-map')).toHaveCount(1);
    await expect(page.locator('#main-container')).toHaveCount(1);
  });

  test('uncheck tipologie riduce marker visibili', async ({ page }) => {
    await page.locator('aside [data-filter-type="road_maintenance"]').uncheck();
    await page.locator('aside [data-filter-type="public_lighting"]').uncheck();
    await page.waitForTimeout(400);

    const layers = await page.evaluate(() =>
      document.getElementById('block-map')._markersLayer.getLayers().length,
    );

    expect(layers).toBe(1);
  });
});

import { test, expect } from '@playwright/test';

const baseUrl = process.env.PLAYWRIGHT_BASE_URL ?? 'http://127.0.0.1:8000';

/**
 * STORY-125 / STORY-292 — homepage: tipologie in sidebar, nessuna legenda overlay sulla mappa.
 */
test.describe('map-lit legend', () => {
    test.use({
        geolocation: { latitude: 45.555, longitude: 12.25 },
        permissions: ['geolocation'],
        viewport: { width: 1280, height: 900 },
    });

    test('does not show redundant tipologie legend on /it', async ({ page }) => {
        test.setTimeout(120000);

        await page.goto(`${baseUrl}/it/#`, { waitUntil: 'load', timeout: 90000 });

        await expect
            .poll(
                async () =>
                    page.evaluate(() => document.querySelector('map-lit#block-map')?._allFeatures?.length ?? 0),
                { timeout: 90000 },
            )
            .toBeGreaterThan(0);

        const legend = page.locator('map-lit#block-map .geo-map-legend');
        await expect(legend).toHaveCount(0);
    });
});

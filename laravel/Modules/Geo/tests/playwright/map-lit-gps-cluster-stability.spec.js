import { test, expect } from '@playwright/test';

const baseUrl = process.env.PLAYWRIGHT_BASE_URL ?? 'http://127.0.0.1:8000';

/**
 * STORY-122 — assenza lat/lng → GPS default; cluster stabili dopo pan/zoom.
 */
test.describe('map-lit implicit GPS center and cluster stability', () => {
    test.use({
        geolocation: { latitude: 44.4949, longitude: 11.3426 },
        permissions: ['geolocation'],
        viewport: { width: 1280, height: 900 },
    });

    test('/it/ without lat/lng centers on GPS and keeps markers after pan/zoom', async ({ page }) => {
        test.setTimeout(120000);

        await page.goto(`${baseUrl}/it/#`, { waitUntil: 'networkidle', timeout: 60000 });

        const mapLit = page.locator('map-lit#block-map');
        await expect(mapLit).toBeVisible({ timeout: 15000 });
        await expect(mapLit).not.toHaveAttribute('lat');
        await expect(mapLit).not.toHaveAttribute('lng');

        await expect
            .poll(
                async () =>
                    page.evaluate(() => document.querySelector('map-lit#block-map')?._allMarkers?.length ?? 0),
                { timeout: 90000 },
            )
            .toBeGreaterThan(0);

        await expect
            .poll(
                async () =>
                    page.evaluate(() => document.querySelector('map-lit#block-map')?._isUserCentered === true),
                { timeout: 15000 },
            )
            .toBe(true);

        const afterLoad = await page.evaluate(() => ({
            allMarkers: document.querySelector('map-lit#block-map')?._allMarkers?.length ?? 0,
        }));

        await page.evaluate(() => {
            const map = document.querySelector('map-lit#block-map')?._map;
            map?.setZoom(10);
            map?.panBy([120, 80]);
            map?.setZoom(13);
            map?.panBy([-80, -40]);
            map?.setZoom(15);
        });

        await page.waitForTimeout(800);

        const afterPan = await page.evaluate(() => ({
            allMarkers: document.querySelector('map-lit#block-map')?._allMarkers?.length ?? 0,
            icons: document.querySelectorAll('.leaflet-marker-icon').length,
            clusters: document.querySelectorAll('.geo-cluster-wrapper, .marker-cluster').length,
        }));

        expect(afterPan.allMarkers).toBe(afterLoad.allMarkers);
        expect(afterPan.icons + afterPan.clusters).toBeGreaterThan(0);
    });
});

import { test, expect } from '@playwright/test';

const baseUrl = process.env.PLAYWRIGHT_BASE_URL ?? 'http://127.0.0.1:8000';

/**
 * STORY-123 / #12 — icone cluster max 14px (no trash SVG oversize).
 */
test.describe('map-lit cluster type icon sizing', () => {
    test.use({
        geolocation: { latitude: 44.4949, longitude: 11.3426 },
        permissions: ['geolocation'],
        viewport: { width: 1280, height: 900 },
    });

    test('cluster type dots are at most 16px', async ({ page }) => {
        test.setTimeout(120000);

        await page.goto(`${baseUrl}/it/#`, { waitUntil: 'networkidle', timeout: 60000 });

        await expect
            .poll(
                async () =>
                    page.evaluate(() => document.querySelector('map-lit#block-map')?._allMarkers?.length ?? 0),
                { timeout: 90000 },
            )
            .toBeGreaterThan(0);

        await page.evaluate(() => {
            document.querySelector('map-lit#block-map')?._map?.setView([44.4949, 11.3426], 10, { animate: false });
        });

        await page.waitForTimeout(800);

        const sizes = await page.evaluate(() => {
            return [...document.querySelectorAll('.geo-cluster-type-icons svg, .geo-cluster-type-icons img')].map(
                (el) => {
                    const r = el.getBoundingClientRect();
                    return { w: r.width, h: r.height };
                },
            );
        });

        expect(sizes.length).toBeGreaterThan(0);

        for (const { w, h } of sizes) {
            expect(w).toBeLessThanOrEqual(16);
            expect(h).toBeLessThanOrEqual(16);
            expect(w).toBeGreaterThanOrEqual(10);
            expect(h).toBeGreaterThanOrEqual(10);
        }
    });
});

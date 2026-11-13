import { test, expect } from '@playwright/test';

const baseUrl = process.env.PLAYWRIGHT_BASE_URL ?? 'http://127.0.0.1:8000';

/**
 * STORY-123 — cluster stabili al hover (no transform scale, no refreshClusters manuale).
 */
test.describe('map-lit cluster hover stability', () => {
    test.use({
        geolocation: { latitude: 44.4949, longitude: 11.3426 },
        permissions: ['geolocation'],
        viewport: { width: 1280, height: 900 },
    });

    test('cluster icon does not shift on hover', async ({ page }) => {
        test.setTimeout(120000);

        await page.goto(`${baseUrl}/it/#`, { waitUntil: 'networkidle', timeout: 60000 });

        const mapLit = page.locator('map-lit#block-map');
        await expect(mapLit).toBeVisible({ timeout: 15000 });

        await expect
            .poll(
                async () =>
                    page.evaluate(() => document.querySelector('map-lit#block-map')?._allMarkers?.length ?? 0),
                { timeout: 90000 },
            )
            .toBeGreaterThan(0);

        await page.evaluate(() => {
            const map = document.querySelector('map-lit#block-map')?._map;
            map?.setView([44.4949, 11.3426], 10, { animate: false });
        });

        await page.waitForTimeout(600);

        const cluster = page.locator('.leaflet-marker-icon.geo-cluster-wrapper').first();
        await expect(cluster).toBeVisible({ timeout: 10000 });

        const box = await cluster.boundingBox();
        expect(box).not.toBeNull();
        const cx = box.x + box.width / 2;
        const cy = box.y + box.height / 2;

        const before = await page.evaluate(() => {
            const icon = document.querySelector('.leaflet-marker-icon.geo-cluster-wrapper');
            const circle = icon?.querySelector('.geo-cluster-circle');
            const ir = icon?.getBoundingClientRect();
            const cs = circle ? getComputedStyle(circle) : null;
            return {
                x: ir ? ir.x + ir.width / 2 : 0,
                y: ir ? ir.y + ir.height / 2 : 0,
                transform: cs?.transform ?? 'none',
            };
        });

        await page.mouse.move(cx, cy);
        await page.waitForTimeout(200);

        const positions = await page.evaluate(async () => {
            const icon = document.querySelector('.leaflet-marker-icon.geo-cluster-wrapper');
            const circle = icon?.querySelector('.geo-cluster-circle');
            if (!icon || !circle) {
                return null;
            }

            const rect = () => {
                const r = icon.getBoundingClientRect();
                return {
                    x: r.x + r.width / 2,
                    y: r.y + r.height / 2,
                    transform: getComputedStyle(circle).transform,
                };
            };

            const samples = [rect()];

            for (let i = 0; i < 8; i++) {
                await new Promise((resolve) => setTimeout(resolve, 80));
                samples.push(rect());
            }

            return samples;
        });

        expect(positions).not.toBeNull();
        expect(positions.length).toBeGreaterThan(1);

        const xs = positions.map((p) => p.x);
        const ys = positions.map((p) => p.y);
        const deltaX = Math.max(...xs) - Math.min(...xs);
        const deltaY = Math.max(...ys) - Math.min(...ys);

        expect(deltaX).toBeLessThan(3);
        expect(deltaY).toBeLessThan(3);

        const transforms = positions.map((p) => p.transform);
        for (const t of transforms) {
            expect(t === 'none' || t === 'matrix(1, 0, 0, 1, 0, 0)').toBeTruthy();
        }

        const afterHover = positions[positions.length - 1];
        expect(Math.abs(afterHover.x - before.x)).toBeLessThan(3);
        expect(Math.abs(afterHover.y - before.y)).toBeLessThan(3);
    });
});

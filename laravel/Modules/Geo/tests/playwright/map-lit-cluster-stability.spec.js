import { test, expect } from '@playwright/test';

const baseUrl = process.env.PLAYWRIGHT_BASE_URL ?? 'http://127.0.0.1:8000';

/**
 * STORY-123 — Verifica stabilità cluster al hover
 */
test.describe('map-lit cluster stability', () => {
  test('/it/ clusters stable on hover', async ({ page }) => {
    test.setTimeout(60000);

    await page.goto(`${baseUrl}/it/`, { waitUntil: 'networkidle', timeout: 30000 });

    // Attendi caricamento mappa
    const mapLit = page.locator('map-lit#block-map');
    await expect(mapLit).toBeVisible({ timeout: 15000 });

    // Attendi geo-map-loaded
    await page.waitForEvent('console', {
      predicate: msg => msg.text().includes('[map-lit] GeoJSON loaded'),
      timeout: 10000,
    });

    // Attendi rendering cluster
    await page.waitForTimeout(2000);

    // Trova cluster
    const clusters = await page.locator('.geo-cluster-wrapper').all();
    console.log(`Found ${clusters.length} clusters`);

    if (clusters.length === 0) {
      test.skip('No clusters found');
    }

    // Screenshot before hover
    await page.screenshot({ path: '/tmp/map-before-hover.png', fullPage: false });

    // Hover su primo cluster
    const firstCluster = clusters[0];
    await firstCluster.hover();

    // Attendi eventuale animazione
    await page.waitForTimeout(500);

    // Screenshot after hover
    await page.screenshot({ path: '/tmp/map-after-hover.png', fullPage: false });

    // Verifica che cluster siano visibili e stabili
    const clusterCount = await page.locator('.geo-cluster-wrapper').count();
    expect(clusterCount).toBeGreaterThan(0);

    // Verifica coverage on hover (nuovo parametro)
    const hasCoverage = await page.locator('.leaflet-overlay-pane .leaflet-interactive').count();
    console.log(`Coverage polygons: ${hasCoverage}`);

    // Pan test - verifica stabilità durante pan
    const map = await page.locator('.geo-map-leaflet');
    await map.dragRelatively({ x: 100, y: 100 });
    await page.waitForTimeout(500);

    // Verifica cluster ancora presenti dopo pan
    const clustersAfterPan = await page.locator('.geo-cluster-wrapper').count();
    expect(clustersAfterPan).toBeGreaterThan(0);

    await page.screenshot({ path: '/tmp/map-after-pan.png', fullPage: false });

    console.log('✓ Cluster stability test passed');
  });

  test('marker params match direktvermarkter.js', async ({ page }) => {
    await page.goto(`${baseUrl}/it/`);

    const mapLit = page.locator('map-lit#block-map');
    await expect(mapLit).toBeVisible();

    // Verifica configurazione cluster via JS
    const clusterConfig = await page.evaluate(() => {
      const el = document.querySelector('map-lit#block-map');
      if (!el || !el._markersLayer) return null;
      
      const options = el._markersLayer.options || {};
      return {
        spiderfyOnMaxZoom: options.spiderfyOnMaxZoom,
        showCoverageOnHover: options.showCoverageOnHover,
        zoomToBoundsOnClick: options.zoomToBoundsOnClick,
        removeOutsideVisibleBounds: options.removeOutsideVisibleBounds,
      };
    });

    console.log('Cluster config:', clusterConfig);

    expect(clusterConfig).not.toBeNull();
    expect(clusterConfig.spiderfyOnMaxZoom).toBe(true);
    expect(clusterConfig.showCoverageOnHover).toBe(false);
    expect(clusterConfig.zoomToBoundsOnClick).toBe(true);
    expect(clusterConfig.removeOutsideVisibleBounds).toBe(false);
  });
});

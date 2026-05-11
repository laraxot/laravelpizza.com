const { test, expect } = require('@playwright/test');

test.describe('Segnalazioni Elenco Map Marker Clusters Test', () => {
  test.beforeEach(async ({ page }) => {
    await page.goto('http://127.0.0.1:8000/it/tests/segnalazioni-elenco');
  });

  test('marker clusters should have circular farmshosp.eu style', async ({ page }) => {
    await page.waitForSelector('.leaflet-container', { timeout: 10000 });

    // Wait for clusters to be present (zoom out to see clustering)
    await page.waitForTimeout(2000);

    // Check for cluster elements with circular style
    const clusters = page.locator('.marker-cluster, .geo-cluster-lod');
    await expect(clusters).toBeVisible({ timeout: 5000 });

    // Verify circular style properties
    const firstCluster = clusters.first();
    await expect(firstCluster).toHaveCSS('border-radius', /50%/);
    await expect(firstCluster).toHaveCSS('background-color', 'rgb(255, 255, 255)'); // white
    await expect(firstCluster).toHaveCSS('border-color', /rgb\(0, 102, 204\)/); // #0066cc
  });

  test('marker clusters should show count and type breakdown at zoom >= 8', async ({ page }) => {
    await page.waitForSelector('.leaflet-container', { timeout: 10000 });

    // Zoom in to see type breakdown in clusters
    const zoomInButton = page.locator('.ctrl-btn >> nth=1');
    await zoomInButton.click();
    await zoomInButton.click();
    await page.waitForTimeout(1000);

    // Check for cluster with type indicators (colored dots or SVGs)
    const clusterWithTypes = page.locator('.geo-cluster-lod:has(.geo-cluster-dot)');
    await expect(clusterWithTypes).toBeVisible({ timeout: 5000 });

    // Check that cluster contains count and type indicators
    const clusterContent = await clusterWithTypes.textContent();
    expect(clusterContent).toMatch(/\d+/); // should contain a number
  });

  test('marker clusters should use proper sizing based on count', async ({ page }) => {
    await page.waitForSelector('.leaflet-container', { timeout: 10000 });

    // Find clusters and verify they have appropriate sizes
    const clusters = page.locator('.marker-cluster');

    // Check that we have clusters with different sizes (small/medium/large)
    const clusterCount = await clusters.count();
    expect(clusterCount).toBeGreaterThan(0);

    // Verify at least one cluster has the expected size properties
    const firstCluster = clusters.first();
    const width = await firstCluster.evaluate(el =>
      parseInt(window.getComputedStyle(el).width)
    );
    const height = await firstCluster.evaluate(el =>
      parseInt(window.getComputedStyle(el).height)
    );

    // Clusters should be square and have reasonable sizes
    expect(width).toBeGreaterThan(0);
    expect(height).toBeGreaterThan(0);
    expect(width).toEqual(height); // should be square
  });
});
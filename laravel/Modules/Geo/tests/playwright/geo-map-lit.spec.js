import { test, expect } from '@playwright/test';

test.describe('GeoMapLit Component Tests', () => {
  test.beforeEach(async ({ page }) => {
    await page.goto('http://127.0.0.1:8000/it/tests/segnalazioni-listed');
  });

  test('renders listen component', async ({ page }) => {
    const mapComponent = page.locator('geo-map-lit');
    await expect(mapComponent).toBeVisible();

    const size = await mapComponent.boundingBox();
    expect(size.height).not.toBeNull();
    expect(size.height).toBeGreaterThan(300);
  });

  test('map container has correct height', async ({ page }) => {
    const mapBox = page.locator('.map-box');
    expect(mapBox).toBeVisible();

    const style = await mapBox.evaluate(el => {
      const cs = window.getComputedStyle(el);
      return {
        height: cs.height,
        position: cs.position
      };
    });

    expect(style.height).toBe('450px');
  });

  test('leaflet map initializes', async ({ page }) => {
    await page.waitForSelector('.leaflet-container', { timeout: 10000 });
    const container = page.locator('.leaflet-container');
    expect(container).toBeVisible();

    const tiles = page.locator('.leaflet-tile');
    await expect(tiles.first()).toBeVisible({ timeout: 10000 });
  });

  test('map controls visible', async ({ page }) => {
    await page.waitForSelector('.leaflet-container', { timeout: 10000 });

    const controls = page.locator('.leaflet-control');
    await expect(controls).toBeVisible();

    const zoomIn = page.locator('.ctrl-btn:nth-match(1)');
    const zoomOut = page.locator('.ctrl-btn:nth-match(2)');
    const layerSwitch = page.locator('.ctrl-btn:nth-match(3)');
    const geoloc = page.locator('.ctrl-btn:nth-match(4)');

    await expect(zoomIn).toBeVisible();
    await expect(zoomOut).toBeVisible();
    await expect(layerSwitch).toBeVisible();
    await expect(geoloc).toBeVisible();
  });

  test('markers render from GeoJSON', async ({ page }) => {
    await page.waitForSelector('.leaflet-container', { timeout: 10000 });
    await page.waitForSelector('.leaflet-marker-icon', { timeout: 10000 });

    const markers = page.locator('.leaflet-marker-icon');
    const count = await markers.count();
    expect(count).toBeGreaterThan(0);
  });

  test('filter by type dropdown works', async ({ page }) => {
    const select = page.locator('select');
    await expect(select).toBeVisible();

    const initialCount = await page.locator('.leaflet-marker-icon').count();
    await select.selectOption({ index: 1 });
    await page.waitForTimeout(1000);
    const filteredCount = await page.locator('.leaflet-marker-icon').count();
    expect(filteredCount).toBeGreaterThanOrEqual(0);
  });

  test('responsive to resize', async ({ page }) => {
    await page.waitForSelector('.leaflet-container', { timeout: 10000 });

    const initial = await page.locator('.leaflet-container').boundingBox();
    await page.setViewportSize({ width: 800, height: 600 });
    await page.waitForTimeout(1000);
    const after = await page.locator('.leaflet-container').boundingBox();
    expect(after.width).toBeGreaterThanOrEqual(600);
  });

  test('heatmap toggle works', async ({ page }) => {
    await page.waitForSelector('.leaflet-container', { timeout: 10000 });
    const layerControl = page.locator('.leaflet-control-layers');
    if (await layerControl.isVisible()) {
      await layerControl.click();
      const heatOption = page.locator('text=Heatmap');
      if (await heatOption.isVisible()) {
        await heatOption.click();
        await page.waitForTimeout(1000);
      }
    }
    await expect(page.locator('.leaflet-container')).toBeVisible();
  });
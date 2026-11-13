import { test, expect } from '@playwright/test';

const ELENCO_URL = 'http://127.0.0.1:8000/it/tests/ticket-list';

test.describe('STORY-062/065 — tab Mappa/Elenco (Bootstrap Italia)', () => {
  test.beforeEach(async ({ page }) => {
    const response = await page.goto(ELENCO_URL, {
      waitUntil: 'domcontentloaded',
      timeout: 30000,
    });

    test.skip(response === null || !response.ok(), 'Elenco non raggiungibile');
    await page.locator('#tabDisservizio').waitFor({ state: 'visible', timeout: 10000 });
  });

  test('nav-tabs Mappa/Elenco renderizzati', async ({ page }) => {
    await expect(page.locator('#tabDisservizio .nav-link')).toHaveCount(2);
  });

  test('tab Mappa attivo di default — pannello mappa visibile', async ({ page }) => {
    const mapPanel = page.locator('.tab-pane.show.active');
    await expect(mapPanel).toBeVisible();
    await expect(mapPanel.locator('map-lit#block-map')).toHaveCount(1);
  });

  test('click tab Elenco — pannello lista visibile', async ({ page }) => {
    await page.locator('#tabDisservizio .nav-link').nth(1).click();
    await page.waitForTimeout(400);

    const listPanel = page.locator('.tab-pane').nth(1);
    await expect(listPanel).toHaveClass(/show/);
  });

  test('switch mappa → elenco → mappa — nessun JS error', async ({ page }) => {
    const errors = [];
    page.on('pageerror', (err) => errors.push(err.message));

    const links = page.locator('#tabDisservizio .nav-link');
    await links.nth(1).click();
    await page.waitForTimeout(300);
    await links.nth(0).click();
    await page.waitForTimeout(300);

    expect(errors).toHaveLength(0);
  });
});

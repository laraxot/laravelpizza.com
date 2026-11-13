import { test, expect } from '@playwright/test';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const screenshotDir = path.resolve(
  __dirname,
  '../../../../docs/project/visual-comparison/ticket-list-it',
);

const viewports = [
  { name: 'mobile', width: 375, height: 812 },
  { name: 'tablet', width: 768, height: 1024 },
  { name: 'desktop', width: 1280, height: 900 },
];

const elencoPaths = ['/it/', '/en/', '/it/tests/ticket-list'];

test.describe('STORY-109 — elenco segnalazioni vs Design Comuni', () => {
  for (const elencoPath of elencoPaths) {
    const slug = elencoPath.replace(/\//g, '_').replace(/_$/, '');

    for (const viewport of viewports) {
      test(`${slug} screenshot ${viewport.name} @ ${viewport.width}px`, async ({ page }) => {
        await page.setViewportSize({ width: viewport.width, height: viewport.height });

        const response = await page.goto(`http://127.0.0.1:8000${elencoPath}`, {
          waitUntil: 'networkidle',
          timeout: 30000,
        });

        test.skip(response === null || !response.ok(), 'App non raggiungibile');

        await page.waitForSelector('#main-container[data-page="ticket-list"]', {
          timeout: 15000,
        });
        await page.locator('#main-container map-lit#block-map').waitFor({
          state: 'visible',
          timeout: 15000,
        });

        await page.screenshot({
          path: path.join(screenshotDir, `local-${slug}-${viewport.name}-${viewport.width}.png`),
          fullPage: true,
        });

        await expect(page.locator('body[data-page="ticket-list"]')).toBeVisible();

        const geo = await page.request.get('http://127.0.0.1:8000/data/tickets.json');
        test.skip(!geo.ok(), 'API GeoJSON non disponibile');
        const geojson = await geo.json();
        const mapTotal = Number(geojson.total ?? geojson.features?.length ?? 0);
        const typeValues = new Set(
          (geojson.features ?? []).map((f) => f.properties?.type?.value).filter(Boolean),
        );

        const filterInputs = page
          .locator('#main-container aside.col-lg-3')
          .locator('input[name="category"][data-filter-type]');
        await expect(filterInputs).toHaveCount(typeValues.size);

        const resultsCount = page.locator('#block-results-count').first();
        const resultsPattern = elencoPath.startsWith('/en')
          ? new RegExp(`${mapTotal}\\s+Results`, 'i')
          : new RegExp(`${mapTotal}\\s+Risultati`, 'i');
        await expect(resultsCount).toHaveText(resultsPattern, { timeout: 15000 });

        const checkbox = page.locator('input[name="category"][data-filter-type]').first();
        if (viewport.width >= 992) {
          await expect(checkbox).toBeVisible();
        } else {
          await expect(checkbox).toBeAttached();
        }
      });
    }
  }
});

import { test, expect } from '@playwright/test';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const screenshotDir = path.resolve(
  __dirname,
  '../../../../Themes/Sixteen/docs/design-comuni/visual-comparison/homepage-it-qa',
);

const viewports = [
  { name: 'mobile', width: 375, height: 812 },
  { name: 'tablet', width: 768, height: 1024 },
  { name: 'desktop', width: 1280, height: 800 },
];

const pages = [
  { locale: 'it', path: '/it', root: 'main[data-page="page-shell"], #main-container' },
  { locale: 'it-sandbox', path: '/it/tests/homepage', root: '#main-container, main' },
  { locale: 'en-sandbox', path: '/en/tests/homepage', root: '#main-container, main' },
];

test.describe('STORY-056 — homepage mobile/tablet QA', () => {
  for (const pageConfig of pages) {
    for (const viewport of viewports) {
      test(`${pageConfig.path} @ ${viewport.name}`, async ({ page }) => {
        await page.setViewportSize({ width: viewport.width, height: viewport.height });

        const response = await page.goto(`http://127.0.0.1:8000${pageConfig.path}`, {
          waitUntil: 'networkidle',
          timeout: 30000,
        });

        test.skip(response === null || response.status() === 404, 'Pagina non disponibile');

        expect(response.ok()).toBeTruthy();

        await page.locator(pageConfig.root).first().waitFor({ state: 'visible', timeout: 15000 });

        const hasOverflow = await page.evaluate(() => {
          const doc = document.documentElement;
          const body = document.body;

          return doc.scrollWidth > doc.clientWidth + 1 || body.scrollWidth > body.clientWidth + 1;
        });

        expect(hasOverflow, 'overflow-x su body/html').toBe(false);

        const cta = page.locator('a[href*="segnalazione-crea"]').first();
        if ((await cta.count()) > 0) {
          await expect(cta).toBeVisible();
          const box = await cta.boundingBox();
          if (box !== null && viewport.width < 992) {
            expect(box.height).toBeGreaterThanOrEqual(40);
          }
        }

        const slug = pageConfig.path.replace(/\//g, '-').replace(/^-/, '');
        await page.screenshot({
          path: path.join(screenshotDir, `${slug}-${viewport.name}-${viewport.width}.png`),
          fullPage: true,
        });
      });
    }
  }
});

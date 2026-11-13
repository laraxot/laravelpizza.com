import { test, expect } from '@playwright/test';

/**
 * STORY-053 — facet sidebar vs tickets.json (SSoT mappa).
 * URL canonica post STORY-092: /it/tests/ticket-list.
 */
test.describe('Segnalazioni elenco — filtri facet da tickets.json', () => {
  test.beforeEach(async ({ page }) => {
    const response = await page.goto('http://127.0.0.1:8000/it/tests/ticket-list', {
      waitUntil: 'domcontentloaded',
      timeout: 30000,
    });

    test.skip(response === null || !response.ok(), 'App non raggiungibile su :8000');

    await page.waitForSelector('[data-filter-type]', { timeout: 15000 });
  });

  test('somma conteggi checkbox = total feature nel JSON', async ({ page, request }) => {
    const jsonRes = await request.get('http://127.0.0.1:8000/data/tickets.json');
    test.skip(!jsonRes.ok(), 'tickets.json non disponibile');

    const geojson = await jsonRes.json();
    const totalFeatures = geojson.features?.length ?? 0;
    test.skip(totalFeatures === 0, 'Nessuna feature in tickets.json');

    const sidebarSum = await page.locator('aside.col-lg-3 [data-filter-type]').evaluateAll((inputs) =>
      inputs.reduce((sum, input) => {
        const count = parseInt(input.dataset.count ?? '0', 10);

        return sum + (Number.isNaN(count) ? 0 : count);
      }, 0),
    );

    expect(sidebarSum).toBe(totalFeatures);
  });

  test('results count allineato al totale senza filtri attivi', async ({ page, request }) => {
    const jsonRes = await request.get('http://127.0.0.1:8000/data/tickets.json');
    test.skip(!jsonRes.ok(), 'tickets.json non disponibile');

    const geojson = await jsonRes.json();
    const totalFeatures = geojson.features?.length ?? 0;
    test.skip(totalFeatures === 0, 'Nessuna feature in tickets.json');

    const resultsText = await page.locator('#block-results-count').innerText();
    expect(resultsText).toMatch(new RegExp(String(totalFeatures)));
  });
});

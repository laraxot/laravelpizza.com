---
title: Playwright — Visual Testing MapPicker
description: Guida definitiva al testing visivo per componenti mappa (Geo Module) nel 2026
tags: [playwright, puppeteer, visual-testing, map-picker, leaflet, laravel, pest]
---

# Playwright — Visual Testing MapPicker

Per verificare visualmente i componenti del modulo Geo (Leaflet + Lit Web Components), seguire gli standard di [Visual Control Mastery](../../../../../docs/wiki/concepts/visual-control-mastery.md).

## 1. Setup per Geo Module

### Playwright PHP & Pest v4
Il progetto utilizza **Pest v4** con il plugin browser (basato su Playwright).

```php
// laravel/Modules/Geo/tests/Browser/MapPickerTest.php
it('renders the map and matches baseline', function () {
    visit('/it/segnalazione/crea')
        ->waitFor('.leaflet-container')
        ->assertScreenshotsMatches();
});
```

### Playwright Node.js (Component Testing)
Per testare i Web Components in isolamento:

```javascript
// laravel/Modules/Geo/tests/Playwright/geo-map-lit.spec.js
import { test, expect } from '@playwright/test';

test('map renders with markers', async ({ page }) => {
  await page.goto('/it/segnalazione/crea');
  const map = page.locator('geo-map-lit');
  
  // Attendi caricamento dati e tiles
  await page.waitForLoadState('networkidle');
  
  // Screenshot con tolleranza per anti-aliasing
  await expect(map).toHaveScreenshot('geo-map-baseline.png', {
    maxDiffPixelRatio: 0.02,
    mask: [page.locator('.leaflet-control-attribution')]
  });
});
```

## 2. Scenari Critici da Verificare

- **Rendering Iniziale**: Verifica che la mappa carichi i tiles senza "buchi".
- **Marker Cluster**: Screenshot con diversi livelli di zoom per verificare l'aggregazione dei punti.
- **InvalidateSize**: Verifica rendering corretto dopo toggle fullscreen o cambio step wizard.
- **Z-Index**: Controlli mappa sopra gli altri elementi della pagina.
- **Custom Markers**: Verifica che gli SVG pin locali siano renderizzati correttamente (no 404/fallback).

## 3. Best Practices Mappe

1. **Deterministic Zoom**: Forza un livello di zoom fisso per gli screenshot di baseline.
2. **Disable Animations**: `animations: 'disabled'` per evitare screenshot durante lo zoom.
3. **Wait for Update**: Usare `await mapElement.evaluate(el => el.updateComplete)` per componenti Lit.

---
*Vedi anche:*
- [Visual Control Mastery](../../../../../docs/wiki/concepts/visual-control-mastery.md)
- [Coordinate Picker Rule](./coordinate-picker-lit-wizard-fullscreen-rule.md)

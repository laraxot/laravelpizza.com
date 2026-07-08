---
title: Visual Testing con Playwright e Puppeteer — Modulo Media
type: concept
sources:
  - https://playwright.dev/docs/test-snapshots
  - https://playwright-php.dev/
  - https://www.browserstack.com/guide/playwright-vs-puppeteer
confidence: high
created: 2026-05-04
updated: 2026-05-04
tags: [visual-testing, playwright, puppeteer, e2e, screenshot, laravel, Media]
related:
  - playwright-testing-policy
---

# Visual Testing con Playwright e Puppeteer — Modulo Media

## Panoramica

Il testing visivo (visual regression testing) permette di rilevare cambiamenti UI non intenzionali confrontando screenshot di riferimento con screenshot attuali.

Per la policy di collocazione dei test: vedi [Playwright Testing Policy](../../../../docs/wiki/concepts/playwright-testing-policy.md).

## Collocazione Test

I test Playwright del modulo Media appartengono a:

```
laravel/Modules/Media/tests/Playwright/
```

## Playwright vs Puppeteer

| Criterio | Playwright | Puppeteer |
|----------|-----------|-----------|
| **Browser** | Chromium, Firefox, WebKit | Chrome/Chromium |
| **Auto-wait** | Integrato | Manuale |
| **Laravel** | Pest v4 nativo | Node.js |
| **Uso consigliato** | Standard progetto | Task Chrome-only |

## Esempio Base

```javascript
// laravel/Modules/Media/tests/Playwright/visual-regression.spec.js
import { test, expect } from '@playwright/test';

test('Media UI renders correctly', async ({ page }) => {
    await page.goto('/it/...');
    await page.waitForLoadState('networkidle');
    await expect(page).toHaveScreenshot('Media-initial.png', {
        maxDiffPixelRatio: 0.02,
        animations: 'disabled'
    });
});
```

## Best Practices

1. **Atomici**: Screenshot di singoli componenti, non pagine intere
2. **Stabile**: Usa `maxDiffPixelRatio: 0.02` per tolleranza sub-pixel
3. **Mascherare dinamici**: Usa `mask` per timestamp, avatar, dati variabili
4. **Animazioni**: Disabilita con `animations: 'disabled'`
5. **CI/CD**: Esegui in ambiente Docker consistente

## Risorse

- [Playwright Docs](https://playwright.dev/)
- [Visual Control Mastery](../../../../docs/wiki/concepts/visual-control-mastery.md)
- [Playwright Testing Policy](../../../../docs/wiki/concepts/playwright-testing-policy.md)

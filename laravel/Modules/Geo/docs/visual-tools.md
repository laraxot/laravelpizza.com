# Visual Regression & Documentation Tool (Playwright)

## Overview
Questo progetto utilizza **Playwright** come strumento primario per la comprensione visiva, la generazione di screenshot per la documentazione e i test di regressione visiva dei componenti UI (Lit, Filament, Blade).

## Installazione & Requisiti
Lo strumento è configurato in `package.json`. Per assicurarsi che i browser necessari siano presenti:

```bash
npx playwright install --with-deps
```

## Utilizzo per la Documentazione
Gli screenshot per la documentazione tecnica dei moduli devono essere generati programmaticamente per garantire coerenza.

### Generazione Screenshot Esempio
Eseguire lo script di utility (se presente) o usare la CLI:

```bash
npx playwright screenshot --viewport-size=1280,720 http://localhost:8000/test-component docs/img/component-preview.png
```

## Governance Visiva
Ogni nuovo componente UI (es. `MapPositioner`) deve essere accompagnato da:
1. Uno script di fumo (smoke test) in Playwright.
2. Uno screenshot aggiornato nella cartella `docs/img` del modulo di appartenenza.

---
*Ultimo aggiornamento: Aprile 2026*

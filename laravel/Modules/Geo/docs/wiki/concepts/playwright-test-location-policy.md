---
type: concept
module: Geo
component: testing
created: 2026-04-30
updated: 2026-04-30
stories:
  - 8-78-segnalazioni-elenco-polish
  - 8-79-geo-map-controls-unification
---

# Playwright Test Location Policy

## Scopo

Definire la posizione corretta per i file di test Playwright all'interno di un progetto Laraxot/Filament multi-modulo.

## Regola Assoluta

```
OBBLIGATORIO: I test Playwright DEVONO risiedere all'interno del modulo o tema specifico
VIETATO: Posizionare test Playwright nella root /tests/Playwright/
```

## Posizioni Consentite

### 1. Test specifici di un modulo
```
laravel/Modules/<NomeModulo>/tests/Playwright/
laravel/Modules/<NomeModulo>/tests/Browser/
```

Esempio per modulo Geo:
```
laravel/Modules/Geo/tests/Playwright/segnalazioni-elenco.spec.js
laravel/Modules/Geo/tests/Playwright/geo-map-lit.spec.js
```

### 2. Test specifici di un tema
```
laravel/Themes/<NomeTema>/tests/Playwright/
laravel/Themes/<NomeTema>/tests/Browser/
```

Esempio per tema Sixteen:
```
laravel/Themes/Sixteen/tests/Playwright/header-navigation.spec.js
laravel/Themes/Sixteen/tests/Playwright/login-wizard.spec.js
```

### 3. Test globali (rari)
```
tests/Feature/Browser/  ← Solo per test E2E veramente cross-modulo
```

## Perché Questa Regola

### 1. Ownership Chiaro
Ogni modulo possiede i propri test. Il team del modulo Geo è responsabile dei test Geo.

### 2. Co-locazione con Codice
Test e implementazione vicini:
```
laravel/Modules/Geo/
├── resources/js/components/geo-map-lit.js      ← Implementazione
├── docs/wiki/entities/geo-map-lit.md            ← Documentazione
└── tests/Playwright/geo-map-lit.spec.js         ← Test
```

### 3. Dipendenze Isolate
I test di un modulo non dipendono da setup di altri moduli:
```javascript
// ❌ SBAGLIATO: test in root che richiede setup globale
// /tests/Playwright/segnalazioni-elenco.spec.js

test('map loads', async ({ page }) => {
    await page.goto('/it/tests/segnalazioni-elenco');
    // ...
});

// ✅ CORRETTO: test nel modulo Geo
// laravel/Modules/Geo/tests/Playwright/segnalazioni-elenco.spec.js

import { test, expect } from '@playwright/test';

test('map loads', async ({ page }) => {
    await page.goto('/it/tests/segnalazioni-elenco');
    await expect(page.locator('geo-map-lit')).toBeVisible();
});
```

### 4. CI/CD Modulare
GitHub Actions può eseguire solo i test del modulo modificato:
```yaml
# .github/workflows/test.yml
- name: Test changed modules
  run: |
    if git diff --name-only HEAD~1 | grep -q "Modules/Geo"; then
      cd laravel/Modules/Geo && npm test
    fi
```

### 5. Manutenibilità
Rinominare, spostare o eliminare un modulo? I test vanno con lui.

## Struttura Directory Consigliata

```
laravel/
├── Modules/
│   ├── Fixcity/
│   │   ├── app/
│   │   ├── tests/
│   │   │   ├── Feature/
│   │   │   │   └── GenerateTicketsJsonTest.php  ← Test PHPUnit
│   │   │   └── Playwright/
│   │   │       └── tickets-json-generation.spec.js  ← Test Playwright
│   │   └── docs/
│   ├── Geo/
│   │   ├── resources/js/components/
│   │   │   ├── geo-map-lit.js
│   │   │   └── map-picker-controls.js
│   │   ├── tests/
│   │   │   ├── Feature/
│   │   │   └── Playwright/
│   │   │       ├── segnalazioni-elenco.spec.js
│   │   │       └── geo-map-lit.spec.js
│   │   └── docs/
│   └── User/
│       ├── tests/
│       │   ├── Feature/
│       │   └── Playwright/
│       └── docs/
├── Themes/
│   └── Sixteen/
│       ├── resources/views/
│       ├── tests/
│       │   └── Playwright/
│       │       └── header-responsive.spec.js
│       ├── public/
│       └── docs/
└── tests/  ← SOLO test globali cross-modulo (rari)
    └── Feature/
```

## Esempio: Test del Modulo Geo

### Posizione Corretta
```
laravel/Modules/Geo/tests/Playwright/segnalazioni-elenco.spec.js
```

### Contenuto Esempio
```javascript
import { test, expect } from '@playwright/test';

test.describe('Segnalazioni Elenco - Map Component', () => {
    test('should display geo-map-lit component', async ({ page }) => {
        await page.goto('/it/tests/segnalazioni-elenco');
        
        const mapElement = page.locator('geo-map-lit');
        await expect(mapElement).toBeVisible();
        await expect(mapElement).toHaveAttribute('data-url', '/data/tickets.json');
    });

    test('should load markers from GeoJSON', async ({ page }) => {
        await page.goto('/it/tests/segnalazioni-elenco');
        
        // Aspetta che la mappa carichi
        await page.waitForSelector('.leaflet-marker-icon');
        
        const markers = page.locator('.leaflet-marker-icon');
        const count = await markers.count();
        
        expect(count).toBeGreaterThan(0);
    });

    test('should have zoom controls', async ({ page }) => {
        await page.goto('/it/tests/segnalazioni-elenco');
        
        const zoomInBtn = page.locator('.geo-map-btn-zoom-in');
        const zoomOutBtn = page.locator('.geo-map-btn-zoom-out');
        
        await expect(zoomInBtn).toBeVisible();
        await expect(zoomOutBtn).toBeVisible();
    });
});
```

## Esecuzione Test per Modulo

### Package.json nel modulo
```json
{
  "name": "geo",
  "scripts": {
    "test": "playwright test",
    "test:headed": "playwright test --headed"
  }
}
```

### Esecuzione
```bash
# Entra nel modulo
cd laravel/Modules/Geo

# Installa dipendenze (una volta)
npm install

# Esegui test
npm test

# Esegui test specifico
npx playwright test segnalazioni-elenco.spec.js
```

## Regole per Nuovi Test

1. **Crea la directory se non esiste**
   ```bash
   mkdir -p laravel/Modules/Geo/tests/Playwright
   ```

2. **Inizializza Playwright nel modulo**
   ```bash
   cd laravel/Modules/Geo
   npx playwright install
   npx playwright codegen  # per generare test
   ```

3. **Mantieni test co-locati**
   - Test per `geo-map-lit.js` → nello stesso modulo
   - Non spargere test in root

4. **Ciclo di vita**
   - Modulo eliminato? → Test eliminati
   - Componente rinominato? → Test aggiornato nel modulo
   - Fix applicato? → Test aggiornato nel modulo

## Migrazione da Root a Modulo

Se trovi test nella root:

```bash
# 1. Trova i test nella root
find tests/Playwright -name "*.spec.js" -o -name "*.spec.ts"

# 2. Determina il modulo di appartenenza
# Es: segnalazioni-elenco.spec.js → modulo Geo

# 3. Sposta nel modulo
mkdir -p laravel/Modules/Geo/tests/Playwright
mv tests/Playwright/segnalazioni-elenco.spec.js laravel/Modules/Geo/tests/Playwright/

# 4. Aggiorna import/require se necessario
# 5. Verifica che i test passino nel nuovo contesto
cd laravel/Modules/Geo && npm test
```

## Verifica di Conformità

### Script di verifica
```bash
# Controlla se ci sono test nella root (non permesso)
find tests/Playwright -type f \( -name "*.spec.js" -o -name "*.spec.ts" \) 2>/dev/null | grep -v node_modules
# Deve ritornare 0 risultati per i test E2E

# Controlla che ogni modulo abbia i suoi test
for module in laravel/Modules/*/; do
    if [ -d "$module/tests/Playwright" ]; then
        echo "✓ $(basename $module) ha test Playwright"
    else
        echo "⚠ $(basename $module) NON ha test Playwright"
    fi
done
```

## Link Correlati

- [Playwright Documentation](https://playwright.dev/)
- [Component Testing with Playwright](https://playwright.dev/docs/test-components)
- [Laravel Testing Documentation](https://laravel.com/docs/12.x/testing)
- [GitHub Actions for Playwright](https://playwright.dev/docs/ci-intro)

## Note Importanti

- **Feature Testing** (Laravel Pest/Dusk) → `tests/Feature/` nella root
- **Browser Testing** (Playwright) → `modules/*/tests/Playwright/`
- **Unit Testing** → `modules/*/tests/Unit/`
- **E2E Cross-Modulo** (raro) → `tests/Feature/Browser/`

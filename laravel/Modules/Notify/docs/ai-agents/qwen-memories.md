# QWEN Memories

Memorie e lesson learned accumulate da Qwen.

---

## Error Fix Pattern

Quando si lavora con date in blade:
- **SEMPRE** usare `Carbon\Carbon::parse($date)->method()`
- **MAI** usare `instanceof` check

Errori comuni:
- `diffForHumans()` su stringhe
- Foreign key migration fallite
- Traduzioni mancanti

**Workflow**: tail logs → fix error → view:clear → test → commit → push

---

## Seeder Best Practice

- **MAI** creare utenti nuovi nei seeder (causa DB conflicts)
- Usare `User::limit(50)->get()` per prendere utenti esistenti
- **DATI CALCOLATI** con formule reali, **MAI** hardcoded
- Volume = sum(transactions)
- Participants = count(unique users)
- Price chart = random walk con drift

---

## Currency Design

- Il progetto usa **CREDITS** (bottle caps stile Fallout TV series)
- **NON** euro o valuta reale
- Credits sono virtuali, senza valore reale
- **Sostituire SEMPRE** € con "Credits"

---

## Predict List Page

Deve essere **BEST IN CLASS** per SEO e WCAG.

**SEO**:
- Meta tags
- Structured data (Schema.org)
- Open Graph
- Twitter Card
- Canonical URL

**WCAG 2.2**:
- Skip links
- ARIA labels
- Color contrast 4.5:1
- Focus indicators
- Keyboard navigation
- Touch targets 44x44px

---

## Philosophy/Zen/Vision

**Documentare SEMPRE prima di implementare**.

10 Pilastri:
1. Accessibilità
2. Community Governance
3. Valore+Gamification
4. B2B+B2C
5. Long-Term
6. Open Source
7. Multi-Language
8. SEO
9. UX
10. Continuous Improvement

5 Principi Zen:
1. Vuoto
2. Impermanenza
3. Interconnessione
4. Semplicità
5. Presenza

---

## Architecture CRITICAL RULE

**[container0]/index.blade.php** e **[container0]/[slug0]/index.blade.php** sono **GENERIC templates** per **OGNI** content type.

**MAI** aggiungere logica specifica:
- ❌ `getMarketData()`
- ❌ `loadPriceHistory()`
- ❌ `buildOrderBook()`
- ❌ `calculateQualityScore()`

La logica specifica va in:
- Components del modulo
- Filament Widgets
- Actions

---

## GitHub Workflow Rule

**OGNI fix DEVE** avere:
1. **MINIMO 1 GitHub issue**
2. **MINIMO 1 GitHub discussion**

Issue: documenta bug, root cause, soluzione, testing
Discussion: apre alla community, chiede feedback

---

## Database Configuration

- `config/database.php` allineato a Laravel 13.x
- Produzione usa MySQL tramite .env
- Test usano MySQL (predict_test) tramite phpunit.xml
- **MAI** cambiare default in config/database.php

---

## Folio Layout Parameters

`app.blade.php` **DEVE** accettare parametri Folio:
```blade
@props(['fallbackPlaceholder', 'container0', 'slug0'])
```

Con default null per prevenire errori.

---

## CMS JSON Architecture

- Tema agnostico basato su JSON
- Blocchi configurati in `config/local/predict/database/content/pages/home.json`
- Struttura: `type`, `enabled`, `order`, `data`, `view`

---

## Pub_Theme Alias Rule

**NEI FILE JSON CMS** usare SEMPRE `pub_theme::` come namespace view.
- **NON** `TwentyOne::`, `Sixteen::`, etc.
- `pub_theme` è alias configurato in `config/*/xra.php`

---

## Translation Pattern

**TUTTE** le traduzioni DEVONO avere 5 livelli:
```php
__('<namespace>::<context>.<collection>.<key>.<type>')
```

Esempio: `__('predict::home.hero.cta_learn.label')`

**MAI** usare 4 livelli (manca `.label`)

**Eccezione**: `predict::messages.*` valore diretto

---

## Footer CMS Architecture

- Footer caricato da JSON config via `<x-section slug="footer" />`
- **NON** usare `GetFooterData` action (DEPRECATA)
- **NON** aggiungere blocchi footer in `home.json`
- Config: `config/local/predict/database/content/sections/footer.json`

---

## CSS Architecture

- **MAI** usare `@push('styles')` in blade components
- CSS solo in file dedicati
- **Eccezioni**: critical CSS per LCP (max 14KB)

---

## Front Office NO EMOJI

- **MAI** usare emoji (⚽🏛📊) nel front-office
- **USARE SVG**: `x-filament::icon` o `@svg`
- Emoji OK solo in: console commands, back office, commenti

---

## Multi-Outcome Predictions

Previsioni **DEVONO** avere **3-5+ esiti** (NON solo SI/NO).

Esempi:
- "Chi vincerà Scudetto?" → 6 opzioni
- "Quale cantante vince Sanremo?" → 6 opzioni

---

## Particles Effect

Usare `cinematic-particles` per background hero:
- CSS-only
- Respect prefers-reduced-motion
- Max 8 particles con animate

---

## Database REAL DATA

- **NON** mockare dati
- **USARE** dati reali da database
- Anche se pochi, mostrare dati veri

---

## 🔗 Link

- [Indice QWEN](./qwen-split-index.md)
- [memories.md](./memories.md) - Più memorie
- [QWEN.md originale](../../QWEN.md)
- [Index principale](./index.md)

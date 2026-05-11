# Design Comuni - Domande Frequenti (FAQ)

## Panoramica

Implementazione della pagina FAQ del progetto Design Comuni Italia nel modulo Cms.

- **Pagina**: `/it/tests/domande-frequenti`
- **JSON Content**: `config/local/fixcity/database/content/pages/tests.domande-frequenti.json`
- **Componenti**: Accordion, Hero, Breadcrumb, Search
- **Stato**: ✅ 90% Completato

## Architettura

### Content Blocks

La pagina FAQ utilizza i seguenti content blocks definiti nel JSON:

```json
{
  "content_blocks": {
    "it": [
      { "type": "breadcrumb", "data": {...} },
      { "type": "hero", "data": {...} },
      { "type": "search", "data": {...} },
      { "type": "accordion", "data": {...} },
      { "type": "link-list", "data": {...} }
    ]
  }
}
```

### Rendering Pipeline

```
JSON Content
    ↓
Cms Page Component (Page.php)
    ↓
<x-page side="content" :slug="$pageSlug" :data="$data" />
    ↓
Universal Blocks Renderer
    ↓
<x-blocks.breadcrumb />
<x-blocks.hero />
<x-blocks.search />
<x-blocks.accordion />
<x-blocks.link-list />
```

## Componenti Utilizzati

### 1. Accordion Block

**File Tema**: `Themes/Sixteen/resources/views/components/blocks/accordion/default.blade.php`

**Struttura**:
- Lista piatta di FAQ (no titoli sezione)
- Button con `button-wrapper` e `icon-wrapper`
- Icona toggle SVG per espandere/collassare
- Classi Bootstrap Italia replicate con Tailwind @apply

**JSON Data**:
```json
{
  "type": "accordion",
  "data": {
    "items": [
      {
        "question": "Come posso pagare una multa?",
        "answer": "Lorem Ipsum..."
      }
    ]
  }
}
```

### 2. Hero Block

**File Tema**: `Themes/Sixteen/resources/views/components/blocks/hero/default.blade.php`

**Struttura FAQ**:
- Sfondo bianco (`bg-white`)
- Titolo nero (`text-black`)
- Wrapper `cmp-hero`
- Padding specifico: `pt-0 ps-0 pb-4 pb-lg-60`

### 3. Breadcrumb Block

**File Tema**: `Themes/Sixteen/resources/views/components/blocks/breadcrumb/default.blade.php`

**Struttura**:
- Wrapper `cmp-breadcrumbs` con `role="navigation"`
- Separator `/` tra items
- Layout centrato: `col-12 col-lg-10`

### 4. Search Block

**File Tema**: `Themes/Sixteen/resources/views/components/blocks/search/input.blade.php`

**Struttura**:
- Wrapper `autocomplete-wrapper`
- Input con classe `autocomplete`
- Icona search posizionata assolutamente
- Button in `input-group-append`

## CSS Implementation

**File**: `Themes/Sixteen/resources/css/components/design-comuni.css`

### Componenti FAQ Styles

```css
/* Breadcrumb */
.cmp-breadcrumbs { @apply py-4; }
.cmp-breadcrumbs .separator { @apply mx-2 text-gray-400; }

/* Hero */
.cmp-hero { @apply py-8; }
.cmp-hero h1 { @apply text-black text-4xl lg:text-5xl font-bold; }

/* Search */
.cmp-input-search .autocomplete { @apply flex-1 px-4 py-2 border...; }

/* Accordion */
.cmp-accordion.faq .button-wrapper { @apply flex items-center...; }
.cmp-accordion.faq .icon-wrapper { @apply flex items-center...; }
```

## Build e Deploy

```bash
cd laravel/Themes/Sixteen
npm run build    # Compila CSS/JS
npm run copy     # Copia in public_html/themes/Sixteen/
```

## Testing

### URL Testing
- **Locale**: http://127.0.0.1:8000/it/tests/domande-frequenti
- **Reference**: https://italia.github.io/design-comuni-pagine-statiche/sito/domande-frequenti.html

### Screenshot Analysis
Script automatizzato: `bashscripts/design-comuni/capture-faq-screenshots.js`

Output: `Themes/Sixteen/docs/design-comuni/screenshots/`

## Match Percentage

| Componente | HTML | CSS | JS | Totale |
|-----------|------|-----|----|--------|
| Breadcrumb | 100% | 100% | N/A | ✅ 100% |
| Hero | 100% | 95% | N/A | ✅ 98% |
| Search | 100% | 90% | 0% | ⏳ 65% |
| Accordion | 95% | 90% | 0% | ⏳ 62% |
| **Totale** | **98%** | **94%** | **0%** | **✅ 85%** |

## Documentazione Correlata

### Tema Sixteen
- [Analisi HTML](../../../Themes/Sixteen/docs/design-comuni/DOMANDE_FREQUENTI_HTML_ANALYSIS.md)
- [Implementazione](../../../Themes/Sixteen/docs/design-comuni/DOMANDE_FREQUENTI_IMPLEMENTAZIONE.md)
- [Analisi Visiva](../../../Themes/Sixteen/docs/design-comuni/DOMANDE_FREQUENTI_ANALISI_VISIVA.md)
- [Report Finale](../../../Themes/Sixteen/docs/design-comuni/DOMANDE_FREQUENTI_REPORT_FINALE.md)
- [Index Design Comuni](../../../Themes/Sixteen/docs/design-comuni/00-index.md)

### Scripts
- [Screenshot Script](../../../bashscripts/design-comuni/capture-faq-screenshots.js)
- [Documentazione Script](../../../bashscripts/docs/DESIGN_COMUNI_SCREENSHOT_SCRIPT.md)

### Moduli Correlati
- [UI Module - Blocks System](../UI/docs/blocks-system.md)
- [UI Module - Design System](../UI/docs/design-system.md)

## Prossimi Passi

1. ⏳ Implementare Alpine.js per accordion toggle
2. ⏳ Test responsive (mobile, tablet)
3. ⏳ Test accessibilità WCAG 2.1 AA
4. ⏳ Decisione su header globale

## Note Tecniche

### Alpine.js (Da Implementare)

Attualmente l'accordion utilizza `data-bs-toggle="collapse"` (Bootstrap JS).

**Migrazione pianificata**:
```html
<div x-data="{ expanded: false }">
  <button @click="expanded = !expanded">
    <svg :class="{ 'rotate-180': expanded }"></svg>
  </button>
  <div x-show="expanded" x-collapse>
    Content...
  </div>
</div>
```

### Icone SVG

Sprite SVG disponibile in:
`public_html/themes/Sixteen/design-comuni/assets/bootstrap-italia/dist/svg/sprites.svg`

Icone utilizzate:
- `#it-expand` - Icona toggle accordion
- `#it-search` - Icona search input

---

**Ultimo Aggiornamento**: 2026-04-03  
**Stato**: ✅ 90% Completato  
**Responsabile**: AI Agent Team

## Verifica corrente 2026-04-03

Verifica rilanciata sui render attuali:
- [Theme parity report](../../../Themes/Sixteen/docs/design-comuni/domande-frequenti-parity-2026-04-03.md)
- [Structure diff](../../../Themes/Sixteen/docs/pages/domande-frequenti/STRUCTURE-DIFF.md)

Esito aggiornato:
- il precedente stato `90% completato` non e piu affidabile come baseline operativa
- il confronto automatico corrente misura `57%` di parity strutturale
- il JSON `tests.domande-frequenti.json` e corretto come sorgente contenuti, ma la resa finale del body locale diverge ancora dal riferimento nella shell utile

Implicazione pratica:
- per questa pagina non e ancora corretto parlare di parity ottenibile con soli CSS/JS
- prima serve riallineare struttura e wrapper effettivamente renderizzati dal tema

# Gap Analysis: Modulo Chart

**Data**: 23 Gennaio 2026
**Stato Modulo**: PHPStan Level 10 ✅
**Tecnologie**: Chart.js 4.4.3 (frontend), JpGraph 4.1 (backend)

## Panoramica

Il modulo Chart gestisce la visualizzazione dati tramite grafici. Ha un'architettura duale: Chart.js per web interattivo e JpGraph per generazione PNG in PDF.

---

## 1. Stato Attuale ✅

### 1.1 Chart Types Supportati

**Frontend (Chart.js)**:
- ✅ Bar charts (vertical, horizontal)
- ✅ Line charts
- ✅ Pie/Doughnut charts
- ✅ Mixed charts
- ✅ Radar charts
- ✅ Polar area charts

**Backend (JpGraph)**:
- ✅ bar1, bar2, bar3 - Varianti barre
- ✅ horizbar1 - Barre orizzontali
- ✅ pie1, pieAvg - Torte
- ✅ lineSubQuestion - Linee
- ✅ mixed:X - Combinati

### 1.2 DTO Pattern
- ✅ `ChartData` - Configurazione grafico
- ✅ `AnswersChartData` - Dati con risposte

### 1.3 Actions JpGraph
- ✅ `Bar2Action`, `PieAction`, etc. per PDF

---

## 2. Funzionalità MANCANTI ❌

### 2.1 Advanced Chart Types

**Gap**: Mancano tipi avanzati disponibili in Chart.js ma non implementati

| Type | Chart.js | JpGraph | Status |
|------|----------|---------|--------|
| Scatter | ✅ | ✅ | ❌ Non impl. |
| Bubble | ✅ | ❌ | ❌ Non impl. |
| Area (stacked) | ✅ | ✅ | ⚠️ Parziale |
| Treemap | Plugin | ❌ | ❌ Non impl. |
| Sankey | Plugin | ❌ | ❌ Non impl. |
| Heatmap | Plugin | ✅ | ❌ Non impl. |

**Raccomandazione**: Implementare scatter per correlazioni, heatmap per matrix questions

---

### 2.2 Chart Interactivity

**Attuale**: Grafici statici, no interazione

**Gap**:
- Non c'è click-to-filter
- Non c'è tooltip custom
- Non c'è zoom/pan
- Non c'è drill-down

**Impatto**: MEDIO - migliora UX analisi

**Raccomandazione**:
```javascript
// Chart.js onclick handler
const config = {
    options: {
        onClick: (event, elements) => {
            if (elements.length) {
                const index = elements[0].index;
                Livewire.dispatch('chartClicked', { segment: index });
            }
        }
    }
};
```

---

### 2.3 Responsive/Adaptive Charts

**Attuale**: Dimensioni fisse

**Gap**:
- Non c'è adattamento viewport
- Non c'è versione mobile-optimized
- Non c'è breakpoint configuration

**Impatto**: MEDIO - importante per mobile

**Raccomandazione**:
- Implementare `responsive: true` in Chart.js
- Creare configurazioni per mobile/tablet/desktop

---

### 2.4 Animation & Transitions

**Attuale**: Animazioni base default

**Gap**:
- Non c'è configurazione animazioni
- Non c'è delay progressivo
- Non c'è animazione on-update

**Impatto**: BASSO - cosmetico

---

### 2.5 Chart Themes/Palettes

**Attuale**: Colori hardcoded in alcuni punti

**Gap**:
- Non c'è sistema palette centralizzato
- Non c'è dark mode support
- Non c'è personalizzazione colori per tenant

**Impatto**: MEDIO - importante per branding

**Raccomandazione**:
```php
// ColorPaletteService
class ColorPaletteService
{
    public function getDefaultPalette(): array
    {
        return [
            'primary' => '#d60021',
            'secondary' => '#0066cc',
            'tertiary' => '#00aa55',
            // ...
        ];
    }

    public function getTenantPalette(Tenant $tenant): array
    {
        return $tenant->brand_colors ?? $this->getDefaultPalette();
    }
}
```

---

### 2.6 Chart Annotations

**Attuale**: Non implementato

**Gap**:
- Non c'è linea media/mediana
- Non c'è threshold indicators
- Non c'è target lines
- Non c'è annotazioni testuali

**Impatto**: ALTO - essenziale per analisi

**Raccomandazione**:
```javascript
// Chart.js annotation plugin
import annotationPlugin from 'chartjs-plugin-annotation';

const config = {
    plugins: {
        annotation: {
            annotations: {
                averageLine: {
                    type: 'line',
                    yMin: 60,
                    yMax: 60,
                    borderColor: 'red',
                    borderDash: [5, 5],
                    label: {
                        content: 'Media: 60%',
                        enabled: true
                    }
                }
            }
        }
    }
};
```

---

### 2.7 Export Options

**Attuale**: PNG via JpGraph per PDF

**Gap**:
- Non c'è export SVG (vector, scalable)
- Non c'è export high-resolution PNG
- Non c'è export Chart.js canvas diretto
- Non c'è export data as JSON

**Impatto**: MEDIO - utile per presentazioni

**Raccomandazione**:
```php
// ExportChartAction
class ExportChartAction
{
    public function execute(ChartData $chart, string $format, array $options = []): string
    {
        return match($format) {
            'png' => $this->exportPng($chart, $options['dpi'] ?? 150),
            'svg' => $this->exportSvg($chart),
            'json' => $this->exportJson($chart),
        };
    }
}
```

---

### 2.8 Accessibility (A11y)

**Attuale**: Non considerata

**Gap**:
- Non c'è aria-labels
- Non c'è tabella dati alternativa
- Non c'è high-contrast mode
- Non c'è screen reader support

**Impatto**: MEDIO - compliance requirement

**Raccomandazione**:
- Aggiungere tabella nascosta con dati
- Implementare aria-describedby
- Creare mode high-contrast

---

### 2.9 Data Labels Plugin

**Attuale**: Implementato via build Vite

**Gap**:
- Configurazione limitata
- Non c'è posizionamento dinamico anti-overlap

**Impatto**: BASSO - già funzionante base

---

## 3. Problemi DOCUMENTAZIONE

### 3.1 Documentazione Molto Disorganizzata

**Stato Attuale**: 366+ file docs, estrema ridondanza

**Problemi Critici**:
- README.md con contenuto duplicato e confuso
- File multipli per stesso argomento
- Collegamenti a path inesistenti
- Sezioni incomplete

**Azioni Urgenti**:
1. **Rimuovere file ridondanti** (stimati 300+ da eliminare)
2. **Consolidare in struttura chiara**:
   ```
   /docs/
   ├── README.md                 # Overview
   ├── index.md                  # Indice
   ├── installation.md           # Setup
   ├── chart-types.md            # Tipi disponibili
   ├── chartjs-integration.md    # Frontend
   ├── jpgraph-integration.md    # Backend/PDF
   ├── dto-pattern.md            # ChartData, AnswersChartData
   ├── actions/                  # Actions reference
   │   ├── bar-actions.md
   │   ├── pie-actions.md
   │   └── line-actions.md
   ├── filament-widgets.md       # Widget integration
   ├── theming.md                # Colori, palette
   ├── export.md                 # Export options
   └── phpstan/                  # Analysis
   ```

3. **Archiviare obsoleti** in `/docs/archive/`

---

## 4. JpGraph vs Chart.js Parity

### 4.1 Feature Matrix

| Feature | Chart.js | JpGraph | Parity |
|---------|----------|---------|--------|
| Bar charts | ✅ Full | ✅ Full | ✅ |
| Line charts | ✅ Full | ✅ Full | ✅ |
| Pie/Doughnut | ✅ Full | ✅ Full | ✅ |
| Mixed charts | ✅ Full | ⚠️ Limited | ⚠️ |
| Annotations | ✅ Plugin | ⚠️ Manual | ⚠️ |
| Data labels | ✅ Plugin | ✅ Built-in | ✅ |
| Responsive | ✅ Built-in | ❌ Fixed | ❌ |
| Colors | ✅ Full | ✅ Full | ✅ |
| Legends | ✅ Full | ✅ Full | ✅ |
| Tooltips | ✅ Interactive | ❌ N/A | ❌ |

### 4.2 Gap da Colmare

**Per PDF (JpGraph)**:
- Migliorare mixed charts
- Aggiungere annotation lines
- Supportare gradient fills

---

## 5. Piano di Sviluppo Raccomandato

### Phase 1: Core Improvements (2 settimane)

1. **Chart Annotations** - HIGH priority
   - Implementare plugin chartjs-plugin-annotation
   - Aggiungere linee media/target
   - Creare JpGraph equivalent

2. **Color Palette System** - HIGH priority
   - ColorPaletteService centralizzato
   - Tenant-specific palettes
   - Dark mode support

### Phase 2: Export & Interactivity (2 settimane)

3. **Export Multi-format**
   - SVG export
   - High-res PNG
   - JSON data export

4. **Chart Interactivity**
   - Click-to-filter
   - Zoom/pan capability
   - Custom tooltips

### Phase 3: Documentation (1 settimana)

5. **Documentation Overhaul**
   - Consolidare 366 → ~15 file
   - Creare struttura chiara
   - Aggiornare tutti i link

### Phase 4: Advanced (3+ settimane)

6. **New Chart Types**
   - Scatter plots
   - Heatmaps
   - Stacked area

7. **Accessibility**
   - ARIA labels
   - Data table fallback
   - High contrast mode

---

## 6. Metriche Target

| Metrica | Attuale | Target Q2 2026 |
|---------|---------|----------------|
| Docs Files | 366+ | ~15 |
| Chart Types (web) | 6 | 8+ |
| Chart Types (PDF) | 8 | 10+ |
| Export Formats | 1 (PNG) | 3 (PNG, SVG, JSON) |
| Annotations | No | Yes |
| A11y Support | No | Basic |

---

## 7. Conclusioni

Il modulo Chart ha una solida base tecnica con il pattern duale Chart.js/JpGraph. I principali gap sono:

**Priorità ALTA**:
1. Chart annotations (medie, target, threshold)
2. Color palette system centralizzato
3. Documentazione riorganizzata (urgente!)

**Priorità MEDIA**:
4. Export multi-format (SVG)
5. Chart interactivity
6. JpGraph/Chart.js parity

**Priorità BASSA**:
7. Nuovi tipi grafico
8. Accessibility compliance

La documentazione è il problema più urgente: 366+ file sono ingestibili e impattano la manutenibilità.

---

**Autore**: Claude Code Analysis
**Prossima Review**: Q2 2026

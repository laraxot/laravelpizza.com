# Roadmap Modulo Chart - 2026

**Data Aggiornamento**: 23 Gennaio 2026
**Stato**: PHPStan Level 10 ✅
**Tecnologie**: Chart.js 4.4.3 (frontend), JpGraph 4.1 (backend)

## Panoramica

Il modulo Chart gestisce la visualizzazione dati tramite grafici con architettura duale:
- **Chart.js**: Frontend interattivo (dashboard Filament)
- **JpGraph**: Backend PNG generation (embedding in PDF)

---

## Stato Attuale ✅

### Metriche Attuali

| Metrica | Valore |
|---------|--------|
| PHPStan Level | 10 ✅ |
| File PHP | 86 |
| Test | 7 (copertura ~20%) |
| Models | 6 |
| Actions | 22 |
| Filament Resources | 16 |

### Chart Types Supportati

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

### DTO Pattern Implementato
- ✅ `ChartData` - Configurazione grafico
- ✅ `AnswersChartData` - Dati con risposte

---

## Gap Analysis - Priorità

### 🔴 ALTA Priorità

#### 1. Chart Annotations Plugin
**Gap**: Mancano linee media/mediana, threshold, target lines
**Impatto**: ALTO - essenziale per analisi dati

**Implementazione Proposta**:
```javascript
// resources/js/chart-plugins.js
import annotationPlugin from 'chartjs-plugin-annotation';
Chart.register(annotationPlugin);

// Configurazione standard
const annotationConfig = {
    plugins: {
        annotation: {
            annotations: {
                averageLine: {
                    type: 'line',
                    yMin: avgValue,
                    yMax: avgValue,
                    borderColor: 'rgba(255, 99, 132, 0.8)',
                    borderDash: [5, 5],
                    borderWidth: 2,
                    label: {
                        content: `Media: ${avgValue}%`,
                        enabled: true,
                        position: 'end'
                    }
                }
            }
        }
    }
};
```

```php
// Modules/Chart/Datas/ChartAnnotationData.php
class ChartAnnotationData extends Data
{
    public string $type; // line, box, point, label
    public float $value;
    public string $color;
    public string $label;
    public bool $showLabel = true;
}
```

**Task**:
- [ ] Installare chartjs-plugin-annotation: `npm install chartjs-plugin-annotation`
- [ ] Registrare plugin in build Vite
- [ ] Creare ChartAnnotationData DTO
- [ ] Implementare annotazioni in JpGraph per PDF parity
- [ ] Aggiungere UI per configurazione annotazioni in Filament

#### 2. Color Palette System
**Gap**: Colori hardcoded, no dark mode, no tenant customization
**Impatto**: MEDIO-ALTO - importante per branding

**Implementazione Proposta**:
```php
// Modules/Chart/Services/ColorPaletteService.php
class ColorPaletteService
{
    private array $defaultPalette = [
        'primary' => '#d60021',
        'secondary' => '#0066cc',
        'tertiary' => '#00aa55',
        'quaternary' => '#ff9500',
        'quinary' => '#9b59b6',
        'senary' => '#1abc9c',
    ];

    public function getDefaultPalette(): array
    {
        return $this->defaultPalette;
    }

    public function getTenantPalette(?Tenant $tenant): array
    {
        if ($tenant && isset($tenant->brand_colors)) {
            return array_merge($this->defaultPalette, $tenant->brand_colors);
        }
        return $this->defaultPalette;
    }

    public function getDarkModePalette(): array
    {
        return array_map(fn($color) => $this->adjustForDarkMode($color), $this->defaultPalette);
    }

    public function getContrastingColors(int $count): array
    {
        // Generate visually distinct colors for charts
        return ColorGenerator::generateDistinct($count);
    }
}
```

**Task**:
- [ ] Creare ColorPaletteService
- [ ] Definire palette default professionale
- [ ] Implementare tenant-specific palettes
- [ ] Aggiungere dark mode support
- [ ] Integrare con ChartData DTO

---

### 🟡 MEDIA Priorità

#### 3. Chart Interactivity
**Gap**: Grafici statici, no click-to-filter, no zoom/pan
**Impatto**: MEDIO - migliora UX analisi

**Implementazione Proposta**:
```javascript
// resources/js/chart-interactivity.js
const interactiveConfig = {
    options: {
        onClick: (event, elements) => {
            if (elements.length) {
                const index = elements[0].index;
                const datasetIndex = elements[0].datasetIndex;

                // Dispatch Livewire event for filtering
                Livewire.dispatch('chartSegmentClicked', {
                    segment: index,
                    dataset: datasetIndex,
                    label: chart.data.labels[index],
                    value: chart.data.datasets[datasetIndex].data[index]
                });
            }
        },
        plugins: {
            zoom: {
                zoom: {
                    wheel: { enabled: true },
                    pinch: { enabled: true },
                    mode: 'xy',
                },
                pan: {
                    enabled: true,
                    mode: 'xy',
                },
            }
        }
    }
};
```

**Task**:
- [ ] Installare chartjs-plugin-zoom
- [ ] Implementare click handler con Livewire dispatch
- [ ] Creare zoom/pan per grafici grandi
- [ ] Aggiungere custom tooltip avanzati
- [ ] Implementare drill-down navigation

#### 4. Export Multi-format
**Gap**: Solo PNG via JpGraph, manca SVG e high-res
**Impatto**: MEDIO - utile per presentazioni

**Implementazione Proposta**:
```php
// Modules/Chart/Actions/Export/ExportChartAction.php
class ExportChartAction
{
    public function execute(ChartData $chart, string $format, array $options = []): string
    {
        return match($format) {
            'png' => $this->exportPng($chart, $options['dpi'] ?? 150),
            'png-hires' => $this->exportPng($chart, 300),
            'svg' => $this->exportSvg($chart),
            'json' => $this->exportJson($chart),
            default => throw new InvalidArgumentException("Unsupported format: {$format}"),
        };
    }

    private function exportSvg(ChartData $chart): string
    {
        // Use SVG.js or direct SVG generation
        $svgGenerator = new SvgChartGenerator($chart);
        return $svgGenerator->render();
    }
}
```

**Task**:
- [ ] Implementare export SVG (vector, scalable)
- [ ] Aggiungere export PNG high-resolution (300 DPI)
- [ ] Creare export JSON data
- [ ] Aggiungere export diretto da Chart.js canvas

#### 5. Responsive/Adaptive Charts
**Gap**: Dimensioni fisse, no mobile-optimized
**Impatto**: MEDIO - importante per mobile

**Task**:
- [ ] Implementare `responsive: true` per tutti i chart
- [ ] Creare configurazioni breakpoint (mobile/tablet/desktop)
- [ ] Ottimizzare label sizing per viewport piccoli
- [ ] Aggiungere aspect ratio configuration

#### 6. Advanced Chart Types
**Gap**: Tipi avanzati disponibili in Chart.js non implementati
**Impatto**: BASSO-MEDIO - nice-to-have

| Type | Chart.js | JpGraph | Priority |
|------|----------|---------|----------|
| Scatter | ✅ | ✅ | Medium |
| Bubble | ✅ | ❌ | Low |
| Area (stacked) | ✅ | ✅ | Medium |
| Heatmap | Plugin | ✅ | Medium |
| Treemap | Plugin | ❌ | Low |

**Task**:
- [ ] Implementare scatter plot per correlazioni
- [ ] Aggiungere heatmap per matrix questions
- [ ] Creare stacked area charts

---

### 🟢 BASSA Priorità

#### 7. Animation & Transitions
**Gap**: Solo animazioni base default
**Impatto**: BASSO - cosmetico

**Task**:
- [ ] Configurare animazioni personalizzate
- [ ] Aggiungere delay progressivo per serie multiple
- [ ] Implementare animazione on-update

#### 8. Accessibility (A11y)
**Gap**: No aria-labels, no screen reader support
**Impatto**: MEDIO - compliance requirement

**Task**:
- [ ] Aggiungere aria-labels a tutti i chart
- [ ] Creare tabella dati alternativa nascosta
- [ ] Implementare high-contrast mode
- [ ] Supportare keyboard navigation

#### 9. Data Labels Configuration
**Gap**: Configurazione limitata, no anti-overlap
**Impatto**: BASSO - già funzionante base

**Task**:
- [ ] Aggiungere posizionamento dinamico anti-overlap
- [ ] Creare formatter personalizzabile per labels
- [ ] Supportare multi-line labels

---

## JpGraph vs Chart.js Parity Matrix

| Feature | Chart.js | JpGraph | Gap Action |
|---------|----------|---------|------------|
| Bar charts | ✅ Full | ✅ Full | ✅ Parity |
| Line charts | ✅ Full | ✅ Full | ✅ Parity |
| Pie/Doughnut | ✅ Full | ✅ Full | ✅ Parity |
| Mixed charts | ✅ Full | ⚠️ Limited | Improve JpGraph |
| Annotations | ✅ Plugin | ⚠️ Manual | Implement JpGraph |
| Data labels | ✅ Plugin | ✅ Built-in | ✅ Parity |
| Responsive | ✅ Built-in | ❌ Fixed | N/A (PDF is fixed) |
| Colors | ✅ Full | ✅ Full | ✅ Parity |
| Legends | ✅ Full | ✅ Full | ✅ Parity |
| Tooltips | ✅ Interactive | ❌ N/A | N/A (static PNG) |

---

## Piano di Sviluppo

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

### Phase 3: Testing & Documentation (1 settimana)

5. **Test Coverage**
   - Unit tests per Models
   - Feature tests per Actions
   - Integration tests per Resources
   - Target: 80% coverage

6. **Documentation Cleanup**
   - Consolidare 906 → ~20 file
   - Creare struttura chiara
   - Archiviare obsoleti

### Phase 4: Advanced (3+ settimane)

7. **New Chart Types**
   - Scatter plots
   - Heatmaps
   - Stacked area

8. **Accessibility**
   - ARIA labels
   - Data table fallback
   - High contrast mode

---

## Metriche Target Q2 2026

| Metrica | Attuale | Target |
|---------|---------|--------|
| PHPStan Level | 10 ✅ | 10 |
| Test Coverage | ~20% | 80% |
| Docs Files | 906 | ~20 |
| Chart Types (web) | 6 | 8+ |
| Chart Types (PDF) | 8 | 10+ |
| Export Formats | 1 (PNG) | 3 (PNG, SVG, JSON) |
| Annotations | ❌ | ✅ |
| Color Palette System | ❌ | ✅ |
| A11y Support | ❌ | Basic |

---

## Documentazione Critica 📚

### Problema: 906 File Docs
La documentazione è **estremamente ridondante**. Molti file duplicati e contenuto confuso.

### Azione Urgente: Consolidamento
Target structure:
```
/docs/
├── README.md                 # Overview
├── chart-types.md            # Tipi disponibili
├── chartjs-integration.md    # Frontend
├── jpgraph-integration.md    # Backend/PDF
├── dto-pattern.md            # ChartData, AnswersChartData
├── color-palette.md          # Sistema colori
├── annotations.md            # Annotazioni
├── export.md                 # Export options
├── testing-guide.md          # Testing
├── performance-guide.md      # Performance
└── archive/                  # File obsoleti
```

---

## Dipendenze Inter-Modulo

### Dipendenze da Altri Moduli
- **Xot**: Framework base (XotBaseWidget, XotBaseResource)
- **Quaeris**: Business logic survey (ChartData consumer)

### Moduli che Dipendono da Chart
- **Quaeris**: Usa Chart per visualizzazione in dashboard e PDF

**REGOLA ASSOLUTA**: Chart fornisce visualizzazione dati, NON business logic!

---

## Riferimenti

- **Gap Analysis**: [gap-analysis-2026-01.md](./gap-analysis-2026-01.md)
- **Professional Charts Guide**: [filament-charts-professional-guide.md](./filament-charts-professional-guide.md)
- **Chart.js Docs**: https://www.chartjs.org/docs/latest/
- **JpGraph Manual**: https://jpgraph.net/doc/

---

**Autore**: Claude Code Analysis
**Prossima Review**: Q2 2026

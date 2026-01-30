# Guida Completa: Multiple Labels con chartjs-plugin-datalabels in Filament 5.x

**Versione:** 1.0  
**Data:** Gennaio 2026  
**Target:** Filament 5.x, Laravel 12.x  
**Livello:** Guida "a prova di stupido" - passo dopo passo

> **Riferimento Ufficiale:** [chartjs-plugin-datalabels - Multiple Labels Sample](https://chartjs-plugin-datalabels.netlify.app/samples/advanced/multiple-labels.html)

---

## 📋 Indice

1. [Cos'è Multiple Labels?](#cosè-multiple-labels)
2. [Prerequisiti](#prerequisiti)
3. [Installazione Passo-Passo](#installazione-passo-passo)
4. [Registrazione Plugin per Filament 5.x](#registrazione-plugin-per-filament-5x)
5. [Configurazione Multiple Labels](#configurazione-multiple-labels)
6. [Esempi Pratici Completi](#esempi-pratici-completi)
7. [Opzioni Disponibili](#opzioni-disponibili)
8. [Troubleshooting](#troubleshooting)
9. [Best Practices](#best-practices)

---

## Cos'è Multiple Labels?

**Multiple Labels** permette di visualizzare **più etichette diverse** sullo stesso elemento del grafico (barra, fetta, punto, ecc.).

### Esempio Pratico

In un grafico a barre puoi mostrare:
- **Label 1 (value)**: Il valore numerico sopra la barra
- **Label 2 (percent)**: La percentuale dentro la barra
- **Label 3 (index)**: L'indice numerico accanto alla barra

Ogni label può avere:
- Posizione diversa (top, bottom, center, start, end)
- Stile diverso (colore, font, sfondo)
- Formattazione personalizzata (valore, percentuale, testo custom)

---

## Prerequisiti

Prima di iniziare, assicurati di avere:

- ✅ **Filament 5.x** installato e funzionante
- ✅ **Laravel 12.x** (o 11.28+)
- ✅ **PHP 8.2+**
- ✅ **Node.js e NPM** installati
- ✅ **Vite** configurato nel progetto
- ✅ **Modulo Chart** con `XotBaseChartWidget` disponibile

---

## Installazione Passo-Passo

### Step 1: Installa il Plugin NPM

Apri il terminale e vai nella directory del modulo Chart:

```bash
cd /var/www/_bases/base_quaeris_fila5_mono/laravel/Modules/Chart
```

Installa il plugin:

```bash
npm install chartjs-plugin-datalabels --save-dev
```

**Verifica installazione:**

```bash
npm list chartjs-plugin-datalabels
```

Dovresti vedere qualcosa come:
```
chartjs-plugin-datalabels@2.2.0
```

### Step 2: Verifica File JavaScript

Il file per registrare i plugin dovrebbe essere:

```
Modules/Chart/resources/js/filament-chart-js-plugins.js
```

**Contenuto minimo richiesto:**

```javascript
import ChartDataLabels from 'chartjs-plugin-datalabels';

// ✅ CORRETTO: Usa nullish coalescing assignment
window.filamentChartJsPlugins ??= [];
window.filamentChartJsPlugins.push(ChartDataLabels);
```

**⚠️ IMPORTANTE:**
- NON usare `window.filamentChartJsPlugins = [...]` (sovrascrive array esistente)
- USA `window.filamentChartJsPlugins.push(...)` (aggiunge al array esistente)
- USA `??=` per inizializzare solo se non esiste

### Step 3: Verifica Vite Configuration

Apri il file:

```
Modules/Chart/vite.config.js
```

Verifica che il file JS sia nell'array `input`:

```javascript
laravel({
    input: [
        resolve(__dirname, 'resources/css/app.css'),
        resolve(__dirname, 'resources/js/app.js'),
        resolve(__dirname, 'resources/js/filament-chart-js-plugins.js') // ✅ Deve essere qui
    ],
    // ...
})
```

### Step 4: Build Assets

Compila gli asset con Vite:

```bash
npm run build
```

Oppure in modalità sviluppo:

```bash
npm run dev
```

**Verifica che il build sia riuscito:**
- Controlla che non ci siano errori nel terminale
- Verifica che il file compilato esista in `public_html/assets/chart/`

### Step 5: Verifica Registrazione Asset in Filament

Apri il Panel Provider del modulo Chart:

```
Modules/Chart/app/Providers/Filament/AdminPanelProvider.php
```

Verifica che l'asset sia registrato:

```php
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Assets\Js;
use Filament\Support\Assets\Css;
use Illuminate\Support\Facades\Vite;

public function panel(Panel $panel): Panel
{
    $panel = parent::panel($panel);
    
    // ✅ CORRETTO: Registrazione centralizzata nel modulo Chart
    FilamentAsset::register([
        Js::make('chart-js-plugins', Vite::asset('resources/js/filament-chart-js-plugins.js', 'assets/chart'))->module(),
        Css::make('chart-js-plugins', Vite::asset('resources/css/app.css', 'assets/chart')),
    ]);
    
    return $panel;
}
```

**⚠️ REGOLA CRITICA: Centralizzazione Asset Chart**

**Le configurazioni JS/CSS per Chart.js plugins DEVONO essere registrate SOLO nel modulo Chart.**

- ✅ **CORRETTO**: Registrare in `Modules/Chart/app/Providers/Filament/AdminPanelProvider.php`
- ❌ **ERRATO**: Registrare in altri moduli (Quaeris, UI, ecc.) o temi

**Motivazione:**
- DRY: Un'unica fonte di verità
- KISS: Configurazione semplice e centralizzata
- Coerenza: Tutti i moduli ereditano automaticamente gli asset

Per dettagli completi, vedere [chart-assets-centralization-rule.md](./chart-assets-centralization-rule.md).

---

## Registrazione Plugin per Filament 5.x

### Pattern Corretto (✅ USARE)

Filament 5.x usa **due array globali** per i plugin:

1. **`window.filamentChartJsPlugins`**: Plugin inline (per opzioni specifiche del chart)
2. **`window.filamentChartJsGlobalPlugins`**: Plugin globali (per `Chart.register()`)

**Per chartjs-plugin-datalabels, usa `window.filamentChartJsPlugins`:**

```javascript
// resources/js/filament-chart-js-plugins.js
import ChartDataLabels from 'chartjs-plugin-datalabels';

// ✅ CORRETTO
window.filamentChartJsPlugins ??= [];
window.filamentChartJsPlugins.push(ChartDataLabels);
```

### Pattern Errato (❌ NON USARE)

```javascript
// ❌ ERRATO: Sovrascrive array esistente
window.filamentChartJsPlugins = [ChartDataLabels];

// ❌ ERRATO: Usa Chart.register() direttamente
Chart.register(ChartDataLabels);

// ❌ ERRATO: Non inizializza se non esiste
window.filamentChartJsPlugins.push(ChartDataLabels);
```

---

## Configurazione Multiple Labels

### Struttura Base

Le multiple labels si configurano in **due modi**:

1. **Globalmente** in `options.plugins.datalabels.labels`
2. **Per dataset** in `dataset.datalabels.labels`

### Pattern 1: Configurazione Globale (Array PHP)

```php
protected function getOptions(): array
{
    $options = parent::getOptions();
    
    $options['plugins']['datalabels'] = [
        'labels' => [
            'value' => [
                'anchor' => 'end',
                'align' => 'top',
                'color' => '#1f2937',
                'font' => ['weight' => 'bold', 'size' => 12],
                'formatter' => 'function(v) { return v || ""; }',
            ],
            'percent' => [
                'anchor' => 'center',
                'align' => 'center',
                'color' => '#ffffff',
                'font' => ['weight' => '600', 'size' => 10],
                'formatter' => 'function(v, ctx) {
                    var d = ctx.dataset.data || [];
                    var t = d.reduce(function(s, x) { return s + (Number(x) || 0); }, 0);
                    if (!t || !v) return "";
                    var p = (v / t) * 100;
                    return p >= 3 ? Math.round(p) + "%" : "";
                }',
            ],
        ],
    ];
    
    return $options;
}
```

### Pattern 2: Configurazione con RawJs (JavaScript Puro)

```php
use Filament\Support\RawJs;

protected function getOptions(): RawJs
{
    return RawJs::make(<<<'JS'
{
  plugins: {
    datalabels: {
      labels: {
        value: {
          anchor: 'end',
          align: 'top',
          color: '#1f2937',
          font: { weight: 'bold', size: 12 },
          formatter: function(v) { return v || ''; }
        },
        percent: {
          anchor: 'center',
          align: 'center',
          color: '#ffffff',
          font: { weight: '600', size: 10 },
          formatter: function(v, ctx) {
            var d = ctx.dataset.data || [];
            var t = d.reduce(function(s, x) { return s + (Number(x) || 0); }, 0);
            if (!t || !v) return '';
            var p = (v / t) * 100;
            return p >= 3 ? Math.round(p) + '%' : '';
          }
        }
      }
    }
  }
}
JS);
}
```

### Pattern 3: Configurazione per Dataset

Puoi anche configurare le labels direttamente nel dataset:

```php
protected function getData(): array
{
    return [
        'labels' => ['Jan', 'Feb', 'Mar'],
        'datasets' => [
            [
                'data' => [10, 20, 30],
                'backgroundColor' => 'rgba(59, 130, 246, 0.8)',
                'datalabels' => [
                    'labels' => [
                        'value' => [
                            'anchor' => 'end',
                            'align' => 'top',
                        ],
                        'percent' => [
                            'anchor' => 'center',
                            'align' => 'center',
                        ],
                    ],
                ],
            ],
        ],
    ];
}
```

**⚠️ NOTA:** La configurazione nel dataset ha priorità su quella globale.

---

## Esempi Pratici Completi

### Esempio 1: Bar Chart con 2 Labels (Value + Percent)

**Caso d'uso:** Mostrare valore numerico sopra la barra e percentuale dentro.

```php
<?php

declare(strict_types=1);

namespace Modules\YourModule\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class BarChartDualLabelsWidget extends XotBaseChartWidget
{
    protected ?string $heading = 'Vendite Mensili - Valore e Percentuale';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        return [
            'labels' => ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu'],
            'datasets' => [
                [
                    'label' => 'Vendite',
                    'data' => [1200, 1900, 3000, 5000, 2000, 3000],
                    'backgroundColor' => 'rgba(59, 130, 246, 0.8)',
                    'borderColor' => 'rgb(37, 99, 235)',
                    'borderWidth' => 1,
                ],
            ],
        ];
    }

    protected function getOptions(): array
    {
        $options = parent::getOptions();

        $options['plugins']['datalabels'] = [
            'clip' => false,  // Permette label fuori dal chart area
            'clamp' => true,  // Limita label ai bordi del chart
            'labels' => [
                // Label 1: Valore sopra la barra
                'value' => [
                    'anchor' => 'end',      // Ancorato alla fine della barra
                    'align' => 'top',        // Allineato in alto
                    'offset' => 4,           // Offset di 4px dalla barra
                    'color' => '#1f2937',    // Colore testo grigio scuro
                    'font' => [
                        'weight' => 'bold',
                        'size' => 12,
                    ],
                    'formatter' => 'function(v) { return v || ""; }',
                    'display' => 'function(ctx) { return (ctx.dataset.data[ctx.dataIndex] || 0) > 0; }',
                ],
                // Label 2: Percentuale dentro la barra
                'percent' => [
                    'anchor' => 'center',    // Ancorato al centro
                    'align' => 'center',     // Allineato al centro
                    'color' => '#ffffff',    // Colore testo bianco
                    'font' => [
                        'weight' => '600',
                        'size' => 10,
                    ],
                    'formatter' => 'function(v, ctx) {
                        var d = ctx.dataset.data || [];
                        var t = d.reduce(function(s, x) { return s + (Number(x) || 0); }, 0);
                        if (!t || !v) return "";
                        var p = (v / t) * 100;
                        return p >= 3 ? Math.round(p) + "%" : "";
                    }',
                    'display' => 'function(ctx) {
                        var v = ctx.dataset.data[ctx.dataIndex] || 0;
                        var d = ctx.dataset.data || [];
                        var t = d.reduce(function(s, x) { return s + (Number(x) || 0); }, 0);
                        return t > 0 && (v / t) >= 0.03;
                    }',
                ],
            ],
        ];

        $options['scales']['y']['beginAtZero'] = true;

        return $options;
    }
}
```

**Risultato:**
- Valore numerico (es. "5000") sopra ogni barra
- Percentuale (es. "25%") dentro ogni barra (solo se >= 3%)

### Esempio 1.1: Bar Chart con Stack Verticale Compatto (UI/UX Ottimizzata)

**Caso d'uso:** Visualizzare media voti (0-10) e numero votanti in stack verticale compatto sopra la barra, con mese sotto, per migliorare la leggibilità e l'esperienza utente.

**Pattern DRY + KISS:** Usa `anchor: 'center'` con `align: 'top'` per entrambe le labels sopra (offset differenziati: 20px/8px) e `align: 'bottom'` per mese sotto, `backgroundColor`, `borderColor`, `borderRadius` e `padding` per creare stack verticale leggibile con gerarchia visiva a 3 livelli.

```php
protected function getOptions(): array
{
    $options = parent::getOptions();

    $options['plugins']['datalabels'] = [
        'clip' => false,
        'clamp' => true,
        'labels' => [
            // Label 1: Media voti CENTRATA sopra la barra - Stack verticale alto (offset maggiore)
            'average' => [
                'anchor' => 'center',                    // ✅ Perfect center anchor point
                'align' => 'top',                        // ✅ Positioned above the anchor
                'offset' => 20,                          // ✅ Offset maggiore per stack verticale alto
                'color' => '#1e293b',                    // ✅ Dark slate for high contrast
                'backgroundColor' => 'rgba(255, 255, 255, 0.95)', // ✅ Almost opaque white for clarity
                'borderColor' => 'rgba(148, 163, 184, 0.5)', // ✅ Subtle gray border
                'borderWidth' => 1,
                'borderRadius' => 6,                     // ✅ Rounded corners
                'padding' => 6,                          // ✅ Compact padding per stack verticale
                'font' => [
                    'weight' => '700',                   // ✅ Extra bold for prominence
                    'size' => 13,                        // ✅ Slightly smaller per stack compatto
                    'family' => 'system-ui, -apple-system, sans-serif', // ✅ Modern font stack
                ],
                'formatter' => 'function(v, ctx) {
                    var avg = Number(v) || 0;
                    return avg > 0 ? avg.toFixed(1) + "/10" : "";
                }',
                'display' => 'function(ctx) { return (ctx.dataset.data[ctx.dataIndex] || 0) > 0; }',
            ],
            // Label 2: Numero votanti CENTRATO sotto la media - Stack verticale basso (offset minore)
            'voters' => [
                'anchor' => 'center',                    // ✅ Perfect center anchor point (stesso della media)
                'align' => 'top',                        // ✅ Positioned above (stesso anchor della media)
                'offset' => 8,                           // ✅ Offset minore per stack verticale compatto
                'color' => '#64748b',                    // ✅ Muted slate gray for secondary info
                'backgroundColor' => 'rgba(241, 245, 249, 0.9)', // ✅ Light gray background (subtle)
                'borderColor' => 'rgba(203, 213, 225, 0.6)', // ✅ Light border
                'borderWidth' => 1,
                'borderRadius' => 5,                     // ✅ Slightly less rounded (secondary)
                'padding' => 5,                          // ✅ Compact padding per stack compatto
                'font' => [
                    'weight' => '600',                   // ✅ Semi-bold (less than primary)
                    'size' => 11,                        // ✅ Smaller size for secondary info
                    'family' => 'system-ui, -apple-system, sans-serif', // ✅ Consistent font
                ],
                'formatter' => 'function(v, ctx) {
                    var voteCounts = ctx.dataset.voteCounts || [];
                    var voters = voteCounts[ctx.dataIndex] || 0;
                    return voters > 0 ? voters + " voti" : "";
                }',
                'display' => 'function(ctx) {
                    var voteCounts = ctx.dataset.voteCounts || [];
                    var voters = voteCounts[ctx.dataIndex] || 0;
                    return voters > 0;
                }',
            ],
            // Label 3: Mese CENTRATO sotto la barra
            'month' => [
                'anchor' => 'center',                    // ✅ Perfect center anchor point
                'align' => 'bottom',                     // ✅ Positioned below the anchor
                'offset' => 8,                           // ✅ Generous spacing from bar bottom
                'color' => '#94a3b8',                    // ✅ Lighter gray for tertiary info
                'backgroundColor' => 'rgba(248, 250, 252, 0.85)', // ✅ Very light gray background
                'borderColor' => 'rgba(226, 232, 240, 0.5)', // ✅ Very light border
                'borderWidth' => 1,
                'borderRadius' => 4,                     // ✅ Less rounded (tertiary)
                'padding' => 5,                          // ✅ Compact padding
                'font' => [
                    'weight' => '500',                   // ✅ Medium weight (tertiary)
                    'size' => 10,                        // ✅ Smaller size for tertiary info
                    'family' => 'system-ui, -apple-system, sans-serif', // ✅ Consistent font
                ],
                'formatter' => 'function(v, ctx) {
                    var labels = ctx.chart.data.labels || [];
                    return labels[ctx.dataIndex] || "";
                }',
                'display' => 'function(ctx) {
                    return (ctx.dataset.data[ctx.dataIndex] || 0) > 0;
                }',
            ],
        ],
    ];

    return $options;
}
```

**Opzioni Sfondo Disponibili:**

| Opzione | Tipo | Descrizione | Esempio (Valori Ottimizzati) |
|---------|------|-------------|-------------------------------|
| `backgroundColor` | `string` o `function(ctx)` | Colore di sfondo della label. **Migliora UI/UX** aggiungendo contrasto. | Label sopra: `'rgba(255, 255, 255, 0.9)'` (90% opacità)<br>Label dentro: `'rgba(0, 0, 0, 0.6)'` (60% opacità) |
| `borderColor` | `string` | Colore del bordo semi-trasparente per definizione. | Label sopra: `'rgba(209, 213, 219, 0.8)'` (80% opacità)<br>Label dentro: `'rgba(255, 255, 255, 0.4)'` (40% opacità) |
| `borderWidth` | `number` | Larghezza del bordo in pixel. Tipicamente `1` per bordi sottili e moderni. | `1` |
| `borderRadius` | `number` | Raggio degli angoli in pixel. Valori ottimizzati per appeal visivo. | Label sopra: `6px`<br>Label dentro: `8px` |
| `padding` | `number` o `object` | Padding interno. Valori ottimizzati per respirabilità. | Label sopra: `6px`<br>Label dentro: `5px`<br>Oggetto: `{top: 4, right: 6, bottom: 4, left: 6}` |
| `offset` | `number` | Offset dalla posizione di ancoraggio. Valore ottimizzato per spaziatura. | `6px` (aumentato da 4px per migliore spaziatura) |

**Best Practices UI/UX (Posizionamento Centrato Ottimizzato):**
- ✅ **Label sopra barra (CENTRATA)**: 
  - **Posizionamento**: `anchor: 'center', align: 'top'` per allineamento perfetto
  - Sfondo bianco quasi opaco: `rgba(255, 255, 255, 0.95)` (95% opacità) per massima chiarezza
  - Bordo grigio sottile: `rgba(148, 163, 184, 0.5)` (50% opacità) per definizione discreta
  - Angoli arrotondati: `borderRadius: 8px` per aspetto moderno
  - Padding generoso: `padding: 8px` per respirabilità ottimale
  - Offset generoso: `offset: 8px` per spaziatura dalla barra
  - Font size maggiore: `14px` con weight `700` (extra bold) per gerarchia visiva primaria
- ✅ **Label sotto barra (CENTRATA)**: 
  - **Posizionamento**: `anchor: 'center', align: 'bottom'` per allineamento perfetto
  - Sfondo grigio chiaro semi-trasparente: `rgba(241, 245, 249, 0.9)` (90% opacità) per informazioni secondarie
  - Bordo grigio chiaro: `rgba(203, 213, 225, 0.6)` (60% opacità) per definizione sottile
  - Angoli arrotondati: `borderRadius: 6px` (meno prominente della primaria)
  - Padding confortevole: `padding: 6px`
  - Offset generoso: `offset: 8px` per spaziatura dalla barra
  - Font size minore: `11px` con weight `600` (semi-bold) per gerarchia visiva secondaria
- ✅ **Bordi sottili**: `borderWidth: 1px` per definizione senza pesantezza
- ✅ **Colori contrastanti**: Testo slate scuro (`#1e293b`) su sfondo bianco, testo slate grigio (`#64748b`) su sfondo grigio chiaro
- ✅ **Layout padding**: `top: 20px, bottom: 20px` per accogliere labels senza clipping
- ✅ **Font stack moderno**: `system-ui, -apple-system, sans-serif` per consistenza cross-platform

**Esempio Reale nel Progetto:**
- `Modules/Quaeris/app/Filament/Widgets/SimpleChartWidget.php` - ⭐ **IMPLEMENTAZIONE COMPLETA** con stack verticale compatto sopra (media voti + numero votanti) e mese sotto
  - [Documentazione Completa](../../Quaeris/docs/simplechartwidget-labels-backgrounds.md)
  - Pattern: `anchor: 'center'` + `align: 'top'` (sopra) / `align: 'bottom'` (sotto)
  - Gerarchia visiva: Font size 14px/11px, weight 700/600, colori slate professionali
  - Layout padding: `top: 20px, bottom: 20px` per accogliere labels senza clipping

### Esempio 2: Doughnut Chart con 3 Labels (Index + Name + Value)

**Caso d'uso:** Mostrare indice, nome categoria e valore in un grafico a ciambella.

```php
<?php

declare(strict_types=1);

namespace Modules\YourModule\Filament\Widgets;

use Filament\Support\RawJs;
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class DoughnutChartTripleLabelsWidget extends XotBaseChartWidget
{
    protected ?string $heading = 'Distribuzione Categorie - Triple Labels';

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        return [
            'labels' => ['Terra', 'Marte', 'Saturno', 'Giove'],
            'datasets' => [
                [
                    'data' => [12, 55, 9, 33],
                    'backgroundColor' => [
                        '#1d4ed8',  // Blu
                        '#10b981',  // Verde
                        '#f59e0b',  // Arancione
                        '#ef4444',  // Rosso
                    ],
                    'hoverBorderColor' => 'white',
                ],
            ],
        ];
    }

    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<'JS'
{
  plugins: {
    datalabels: {
      color: 'white',
      display: function(ctx) {
        return ctx.dataset.data[ctx.dataIndex] > 10;
      },
      font: {
        weight: 'bold'
      },
      offset: 0,
      padding: 0,
      labels: {
        // Label 1: Indice numerico
        index: {
          align: 'end',
          anchor: 'end',
          color: function(ctx) {
            return ctx.dataset.backgroundColor[ctx.dataIndex];
          },
          font: { size: 18 },
          formatter: function(value, ctx) {
            return ctx.active
              ? 'index'
              : '#' + (ctx.dataIndex + 1);
          },
          offset: 8,
          opacity: function(ctx) {
            return ctx.active ? 1 : 0.5;
          }
        },
        // Label 2: Nome categoria
        name: {
          align: 'top',
          font: { size: 16 },
          formatter: function(value, ctx) {
            return ctx.active
              ? 'name'
              : ctx.chart.data.labels[ctx.dataIndex];
          }
        },
        // Label 3: Valore con sfondo condizionale
        value: {
          align: 'bottom',
          backgroundColor: function(ctx) {
            var value = ctx.dataset.data[ctx.dataIndex];
            return value > 50 ? 'white' : null;
          },
          borderColor: 'white',
          borderWidth: 2,
          borderRadius: 4,
          color: function(ctx) {
            var value = ctx.dataset.data[ctx.dataIndex];
            return value > 50
              ? ctx.dataset.backgroundColor[ctx.dataIndex]
              : 'white';
          },
          formatter: function(value, ctx) {
            return ctx.active
              ? 'value'
              : Math.round(value * 1000) / 1000;
          },
          padding: 4
        }
      }
    }
  },
  aspectRatio: 3 / 2,
  layout: {
    padding: 16
  }
}
JS);
    }
}
```

**Risultato:**
- Indice numerico (es. "#1") all'esterno della fetta
- Nome categoria (es. "Terra") in alto
- Valore (es. "12") in basso con sfondo bianco se valore > 50

### Esempio 3: Line Chart con Value + Trend

**Caso d'uso:** Mostrare valore e indicatore di trend (↑/↓) in un grafico a linee.

```php
protected function getOptions(): array
{
    $options = parent::getOptions();

    $options['plugins']['datalabels'] = [
        'labels' => [
            'value' => [
                'anchor' => 'end',
                'align' => 'top',
                'offset' => 8,
                'color' => '#1f2937',
                'font' => ['weight' => 'bold', 'size' => 11],
                'formatter' => 'function(v) { return v || ""; }',
            ],
            'trend' => [
                'anchor' => 'start',
                'align' => 'bottom',
                'offset' => 8,
                'color' => function(ctx) {
                    var current = ctx.dataset.data[ctx.dataIndex];
                    var previous = ctx.dataset.data[ctx.dataIndex - 1];
                    if (!previous) return '#6b7280';
                    return current > previous ? '#10b981' : '#ef4444';
                },
                'font' => ['size' => 14],
                'formatter' => 'function(v, ctx) {
                    var current = ctx.dataset.data[ctx.dataIndex];
                    var previous = ctx.dataset.data[ctx.dataIndex - 1];
                    if (!previous) return "";
                    return current > previous ? "↑" : "↓";
                }',
                'display' => 'function(ctx) { return ctx.dataIndex > 0; }',
            ],
        ],
    ];

    return $options;
}
```

---

## Opzioni Disponibili

### Opzioni di Posizionamento

| Opzione | Valori | Descrizione |
|---------|--------|-------------|
| `anchor` | `'center'`, `'start'`, `'end'` | Punto di ancoraggio della label |
| `align` | `'center'`, `'start'`, `'end'`, `'top'`, `'bottom'`, `'left'`, `'right'` | Allineamento della label |
| `offset` | `number` | Distanza in pixel dal punto di ancoraggio |

**Combinazioni comuni:**

| anchor | align | Risultato |
|--------|-------|-----------|
| `center` | `top` | **Sopra, PERFETTAMENTE CENTRATO** ⭐ Pattern ottimale per UI/UX |
| `center` | `bottom` | **Sotto, PERFETTAMENTE CENTRATO** ⭐ Pattern ottimale per UI/UX |
| `center` | `center` | Centrato dentro l'elemento |
| `end` | `top` | Sopra, allineato a destra |
| `end` | `bottom` | Sotto, allineato a destra |
| `start` | `top` | Sopra, allineato a sinistra |

### Opzioni di Stile

| Opzione | Tipo | Descrizione |
|---------|------|-------------|
| `color` | `string` o `function(ctx)` | Colore del testo |
| `font` | `object` | `{ weight: 'bold', size: 12, family: 'Arial' }` |
| `backgroundColor` | `string` o `function(ctx)` | Colore di sfondo. **Valori ottimizzati centrati**: `'rgba(255, 255, 255, 0.95)'` per label sopra (primaria), `'rgba(241, 245, 249, 0.9)'` per label sotto (secondaria) |
| `borderColor` | `string` | Colore del bordo semi-trasparente. **Valori ottimizzati**: `'rgba(148, 163, 184, 0.5)'` per label sopra, `'rgba(203, 213, 225, 0.6)'` per label sotto |
| `borderWidth` | `number` | Spessore del bordo. Tipicamente `1px` per bordi sottili |
| `borderRadius` | `number` | Raggio degli angoli. **Valori ottimizzati centrati**: `8px` per label sopra (primaria), `6px` per label sotto (secondaria) |
| `padding` | `number` o `object` | Padding interno. **Valori ottimizzati centrati**: `8px` per label sopra (primaria), `6px` per label sotto (secondaria) |
| `opacity` | `number` o `function(ctx)` | Opacità (0-1). Utile per effetti hover o condizioni dinamiche |
| `offset` | `number` | Offset dalla posizione di ancoraggio. **Valore ottimizzato centrato**: `8px` per migliore spaziatura |
| `font.size` | `number` | Dimensione font. **Gerarchia visiva**: `14px` per primaria, `11px` per secondaria |
| `font.weight` | `string` | Peso font. **Gerarchia visiva**: `'700'` (extra bold) per primaria, `'600'` (semi-bold) per secondaria |
| `font.family` | `string` | Font stack. **Consistenza**: `'system-ui, -apple-system, sans-serif'` per cross-platform |

### Opzioni di Formattazione

| Opzione | Tipo | Descrizione |
|---------|------|-------------|
| `formatter` | `function(value, ctx)` | Funzione per formattare il valore |
| `display` | `boolean` o `function(ctx)` | Mostra/nascondi la label |

**Parametri `ctx` (context):**

```javascript
{
  active: boolean,           // Se l'elemento è hover
  chart: Chart,              // Istanza del chart
  dataIndex: number,         // Indice del dato
  dataset: object,           // Dataset corrente
  datasetIndex: number,      // Indice del dataset
}
```

### Esempi di Formatter

**Valore semplice:**
```javascript
formatter: 'function(v) { return v || ""; }'
```

**Percentuale:**
```javascript
formatter: 'function(v, ctx) {
    var d = ctx.dataset.data || [];
    var t = d.reduce(function(s, x) { return s + (Number(x) || 0); }, 0);
    if (!t || !v) return "";
    return Math.round((v / t) * 100) + "%";
}'
```

**Valuta:**
```javascript
formatter: 'function(v) { return "€" + v.toLocaleString("it-IT"); }'
```

**Con condizione:**
```javascript
formatter: 'function(v, ctx) {
    return v > 1000 ? (v / 1000).toFixed(1) + "k" : v;
}'
```

---

## Troubleshooting

### Problema 1: Le Labels Non Appaiono

**Sintomi:** Il grafico si visualizza ma le labels non compaiono.

**Soluzioni:**

1. **Verifica installazione plugin:**
   ```bash
   npm list chartjs-plugin-datalabels
   ```

2. **Verifica registrazione in JavaScript:**
   ```javascript
   // Apri console browser (F12)
   console.log(window.filamentChartJsPlugins);
   // Dovrebbe contenere ChartDataLabels
   ```

3. **Verifica build Vite:**
   ```bash
   npm run build
   # Controlla che non ci siano errori
   ```

4. **Verifica asset registrato in Filament:**
   ```php
   // In PanelProvider
   FilamentAsset::register([
       Js::make('chart-js-plugins', Vite::asset('resources/js/filament-chart-js-plugins.js', 'assets/chart'))->module(),
   ]);
   ```

5. **Verifica configurazione `display`:**
   ```php
   'display' => 'function(ctx) { return true; }'  // Forza sempre visibile per test
   ```

### Problema 2: Callback Non Funzionano

**Sintomi:** Le labels appaiono ma i formatter/display non funzionano.

**Soluzioni:**

1. **Usa `RawJs` per callback complessi:**
   ```php
   use Filament\Support\RawJs;
   
   protected function getOptions(): RawJs
   {
       return RawJs::make(<<<'JS'
   {
     plugins: {
       datalabels: {
         formatter: function(v) { return v; }  // ✅ Funziona
       }
     }
   }
   JS);
   }
   ```

2. **Per array PHP, usa stringhe di funzioni:**
   ```php
   'formatter' => 'function(v) { return v || ""; }'  // ✅ Stringa
   // NON: 'formatter' => function($v) { ... }  // ❌ Closure PHP
   ```

### Problema 3: Labels Si Sovrappongono

**Sintomi:** Le labels si sovrappongono o escono dal chart.

**Soluzioni:**

1. **Usa `anchor` e `align` diversi per ogni label:**
   ```php
   'value' => ['anchor' => 'end', 'align' => 'top'],
   'percent' => ['anchor' => 'center', 'align' => 'center'],
   ```

2. **Aumenta `offset`:**
   ```php
   'value' => ['offset' => 10],  // Aumenta distanza
   ```

3. **Usa `clip: false` per permettere label fuori area:**
   ```php
   'clip' => false,
   ```

4. **Aumenta `layout.padding`:**
   ```php
   'layout' => ['padding' => 20],
   ```

### Problema 4: Labels Non Si Aggiornano con Polling

**Sintomi:** Le labels rimangono statiche quando i dati cambiano.

**Soluzioni:**

1. **Verifica che `getOptions()` venga chiamato ad ogni update:**
   ```php
   // Le opzioni vengono ricaricate automaticamente con polling
   // Se non funziona, verifica che il widget non sia cached
   ```

2. **Usa `formatter` dinamico:**
   ```php
   'formatter' => 'function(v, ctx) {
       // Usa ctx.dataset.data per dati aggiornati
       return ctx.dataset.data[ctx.dataIndex];
   }'
   ```

### Problema 5: Errori JavaScript in Console

**Sintomi:** Errori in console del browser.

**Soluzioni:**

1. **Verifica sintassi JavaScript:**
   ```javascript
   // ✅ CORRETTO
   formatter: 'function(v) { return v; }'
   
   // ❌ ERRATO (virgola mancante, parentesi, ecc.)
   formatter: 'function(v) return v'
   ```

2. **Verifica che le funzioni siano valide:**
   ```javascript
   // Testa in console browser:
   var test = function(v) { return v; };
   console.log(test(10));  // Dovrebbe loggare 10
   ```

3. **Verifica accesso a `ctx`:**
   ```javascript
   // ✅ CORRETTO
   formatter: 'function(v, ctx) { return ctx.dataset.data[ctx.dataIndex]; }'
   
   // ❌ ERRATO (ctx non definito)
   formatter: 'function(v) { return ctx.dataset.data[ctx.dataIndex]; }'
   ```

---

## Best Practices

### 1. Usa Nomi Descrittivi per le Labels

```php
// ✅ CORRETTO
'labels' => [
    'value' => [...],      // Valore numerico
    'percent' => [...],    // Percentuale
    'trend' => [...],      // Indicatore trend
]

// ❌ ERRATO
'labels' => [
    'label1' => [...],     // Non descrittivo
    'label2' => [...],     // Non descrittivo
]
```

### 2. Mantieni Formatter Semplici

```php
// ✅ CORRETTO: Formatter semplice e leggibile
'formatter' => 'function(v) { return v || ""; }'

// ❌ ERRATO: Formatter troppo complesso
'formatter' => 'function(v, ctx) {
    var d = ctx.dataset.data || [];
    var t = d.reduce(function(s, x) { return s + (Number(x) || 0); }, 0);
    var p = (v / t) * 100;
    var f = p >= 10 ? Math.round(p) : p.toFixed(1);
    return f + "% (" + v + ")";
}'
// Meglio estrarre in funzione separata
```

### 3. Usa `display` per Performance

```php
// ✅ CORRETTO: Nascondi label non necessarie
'display' => 'function(ctx) {
    var v = ctx.dataset.data[ctx.dataIndex] || 0;
    return v > 0;  // Mostra solo se valore > 0
}'

// ❌ ERRATO: Mostra sempre (anche valori 0)
'display' => true
```

### 4. Testa su Dati Reali

```php
// ✅ CORRETTO: Testa con dati reali del progetto
protected function getData(): array
{
    return [
        'labels' => $this->getRealLabels(),
        'datasets' => [
            [
                'data' => $this->getRealData(),
                // ...
            ],
        ],
    ];
}

// ❌ ERRATO: Testa solo con dati mock
protected function getData(): array
{
    return [
        'labels' => ['A', 'B', 'C'],
        'datasets' => [['data' => [1, 2, 3]]],
    ];
}
```

### 5. Documenta Configurazioni Complesse

```php
/**
 * Chart options with dual datalabels (value + percent).
 *
 * Labels configuration:
 * - value: Numeric value displayed above bar (top-right)
 * - percent: Percentage displayed inside bar (center)
 *
 * @see https://chartjs-plugin-datalabels.netlify.app/samples/advanced/multiple-labels.html
 */
protected function getOptions(): array
{
    // ...
}
```

### 6. UI/UX Best Practices per Multiple Labels

#### Contrasto Adeguato
- Usa sfondi semi-trasparenti per assicurare leggibilità su sfondi diversi
- Scegli colori del testo con rapporto di contrasto sufficiente (almeno 4.5:1)

#### Spaziatura e Posizionamento (Pattern Centrato Ottimale)

**⭐ Pattern Consigliato: Labels PERFETTAMENTE CENTRATE**

- **Posizionamento Centrato**: Usa `anchor: 'center'` con `align: 'top'` (sopra) e `align: 'bottom'` (sotto) per bilanciamento visivo perfetto
- **Offset Generoso**: Usa `offset: 8px` per entrambe le labels per spaziatura ottimale dalla barra
- **Padding Generoso**: `8px` per primaria, `6px` per secondaria per migliorare la leggibilità
- **Layout Padding**: Aggiungi `layout.padding.top: 20px` e `layout.padding.bottom: 20px` per accogliere labels senza clipping
- **Separazione Verticale**: Posiziona una label sopra e una sotto la barra per chiara separazione gerarchica
- **Allineamento Orizzontale**: Entrambe le labels centrate creano allineamento visivo perfetto tra colonne

#### Stile Visivo
- Usa font weight diversi per distinguere informazioni principali da quelle secondarie
- Usa dimensioni del font appropriate per ogni livello di informazione
- Applica bordi sottili per definire chiaramente le label
- Usa angoli arrotondati per un aspetto moderno e pulito

#### Gerarchia delle Informazioni
- Usa uno stile più prominente (grassetto, colore scuro) per l'informazione principale
- Usa uno stile più sottile (peso medio, colore grigio) per le informazioni secondarie
- Posiziona le informazioni principali dove sono più visibili (es. sopra la barra)
- Usa stili coerenti tra diverse istanze dello stesso tipo di informazione

#### Esempio di Implementazione con Stack Verticale Compatto (3 Labels)

**Pattern Ottimale UI/UX:** Stack verticale compatto sopra la barra (media voti + numero votanti) e mese sotto per visualizzazione ottimale di dati di valutazione.

```javascript
{
  plugins: {
    datalabels: {
      clip: false,
      clamp: true,
      labels: {
        // Label 1: Media voti CENTRATA sopra la barra - Stack verticale alto (offset maggiore)
        average: {
          anchor: 'center',                            // ✅ Perfect center anchor
          align: 'top',                                // ✅ Positioned above
          offset: 20,                                  // ✅ Offset maggiore per stack verticale alto
          color: '#1e293b',                            // ✅ Dark slate for contrast
          backgroundColor: 'rgba(255, 255, 255, 0.95)', // ✅ Almost opaque white
          borderColor: 'rgba(148, 163, 184, 0.5)',    // ✅ Subtle gray border
          borderWidth: 1,
          borderRadius: 6,                             // ✅ Rounded corners
          padding: 6,                                  // ✅ Compact padding per stack
          font: {
            weight: '700',                             // ✅ Extra bold for prominence
            size: 13,                                  // ✅ Slightly smaller per stack compatto
            family: 'system-ui, -apple-system, sans-serif', // ✅ Modern font
          },
          formatter: 'function(v, ctx) {
            var avg = Number(v) || 0;
            return avg > 0 ? avg.toFixed(1) + "/10" : "";
          }',
          display: 'function(ctx) { return (ctx.dataset.data[ctx.dataIndex] || 0) > 0; }'
        },
        // Label 2: Numero votanti CENTRATO sotto la media - Stack verticale basso (offset minore)
        voters: {
          anchor: 'center',                            // ✅ Perfect center anchor (stesso della media)
          align: 'top',                                // ✅ Positioned above (stesso anchor della media)
          offset: 8,                                   // ✅ Offset minore per stack verticale compatto
          color: '#64748b',                            // ✅ Muted slate gray (secondary)
          backgroundColor: 'rgba(241, 245, 249, 0.9)', // ✅ Light gray background
          borderColor: 'rgba(203, 213, 225, 0.6)',     // ✅ Light border
          borderWidth: 1,
          borderRadius: 5,                             // ✅ Slightly less rounded
          padding: 5,                                  // ✅ Compact padding per stack
          font: {
            weight: '600',                             // ✅ Semi-bold (secondary)
            size: 11,                                  // ✅ Smaller size (secondary)
            family: 'system-ui, -apple-system, sans-serif', // ✅ Consistent font
          },
          formatter: 'function(v, ctx) {
            var voteCounts = ctx.dataset.voteCounts || [];
            var voters = voteCounts[ctx.dataIndex] || 0;
            return voters > 0 ? voters + " voti" : "";
          }',
          display: 'function(ctx) {
            var voteCounts = ctx.dataset.voteCounts || [];
            var voters = voteCounts[ctx.dataIndex] || 0;
            return voters > 0;
          }'
        },
        // Label 3: Mese CENTRATO sotto la barra
        month: {
          anchor: 'center',                            // ✅ Perfect center anchor
          align: 'bottom',                             // ✅ Positioned below
          offset: 8,                                   // ✅ Generous spacing
          color: '#94a3b8',                            // ✅ Lighter gray (tertiary)
          backgroundColor: 'rgba(248, 250, 252, 0.85)', // ✅ Very light gray background
          borderColor: 'rgba(226, 232, 240, 0.5)',     // ✅ Very light border
          borderWidth: 1,
          borderRadius: 4,                             // ✅ Less rounded (tertiary)
          padding: 5,                                  // ✅ Compact padding
          font: {
            weight: '500',                             // ✅ Medium weight (tertiary)
            size: 10,                                  // ✅ Smaller size (tertiary)
            family: 'system-ui, -apple-system, sans-serif', // ✅ Consistent font
          },
          formatter: 'function(v, ctx) {
            var labels = ctx.chart.data.labels || [];
            return labels[ctx.dataIndex] || "";
          }',
          display: 'function(ctx) {
            return (ctx.dataset.data[ctx.dataIndex] || 0) > 0;
          }'
        }
      }
    }
  },
  layout: {
    padding: {
      top: 35,    // ✅ Extra space for vertical stack (average + voters)
      bottom: 25  // ✅ Extra space for month label below
    }
  }
}
```

#### Considerazioni per lo Stack Verticale Compatto

##### Stack Verticale Sopra la Barra (Pattern Ottimale)
- **Vantaggi**: 
  - Labels vicine ma leggibili grazie a offset differenziati (20px vs 8px)
  - Gerarchia visiva chiara: media voti (primaria) sopra, numero votanti (secondaria) sotto
  - Stack compatto che non occupa troppo spazio verticale
  - Nessuna sovrapposizione grazie a padding e contrasto ottimizzati
- **Uso ideale**: Media voti (0-10) sopra, numero votanti sotto, mese sotto la barra
- **Accessibilità**: Migliora la leggibilità e la percezione gerarchica con 3 livelli di informazione

##### Posizionamento Stack Verticale con `anchor: 'center'`
- **Stack sopra barra**: Entrambe le labels usano `anchor: 'center'` + `align: 'top'`
- **Offset differenziati**: Media `offset: 20px` (lontano), Votanti `offset: 8px` (vicino)
- **Risultato**: Stack verticale naturale con labels vicine ma leggibili
- **Layout padding**: Aggiungi `top: 35px` per accogliere stack verticale, `bottom: 25px` per mese

##### Gerarchia Visiva Ottimizzata (3 Livelli)
- **Primaria (media voti)**: Font size 13px, weight extra bold (700), colore scuro (`#1e293b`)
- **Secondaria (numero votanti)**: Font size 11px, weight semi-bold (600), colore grigio (`#64748b`)
- **Terziaria (mese)**: Font size 10px, weight medium (500), colore grigio chiaro (`#94a3b8`)
- **Sfondi differenziati**: Bianco quasi opaco (primaria), grigio chiaro (secondaria), grigio molto chiaro (terziaria)

---

## Collegamenti e Riferimenti

### Documentazione Ufficiale

- [chartjs-plugin-datalabels - Multiple Labels](https://chartjs-plugin-datalabels.netlify.app/samples/advanced/multiple-labels.html)
- [chartjs-plugin-datalabels - Guide](https://chartjs-plugin-datalabels.netlify.app/guide/)
- [Filament 5.x - Charts Widgets](https://filamentphp.com/docs/5.x/widgets/charts)

### Documentazione Progetto

- [Filament 5.x Installation Guide](./filament-5-installation-guide.md)
- [Filament Charts Professional Guide](./filament-charts-professional-guide.md)
- [Chart Assets Centralization Rule](./chart-assets-centralization-rule.md) - ⚠️ **CRITICO** - Regola architetturale: centralizzazione asset Chart.js
- [Chart.js Integration Guide](../../UI/docs/charts/filament-chart-js-guide.md)

### Esempi Pratici nel Progetto

- `Modules/Quaeris/app/Filament/Widgets/SimpleChartWidget.php` - ⭐ **ESEMPIO COMPLETO** - Stack verticale compatto (media voti + numero votanti sopra, mese sotto) con UI/UX ottimizzata
  - [Documentazione Completa](../../Quaeris/docs/simplechartwidget-labels-backgrounds.md)
  - **Pattern Centrato**: `anchor: 'center'` + `align: 'top'`/`'bottom'` per bilanciamento visivo perfetto
  - **Gerarchia Visiva**: Font size 14px/11px, weight 700/600, colori slate professionali
  - **Best Practices**: Sfondi ottimizzati, angoli arrotondati, padding generoso, layout padding per prevenire clipping
  - **Font Stack Moderno**: `system-ui, -apple-system, sans-serif` per consistenza cross-platform

---

**Versione:** 1.0  
**Ultimo Aggiornamento:** Gennaio 2026  
**Mantenuto da:** Quaeris Development Team

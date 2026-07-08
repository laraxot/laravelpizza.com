# Guida Completa: Multiple Labels con chartjs-plugin-datalabels in Filament 5.x (Tema Zero)

**Versione:** 1.0  
**Data:** Gennaio 2026  
**Target:** Filament 5.x, Tema Zero  
**Livello:** Guida "a prova di stupido" - passo dopo passo

> **Riferimento Ufficiale:** [chartjs-plugin-datalabels - Multiple Labels Sample](https://chartjs-plugin-datalabels.netlify.app/samples/advanced/multiple-labels.html)  
> **Guida Generale:** [Guida Completa Chart Module](../../Modules/Chart/docs/chartjs-datalabels-multiple-labels-complete-guide.md)

---

## 📋 Indice

1. [Introduzione Tema Zero](#introduzione-tema-zero)
2. [Prerequisiti Tema Zero](#prerequisiti-tema-zero)
3. [Installazione nel Tema Zero](#installazione-nel-tema-zero)
4. [Configurazione Vite Tema Zero](#configurazione-vite-tema-zero)
5. [Esempi Specifici Tema Zero](#esempi-specifici-tema-zero)
6. [Integrazione con Assets Tema](#integrazione-con-assets-tema)
7. [Troubleshooting Tema Zero](#troubleshooting-tema-zero)

---

## Introduzione Tema Zero

Questa guida è specifica per l'uso di **multiple labels** con `chartjs-plugin-datalabels` nel **Tema Zero** in Filament 5.x.

**Caratteristiche Tema Zero:**
- Tema principale del progetto
- Gestisce assets frontend separati
- Deve essere compatibile con Tailwind CSS v4.1+ (Filament 5.x requirement)

**⚠️ IMPORTANTE:** Se il modulo Chart è già configurato, potresti non dover installare il plugin nel tema. Verifica prima la configurazione esistente.

---

## Prerequisiti Tema Zero

Prima di iniziare, assicurati di avere:

- ✅ **Tema Zero** installato e configurato
- ✅ **Tailwind CSS v4.1+** (⚠️ CRITICO per Filament 5.x)
- ✅ **Vite** configurato per il tema
- ✅ **Modulo Chart** verificato (potrebbe già gestire il plugin)

**Verifica configurazione:**

```bash
# Verifica tema Zero
ls -la Themes/Zero

# Verifica Tailwind v4
cd Themes/Zero
npm list tailwindcss
# Dovrebbe mostrare: tailwindcss@^4.1.0
```

---

## Installazione nel Tema Zero

### Step 1: Verifica Configurazione Esistente

**🚨 REGOLA CRITICA: Centralizzazione Asset Chart**

**Prima di installare, verifica se il plugin è già gestito dal modulo Chart:**

```bash
# Verifica se Chart module ha già il plugin
ls -la Modules/Chart/resources/js/filament-chart-js-plugins.js
```

**Se il file esiste, il plugin è già registrato. Non è necessario installarlo nel tema.**

**⚠️ IMPORTANTE:**
- ✅ **CORRETTO**: Asset chart registrati in `Modules/Chart/app/Providers/Filament/AdminPanelProvider.php`
- ❌ **ERRATO**: Registrare asset chart nei temi o in altri moduli

**Motivazione Architetturale:**
- **DRY**: Un'unica fonte di verità per tutti gli asset chart
- **KISS**: Configurazione semplice e centralizzata
- **Coerenza**: Tutti i moduli e temi ereditano automaticamente gli asset chart

Per dettagli completi, vedere [chart-assets-centralization-rule.md](../../Modules/Chart/docs/chart-assets-centralization-rule.md).

### Step 2: Installa Plugin (Solo se Necessario)

Se il tema Zero ha un **bundle Vite separato** e non usa il modulo Chart:

```bash
cd Themes/Zero
npm install chartjs-plugin-datalabels --save-dev
```

**Verifica installazione:**

```bash
npm list chartjs-plugin-datalabels
```

### Step 3: Crea File Registrazione Plugin

Crea o aggiorna il file:

```
Themes/Zero/resources/js/filament-chart-js-plugins.js
```

**Contenuto:**

```javascript
import ChartDataLabels from 'chartjs-plugin-datalabels';

// ✅ CORRETTO: Usa nullish coalescing assignment
window.filamentChartJsPlugins ??= [];
window.filamentChartJsPlugins.push(ChartDataLabels);
```

**⚠️ IMPORTANTE:**
- NON sovrascrivere `window.filamentChartJsPlugins`
- USA `push()` per aggiungere al array esistente
- USA `??=` per inizializzare solo se non esiste

---

## Configurazione Vite Tema Zero

### Step 1: Verifica vite.config.js

Apri il file:

```
Themes/Zero/vite.config.js
```

### Step 2: Aggiungi File JS all'Input

Assicurati che il file plugin sia nell'array `input`:

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/filament-chart-js-plugins.js',  // ✅ Aggiungi questa riga
            ],
            // ...
        }),
        tailwindcss(),  // ✅ Tailwind v4.1+ plugin
    ],
});
```

### Step 3: Build Assets

Compila gli asset:

```bash
npm run build
```

Oppure in modalità sviluppo:

```bash
npm run dev
```

**Verifica build:**
- Controlla che non ci siano errori
- Verifica che il file compilato esista nella directory di output

---

## Esempi Specifici Tema Zero

### Esempio 1: Widget Tema Zero con Multiple Labels

**Caso d'uso:** Widget specifico del tema Zero che mostra statistiche con valore e percentuale.

```php
<?php

declare(strict_types=1);

namespace Themes\Zero\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class ZeroThemeStatsWidget extends XotBaseChartWidget
{
    protected ?string $heading = 'Statistiche Tema Zero';

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
            'clip' => false,
            'clamp' => true,
            'labels' => [
                'value' => [
                    'anchor' => 'center',                    // ✅ Perfect center anchor point
                    'align' => 'top',                        // ✅ Positioned above the anchor
                    'offset' => 8,                           // ✅ Generous spacing from bar top
                    'color' => '#1e293b',                    // ✅ Dark slate for high contrast
                    'backgroundColor' => 'rgba(255, 255, 255, 0.95)', // ✅ Almost opaque white for clarity
                    'borderColor' => 'rgba(148, 163, 184, 0.5)', // ✅ Subtle gray border
                    'borderWidth' => 1,
                    'borderRadius' => 8,                     // ✅ More rounded for modern look
                    'padding' => 8,                          // ✅ Generous padding for breathing room
                    'font' => [
                        'weight' => '700',                   // ✅ Extra bold for prominence
                        'size' => 14,                        // ✅ Larger size for primary info
                        'family' => 'system-ui, -apple-system, sans-serif', // ✅ Modern font stack
                    ],
                    'formatter' => 'function(v) { return v || ""; }',
                    'display' => 'function(ctx) { return (ctx.dataset.data[ctx.dataIndex] || 0) > 0; }',
                ],
                'percent' => [
                    'anchor' => 'center',                    // ✅ Perfect center anchor point
                    'align' => 'bottom',                     // ✅ Positioned below the anchor
                    'offset' => 8,                           // ✅ Generous spacing from bar bottom
                    'color' => '#64748b',                    // ✅ Muted slate gray for secondary info
                    'backgroundColor' => 'rgba(241, 245, 249, 0.9)', // ✅ Light gray background (subtle)
                    'borderColor' => 'rgba(203, 213, 225, 0.6)', // ✅ Light border
                    'borderWidth' => 1,
                    'borderRadius' => 6,                     // ✅ Slightly less rounded (secondary)
                    'padding' => 6,                          // ✅ Comfortable padding
                    'font' => [
                        'weight' => '600',                   // ✅ Semi-bold (less than primary)
                        'size' => 11,                        // ✅ Smaller size for secondary info
                        'family' => 'system-ui, -apple-system, sans-serif', // ✅ Consistent font
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

### Esempio 2: Doughnut Chart con Colori Tema Zero

**Caso d'uso:** Grafico a ciambella con colori del tema Zero.

```php
<?php

declare(strict_types=1);

namespace Themes\Zero\Filament\Widgets;

use Filament\Support\RawJs;
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class ZeroThemeDoughnutWidget extends XotBaseChartWidget
{
    protected ?string $heading = 'Distribuzione Tema Zero';

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        return [
            'labels' => ['Categoria A', 'Categoria B', 'Categoria C', 'Categoria D'],
            'datasets' => [
                [
                    'data' => [25, 30, 20, 25],
                    'backgroundColor' => [
                        '#3b82f6',  // Blu primario Zero
                        '#10b981',  // Verde successo Zero
                        '#f59e0b',  // Arancione warning Zero
                        '#8b5cf6',  // Viola accent Zero
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
      font: { weight: 'bold' },
      offset: 0,
      padding: 0,
      labels: {
        index: {
          align: 'end',
          anchor: 'end',
          color: function(ctx) {
            return ctx.dataset.backgroundColor[ctx.dataIndex];
          },
          font: { size: 16 },
          formatter: function(value, ctx) {
            return '#' + (ctx.dataIndex + 1);
          },
          offset: 8,
        },
        name: {
          align: 'top',
          font: { size: 14 },
          formatter: function(value, ctx) {
            return ctx.chart.data.labels[ctx.dataIndex];
          }
        },
        value: {
          align: 'bottom',
          backgroundColor: function(ctx) {
            var value = ctx.dataset.data[ctx.dataIndex];
            return value > 20 ? 'white' : null;
          },
          borderColor: 'white',
          borderWidth: 2,
          borderRadius: 4,
          color: function(ctx) {
            var value = ctx.dataset.data[ctx.dataIndex];
            return value > 20
              ? ctx.dataset.backgroundColor[ctx.dataIndex]
              : 'white';
          },
          formatter: function(value, ctx) {
            return value;
          },
          padding: 4
        }
      }
    }
  },
  aspectRatio: 1,
  layout: {
    padding: 20
  }
}
JS);
    }
}
```

---

## Integrazione con Assets Tema

### Registrazione Asset nel Panel Provider

Se il tema Zero ha un **Panel Provider dedicato**, registra l'asset:

```php
<?php

namespace Themes\Zero\Providers;

use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Assets\Js;
use Illuminate\Support\Facades\Vite;

class ZeroPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $panel = parent::panel($panel);
        
        FilamentAsset::register([
            Js::make('chart-js-plugins', Vite::asset('resources/js/filament-chart-js-plugins.js', 'assets/zero'))->module(),
        ]);
        
        return $panel;
    }
}
```

**⚠️ NOTA:** Se il modulo Chart registra già l'asset, non è necessario registrarlo di nuovo nel tema.

---

## Troubleshooting Tema Zero

### Problema: Tailwind CSS v3.x Incompatibile

**Sintomi:** Errori di build o incompatibilità con Filament 5.x.

**Soluzione:**

1. **Aggiorna a Tailwind v4.1+:**
   ```bash
   cd Themes/Zero
   npm uninstall tailwindcss
   npm install tailwindcss@^4.1.0 @tailwindcss/vite@^4.1.0 --save-dev
   ```

2. **Aggiorna vite.config.js:**
   ```javascript
   import tailwindcss from '@tailwindcss/vite';
   
   export default defineConfig({
       plugins: [
           laravel({...}),
           tailwindcss(),  // ✅ Plugin Tailwind v4
       ],
   });
   ```

3. **Aggiorna CSS:**
   ```css
   /* resources/css/app.css */
   @import 'tailwindcss';  /* ✅ Nuova sintassi v4 */
   /* NON: @tailwind base; @tailwind components; @tailwind utilities; */
   ```

### Problema: Plugin Non Caricato

**Sintomi:** Labels non appaiono nei widget del tema.

**Soluzioni:**

1. **Verifica che il modulo Chart sia abilitato:**
   ```bash
   php artisan module:list | grep Chart
   ```

2. **Verifica build Vite:**
   ```bash
   cd Themes/Zero
   npm run build
   # Controlla errori
   ```

3. **Verifica console browser:**
   ```javascript
   // Apri console (F12)
   console.log(window.filamentChartJsPlugins);
   // Dovrebbe contenere ChartDataLabels
   ```

### Problema: Asset Duplicati

**Sintomi:** Errori di asset duplicati o conflitti.

**Soluzione:**

- **Non registrare l'asset due volte.** Se il modulo Chart lo registra già, non registrarlo nel tema.

---

## Collegamenti e Riferimenti

### Documentazione Tema Zero

- [Filament 5.x Installation Guide](./filament-5-installation-guide.md)
- [Tema Zero README](../README.md)

### Documentazione Generale

- [Guida Completa Chart Module](../../../Modules/Chart/docs/chartjs-datalabels-multiple-labels-complete-guide.md)
- [QuestionChartAnswersChartWidget (doughnut/pie)](../../../Modules/healthcare_app/docs/question-chart-answers-chart-widget.md) – implementazione doughnut con clip false, anchor/display, label+percentuale
- [SimpleChartWidget con Sfondi](../../../Modules/healthcare_app/docs/simplechartwidget-labels-backgrounds.md) - ⭐ Esempio completo con sfondi ottimizzati per UI/UX
- [Filament 5.x Charts](https://filamentphp.com/docs/5.x/widgets/charts)

### Documentazione Ufficiale

- [chartjs-plugin-datalabels - Multiple Labels](https://chartjs-plugin-datalabels.netlify.app/samples/advanced/multiple-labels.html)
- [chartjs-plugin-datalabels - Doughnut (sorgente)](https://github.com/chartjs/chartjs-plugin-datalabels/blob/master/docs/samples/charts/doughnut.md) / [Demo Doughnut](https://chartjs-plugin-datalabels.netlify.app/samples/charts/doughnut.html)

---

**Versione:** 1.0  
**Ultimo Aggiornamento:** Gennaio 2026  
**Mantenuto da:** healthcare_app Development Team

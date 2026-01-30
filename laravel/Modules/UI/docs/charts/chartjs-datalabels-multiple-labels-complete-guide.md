# Guida Completa: Multiple Labels con chartjs-plugin-datalabels in Filament 5.x (Modulo UI)

**Versione:** 1.0  
**Data:** Gennaio 2026  
**Target:** Filament 5.x, Laravel 12.x, Modulo UI  
**Livello:** Guida "a prova di stupido" - passo dopo passo

> **Riferimento Ufficiale:** [chartjs-plugin-datalabels - Multiple Labels Sample](https://chartjs-plugin-datalabels.netlify.app/samples/advanced/multiple-labels.html)  
> **Guida Generale:** [Guida Completa Chart Module](../../Chart/docs/chartjs-datalabels-multiple-labels-complete-guide.md)

---

## 📋 Indice

1. [Introduzione](#introduzione)
2. [Prerequisiti Modulo UI](#prerequisiti-modulo-ui)
3. [Installazione nel Modulo UI](#installazione-nel-modulo-ui)
4. [Configurazione Widget UI](#configurazione-widget-ui)
5. [Esempi Specifici UI](#esempi-specifici-ui)
6. [Integrazione con Componenti UI](#integrazione-con-componenti-ui)
7. [Troubleshooting UI](#troubleshooting-ui)

---

## Introduzione

Questa guida è specifica per l'uso di **multiple labels** con `chartjs-plugin-datalabels` nei **widget del modulo UI** in Filament 5.x.

**Differenze con Chart Module:**
- Il modulo UI si concentra su componenti riutilizzabili e design system
- I widget UI devono essere compatibili con il tema attivo
- Le configurazioni devono rispettare le linee guida AGID (se applicabili)

**Per la guida completa generale, vedere:**
- [Guida Completa Chart Module](../../Chart/docs/chartjs-datalabels-multiple-labels-complete-guide.md)

---

## Prerequisiti Modulo UI

Prima di iniziare, assicurati di avere:

- ✅ **Modulo Chart** installato e configurato (gestisce registrazione plugin)
- ✅ **Modulo UI** abilitato
- ✅ **Tema attivo** configurato (Zero, One, ecc.)
- ✅ **Filament 5.x** funzionante

**Verifica dipendenze:**

```bash
# Verifica modulo Chart
php artisan module:list | grep Chart

# Verifica modulo UI
php artisan module:list | grep UI
```

---

## Installazione nel Modulo UI

### ⚠️ IMPORTANTE: Plugin Registrato nel Modulo Chart (Centralizzazione)

Nel progetto, il plugin `chartjs-plugin-datalabels` è **già registrato nel modulo Chart**:

- **File JS:** `Modules/Chart/resources/js/filament-chart-js-plugins.js`
- **Panel Provider:** `Modules/Chart/app/Providers/Filament/AdminPanelProvider.php`

**🚨 REGOLA CRITICA: Centralizzazione Asset Chart**

**Le configurazioni JS/CSS per Chart.js plugins DEVONO essere registrate SOLO nel modulo Chart.**

- ✅ **CORRETTO**: Asset registrati in `Modules/Chart/app/Providers/Filament/AdminPanelProvider.php`
- ❌ **ERRATO**: Registrare asset chart in altri moduli o temi

**Non è necessario installare il plugin nel modulo UI** - gli asset sono già disponibili grazie alla registrazione centralizzata nel modulo Chart.

**Motivazione Architetturale:**
- **DRY**: Un'unica fonte di verità per tutti gli asset chart
- **KISS**: Configurazione semplice e centralizzata
- **Coerenza**: Tutti i moduli ereditano automaticamente gli asset chart

Per dettagli completi, vedere [chart-assets-centralization-rule.md](../../Chart/docs/chart-assets-centralization-rule.md).

### Se Usi un Panel Separato per UI

Se il modulo UI ha un **panel Filament separato**, devi:

1. **Installa il plugin:**
   ```bash
   cd /var/www/_bases/base_quaeris_fila5_mono/laravel/Modules/UI
   npm install chartjs-plugin-datalabels --save-dev
   ```

2. **Crea file registrazione:**
   ```
   Modules/UI/resources/js/filament-chart-js-plugins.js
   ```
   ```javascript
   import ChartDataLabels from 'chartjs-plugin-datalabels';
   
   window.filamentChartJsPlugins ??= [];
   window.filamentChartJsPlugins.push(ChartDataLabels);
   ```

3. **Aggiungi a Vite config:**
   ```javascript
   // Modules/UI/vite.config.js
   laravel({
       input: [
           // ...
           resolve(__dirname, 'resources/js/filament-chart-js-plugins.js')
       ],
   })
   ```

4. **Registra asset nel Panel Provider UI:**
   ```php
   // Modules/UI/app/Providers/Filament/UIPanelProvider.php
   FilamentAsset::register([
       Js::make('chart-js-plugins', Vite::asset('resources/js/filament-chart-js-plugins.js', 'assets/ui'))->module(),
   ]);
   ```

---

## Configurazione Widget UI

### Pattern Base per Widget UI

I widget UI devono estendere `XotBaseChartWidget` e rispettare le convenzioni del design system:

```php
<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class UIChartWidget extends XotBaseChartWidget
{
    protected ?string $heading = 'UI Chart Example';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        return [
            'labels' => ['Q1', 'Q2', 'Q3', 'Q4'],
            'datasets' => [
                [
                    'label' => 'Vendite',
                    'data' => [100, 200, 150, 300],
                    'backgroundColor' => 'rgba(59, 130, 246, 0.8)',
                ],
            ],
        ];
    }

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
            ],
        ];

        return $options;
    }
}
```

### Integrazione con Design System UI

I widget UI devono rispettare i colori e gli stili del design system:

```php
protected function getOptions(): array
{
    $options = parent::getOptions();

    // Usa colori del design system UI
    $primaryColor = '#3b82f6';  // Colore primario UI
    $textColor = '#1f2937';     // Colore testo UI
    $bgColor = '#ffffff';       // Colore sfondo UI

    $options['plugins']['datalabels'] = [
        'labels' => [
            'value' => [
                'anchor' => 'end',
                'align' => 'top',
                'color' => $textColor,
                'font' => ['weight' => 'bold', 'size' => 12],
                'formatter' => 'function(v) { return v || ""; }',
            ],
            'percent' => [
                'anchor' => 'center',
                'align' => 'center',
                'color' => $bgColor,
                'font' => ['weight' => '600', 'size' => 10],
                'formatter' => 'function(v, ctx) {
                    var d = ctx.dataset.data || [];
                    var t = d.reduce(function(s, x) { return s + (Number(x) || 0); }, 0);
                    if (!t || !v) return "";
                    return Math.round((v / t) * 100) + "%";
                }',
            ],
        ],
    ];

    return $options;
}
```

---

## Esempi Specifici UI

### Esempio 1: Widget Statistiche UI con Multiple Labels

**Caso d'uso:** Widget per dashboard UI che mostra statistiche con valore e percentuale.

```php
<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class UIStatsChartWidget extends XotBaseChartWidget
{
    protected ?string $heading = 'Statistiche UI';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        return [
            'labels' => ['Utenti', 'Pagine', 'Componenti', 'Widget'],
            'datasets' => [
                [
                    'label' => 'Conteggio',
                    'data' => [150, 45, 120, 30],
                    'backgroundColor' => [
                        'rgba(59, 130, 246, 0.8)',   // Blu primario UI
                        'rgba(16, 185, 129, 0.8)',   // Verde successo UI
                        'rgba(245, 158, 11, 0.8)',   // Arancione warning UI
                        'rgba(239, 68, 68, 0.8)',    // Rosso errore UI
                    ],
                    'borderColor' => [
                        'rgb(37, 99, 235)',
                        'rgb(5, 150, 105)',
                        'rgb(217, 119, 6)',
                        'rgb(220, 38, 38)',
                    ],
                    'borderWidth' => 1,
                ],
            ],
        ];
    }

    protected function getOptions(): array
    {
        $options = parent::getOptions();

        $options['plugins']['legend'] = ['display' => false];
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

### Esempio 2: Widget Componenti UI con Doughnut

**Caso d'uso:** Widget che mostra distribuzione componenti UI con triple labels.

```php
<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Widgets;

use Filament\Support\RawJs;
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class UIComponentsDistributionWidget extends XotBaseChartWidget
{
    protected ?string $heading = 'Distribuzione Componenti UI';

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        return [
            'labels' => ['Buttons', 'Forms', 'Cards', 'Tables', 'Modals'],
            'datasets' => [
                [
                    'data' => [25, 15, 20, 18, 12],
                    'backgroundColor' => [
                        '#3b82f6',  // Blu
                        '#10b981',  // Verde
                        '#f59e0b',  // Arancione
                        '#8b5cf6',  // Viola
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
            return value > 15 ? 'white' : null;
          },
          borderColor: 'white',
          borderWidth: 2,
          borderRadius: 4,
          color: function(ctx) {
            var value = ctx.dataset.data[ctx.dataIndex];
            return value > 15
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

## Integrazione con Componenti UI

### Widget UI in Dashboard

I widget UI con multiple labels possono essere utilizzati nelle dashboard Filament:

```php
// In una pagina dashboard
protected function getWidgets(): array
{
    return [
        UIStatsChartWidget::class,
        UIComponentsDistributionWidget::class,
    ];
}
```

### Personalizzazione per Tema

I widget UI possono adattarsi al tema attivo:

```php
protected function getOptions(): array
{
    $options = parent::getOptions();

    // Rileva tema attivo (esempio)
    $theme = config('filament.theme', 'zero');
    
    // Colori basati su tema
    $colors = match($theme) {
        'zero' => [
            'primary' => '#3b82f6',
            'text' => '#1f2937',
            'bg' => '#ffffff',
        ],
        'one' => [
            'primary' => '#6366f1',
            'text' => '#111827',
            'bg' => '#f9fafb',
        ],
        default => [
            'primary' => '#3b82f6',
            'text' => '#1f2937',
            'bg' => '#ffffff',
        ],
    };

    $options['plugins']['datalabels'] = [
        'labels' => [
            'value' => [
                'color' => $colors['text'],
                // ...
            ],
        ],
    ];

    return $options;
}
```

---

## Troubleshooting UI

### Problema: Widget UI Non Mostra Labels

**Sintomi:** Widget UI funziona ma labels non compaiono.

**Soluzioni:**

1. **Verifica che il modulo Chart sia abilitato:**
   ```bash
   php artisan module:list | grep Chart
   ```

2. **Verifica asset registrato:**
   ```php
   // Il Panel Provider Chart deve registrare l'asset
   // Se usi panel separato UI, registra anche lì
   ```

3. **Verifica namespace widget:**
   ```php
   // ✅ CORRETTO
   namespace Modules\UI\Filament\Widgets;
   
   // ❌ ERRATO
   namespace App\Filament\Widgets;
   ```

### Problema: Colori Non Compatibili con Tema

**Sintomi:** Labels hanno colori che non si integrano con il tema UI.

**Soluzioni:**

1. **Usa colori del design system:**
   ```php
   // ✅ CORRETTO: Colori UI standard
   'color' => '#1f2937',  // Testo UI
   'backgroundColor' => '#ffffff',  // Sfondo UI
   
   // ❌ ERRATO: Colori hardcoded non UI
   'color' => '#ff0000',  // Rosso generico
   ```

2. **Usa variabili CSS se disponibili:**
   ```php
   // Se il tema espone variabili CSS, usale
   'color' => 'var(--ui-text-color)',
   ```

---

## Collegamenti e Riferimenti

### Documentazione Modulo UI

- [Filament Chart.js Guide](./filament-chart-js-guide.md)
- [UI Components Documentation](../components/README.md)

### Documentazione Generale

- [Guida Completa Chart Module](../../Chart/docs/chartjs-datalabels-multiple-labels-complete-guide.md)
- [Filament 5.x Installation Guide](../../Chart/docs/filament-5-installation-guide.md)
- [SimpleChartWidget con Sfondi](../../Quaeris/docs/simplechartwidget-labels-backgrounds.md) - ⭐ Esempio completo con sfondi ottimizzati per UI/UX

### Documentazione Ufficiale

- [chartjs-plugin-datalabels - Multiple Labels](https://chartjs-plugin-datalabels.netlify.app/samples/advanced/multiple-labels.html)
- [Filament 5.x - Charts Widgets](https://filamentphp.com/docs/5.x/widgets/charts)

---

**Versione:** 1.0  
**Ultimo Aggiornamento:** Gennaio 2026  
**Mantenuto da:** Quaeris Development Team

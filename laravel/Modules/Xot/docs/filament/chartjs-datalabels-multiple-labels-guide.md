# Multiple Labels con chartjs-plugin-datalabels (Xot Base)

**Versione:** 1.0  
**Data:** Gennaio 2026  
**Target:** XotBaseChartWidget  
**Livello:** Guida di riferimento rapido

> **⚠️ IMPORTANTE:** Per la guida completa dettagliata, vedere: [Guida Completa Chart Module](../../Chart/docs/chartjs-datalabels-multiple-labels-complete-guide.md)

---

## Pattern Base con XotBaseChartWidget

```php
<?php

declare(strict_types=1);

namespace Modules\YourModule\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class YourChartWidget extends XotBaseChartWidget
{
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

---

## Esempi Pratici

### Bar Chart Dual Labels

```php
protected function getOptions(): array
{
    $options = parent::getOptions();

    $options['plugins']['datalabels'] = [
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
                    return Math.round((v / t) * 100) + "%";
                }',
            ],
        ],
    ];

    return $options;
}
```

---

## Collegamenti

- [Guida Completa Chart Module](../../Chart/docs/chartjs-datalabels-multiple-labels-complete-guide.md)
- [XotBaseChartWidget Documentation](../README.md)

---

**Versione:** 1.0  
**Ultimo Aggiornamento:** Gennaio 2026

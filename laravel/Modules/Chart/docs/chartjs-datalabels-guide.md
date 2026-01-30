# CHART.JS DATALABELS PLUGIN - GUIDA COMPLETA

## 🎯 Panoramica

Il plugin **chartjs-plugin-datalabels** è incredibilmente **DRY e KISS** per aggiungere etichette ai grafici Chart.js. Perfetto per mostrare dati multipli per ogni punto dati (valore, percentuale, ecc.).

## ✅ Installazione

### 1. Installazione nel Progetto
```bash
# Installa il plugin
composer require chartjs/chartjs-plugin-datalabels:^2.2

# Verifica installazione
composer show chartjs/chartjs-plugin-datalabels
```

### 2. Installazione Frontend
```bash
# Installa per il frontend
npm install chartjs-plugin-datalabels

# Oppure usa CDN
# <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
```

## 📊 Pattern Base - DRY & KISS

### ✅ Pattern 1: Dual Label (Valore + Percentuale)
```php
class DualLabelChartWidget extends XotBaseChartWidget
{
    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Dati Vendite',
                    'data' => [120, 150, 80, 70, 110, 130, 90],
                    'backgroundColor' => 'rgba(54, 162, 235, 0.8)',
                ],
            ],
            'labels' => ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu', 'Lug'],
        ];
    }
    
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'datalabels' => [
                    'labels' => [
                        'value' => [
                            'anchor' => 'end',
                            'align' => 'top',
                            'color' => '#1f2937',
                            'font' => ['weight' => 'bold'],
                            'formatter' => 'function(v) { return v || ""; }',
                        ],
                        'percent' => [
                            'anchor' => 'center',
                            'align' => 'center',
                            'color' => '#ffffff',
                            'formatter' => 'function(v, ctx) {
                                var t = ctx.dataset.data.reduce((s, x) => s + x, 0);
                                return t ? Math.round((v / t) * 100) + "%" : "";
                            }',
                        ],
                    ],
                ],
            ],
        ];
    }
}
```

### ✅ Pattern 2: Label Condizionale
```php
class ConditionalLabelChartWidget extends XotBaseChartWidget
{
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'datalabels' => [
                    'display' => 'function(ctx) {
                        // Mostra label solo per valori > 50
                        return ctx.dataset.data[ctx.dataIndex] > 50;
                    },
                    'labels' => [
                        'value' => [
                            'color' => 'function(ctx) {
                                return ctx.dataset.data[ctx.dataIndex] > 100 ? '#ff0000' : '#1f2937';
                            }',
                            'formatter' => 'function(v) {
                                return v > 100 ? "⚠️ " + v : v;
                            }',
                        ],
                    ],
                ],
            ],
        ];
    }
}
```

## 🎯 Esempio Pratico - SimpleChartWidget

Il file `SimpleChartWidget.php` che abbiamo corretto mostra l'approccio perfetto:

### 📋 Caratteristiche Chiave
1. **DRY**: Nessun duplicazione di configurazione
2. **KISS**: Logica semplice e leggibile
3. **Performance**: Formatters efficienti
4. **Maintenance**: Facile da modificare

### 🏗️ Struttura
```php
// 1. Singolo metodo getOptions() - DRY
protected function getOptions(): array
{
    return [
        'plugins' => [
            'datalabels' => [
                'labels' => [
                    // 2. Dual labels per ogni dato
                    'value' => [...],  // Etichetta valore
                    'percent' => [...], // Etichetta percentuale
                ],
            ],
        ],
        // 3. Altre opzioni standard Chart.js
        'responsive' => true,
        'scales' => [...],
    ];
}
```

## 🎨 Opzioni Avanzate

### 1. Multiple Labels Configuration
```php
'datalabels' => [
    'labels' => [
        'title' => [
            'display' => true,
            'color' => '#333',
            'font' => ['size' => 14, 'weight' => 'bold'],
            'formatter' => 'function(v, ctx) { return ctx.chart.data.labels[ctx.dataIndex]; }',
        ],
        'subtitle' => [
            'display' => true,
            'color' => '#666',
            'font' => ['size' => 12],
            'formatter' => 'function(v, ctx) { return new Date(v).toLocaleDateString(); }',
        ],
        'value' => [
            'anchor' => 'end',
            'align' => 'top',
            'offset' => 8,
        ],
        'footer' => [
            'display' => true,
            'color' => '#999',
            'font' => ['size' => 10, 'style' => 'italic'],
        ],
    ],
]
```

### 2. Performance Optimization
```php
'datalabels' => [
    // Mostra labels solo per dati rilevanti
    'display' => 'function(ctx) {
        var value = ctx.dataset.data[ctx.dataIndex];
        return value > 10; // Solo per valori > 10
    },
    // Cache formatter per performance
    'formatter' => 'function(v) {
        // Cache del formatter
        if (!window.chartLabelFormatters) {
            window.chartLabelFormatters = {};
        }
        
        var key = 'value_' + Math.floor(v/10);
        if (!window.chartLabelFormatters[key]) {
            window.chartLabelFormatters[key] = function(val) {
                return val.toLocaleString();
            };
        }
        
        return window.chartLabelFormatters[key](v);
    }',
]
```

### 3. Styling Avanzato
```php
'datalabels' => [
    'labels' => [
        'value' => [
            'color' => 'function(ctx) {
                // Colore dinamico basato sul valore
                var value = ctx.dataset.data[ctx.dataIndex];
                var colors = ['#22c55e', '#fbbf24', '#ef4444', '#10b981'];
                return colors[Math.floor(value / 25) % colors.length];
            }',
            'font' => [
                'weight' => 'bold',
                'size' => 'function(ctx) {
                    var value = ctx.dataset.data[ctx.dataIndex];
                    return 12 + (value / 10); // Font size dinamico
                }',
            ],
            'borderRadius' => 4,
            'borderWidth' => 2,
            'backgroundColor' => 'function(ctx) {
                var value = ctx.dataset.data[ctx.dataIndex];
                var opacity = Math.min(0.8, 0.3 + (value / 100));
                return 'rgba(255, 255, 255, ' + opacity + ')';
            }',
        ],
    ],
]
```

## 🔧 Best Practices

### 1. Performance
- ✅ **Cache formatter functions**: Evita ricreazione costante
- ✅ **Lazy evaluation**: Calcola solo quando necessario
- ✅ **Minimal DOM updates**: Aggiorna solo gli elementi necessari
- ✅ **Use arrow functions**: Più efficienti delle funzioni classiche

### 2. User Experience
- ✅ **Smart positioning**: Adatta posizione al tipo di grafico
- ✅ **Contrast colors**: Buon contrasto per leggibilità
- ✅ **Responsive sizing**: Adatta dimensioni al viewport
- ✅ **Accessibility**: Test con screen readers

### 3. Code Quality
- ✅ **DRY principle**: Non duplicare configurazioni
- ✅ **KISS logic**: Mantieni semplice e manutenibile
- ✅ **Type safety**: Valida tutti i dati
- ✅ **Error handling**: Graceful fallback

## 🚀 Esempi Avanzati

### 1. Survey Response Chart
```php
class SurveyResponseChart extends XotBaseChartWidget
{
    protected function getData(): array
    {
        // Dati survey con multiple tipi di risposta
        $responses = $this->getSurveyResponses();
        
        return [
            'datasets' => [
                [
                    'label' => 'Risposte Positive',
                    'data' => $responses['positive'],
                    'backgroundColor' => 'rgba(34, 197, 94, 0.8)',
                ],
                [
                    'label' => 'Risposte Negative', 
                    'data' => $responses['negative'],
                    'backgroundColor' => 'rgba(239, 68, 68, 0.8)',
                ],
                [
                    'label' => 'Risposte Neutral',
                    'data' => $responses['neutral'],
                    'backgroundColor' => 'rgba(156, 163, 175, 0.8)',
                ],
            ],
            'labels' => $responses['questions'],
        ];
    }
    
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'datalabels' => [
                    'labels' => [
                        'value' => [
                            'anchor' => 'end',
                            'align' => 'top',
                            'offset' => 8,
                            'color' => '#ffffff',
                            'font' => ['weight' => 'bold', 'size' => 12],
                            'formatter' => 'function(v, ctx) {
                                if (!v) return '0';
                                return v.toLocaleString() + ' risposte';
                            }',
                        ],
                        'percent' => [
                            'anchor' => 'center',
                            'align' => 'center',
                            'color' => '#ffffff',
                            'font' => ['weight' => '600', 'size' => 10],
                            'formatter' => 'function(v, ctx) {
                                var total = ctx.dataset.data.reduce((s, x) => s + x, 0);
                                return Math.round((v / total) * 100) + '%';
                            }',
                        ],
                    ],
                ],
            ],
        ];
    }
}
```

### 2. Real-time Dashboard Chart
```php
class RealTimeChart extends XotBaseChartWidget
{
    protected static bool $isLazy = true;
    
    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Utenti Attivi',
                    'data' => $this->getRealTimeData(),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.8)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                ],
            ],
            'labels' => $this->getTimeLabels(),
        ];
    }
    
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'datalabels' => [
                    'labels' => [
                        'value' => [
                            'anchor' => 'end',
                            'align' => 'top',
                            'color' => '#ffffff',
                            'font' => ['weight' => 'bold'],
                            'formatter' => 'function(v, ctx) {
                                // Formatta con indicatori real-time
                                var indicator = ctx.active ? '🔴' : '⚪';
                                return indicator + ' ' + v.toLocaleString();
                            }',
                        ],
                    ],
                ],
            ],
            // Animazioni per real-time
            'animation' => [
                'duration' => 0, // Nessuna animazione per dati real-time
            ],
        ];
    }
}
```

## 🔧 Troubleshooting

### Problemi Comuni e Soluzioni

#### 1. Labels Non Appaiono
```php
// ❌ SBAGLIATO
'datalabels' => [
    'display' => false, // Non mostra mai le labels!
]

// ✅ CORRETTO
'datalabels' => [
    'display' => 'function(ctx) { 
        return ctx.dataset.data[ctx.dataIndex] > 0; 
    }',
]
```

#### 2. Performance Lenta
```php
// ❌ SBAGLIATO - Formatter ricreato ogni volta
'formatter' => 'function(v) {
    var labels = ['Basso', 'Medio', 'Alto'];
    var index = Math.floor(v / 33);
    return labels[index]; // Calcolo ripetuto
},

// ✅ CORRETTO - Cache del formatter
if (!window.valueLabels) {
    window.valueLabels = ['Basso', 'Medio', 'Alto'];
}
'formatter' => 'function(v) {
    var index = Math.floor(v / 33);
    return window.valueLabels[index]; // Lookup O(1)
},
```

#### 3. Labels Si Sovrappongono
```php
// ❌ SBAGLIATO - Nessun clipping
'clip' => false,

// ✅ CORRETTO - Clip per evitare sovrapposizioni
'clip' => true,
'offset' => 8,
```

## 📚 Riferimenti e Risorse

### Documentazione Ufficiale
- [Chart.js Datalabels Plugin](https://github.com/chartjs/chartjs-plugin-datalabels)
- [Esempi Avanzati](https://chartjs-plugin-datalabels.netlify.app/samples/)
- [API Reference](https://chartjs-plugin-datalabels.netlify.app/guide/)

### Esempi nel Progetto
- `Modules/Quaeris/app/Filament/Widgets/SimpleChartWidget.php` - Demo base
- `Modules/Chart/docs/chartjs-datalabels-guide.md` - Guida avanzata
- Dashboard widgets per dati survey in `Modules/Quaeris/`

### Tools di Sviluppo
- Chrome DevTools per debugging formatter functions
- Chart.js Inspector per analisi performance
- Laravel Telescope per debug backend

---

## ✅ Checklist di Implementazione

Prima di aggiungere datalabels a un widget:

- [ ] Plugin installato via composer
- [ ] Plugin installato via npm
- [ ] Metodo getOptions() restituisce array
- [ ] Datalabels configurato in options
- [ ] Formatters testati con dati reali
- [ ] Performance ottimizzata (cache formatters)
- [ ] Labels responsive su mobile
- [ ] Contrasto colori verificato
- [ ] Accessibilità testata

---

**Conclusione**: Il plugin chartjs-plugin-datalabels segue perfettamente i principi **DRY e KISS** che sono il cuore del nostro sistema. Implementalo con logica pulita e manutenibile per图表 professionali e performanti.
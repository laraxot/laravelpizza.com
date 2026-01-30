# Chart.js Export con Filament Actions - Implementazione Completa

**Data Creazione**: 2025-01-18  
**Status**: Implementazione Completa  
**Versione**: 1.0.0

## 📋 Panoramica

Questa documentazione descrive l'implementazione completa dell'export Chart.js (PNG e SVG) utilizzando **SOLO Filament Actions**, senza controller o rotte custom, seguendo l'architettura Laraxot.

---

## 🏗️ Architettura

### Componenti Principali

```
QuestionChartItemWidget (Filament Widget)
    ├─→ View Custom: question-chart-item-widget.blade.php
    │   ├─→ Alpine.js component: chartWithExport()
    │   └─→ Pulsanti export (PNG/SVG)
    │
    ├─→ Metodi Livewire:
    │   ├─→ saveChartJsPng(string $imageBase64): void
    │   └─→ saveChartJsSvg(string $imageBase64): void
    │
    └─→ Actions (Spatie QueueableActions):
        ├─→ SaveChartJsPngAction
        └─→ SaveChartJsSvgAction
```

---

## 📁 File Implementati

### 1. Actions

#### `SaveChartJsPngAction.php`

**Path**: `Modules/Quaeris/app/Actions/QuestionChart/SaveChartJsPngAction.php`

**Responsabilità**:
- Riceve immagine PNG in formato base64
- Valida formato e dimensione
- Salva file su filesystem (`public/chart/{id}.png`)
- Aggiorna `QuestionChart` model

**Esempio utilizzo**:
```php
$filename = app(SaveChartJsPngAction::class)
    ->execute($questionChart, $pngBase64);
```

#### `SaveChartJsSvgAction.php`

**Path**: `Modules/Quaeris/app/Actions/QuestionChart/SaveChartJsSvgAction.php`

**Responsabilità**:
- Riceve immagine SVG in formato base64 o stringa
- Valida formato e dimensione
- Salva file su filesystem (`public/chart/{id}.svg`)
- Aggiorna `QuestionChart` model

**Esempio utilizzo**:
```php
$filename = app(SaveChartJsSvgAction::class)
    ->execute($questionChart, $svgBase64);
```

---

### 2. Widget Filament

#### `QuestionChartItemWidget.php`

**Path**: `Modules/Quaeris/app/Filament/Widgets/QuestionChartItemWidget.php`

**Metodi Livewire**:

```php
/**
 * Salva grafico Chart.js come PNG.
 * Chiamato da JavaScript tramite Livewire.
 */
public function saveChartJsPng(string $imageBase64): void
{
    $questionChart = $this->getQuestionChart();
    $filename = app(SaveChartJsPngAction::class)
        ->execute($questionChart, $imageBase64);
    
    Notification::make()
        ->title('Grafico esportato con successo')
        ->body("File salvato: {$filename}")
        ->success()
        ->send();
}

/**
 * Salva grafico Chart.js come SVG.
 * Chiamato da JavaScript tramite Livewire.
 */
public function saveChartJsSvg(string $imageBase64): void
{
    $questionChart = $this->getQuestionChart();
    $filename = app(SaveChartJsSvgAction::class)
        ->execute($questionChart, $imageBase64);
    
    Notification::make()
        ->title('Grafico esportato con successo')
        ->body("File salvato: {$filename}")
        ->success()
        ->send();
}
```

---

### 3. View Custom

#### `question-chart-item-widget.blade.php`

**Path**: `Modules/Quaeris/resources/views/filament/widgets/question-chart-item-widget.blade.php`

**Caratteristiche**:
- Estende template standard Filament chart widget
- Aggiunge pulsanti export (PNG/SVG) nell'header
- Integra Alpine.js component `chartWithExport()`

**JavaScript Alpine.js**:

```javascript
Alpine.data('chartWithExport', (config) => {
    return {
        ...chartComponent(config),
        
        /**
         * Esporta grafico Chart.js
         */
        exportChart(format) {
            const canvas = this.$refs.canvas;
            const chartInstance = Chart.getChart(canvas);
            
            if (format === 'png') {
                const pngBase64 = canvas.toDataURL('image/png', 1.0);
                @this.call('saveChartJsPng', pngBase64);
            } else if (format === 'svg') {
                const svgString = this.canvasToSvg(canvas, chartInstance);
                const svgBase64 = btoa(unescape(encodeURIComponent(svgString)));
                const dataUrl = 'data:image/svg+xml;base64,' + svgBase64;
                @this.call('saveChartJsSvg', dataUrl);
            }
        }
    };
});
```

---

## 🔄 Flusso Completo

### Export PNG

1. **Utente clicca pulsante "PNG"** nel widget
2. **Alpine.js** chiama `exportChart('png')`
3. **JavaScript** esporta canvas come PNG base64
4. **Livewire** chiama `saveChartJsPng($pngBase64)`
5. **Action** `SaveChartJsPngAction`:
   - Valida formato PNG
   - Decodifica base64
   - Salva file su filesystem
   - Aggiorna `QuestionChart` model
6. **Notification** Filament mostra successo

### Export SVG

1. **Utente clicca pulsante "SVG"** nel widget
2. **Alpine.js** chiama `exportChart('svg')`
3. **JavaScript** converte canvas a SVG
4. **Livewire** chiama `saveChartJsSvg($svgBase64)`
5. **Action** `SaveChartJsSvgAction`:
   - Valida formato SVG
   - Decodifica base64 (se necessario)
   - Salva file su filesystem
   - Aggiorna `QuestionChart` model
6. **Notification** Filament mostra successo

---

## ✅ Verifica Qualità

### PHPStan Livello 10

```bash
./vendor/bin/phpstan analyse --level=10 \
    Modules/Quaeris/app/Actions/QuestionChart/SaveChartJsPngAction.php \
    Modules/Quaeris/app/Actions/QuestionChart/SaveChartJsSvgAction.php \
    Modules/Quaeris/app/Filament/Widgets/QuestionChartItemWidget.php
```

**Risultato**: ✅ Nessun errore

### Convenzioni Codice

- ✅ **Safe Functions**: Usa `Safe\base64_decode`, `Safe\preg_replace`
- ✅ **Type Hints**: Tutti i parametri e return types espliciti
- ✅ **Assertions**: `Webmozart\Assert\Assert` per validazione
- ✅ **Yoda Conditions**: `false === $decoded` invece di `$decoded === false`
- ✅ **PSR-12**: Conformità standard coding style

---

## 🚫 Cosa NON Fare

### ❌ NON Creare Controller

```php
// ❌ SBAGLIATO
class ChartExportController extends Controller
{
    public function exportPng(Request $request) { }
}
```

### ❌ NON Aggiungere Routes

```php
// ❌ SBAGLIATO
Route::post('/api/chart/export', [ChartExportController::class, 'export']);
```

### ❌ NON Usare Services

```php
// ❌ SBAGLIATO
class ChartExportService
{
    public function exportPng() { }
}
```

---

## ✅ Pattern Corretto

### ✅ Usa Actions (Spatie QueueableActions)

```php
// ✅ CORRETTO
class SaveChartJsPngAction
{
    use QueueableAction;
    
    public function execute(QuestionChart $questionChart, string $imageBase64): string
    {
        // Logica export
    }
}
```

### ✅ Usa Metodi Livewire nel Widget

```php
// ✅ CORRETTO
class QuestionChartItemWidget extends XotBaseChartWidget
{
    public function saveChartJsPng(string $imageBase64): void
    {
        app(SaveChartJsPngAction::class)
            ->execute($this->getQuestionChart(), $imageBase64);
    }
}
```

### ✅ Usa JavaScript Alpine.js

```javascript
// ✅ CORRETTO
Alpine.data('chartWithExport', (config) => {
    return {
        exportChart(format) {
            @this.call('saveChartJsPng', pngBase64);
        }
    };
});
```

---

## 📚 Riferimenti

- [Action Pattern Guidelines](../../.ai/guidelines/action-pattern.md)
- [Filament Widgets Documentation](https://filamentphp.com/docs/widgets)
- [Alpine.js Documentation](https://alpinejs.dev/)
- [Chart.js Export Documentation](./chartjs-export-step-by-step.md)

---

## 🔧 Troubleshooting

### Problema: Export non funziona

**Soluzione**:
1. Verifica che il widget usi la view custom
2. Controlla console browser per errori JavaScript
3. Verifica che `QuestionChart` esista e sia valido
4. Controlla permessi filesystem su `public/chart/`

### Problema: PHPStan errors

**Soluzione**:
1. Usa sempre `Safe\` functions
2. Aggiungi type hints espliciti
3. Usa `Assert::` per type narrowing
4. Verifica Yoda conditions

---

## 📝 Note Finali

Questa implementazione segue rigorosamente l'architettura Laraxot:
- **Actions over Services**: Usa Spatie QueueableActions
- **Filament First**: Tutto tramite Filament, nessun controller
- **Type Safety**: PHPStan livello 10
- **DRY + KISS**: Codice semplice e riutilizzabile


# Server-Side Chart Generation Actions

> **Purpose**: Generate chart images (PNG/SVG) in background jobs (Queueable Actions) for email attachments or PDF reports.

## 📋 Prerequisites

Since PHP cannot execute JavaScript (required for Chart.js), we use **Standard Headless Browser** approach.

```bash
composer require spatie/browsershot
npm install puppeteer
```

---

## 📸 Action 1: Generate PNG (Best for Email/PDF)

This action renders the chart widget in a headless browser and takes a screenshot.

### The Action Class

```php
namespace Modules\UI\Actions\Chart;

use Spatie\QueueableAction\QueueableAction;
use Spatie\Browsershot\Browsershot;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\View;

class GenerateChartPngAction
{
    use QueueableAction;

    /**
     * @param string $widgetClass Full class name of the Filament Chart Widget
     * @param array $data Data to pass to the widget mount method
     */
    public function execute(string $widgetClass, array $data = [], string $filename = 'chart.png'): string
    {
        // 1. Render the Widget to HTML
        // We wrap it in a minimal HTML structure to ensure Chart.js loads
        $html = View::make('ui::charts.headless-wrapper', [
            'widget' => $widgetClass,
            'data' => $data,
        ])->render();

        // 2. Use Browsershot to capture screenshot
        $screenshot = Browsershot::html($html)
            ->windowSize(800, 400)
            ->deviceScaleFactor(2) // High Res implementation
            ->waitUntilNetworkIdle()
            ->fullPage()
            ->screenshot(); // Returns raw binary content

        return $screenshot;
    }
}
```

### The Wrapper View (`ui::charts.headless-wrapper`)

You need a Blade view that loads the scripts but **no UI Chrome**.

```blade
<!DOCTYPE html>
<html>
<head>
    {{-- Load standard scripts --}}
    @filamentScripts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white">
    {{-- Render the widget --}}
    @livewire($widget, $data)
</body>
</html>
```

---

## 🎨 Action 2: Generate SVG (Advanced)

Getting SVG from Chart.js is complex because it renders to `<canvas>` (bitmap). To get SVG, we must:
1.  Use `Browsershot` to render the page.
2.  Inject a library like `canvas2svg` or use `chart.js` config to output SVG if a specific plugin is used.
3.  **Alternative**: Use `QuickChart.io` API if acceptable.

**Recommended "KISS" Approach for Vector**:
If you strictly need vector (SVG), do NOT use Chart.js + Browsershot. Use a server-side charting library that outputs SVG natively (like `svg-charts` or `QuickChart`).

However, if you must assume Chart.js, here is the theoretical implementation using Browsershot script injection:

```php
public function execute(string $widgetClass): string
{
    // ... setup Browsershot ...

    // We execute JS to extract the SVG serialization
    // *Requires chartjs-plugin-save-svg or similar loaded in the wrapper*
    $svg = Browsershot::html($html)
        ->waitUntilNetworkIdle()
        ->evaluate("document.querySelector('canvas').toDataURL('image/svg+xml')");

    return $svg;
}
```

> **Warning**: Chart.js Canvas-to-SVG is flaky. **We strongly recommend using High-Res PNG (scale factor 3) instead of SVG** for almost all report use cases. It looks perfect in PDFs and is 10x more reliable.

---

## 🚀 Usage Example

```php
use Modules\UI\Actions\Chart\GenerateChartPngAction;

class SendReportAction
{
    use QueueableAction;

    public function execute(User $user)
    {
        // 1. Generate Chart Image
        $chartPng = app(GenerateChartPngAction::class)->execute(
            widgetClass: MonthlySalesChart::class,
            data: ['userId' => $user->id]
        );

        // 2. Attach to Email
        // ... (See PDF/Email Guide)
    }
}
```

# Shared Hosting Chart Strategy (No NPM/Node)

> **Purpose**: Generate chart images in background jobs on **Shared Hosting environments** where you cannot install Node.js/Puppeteer (`browsershot` is not an option).

## ⚠️ Privacy Warning
This method uses an external API (**QuickChart.io**).
-   **Your data leaves the server.**
-   Do **NOT** use this for strictly confidential data (PII, financial secrets) unless you host your own QuickChart instance or trust the service.
-   The Community Edition of QuickChart is open source and can be self-hosted on a cheap VPS or Docker container if needed.

## 🛠️ The Solution: Remote Rendering API

Instead of rendering the chart locally with Headless Chrome, we send the chart configuration (JSON) to a remote service which returns the image.

### Dependencies
No strict dependencies, just standard `Guzzle` (included in Laravel).

---

## 📸 Action: Generate PNG via API

This action reads the data from your Filament Chart Widget and calls the API.

### The Action Class

```php
namespace Modules\UI\Actions\Chart;

use Spatie\QueueableAction\QueueableAction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Http;
use ReflectionMethod;

class GenerateChartPngViaApiAction
{
    use QueueableAction;

    /**
     * @param string $widgetClass The class of the Filament Widget
     */
    public function execute(string $widgetClass, int $width = 800, int $height = 400): string
    {
        // 1. Instantiate the Widget to get its Data
        // Note: We use Reflection because getData() is usually protected
        $widget = new $widgetClass();

        $reflection = new ReflectionMethod($widgetClass, 'getData');
        $reflection->setAccessible(true);
        $data = $reflection->invoke($widget);

        $reflectionType = new ReflectionMethod($widgetClass, 'getType');
        $reflectionType->setAccessible(true);
        $type = $reflectionType->invoke($widget);

        // 2. Prepare Config for QuickChart (Chart.js compatible)
        $chartConfig = [
            'type' => $type,
            'data' => $data,
            'options' => [
                'plugins' => [
                    // Disable animations for static image
                    'datalabels' => ['display' => true],
                ],
            ],
        ];

        // 3. Call API
        $response = Http::get('https://quickchart.io/chart', [
            'width' => $width,
            'height' => $height,
            'c' => json_encode($chartConfig),
        ]);

        if ($response->failed()) {
            throw new \Exception('QuickChart API failed: ' . $response->body());
        }

        // Returns binary image data (PNG)
        return $response->body();
    }
}
```

## 🚀 Usage Example

```php
use Modules\UI\Actions\Chart\GenerateChartPngViaApiAction;

class SendReportAction
{
    use QueueableAction;

    public function execute()
    {
        // 1. Generate via API
        $pngBinary = app(GenerateChartPngViaApiAction::class)->execute(
            widgetClass: MonthlySalesChart::class
        );

        // 2. Save or Attach
        Storage::put('reports/chart.png', $pngBinary);
    }
}
```

---

## 🆚 Comparison

| Feature | Browsershot (Node) | QuickChart API (Shared Hosting) |
| :--- | :--- | :--- |
| **Environment** | VPS / Dedicated | Shared Hosting / Any |
| **Setup** | Complex (Node, Puppeteer) | Zero (PHP only) |
| **Privacy** | Local (Secure) | External (Data leaves server) |
| **Consistency** | Perfect (Uses your CSS/Blade) | Good (Uses standard Chart.js) |
| **Speed** | Slow (Boots Chrome) | Fast (Optimized Service) |

**Recommendation**: Use **Browsershot** if you have a VPS. Use **QuickChart** ONLY if you are constrained by shared hosting.

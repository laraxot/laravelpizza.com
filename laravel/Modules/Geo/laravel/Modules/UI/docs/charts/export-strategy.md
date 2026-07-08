# Chart Export Strategy (PNG/SVG)

> **Goal**: Allow users to download Filament charts as images (PNG) or vectors (SVG) for reports.

## 1. Primary Strategy: PNG via Client-Side JS

This is the most robust and simplest method. It uses the browser's ability to convert the HTML5 Canvas to an image.

### How Implementing

You need to interact with the underlying Chart.js instance.

#### A. The JavaScript Helper

Create a helper function in your JS asset:

```javascript
// resources/js/chart-export.js

export function exportChart(chartInstanceId, filename = 'chart.png') {
    const chart = Filament.getChart(chartInstanceId); // Hypothetical helper if Filament exposes it
    // OR find canvas directly if strictly standard
    const canvas = document.getElementById(chartInstanceId).querySelector('canvas');

    if (!canvas) {
        console.error('Canvas not found for export');
        return;
    }

    // Convert to Data URL
    const image = canvas.toDataURL('image/png', 1.0);

    // Trigger Download
    const link = document.createElement('a');
    link.download = filename;
    link.href = image;
    link.click();
}
```

#### B. The Filament Widget View

Override the widget view to add an export button.

```blade
{{-- resources/views/filament/widgets/my-chart-widget.blade.php --}}
<x-filament-widgets::widget>
    <x-filament::card>
        {{-- Header with Export Button --}}
        <div class="flex items-center justify-between gap-8">
            <h2 class="text-lg font-bold">{{ $this->getHeading() }}</h2>
            <x-filament::button
                size="xs"
                color="gray"
                icon="heroicon-m-arrow-down-tray"
                id="export-{{ $this->getId() }}"
                onclick="exportChart(this.closest('.filament-widget').querySelector('canvas'), '{{ Str::slug($this->getHeading()) }}.png')"
            >
                Export PNG
            </x-filament::button>
        </div>

        {{-- The Chart --}}
        <div class="h-64">
            {{-- Standard Filament Chart rendering --}}
             <canvas x-ref="canvas" ...></canvas>
        </div>
    </x-filament::card>
</x-filament-widgets::widget>
```

## 2. SVG Export (Complex)

Standard generic `<canvas>` does not export to SVG. To get SVG, you need to swap the rendering engine of Chart.js to use something like `canvas2svg` or use a backend generation service.

**Recommendation**: **Avoid SVG** unless strictly necessary for print professionals.
-   **Why?**: Requires replacing the Chart.js renderer or heavy custom JS libraries that might conflict with Filament's Alpine.js wrappers.
-   **Alternative**: Generate High-Res PNG (pass scale factor to `toDataURL` if creating custom implementation, usually limited by browser though).

## 3. Server-Side Export (Node/Puppeteer)

If you need to attach the chart to a PDF report generated on the backend (e.g. `html2pdf` or `spatie/browsershot`):

1.  **Do not render chart on server**: PHP cannot render Chart.js (it's JS).
2.  **Solution**:
    -   Render page with `browsershot` (Headless Chrome), capture screenshot/PDF.
    -   OR send the data to a specialized microservice (QuickChart.io compatible).

**Our Standard**: Use **Client-Side PNG Export** for UI interactions. Use **QuickChart.io** (or self-hosted version) if you need to embed charts in generated backend PDFs.

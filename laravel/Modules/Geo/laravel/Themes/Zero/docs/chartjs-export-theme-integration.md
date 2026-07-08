# 🎨 CHART.JS EXPORT INTEGRATION - TEMA ZERO

## 📋 INDICE
1. [Integrazione Tema Zero](#-integrazione-tema-zero)
2. [Stili Chart Export](#-stili-chart-export)
3. [Componenti Tema Personalizzati](#-componenti-tema-personalizzati)
4. [Asset Management](#-asset-management)
5. [Configurazione Vite Tema](#-configurazione-vite-tema)

---

## 🎯 INTEGRAZIONE TEMA ZERO (Tema Zero Integration)

### **1. Struttura File Tema per Chart Export**
```
Themes/Zero/
├── resources/
│   ├── views/
│   │   ├── components/
│   │   │   ├── chart-export.blade.php          # Componente base
│   │   │   ├── chart-export-card.blade.php     # Versione card
│   │   │   ├── chart-export-modal.blade.php    # Versione modal
│   │   │   └── chart-export-dashboard.blade.php # Dashboard integration
│   │   ├── layouts/
│   │   │   ├── app.blade.php                    # Layout principale
│   │   │   └── pdf.blade.php                    # Layout PDF
│   │   └── partials/
│   │       ├── chart-scripts.blade.php         # Scripts comuni
│   │       └── chart-styles.blade.php          # Stili comuni
│   ├── js/
│   │   ├── services/
│   │   │   ├── chartjs-base-service.js         # Servizio base
│   │   │   ├── chart-export-service.js         # Export SVG
│   │   │   ├── png-export-service.js           # Export PNG
│   │   │   └── batch-export-service.js         # Batch export
│   │   ├── components/
│   │   │   ├── ChartExport.js                  # Componente Vue/Alpine
│   │   │   └── ChartExportModal.js             # Modal component
│   │   └── chart-export-main.js                # Entry point
│   ├── css/
│   │   ├── chart-export.css                    # Stili specifici
│   │   └── chart-export-responsive.css         # Responsive
│   └── lang/
│       ├── it/charts.php                        # Traduzioni IT
│       ├── en/charts.php                        # Traduzioni EN
│       └── de/charts.php                        # Traduzioni DE
├── theme.json                                   # Configurazione tema
└── README.md                                    # Documentazione tema
```

### **2. Configurazione Tema Zero**
```json
// Themes/Zero/theme.json
{
    "name": "Zero",
    "version": "2.0.0",
    "description": "Tema minimalista con Chart.js Export integration",
    "author": "Laraxot Team",
    "license": "MIT",
    "active": true,
    "order": 0,
    "dependencies": {
        "chart.js": "^4.4.0",
        "html2canvas": "^1.4.1",
        "file-saver": "^2.0.5",
        "chartjs-plugin-datalabels": "^2.2.0"
    },
    "features": {
        "chart_export": true,
        "svg_export": true,
        "png_export": true,
        "batch_export": true,
        "pdf_integration": true,
        "multi_language": true,
        "responsive": true,
        "dark_mode": true
    },
    "assets": {
        "css": [
            "resources/css/chart-export.css",
            "resources/css/chart-export-responsive.css"
        ],
        "js": [
            "resources/js/chart-export-main.js"
        ]
    },
    "views": {
        "components": [
            "chart-export",
            "chart-export-card",
            "chart-export-modal"
        ],
        "layouts": [
            "app",
            "pdf"
        ]
    }
}
```

---

## 🎨 STILI CHART EXPORT (Chart Export Styles)

### **1. CSS Principale Tema Zero**
```css
/* Themes/Zero/resources/css/chart-export.css */

/* Chart Container Base Styles */
.chart-container {
    position: relative;
    background: var(--zero-bg-primary, #ffffff);
    border-radius: var(--zero-border-radius, 0.5rem);
    box-shadow: var(--zero-shadow-sm, 0 1px 2px rgba(0, 0, 0, 0.05));
    overflow: hidden;
    transition: all 0.3s ease;
}

.chart-container:hover {
    box-shadow: var(--zero-shadow-md, 0 4px 6px rgba(0, 0, 0, 0.1));
    transform: translateY(-2px);
}

/* Chart Canvas */
.chart-canvas {
    display: block;
    max-width: 100%;
    height: auto !important;
    padding: var(--zero-chart-padding, 1rem);
}

/* Export Panel Styles */
.chart-export-panel {
    background: var(--zero-bg-secondary, #f8f9fa);
    border-top: 1px solid var(--zero-border-color, #dee2e6);
    padding: var(--zero-spacing-md, 1rem);
}

.export-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--zero-spacing-sm, 0.75rem);
}

.export-header h6 {
    margin: 0;
    font-weight: var(--zero-font-weight-semibold, 600);
    color: var(--zero-text-primary, #212529);
    font-size: var(--zero-font-size-sm, 0.875rem);
}

.export-badges {
    display: flex;
    gap: var(--zero-spacing-xs, 0.25rem);
}

.export-badge {
    padding: 0.25rem 0.5rem;
    border-radius: var(--zero-border-radius-sm, 0.25rem);
    font-size: var(--zero-font-size-xs, 0.75rem);
    font-weight: var(--zero-font-weight-medium, 500);
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

.export-badge.svg {
    background: var(--zero-primary-100, #e3f2fd);
    color: var(--zero-primary-800, #1565c0);
}

.export-badge.png {
    background: var(--zero-success-100, #e8f5e8);
    color: var(--zero-success-800, #2e7d32);
}

.export-badge.png-hd {
    background: var(--zero-info-100, #e1f5fe);
    color: var(--zero-info-800, #0277bd);
}

/* Export Buttons */
.export-buttons {
    display: flex;
    gap: var(--zero-spacing-sm, 0.5rem);
    flex-wrap: wrap;
}

.export-btn {
    display: inline-flex;
    align-items: center;
    gap: var(--zero-spacing-xs, 0.25rem);
    padding: var(--zero-spacing-xs, 0.375rem) var(--zero-spacing-sm, 0.75rem);
    border: 1px solid transparent;
    border-radius: var(--zero-border-radius-sm, 0.25rem);
    font-size: var(--zero-font-size-xs, 0.75rem);
    font-weight: var(--zero-font-weight-medium, 500);
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
    min-width: 80px;
    justify-content: center;
}

.export-btn:hover {
    transform: translateY(-1px);
    box-shadow: var(--zero-shadow-sm, 0 2px 4px rgba(0, 0, 0, 0.1));
}

.export-btn:active {
    transform: translateY(0);
}

.export-btn svg {
    width: 14px;
    height: 14px;
}

.export-btn.primary {
    background: var(--zero-primary-500, #3b82f6);
    border-color: var(--zero-primary-500, #3b82f6);
    color: white;
}

.export-btn.primary:hover {
    background: var(--zero-primary-600, #2563eb);
    border-color: var(--zero-primary-600, #2563eb);
}

.export-btn.success {
    background: var(--zero-success-500, #10b981);
    border-color: var(--zero-success-500, #10b981);
    color: white;
}

.export-btn.success:hover {
    background: var(--zero-success-600, #059669);
    border-color: var(--zero-success-600, #059669);
}

.export-btn.info {
    background: var(--zero-info-500, #06b6d4);
    border-color: var(--zero-info-500, #06b6d4);
    color: white;
}

.export-btn.info:hover {
    background: var(--zero-info-600, #0891b2);
    border-color: var(--zero-info-600, #0891b2);
}

/* Advanced Options */
.export-advanced {
    margin-top: var(--zero-spacing-md, 1rem);
    border-top: 1px solid var(--zero-border-color, #dee2e6);
    padding-top: var(--zero-spacing-md, 1rem);
}

.export-advanced .form-group {
    margin-bottom: var(--zero-spacing-sm, 0.75rem);
}

.export-advanced .form-group:last-child {
    margin-bottom: 0;
}

.export-advanced label {
    display: block;
    margin-bottom: var(--zero-spacing-xs, 0.25rem);
    font-weight: var(--zero-font-weight-medium, 500);
    color: var(--zero-text-secondary, #6c757d);
    font-size: var(--zero-font-size-sm, 0.875rem);
}

.export-advanced select,
.export-advanced input[type="checkbox"] {
    width: 100%;
    padding: var(--zero-spacing-xs, 0.375rem) var(--zero-spacing-sm, 0.5rem);
    border: 1px solid var(--zero-border-color, #dee2e6);
    border-radius: var(--zero-border-radius-sm, 0.25rem);
    font-size: var(--zero-font-size-sm, 0.875rem);
    background: white;
}

.export-advanced select:focus {
    outline: none;
    border-color: var(--zero-primary-500, #3b82f6);
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
}

/* Progress Indicator */
.export-progress {
    background: var(--zero-bg-tertiary, #e9ecef);
    border-radius: var(--zero-border-radius-sm, 0.25rem);
    padding: var(--zero-spacing-sm, 0.75rem);
    margin-top: var(--zero-spacing-md, 1rem);
}

.export-progress .progress {
    height: 6px;
    background: var(--zero-bg-quaternary, #dee2e6);
    border-radius: 3px;
    overflow: hidden;
    margin-bottom: var(--zero-spacing-xs, 0.375rem);
}

.export-progress .progress-bar {
    height: 100%;
    background: linear-gradient(90deg, var(--zero-primary-500, #3b82f6), var(--zero-primary-600, #2563eb));
    transition: width 0.3s ease;
    border-radius: 3px;
}

.export-progress small {
    font-size: var(--zero-font-size-xs, 0.75rem);
    color: var(--zero-text-muted, #6c757d);
    display: block;
    text-align: center;
}

/* Dark Mode Support */
@media (prefers-color-scheme: dark) {
    :root {
        --zero-bg-primary: #1a1a1a;
        --zero-bg-secondary: #2d2d2d;
        --zero-bg-tertiary: #404040;
        --zero-bg-quaternary: #525252;
        --zero-text-primary: #ffffff;
        --zero-text-secondary: #a3a3a3;
        --zero-text-muted: #737373;
        --zero-border-color: #404040;
    }
    
    .chart-container {
        background: var(--zero-bg-primary);
    }
    
    .chart-export-panel {
        background: var(--zero-bg-secondary);
        border-top-color: var(--zero-border-color);
    }
    
    .export-advanced select,
    .export-advanced input[type="checkbox"] {
        background: var(--zero-bg-primary);
        border-color: var(--zero-border-color);
        color: var(--zero-text-primary);
    }
}

/* Animation Classes */
@keyframes exportPulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

.export-btn.exporting {
    animation: exportPulse 1.5s ease-in-out infinite;
    pointer-events: none;
    opacity: 0.7;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.export-advanced.show {
    animation: slideDown 0.3s ease-out;
}

/* Loading States */
.export-loading {
    position: relative;
    overflow: hidden;
}

.export-loading::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    animation: loadingShimmer 2s infinite;
}

@keyframes loadingShimmer {
    0% { left: -100%; }
    100% { left: 100%; }
}

/* Success/Error States */
.export-success {
    border-color: var(--zero-success-500, #10b981) !important;
    background: var(--zero-success-50, #ecfdf5) !important;
}

.export-error {
    border-color: var(--zero-danger-500, #ef4444) !important;
    background: var(--zero-danger-50, #fef2f2) !important;
}

/* Tooltip Styles */
.export-tooltip {
    position: relative;
}

.export-tooltip::before {
    content: attr(data-tooltip);
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    background: var(--zero-gray-800, #1f2937);
    color: white;
    padding: var(--zero-spacing-xs, 0.25rem) var(--zero-spacing-sm, 0.5rem);
    border-radius: var(--zero-border-radius-sm, 0.25rem);
    font-size: var(--zero-font-size-xs, 0.75rem);
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s ease;
    z-index: 1000;
}

.export-tooltip:hover::before {
    opacity: 1;
}
```

### **2. CSS Responsive per Tema Zero**
```css
/* Themes/Zero/resources/css/chart-export-responsive.css */

/* Mobile First Approach */
@media (max-width: 640px) {
    .chart-container {
        margin: var(--zero-spacing-sm, 0.5rem) 0;
    }
    
    .export-header {
        flex-direction: column;
        align-items: flex-start;
        gap: var(--zero-spacing-xs, 0.25rem);
    }
    
    .export-buttons {
        flex-direction: column;
        gap: var(--zero-spacing-xs, 0.25rem);
    }
    
    .export-btn {
        width: 100%;
        justify-content: space-between;
    }
    
    .export-badges {
        flex-wrap: wrap;
    }
    
    .chart-canvas {
        padding: var(--zero-spacing-sm, 0.5rem);
    }
    
    .export-advanced {
        padding: var(--zero-spacing-sm, 0.75rem) var(--zero-spacing-xs, 0.375rem);
    }
}

@media (max-width: 768px) {
    .chart-export-panel {
        padding: var(--zero-spacing-sm, 0.75rem);
    }
    
    .export-header h6 {
        font-size: var(--zero-font-size-xs, 0.75rem);
    }
    
    .export-badge {
        font-size: var(--zero-font-size-2xs, 0.625rem);
        padding: 0.1875rem 0.375rem;
    }
    
    .export-btn {
        font-size: var(--zero-font-size-2xs, 0.625rem);
        padding: var(--zero-spacing-2xs, 0.25rem) var(--zero-spacing-xs, 0.5rem);
        min-width: 70px;
    }
    
    .export-btn svg {
        width: 12px;
        height: 12px;
    }
}

@media (max-width: 1024px) {
    .export-buttons {
        justify-content: center;
    }
    
    .export-advanced .form-group {
        display: flex;
        flex-direction: column;
        gap: var(--zero-spacing-2xs, 0.25rem);
    }
}

/* Tablet Specific */
@media (min-width: 768px) and (max-width: 1024px) {
    .chart-container {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: var(--zero-spacing-md, 1rem);
        align-items: start;
    }
    
    .chart-wrapper {
        grid-column: 1;
    }
    
    .chart-export-panel {
        grid-column: 2;
        width: 200px;
        position: sticky;
        top: var(--zero-spacing-lg, 1.5rem);
    }
    
    .export-buttons {
        flex-direction: column;
    }
    
    .export-btn {
        width: 100%;
    }
}

/* Desktop Optimizations */
@media (min-width: 1024px) {
    .chart-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .export-buttons {
        justify-content: flex-end;
    }
    
    .export-advanced {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: var(--zero-spacing-md, 1rem);
    }
    
    .export-advanced .form-group:last-child {
        grid-column: span 2;
    }
}

/* High DPI Displays */
@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
    .export-btn {
        border-width: 0.5px;
    }
    
    .chart-canvas {
        image-rendering: -webkit-optimize-contrast;
        image-rendering: crisp-edges;
    }
}

/* Print Styles */
@media print {
    .chart-export-panel {
        display: none !important;
    }
    
    .chart-container {
        box-shadow: none !important;
        border: 1px solid #000 !important;
        break-inside: avoid;
    }
    
    .chart-canvas {
        max-width: 100% !important;
        height: auto !important;
    }
}

/* Reduced Motion */
@media (prefers-reduced-motion: reduce) {
    .chart-container,
    .export-btn,
    .export-progress .progress-bar,
    .export-advanced.show {
        transition: none;
        animation: none;
    }
    
    .export-btn.exporting {
        animation: none;
    }
}

/* Touch Device Optimizations */
@media (hover: none) and (pointer: coarse) {
    .export-btn {
        min-height: 44px;
        padding: var(--zero-spacing-sm, 0.75rem) var(--zero-spacing-md, 1rem);
    }
    
    .export-buttons {
        gap: var(--zero-spacing-md, 1rem);
    }
    
    .export-advanced select,
    .export-advanced input[type="checkbox"] {
        min-height: 44px;
    }
}
```

---

## 🧩 COMPONENTI TEMA PERSONALIZZATI (Custom Theme Components)

### **1. Chart Export Card Component**
```blade
{{-- Themes/Zero/resources/views/components/chart-export-card.blade.php --}}
@props([
    'chartId' => 'required',
    'title' => null,
    'description' => null,
    'chartType' => 'line',
    'data' => [],
    'options' => [],
    'showExportControls' => true,
    'exportFormats' => ['svg', 'png', 'png-hd'],
    'cardClass' => '',
    'compact' => false,
])

<div class="chart-export-card {{ $cardClass }}" data-chart-id="{{ $chartId }}">
    {{-- Card Header --}}
    @if($title || $description)
        <div class="card-header">
            @if($title)
                <h5 class="card-title">{{ $title }}</h5>
            @endif
            @if($description)
                <p class="card-text text-muted">{{ $description }}</p>
            @endif
        </div>
    @endif

    {{-- Card Body --}}
    <div class="card-body">
        {{-- Chart Container --}}
        <div class="chart-wrapper {{ $compact ? 'compact' : '' }}">
            <canvas id="{{ $chartId }}" class="chart-canvas"></canvas>
        </div>

        {{-- Export Controls --}}
        @if($showExportControls)
            <div class="export-controls {{ $compact ? 'compact' : '' }}">
                <div class="export-header">
                    <span class="export-title">{{ __('charts.export_options') }}</span>
                    <div class="export-formats">
                        @foreach($exportFormats as $format)
                            <span class="format-badge {{ $format }}">{{ strtoupper($format) }}</span>
                        @endforeach
                    </div>
                </div>
                
                <div class="export-actions">
                    @foreach($exportFormats as $format)
                        <button 
                            type="button" 
                            class="btn btn-{{ $format === 'svg' ? 'primary' : ($format === 'png' ? 'success' : 'info') }} export-action"
                            data-chart="{{ $chartId }}"
                            data-format="{{ $format }}"
                        >
                            <i class="fas fa-{{ $format === 'svg' ? 'download' : ($format === 'png' ? 'image' : 'hdd') }}"></i>
                            {{ __('charts.export_' . $format) }}
                        </button>
                    @endforeach
                </div>

                @if(!$compact)
                    <button 
                        type="button" 
                        class="btn btn-outline-secondary btn-sm advanced-toggle"
                        data-target="advanced-{{ $chartId }}"
                    >
                        <i class="fas fa-cog"></i> {{ __('charts.advanced') }}
                    </button>
                    
                    <div class="advanced-options collapse" id="advanced-{{ $chartId }}">
                        <div class="advanced-content">
                            <div class="form-group">
                                <label>{{ __('charts.quality') }}</label>
                                <select class="form-control form-control-sm export-quality">
                                    <option value="standard">{{ __('charts.quality_standard') }}</option>
                                    <option value="high" selected>{{ __('charts.quality_high') }}</option>
                                    <option value="maximum">{{ __('charts.quality_maximum') }}</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>{{ __('charts.scale') }}</label>
                                <select class="form-control form-control-sm export-scale">
                                    <option value="1">1x</option>
                                    <option value="2" selected>2x</option>
                                    <option value="3">3x</option>
                                    <option value="4">4x</option>
                                </select>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>

    {{-- Progress Indicator --}}
    <div class="export-progress-overlay d-none" id="progress-{{ $chartId }}">
        <div class="progress-content">
            <div class="spinner-border spinner-border-sm" role="status">
                <span class="sr-only">{{ __('charts.exporting') }}</span>
            </div>
            <span class="progress-text">{{ __('charts.please_wait') }}</span>
        </div>
    </div>
</div>

{{-- Component Styles --}}
<style>
.chart-export-card {
    background: white;
    border-radius: var(--zero-border-radius-lg, 0.75rem);
    box-shadow: var(--zero-shadow-md, 0 4px 6px rgba(0, 0, 0, 0.1));
    overflow: hidden;
    transition: all 0.3s ease;
}

.chart-export-card:hover {
    box-shadow: var(--zero-shadow-lg, 0 10px 15px rgba(0, 0, 0, 0.1));
    transform: translateY(-2px);
}

.card-header {
    background: linear-gradient(135deg, var(--zero-primary-50, #eff6ff), var(--zero-primary-100, #dbeafe));
    border-bottom: 1px solid var(--zero-primary-200, #bfdbfe);
    padding: var(--zero-spacing-lg, 1.5rem);
}

.card-title {
    color: var(--zero-primary-800, #1e40af);
    font-weight: var(--zero-font-weight-bold, 700);
    margin: 0;
}

.card-body {
    padding: var(--zero-spacing-lg, 1.5rem);
}

.chart-wrapper.compact {
    max-height: 300px;
    overflow: hidden;
}

.export-controls.compact {
    background: var(--zero-gray-50, #f9fafb);
    padding: var(--zero-spacing-md, 1rem);
    border-top: 1px solid var(--zero-gray-200, #e5e7eb);
}

.export-title {
    font-weight: var(--zero-font-weight-semibold, 600);
    color: var(--zero-gray-700, #374151);
    font-size: var(--zero-font-size-sm, 0.875rem);
}

.export-formats {
    display: flex;
    gap: var(--zero-spacing-2xs, 0.25rem);
}

.format-badge {
    padding: 0.1875rem 0.5rem;
    border-radius: var(--zero-border-radius-full, 9999px);
    font-size: var(--zero-font-size-2xs, 0.625rem);
    font-weight: var(--zero-font-weight-medium, 500);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.format-badge.svg {
    background: var(--zero-primary-100, #dbeafe);
    color: var(--zero-primary-700, #1d4ed8);
}

.format-badge.png {
    background: var(--zero-success-100, #d1fae5);
    color: var(--zero-success-700, #047857);
}

.format-badge.png-hd {
    background: var(--zero-info-100, #cffafe);
    color: var(--zero-info-700, #0284c7);
}

.export-actions {
    display: flex;
    gap: var(--zero-spacing-sm, 0.5rem);
    margin-top: var(--zero-spacing-md, 1rem);
    flex-wrap: wrap;
}

.export-action {
    flex: 1;
    min-width: 100px;
    justify-content: center;
}

.advanced-toggle {
    width: 100%;
    margin-top: var(--zero-spacing-md, 1rem);
}

.advanced-options {
    margin-top: var(--zero-spacing-md, 1rem);
    border-top: 1px solid var(--zero-gray-200, #e5e7eb);
    padding-top: var(--zero-spacing-md, 1rem);
}

.advanced-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: var(--zero-spacing-md, 1rem);
}

.export-progress-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.progress-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: var(--zero-spacing-sm, 0.5rem);
}

.progress-text {
    font-size: var(--zero-font-size-sm, 0.875rem);
    color: var(--zero-gray-600, #4b5563);
    font-weight: var(--zero-font-weight-medium, 500);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .export-actions {
        flex-direction: column;
    }
    
    .export-action {
        width: 100%;
    }
    
    .advanced-content {
        grid-template-columns: 1fr;
    }
}
</style>

{{-- Component JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartId = '{{ $chartId }}';
    const chartData = @json($data);
    const chartOptions = @json($options);
    const chartType = '{{ $chartType }}';

    // Initialize chart
    const chartService = new ChartJsBaseService();
    const chart = chartService.createChart(chartId, {
        type: chartType,
        data: chartData,
        showLegend: chartOptions.showLegend ?? true,
        showDataLabels: chartOptions.showDataLabels ?? false,
    }, chartOptions);

    // Export actions
    document.querySelectorAll(`[data-chart="${chartId}"]`).forEach(button => {
        button.addEventListener('click', async function() {
            const format = this.dataset.format;
            const progressOverlay = document.getElementById(`progress-${chartId}`);
            
            // Show progress
            progressOverlay.classList.remove('d-none');
            this.classList.add('exporting');
            
            try {
                const exportService = new ChartExportService();
                
                switch (format) {
                    case 'svg':
                        await exportService.exportSVG(chartId, chart);
                        break;
                    case 'png':
                        await exportService.exportPNG(chartId, chart, { scale: 1 });
                        break;
                    case 'png-hd':
                        await exportService.exportPNG(chartId, chart, { scale: 2 });
                        break;
                }
            } catch (error) {
                console.error('Export failed:', error);
                alert('Export failed: ' + error.message);
            } finally {
                // Hide progress
                progressOverlay.classList.add('d-none');
                this.classList.remove('exporting');
            }
        });
    });

    // Advanced options toggle
    const advancedToggle = document.querySelector(`[data-target="advanced-${chartId}"]`);
    if (advancedToggle) {
        advancedToggle.addEventListener('click', function() {
            const advancedOptions = document.getElementById(`advanced-${chartId}`);
            advancedOptions.classList.toggle('show');
            
            this.innerHTML = advancedOptions.classList.contains('show') 
                ? '<i class="fas fa-times"></i> {{ __("charts.close_advanced") }}'
                : '<i class="fas fa-cog"></i> {{ __("charts.advanced") }}';
        });
    }
});
</script>
```

---

## 📦 ASSET MANAGEMENT (Asset Management)

### **1. Vite Configuration per Tema Zero**
```javascript
// Themes/Zero/vite.config.js
import { defineConfig } from 'vite';
import path from 'path';

export default defineConfig({
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources'),
            '@components': path.resolve(__dirname, 'resources/views/components'),
            '@js': path.resolve(__dirname, 'resources/js'),
            '@css': path.resolve(__dirname, 'resources/css'),
            '@chartjs': 'chart.js',
            '@export': './resources/js/services/chart-export/',
        },
    },
    build: {
        rollupOptions: {
            input: {
                'chart-export-main': path.resolve(__dirname, 'resources/js/chart-export-main.js'),
                'chart-export-styles': path.resolve(__dirname, 'resources/css/chart-export.css'),
            },
            output: {
                entryFileNames: 'js/[name].js',
                chunkFileNames: 'js/[name].js',
                assetFileNames: 'css/[name][extname]',
                manualChunks: {
                    'chart-vendor': ['chart.js', 'chartjs-adapter-date-fns', 'chartjs-plugin-datalabels'],
                    'export-vendor': ['html2canvas', 'file-saver'],
                    'chart-export': [
                        './resources/js/services/chartjs-base-service.js',
                        './resources/js/services/chart-export-service.js',
                        './resources/js/services/png-export-service.js',
                        './resources/js/services/batch-export-service.js',
                    ],
                },
            },
        },
        cssCodeSplit: true,
        sourcemap: process.env.NODE_ENV === 'development',
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: process.env.NODE_ENV === 'production',
                drop_debugger: process.env.NODE_ENV === 'production',
            },
        },
    },
    optimizeDeps: {
        include: [
            'chart.js',
            'chartjs-adapter-date-fns',
            'chartjs-plugin-datalabels',
            'html2canvas',
            'file-saver',
        ],
    },
    server: {
        hmr: {
            overlay: false,
        },
    },
    define: {
        __VUE_OPTIONS_API__: JSON.stringify(true),
        __VUE_PROD_DEVTOOLS__: JSON.stringify(false),
    },
});
```

### **2. Main JavaScript Entry Point**
```javascript
// Themes/Zero/resources/js/chart-export-main.js
import './services/chartjs-base-service.js';
import './services/chart-export-service.js';
import './services/png-export-service.js';
import './services/batch-export-service.js';

// Import Chart.js and dependencies
import Chart from 'chart.js/auto';
import 'chartjs-adapter-date-fns';
import ChartDataLabels from 'chartjs-plugin-datalabels';

// Import CSS
import '../css/chart-export.css';
import '../css/chart-export-responsive.css';

// Register plugins
Chart.register(ChartDataLabels);

// Global Chart.js configuration
Chart.defaults.font.family = "'Inter', 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif";
Chart.defaults.font.size = 12;
Chart.defaults.color = '#374151';
Chart.defaults.borderColor = '#e5e7eb';

// Export services globally
window.Chart = Chart;
window.ChartJsBaseService = window.ChartJsBaseService || class ChartJsBaseService {
    constructor() {
        this.charts = new Map();
        this.exportService = new window.ChartExportService();
        this.pngService = new window.PNGExportService();
        this.batchService = new window.BatchExportService();
    }

    createChart(canvasId, config, options = {}) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) {
            throw new Error(`Canvas element with id '${canvasId}' not found`);
        }

        const chartConfig = {
            type: config.type,
            data: config.data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuart',
                },
                plugins: {
                    legend: {
                        display: config.showLegend ?? true,
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: {
                                size: 12,
                            },
                        },
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: 'rgba(31, 41, 55, 0.9)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: '#4b5563',
                        borderWidth: 1,
                        cornerRadius: 6,
                        padding: 12,
                        displayColors: true,
                    },
                    datalabels: {
                        display: config.showDataLabels ?? false,
                        color: '#374151',
                        font: {
                            weight: 'bold',
                            size: 11,
                        },
                    },
                },
                ...options,
            },
        };

        const chart = new Chart(canvas, chartConfig);
        this.charts.set(canvasId, chart);
        
        return chart;
    }

    getChart(canvasId) {
        return this.charts.get(canvasId);
    }

    destroyChart(canvasId) {
        const chart = this.charts.get(canvasId);
        if (chart) {
            chart.destroy();
            this.charts.delete(canvasId);
        }
    }

    exportChart(canvasId, format, options = {}) {
        const chart = this.getChart(canvasId);
        if (!chart) {
            throw new Error(`Chart with id '${canvasId}' not found`);
        }

        switch (format) {
            case 'svg':
                return this.exportService.exportSVG(canvasId, chart, options);
            case 'png':
                return this.pngService.exportPNG(canvasId, chart, options);
            case 'png-hd':
                return this.pngService.exportPNG(canvasId, chart, { ...options, scale: 2 });
            default:
                throw new Error(`Unsupported format: ${format}`);
        }
    }

    exportAllCharts(formats = ['svg', 'png'], options = {}) {
        return this.batchService.exportAllCharts(formats, options);
    }
};

// Auto-initialize charts on page load
document.addEventListener('DOMContentLoaded', function() {
    // Find all chart containers with data-chart-config
    const chartContainers = document.querySelectorAll('[data-chart-config]');
    
    chartContainers.forEach(container => {
        try {
            const chartId = container.dataset.chartId || `chart-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;
            const chartConfig = JSON.parse(container.dataset.chartConfig);
            const chartOptions = JSON.parse(container.dataset.chartOptions || '{}');
            
            // Set canvas ID if not present
            const canvas = container.querySelector('canvas');
            if (canvas && !canvas.id) {
                canvas.id = chartId;
            }
            
            // Create chart
            const chartService = new window.ChartJsBaseService();
            chartService.createChart(chartId, chartConfig, chartOptions);
            
            // Store chart instance on container
            container.chartInstance = chartService.getChart(chartId);
            
        } catch (error) {
            console.error('Failed to initialize chart:', error);
        }
    });
    
    // Initialize export buttons
    const exportButtons = document.querySelectorAll('[data-export-chart]');
    exportButtons.forEach(button => {
        button.addEventListener('click', async function() {
            const chartId = this.dataset.exportChart;
            const format = this.dataset.exportFormat || 'svg';
            
            try {
                const chartService = new window.ChartJsBaseService();
                await chartService.exportChart(chartId, format);
            } catch (error) {
                console.error('Export failed:', error);
                alert('Export failed: ' + error.message);
            }
        });
    });
});

// Export for module usage
export { Chart, ChartJsBaseService };
```

---

## 🎯 CONFIGURAZIONE VITE TEMA (Vite Theme Configuration)

### **1. Laravel Mix Alternative (se usato)**
```javascript
// Themes/Zero/webpack.mix.js (alternative to Vite)
const mix = require('laravel-mix');
const path = require('path');

mix.setPublicPath('public/themes/zero')
    .js('resources/js/chart-export-main.js', 'js')
    .sass('resources/sass/chart-export.scss', 'css')
    .options({
        processCssUrls: false,
        postCss: [
            require('autoprefixer'),
            require('cssnano')({
                preset: 'default',
            }),
        ],
    })
    .webpackConfig({
        resolve: {
            alias: {
                '@': path.resolve(__dirname, 'resources'),
                '@components': path.resolve(__dirname, 'resources/views/components'),
                '@js': path.resolve(__dirname, 'resources/js'),
                '@css': path.resolve(__dirname, 'resources/css'),
            },
        },
        externals: {
            'chart.js': 'Chart',
        },
    })
    .sourceMaps()
    .version();

// Production optimizations
if (mix.inProduction()) {
    mix.options({
        terser: {
            terserOptions: {
                compress: {
                    drop_console: true,
                },
            },
        },
    });
}
```

### **2. Package.json del Tema**
```json
// Themes/Zero/package.json
{
    "name": "laraxot-theme-zero",
    "version": "2.0.0",
    "description": "Laraxot Zero Theme with Chart.js Export",
    "main": "resources/js/chart-export-main.js",
    "scripts": {
        "dev": "vite",
        "build": "vite build",
        "watch": "vite build --watch",
        "prod": "NODE_ENV=production vite build",
        "clean": "rimraf public/themes/zero/js public/themes/zero/css",
        "lint:js": "eslint resources/js --ext .js",
        "lint:css": "stylelint resources/css --ext .css",
        "format": "prettier --write resources/**/*.{js,css,blade.php}"
    },
    "dependencies": {
        "chart.js": "^4.4.0",
        "chartjs-adapter-date-fns": "^3.0.0",
        "chartjs-plugin-datalabels": "^2.2.0",
        "html2canvas": "^1.4.1",
        "file-saver": "^2.0.5"
    },
    "devDependencies": {
        "@vitejs/plugin-laravel": "^0.7.5",
        "autoprefixer": "^10.4.14",
        "cssnano": "^6.0.1",
        "eslint": "^8.44.0",
        "postcss": "^8.4.24",
        "prettier": "^3.0.0",
        "rimraf": "^5.0.1",
        "stylelint": "^15.7.0",
        "vite": "^4.4.0"
    },
    "browserslist": [
        "> 1%",
        "last 2 versions",
        "not dead",
        "not ie 11"
    ],
    "keywords": [
        "laraxot",
        "theme",
        "chart.js",
        "export",
        "svg",
        "png",
        "laravel"
    ],
    "author": "Laraxot Team",
    "license": "MIT",
    "repository": {
        "type": "git",
        "url": "https://github.com/laraxot/theme-zero.git"
    }
}
```

---

## 📚 RIEPILOGO INTEGRAZIONE TEMA

### **✅ Cosa Implementato nel Tema Zero**

1. **Struttura Completa Tema**
   - Organizzazione file ottimizzata
   - Componenti Blade riutilizzabili
   - Asset management con Vite

2. **Stili CSS Professional**
   - Design system coerente
   - Responsive design
   - Dark mode support
   - Animazioni e transizioni

3. **Componenti Avanzati**
   - Chart Export Card
   - Modal integration
   - Dashboard components
   - Loading states

4. **Asset Management**
   - Vite configuration
   - Code splitting
   - Tree shaking
   - Production optimization

5. **Multi-language Support**
   - Traduzioni IT/EN/DE
   - Localizzazione completa
   - Accessibility features

### **🚀 Come Usare il Tema**

1. **Installare il tema** in `Themes/Zero/`
2. **Configurare Vite** per build optimization
3. **Includere gli asset** nel layout principale
4. **Utilizzare i componenti** Blade nelle viste
5. **Personalizzare gli stili** secondo le esigenze

**Il Tema Zero fornisce una base solida e professionale per Chart.js Export!**

---

*Integrazione Tema Zero Chart.js Export - Laraxot Theme System*  
*Creato: 2025-11-17*  
*Autore: AI Assistant con tema production-ready*
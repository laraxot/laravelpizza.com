# LimeSurvey Charts PDF Integration - Zero Theme

**Created:** January 2026
**Author:** Claude Opus 4.5 (claude-opus-4-5-20251101)
**Version:** 1.0.0
**Status:** Production Ready

> Update 2026-03-09: this project follows a docs-first rule.
> Before code changes on PDF/chart flows, module and theme docs must be reviewed and improved.

---

## Table of Contents

1. [Overview](#overview)
2. [Architecture](#architecture)
3. [Theme Responsibilities](#theme-responsibilities)
4. [PDF Template Structure](#pdf-template-structure)
5. [Chart Styling for PDF](#chart-styling-for-pdf)
6. [Blade Components](#blade-components)
7. [Print CSS](#print-css)

---

## Overview

This document describes how the Zero theme integrates LimeSurvey survey charts into PDF exports. The theme provides:

- PDF templates for survey reports
- Chart styling consistency
- Print-optimized CSS
- Blade components for chart layouts

### Workflow

```
Survey Data (LimeSurvey)
    ↓
<nome progetto> Module (Dashboard + PDF orchestration)
    ↓
JpGraph (PNG Generation)
    ↓
Zero Theme (PDF Templates)
    ↓
Spipu Html2Pdf (PDF Generation)
    ↓
PDF Download
```

---

## Architecture

### Module Responsibilities

| Module/Theme | Responsibility |
|--------------|----------------|
| **Limesurvey** | Database access, models, question types |
| **<nome progetto>** | Business logic, chart widgets orchestration, PDF generation |
| **Chart** | JpGraph actions, Chart.js plugins, asset registration |
| **Zero Theme** | PDF templates, styling, Blade components |

### Theme Does NOT

- Generate chart images (that's <nome progetto>/Chart actions)
- Register Chart.js plugins (that's Chart module)
- Query LimeSurvey database (that's Limesurvey module)

### Theme DOES

- Provide PDF layout templates
- Define print-optimized CSS
- Create reusable Blade components for charts
- Ensure visual consistency in exports

---

## Theme Responsibilities

### 1. PDF Templates Location

```
Themes/Zero/
├── resources/
│   └── views/
│       └── pdf/
│           ├── layouts/
│           │   ├── base.blade.php         # Base PDF layout
│           │   └── landscape.blade.php    # Landscape orientation
│           ├── components/
│           │   ├── chart-container.blade.php
│           │   ├── chart-grid.blade.php
│           │   └── header-footer.blade.php
│           └── reports/
│               ├── survey-monthly.blade.php
│               └── survey-detailed.blade.php
```

### 2. Styling Files

```
Themes/Zero/
├── resources/
│   └── css/
│       └── pdf/
│           ├── base.css        # Base PDF styles
│           ├── charts.css      # Chart-specific styles
│           └── print.css       # Print media styles
```

---

## PDF Template Structure

### Base Layout

```html
<!-- Themes/Zero/resources/views/pdf/layouts/base.blade.php -->
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 15mm;
            size: A4 landscape;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10pt;
            color: #1e293b;
            line-height: 1.4;
        }

        .page-break {
            page-break-after: always;
        }

        /* Chart container styles */
        .chart-container {
            width: 100%;
            margin: 10px 0;
            text-align: center;
        }

        .chart-container img {
            max-width: 100%;
            height: auto;
        }

        /* Header styles */
        .report-header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #3b82f6;
        }

        .report-title {
            font-size: 18pt;
            font-weight: bold;
            color: #1e293b;
            margin: 0;
        }

        .report-subtitle {
            font-size: 11pt;
            color: #64748b;
            margin: 5px 0 0 0;
        }

        /* Footer styles */
        .report-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8pt;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 5px;
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="report-header">
        <h1 class="report-title">@yield('title', 'Survey Report')</h1>
        <p class="report-subtitle">@yield('subtitle')</p>
    </div>

    @yield('content')

    <div class="report-footer">
        Generated: {{ now()->format('d/m/Y H:i') }} | {{ config('app.name') }}
    </div>
</body>
</html>
```

### Survey Monthly Report

```html
<!-- Themes/Zero/resources/views/pdf/reports/survey-monthly.blade.php -->
@extends('zero::pdf.layouts.base')

@section('title', $survey_title ?? 'Monthly Survey Report')
@section('subtitle', "Period: {$date_from} - {$date_to}")

@section('styles')
<style>
    .chart-grid {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    .chart-row {
        display: table-row;
    }

    .chart-cell {
        display: table-cell;
        padding: 10px;
        vertical-align: top;
    }

    .chart-title {
        font-size: 11pt;
        font-weight: bold;
        color: #1e293b;
        margin-bottom: 8px;
        text-align: center;
    }

    .chart-description {
        font-size: 9pt;
        color: #64748b;
        margin-bottom: 10px;
        text-align: center;
    }

    .stats-summary {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 10px;
        margin: 10px 0;
    }

    .stats-item {
        display: inline-block;
        margin-right: 20px;
    }

    .stats-label {
        font-size: 9pt;
        color: #64748b;
    }

    .stats-value {
        font-size: 14pt;
        font-weight: bold;
        color: #1e293b;
    }

    .stats-value.excellent { color: #22c55e; }
    .stats-value.good { color: #3b82f6; }
    .stats-value.average { color: #fbbf24; }
    .stats-value.poor { color: #ef4444; }
</style>
@endsection

@section('content')
    {{-- Summary Statistics --}}
    <div class="stats-summary">
        <div class="stats-item">
            <span class="stats-label">Total Responses:</span>
            <span class="stats-value">{{ $total_responses ?? 0 }}</span>
        </div>
        <div class="stats-item">
            <span class="stats-label">Average Rating:</span>
            <span class="stats-value {{ $rating_class ?? '' }}">{{ number_format($avg_rating ?? 0, 1) }}/10</span>
        </div>
        <div class="stats-item">
            <span class="stats-label">Response Rate:</span>
            <span class="stats-value">{{ number_format($response_rate ?? 0, 1) }}%</span>
        </div>
    </div>

    {{-- Charts Grid --}}
    @foreach($chart_rows as $row)
        <div class="chart-grid">
            <div class="chart-row">
                @foreach($row as $chart)
                    <div class="chart-cell" style="width: {{ $chart->col_size ?? 50 }}%;">
                        @if($chart->title)
                            <div class="chart-title">{{ $chart->title }}</div>
                        @endif

                        @if($chart->description)
                            <div class="chart-description">{{ $chart->description }}</div>
                        @endif

                        <div class="chart-container">
                            @if($chart->img_src && file_exists(public_path($chart->img_src)))
                                <img src="{{ public_path($chart->img_src) }}" alt="{{ $chart->title ?? 'Chart' }}">
                            @else
                                <p style="color: #ef4444;">Chart image not available</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @if(!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
@endsection
```

---

## Chart Styling for PDF

### Color Palette (Consistent with Chart.js)

```css
/* Chart color variables for PDF */
:root {
    --chart-excellent: #22c55e;  /* Green - rating >= 8.5 */
    --chart-good: #3b82f6;       /* Blue - rating >= 7.5 */
    --chart-average: #fbbf24;    /* Amber - rating >= 6.0 */
    --chart-poor: #ef4444;       /* Red - rating < 6.0 */

    --chart-primary: #3b82f6;
    --chart-secondary: #64748b;
    --chart-background: #f8fafc;
    --chart-border: #e2e8f0;
}
```

### Chart Container Styles

```css
/* Themes/Zero/resources/css/pdf/charts.css */

.chart-container {
    position: relative;
    width: 100%;
    background: white;
    border: 1px solid var(--chart-border);
    border-radius: 8px;
    padding: 15px;
    box-sizing: border-box;
}

.chart-container img {
    display: block;
    margin: 0 auto;
    max-width: 100%;
    height: auto;
}

/* Full-width chart */
.chart-full {
    width: 100%;
}

/* Half-width chart (for 2-column layout) */
.chart-half {
    width: 48%;
    display: inline-block;
    vertical-align: top;
    margin: 1%;
}

/* Third-width chart (for 3-column layout) */
.chart-third {
    width: 31%;
    display: inline-block;
    vertical-align: top;
    margin: 1%;
}

/* Chart legend */
.chart-legend {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 10px;
    font-size: 9pt;
}

.chart-legend-item {
    display: flex;
    align-items: center;
    margin: 3px 10px;
}

.chart-legend-color {
    width: 12px;
    height: 12px;
    border-radius: 2px;
    margin-right: 5px;
}
```

---

## Blade Components

### Chart Container Component

```php
<!-- Themes/Zero/resources/views/components/pdf/chart-container.blade.php -->
@props([
    'title' => null,
    'description' => null,
    'width' => '100%',
    'imagePath' => null,
    'alt' => 'Chart'
])

<div class="chart-container" style="width: {{ $width }};">
    @if($title)
        <div class="chart-title">{{ $title }}</div>
    @endif

    @if($description)
        <div class="chart-description">{{ $description }}</div>
    @endif

    @if($imagePath && file_exists(public_path($imagePath)))
        <img src="{{ public_path($imagePath) }}" alt="{{ $alt }}">
    @else
        <div class="chart-placeholder">
            <p>Chart not available</p>
        </div>
    @endif

    {{ $slot }}
</div>
```

### Chart Grid Component

```php
<!-- Themes/Zero/resources/views/components/pdf/chart-grid.blade.php -->
@props([
    'columns' => 2
])

@php
    $columnClass = match((int)$columns) {
        1 => 'chart-full',
        2 => 'chart-half',
        3 => 'chart-third',
        default => 'chart-half',
    };
@endphp

<div class="chart-grid columns-{{ $columns }}">
    {{ $slot }}
</div>

<style>
    .chart-grid.columns-{{ $columns }} > .chart-container {
        @if($columns > 1)
            display: inline-block;
            width: {{ floor(100 / $columns) - 2 }}%;
            margin: 1%;
            vertical-align: top;
        @endif
    }
</style>
```

### Usage in PDF Template

```html
<!-- Example usage -->
@extends('zero::pdf.layouts.base')

@section('content')
    <x-zero::pdf.chart-grid :columns="2">
        <x-zero::pdf.chart-container
            title="Monthly Responses"
            :imagePath="$chart1->img_src"
            width="48%"
        />

        <x-zero::pdf.chart-container
            title="Average Ratings"
            :imagePath="$chart2->img_src"
            width="48%"
        />
    </x-zero::pdf.chart-grid>
@endsection
```

---

## Print CSS

```css
/* Themes/Zero/resources/css/pdf/print.css */

@media print {
    body {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .no-print {
        display: none !important;
    }

    .page-break {
        page-break-after: always;
    }

    .avoid-break {
        page-break-inside: avoid;
    }

    /* Ensure chart images print with colors */
    img {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    /* Chart container print styles */
    .chart-container {
        break-inside: avoid;
        page-break-inside: avoid;
    }

    /* Remove shadows for cleaner print */
    .chart-container,
    .stats-summary {
        box-shadow: none !important;
    }
}
```

---

## Template Mensile: Pattern Completo

### Template per Report Mensile con Chart

```blade
{{-- Themes/Zero/resources/views/pdf/reports/survey-monthly.blade.php --}}
@extends('zero::pdf.layouts.base')

@section('title', $surveyPdf->name ?? 'Monthly Survey Report')
@section('subtitle', "Period: {$dateFrom} - {$dateTo}")

@section('content')
    @foreach($questionCharts as $questionChart)
        <div style="page-break-inside: avoid; margin: 30px 0;">
            {{-- Titolo Domanda --}}
            <h2 style="font-size: 14pt; margin-bottom: 15px; color: #1e293b; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px;">
                {{ $questionChart->question->text ?? 'Domanda '.$questionChart->question_id }}
            </h2>
            
            {{-- Chart Image --}}
            @if(isset($chartImages[$questionChart->id]) && file_exists(public_path($chartImages[$questionChart->id])))
                <div style="text-align: center; margin: 20px 0;">
                    <img 
                        src="{{ public_path($chartImages[$questionChart->id]) }}" 
                        alt="Chart for {{ $questionChart->question->text }}"
                        style="width: 100%; max-width: 800px; height: auto; border: 1px solid #e2e8f0; border-radius: 4px;"
                    />
                </div>
            @endif
            
            {{-- Tabella Dati Mensili --}}
            <table style="width: 100%; margin-top: 20px; border-collapse: collapse; font-size: 10pt;">
                <thead>
                    <tr style="background-color: #f1f5f9;">
                        <th style="padding: 10px; border: 1px solid #e2e8f0; text-align: left;">Mese</th>
                        <th style="padding: 10px; border: 1px solid #e2e8f0; text-align: right;">Risposte</th>
                        <th style="padding: 10px; border: 1px solid #e2e8f0; text-align: right;">Media</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($monthlyData[$questionChart->id] ?? [] as $month)
                        <tr>
                            <td style="padding: 8px; border: 1px solid #e2e8f0;">{{ $month->month_label }}</td>
                            <td style="padding: 8px; border: 1px solid #e2e8f0; text-align: right;">{{ $month->response_count }}</td>
                            <td style="padding: 8px; border: 1px solid #e2e8f0; text-align: right;">
                                {{ $month->avg_value !== null ? number_format((float) $month->avg_value, 2, ',', '.') : 'N/A' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if(!$loop->last)
            <pagebreak />
        @endif
    @endforeach
@endsection
```

---

## Related Documentation

### Primary Guides
- [Guida Completa LimeSurvey Chart Widget](../../Modules/healthcare_app/docs/limesurvey-chart-widget-complete-guide.md) - ⭐ **PRINCIPALE**
- [JpGraph Deep Dive and Alternatives](../../Modules/Chart/docs/jpgraph-deep-dive-and-alternatives.md) - ⭐ **NUOVO** - Analisi approfondita JpGraph 4.4.3, alternative, confronto, e best practices

### Implementation Guides
- [Survey Chart Widget Implementation](../../Modules/healthcare_app/docs/survey-chart-widget-implementation.md)
- [PDF Generation Workflow](../../Modules/healthcare_app/docs/pdf-generation-workflow.md)
- [PDF Charts Integration Complete](../../Modules/Chart/docs/pdf-charts-limesurvey-integration-complete.md)
- [JpGraph Class Reference Complete](../../Modules/Chart/docs/jpgraph-class-reference-complete.md) - ⭐ **NUOVO** - Guida completa Class Reference basata su documentazione ufficiale
- [JpGraph Complete Guide](../../Modules/Chart/docs/jpgraph-complete-guide.md) - Guida completa JpGraph con esempi pratici

### Official JpGraph Resources
- [JpGraph Official Site](https://jpgraph.net/) - Sito ufficiale
- [JpGraph Documentation Portal](https://jpgraph.net/download/manuals) - Tutorial 750+ pagine
- [JpGraph Class Reference](https://jpgraph.net/download/manuals/classref/index.html) - ⭐ **RIFERIMENTO PRINCIPALE** - Class Reference completa ufficiale
- [JpGraph HowTo's](https://jpgraph.net/doc/howto.php) - Guide pratiche
- [JpGraph FAQ](https://jpgraph.net/doc/faq.php) - Domande frequenti

---

**Last Updated:** January 2026  
**Maintainer:** Laraxot Team + Auto (AI Coding Assistant)  
**Livello:** Approfondito con pattern reali dal codebase

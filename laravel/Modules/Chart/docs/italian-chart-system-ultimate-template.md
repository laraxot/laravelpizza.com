# 🎯 Italian Chart System - Ultimate Template & Guide

## 📋 Overview

The Italian Chart System represents the pinnacle of professional chart development in the Quaeris Fila5 Mono project. This comprehensive system implements DRY+KISS principles with perfect dual-label patterns, Italian localization, and professional color schemes.

## 🎨 Design Principles

### 1. **Italian Professional Color Palette**
- **Verde**: `hsla(142, 70%, 50%, 0.8)` - Success, positive metrics
- **Blu**: `hsla(217, 70%, 50%, 0.8)` - Neutral, primary data
- **Rosso**: `hsla(0, 70%, 50%, 0.8)` - Alerts, negative metrics
- **Ambra**: `hsla(38, 70%, 50%, 0.8)` - Warning, moderate values
- **Viola**: `hsla(262, 70%, 50%, 0.8)` - Special categories
- **Arancione**: `hsla(28, 70%, 50%, 0.8)` - Energy, activity
- **Turchese**: `hsla(188, 70%, 50%, 0.8)` - Information, communication
- **Grigio**: `hsla(220, 10%, 50%, 0.8)` - Neutral, secondary data

### 2. **Perfect Dual-Label Pattern**
```
Label 1 (Primary): Uses Number(v) parameter - positioned with anchor/align
Label 2 (Secondary): Uses ctx.dataset.customProperty - no offset manual
```

### 3. **DRY+KISS Implementation**
- Centralized business logic in `ChartService`
- Reusable color generation methods
- Consistent Italian localization
- Standardized JavaScript patterns

## 🚀 Quick Start Template

### UltimateChartWidgetTemplate.php
```php
<?php

declare(strict_types=1);

namespace Modules\Quaeris\Filament\Widgets;

use Filament\Support\RawJs;
use Modules\Quaeris\Services\ChartService;
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

/**
 * UltimateChartWidgetTemplate - Perfect Italian Chart Widget.
 *
 * This template represents the GOLD STANDARD for all chart widgets in the Quaeris project.
 * 
 * Features:
 * - ✅ Perfect dual-label pattern (no overlaps)
 * - ✅ Italian professional color palette
 * - ✅ ChartService integration (DRY+KISS)
 * - ✅ RawJs::make() with heredoc (BEST PRACTICE)
 * - ✅ PHPStan Level 10 compliance
 * - ✅ Complete documentation
 */
class UltimateChartWidgetTemplate extends XotBaseChartWidget
{
    /**
     * Get heading via automatic translation.
     */
    public function getHeading(): ?string
    {
        return static::trans('navigation.heading');
    }

    /**
     * Dataset configuration using ChartService for professional Italian UX.
     */
    protected function getData(): array
    {
        $chartService = new ChartService();
        
        // Your primary data (e.g., sales, ratings, values)
        $primaryData = [/* Your data here */];
        
        // Your secondary data (e.g., customer counts, votes, percentages)
        $secondaryData = [/* Your secondary data here */];
        
        // Generate professional Italian colors based on values
        $colors = $chartService->generateItalianColors($primaryData);

        return [
            'datasets' => [
                [
                    'label' => static::trans('fields.primary_metric'),
                    'data' => $primaryData,
                    'backgroundColor' => $colors,
                    'borderColor' => $chartService->generateItalianColors($primaryData, 1.0),
                    'borderWidth' => 1,
                    'voteCounts' => $secondaryData, // Custom property for secondary labels
                ],
            ],
            'labels' => $chartService->getItalianMonthLabels(count($primaryData)),
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // or 'line', 'doughnut', 'pie'
    }

    /**
     * Chart options with PERFECT dual-label pattern - NO MANUAL OFFSETS.
     */
    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<'JS'
        {
            plugins: {
                legend: { display: false },
                datalabels: {
                    clip: false,
                    clamp: true,
                    labels: {
                        // Label 1: Primary value - PERFECT PATTERN
                        primary: {
                            anchor: 'end',
                            align: 'top',
                            color: '#1e293b',
                            backgroundColor: 'rgba(255, 255, 255, 0.95)',
                            borderColor: 'rgba(148, 163, 184, 0.5)',
                            borderWidth: 1,
                            borderRadius: 6,
                            padding: 6,
                            font: { 
                                weight: '700', 
                                size: 11, 
                                family: 'system-ui, -apple-system, sans-serif' 
                            },
                            // ✅ CORRECT: Uses Number(v) parameter for primary data
                            formatter: function(v, ctx) {
                                var value = Number(v) || 0;
                                return value > 0 ? "€" + value.toLocaleString('it-IT') : '';
                            }
                        },
                        // Label 2: Secondary value - PERFECT PATTERN
                        secondary: {
                            anchor: 'end',
                            align: 'bottom',
                            color: '#64748b',
                            backgroundColor: 'rgba(241, 245, 249, 0.95)',
                            borderColor: 'rgba(148, 163, 184, 0.5)',
                            borderWidth: 1,
                            borderRadius: 6,
                            padding: 6,
                            font: { 
                                weight: '600', 
                                size: 11, 
                                family: 'system-ui, -apple-system, sans-serif' 
                            },
                            // ✅ CORRECT: Uses custom dataset property for secondary data
                            formatter: function(v, ctx) {
                                var voteCounts = ctx.dataset.voteCounts || [];
                                var count = voteCounts[ctx.dataIndex] || 0;
                                return count > 0 ? count.toLocaleString('it-IT') + ' unità' : '';
                            }
                        }
                    }
                }
            },
            layout: { 
                padding: { 
                    top: 35, 
                    bottom: 25,
                    right: 10,
                    left: 10
                } 
            },
            scales: {
                x: { 
                    grid: { display: false },
                    ticks: { 
                        color: 'rgba(100, 116, 139, 0.7)', 
                        font: { size: 11 } 
                    }
                },
                y: { 
                    beginAtZero: true,
                    grid: { 
                        color: 'rgba(0, 0, 0, 0.04)', 
                        drawBorder: false 
                    },
                    ticks: { 
                        color: 'rgba(100, 116, 139, 0.7)', 
                        font: { size: 11 } 
                    }
                }
            }
        }
    JS);
    }
}
```

## 📊 Widget Variations

### 1. **Sales Chart (Simple01ChartWidget)**
- **Pattern**: € Primary + Customer Counts Secondary
- **Colors**: Verde for positive sales
- **Labels**: Italian months (Gen, Feb, Mar...)

### 2. **Growth Trend Chart (Simple02ChartWidget)**
- **Pattern**: Value + Growth Percentage
- **Colors**: Blu with dynamic growth indicators
- **Features**: Line chart with smooth curves

### 3. **Rating Charts (Simple05, Simple06, Simple09, Simple13)**
- **Pattern**: Average Rating + Vote Counts
- **Colors**: Dynamic based on performance (Verde≥8.5, Blu≥7.5, etc.)
- **Features**: Star ratings and performance indicators

### 4. **Doughnut Chart (Simple11ChartWidget)**
- **Pattern**: Value + Percentage
- **Colors**: Full Italian palette
- **Features**: Center-aligned primary labels

### 5. **Percentage Charts (Simple20ChartWidget)**
- **Pattern**: Absolute Value + Percentage
- **Colors**: Professional Blu theme
- **Features**: Pre-calculated percentages

## 🔧 ChartService Integration

### Key Methods
```php
// Italian color palette
$colors = $chartService->getItalianColorPalette();

// Dynamic color generation based on values
$dynamicColors = $chartService->generateItalianColors($values);

// Italian labels
$months = $chartService->getItalianMonthLabels();
$weeks = $chartService->getItalianWeekLabels();

// Business logic
$stats = $chartService->calculateGrowthStatistics($data);
$percentage = $chartService->calculateGrowthPercentage($current, $previous);
```

## ✅ Quality Checklist

### Code Quality
- [ ] PHPStan Level 10 compliance
- [ ] Strict typing on all methods
- [ ] No mixed types allowed
- [ ] Complete PHPDoc documentation

### Chart Quality
- [ ] Perfect dual-label pattern (no overlaps)
- [ ] Italian professional colors
- [ ] RawJs::make() with heredoc
- [ ] Number(v) for primary values
- [ ] ctx.dataset.custom for secondary values

### UX Quality
- [ ] Italian localization
- [ ] Professional styling
- [ ] Responsive behavior
- [ ] Consistent spacing and fonts

## 🚀 Migration Guide

### From Old Pattern to New Pattern

#### ❌ OLD (Wrong - causes overlap)
```javascript
formatter: function(v, ctx) {
    var value = ctx.dataset.data[ctx.dataIndex] || 0;
    return "€" + value.toLocaleString("it-IT");
},
offset: 4 // Manual offset causes problems
```

#### ✅ NEW (Perfect - Ultimate pattern)
```javascript
formatter: function(v, ctx) {
    var value = Number(v) || 0;
    return value > 0 ? "€" + value.toLocaleString("it-IT") : '';
},
// No offset needed - anchor/align handle positioning
```

## 📈 Performance Optimization

### ChartService Features
- **Caching**: Built-in caching for expensive calculations
- **Lazy Loading**: Data loaded only when needed
- **Memory Efficient**: Minimal footprint with generators

### JavaScript Performance
- **Efficient Formatters**: Optimized for thousands of data points
- **Minimal DOM**: Only update what's necessary
- **Responsive Design**: Scales gracefully

## 🌍 Internationalization

### Italian First
All widgets prioritize Italian localization:
- Months: Gen, Feb, Mar...
- Numbers: Italian formatting (1.234,56)
- Colors: Italian cultural color meanings
- Labels: Professional Italian terminology

### Extensible
```php
// Easy to add other languages
public function getSpanishLabels(): array;
public function getEnglishLabels(): array;
```

## 🔮 Future Enhancements

### Planned Features
- [ ] Dark mode support
- [ ] Animated transitions
- [ ] Advanced tooltips
- [ ] Export functionality
- [ ] Real-time updates

### Extensibility
- [ ] Plugin system for custom formatters
- [ ] Theme customization
- [ ] Custom color palettes
- [ ] Advanced chart types

---

**Status**: PRODUCTION READY ✅  
**Version**: 2.0.0  
**Last Updated**: 2026-01-28  
**Maintainer**: Quaeris Development Team

This template represents the culmination of extensive research and development in creating the perfect chart widget system for professional Italian applications.
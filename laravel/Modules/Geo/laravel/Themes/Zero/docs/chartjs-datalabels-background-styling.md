# Chart UI/UX Enhancements with Background Styling and Positioning

## Overview
This document explains the UI/UX improvements made to chart datalabels using background styling and optimal positioning for better readability and visual appeal.

## Background Styling Implementation
The chart datalabels now use background styling to improve readability and visual hierarchy:

### Value Labels (Above Bars)
- **Background**: White with slight transparency (`rgba(255, 255, 255, 0.95)`)
- **Border**: Light gray border for definition
- **Border Radius**: 4px rounded corners
- **Padding**: 4px for comfortable spacing
- **Text Color**: Dark color (`#111827`) for high contrast
- **Position**: Centered above the bar using `'anchor' => 'end', 'align' => 'bottom', 'offset' => 8`

### Rank Labels (Below Bars)
- **Background**: Gray semi-transparent background (`rgba(75, 85, 99, 0.8)`)
- **Border**: Darker border for definition
- **Border Radius**: 4px rounded corners
- **Padding**: 4px balanced padding
- **Text Color**: White (`#ffffff`) for contrast
- **Position**: Centered below the bar using `'anchor' => 'end', 'align' => 'top', 'offset' => -8`

## Positioning Strategy
The dual label positioning uses Chart.js datalabels positioning system:
- Both labels are centered relative to the bar for visual balance
- `anchor: 'end'` positions labels at the end (top) of the bar
- `align: 'bottom'` aligns the value label to appear above the bar
- `align: 'top'` with `offset: -8` positions the rank label below the bar
- This creates a clean, professional appearance with consistent spacing

## Implementation Benefits
1. **Enhanced Readability**: Backgrounds ensure text is readable regardless of chart colors
2. **Visual Balance**: Symmetric positioning above and below bars creates better visual harmony
3. **Consistency**: Uniform styling and positioning approach across all chart widgets
4. **Accessibility**: Better contrast ratios and spacing for improved accessibility
5. **Professional Appearance**: More polished visual presentation compared to mixed positioning

## Example Configuration
```javascript
// Value label configuration
'value' => [
    'anchor' => 'end',
    'align' => 'top',
    'offset' => 6,
    'color' => '#111827',
    'backgroundColor' => 'rgba(255, 255, 255, 0.9)',
    'borderColor' => 'rgba(209, 213, 219, 0.8)',
    'borderWidth' => 1,
    'borderRadius' => 6,
    'padding' => 6,
    // ...
]

// Rank label configuration
'rank' => [
    'anchor' => 'center',
    'align' => 'center',
    'color' => '#ffffff',
    'backgroundColor' => 'rgba(0, 0, 0, 0.6)',
    'borderColor' => 'rgba(255, 255, 255, 0.4)',
    'borderWidth' => 1,
    'borderRadius' => 8,
    'padding' => 5,
    // ...
]
```

## Rating Information Display (Average + Voter Count)

For displaying rating information (e.g., average rating 0-10 and voter count), a stacked approach is used:

### Average Rating Label (Primary)
- **Position**: Higher above the bar using `offset: 14`
- **Background**: Clean white background (`rgba(255, 255, 255, 0.9)`)
- **Text**: Bold styling, 13px font, dark slate color (`#1e293b`)
- **Content**: Formatted as "Media: X.X" (e.g., "Media: 7.2")
- **Purpose**: Primary information displayed prominently

### Voter Count Label (Secondary)
- **Position**: Closer to the bar using `offset: 4`
- **Background**: Light gray background (`rgba(241, 245, 249, 0.85)`)
- **Text**: Medium weight, 11px font, muted slate color (`#64748b`)
- **Content**: Formatted as "Votanti: XX" (e.g., "Votanti: 45")
- **Purpose**: Supporting information displayed subtly

### Stacking Benefits
- **Logical Grouping**: Related information displayed close together
- **Visual Hierarchy**: Clear distinction between primary and secondary information
- **Quick Comprehension**: Users understand both quality (average) and quantity (count) at a glance
- **Consistent Layout**: Same positioning strategy applied across all rating charts

## DRY + KISS Principles
- **DRY**: Background styling configuration is standardized and reusable
- **KISS**: Simple configuration parameters for consistent results
- **Maintainable**: Easy to update styling across all charts by modifying parameters
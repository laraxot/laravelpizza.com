# SVG Icon Standards for Laraxot Modules

## 🎯 Design Principles

All SVG icons in Laraxot modules must follow these standards to ensure consistency, accessibility, and performance.

## 📋 Required Specifications

### 1. Basic Structure
```xml
<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" 
     fill="none" 
     viewBox="0 0 24 24" 
     stroke="currentColor"
     stroke-width="1.5"
     aria-hidden="true" 
     role="img">
    <!-- Content here -->
</svg>
```

### 2. Required Attributes
- `xmlns="http://www.w3.org/2000/svg"` - SVG namespace
- `fill="none"` - No fill (outline style)
- `viewBox="0 0 24 24"` - Standard 24x24 viewport
- `stroke="currentColor"` - Inherit text color
- `stroke-width="1.5"` - Consistent stroke weight
- `aria-hidden="true"` - Hide from screen readers
- `role="img"` - Proper semantic role

### 3. Animation Standards

#### Hover Animations (Required)
```css
<style>
    .icon-element {
        transition: all 0.3s ease-in-out;
    }
    svg:hover .icon-element {
        animation: bounce 1s ease-in-out infinite;
    }
    @keyframes bounce {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-2px); }
    }
    @media (prefers-reduced-motion: reduce) {
        .icon-element { animation: none; }
    }
</style>
```

#### Subtle Animations (Optional)
- Gentle floating/bouncing on hover
- Smooth transitions between states
- Respect reduced motion preferences

### 4. Dark Theme Support
```css
<style>
    /* Automatic dark theme adaptation */
    @media (prefers-color-scheme: dark) {
        svg {
            opacity: 0.9;
            filter: brightness(1.1);
        }
    }
</style>
```

### 5. File Naming Convention
- `icon.svg` - Primary module icon
- `icon1.svg` - First variation
- `icon2.svg` - Second variation  
- `icon3.svg` - Third variation
- `module-specific-name.svg` - Additional specialized icons

## 🎨 Design Guidelines

### Heroicons Outline Style
- **Stroke-based**: No fills, only strokes
- **Geometric**: Clean, simple shapes
- **Consistent**: 1.5px stroke width
- **Minimal**: Avoid unnecessary complexity
- **Recognizable**: Clear representation of module purpose

### Color Usage
- Use `currentColor` for all strokes
- No hardcoded colors
- Inherits from parent element's text color
- Automatically adapts to light/dark themes

### Size & Proportions
- **Viewport**: 24x24 units
- **Padding**: 2 units minimum around edges
- **Scale**: Elements should fill ~70-80% of viewport
- **Balance**: Visual weight distributed evenly

## ⚡ Performance Optimization

### File Size
- **Target**: < 2KB per icon
- **Optimize**: Remove unnecessary metadata
- **Minify**: Clean SVG code structure
- **Avoid**: Embedded images or complex filters

### Code Efficiency
```xml
<!-- GOOD: Minimal, efficient -->
<circle cx="12" cy="12" r="10" />

<!-- BAD: Redundant -->
<circle cx="12.000000" cy="12.000000" r="10.000000" 
        style="stroke: currentColor; stroke-width: 1.5;" />
```

## ♿ Accessibility

### ARIA Attributes
```xml
<svg aria-hidden="true" role="img">
    <!-- No descriptive text needed for decorative icons -->
</svg>
```

### Reduced Motion
```css
@media (prefers-reduced-motion: reduce) {
    * { animation: none !important; }
}
```

### High Contrast
- Ensure good contrast ratio
- Test with various background colors
- Maintain visibility in both themes

## 🔧 Validation Checklist

Before committing any SVG icon, verify:

1. [ ] File size < 2KB
2. [ ] Uses `currentColor` for strokes
3. [ ] No hardcoded colors or fills
4. [ ] Proper viewBox="0 0 24 24"
5. [ ] stroke-width="1.5"
6. [ ] aria-hidden="true" and role="img"
7. [ ] Includes hover animations
8. [ ] Respects reduced motion preferences
9. [ ] Dark theme compatible
10. [ ] Valid SVG syntax
11. [ ] No unnecessary metadata
12. [ ] Follows naming conventions

## 🚀 Quick Start Template

```xml
<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" 
     fill="none" 
     viewBox="0 0 24 24" 
     stroke="currentColor"
     stroke-width="1.5"
     aria-hidden="true" 
     role="img">
    
    <style>
        .icon-element {
            transition: all 0.3s ease-in-out;
        }
        svg:hover .icon-element {
            animation: float 1s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-2px); }
        }
        @media (prefers-reduced-motion: reduce) {
            .icon-element { animation: none; }
        }
        @media (prefers-color-scheme: dark) {
            svg { opacity: 0.9; }
        }
    </style>
    
    <!-- Your icon content here -->
    <g class="icon-element">
        <circle cx="12" cy="12" r="10" />
    </g>
    
</svg>
```

## 📚 Module-Specific Considerations

### Employee Module
- Use human figures, badges, time elements
- Represent HR/management concepts

### Tenant Module  
- Buildings, domains, multi-tenant concepts
- Architecture and infrastructure themes

### Geo Module
- Maps, locations, geography elements
- GPS and navigation symbols

### GDPR Module
- Privacy shields, consent dialogs
- Data protection symbols

### UI Module
- Interface elements, components
- Design system symbols

---

*Last Updated: 2025-08-27*  
*SVG Standards Version: 2.0*  
*Based on Heroicons Outline Style*
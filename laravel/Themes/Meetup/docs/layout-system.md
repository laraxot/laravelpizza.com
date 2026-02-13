# Layout System for Meetup Theme

## Overview
Comprehensive layout system for the Meetup theme following modern design principles and Laraxot architecture.

## Philosophy
- **Mobile-First**: Design for mobile, enhance for desktop
- **Component-Based**: Reusable layout components
- **Consistent Spacing**: 8px grid system
- **Responsive Breakpoints**: sm, md, lg, xl, 2xl

## Grid System

### Container Widths
```php
// Full width container
class="w-full max-w-7xl mx-auto"

// Standard container (max-w-6xl)
class="w-full max-w-6xl mx-auto px-4"

// Narrow container (max-w-4xl)
class="w-full max-w-4xl mx-auto px-4"

// Compact container (max-w-md)
class="w-full max-w-md mx-auto"
```

### Spacing Scale
```
0    0px
0.5  2px
1    4px
1.5  6px
2    8px
2.5  10px
3    12px
3.5  14px
4    16px
5    20px
6    24px
7    28px
8    32px
10   40px
12   48px
14   56px
16   64px
20   80px
24   96px
```

## Layout Patterns

### 1. Two-Column Layout (Register Page)
```php
<div class="flex flex-col lg:flex-row gap-12 lg:gap-20 items-center justify-center w-full">
    {{-- Left Column: Content --}}
    <div class="text-center lg:text-left space-y-8 w-full max-w-lg mx-auto">
        <!-- Content -->
    </div>

    {{-- Right Column: Form --}}
    <div class="bg-slate-800/90 backdrop-blur-xl shadow-2xl rounded-2xl p-8 sm:p-10 lg:p-12 border border-slate-700/50 w-full max-w-md mx-auto">
        <!-- Form -->
    </div>
</div>
```

**Key Features:**
- Flexbox for responsive layout
- Stack on mobile, side-by-side on desktop
- Center alignment on mobile, left-aligned on desktop
- Maximum width constraints for readability

### 2. Card Layout
```php
<div class="bg-slate-800/90 backdrop-blur-xl shadow-2xl rounded-2xl p-8 border border-slate-700/50">
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-white mb-2">Title</h2>
        <p class="text-sm text-slate-400">Description</p>
    </div>
    <!-- Content -->
</div>
```

### 3. Section Layout
```php
<section class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-slate-800 to-red-900 py-12 px-4">
    <div class="w-full max-w-7xl mx-auto">
        <!-- Content -->
    </div>
</section>
```

### 4. Grid Layout
```php
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Grid Items -->
</div>
```

## Breakpoints

### Tailwind Default Breakpoints
```
sm:  640px   (Small mobile)
md:  768px   (Tablet)
lg:  1024px  (Small desktop)
xl:  1280px  (Desktop)
2xl: 1536px (Large desktop)
```

### Responsive Patterns
```php
// Text sizing
text-base sm:text-lg lg:text-xl

// Padding
p-4 sm:p-6 lg:p-8

// Margins
mb-4 sm:mb-6 lg:mb-8

// Grid columns
grid-cols-1 sm:grid-cols-2 lg:grid-cols-3

// Flex direction
flex-col lg:flex-row
```

## Component Layouts

### Hero Section
```php
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Animated gradients -->
    </div>

    <!-- Content -->
    <div class="relative z-10 w-full max-w-7xl mx-auto px-4">
        <div class="text-center space-y-8">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold">
                <!-- Headline -->
            </h1>
            <p class="text-lg lg:text-xl">
                <!-- Subheadline -->
            </p>
            <!-- CTAs -->
        </div>
    </div>
</section>
```

### Form Layout
```php
<form wire:submit="submit" class="space-y-6">
    <!-- Section 1 -->
    <div class="space-y-5">
        <div>
            <h2 class="text-lg font-bold">Section Title</h2>
            <p class="mt-1 text-sm text-slate-400">Description</p>
        </div>
        <!-- Fields -->
    </div>

    <!-- Section 2 -->
    <div class="space-y-5">
        <!-- Fields -->
    </div>

    <!-- Submit -->
    <div class="pt-4 space-y-4">
        <button type="submit">Submit</button>
    </div>
</form>
```

### Navigation Layout
```php
<nav class="fixed top-0 left-0 right-0 z-50 bg-slate-900/95 backdrop-blur-md border-b border-white/20">
    <div class="w-full max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="/">Logo</a>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center gap-8">
                <!-- Menu Items -->
            </div>

            <!-- Mobile Menu Button -->
            <button class="lg:hidden">
                <!-- Hamburger Icon -->
            </button>
        </div>
    </div>
</nav>
```

## Spacing Guidelines

### Vertical Spacing
```php
// Section spacing
py-12 sm:py-16 lg:py-20

// Element spacing
space-y-4 sm:space-y-6 lg:space-y-8

// Margin bottom
mb-4 sm:mb-6 lg:mb-8
```

### Horizontal Spacing
```php
// Container padding
px-4 sm:px-6 lg:px-8

// Element gap
gap-4 sm:gap-6 lg:gap-8

// Padding
p-4 sm:p-6 lg:p-8
```

## Alignment Guidelines

### Text Alignment
```php
// Mobile centered, desktop left-aligned
text-center lg:text-left

// Always centered
text-center

// Always left-aligned
text-left
```

### Flex Alignment
```php
// Center items
flex items-center justify-center

// Left align on desktop
flex flex-col lg:flex-row items-center lg:items-start

// Space between
flex items-center justify-between
```

## Responsive Patterns

### Hide/Show Elements
```php
// Hide on mobile, show on desktop
hidden lg:block

// Show on mobile only
block lg:hidden

// Show on tablet and up
hidden md:block
```

### Conditional Layouts
```php
// Stack on mobile, side-by-side on desktop
flex flex-col lg:flex-row

// Full width on mobile, constrained on desktop
w-full lg:w-1/2

// Small text on mobile, larger on desktop
text-sm sm:text-base lg:text-lg
```

## Common Layout Mistakes

### 1. Not Testing on Mobile
```php
// ❌ WRONG - Only desktop optimized
class="w-1/2 text-left"

// ✅ CORRECT - Responsive
class="w-full lg:w-1/2 text-center lg:text-left"
```

### 2. Inconsistent Spacing
```php
// ❌ WRONG - Random spacing
class="mb-2 mt-4 px-3 py-5"

// ✅ CORRECT - Consistent scale
class="mb-4 px-4 py-4"
```

### 3. Not Using Container
```php
// ❌ WRONG - Full width without constraint
<div class="w-full">Content</div>

// ✅ CORRECT - Constrained width
<div class="w-full max-w-7xl mx-auto px-4">Content</div>
```

### 4. Ignoring Breakpoints
```php
// ❌ WRONG - No responsive design
class="text-2xl grid-cols-4"

// ✅ CORRECT - Responsive
class="text-xl sm:text-2xl lg:text-3xl grid-cols-1 sm:grid-cols-2 lg:grid-cols-4"
```

## Performance Optimization

### CSS Optimization
```php
// Use Tailwind utilities instead of custom CSS
// ✅ CORRECT
class="flex items-center justify-center gap-4"

// ❌ WRONG
style="display: flex; align-items: center; justify-content: center; gap: 16px;"
```

### Lazy Loading
```php
// Lazy load heavy components
@lazy
@component('heavy-component')
@endcomponent
@endlazy
```

## Testing Checklist

### Mobile (< 768px)
- [ ] Single column layout
- [ ] Touch targets ≥ 48×48px
- [ ] No horizontal scroll
- [ ] Readable text (16px minimum)
- [ ] Accessible navigation

### Tablet (768px - 1024px)
- [ ] Two-column layout works
- [ ] Grid columns adjust
- [ ] Padding/margins appropriate
- [ ] Navigation accessible

### Desktop (> 1024px)
- [ ] Full layout visible
- [ ] All content fits without scrolling
- [ ] Hover effects work
- [ ] Keyboard navigation

## Related Documentation
- [Color Palette](./color-palette.md)
- [Typography System](./typography.md)
- [Animations](./animations.md)
- [WCAG Accessibility](./wcag-accessibility.md)

## Credits
- Layout System: Tailwind CSS 4.x
- Grid System: 8px base unit
- Breakpoints: Tailwind default
- Philosophy: Mobile-first responsive design
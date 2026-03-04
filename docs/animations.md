# Animations System for Meetup Theme

## Overview
Animation system for the Laravel Pizza Meetup theme providing smooth, performant, and accessible micro-interactions.

## Philosophy
- **Purposeful**: Every animation has a clear purpose
- **Accessible**: Respects `prefers-reduced-motion`
- **Performant**: Uses GPU-accelerated properties
- **Subtle**: Enhances without distracting

## Animation Guidelines

### Duration Scale
```php
// Instant (100ms)
duration-100

// Fast (200ms)
duration-200

// Normal (300ms)
duration-300

// Slow (500ms)
duration-500

// Very Slow (700ms)
duration-700
```

### Easing Functions
```php
// Linear (no easing)
ease-linear

// In (starts slow)
ease-in

// Out (ends slow)
ease-out

// In-Out (both)
ease-in-out

// Custom (cubic-bezier)
ease-[cubic-bezier(0.4,0,0.2,1)]
```

## Core Animations

### Hover Effects
```php
// Scale up
hover:scale-105 transition-transform duration-200

// Scale down
hover:scale-95 transition-transform duration-200

// Translate right
hover:translate-x-1 transition-transform duration-200

// Translate up
hover:-translate-y-1 transition-transform duration-200

// Color change
hover:text-red-300 transition-colors duration-200

// Background change
hover:bg-red-600 transition-colors duration-200
```

### Focus Effects
```php
// Ring focus
focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-shadow duration-200

// Scale focus
focus:scale-105 transition-transform duration-200

// Outline focus
focus:outline-none focus:ring-2 focus:ring-red-500 transition-shadow duration-200
```

### Click Effects
```php
// Scale on active
active:scale-95 transition-transform duration-100

// Press effect
active:translate-y-0.5 active:scale-95 transition-all duration-100
```

### Loading States
```php
// Spinner
animate-spin

// Pulse
animate-pulse

// Bounce
animate-bounce
```

## Component Animations

### Buttons
```php
// Primary button with hover
<button class="
    bg-red-600 text-white
    hover:bg-red-500 hover:shadow-xl
    active:scale-95 active:shadow-lg
    focus:ring-2 focus:ring-red-500 focus:ring-offset-2
    transition-all duration-200
">
    Button Text
</button>
```

### Links
```php
// Link with hover effect
<a href="#" class="
    text-cyan-400
    hover:text-cyan-300 hover:underline
    focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 rounded
    transition-colors duration-200
">
    Link Text
</a>
```

### Cards
```php
// Card with hover lift
<div class="
    bg-slate-800 rounded-xl
    hover:-translate-y-1 hover:shadow-xl
    transition-transform duration-300
">
    Card Content
</div>
```

### Inputs
```php
// Input with focus ring
<input class="
    border-gray-300
    focus:border-red-500 focus:ring-2 focus:ring-red-500
    transition-all duration-200
">
```

### Modals
```php
// Modal with fade in
<div class="
    fixed inset-0 bg-black/50
    opacity-0 animate-[fadeIn_300ms_ease-out_forwards]
">
    Modal Content
</div>
```

### Dropdowns
```php
// Dropdown with slide down
<div class="
    absolute top-full left-0
    opacity-0 invisible
    group-hover:opacity-100 group-hover:visible
    transition-all duration-200
">
    Dropdown Items
</div>
```

## Background Animations

### Gradient Pulse
```php
// Subtle pulse
class="animate-pulse"
// Used for: loading states, placeholder content

// Custom pulse
class="animate-[pulse_2s_ease-in-out_infinite]"
```

### Floating Elements
```php
// Gentle float
class="animate-[float_3s_ease-in-out_infinite]"

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}
```

### Gradient Animation
```php
// Gradient shift
class="animate-gradient"

@keyframes gradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
```

### Blur Animation
```php
// Blur in
class="animate-[blur-in_500ms_ease-out]"

@keyframes blur-in {
    from {
        opacity: 0;
        filter: blur(10px);
    }
    to {
        opacity: 1;
        filter: blur(0);
    }
}
```

## Transitions

### Fade Transitions
```php
// Fade in
transition-opacity duration-300
opacity-0 hover:opacity-100

// Fade out
transition-opacity duration-300
opacity-100 hover:opacity-0
```

### Slide Transitions
```php
// Slide from bottom
translate-y-4 opacity-0
animate-[slide-up_300ms_ease-out]

@keyframes slide-up {
    from {
        transform: translateY(1rem);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
```

### Scale Transitions
```php
// Scale in
scale-95 opacity-0
animate-[scale-in_200ms_ease-out]

@keyframes scale-in {
    from {
        transform: scale(0.95);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}
```

## Loading Animations

### Spinner
```php
<svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
```

### Pulse Dots
```php
<div class="flex gap-1">
    <div class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></div>
    <div class="w-2 h-2 bg-red-500 rounded-full animate-pulse" style="animation-delay: 0.1s;"></div>
    <div class="w-2 h-2 bg-red-500 rounded-full animate-pulse" style="animation-delay: 0.2s;"></div>
</div>
```

### Skeleton Loading
```php
<div class="animate-pulse space-y-3">
    <div class="h-4 bg-slate-700 rounded w-3/4"></div>
    <div class="h-4 bg-slate-700 rounded w-1/2"></div>
    <div class="h-4 bg-slate-700 rounded w-5/6"></div>
</div>
```

## Interactive Animations

### Click Ripple
```php
// Material Design ripple effect
active:animate-[ripple_600ms_ease-out]

@keyframes ripple {
    0% {
        transform: scale(0);
        opacity: 1;
    }
    100% {
        transform: scale(4);
        opacity: 0;
    }
}
```

### Shake Animation
```php
// Error shake
animate-[shake_500ms_ease-in-out]

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-4px); }
    20%, 40%, 60%, 80% { transform: translateX(4px); }
}
```

### Success Checkmark
```php
// Success animation
animate-[checkmark_600ms_ease-in-out]

@keyframes checkmark {
    0% { transform: scale(0) rotate(0deg); }
    50% { transform: scale(1.2) rotate(45deg); }
    100% { transform: scale(1) rotate(45deg); }
}
```

## Accessibility

### Reduced Motion
```php
// Respect user preferences
@media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
        scroll-behavior: auto !important;
    }
}
```

### No Animation Preference
```php
// Provide option to disable
class="transition-all duration-200"
// Can be overridden with CSS custom properties
```

## Performance Optimization

### GPU Acceleration
```php
// Use transform and opacity
transform translate-x-1 translate-y-1 scale-105
opacity-0 hover:opacity-100

// Avoid layout triggers
// ❌ DON'T use
width height margin padding

// ✅ DO use
transform opacity filter
```

### Animation Performance
```php
// Use will-change sparingly
will-change transform

// Remove will-change when done
animationend -> remove will-change
```

### Lazy Loading
```php
// Load animations only when needed
@lazy
@component('animated-component')
@endcomponent
@endlazy
```

## Common Mistakes

### 1. Too Many Animations
```php
// ❌ WRONG - Animation chaos
hover:scale-105 hover:rotate-12 hover:skew-x-6 hover:blur-sm

// ✅ CORRECT - Single purpose
hover:scale-105
```

### 2. Too Slow
```php
// ❌ WRONG - Feels sluggish
transition-all duration-1000

// ✅ CORRECT - Snappy
transition-all duration-200
```

### 3. Not Respecting Reduced Motion
```php
// ❌ WRONG - Always animates
animate-pulse

// ✅ CORRECT - Respects preference
animate-pulse motion-reduce:animate-none
```

### 4. Layout Thrashing
```php
// ❌ WRONG - Triggers layout
hover:width-48 hover:height-48

// ✅ CORRECT - Uses transform
hover:scale-105
```

### 5. No Transition
```php
// ❌ WRONG - Abrupt change
hover:bg-red-600

// ✅ CORRECT - Smooth transition
hover:bg-red-600 transition-colors duration-200
```

## Animation Testing

### Performance
- [ ] Uses GPU-accelerated properties
- [ ] Respects `prefers-reduced-motion`
- [ ] No layout thrashing
- [ ] Smooth 60fps on target devices

### Accessibility
- [ ] Can be disabled
- [ ] Not disorienting
- [ ] Doesn't cause nausea
- [ ] Has sufficient contrast

### User Experience
- [ ] Purpose is clear
- [ ] Not distracting
- [ ] Enhances interaction
- [ ] Feels natural

## Related Documentation
- [Layout System](./layout-system.md)
- [Color Palette](./color-palette.md)
- [WCAG Accessibility](./wcag-accessibility.md)

## Credits
- Animation Library: Tailwind CSS built-in
- Philosophy: Subtle, purposeful, accessible
- Performance: GPU-accelerated properties only
- Duration: 100ms - 700ms scale
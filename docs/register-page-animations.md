# Register Page Animations System

## Overview
Animation system for the registration page optimized for performance, accessibility, and reduced motion support.

## Animation Principles

### Core Principles
1. **Purposeful**: Every animation serves a clear purpose
2. **Subtle**: Animations are gentle and don't distract
3. **Performant**: Use GPU-accelerated properties only
4. **Accessible**: Support reduced motion preferences
5. **Short**: Duration 200-500ms for optimal perception

### GPU-Accelerated Properties
```css
/* ✅ Safe to animate (GPU-accelerated) */
transform: translate3d(x, y, z);
transform: scale(x, y);
transform: rotate(deg);
opacity: 0.5;

/* ❌ Avoid animating (triggers reflow) */
width, height, top, left, right, bottom, margin, padding
```

## Animation Durations

### Duration Scale
```css
--duration-instant: 100ms;      /* Instant feedback */
--duration-fast: 200ms;         /* Quick transitions */
--duration-base: 300ms;         /* Standard transitions */
--duration-slow: 500ms;         /* Slow transitions */
--duration-slower: 700ms;       /* Very slow transitions */
```

### Use Cases
- **Button hover**: 200ms (fast)
- **Form focus**: 200ms (fast)
- **Page load**: 500ms (slow)
- **Background elements**: 2000ms (ambient)
- **Loading states**: 1000ms (loop)

## Animation Easings

### Easing Functions
```css
/* Linear (no easing) */
easing-linear: cubic-bezier(0, 0, 1, 1);

/* Ease (natural) */
easing-ease: cubic-bezier(0.4, 0, 0.2, 1);

/* Ease In (accelerating) */
easing-ease-in: cubic-bezier(0.4, 0, 1, 1);

/* Ease Out (decelerating) */
easing-ease-out: cubic-bezier(0, 0, 0.2, 1);

/* Ease In Out (accelerating then decelerating) */
easing-ease-in-out: cubic-bezier(0.4, 0, 0.2, 1);
```

### Tailwind Easing
```css
/* Default easings */
duration-75
duration-100
duration-200
duration-300
duration-500
duration-700
duration-1000

/* Default easings */
ease-linear
ease-in
ease-out
ease-in-out
```

## Page Load Animations

### Fade In Sequence
```css
/* Staggered fade in */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in-up {
  animation: fadeInUp 0.5s ease-out forwards;
}
```

### Stagger Delays
```css
/* Stagger children */
.children-stagger > *:nth-child(1) { animation-delay: 0ms; }
.children-stagger > *:nth-child(2) { animation-delay: 100ms; }
.children-stagger > *:nth-child(3) { animation-delay: 200ms; }
.children-stagger > *:nth-child(4) { animation-delay: 300ms; }
```

## Background Animations

### Floating Pizza Emojis
```css
/* Gentle float animation */
@keyframes floatPizza {
  0%, 100% {
    transform: translateY(0px) rotate(0deg);
  }
  50% {
    transform: translateY(-20px) rotate(5deg);
  }
}

.animate-float-pizza {
  animation: floatPizza 6s ease-in-out infinite;
}

/* Different durations for variety */
.animate-float-pizza-1 { animation-duration: 6s; }
.animate-float-pizza-2 { animation-duration: 8s; }
.animate-float-pizza-3 { animation-duration: 7s; }
.animate-float-pizza-4 { animation-duration: 9s; }
```

### Animated Gradient Blobs
```css
/* Pulsing blob */
@keyframes pulseBlob {
  0%, 100% {
    transform: scale(1);
    opacity: 0.3;
  }
  50% {
    transform: scale(1.2);
    opacity: 0.2;
  }
}

.animate-pulse-blob {
  animation: pulseBlob 4s ease-in-out infinite;
}

/* Moving blob */
@keyframes moveBlob {
  0% {
    transform: translate(0, 0) rotate(0deg);
  }
  33% {
    transform: translate(30px, -30px) rotate(120deg);
  }
  66% {
    transform: translate(-20px, 20px) rotate(240deg);
  }
  100% {
    transform: translate(0, 0) rotate(360deg);
  }
}

.animate-move-blob {
  animation: moveBlob 10s linear infinite;
}
```

### Geometric Shapes
```css
/* Rotating square */
@keyframes rotateSquare {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}

.animate-rotate-square {
  animation: rotateSquare 20s linear infinite;
}

/* Floating triangle */
@keyframes floatTriangle {
  0%, 100% {
    transform: translateY(0) translateX(0);
  }
  25% {
    transform: translateY(-15px) translateX(10px);
  }
  75% {
    transform: translateY(10px) translateX(-10px);
  }
}

.animate-float-triangle {
  animation: floatTriangle 8s ease-in-out infinite;
}
```

## Interactive Animations

### Button Hover
```css
/* Hover scale effect */
@keyframes buttonHover {
  from {
    transform: scale(1);
  }
  to {
    transform: scale(1.02);
  }
}

.hover\:scale-102:hover {
  transform: scale(1.02);
  transition: transform 200ms ease-out;
}
```

### Input Focus
```css
/* Focus ring animation */
@keyframes focusRing {
  0% {
    box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4);
  }
  100% {
    box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.2);
  }
}

.input-focus-ring:focus-visible {
  animation: focusRing 200ms ease-out forwards;
}
```

### Card Hover
```css
/* Card lift effect */
.card-lift {
  transition: transform 200ms ease-out, box-shadow 200ms ease-out;
}

.card-lift:hover {
  transform: translateY(-4px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}
```

## Form Animations

### Error Shake
```css
/* Shake animation for errors */
@keyframes shake {
  0%, 100% {
    transform: translateX(0);
  }
  10%, 30%, 50%, 70%, 90% {
    transform: translateX(-5px);
  }
  20%, 40%, 60%, 80% {
    transform: translateX(5px);
  }
}

.animate-shake {
  animation: shake 500ms ease-in-out;
}
```

### Success Checkmark
```css
/* Success checkmark animation */
@keyframes checkmark {
  0% {
    stroke-dashoffset: 100;
  }
  100% {
    stroke-dashoffset: 0;
  }
}

.animate-checkmark {
  stroke-dasharray: 100;
  animation: checkmark 500ms ease-out forwards;
}
```

### Loading Spinner
```css
/* Simple spinner */
@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}

.animate-spin {
  animation: spin 1s linear infinite;
}
```

## Transitions

### Transition Shortcuts
```css
/* Common transitions */
.transition-all { transition: all 200ms ease-out; }
.transition-transform { transition: transform 200ms ease-out; }
.transition-opacity { transition: opacity 200ms ease-out; }
.transition-colors { transition: colors 200ms ease-out; }
.transition-shadow { transition: box-shadow 200ms ease-out; }
```

### Custom Transitions
```css
/* Smooth hover */
.smooth-hover {
  transition: transform 200ms ease-out, opacity 200ms ease-out;
}

/* Slow fade */
.slow-fade {
  transition: opacity 500ms ease-out;
}

/* Quick scale */
.quick-scale {
  transition: transform 150ms ease-out;
}
```

## Reduced Motion Support

### Media Query
```css
@media (prefers-reduced-motion: reduce) {
  /* Disable all animations */
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

### Reduced Motion Classes
```css
/* Force reduced motion */
@media (prefers-reduced-motion: reduce) {
  .no-reduced-motion {
    animation: none !important;
    transition: none !important;
  }
}

/* Enable reduced motion */
@media (prefers-reduced-motion: no-preference) {
  .with-motion {
    animation: fadeInUp 0.5s ease-out;
  }
}
```

## Animation Performance

### Performance Tips
1. **Use transform and opacity only**
2. **Avoid layout thrashing**
3. **Use will-change sparingly**
4. **Batch DOM reads and writes**
5. **Use CSS animations over JavaScript**

### Performance Monitoring
```javascript
// Measure animation performance
const start = performance.now();

// Start animation

const end = performance.now();
console.log(`Animation took ${end - start}ms`);

// Check for dropped frames
const frame = requestAnimationFrame(() => {
  console.log('Frame rendered');
});
```

### Animation Optimization
```css
/* Hint to browser about animated properties */
.animated-element {
  will-change: transform, opacity;
}

/* Remove hint after animation */
.animated-element.finished {
  will-change: auto;
}
```

## Animation Best Practices

### Dos
- ✅ Use GPU-accelerated properties (transform, opacity)
- ✅ Keep animations short (200-500ms)
- ✅ Use appropriate easing functions
- ✅ Support reduced motion preferences
- ✅ Test animations on low-end devices
- ✅ Use CSS animations instead of JavaScript
- ✅ Provide visual feedback for interactions

### Don'ts
- ❌ Don't animate layout properties (width, height, margin)
- ❌ Don't use long animations (> 500ms for UI)
- ❌ Don't animate too many elements simultaneously
- ❌ Don't use animations without purpose
- ❌ Don't ignore reduced motion preferences
- ❌ Don't cause layout thrashing
- ❌ Don't overuse animations (can be distracting)

## Animation Testing Checklist

- [ ] Animations are smooth (60fps)
- [ ] Animations serve a clear purpose
- [ ] Reduced motion is supported
- [ ] Animations are not distracting
- [ ] Animations have appropriate duration
- [ ] Animations use appropriate easing
- [ ] Animations work on low-end devices
- [ ] Animations don't cause layout shifts
- [ ] Animations are accessible to screen readers
- [ ] Animations don't cause motion sickness

## References
- [Web Animations API](https://developer.mozilla.org/en-US/docs/Web/API/Web_Animations_API)
- [CSS Animations](https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Animations)
- [Reduced Motion](https://developer.mozilla.org/en-US/docs/Web/CSS/@media/prefers-reduced-motion)
- [Animation Performance](https://web.dev/animations-guide/)
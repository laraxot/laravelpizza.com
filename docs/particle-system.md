# Particle System - Zero Gravity Background Animation

## Overview

The LaravelPizza Meetup theme includes an interactive particle system that creates a zero-gravity background effect with mouse interaction, inspired by Google's Antigravity experience.

## Features

- **80 floating particles** in brand colors (red, orange, cyan, violet, pink)
- **Zero-gravity simulation** - particles float freely in random directions
- **Mouse repulsion effect** - particles react and move away from cursor
- **Smooth physics** - acceleration, friction, and velocity limits
- **Particle connections** - lines drawn between nearby particles
- **Responsive** - adapts to window size automatically
- **Performance optimized** - uses requestAnimationFrame for 60fps
- **Accessibility** - canvas has `aria-hidden="true"` to avoid screen reader interference

## Physics Model

### Zero-Gravity Movement

Particles follow these physics rules:

```javascript
// Velocity update with acceleration
particle.vx += Math.cos(angle) * force * acceleration;
particle.vy += Math.sin(angle) * force * acceleration;

// Apply friction to prevent infinite acceleration
particle.vx *= friction;  // 0.98
particle.vy *= friction;  // 0.98

// Minimum speed to keep particles moving (zero-gravity effect)
if (currentSpeed < minSpeed) {
    particle.vx += (Math.random() - 0.5) * 0.1;
    particle.vy += (Math.random() - 0.5) * 0.1;
}
```

### Mouse Repulsion

When the mouse is near a particle:

```javascript
const distance = Math.sqrt(dx * dx + dy * dy);

if (distance < mouseRadius) {
    const force = (mouseRadius - distance) / mouseRadius;
    const angle = Math.atan2(dy, dx);
    
    // Push particle away from mouse
    particle.vx += Math.cos(angle) * force * acceleration * 5;
    particle.vy += Math.sin(angle) * force * acceleration * 5;
}
```

### Particle Properties

```javascript
{
    x: position_x,
    y: position_y,
    vx: velocity_x,
    vy: velocity_y,
    radius: particle_size,
    color: 'rgba(239, 68, 68, 0.8)',
    originalRadius: base_size,
    alpha: opacity
}
```

## Configuration

### Default Settings

```javascript
{
    particleCount: 80,           // Number of particles
    baseRadius: 2,              // Minimum particle size
    maxRadius: 4,               // Maximum particle size
    baseSpeed: 0.5,             // Base floating speed
    mouseRadius: 150,           // Mouse interaction radius
    acceleration: 0.05,         // Force multiplier
    friction: 0.98,             // Velocity dampening
    colors: [                   // Brand color palette
        'rgba(239, 68, 68, 0.8)',    // red-500
        'rgba(249, 115, 22, 0.8)',   // orange-500
        'rgba(6, 182, 212, 0.8)',    // cyan-500
        'rgba(139, 92, 246, 0.8)',   // violet-500
        'rgba(236, 72, 153, 0.8)'    // pink-500
    ]
}
```

### Customization

To customize the particle system, edit `resources/js/particles.js`:

```javascript
// Initialize with custom options
const particleSystem = new ParticleSystem({
    particleCount: 120,         // More particles
    baseRadius: 3,              // Larger particles
    mouseRadius: 200,           // Bigger interaction area
    colors: [
        'rgba(34, 197, 94, 0.8)',   // green-500
        'rgba(59, 130, 246, 0.8)'   // blue-500
    ]
});

particleSystem.init();
```

## File Structure

```
Themes/Meetup/
├── resources/
│   ├── css/
│   │   └── app.css                    # Particle canvas styles
│   ├── js/
│   │   └── particles.js               # Particle system logic
│   └── views/
│       └── components/layouts/
│           └── main.blade.php         # Canvas element
└── public_html/themes/Meetup/
    └── assets/
        └── app-*.js                    # Bundled JavaScript
```

## CSS Styling

```css
.particle-canvas {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;    /* Doesn't block interactions */
    z-index: 0;              /* Behind content */
    opacity: 0.6;            /* Subtle effect */
}

.has-particles .particle-canvas {
    pointer-events: auto;    /* Enable mouse interaction */
}
```

## Browser Compatibility

- ✅ Chrome/Edge 90+
- ✅ Firefox 88+
- ✅ Safari 14+
- ✅ Opera 76+

**Note:** Requires HTML5 Canvas support (widely supported).

## Performance Considerations

### Optimization Techniques

1. **RequestAnimationFrame** - Ensures smooth 60fps animation
2. **Efficient distance calculations** - Uses squared distance when possible
3. **Limited connections** - Only draws lines between particles within 100px
4. **Canvas layering** - Uses single canvas for all particles
5. **Minimal state changes** - Groups similar operations

### Performance Metrics

- **Target FPS:** 60
- **Particles:** 80 (adjustable based on performance)
- **Connection distance:** 100px (reduces calculations)
- **Canvas updates:** Full clear with fade effect for trails

### Monitoring Performance

```javascript
// Check frame rate
const startTime = performance.now();
let frameCount = 0;

function animate() {
    frameCount++;
    update();
    draw();
    
    const elapsed = performance.now() - startTime;
    const fps = Math.round((frameCount / elapsed) * 1000);
    
    if (frameCount % 60 === 0) {
        console.log(`FPS: ${fps}`);
    }
    
    requestAnimationFrame(() => animate());
}
```

## Accessibility

The particle system is designed to be accessibility-friendly:

1. **`aria-hidden="true"`** - Canvas is hidden from screen readers
2. **No keyboard focus** - Particles don't interfere with navigation
3. **Reduced motion support** - Respects `prefers-reduced-motion` preference
4. **No flashing content** - Particles move smoothly without flashing

### Reduced Motion Support

```css
@media (prefers-reduced-motion: reduce) {
    .particle-canvas {
        display: none;  /* Hide particles for users who prefer reduced motion */
    }
}
```

## Troubleshooting

### Particles Not Showing

1. Check browser console for JavaScript errors
2. Verify canvas element exists in DOM
3. Ensure JavaScript bundle is loaded
4. Check if canvas has valid dimensions

### Performance Issues

1. Reduce `particleCount` in configuration
2. Increase `friction` to slow particles
3. Reduce `connectionDistance` in `drawConnections()`
4. Disable particle connections entirely

### Mobile Performance

For better mobile performance:

```javascript
// Detect mobile and reduce particles
const isMobile = window.innerWidth < 768;
const mobileParticleCount = isMobile ? 40 : 80;

const particleSystem = new ParticleSystem({
    particleCount: mobileParticleCount
});
```

## Inspiration

This particle system is inspired by:

- **Google Antigravity** - Zero-gravity UI floating effect
- **Particle.js** - Lightweight particle library
- **Canvas Physics** - Physics-based animations on HTML5 Canvas

## Future Enhancements

Potential improvements for the particle system:

1. **Click interactions** - Particles react to clicks
2. **Gravity control** - User can adjust gravity strength
3. **Color themes** - Different color palettes for pages
4. **Particle shapes** - Support for circles, squares, triangles
5. **Particle trails** - Longer trail effects
6. **Particle bursts** - Explosion effects on interaction
7. **Sound integration** - Audio feedback on particle interaction
8. **3D particles** - Three.js integration for depth

## Related Documentation

- `animation-usage.md` - General animation guidelines
- `wcag-accessibility-guide.md` - Accessibility requirements
- `color-palette-guidelines.md` - Brand color usage

## Credits

- **Based on:** Zero-gravity physics concepts from Antigravity
- **Implementation:** Vanilla JavaScript + HTML5 Canvas
- **Performance:** requestAnimationFrame for smooth 60fps
- **Colors:** LaravelPizza Meetup brand palette

---

**
**Maintained By:** LaravelPizza Theme Team  
**Status:** Production Ready ✅
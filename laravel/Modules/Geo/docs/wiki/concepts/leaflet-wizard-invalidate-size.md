# Leaflet Map in Wizard - InvalidateSize Rule

## Problem
Leaflet map appears blank (gray tiles) when used inside Filament wizard steps because:

1. Wizard steps use `display: none` to hide inactive steps
2. Leaflet initializes while container is hidden → 0x0 dimensions
3. Map tiles never load or render properly

## Solution

### InvalidateSize Call

```javascript
// After wizard step becomes visible
this._observer = new IntersectionObserver(
    entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting && this._map) {
                setTimeout(() => this._map.invalidateSize(), 100);
            }
        });
    },
    { threshold: 0.1 }
);
```

### Why 100ms timeout?
- Allows DOM/CSS transitions to complete
- Ensures container has correct dimensions
- Prevents flickering or layout thrashing

### Full Component Example

```javascript
export class CoordinatePickerLit extends LitElement {
    firstUpdated() {
        this._observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting && this._map) {
                    setTimeout(() => this._map.invalidateSize(), 100);
                }
            });
        }, { threshold: [0, 0.1, 0.5, 1] });
    }

    connectedCallback() {
        super.connectedCallback();
        const container = this.querySelector('.map-container');
        if (container) {
            this._observer.observe(container);
        }
    }

    disconnectedCallback() {
        this._observer?.disconnect();
        super.disconnectedCallback();
    }
}
```

## CSS Requirements

```css
/* Map container must have defined dimensions */
.map-container {
    height: 400px;
    width: 100%;
    position: relative;
}

/* Prevent map from inheriting hidden styles */
.map-container[hidden] {
    display: block !important;
    visibility: hidden;
}
```

## Alternative: MutationObserver

For cases where IntersectionObserver isn't sufficient:

```javascript
this._mutationObserver = new MutationObserver(() => {
    if (this.offsetParent !== null) {
        setTimeout(() => this._refreshMapSize(), 150);
    }
});

// Observe parent elements up the DOM tree
let parent = this.parentElement;
for (let i = 0; i < 6 && parent; i++) {
    this._mutationObserver.observe(parent, {
        attributes: true,
        attributeFilter: ['class', 'style', 'hidden']
    });
    parent = parent.parentElement;
}
```

## Testing

### Manual Test Steps
1. Open ticket creation wizard
2. Navigate to map step
3. Verify map tiles load correctly
4. Test zoom/pan interactions
5. Navigate away and return
6. Verify map still works

### Automated Checks
```javascript
// Test that invalidateSize is called
const mapElement = await page.locator('.leaflet-container');
await expect(mapElement).toBeVisible();
const width = await mapElement.evaluate(el => el.clientWidth);
expect(width).toBeGreaterThan(0);
```

## Related Files

- `laravel/Modules/Geo/resources/js/components/map-picker-lit.js`
- `laravel/Themes/Sixteen/resources/css/app.css`
- `laravel/Modules/Fixcity/docs/wiki/concepts/wizard-map-visibility-fix.md`

## Documentation

- [Leaflet API - invalidateSize](https://leafletjs.com/reference.html#map-invalidatesize)
- [IntersectionObserver MDN](https://developer.mozilla.org/en-US/docs/Web/API/Intersection_Observer_API)
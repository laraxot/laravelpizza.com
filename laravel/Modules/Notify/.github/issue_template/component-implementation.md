---
name: Component Implementation
about: Implement a reusable component for Design Comuni replication
title: 'Component: [Component Name]'
labels: ['component', 'design-comuni', 'frontend']
assignees: ''
---

## Component: [Component Name]

**Type**: [Layout / Content / Navigation / Interactive / Data Display]  
**Priority**: [Tier 1 / Tier 2 / Tier 3 / Tier 4 / Tier 5]  
**Used by**: [List of pages that will use this component]  
**Status**: 🟡 Proposed / 🟡 In Progress / ✅ Complete

---

## Requirements

### Design References
- **Design Comuni**: [URL to original component]
- **Tailwind UI**: [URL to similar component]
- **Flowbite**: [URL to similar component]
- **DaisyUI**: [URL to similar component]

### Screenshots
<!-- Add screenshots from Design Comuni showing the component -->

**Desktop**: ![Desktop view](screenshot-desktop.png)  
**Mobile**: ![Mobile view](screenshot-mobile.png)

---

## Implementation Plan

### 1. Create Blade Component
**File**: `laravel/Themes/Sixteen/resources/views/components/blocks/<type>/<component>.blade.php`

```blade
@props(['data' => [], 'options' => []])

@php
    // Extract data with defaults
    $title = $data['title'] ?? 'Default Title';
    $subtitle = $data['subtitle'] ?? '';
    $items = $data['items'] ?? [];
@endphp

<div {{ $attributes->merge(['class' => 'cmp-<component>']) }}
     x-data="{ /* Alpine.js data if needed */ }">
    {{-- Component HTML --}}
</div>
```

### 2. Add Tailwind @apply Styles
**File**: `laravel/Themes/Sixteen/resources/css/style-apply.css`

```css
/* Component: <component-name> */
.cmp-<component> {
  @apply /* Tailwind classes */;
}

.cmp-<component>-element {
  @apply /* Tailwind classes */;
}

/* Responsive variants */
@media (min-width: 768px) {
  .cmp-<component> {
    @apply /* Tablet styles */;
  }
}

@media (min-width: 992px) {
  .cmp-<component> {
    @apply /* Desktop styles */;
  }
}
```

### 3. Add Alpine.js Interactions (if needed)
**File**: `laravel/Themes/Sixteen/resources/js/app.js`

```javascript
// Component: <component-name>
document.addEventListener('alpine:init', () => {
  // Alpine.js initialization
});
```

### 4. Ensure WCAG 2.1 AA Compliance
- [ ] Color contrast ratio ≥ 4.5:1 (text), ≥ 3:1 (large text)
- [ ] Keyboard navigation works (Tab, Enter, Escape)
- [ ] ARIA labels added where needed
- [ ] Focus indicators visible
- [ ] Screen reader compatible

### 5. Write Pest Tests
**File**: `laravel/Themes/Sixteen/tests/Unit/Components/Blocks/<Type>/<Component>Test.php`

```php
<?php

use function Pest\Livewire\livewire;

it('renders <component> correctly', function () {
    $data = [
        'title' => 'Test Title',
        // ... other data
    ];

    $html = view('pub_theme::components.blocks.<type>.<component>', ['data' => $data])
        ->render();

    expect($html)->toContain('Test Title');
});

it('is accessible', function () {
    // Accessibility test
})->skip('Browser test needed');
```

### 6. Document Usage
**File**: `laravel/Themes/Sixteen/docs/COMPONENT_CATALOG.md`

```markdown
## <Component Name>

**Type**: <type>  
**View**: `pub_theme::components.blocks.<type>.<component>`

### Usage

```blade
<x-pub_theme::blocks.<type>.<component>
  :data="$data"
  :options="$options"
/>
```

### Data Structure

```json
{
  "title": "Component title",
  "subtitle": "Component subtitle",
  "items": [...]
}
```

### Examples

#### Basic Example
<!-- Screenshot + code -->

#### With Options
<!-- Screenshot + code -->

### Accessibility Notes
- [Accessibility considerations]

### Browser Support
- Chrome/Edge: ✅ Full support
- Firefox: ✅ Full support
- Safari: ✅ Full support
- Mobile: ✅ Responsive
```

---

## Acceptance Criteria

### Code Quality
- [ ] Component is universal (NOT page-specific)
- [ ] Follows DRY principle (no duplication)
- [ ] Follows KISS principle (simple, readable)
- [ ] PHPStan Level 10 compliance
- [ ] Pint code style (PSR-12)
- [ ] Pest tests written and passing

### Design Quality
- [ ] Matches Design Comuni design
- [ ] Responsive (mobile, tablet, desktop)
- [ ] WCAG 2.1 AA accessible
- [ ] Tailwind @apply used (NOT custom CSS)
- [ ] Alpine.js for interactions (NOT jQuery)

### Documentation
- [ ] Component documented in COMPONENT_CATALOG.md
- [ ] Usage examples provided
- [ ] Data structure documented
- [ ] Accessibility notes included
- [ ] Bidirectional links in docs

---

## Testing

### Visual Tests
```php
// tests/Browser/Components/<Component>Test.php
it('renders <component> correctly', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/it/tests/homepage')
                ->waitFor('@<component>')
                ->assertSee('Expected text')
                ->assertScreenshot('<component>-desktop');
    });
});

it('is responsive on mobile', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/it/tests/homepage')
                ->resize(375, 812)
                ->assertScreenshot('<component>-mobile');
    });
});
```

### Accessibility Tests
```php
it('passes WCAG 2.1 AA audit', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/it/tests/homepage')
                ->assertAccessibility('wcag2aa');
    });
});
```

---

## Definition of Done

- [ ] Blade component created
- [ ] Tailwind @apply styles added
- [ ] Alpine.js interactions implemented
- [ ] WCAG 2.1 AA compliance verified
- [ ] Pest tests written and passing
- [ ] Component catalog updated
- [ ] Code reviewed and approved
- [ ] Component reused in at least 2 pages

---

## Related Issues
- Depends on: #[issue numbers]
- Blocks: #[issue numbers]
- Related to: #[issue numbers]

---

## Comments

<!-- GitHub comments will be added here -->

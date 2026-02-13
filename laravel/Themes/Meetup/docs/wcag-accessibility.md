# WCAG 2.2 AAA Accessibility Guidelines

## Overview
Web Content Accessibility Guidelines (WCAG) 2.2 AAA compliance for the Laravel Pizza Meetup theme ensuring equal access for all users.

## Philosophy
- **Inclusive**: Design for everyone, including disabilities
- **Accessible**: Remove barriers to access
- **Standard-Based**: Follow WCAG 2.2 AAA guidelines
- **Tested**: Verified with real users and tools

## WCAG 2.2 AAA Requirements

### Level AAA Contrast Ratios
```
Normal Text (< 18pt): 7:1 contrast ratio
Large Text (≥ 18pt): 4.5:1 contrast ratio
Interactive Elements: 3:1 contrast ratio
```

### Verified Color Combinations
```php
// ✅ AAA Compliant (7:1+)
text-white on bg-slate-900      // 18.5:1
text-slate-900 on bg-white      // 21:1
text-white on bg-red-500        // 4.5:1 (fails AAA for normal text)
text-slate-900 on bg-red-500    // 4.5:1 (fails AAA for normal text)

// ✅ AAA Compliant for Large Text
text-white on bg-red-500        // 4.5:1 (OK for ≥ 18pt)
text-slate-900 on bg-red-500    // 4.5:1 (OK for ≥ 18pt)

// ✅ AAA Compliant for Interactive Elements
text-white on bg-red-500        // 4.5:1 (OK for buttons)
```

## Focus Indicators

### Standard Focus States
```php
// Ring focus (3px thickness)
focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-slate-900

// Solid border focus
focus:outline-none focus:ring-2 focus:ring-offset-2 focus:border-red-500

// Underline focus
focus:outline-none focus:ring-2 focus:ring-offset-2 focus:underline
```

### Focus Styles by Element
```php
// Links
<a class="text-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 rounded">
    Link Text
</a>

// Buttons
<button class="bg-red-600 text-white focus:outline-none focus:ring-4 focus:ring-red-500/50 rounded-lg">
    Button Text
</button>

// Inputs
<input class="border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-500 rounded-lg">
```

## Keyboard Navigation

### Tab Order
```php
// Logical tab order
// Ensure tabindex is not used to reorder

// Skip Links
<a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4">
    Skip to main content
</a>

// Focus Management
// Move focus to modal when opened
// Return focus when modal closes
```

### Keyboard Shortcuts
```php
// Standard shortcuts
Tab - Next element
Shift+Tab - Previous element
Enter - Activate
Space - Activate buttons
Escape - Close modals
```

## Screen Reader Support

### ARIA Labels
```php
// Descriptive labels
<button aria-label="Close modal">✕</button>
<input aria-label="Email address" type="email">

// Descriptive labels with description
<input aria-label="Password" aria-describedby="password-hint">
<p id="password-hint">Must be at least 12 characters</p>

// Landmarks
<nav aria-label="Main navigation">
<main aria-label="Main content">
<aside aria-label="Sidebar">
<footer aria-label="Footer">
```

### ARIA Roles
```php
// Button role (if not using <button>)
<div role="button" tabindex="0">Click me</div>

// Navigation role
<nav role="navigation">

// Alert role (for dynamic content)
<div role="alert">Error message</div>

// Status role (for status updates)
<div role="status">Loading...</div>
```

### ARIA States
```php
// Expanded/collapsed
<button aria-expanded="false">Menu</button>

// Hidden/visible
<div aria-hidden="true">Hidden content</div>

// Disabled
<button aria-disabled="true">Disabled button</button>

// Checked
<input type="checkbox" aria-checked="false">
```

## Text Alternatives

### Image Alt Text
```php
// Decorative images
<img src="decoration.png" alt="" aria-hidden="true">

// Informative images
<img src="meetup.jpg" alt="Laravel Rome Meetup with 50 developers networking">

// Functional images
<img src="menu.png" alt="Open menu">

// Complex images
<img src="chart.png" alt="Bar chart showing 50% increase in Laravel adoption">
```

### Icons
```php
// Icon buttons
<button aria-label="Search">
    <svg><!-- search icon --></svg>
</button>

// Icon links
<a href="/search" aria-label="Search">
    <svg><!-- search icon --></svg>
</a>
```

## Form Accessibility

### Form Labels
```php
// Explicit labels
<label for="email">Email</label>
<input id="email" type="email">

// Implicit labels
<label>
    Email
    <input type="email">
</label>

// ARIA labels (when labels not possible)
<input aria-label="Email address" type="email">
```

### Form Validation
```php
// Error messages
<input aria-invalid="true" aria-describedby="email-error">
<p id="email-error" role="alert">Please enter a valid email</p>

// Required fields
<label for="email">Email <span class="text-red-500" aria-label="required">*</span></label>
<input id="email" type="email" required aria-required="true">

// Helper text
<input aria-describedby="email-hint">
<p id="email-hint">We'll send a confirmation email</p>
```

### Form Instructions
```php
// Grouping related fields
<fieldset>
    <legend>Personal Information</legend>
    <label>First Name</label>
    <input>
    <label>Last Name</label>
    <input>
</fieldset>
```

## Color Independence

### Not Color Alone
```php
// ❌ WRONG - Color only
<div class="text-red-500">Error</div>

// ✅ CORRECT - Color + text/icon
<div class="text-red-500">
    <svg aria-hidden="true"><!-- error icon --></svg>
    Error
</div>

// ✅ CORRECT - Text label
<div class="text-red-500" role="alert">Error: Invalid email</div>
```

### Focus Indicators
```php
// Always have visible focus indicator
focus:ring-2 focus:ring-red-500 focus:ring-offset-2

// Don't rely on color change alone
focus:bg-red-600  // ❌ Not enough
focus:ring-2 focus:ring-red-500  // ✅ Clear indicator
```

## Time-Based Media

### Captions
```php
// Provide captions for videos
<video>
    <track kind="captions" src="captions.vtt" srclang="en" label="English">
</video>
```

### Audio Descriptions
```php
// Provide audio descriptions for important visual content
<video>
    <track kind="descriptions" src="descriptions.vtt" srclang="en">
</video>
```

## Responsive Design

### Mobile Accessibility
```php
// Touch targets (minimum 44×44px)
<button class="min-h-[44px] min-w-[44px]">Button</button>

// Text scaling (200% zoom)
// Use relative units (rem, em, %)
font-size: 1rem;

// No horizontal scroll
overflow-x: hidden;
```

### Viewport Configuration
```php
// Proper viewport meta tag
<meta name="viewport" content="width=device-width, initial-scale=1">

// Don't disable zoom
// ❌ WRONG
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

// ✅ CORRECT
<meta name="viewport" content="width=device-width, initial-scale=1">
```

## Motion Accessibility

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

// Apply in Tailwind
class="transition-all duration-200 motion-reduce:transition-none"
```

### Pause/Stop Controls
```php
// Provide controls for auto-playing content
<button aria-label="Pause animation">Pause</button>

// Respect system preferences
@media (prefers-reduced-motion: reduce) {
    .auto-play {
        animation: none;
    }
}
```

## Error Identification

### Error Messages
```php
// Link error to field
<input aria-invalid="true" aria-describedby="email-error">
<p id="email-error" role="alert">Please enter a valid email</p>

// List all errors at top
<div role="alert">
    <h2>Errors</h2>
    <ul>
        <li><a href="#email">Email is required</a></li>
        <li><a href="#password">Password is too short</a></li>
    </ul>
</div>
```

## Language Identification
```php
// Page language
<html lang="it">

// Language changes
<p lang="en">This is in English</p>

// Language of code blocks
<code lang="php">
    // PHP code
</code>
```

## Table Accessibility
```php
// Table captions
<table>
    <caption>Upcoming Laravel Meetups</caption>
    <thead>
        <tr>
            <th scope="col">Date</th>
            <th scope="col">Location</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>2026-02-20</td>
            <td>Rome</td>
        </tr>
    </tbody>
</table>
```

## Common Mistakes

### 1. Poor Contrast
```php
// ❌ WRONG - Low contrast
text-gray-400 on bg-white  // 3.0:1 (fails WCAG AAA)

// ✅ CORRECT - Good contrast
text-slate-600 on bg-white  // 7.5:1 (passes WCAG AAA)
```

### 2. Missing Alt Text
```php
// ❌ WRONG - No alt text
<img src="meetup.jpg">

// ✅ CORRECT - Descriptive alt text
<img src="meetup.jpg" alt="Laravel Rome Meetup with 50 developers">
```

### 3. No Focus Indicator
```php
// ❌ WRONG - No focus state
bg-red-500 text-white

// ✅ CORRECT - With focus ring
bg-red-500 text-white focus:ring-2 focus:ring-red-500 focus:ring-offset-2
```

### 4. Small Touch Targets
```php
// ❌ WRONG - Too small
<button class="w-8 h-8">Button</button>

// ✅ CORRECT - Minimum 44×44px
<button class="min-h-[44px] min-w-[44px]">Button</button>
```

### 5. Empty Links
```php
// ❌ WRONG - No text
<a href="/"><img src="logo.png"></a>

// ✅ CORRECT - With aria-label
<a href="/" aria-label="Laravel Pizza Home">
    <img src="logo.png" alt="Laravel Pizza Logo">
</a>
```

## Testing Tools

### Automated Testing
```php
// WAVE (Web Accessibility Evaluation Tool)
// https://wave.webaim.org/

// axe DevTools
// Chrome extension

// Lighthouse
// Chrome DevTools

// Pa11y
// Command-line tool
```

### Manual Testing
```php
// Keyboard navigation
// Try navigating without mouse

// Screen reader testing
// NVDA (Windows)
// VoiceOver (Mac)
// JAWS (Windows)

// Zoom testing
// Zoom to 200% and verify layout
```

### User Testing
```php
// Test with real users
// Include users with disabilities
// Get feedback on usability
```

## Accessibility Checklist

### Perceivable
- [ ] Text alternatives for non-text content
- [ ] Captions for videos
- [ ] Audio descriptions for important visual content
- [ ] Content can be presented in different ways
- [ ] Content is easier to see and hear

### Operable
- [ ] All functionality is keyboard accessible
- [ ] Users have enough time to read and use content
- [ ] Content doesn't cause seizures
- [ ] Users can navigate and find content
- [ ] Users can use different input devices

### Understandable
- [ ] Text is readable and understandable
- [ ] Content appears and operates in predictable ways
- [ ] Users are helped to avoid and correct mistakes

### Robust
- [ ] Content is compatible with assistive technologies
- [ ] HTML is valid and well-formed
- [ ] ARIA is used correctly
- [ ] Focus management is proper

## Related Documentation
- [Layout System](./layout-system.md)
- [Color Palette](./color-palette.md)
- [Typography System](./typography.md)

## Credits
- Guidelines: WCAG 2.2 AAA
- Testing: WAVE, axe, Lighthouse
- Philosophy: Inclusive, accessible, tested
- Level: AAA (highest accessibility level)
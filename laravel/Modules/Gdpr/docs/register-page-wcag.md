# Register Page WCAG Compliance

## Overview
WCAG 2.1 compliance for the registration page ensuring accessibility for all users.

## WCAG 2.1 Principles

### POUR Principles
- **Perceivable**: Information must be presentable in ways users can perceive
- **Operable**: Interface components must be operable
- **Understandable**: Information and operation must be understandable
- **Robust**: Content must be robust enough to be interpreted by assistive technologies

## Perceivable

### 1.1 Text Alternatives (Level A)

#### Images
```html
<!-- Decorative images -->
<img src="decoration.svg" alt="" aria-hidden="true">

<!-- Informative images -->
<img src="pizza-icon.svg" alt="{{ __('gdpr::register.a11y.pizza_icon') }}">

<!-- Complex images -->
<img src="diagram.svg" alt="{{ __('gdpr::register.a11y.diagram') }}" longdesc="#diagram-desc">
```

#### Icons
```html
<!-- Icon with text -->
<button type="submit">
  <span aria-hidden="true">🍕</span>
  <span>{{ __('gdpr::register.button.submit') }}</span>
</button>

<!-- Standalone icon with aria-label -->
<button type="submit" aria-label="{{ __('gdpr::register.button.submit') }}">
  <span aria-hidden="true">🍕</span>
</button>
```

### 1.2 Time-Based Media (Level A)

#### Captions for Videos
```html
<video controls>
  <source src="intro.mp4" type="video/mp4">
  <track src="captions.vtt" kind="captions" srclang="it" label="Italiano">
  {{ __('gdpr::register.a11y.video_not_supported') }}
</video>
```

### 1.3 Adaptable (Level A)

#### Semantic HTML
```html
<!-- Use semantic elements instead of divs -->
<main role="main">
  <h1>{{ __('gdpr::register.title') }}</h1>
  <section aria-labelledby="form-heading">
    <h2 id="form-heading">{{ __('gdpr::register.sections.registration_form') }}</h2>
    <!-- Form content -->
  </section>
</main>
```

### 1.4 Distinguishable (Level A)

#### Color Contrast (WCAG AA)
```css
/* Minimum contrast ratios */
/* Large text (18px+): 3:1 */
/* Normal text: 4.5:1 */
/* UI components: 3:1 */

/* Good examples */
text-white on bg-slate-900: 12.6:1 (AAA)
text-slate-300 on bg-slate-900: 7.2:1 (AAA)
text-red-400 on bg-slate-900: 5.9:1 (AA)

/* Bad examples */
text-slate-400 on bg-slate-700: 2.8:1 (FAIL)
text-red-300 on bg-slate-800: 3.8:1 (FAIL)
```

#### Focus Indicators (WCAG 2.1 AAA)
```css
/* Clear focus indicators */
:focus-visible {
  outline: 3px solid #ef4444;
  outline-offset: 3px;
  box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.2);
}

/* Ensure focus is visible on all interactive elements */
button:focus-visible,
input:focus-visible,
a:focus-visible {
  outline: 3px solid #ef4444;
  outline-offset: 3px;
}
```

## Operable

### 2.1 Keyboard Accessible (Level A)

#### Keyboard Navigation
```html
<!-- Skip navigation link -->
<a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:bg-white focus:text-black focus:p-4 focus:rounded">
  {{ __('gdpr::register.a11y.skip_content') }}
</a>

<!-- Tab order -->
<input type="text" tabindex="1">
<input type="email" tabindex="2">
<input type="password" tabindex="3">
<button type="submit" tabindex="4">{{ __('gdpr::register.button.submit') }}</button>
```

#### Keyboard Shortcuts
```html
<!-- Document keyboard shortcuts -->
<div role="note" aria-label="{{ __('gdpr::register.a11y.keyboard_shortcuts') }}">
  <p>{{ __('gdpr::register.a11y.shortcuts_desc') }}</p>
  <ul>
    <li><kbd>Tab</kbd>: {{ __('gdpr::register.a11y.next_field') }}</li>
    <li><kbd>Shift + Tab</kbd>: {{ __('gdpr::register.a11y.prev_field') }}</li>
    <li><kbd>Enter</kbd>: {{ __('gdpr::register.a11y.submit') }}</li>
    <li><kbd>Esc</kbd>: {{ __('gdpr::register.a11y.cancel') }}</li>
  </ul>
</div>
```

### 2.2 Enough Time (Level A)

#### No Time Limits
```html
<!-- No automatic timeouts or redirects -->
<!-- If timeouts are necessary, provide warning and extend option -->
<div id="timeout-warning" role="alert" aria-live="polite">
  <p>{{ __('gdpr::register.a11y.timeout_warning') }}</p>
  <button type="button" onclick="extendSession()">
    {{ __('gdpr::register.button.extend_session') }}
  </button>
</div>
```

### 2.3 Seizures and Physical Reactions (Level A)

#### No Flashing Content
```css
/* Limit flashing to 3 times per second */
/* General flash threshold: 3 flashes/second */
/* Red flash threshold: 3 flashes/second */

/* Avoid flashing animations */
.no-flash {
  animation: none;
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
  *,
  *::before,
  *::after {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
  }
}
```

### 2.4 Navigable (Level A)

#### Breadcrumbs
```html
<nav aria-label="{{ __('gdpr::register.a11y.breadcrumb') }}">
  <ol class="flex items-center space-x-2">
    <li>
      <a href="{{ LaravelLocalization::getLocalizedURL($locale, '/') }}" aria-current="page">
        {{ __('gdpr::register.breadcrumb.home') }}
      </a>
    </li>
    <li aria-hidden="true">/</li>
    <li>
      <span aria-current="page">{{ __('gdpr::register.breadcrumb.register') }}</span>
    </li>
  </ol>
</nav>
```

#### Page Titles
```html
<!-- Unique and descriptive page titles -->
<title>{{ __('gdpr::register.meta.title') }} - LaravelPizza</title>
```

## Understandable

### 3.1 Readable (Level A)

#### Language Declaration
```html
<html lang="{{ app()->getLocale() }}" dir="ltr">
```

#### Text Readability
```css
/* Font size: minimum 16px for body text */
body {
  font-size: 16px;
  line-height: 1.625;
}

/* Line height: minimum 1.5 for body text */
p {
  line-height: 1.625;
}

/* Paragraph spacing: minimum 2x font size */
p + p {
  margin-top: 1.5em;
}
```

### 3.2 Predictable (Level A)

#### Consistent Navigation
```html
<!-- Consistent navigation across pages -->
<nav role="navigation" aria-label="{{ __('gdpr::register.a11y.main_nav') }}">
  <!-- Navigation links -->
</nav>
```

#### Focus Management
```html
<!-- Maintain focus on form errors -->
<div id="error-message" role="alert" aria-live="assertive" tabindex="-1">
  <p>{{ __('gdpr::register.error.generic') }}</p>
</div>

<!-- Focus on first error field -->
<script>
document.getElementById('error-message').focus();
</script>
```

### 3.3 Input Assistance (Level A)

#### Form Labels
```html
<!-- Explicit labels for form fields -->
<label for="email">
  {{ __('gdpr::register.fields.email.label') }}
  <span class="text-red-500" aria-hidden="true">*</span>
</label>
<input
  type="email"
  id="email"
  name="email"
  required
  aria-required="true"
  aria-invalid="false"
  aria-describedby="email-help"
>
<span id="email-help" class="text-sm text-slate-400">
  {{ __('gdpr::register.fields.email.help_text') }}
</span>
```

#### Error Messages
```html
<!-- Visible and accessible error messages -->
<div id="email-error" class="text-red-400" role="alert" aria-live="assertive">
  {{ __('gdpr::register.error.email_invalid') }}
</div>

<!-- Associate error with input -->
<input
  type="email"
  id="email"
  aria-invalid="true"
  aria-describedby="email-error"
>
```

#### Instructions
```html
<!-- Clear instructions for form completion -->
<div class="mb-4" role="note">
  <p>{{ __('gdpr::register.form.instructions') }}</p>
  <ul>
    <li>{{ __('gdpr::register.form.instruction_1') }}</li>
    <li>{{ __('gdpr::register.form.instruction_2') }}</li>
    <li>{{ __('gdpr::register.form.instruction_3') }}</li>
  </ul>
</div>
```

## Robust

### 4.1 Compatible (Level A)

#### Valid HTML
```html
<!-- Use valid HTML5 -->
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ __('gdpr::register.meta.title') }}</title>
</head>
<body>
  <!-- Content -->
</body>
</html>
```

#### ARIA Attributes
```html
<!-- Use ARIA attributes for dynamic content -->
<div
  role="status"
  aria-live="polite"
  aria-atomic="true"
  id="form-status"
>
  <!-- Status messages -->
</div>

<!-- Use aria-expanded for collapsible content -->
<button
  type="button"
  aria-expanded="false"
  aria-controls="faq-content"
>
  {{ __('gdpr::register.faq.title') }}
</button>
<div id="faq-content" hidden>
  <!-- FAQ content -->
</div>
```

## WCAG Level Checklist

### Level A (Must have)
- [ ] Non-text content has alt text
- [ ] Captions for videos
- [ ] Semantic HTML
- [ ] Color contrast minimum 4.5:1
- [ ] Keyboard accessible
- [ ] No time limits
- [ ] No flashing content
- [ ] Navigable with breadcrumbs
- [ ] Page titles
- [ ] Language declaration
- [ ] Readable text
- [ ] Consistent navigation
- [ ] Form labels
- [ ] Error messages
- [ ] Valid HTML

### Level AA (Should have)
- [ ] Color contrast minimum 4.5:1 (3:1 for large text)
- [ ] Resizing content up to 200%
- [ ] Text contrast minimum 3:1 for UI components
- [ ] No keyboard traps
- [ ] Focus indicators (3:1 contrast)
- [ ] Error suggestions
- [ ] Labels or instructions
- [ ] Error prevention

### Level AAA (Nice to have)
- [ ] Color contrast minimum 7:1
- [ ] No background audio
- [ ] Text spacing
- [ ] No cancellation buttons
- [ ] Re-authentication after expiration
- [ ] Help text
- [ ] Error identification and description

## Accessibility Testing

### Automated Testing
```bash
# Lighthouse accessibility audit
npx lighthouse https://127.0.0.1:8000/it/auth/register --view --only-categories=accessibility

# axe DevTools
npm install -g @axe-core/cli
axe https://127.0.0.1:8000/it/auth/register --tags wcag2a,wcag2aa,wcag2.1a,wcag2.1aa
```

### Manual Testing

#### Keyboard Navigation
- [ ] Tab through all interactive elements
- [ ] Shift+Tab to navigate backwards
- [ ] Enter to activate buttons
- [ ] Space to toggle checkboxes
- [ ] Arrow keys for radio buttons
- [ ] Escape to close modals

#### Screen Reader Testing
- [ ] Test with NVDA (Windows)
- [ ] Test with VoiceOver (macOS)
- [ ] Test with TalkBack (Android)
- [ ] Test with JAWS (Windows)
- [ ] Verify all content is announced
- [ ] Verify form fields are properly labeled

#### Color Contrast Testing
- [ ] Use WebAIM Contrast Checker
- [ ] Test with color blindness simulators
- [ ] Test in high contrast mode
- [ ] Test with inverted colors

#### Screen Magnification Testing
- [ ] Test at 200% zoom
- [ ] Test at 400% zoom
- [ ] Verify content is still readable
- [ ] Verify horizontal scrolling is minimal

## Accessibility Resources

### Documentation
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- [ARIA Authoring Practices](https://www.w3.org/WAI/ARIA/apg/)
- [WebAIM WCAG Checklist](https://webaim.org/standards/wcag/checklist)

### Testing Tools
- [WAVE Web Accessibility Evaluator](https://wave.webaim.org/)
- [axe DevTools](https://www.deque.com/axe/)
- [Lighthouse](https://developers.google.com/web/tools/lighthouse)
- [A11Y Testing Checklist](https://www.a11yproject.com/checklist/)

### Screen Readers
- [NVDA (Windows)](https://www.nvaccess.org/)
- [VoiceOver (macOS)](https://www.apple.com/accessibility/voiceover/)
- [TalkBack (Android)](https://support.google.com/accessibility/android/answer/6283677)
- [JAWS (Windows)](https://www.freedomscientific.com/products/software/jaws/)

## References
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- [WebAIM WCAG Checklist](https://webaim.org/standards/wcag/checklist)
- [A11Y Project](https://www.a11yproject.com/)
- [ARIA Authoring Practices](https://www.w3.org/WAI/ARIA/apg/)
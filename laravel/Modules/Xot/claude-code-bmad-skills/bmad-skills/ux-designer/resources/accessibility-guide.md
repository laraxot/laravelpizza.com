# Accessibility Guide - WCAG 2.1 AA Reference

Complete accessibility reference for designing inclusive, WCAG 2.1 Level AA compliant user experiences.

---

## Table of Contents

1. [WCAG Overview](#wcag-overview)
2. [Perceivable](#perceivable)
3. [Operable](#operable)
4. [Understandable](#understandable)
5. [Robust](#robust)
6. [Common Violations & Fixes](#common-violations--fixes)
7. [Testing Guide](#testing-guide)
8. [Tools & Resources](#tools--resources)

---

## WCAG Overview

### What is WCAG?

Web Content Accessibility Guidelines (WCAG) 2.1 is the international standard for web accessibility. It ensures content is accessible to people with disabilities including:

- Visual impairments (blindness, low vision, color blindness)
- Hearing impairments (deafness, hard of hearing)
- Motor disabilities (limited dexterity, tremors)
- Cognitive disabilities (learning disabilities, memory issues)
- Seizure disorders (photosensitive epilepsy)

### Conformance Levels

- **Level A:** Minimum accessibility (basic)
- **Level AA:** Mid-range accessibility (target for most sites) ← **OUR MINIMUM**
- **Level AAA:** Highest accessibility (enhanced)

### Four Principles (POUR)

1. **Perceivable:** Information must be presentable to users in ways they can perceive
2. **Operable:** UI components must be operable
3. **Understandable:** Information and operation must be understandable
4. **Robust:** Content must be robust enough for assistive technologies

---

## Perceivable

> Users must be able to perceive the information being presented

### 1.1 Text Alternatives

#### 1.1.1 Non-text Content (Level A)

**Requirement:** All non-text content has a text alternative.

**Images:**

```html
<!-- Informative image -->
<img src="chart.png" alt="Sales increased 25% in Q4 2024">

<!-- Decorative image -->
<img src="decoration.png" alt="" role="presentation">

<!-- Complex image -->
<img src="complex-chart.png"
     alt="Quarterly sales chart"
     aria-describedby="chart-description">
<div id="chart-description">
  Detailed description: Sales data from Q1-Q4...
</div>
```

**Icons with meaning:**

```html
<!-- Icon button -->
<button aria-label="Close dialog">
  <svg aria-hidden="true"><!-- X icon --></svg>
</button>

<!-- Icon with visible text -->
<button>
  <svg aria-hidden="true"><!-- Icon --></svg>
  Delete
</button>
```

**Form inputs:**

```html
<!-- Every input needs a label -->
<label for="email">Email Address</label>
<input type="email" id="email" name="email">
```

---

### 1.2 Time-based Media

#### 1.2.1 Audio-only and Video-only (Level A)

**Audio-only:** Provide a transcript
**Video-only:** Provide audio description or transcript

#### 1.2.2 Captions (Level A)

**Requirement:** Captions for all prerecorded audio in synchronized media (videos)

#### 1.2.4 Captions (Live) (Level AA)

**Requirement:** Live captions for live audio content

#### 1.2.5 Audio Description (Level AA)

**Requirement:** Audio description for all prerecorded video content

---

### 1.3 Adaptable

#### 1.3.1 Info and Relationships (Level A)

**Requirement:** Information, structure, and relationships conveyed through presentation can be programmatically determined.

**Use semantic HTML:**

```html
<!-- Headings -->
<h1>Main Title</h1>
<h2>Section Title</h2>
<h3>Subsection</h3>

<!-- Lists -->
<ul>
  <li>Item 1</li>
  <li>Item 2</li>
</ul>

<!-- Tables -->
<table>
  <caption>Q4 Sales Data</caption>
  <thead>
    <tr>
      <th scope="col">Month</th>
      <th scope="col">Revenue</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>October</td>
      <td>$50,000</td>
    </tr>
  </tbody>
</table>

<!-- Landmark regions -->
<header><!-- Site header --></header>
<nav><!-- Navigation --></nav>
<main><!-- Main content --></main>
<aside><!-- Sidebar --></aside>
<footer><!-- Footer --></footer>
```

#### 1.3.2 Meaningful Sequence (Level A)

**Requirement:** Reading order is logical and meaningful.

- Tab order should follow visual order
- Content order in DOM should be logical
- Don't rely on CSS to create reading order

#### 1.3.3 Sensory Characteristics (Level A)

**Requirement:** Instructions don't rely solely on sensory characteristics.

```html
<!-- Bad: Relies on shape/position -->
"Click the round button on the right"

<!-- Good: Multiple cues -->
"Click the 'Submit' button (round, blue, on the right)"

<!-- Bad: Relies on color -->
"Fields in red are required"

<!-- Good: Multiple cues -->
"Required fields are marked with an asterisk (*) and have red labels"
```

#### 1.3.4 Orientation (Level AA)

**Requirement:** Content works in both portrait and landscape orientations.

- Don't lock orientation unless essential
- Ensure content reflows in both orientations

#### 1.3.5 Identify Input Purpose (Level AA)

**Requirement:** Input purpose can be programmatically determined.

```html
<!-- Use autocomplete attributes -->
<input type="text"
       name="name"
       autocomplete="name">

<input type="email"
       name="email"
       autocomplete="email">

<input type="tel"
       name="phone"
       autocomplete="tel">
```

---

### 1.4 Distinguishable

#### 1.4.1 Use of Color (Level A)

**Requirement:** Color is not the only visual means of conveying information.

```html
<!-- Bad: Color only -->
<span style="color: red;">Error</span>

<!-- Good: Color + icon + text -->
<span style="color: red;">
  <svg aria-hidden="true"><!-- Error icon --></svg>
  Error: Invalid email format
</span>

<!-- Good: Color + pattern -->
<!-- In charts, use both color and patterns/textures -->
```

#### 1.4.3 Contrast (Minimum) (Level AA) ⭐ **CRITICAL**

**Requirement:**
- Normal text: 4.5:1 contrast ratio
- Large text (18px+ or 14px+ bold): 3:1 contrast ratio
- UI components and graphics: 3:1 contrast ratio

**Check with:**
```bash
python scripts/contrast-check.py #333333 #ffffff
```

**Examples:**

✓ Pass: #333333 on #FFFFFF (12.63:1)
✓ Pass: #0066CC on #FFFFFF (7.56:1)
✓ Pass: #767676 on #FFFFFF (4.54:1)
✗ Fail: #999999 on #FFFFFF (2.85:1)

#### 1.4.4 Resize Text (Level AA)

**Requirement:** Text can be resized up to 200% without loss of content or functionality.

- Use relative units (rem, em, %)
- Don't prevent browser zoom
- Test at 200% zoom

#### 1.4.5 Images of Text (Level AA)

**Requirement:** Avoid images of text (use actual text instead).

- Exception: Logos
- Exception: When specific presentation is essential

#### 1.4.10 Reflow (Level AA)

**Requirement:** No horizontal scrolling at 320px width (for vertical scrolling content).

- Content must reflow and adapt
- No 2D scrolling (horizontal + vertical)
- Exception: Complex content like data tables, diagrams

#### 1.4.11 Non-text Contrast (Level AA)

**Requirement:** UI components and graphics have 3:1 contrast against adjacent colors.

- Button borders
- Form input borders
- Focus indicators
- Icons
- Chart elements

#### 1.4.12 Text Spacing (Level AA)

**Requirement:** No loss of content when users adjust spacing:

- Line height: 1.5× font size
- Paragraph spacing: 2× font size
- Letter spacing: 0.12× font size
- Word spacing: 0.16× font size

#### 1.4.13 Content on Hover or Focus (Level AA)

**Requirement:** Content that appears on hover/focus must be:

1. **Dismissible:** Can be closed without moving pointer/focus
2. **Hoverable:** Pointer can move to the new content
3. **Persistent:** Stays visible until dismissed or no longer valid

```html
<!-- Tooltip example -->
<button aria-describedby="tooltip">Help</button>
<div id="tooltip" role="tooltip">
  This is helpful information
  <button aria-label="Close">×</button>
</div>
```

---

## Operable

> Users must be able to operate the interface

### 2.1 Keyboard Accessible

#### 2.1.1 Keyboard (Level A) ⭐ **CRITICAL**

**Requirement:** All functionality available via keyboard.

**Interactive elements must be keyboard accessible:**

```html
<!-- Use native elements (inherently keyboard accessible) -->
<button>Click me</button>
<a href="/page">Link</a>

<!-- If using div/span, add keyboard support -->
<div role="button" tabindex="0" onkeydown="handleKeyPress(event)">
  Custom button
</div>

<!-- Keyboard event handler -->
<script>
function handleKeyPress(event) {
  if (event.key === 'Enter' || event.key === ' ') {
    // Trigger action
  }
}
</script>
```

**Tab order:**
- Use `tabindex="0"` for custom interactive elements
- Use `tabindex="-1"` for elements that should receive focus programmatically but not via Tab
- Never use positive tabindex values (they break natural order)

#### 2.1.2 No Keyboard Trap (Level A)

**Requirement:** Keyboard users can move focus away from any component.

**Modal focus trap (correct implementation):**

```javascript
// When modal opens:
// 1. Save last focused element
const lastFocus = document.activeElement;

// 2. Move focus into modal
modal.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])').focus();

// 3. Trap focus within modal
modal.addEventListener('keydown', (e) => {
  if (e.key === 'Tab') {
    const focusable = modal.querySelectorAll('...');
    const first = focusable[0];
    const last = focusable[focusable.length - 1];

    if (e.shiftKey && document.activeElement === first) {
      e.preventDefault();
      last.focus();
    } else if (!e.shiftKey && document.activeElement === last) {
      e.preventDefault();
      first.focus();
    }
  }

  // Escape key closes modal
  if (e.key === 'Escape') {
    closeModal();
  }
});

// When modal closes:
// 4. Return focus to trigger
lastFocus.focus();
```

#### 2.1.4 Character Key Shortcuts (Level A)

**Requirement:** If single-key shortcuts exist, they can be turned off, remapped, or only active when component has focus.

---

### 2.2 Enough Time

#### 2.2.1 Timing Adjustable (Level A)

**Requirement:** Users can extend, adjust, or turn off time limits.

- Session timeouts: Warn user, allow extension
- Auto-advancing content: Allow pause/stop
- Minimum: 20 seconds before timeout

#### 2.2.2 Pause, Stop, Hide (Level A)

**Requirement:** Moving, blinking, scrolling, or auto-updating content can be paused, stopped, or hidden.

- Carousels: Pause on hover/focus
- Auto-updating news: Pause button
- Animations: Can be paused

---

### 2.3 Seizures and Physical Reactions

#### 2.3.1 Three Flashes or Below Threshold (Level A)

**Requirement:** No content flashes more than 3 times per second.

- Avoid rapidly flashing content
- If unavoidable, keep below threshold

---

### 2.4 Navigable

#### 2.4.1 Bypass Blocks (Level A)

**Requirement:** Mechanism to skip repeated content.

```html
<!-- Skip link (first focusable element) -->
<a href="#main" class="skip-link">Skip to main content</a>

<header><!-- Header content --></header>

<main id="main">
  <!-- Main content -->
</main>

<style>
.skip-link {
  position: absolute;
  top: -40px;
  left: 0;
  background: #000;
  color: #fff;
  padding: 8px;
  z-index: 100;
}

.skip-link:focus {
  top: 0;
}
</style>
```

#### 2.4.2 Page Titled (Level A)

**Requirement:** Pages have descriptive `<title>` elements.

```html
<title>Shopping Cart - 3 items - MyStore</title>
<title>Edit Profile - MyApp</title>
<title>404 Error - Page Not Found - MySite</title>
```

#### 2.4.3 Focus Order (Level A)

**Requirement:** Focus order preserves meaning and operability.

- Tab order should follow visual order
- Logical flow through content
- Don't jump around unpredictably

#### 2.4.4 Link Purpose (In Context) (Level A)

**Requirement:** Link purpose can be determined from link text or context.

```html
<!-- Bad: Ambiguous -->
<a href="/article1">Click here</a>
<a href="/article2">Read more</a>

<!-- Good: Descriptive -->
<a href="/article1">How to Design Accessible Forms</a>
<a href="/article2">Read more about WCAG 2.1 compliance</a>

<!-- Good: Context provided -->
<article>
  <h2>New Feature Released</h2>
  <p>We've added dark mode...</p>
  <a href="/feature">Read more</a> <!-- Context from heading -->
</article>
```

#### 2.4.5 Multiple Ways (Level AA)

**Requirement:** Multiple ways to find pages.

- Site navigation
- Search functionality
- Sitemap
- Related links

#### 2.4.6 Headings and Labels (Level AA)

**Requirement:** Headings and labels are descriptive.

```html
<!-- Bad: Non-descriptive -->
<h2>Section 1</h2>
<label for="input1">Field</label>

<!-- Good: Descriptive -->
<h2>Account Settings</h2>
<label for="email">Email Address</label>
```

#### 2.4.7 Focus Visible (Level AA) ⭐ **CRITICAL**

**Requirement:** Keyboard focus indicator is visible.

```css
/* Default focus styles */
:focus {
  outline: 2px solid #0066CC;
  outline-offset: 2px;
}

/* Custom focus styles */
button:focus {
  outline: 2px solid #0066CC;
  outline-offset: 2px;
  box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.2);
}

/* NEVER do this without replacement */
/* :focus { outline: none; } ← BAD! */
```

---

### 2.5 Input Modalities

#### 2.5.1 Pointer Gestures (Level A)

**Requirement:** Multi-point or path-based gestures have single-pointer alternative.

- Pinch to zoom: Also provide +/- buttons
- Two-finger scroll: Also allow single pointer
- Swipe: Also provide buttons

#### 2.5.2 Pointer Cancellation (Level A)

**Requirement:** Click completes on up-event (not down-event).

- Allows users to cancel by moving pointer away
- Native buttons/links handle this automatically

#### 2.5.3 Label in Name (Level A)

**Requirement:** Visible label text is included in accessible name.

```html
<!-- Visible label: "Submit" -->
<!-- Accessible name should include "Submit" -->

<!-- Good -->
<button>Submit</button>
<button aria-label="Submit form">Submit</button>

<!-- Bad -->
<button aria-label="Send">Submit</button>
```

#### 2.5.4 Motion Actuation (Level A)

**Requirement:** Functions triggered by device motion have UI alternative.

- Shake to undo: Also provide undo button
- Tilt to scroll: Also provide scroll controls

---

## Understandable

> Users must be able to understand the information and operation

### 3.1 Readable

#### 3.1.1 Language of Page (Level A)

**Requirement:** Page language is specified.

```html
<html lang="en">
<html lang="es">
<html lang="fr">
```

#### 3.1.2 Language of Parts (Level AA)

**Requirement:** Language changes are marked.

```html
<p>The French word for hello is <span lang="fr">bonjour</span>.</p>
```

---

### 3.2 Predictable

#### 3.2.1 On Focus (Level A)

**Requirement:** Receiving focus doesn't cause unexpected context change.

- Don't auto-submit forms on focus
- Don't open popups on focus
- Don't navigate away on focus

#### 3.2.2 On Input (Level A)

**Requirement:** Changing input doesn't cause unexpected context change.

```html
<!-- Bad: Auto-submits -->
<select onchange="this.form.submit()">

<!-- Good: Requires explicit action -->
<select id="country">
<button type="submit">Update</button>
```

#### 3.2.3 Consistent Navigation (Level AA)

**Requirement:** Navigation mechanisms are consistent across pages.

- Same menu order on all pages
- Same footer links on all pages
- Same search location on all pages

#### 3.2.4 Consistent Identification (Level AA)

**Requirement:** Components with same functionality have consistent labels.

- If "Search" button on one page, use "Search" (not "Find") on other pages
- Consistent icons for same actions

---

### 3.3 Input Assistance

#### 3.3.1 Error Identification (Level A) ⭐ **CRITICAL**

**Requirement:** Errors are identified and described in text.

```html
<!-- Form with errors -->
<form>
  <div class="field-error">
    <label for="email">Email Address *</label>
    <input type="email"
           id="email"
           aria-invalid="true"
           aria-describedby="email-error">
    <div id="email-error" class="error-message" role="alert">
      <svg aria-hidden="true"><!-- Error icon --></svg>
      Please enter a valid email address (e.g., name@example.com)
    </div>
  </div>
</form>
```

#### 3.3.2 Labels or Instructions (Level A) ⭐ **CRITICAL**

**Requirement:** Labels or instructions provided when input is required.

```html
<!-- Every input needs a label -->
<label for="username">Username *</label>
<input type="text" id="username" required>

<!-- Complex inputs need instructions -->
<label for="password">Password *</label>
<input type="password" id="password" aria-describedby="password-rules">
<div id="password-rules">
  Password must be at least 8 characters and include letters and numbers.
</div>
```

#### 3.3.3 Error Suggestion (Level AA)

**Requirement:** Error messages suggest corrections.

```html
<!-- Bad: Just says there's an error -->
<div>Error in email field</div>

<!-- Good: Suggests correction -->
<div role="alert">
  Please enter a valid email address. Example: name@example.com
</div>

<!-- Good: Specific correction -->
<div role="alert">
  Password must include at least one number.
  Example: Add123 to the end of your password.
</div>
```

#### 3.3.4 Error Prevention (Level AA)

**Requirement:** For legal/financial/data submission, one of:

1. Submissions are reversible
2. Data is checked and user can correct
3. Confirmation step before final submission

```html
<!-- Confirmation before delete -->
<dialog role="dialog" aria-labelledby="confirm-title">
  <h2 id="confirm-title">Confirm Deletion</h2>
  <p>Are you sure you want to delete your account? This cannot be undone.</p>
  <button onclick="cancelDelete()">Cancel</button>
  <button onclick="confirmDelete()">Yes, Delete Account</button>
</dialog>
```

---

## Robust

> Content must work with current and future technologies

### 4.1 Compatible

#### 4.1.1 Parsing (Level A)

**Requirement:** HTML is valid (properly nested, no duplicate IDs).

```html
<!-- Bad: Invalid HTML -->
<div id="main">
  <p>Content
</div>
<div id="main">Another div with same ID</div>

<!-- Good: Valid HTML -->
<div id="main">
  <p>Content</p>
</div>
<div id="sidebar">Another div with unique ID</div>
```

**Validate with:**
- W3C HTML Validator
- Browser DevTools console

#### 4.1.2 Name, Role, Value (Level A)

**Requirement:** UI components have proper name, role, and state.

```html
<!-- Native elements have built-in roles -->
<button>Click me</button>
<!-- role="button" (implicit), name="Click me", value=N/A -->

<!-- Custom elements need ARIA -->
<div role="button"
     tabindex="0"
     aria-pressed="false">
  Toggle
</div>

<!-- Form inputs need names -->
<label for="search">Search</label>
<input type="search" id="search" name="search">

<!-- Complex widgets need proper ARIA -->
<div role="tablist">
  <button role="tab"
          aria-selected="true"
          aria-controls="panel1">
    Tab 1
  </button>
  <button role="tab"
          aria-selected="false"
          aria-controls="panel2">
    Tab 2
  </button>
</div>
<div role="tabpanel" id="panel1">Panel 1 content</div>
<div role="tabpanel" id="panel2" hidden>Panel 2 content</div>
```

#### 4.1.3 Status Messages (Level AA)

**Requirement:** Status messages can be programmatically determined.

```html
<!-- Success message -->
<div role="status" aria-live="polite">
  Your changes have been saved.
</div>

<!-- Error alert -->
<div role="alert" aria-live="assertive">
  An error occurred. Please try again.
</div>

<!-- Loading indicator -->
<div role="status" aria-live="polite" aria-busy="true">
  Loading...
</div>
```

**ARIA live regions:**
- `aria-live="polite"`: Announced at next opportunity (status, progress)
- `aria-live="assertive"`: Announced immediately (errors, warnings)
- `role="status"`: Equivalent to aria-live="polite"
- `role="alert"`: Equivalent to aria-live="assertive"

---

## Common Violations & Fixes

### Violation 1: Missing Alt Text

**Problem:**
```html
<img src="chart.png">
```

**Fix:**
```html
<!-- Informative image -->
<img src="chart.png" alt="Sales chart showing 25% increase in Q4">

<!-- Decorative image -->
<img src="decorative-line.png" alt="">
```

---

### Violation 2: Poor Color Contrast

**Problem:**
```css
/* #999 on #FFF = 2.85:1 (FAIL) */
.text { color: #999; background: #FFF; }
```

**Fix:**
```css
/* #767676 on #FFF = 4.54:1 (PASS) */
.text { color: #767676; background: #FFF; }

/* Or use darker text */
/* #333 on #FFF = 12.63:1 (PASS) */
.text { color: #333; background: #FFF; }
```

**Check:** `python scripts/contrast-check.py #999999 #ffffff`

---

### Violation 3: Missing Form Labels

**Problem:**
```html
<input type="text" placeholder="Enter your name">
```

**Fix:**
```html
<label for="name">Name</label>
<input type="text" id="name" placeholder="Enter your name">
```

---

### Violation 4: Keyboard Inaccessible Buttons

**Problem:**
```html
<div onclick="handleClick()">Click me</div>
```

**Fix:**
```html
<!-- Option 1: Use native button -->
<button onclick="handleClick()">Click me</button>

<!-- Option 2: Add keyboard support -->
<div role="button"
     tabindex="0"
     onclick="handleClick()"
     onkeydown="if(event.key==='Enter'||event.key===' ')handleClick()">
  Click me
</div>
```

---

### Violation 5: No Focus Indicator

**Problem:**
```css
:focus { outline: none; }
```

**Fix:**
```css
/* Remove default outline but provide alternative */
:focus {
  outline: none; /* Only if you provide alternative below */
  box-shadow: 0 0 0 2px #0066CC;
  border-color: #0066CC;
}

/* Or use default outline */
:focus {
  outline: 2px solid #0066CC;
  outline-offset: 2px;
}
```

---

### Violation 6: Empty Links/Buttons

**Problem:**
```html
<a href="/profile">
  <img src="avatar.png">
</a>

<button>
  <svg><!-- Icon --></svg>
</button>
```

**Fix:**
```html
<a href="/profile">
  <img src="avatar.png" alt="View profile">
</a>

<button aria-label="Close dialog">
  <svg aria-hidden="true"><!-- Icon --></svg>
</button>
```

---

### Violation 7: Non-semantic HTML

**Problem:**
```html
<div class="heading">Page Title</div>
<div class="list">
  <div>Item 1</div>
  <div>Item 2</div>
</div>
```

**Fix:**
```html
<h1>Page Title</h1>
<ul>
  <li>Item 1</li>
  <li>Item 2</li>
</ul>
```

---

### Violation 8: Color-only Information

**Problem:**
```html
<p>Fields in red are required</p>
<span style="color: red">Email</span>
```

**Fix:**
```html
<p>Required fields are marked with an asterisk (*)</p>
<label>
  Email <span aria-label="required">*</span>
</label>
```

---

## Testing Guide

### Manual Testing

**1. Keyboard Testing:**
```
[ ] Tab through all interactive elements
[ ] All elements reachable
[ ] Logical tab order
[ ] Visible focus indicators
[ ] Enter/Space activate buttons/links
[ ] Escape closes modals
[ ] Arrow keys work in widgets (tabs, menus)
[ ] No keyboard traps
```

**2. Screen Reader Testing:**
```
[ ] All content announced
[ ] Images have alt text
[ ] Form labels announced
[ ] Error messages announced
[ ] Heading navigation works
[ ] Landmark navigation works
[ ] Links descriptive
```

**Screen readers to test:**
- **NVDA** (Windows, free)
- **JAWS** (Windows, paid)
- **VoiceOver** (Mac/iOS, built-in)
- **TalkBack** (Android, built-in)

**3. Zoom Testing:**
```
[ ] Zoom to 200%
[ ] No horizontal scroll at 200%
[ ] All content visible
[ ] All functionality works
```

**4. Color Blindness Testing:**
```
[ ] Simulate protanopia (red-blind)
[ ] Simulate deuteranopia (green-blind)
[ ] Simulate tritanopia (blue-blind)
[ ] Information not conveyed by color alone
```

Tools:
- Chrome DevTools: Rendering > Emulate vision deficiencies
- Color Oracle (desktop app)

---

### Automated Testing

**1. Browser Extensions:**

- **axe DevTools** (Chrome/Firefox/Edge) - Most comprehensive
- **WAVE** (Chrome/Firefox) - Visual feedback
- **Lighthouse** (Chrome DevTools) - Built-in

**2. Command Line Tools:**

```bash
# Pa11y
npm install -g pa11y
pa11y https://example.com

# axe-core CLI
npm install -g @axe-core/cli
axe https://example.com

# Lighthouse CI
npm install -g @lhci/cli
lhci autorun --collect.url=https://example.com
```

**3. Integration Testing:**

```javascript
// Jest + jest-axe
import { axe, toHaveNoViolations } from 'jest-axe';

expect.extend(toHaveNoViolations);

test('should not have accessibility violations', async () => {
  const { container } = render(<MyComponent />);
  const results = await axe(container);
  expect(results).toHaveNoViolations();
});
```

---

### Testing Checklist

**Quick Audit:**
```
[ ] Run axe DevTools (aim for 0 violations)
[ ] Tab through page (keyboard only)
[ ] Check color contrast (all text)
[ ] Zoom to 200% (no horizontal scroll)
[ ] Resize to 320px width (mobile test)
[ ] Check with screen reader (basic test)
```

**Comprehensive Audit:**
```
[ ] Automated tools (axe, WAVE, Lighthouse)
[ ] Keyboard navigation (all functionality)
[ ] Screen reader (NVDA/VoiceOver, full page)
[ ] Color contrast (all combinations)
[ ] Zoom/resize (200%, 320px width)
[ ] Color blindness simulation
[ ] HTML validation (W3C validator)
[ ] Touch target sizes (44px minimum)
[ ] Focus indicators (all interactive elements)
[ ] Form validation (error messages)
[ ] Dynamic content (ARIA live regions)
[ ] Modal/dialog focus management
```

---

## Tools & Resources

### Testing Tools

**Browser Extensions:**
- axe DevTools: https://www.deque.com/axe/devtools/
- WAVE: https://wave.webaim.org/extension/
- Accessibility Insights: https://accessibilityinsights.io/

**Screen Readers:**
- NVDA (Windows): https://www.nvaccess.org/
- VoiceOver (Mac): Built-in (Cmd+F5)
- JAWS (Windows): https://www.freedomscientific.com/products/software/jaws/

**Contrast Checkers:**
- Built-in: `python scripts/contrast-check.py`
- WebAIM: https://webaim.org/resources/contrastchecker/
- Colour Contrast Analyser: https://www.tpgi.com/color-contrast-checker/

**HTML Validators:**
- W3C: https://validator.w3.org/
- Nu Html Checker: https://validator.github.io/validator/

### Documentation

**Official:**
- WCAG 2.1: https://www.w3.org/WAI/WCAG21/quickref/
- ARIA Authoring Practices: https://www.w3.org/WAI/ARIA/apg/

**Guides:**
- WebAIM: https://webaim.org/
- A11y Project: https://www.a11yproject.com/
- MDN Accessibility: https://developer.mozilla.org/en-US/docs/Web/Accessibility

**ARIA Patterns:**
- Tabs: https://www.w3.org/WAI/ARIA/apg/patterns/tabs/
- Modals: https://www.w3.org/WAI/ARIA/apg/patterns/dialog-modal/
- Menus: https://www.w3.org/WAI/ARIA/apg/patterns/menu/

### Quick Reference

**Run accessibility checks:**
```bash
# WCAG checklist
bash scripts/wcag-checklist.sh

# Color contrast
python scripts/contrast-check.py #333333 #ffffff

# Responsive breakpoints
bash scripts/responsive-breakpoints.sh
```

---

## Summary: Top 10 Accessibility Rules

1. **Semantic HTML** - Use proper elements (button, a, h1, etc.)
2. **Alt text** - All images need descriptive alt attributes
3. **Color contrast** - 4.5:1 for text, 3:1 for UI components
4. **Keyboard access** - All functionality via keyboard
5. **Focus indicators** - Visible outline on focus
6. **Form labels** - Every input needs a label
7. **Heading hierarchy** - Logical H1 → H2 → H3 structure
8. **ARIA labels** - Add when semantic HTML insufficient
9. **Error messages** - Clear, actionable, announced
10. **Test with tools** - axe DevTools, keyboard, screen reader

**Remember:** Accessibility is not optional. It's a legal requirement and the right thing to do.

---

**For complete WCAG 2.1 reference, visit:**
https://www.w3.org/WAI/WCAG21/quickref/

**Run accessibility checks:**
- `bash scripts/wcag-checklist.sh` - Full WCAG AA checklist
- `python scripts/contrast-check.py #hex1 #hex2` - Color contrast check

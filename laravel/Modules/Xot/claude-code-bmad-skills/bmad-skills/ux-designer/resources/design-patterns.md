# Design Patterns Library

Complete UI pattern reference for consistent, accessible user interfaces.

---

## Table of Contents

1. [Navigation Patterns](#navigation-patterns)
2. [Form Patterns](#form-patterns)
3. [Card Patterns](#card-patterns)
4. [Modal Patterns](#modal-patterns)
5. [Button Patterns](#button-patterns)
6. [Loading Patterns](#loading-patterns)
7. [Notification Patterns](#notification-patterns)
8. [Data Display Patterns](#data-display-patterns)

---

## Navigation Patterns

### Top Navigation Bar

**Use when:** Primary navigation needs to be always visible and accessible.

**Desktop Layout:**
```
┌────────────────────────────────────────────────────────────┐
│  [Logo]    Home  Products  About  Contact    [Search] [User]│
└────────────────────────────────────────────────────────────┘
```

**Specifications:**
- **Height:** 64px (mobile), 80px (desktop)
- **Position:** Fixed or sticky top
- **Logo:** Left-aligned, 40px height, clickable to home
- **Links:** Horizontal, 16-24px spacing
- **Active state:** Underline, bold, or color change
- **Z-index:** 100 (above most content)

**States:**
- Default: Transparent or colored
- Scrolled: White with shadow (0 2px 4px rgba(0,0,0,0.1))
- Hover: Underline or color change
- Active: Bold or different color

**Accessibility:**
- `<nav aria-label="Main navigation">`
- Current page: `aria-current="page"`
- Keyboard navigable
- Focus indicators visible

**Responsive:**
- Mobile: Collapse to hamburger menu
- Tablet: Show all or collapse some items
- Desktop: Full horizontal menu

---

### Hamburger Menu (Mobile)

**Use when:** Space is limited (mobile/tablet).

**Closed State:**
```
┌─────────────────┐
│  [≡]  Logo  [⚙] │
└─────────────────┘
```

**Open State:**
```
┌─────────────────┐
│  [×]  Menu      │
├─────────────────┤
│                 │
│  • Home         │
│  • Products     │
│  • About        │
│  • Contact      │
│  • Profile      │
│  • Settings     │
│                 │
└─────────────────┘
```

**Specifications:**
- **Icon:** 24px × 24px, top-left or top-right
- **Menu:** Slide from left, right, or top
- **Backdrop:** rgba(0,0,0,0.5), click to close
- **Animation:** 300ms ease-out
- **Close:** X button, backdrop click, or Escape key

**Behavior:**
- Trap focus within menu when open
- Return focus to hamburger icon when closed
- Prevent body scroll when open
- Close on navigation

**Accessibility:**
- `<button aria-label="Open menu" aria-expanded="false">`
- Toggle aria-expanded on open/close
- Focus trap within menu
- Escape key closes menu

---

### Tab Navigation

**Use when:** Content is organized into distinct sections.

**Layout:**
```
┌────────────────────────────────────────┐
│  [Tab 1*]  [Tab 2]  [Tab 3]  [Tab 4]  │
├────────────────────────────────────────┤
│                                        │
│  Content for Tab 1                     │
│                                        │
└────────────────────────────────────────┘
```

**Specifications:**
- **Active tab:** Border-bottom 2px, bold text
- **Inactive tabs:** Muted color (#737373)
- **Hover:** Background color change
- **Height:** 48px
- **Padding:** 12px 24px

**Behavior:**
- Click to switch tabs
- Arrow keys to switch (Left/Right)
- Tab content fades in (200ms)

**Accessibility:**
- `<div role="tablist">`
- `<button role="tab" aria-selected="true">`
- `<div role="tabpanel">`
- Arrow keys navigate tabs
- Home/End keys to first/last tab

**Code Example:**
```html
<div role="tablist" aria-label="Content sections">
  <button role="tab"
          aria-selected="true"
          aria-controls="panel1"
          id="tab1">
    Tab 1
  </button>
  <button role="tab"
          aria-selected="false"
          aria-controls="panel2"
          id="tab2">
    Tab 2
  </button>
</div>

<div role="tabpanel"
     id="panel1"
     aria-labelledby="tab1">
  Content 1
</div>

<div role="tabpanel"
     id="panel2"
     aria-labelledby="tab2"
     hidden>
  Content 2
</div>
```

---

### Breadcrumbs

**Use when:** Users need to understand their location in site hierarchy.

**Layout:**
```
Home > Products > Electronics > Laptops > MacBook Pro
```

**Specifications:**
- **Font size:** 14px
- **Separator:** > or / or →
- **Current page:** Not a link, bold
- **Links:** All except current page
- **Color:** Muted (#737373), links primary color

**Accessibility:**
- `<nav aria-label="Breadcrumb">`
- `<ol>` list for semantic structure
- Current page: `aria-current="page"`

**Code Example:**
```html
<nav aria-label="Breadcrumb">
  <ol>
    <li><a href="/">Home</a></li>
    <li><a href="/products">Products</a></li>
    <li><a href="/products/electronics">Electronics</a></li>
    <li><a href="/products/electronics/laptops">Laptops</a></li>
    <li aria-current="page">MacBook Pro</li>
  </ol>
</nav>
```

---

### Sidebar Navigation

**Use when:** Many navigation items or hierarchical structure.

**Layout:**
```
┌──────────────┬────────────────────────┐
│              │                        │
│  Dashboard   │  Main Content          │
│  • Overview  │                        │
│              │                        │
│  Projects    │                        │
│  • Active    │                        │
│  • Archived  │                        │
│              │                        │
│  Settings    │                        │
│  • Profile   │                        │
│  • Account   │                        │
│              │                        │
└──────────────┴────────────────────────┘
```

**Specifications:**
- **Width:** 240px (desktop), 280px (wide)
- **Position:** Fixed or sticky
- **Active item:** Background color, bold
- **Hover:** Background color change
- **Collapsible:** Groups with expand/collapse

**Responsive:**
- Mobile: Hidden, accessible via hamburger
- Tablet: Collapsible or narrower (200px)
- Desktop: Always visible

**Accessibility:**
- `<nav aria-label="Sidebar navigation">`
- Current page: `aria-current="page"`
- Expandable groups: `aria-expanded` attribute

---

## Form Patterns

### Single Column Form

**Use when:** Most forms (mobile-first, accessible).

**Layout:**
```
┌────────────────────────────┐
│  Form Title                │
│                            │
│  First Name *              │
│  [____________________]    │
│                            │
│  Last Name *               │
│  [____________________]    │
│                            │
│  Email *                   │
│  [____________________]    │
│  ✓ Valid email format      │
│                            │
│  Password *                │
│  [____________________][👁]│
│  • 8+ characters           │
│                            │
│  [ ] Remember me           │
│                            │
│  [    Submit    ]          │
│                            │
└────────────────────────────┘
```

**Specifications:**
- **Input height:** 48px
- **Input width:** 100% (mobile), max 400px (desktop)
- **Font size:** 16px minimum (prevents iOS zoom)
- **Label position:** Above input
- **Spacing:** 16px between fields
- **Required indicator:** Asterisk (*)

**Validation:**
- On blur (not on every keystroke)
- Inline error messages
- Success indicators (green checkmark)
- Error indicators (red border + message)

**Accessibility:**
- Every input has a label
- Error messages: `role="alert"`
- Error fields: `aria-invalid="true"`
- Helper text: `aria-describedby`

---

### Input Field States

**Default:**
```
┌────────────────────────────┐
│  Email Address *           │
│  [____________________]    │
└────────────────────────────┘
```

**Focus:**
```
┌────────────────────────────┐
│  Email Address *           │
│  [████████████████] ← blue │
└────────────────────────────┘
```

**Valid:**
```
┌────────────────────────────┐
│  Email Address *           │
│  [████████████████] ✓      │
└────────────────────────────┘
```

**Error:**
```
┌────────────────────────────┐
│  Email Address *           │
│  [████████████████] ← red  │
│  ✗ Invalid email format    │
└────────────────────────────┘
```

**Specifications:**
- **Border:** 1px solid
  - Default: #D4D4D4 (Neutral-300)
  - Focus: #0066CC (Primary-500) + shadow
  - Error: #EF4444 (Error-500) + shadow
  - Success: #22C55E (Success-500)
- **Shadow on focus:** 0 0 0 3px rgba(color, 0.2)
- **Disabled:** Background #F5F5F5, cursor not-allowed

---

### Checkbox & Radio

**Checkbox:**
```
[ ] Unchecked option
[✓] Checked option
```

**Radio:**
```
( ) Unselected option
(•) Selected option
```

**Specifications:**
- **Size:** 20px × 20px (desktop), 24px × 24px (mobile)
- **Spacing:** 8px between input and label
- **Touch target:** Entire label area clickable
- **Focus:** Outline on focus

**Accessibility:**
- Group with `<fieldset>` and `<legend>`
- Each option: `<input>` + `<label>`
- Label includes input in clickable area

**Code Example:**
```html
<fieldset>
  <legend>Select your preferences</legend>

  <div>
    <input type="checkbox" id="option1" name="preferences">
    <label for="option1">Option 1</label>
  </div>

  <div>
    <input type="checkbox" id="option2" name="preferences">
    <label for="option2">Option 2</label>
  </div>
</fieldset>
```

---

### Select Dropdown

**Closed:**
```
┌────────────────────────────┐
│  Country                   │
│  [United States      [▼]] │
└────────────────────────────┘
```

**Open:**
```
┌────────────────────────────┐
│  Country                   │
│  [United States      [▲]] │
│  ┌─────────────────────┐   │
│  │ United States       │   │
│  │ Canada              │   │
│  │ United Kingdom      │   │
│  │ Australia           │   │
│  └─────────────────────┘   │
└────────────────────────────┘
```

**Specifications:**
- **Height:** 48px
- **Arrow icon:** Right-aligned
- **Dropdown:** Max height 300px, scrollable
- **Options:** Hover background color

**Accessibility:**
- Native `<select>` is best (built-in accessibility)
- Custom select: ARIA combobox pattern
- Keyboard: Arrow keys, type to search

---

### Search Input

**Layout:**
```
┌────────────────────────────┐
│  [🔍]  Search...           │
└────────────────────────────┘
```

**With Autocomplete:**
```
┌────────────────────────────┐
│  [🔍]  java                │
├────────────────────────────┤
│  JavaScript                │
│  Java                      │
│  Java Spring Boot          │
└────────────────────────────┘
```

**Specifications:**
- **Icon:** Left side, 20px × 20px
- **Padding:** 12px 16px 12px 48px
- **Clear button:** X icon on right when filled
- **Autocomplete:** Max 8 results
- **Debounce:** 300ms delay before search

**Accessibility:**
- `<input type="search">`
- `<label>` or `aria-label="Search"`
- Clear button: `aria-label="Clear search"`
- Results: `role="listbox"` with `role="option"`

---

## Card Patterns

### Basic Card

**Layout:**
```
┌────────────────────┐
│  [Image 16:9]      │
├────────────────────┤
│  Card Title        │
│  Description text  │
│  continues here... │
│                    │
│  [Read More]       │
└────────────────────┘
```

**Specifications:**
- **Border-radius:** 8px
- **Padding:** 16px (mobile), 24px (desktop)
- **Shadow:** 0 2px 8px rgba(0,0,0,0.1)
- **Image:** aspect-ratio 16:9 or 1:1
- **Title:** H3, 20px
- **Description:** 16px, line-height 1.5

**States:**
- **Default:** Subtle shadow
- **Hover:** Shadow 0 4px 16px rgba(0,0,0,0.15), scale 1.02
- **Focus:** 2px outline (keyboard navigation)
- **Transition:** 200ms ease

**Accessibility:**
- Entire card clickable (wrap in `<a>` if link)
- Title as main link
- Image: Descriptive alt text or decorative

---

### Card Grid

**Layout:**
```
Desktop (3 columns):
┌─────┐ ┌─────┐ ┌─────┐
│Card│ │Card│ │Card│
│  1 │ │  2 │ │  3 │
└─────┘ └─────┘ └─────┘

┌─────┐ ┌─────┐ ┌─────┐
│Card│ │Card│ │Card│
│  4 │ │  5 │ │  6 │
└─────┘ └─────┘ └─────┘
```

**Specifications:**
- **Desktop:** 3 columns, gap 24px
- **Tablet:** 2 columns, gap 16px
- **Mobile:** 1 column, gap 16px
- **Equal height:** Within rows

**Code Example:**
```css
.card-grid {
  display: grid;
  gap: 16px;
  grid-template-columns: 1fr;
}

@media (min-width: 768px) {
  .card-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
  }
}

@media (min-width: 1024px) {
  .card-grid {
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
  }
}
```

---

### Product Card

**Layout:**
```
┌────────────────────┐
│  [Product Image]   │
│  [Wishlist ♡]      │
├────────────────────┤
│  Product Name      │
│  ★★★★☆ (24)        │
│  $99.99            │
│  [Add to Cart]     │
└────────────────────┘
```

**Specifications:**
- **Image:** 1:1 aspect ratio, 300px × 300px
- **Wishlist:** Top-right overlay button
- **Rating:** Stars + count
- **Price:** Large, bold
- **Button:** Full width or centered

**States:**
- Hover: Image zoom 1.1×
- Quick view: Hover shows additional info
- Out of stock: Disabled button, gray overlay

---

## Modal Patterns

### Modal Dialog

**Layout:**
```
┌─────────────────────────────────────┐
│  [Backdrop - rgba(0,0,0,0.5)]       │
│                                     │
│    ┌─────────────────────────┐     │
│    │ Dialog Title        [×] │     │
│    ├─────────────────────────┤     │
│    │                         │     │
│    │  Dialog content goes    │     │
│    │  here with information  │     │
│    │  or form elements       │     │
│    │                         │     │
│    ├─────────────────────────┤     │
│    │      [Cancel] [Confirm] │     │
│    └─────────────────────────┘     │
│                                     │
└─────────────────────────────────────┘
```

**Specifications:**
- **Modal:** Max-width 600px, centered
- **Padding:** 24px
- **Close button:** Top-right, 24px × 24px
- **Backdrop:** rgba(0,0,0,0.5)
- **Z-index:** 1000+
- **Border-radius:** 8px

**Behavior:**
- **Open:** Fade in (200ms)
- **Close:** Fade out (200ms)
- **Focus:** Move to modal on open
- **Focus trap:** Keep focus within modal
- **Return focus:** To trigger element on close
- **Escape key:** Closes modal
- **Backdrop click:** Closes modal (optional)

**Accessibility:**
```html
<div role="dialog"
     aria-modal="true"
     aria-labelledby="dialog-title"
     aria-describedby="dialog-description">

  <h2 id="dialog-title">Dialog Title</h2>

  <p id="dialog-description">
    Dialog content...
  </p>

  <button onclick="closeDialog()">Cancel</button>
  <button onclick="confirmDialog()">Confirm</button>
</div>
```

**Focus Management:**
```javascript
// Save last focused element
const lastFocus = document.activeElement;

// Move focus to first focusable element in modal
const firstFocusable = modal.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
firstFocusable.focus();

// Trap focus (Tab key)
// Handle Escape key to close

// On close, return focus
lastFocus.focus();
```

---

### Confirmation Modal

**Layout:**
```
┌───────────────────────────┐
│  [⚠] Confirm Action   [×] │
├───────────────────────────┤
│                           │
│  Are you sure you want to │
│  delete this item?        │
│                           │
│  This cannot be undone.   │
│                           │
├───────────────────────────┤
│     [Cancel]  [Delete]    │
└───────────────────────────┘
```

**Specifications:**
- Smaller than regular modal (max-width 400px)
- Warning icon (if destructive action)
- Clear explanation of consequence
- Cancel button (secondary)
- Confirm button (primary or danger)

---

### Drawer (Side Panel)

**Layout:**
```
┌─────────┬───────────────────────┐
│         │ ┌───────────────────┐ │
│         │ │ Drawer Title  [×] │ │
│         │ ├───────────────────┤ │
│  Main   │ │                   │ │
│ Content │ │  Drawer content   │ │
│         │ │                   │ │
│         │ └───────────────────┘ │
│         │                       │
└─────────┴───────────────────────┘
```

**Specifications:**
- **Width:** 320px (mobile), 400px (desktop)
- **Position:** Fixed right or left
- **Slide in:** From right or left (300ms)
- **Backdrop:** rgba(0,0,0,0.5)
- **Content:** Scrollable if overflow

**Use when:**
- Filters/settings panel
- Shopping cart
- Notifications
- Additional information

---

## Button Patterns

### Button Hierarchy

**Primary Button:**
```
[  Primary Action  ]
```
- Solid background (Primary-500)
- White text
- Most important action
- One per screen section

**Secondary Button:**
```
[  Secondary Action  ]
```
- Outlined (Primary-500 border)
- Primary-500 text
- White background
- Medium importance

**Tertiary Button:**
```
[  Tertiary Action  ]
```
- No background or border
- Primary-500 text
- Underline on hover
- Lowest importance

**Specifications:**
- **Height:** 48px (mobile), 40px (desktop)
- **Min width:** 120px
- **Padding:** 16px 32px
- **Border-radius:** 8px
- **Font:** 16px, medium weight

---

### Button States

**Default:**
```
[ Button ]
```

**Hover:**
```
[ Button ] ← Darken 10%
```

**Focus:**
```
[ Button ] ← 2px outline
```

**Active (pressed):**
```
[ Button ] ← Darken 20%
```

**Disabled:**
```
[ Button ] ← 50% opacity
```

**Loading:**
```
[ ⟳ Loading... ]
```

**CSS Example:**
```css
.button {
  background: #0066CC;
  color: white;
  padding: 12px 32px;
  border-radius: 8px;
  transition: all 200ms ease;
}

.button:hover {
  background: #0052A3;
}

.button:focus {
  outline: 2px solid #0066CC;
  outline-offset: 2px;
}

.button:active {
  background: #003D7A;
}

.button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
```

---

### Icon Buttons

**Layout:**
```
[×]  [♡]  [⋮]  [⚙]
```

**Specifications:**
- **Size:** 40px × 40px (desktop), 44px × 44px (mobile)
- **Icon:** 20px × 20px (centered)
- **Border-radius:** 50% (circular) or 8px (rounded)
- **Background:** Transparent, colored on hover

**Accessibility:**
```html
<button aria-label="Close dialog">
  <svg aria-hidden="true"><!-- X icon --></svg>
</button>

<button aria-label="Add to favorites">
  <svg aria-hidden="true"><!-- Heart icon --></svg>
</button>
```

---

### Button Groups

**Layout:**
```
[ Option 1 ][ Option 2 ][ Option 3 ]
```

**Segmented Control:**
```
┌─────────┬─────────┬─────────┐
│ Left    │ Center  │ Right   │
└─────────┴─────────┴─────────┘
```

**Specifications:**
- Buttons connected (no gap)
- Active button: Filled background
- Inactive buttons: Outlined
- First button: Left border-radius
- Last button: Right border-radius

---

## Loading Patterns

### Spinner

**Layout:**
```
    ⟳
Loading...
```

**Specifications:**
- **Size:** 24px (inline), 48px (page center)
- **Animation:** Rotate 360deg, 1s linear infinite
- **Color:** Primary-500 or current text color

**Accessibility:**
```html
<div role="status" aria-live="polite">
  <svg aria-hidden="true"><!-- Spinner --></svg>
  <span>Loading...</span>
</div>
```

---

### Skeleton Screen

**Layout:**
```
┌────────────────────────────┐
│  ▓▓▓▓▓▓▓▓▓▓▓▓              │
│  ▓▓▓▓▓▓ ▓▓▓▓▓▓▓            │
│                            │
│  ▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓         │
│  ▓▓▓▓▓▓▓▓▓▓                │
└────────────────────────────┘
```

**Use when:** Loading content with known structure.

**Specifications:**
- Gray blocks (#E5E5E5)
- Animated shimmer (optional)
- Match layout of real content
- Replace with real content when loaded

---

### Progress Bar

**Layout:**
```
Uploading file... 45%
████████████▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓
```

**Specifications:**
- **Height:** 8px (slim), 16px (chunky)
- **Border-radius:** 4px
- **Fill:** Primary-500
- **Background:** Neutral-200
- **Label:** Above or below

**Accessibility:**
```html
<div role="progressbar"
     aria-valuenow="45"
     aria-valuemin="0"
     aria-valuemax="100"
     aria-label="Upload progress">
  <div class="progress-fill" style="width: 45%"></div>
</div>
```

---

## Notification Patterns

### Toast Notification

**Layout:**
```
┌────────────────────────────┐
│  ✓ Success message here    │
│  [×]                       │
└────────────────────────────┘
```

**Specifications:**
- **Position:** Top-right, bottom-right, or top-center
- **Width:** 320px (desktop), 90% (mobile)
- **Padding:** 16px
- **Duration:** 3-5 seconds (auto-dismiss)
- **Animation:** Slide in + fade in, slide out + fade out

**Types:**
- Success: Green (#22C55E)
- Error: Red (#EF4444)
- Warning: Yellow (#F59E0B)
- Info: Blue (#3B82F6)

**Accessibility:**
```html
<div role="status" aria-live="polite">
  Success message here
</div>

<!-- For errors -->
<div role="alert" aria-live="assertive">
  Error message here
</div>
```

---

### Banner Notification

**Layout:**
```
┌─────────────────────────────────────────────────┐
│  ⓘ  This is an important message      [×]       │
└─────────────────────────────────────────────────┘
```

**Specifications:**
- **Position:** Top of page (below header)
- **Width:** 100%
- **Padding:** 12px 16px
- **Dismissible:** X button or auto-dismiss
- **Sticky:** Can be fixed to top

**Use when:**
- System-wide messages
- Cookie notices
- Feature announcements
- Warnings/errors affecting entire site

---

### Inline Alert

**Layout:**
```
┌────────────────────────────┐
│  ⚠  Warning message        │
│  Additional details here.  │
└────────────────────────────┘
```

**Specifications:**
- **Border-left:** 4px solid (colored)
- **Background:** Tinted (colored at 10% opacity)
- **Padding:** 16px
- **Border-radius:** 4px
- **Icon:** Left-aligned

**Use when:**
- Contextual messages
- Form validation summary
- Section-specific alerts

---

## Data Display Patterns

### Table

**Layout:**
```
┌──────────┬──────────┬──────────┐
│  Name    │  Email   │  Role    │
├──────────┼──────────┼──────────┤
│  John    │  j@ex.co │  Admin   │
│  Jane    │  jane@   │  User    │
│  Bob     │  bob@    │  User    │
└──────────┴──────────┴──────────┘
```

**Specifications:**
- **Header:** Bold, background color
- **Rows:** Alternating colors (zebra striping)
- **Hover:** Row highlight
- **Padding:** 12px 16px
- **Borders:** 1px solid Neutral-200

**Responsive:**
- Mobile: Card view or horizontal scroll
- Tablet: Visible columns, scroll if needed
- Desktop: Full table

**Accessibility:**
```html
<table>
  <caption>User list</caption>
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Role</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>John</td>
      <td>john@example.com</td>
      <td>Admin</td>
    </tr>
  </tbody>
</table>
```

---

### List

**Unordered List:**
```
• Item 1
• Item 2
• Item 3
```

**Ordered List:**
```
1. First step
2. Second step
3. Third step
```

**Description List:**
```
Name:     John Doe
Email:    john@example.com
Role:     Administrator
```

**Specifications:**
- **Spacing:** 8px between items
- **Bullet/number:** Aligned left
- **Indent:** 24px for nested lists

---

### Accordion

**Closed:**
```
┌────────────────────────────┐
│  ▶ Section Title 1         │
├────────────────────────────┤
│  ▶ Section Title 2         │
├────────────────────────────┤
│  ▶ Section Title 3         │
└────────────────────────────┘
```

**Open:**
```
┌────────────────────────────┐
│  ▼ Section Title 2         │
│                            │
│  Content for section 2     │
│  goes here...              │
│                            │
├────────────────────────────┤
```

**Specifications:**
- **Header:** 48px height, clickable
- **Icon:** Arrow right (closed), arrow down (open)
- **Animation:** Expand/collapse 300ms ease
- **Multiple:** Allow multiple open or single

**Accessibility:**
```html
<div>
  <button aria-expanded="false"
          aria-controls="panel1">
    Section Title
  </button>
  <div id="panel1" hidden>
    Content...
  </div>
</div>
```

---

## Summary

**Key Principles:**

1. **Consistency** - Use same patterns throughout
2. **Accessibility** - Follow WCAG 2.1 AA guidelines
3. **Responsive** - Design for all screen sizes
4. **Feedback** - Provide clear states (hover, focus, loading)
5. **Simplicity** - Don't over-complicate patterns

**Pattern Selection:**

- Navigation: Top bar (desktop), hamburger (mobile), tabs (content sections)
- Forms: Single column, inline validation, clear errors
- Cards: Grid layout, hover effects, equal heights
- Modals: Centered, backdrop, focus trap, Escape key
- Buttons: Clear hierarchy (primary/secondary/tertiary)
- Loading: Skeleton (known structure), spinner (unknown duration)
- Notifications: Toast (temporary), banner (persistent), inline (contextual)

**For more details:**
- REFERENCE.md - Complete pattern implementations
- accessibility-guide.md - WCAG compliance details
- design-tokens.md - Colors, spacing, typography

---

**Remember:** Patterns should be reused, not reinvented. Consistency creates familiarity, familiarity creates usability.

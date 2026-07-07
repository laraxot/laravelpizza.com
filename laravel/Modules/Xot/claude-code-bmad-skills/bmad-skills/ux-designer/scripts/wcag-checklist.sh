#!/bin/bash

# WCAG 2.1 Level AA Compliance Checklist
# Output a comprehensive accessibility checklist

cat << 'EOF'
================================================================================
                    WCAG 2.1 Level AA Compliance Checklist
================================================================================

PERCEIVABLE - Information and UI components must be presentable to users

1. Text Alternatives (1.1)
   [ ] 1.1.1 Non-text Content (A)
       - All images have descriptive alt text
       - Decorative images have empty alt="" or role="presentation"
       - Form inputs have associated labels
       - Icons have aria-label or visually hidden text

2. Time-based Media (1.2)
   [ ] 1.2.1 Audio-only and Video-only (A)
       - Audio-only: Transcript provided
       - Video-only: Audio track or transcript provided
   [ ] 1.2.2 Captions (A)
       - Captions provided for all prerecorded audio in video
   [ ] 1.2.3 Audio Description or Media Alternative (A)
       - Audio description or transcript for prerecorded video
   [ ] 1.2.4 Captions (Live) (AA)
       - Captions provided for all live audio
   [ ] 1.2.5 Audio Description (AA)
       - Audio description for all prerecorded video

3. Adaptable (1.3)
   [ ] 1.3.1 Info and Relationships (A)
       - Semantic HTML (headings, lists, tables, forms)
       - Information structure programmatically determined
       - ARIA labels where semantic HTML insufficient
   [ ] 1.3.2 Meaningful Sequence (A)
       - Reading order is logical and meaningful
       - Tab order follows visual order
   [ ] 1.3.3 Sensory Characteristics (A)
       - Instructions don't rely solely on shape, size, location, orientation
   [ ] 1.3.4 Orientation (AA)
       - Content works in both portrait and landscape
   [ ] 1.3.5 Identify Input Purpose (AA)
       - Input fields have autocomplete attributes where appropriate

4. Distinguishable (1.4)
   [ ] 1.4.1 Use of Color (A)
       - Color is not the only visual means of conveying information
   [ ] 1.4.2 Audio Control (A)
       - Auto-playing audio can be paused/stopped
   [ ] 1.4.3 Contrast (Minimum) (AA) **CRITICAL**
       - Text contrast >= 4.5:1 (normal text)
       - Text contrast >= 3:1 (large text 18px+ or bold 14px+)
       - UI component contrast >= 3:1
       - Use: python scripts/contrast-check.py #foreground #background
   [ ] 1.4.4 Resize Text (AA)
       - Text can be resized up to 200% without loss of content/functionality
   [ ] 1.4.5 Images of Text (AA)
       - Avoid images of text (use actual text)
   [ ] 1.4.10 Reflow (AA)
       - No horizontal scrolling at 320px width (vertical scrolling okay)
       - No vertical scrolling at 256px height (for horizontal content)
   [ ] 1.4.11 Non-text Contrast (AA)
       - UI components and graphics have >= 3:1 contrast
   [ ] 1.4.12 Text Spacing (AA)
       - Content adapts when users increase spacing
   [ ] 1.4.13 Content on Hover or Focus (AA)
       - Tooltips/popovers are dismissable, hoverable, persistent

================================================================================

OPERABLE - UI components and navigation must be operable

2. Keyboard Accessible (2.1)
   [ ] 2.1.1 Keyboard (A) **CRITICAL**
       - All functionality available via keyboard
       - No keyboard-only actions (keyboard + mouse both work)
   [ ] 2.1.2 No Keyboard Trap (A)
       - User can move focus away from any component using keyboard
       - Modal dialogs trap focus appropriately (can close with Esc)
   [ ] 2.1.4 Character Key Shortcuts (A)
       - Single-key shortcuts can be turned off or remapped

3. Enough Time (2.2)
   [ ] 2.2.1 Timing Adjustable (A)
       - User can extend, adjust, or turn off time limits
   [ ] 2.2.2 Pause, Stop, Hide (A)
       - Moving, blinking, auto-updating content can be paused

4. Seizures and Physical Reactions (2.3)
   [ ] 2.3.1 Three Flashes or Below Threshold (A)
       - No content flashes more than 3 times per second

5. Navigable (2.4)
   [ ] 2.4.1 Bypass Blocks (A)
       - Skip links to bypass repeated content
   [ ] 2.4.2 Page Titled (A)
       - Pages have descriptive <title> elements
   [ ] 2.4.3 Focus Order (A)
       - Focus order is logical and preserves meaning
   [ ] 2.4.4 Link Purpose (In Context) (A)
       - Link text describes destination/purpose
   [ ] 2.4.5 Multiple Ways (AA)
       - Multiple ways to find pages (nav, search, sitemap)
   [ ] 2.4.6 Headings and Labels (AA)
       - Headings and labels are descriptive
   [ ] 2.4.7 Focus Visible (AA) **CRITICAL**
       - Keyboard focus indicator is visible (2px outline minimum)

6. Input Modalities (2.5)
   [ ] 2.5.1 Pointer Gestures (A)
       - Multi-point or path-based gestures have single-pointer alternative
   [ ] 2.5.2 Pointer Cancellation (A)
       - Click completes on up-event, not down-event
   [ ] 2.5.3 Label in Name (A)
       - Visible label text is included in accessible name
   [ ] 2.5.4 Motion Actuation (A)
       - Functions triggered by motion have UI alternative

================================================================================

UNDERSTANDABLE - Information and UI operation must be understandable

3. Readable (3.1)
   [ ] 3.1.1 Language of Page (A)
       - Page has lang attribute (<html lang="en">)
   [ ] 3.1.2 Language of Parts (AA)
       - Language changes are marked (lang attribute on element)

4. Predictable (3.2)
   [ ] 3.2.1 On Focus (A)
       - Receiving focus doesn't cause unexpected context change
   [ ] 3.2.2 On Input (A)
       - Changing input doesn't cause unexpected context change
   [ ] 3.2.3 Consistent Navigation (AA)
       - Navigation mechanisms are in consistent order
   [ ] 3.2.4 Consistent Identification (AA)
       - Components with same functionality are labeled consistently

5. Input Assistance (3.3)
   [ ] 3.3.1 Error Identification (A) **CRITICAL**
       - Errors are clearly identified and described
   [ ] 3.3.2 Labels or Instructions (A) **CRITICAL**
       - Labels provided for all form inputs
       - Instructions provided when needed
   [ ] 3.3.3 Error Suggestion (AA)
       - Error messages suggest corrections
   [ ] 3.3.4 Error Prevention (Legal, Financial, Data) (AA)
       - Submissions are reversible, checked, or confirmed

================================================================================

ROBUST - Content must be robust enough for assistive technologies

4. Compatible (4.1)
   [ ] 4.1.1 Parsing (A)
       - HTML is valid (no duplicate IDs, proper nesting)
   [ ] 4.1.2 Name, Role, Value (A)
       - UI components have proper names, roles, states
       - Use semantic HTML or ARIA attributes
   [ ] 4.1.3 Status Messages (AA)
       - Status messages are announced to screen readers
       - Use aria-live, role="status", role="alert"

================================================================================

ADDITIONAL BEST PRACTICES

Touch Targets:
   [ ] Minimum 44px x 44px for all interactive elements
   [ ] Minimum 8px spacing between touch targets

Forms:
   [ ] Required fields marked (not just with color)
   [ ] Error messages associated with inputs (aria-describedby)
   [ ] Success messages announced
   [ ] Validation on blur, not on every keystroke

Loading States:
   [ ] Loading indicators have aria-live="polite"
   [ ] Skeleton screens or spinners have accessible labels

Modals/Dialogs:
   [ ] Focus moves to modal when opened
   [ ] Focus trapped within modal
   [ ] Escape key closes modal
   [ ] Focus returns to trigger when closed
   [ ] role="dialog" and aria-modal="true"

Images:
   [ ] Informative images: Descriptive alt text
   [ ] Decorative images: Empty alt="" or role="presentation"
   [ ] Complex images: Long description via aria-describedby
   [ ] Background images: Not used for important content

Tables:
   [ ] <th> elements for headers
   [ ] scope attribute on headers (col/row)
   [ ] <caption> element for table description

Links vs Buttons:
   [ ] Links: Navigate (use <a>)
   [ ] Buttons: Actions (use <button>)
   [ ] Never <div> or <span> with click handlers (use proper elements)

================================================================================

TESTING CHECKLIST

Manual Testing:
   [ ] Keyboard navigation (Tab, Shift+Tab, Arrow keys, Enter, Space)
   [ ] Screen reader (NVDA, JAWS, VoiceOver)
   [ ] Browser zoom to 200%
   [ ] Mobile responsive test at 320px width
   [ ] Color contrast check (python scripts/contrast-check.py)
   [ ] Turn off CSS (content still makes sense)

Automated Testing Tools:
   [ ] axe DevTools browser extension
   [ ] Lighthouse accessibility audit
   [ ] WAVE browser extension
   [ ] Pa11y or similar CLI tools

User Testing:
   [ ] Test with users who use assistive technologies
   [ ] Test with keyboard-only users
   [ ] Test with users who have low vision
   [ ] Test with users who have cognitive disabilities

================================================================================

QUICK REFERENCE COMMANDS

Check color contrast:
  python scripts/contrast-check.py #333333 #ffffff

View responsive breakpoints:
  bash scripts/responsive-breakpoints.sh

Validate HTML:
  # Use W3C validator or browser DevTools

Run automated accessibility audit:
  # Use Lighthouse in Chrome DevTools
  # Or install axe DevTools extension

================================================================================

WCAG 2.1 AA compliance is the MINIMUM. Aim for AAA where possible.

For detailed guidance, see:
  - resources/accessibility-guide.md
  - https://www.w3.org/WAI/WCAG21/quickref/

================================================================================
EOF

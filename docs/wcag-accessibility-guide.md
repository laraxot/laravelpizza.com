# WCAG Accessibility Guide - Meetup Theme

## Core Principles (POUR)

-   **Perceivable**: Information and user interface components must be presentable to users in ways they can perceive.
    -   Provide text alternatives for non-text content.
    -   Provide captions and other alternatives for multimedia.
    -   Create content that can be presented in different ways without losing information or structure.
    -   Make it easier for users to see and hear content including separating foreground from background.
-   **Operable**: User interface components and navigation must be operable.
    -   Make all functionality available from a keyboard.
    -   Provide users enough time to read and use content.
    -   Do not use content that is known to cause seizures.
    -   Provide ways to help users navigate, find content, and determine where they are.
-   **Understandable**: Information and the operation of user interface must be understandable.
    -   Make text readable and understandable.
    -   Make Web pages appear and operate in predictable ways.
    -   Help users avoid and correct mistakes.
-   **Robust**: Content must be robust enough that it can be interpreted by a wide variety of user agents, including assistive technologies.
    -   Maximize compatibility with current and future user agents, including assistive technologies.

## Implementation Guidelines

-   **Semantic HTML**: Use correct semantic HTML5 elements (e.g., `<header>`, `<nav>`, `<main>`, `<article>`, `<section>`, `<footer>`, `<button>`, `<input>`, `<label>`) to convey meaning and structure to assistive technologies.
-   **Keyboard Navigation**: Ensure all interactive elements are reachable and operable via keyboard alone. Implement visible focus indicators.
-   **Color Contrast**: Maintain a minimum contrast ratio of 4.5:1 for regular text and 3:1 for large text (WCAG AA). Tools like [WebAIM Contrast Checker](https://webaim.org/resources/contrastchecker/) can help.
-   **Text Alternatives**: Provide meaningful `alt` text for all `<img>` tags. Transcripts and captions for multimedia content.
-   **Form Labels**: Always associate `<label>` elements with their form controls using the `for` and `id` attributes. Avoid using placeholder text as the only label.
-   **Error Identification**: Clearly identify input errors and provide suggestions for correction. Link error messages directly to the problematic fields.
-   **Headings**: Use headings (`<h1>` through `<h6>`) to organize content hierarchically and provide an outline for screen readers. Do not skip heading levels.
-   **Language**: Specify the primary language of the page using the `lang` attribute on the `<html>` tag (e.g., `<html lang="it">`).
-   **Responsive Design**: Ensure content adapts well to different screen sizes and orientations.
-   **ARIA Attributes**: Use ARIA (Accessible Rich Internet Applications) roles, states, and properties when native HTML elements cannot convey the necessary semantics or functionality to assistive technologies. Use sparingly and correctly.
-   **Focus Management**: Manage focus changes dynamically (e.g., after a modal opens or closes) to ensure users of assistive technologies don't get lost.
-   **Time Limits**: Provide users with options to extend or turn off time limits for tasks, unless the time limit is essential.

## Specific to Registration Forms

-   **Clear Instructions**: Provide clear instructions for filling out the form, especially for complex fields.
-   **Inline Validation**: Provide real-time, clear, and actionable feedback for form validation errors.
-   **Password Requirements**: Explicitly state password requirements and provide a "show password" toggle.
-   **Error Summaries**: For forms with multiple errors, provide a summary of errors at the top of the form, with links to the problematic fields.
-   **Required Fields**: Clearly indicate required fields (e.g., with an asterisk and `aria-required="true"`).

## Tools for Testing

-   **Browser Extensions**: Axe DevTools, Lighthouse (built into Chrome DevTools), WAVE.
-   **Screen Readers**: NVDA (Windows), VoiceOver (macOS/iOS), TalkBack (Android).
-   **Keyboard Navigation**: Test interacting with the entire interface using only the keyboard.
-   **Color Contrast Checkers**: WebAIM Contrast Checker.

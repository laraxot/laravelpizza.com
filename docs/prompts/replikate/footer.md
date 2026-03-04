# Task: Footer UI/UX and Content Alignment

## Objective
Replicate the footer from the target site (`https://laravelpizza.com/`) ensuring visual parity, correct LaravelPizza content, and adherence to the project's Laraxot architecture.

## Target Reference
- **URL**: `https://laravelpizza.com/` (footer appears on ALL pages)
- **Visual Goal**: Very dark background (~slate-950/#0b1120), light text, 3-column layout, subtle top border, bottom bar with copyright.

## Architectural Constraints & Implementation Guide

1. **Component Invocation**: The footer is rendered globally via `<x-section slug="footer" />`. Do NOT call a Blade component directly.

2. **Component Logic**: The slug → Blade view resolution is in `laravel/Modules/Cms/app/View/Components/Section.php`. Study this file to understand data flow.

3. **Data Source**: Footer content is in `laravel/config/local/laravelpizza/database/content/sections/footer.json`. Content changes go here, NOT hardcoded in Blade.

4. **Blade View**: Currently referenced in footer.json as `pub_theme::components.blocks.navigation.footer-institutional`.

5. **Styling**:
   - Use Tailwind CSS classes only. No inline styles.
   - Background: Very dark slate (~#0b1120 / slate-950)
   - Text: White (headings/brand), gray-400 (descriptions), gray-500 (muted/copyright)
   - Border: Subtle slate-700 border-top for bottom bar
   - Responsive: columns stack on mobile (grid-cols-1 → lg:grid-cols-3)

6. **URL Localization**: All footer links MUST use `LaravelLocalization::localizeUrl('/path')`. Never hardcode locale prefix like `/it/events`. Never write bare paths without localization.

7. **SVG Icons**: No inline SVG in Blade files. Logo and social icons must be SVG files in `Modules/Meetup/resources/svg/` and called via `<x-filament::icon icon="meetup-{name}" class="..." />`.

## Content Specification (LaravelPizza Brand)

Based on actual target site screenshots (Feb 2026):

### Column 1: Brand
- **Logo**: Pizza slice SVG icon (red) + "Laravel Pizza Meetups" (white, bold)
- **Description**: "Bringing together Laravel, Filament, and Livewire enthusiasts over delicious pizza. Join our community and connect with fellow developers."
- **Social Icons**: GitHub, Twitter/X (small gray icons, hover → white)

### Column 2: Quick Links
- **Title**: "Quick Links" (white, bold, sm text)
- **Items** (gray-300, hover → white):
  - Events
  - Community Chat
  - Dashboard

### Column 3: Community
- **Title**: "Community" (white, bold, sm text)
- **Items** (gray-300, hover → white):
  - About Us
  - Code of Conduct
  - Contact

### Bottom Bar
- Subtle border-top (slate-700 or slate-800)
- Centered: "Made with ♥ for the Laravel community" (gray-500, text-sm)

## Current footer.json State

The current `footer.json` already has correct LaravelPizza content with 3 link groups (Community, Company, Legal). Compare with target:
- Target shows 2 groups (Quick Links, Community) — we can keep 3 as an improvement
- Verify brand name matches: "Laravel Pizza Meetups"
- Verify social links icons render correctly

## Verification Checklist

- [ ] Background is very dark (slate-950), NOT navy blue (#1e3a5f)
- [ ] Text contrast is WCAG 2.1 AA compliant on dark bg
- [ ] 3-column layout on desktop, stacked on mobile
- [ ] All links use `LaravelLocalization::localizeUrl()`
- [ ] SVG icons use `<x-filament::icon>` pattern, no inline SVG
- [ ] No "Unable to locate view" errors
- [ ] Footer consistent across all pages (home, events, about, etc.)
- [ ] Social icons render correctly (GitHub, Twitter/X)
- [ ] Bottom bar has subtle border and centered copyright text
- [ ] Build: `npm run build && npm run copy` after CSS/JS changes

## Common Mistakes to Avoid

- **Wrong content domain**: Footer is about Laravel meetups. NO "Marco Sottana", "Consulenza Sicurezza", "Radioprotezione", "Odontoiatria", "Medicina Veterinaria", "D.Lgs 101/2020"
- **Wrong colors**: Background is slate-950 (very dark), NOT navy blue (#1e3a5f) or gradients
- **Wrong column count**: Target has 3 columns (Brand + 2 link groups), NOT 4
- **Wrong namespace**: Never use `two::` or other theme prefixes
- **Hardcoded URLs**: Never write `/it/events` — always `LaravelLocalization::localizeUrl('/events')`
- **Inline SVG**: Never paste SVG markup in Blade — create `.svg` file and use icon component
- **Missing build**: Always run `npm run build && npm run copy` after changes

## Critical Workflow Reminder

After CSS/JS changes in Meetup theme:
1. `cd laravel/Themes/Meetup/`
2. `npm run build`
3. `npm run copy`
4. Hard refresh browser

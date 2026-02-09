# Prompt Writing Guide for Meetup Theme

This guide establishes the strict rules for writing prompts for the Meetup theme. All new and updated prompts must adhere to these standards.

## 1. Path Corrections & Naming Conventions

**CRITICAL**: Always use correct paths for LaravelPizza Meetup theme:

- **Theme Path**: `laravel/Themes/Meetup/`
  - ❌ WRONG: `Themes/Meetup`, `Themes/Meet`, `Two/`
  - ❌ WRONG: `/Themes/Meetup/` (absolute path)
  - ✅ CORRECT: `laravel/Themes/Meetup/`

- **Module Path**: `laravel/Modules/Meetup/`
  - ❌ WRONG: `Modules/Meetup`, `Modules/Quaeris`
  - ✅ CORRECT: `laravel/Modules/Meetup/`

- **Config Path**: `laravel/config/local/laravelpizza/`
  - ❌ WRONG: `config/local/laravelpizza`, `config/local/quaeris`
  - ✅ CORRECT: `laravel/config/local/laravelpizza/`

- **Public Assets**: `public_html/themes/Meetup/`
  - ✅ CORRECT: Destination for `npm run copy`

- **Namespace**:
  - PHP: `Modules\Meetup\` and `Themes\Meetup\`
  - Blade Components: `themes.meetup.components.*`

## 2. Architecture & Strict Rules (Laraxot)

### Filament Rules
- ❌ NEVER extend Filament classes directly
- ✅ ALWAYS extend `XotBase*` classes:
  - `XotBaseResource` instead of `Resource`
  - `XotBasePage` instead of `Page`
  - `XotBaseChartWidget` instead of `ChartWidget`
  - `XotBaseSection` instead of `Section`
- ❌ NEVER use `->label()`, `->placeholder()`, `->tooltip()` on Filament components
- ✅ Translations handled automatically by LangServiceProvider
- ✅ Pattern: `{modulo}::{widget}.fields.{campo}.{tipo}`

### Model Rules
- ❌ NEVER use `property_exists()` on Eloquent models (attributes are magical)
- ✅ ALWAYS use:
  - `isset($model->attribute)`
  - `$model->hasAttribute('attribute')`
  - `$model->isFillable('attribute')`
  - `SafeAttributeCastAction` for type safety
- ✅ Always use `belongsToManyX()` for many-to-many relations, never `belongsToMany()`

### Frontoffice Rules
- ❌ NO controllers for public pages
- ✅ Use Laravel Folio for routing
- ✅ Use Laravel Volt for interactive components
- ✅ Use Blade Components in `laravel/Themes/Meetup/resources/views/components/`

### Content Rules
- ❌ NO hardcoded content in Blade files
- ✅ Use JSON files in `laravel/config/local/laravelpizza/database/content/`
- ✅ Content pages follow pattern: `{slug}.json`

### Service Rules
- ❌ NO traditional Service classes
- ✅ Use Spatie Queueable Actions
- ✅ Actions encapsulate business logic

### Testing Rules
- ✅ ALWAYS use Pest PHP
- ❌ NEVER use PHPUnit
- ❌ NEVER use `RefreshDatabase` trait
- ✅ Use transactions or proper setup/teardown

### Documentation Rules
- ✅ Updates to `docs/` folders are MANDATORY
- ✅ Study docs BEFORE making changes
- ✅ Update docs AFTER making changes
- ✅ Use lowercase filenames (except `README.md`, `CHANGELOG.md`)

### File Modification Rules (NEW 2026-02-09)
- ✅ Before modifying ANY file, create `.lock` file with same name
- ✅ If `.lock` already exists, work on other files
- ✅ After completing modification, delete the `.lock` file
- ✅ This prevents concurrent modification conflicts

### Translation Rules (NEW 2026-02-09)
- ✅ Translation files MUST contain content in target language, NOT English
- ✅ Italian files → Italian content, German files → German content, etc.
- ✅ Only keep translations for ACTIVE enum fields
- ✅ Remove translations for commented/deprecated enum cases
- ✅ Check all 6 languages: it, en, de, fr, es, ru

## 3. Front-End Development (Folio + Volt + Filament)

### Routing
- Use Laravel Folio
- Pages in `laravel/Themes/Meetup/resources/views/pages/`
- Pattern: `[slug].blade.php` for dynamic pages
- NO manual route definitions in `web.php`

### Logic
- Use Laravel Volt for reactive components
- Use Livewire for dynamic features
- NO traditional controllers

### UI Components
- Blade Components in `laravel/Themes/Meetup/resources/views/components/`
- Blocks in `components/blocks/`
- Sections in `components/sections/`
- Layouts in `components/layouts/`

### Content Structure
- Data-driven via JSON files
- `content_blocks` array in JSON
- Each block maps to a Blade component
- Dynamic loading via CMS module

## 4. Language & Tone

### Language
- Prompts can be in Italian or English
- Technical terms and paths must be EXACT
- Use consistent terminology

### Tone
- Professional but approachable
- Strict on rules, flexible on implementation
- "Super Mucca" methodology: high standards, zero errors
- Encourage learning and improvement

## 5. LaravelPizza Brand Guidelines

### Content Rules
- ❌ NEVER use content from other businesses
- ❌ NEVER use "Marco Sottana", "Consulenza Sicurezza"
- ❌ NEVER use medical/dental/veterinary content
- ✅ ALWAYS use LaravelPizza brand
- ✅ Focus on Laravel development, meetups, community
- ✅ Topics: Events, workshops, networking, PHP, Laravel

### Color Palette (verified from actual site screenshots Feb 2026)
- Background Primary: #0f172a (Tailwind slate-900) — nav, hero, page bg
- Background Darker: #0b1120 (~slate-950) — footer
- Card Background: #1e293b (slate-800) — feature cards
- Accent/CTA: #dc2626 (Tailwind red-600) — buttons, highlights, "Pizza. Community." text
- Text Primary: #ffffff (white) — headings
- Text Secondary: #9ca3af (gray-400) — body text
- Text Muted: #6b7280 (gray-500) — copyright, subtle text
- Border: #334155 (slate-700) — dividers on dark bg

**WARNING**: Do NOT use these wrong colors from previous versions:
- #0f2b46 (wrong navy), #ef4444 (wrong red), #f97316 (wrong orange), #06b6d4 (wrong cyan), #f8fafc (wrong light bg)

### URL Structure
- Target: Flat URLs (/{slug})
- Local: Multilingual via Folio (`/{locale}/...`)
- **ALWAYS** use `LaravelLocalization::localizeUrl('/path')` — never hardcode locale prefix
- Language selector: `LaravelLocalization::getLocalizedURL($code, null, [], true)`
- Current locale: `LaravelLocalization::getCurrentLocale()`

### SVG Icons
- **NO inline SVG** in Blade files
- Create `.svg` files in `Modules/Meetup/resources/svg/`
- Use: `<x-filament::icon icon="meetup-{filename}" class="..." />`
- Prefix `meetup-` is registered by XotBaseServiceProvider

### Many-to-Many Relations
- **ALWAYS** `$this->belongsToManyX(Related::class)`, never `belongsToMany()`

## 6. UI/UX & WCAG 2.1 AAA Standards (NEW 2026-02-09)

### Layout & Spacing Best Practices
- Form containers: minimum `max-w-3xl` (768px) for readability
- Padding: `p-8 sm:p-12` for adequate whitespace
- Spacing between sections: `space-y-8` for clear hierarchy
- Input fields: `min-height: 48px` for touch targets
- Checkbox containers: `min-height: 48px` for accessibility

### WCAG 2.1 AAA Compliance Requirements
- **Focus Indicators**: 3px thickness with 3:1 contrast ratio
- **Text Contrast**: 7:1 for normal text (vs 4.5:1 AA)
- **Large Text**: 4.5:1 contrast (18pt+ or 14pt+ bold)
- **Touch Targets**: 48×48px minimum (AAA recommendation)
- **Error Messages**: Clear, accessible with color and text
- **Reduced Motion**: Support for `prefers-reduced-motion`

### Focus Indicator Implementation
```css
:where(a, button, input, select, textarea, summary, [tabindex]:not([tabindex="-1"])):focus-visible {
    outline: 3px solid var(--color-blue-600);
    outline-offset: 3px;
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
}
```

### Color Contrast Verification
- Test all color combinations with contrast checker
- Ensure 7:1 for text, 3:1 for UI components
- Verify in both light and dark modes
- Test with color blindness simulators

### Accessibility Testing Checklist
- [ ] Keyboard navigation complete
- [ ] Screen reader compatibility
- [ ] Voice control compatibility
- [ ] Magnification support (200%)
- [ ] High contrast mode
- [ ] Reduced motion preferences
- [ ] Color blindness verification

### Visual Hierarchy Principles
- Section headers with gradient backgrounds
- Border-left indicators for sections
- Progressive disclosure for complex forms
- Clear distinction between required and optional fields
- Visual grouping with consistent spacing

### Content Rules
- ❌ NEVER use content from other businesses
- ❌ NEVER use "Marco Sottana", "Consulenza Sicurezza"
- ❌ NEVER use medical/dental/veterinary content
- ✅ ALWAYS use LaravelPizza brand
- ✅ Focus on Laravel development, meetups, community
- ✅ Topics: Events, workshops, networking, PHP, Laravel

### Color Palette (verified from actual site screenshots Feb 2026)
- Background Primary: #0f172a (Tailwind slate-900) — nav, hero, page bg
- Background Darker: #0b1120 (~slate-950) — footer
- Card Background: #1e293b (slate-800) — feature cards
- Accent/CTA: #dc2626 (Tailwind red-600) — buttons, highlights, "Pizza. Community." text
- Text Primary: #ffffff (white) — headings
- Text Secondary: #9ca3af (gray-400) — body text
- Text Muted: #6b7280 (gray-500) — copyright, subtle text
- Border: #334155 (slate-700) — dividers on dark bg

**WARNING**: Do NOT use these wrong colors from previous versions:
- #0f2b46 (wrong navy), #ef4444 (wrong red), #f97316 (wrong orange), #06b6d4 (wrong cyan), #f8fafc (wrong light bg)

### URL Structure
- Target: Flat URLs (/{slug})
- Local: Multilingual via Folio (`/{locale}/...`)
- **ALWAYS** use `LaravelLocalization::localizeUrl('/path')` — never hardcode locale prefix
- Language selector: `LaravelLocalization::getLocalizedURL($code, null, [], true)`
- Current locale: `LaravelLocalization::getCurrentLocale()`

### SVG Icons
- **NO inline SVG** in Blade files
- Create `.svg` files in `Modules/Meetup/resources/svg/`
- Use: `<x-filament::icon icon="meetup-{filename}" class="..." />`
- Prefix `meetup-` is registered by XotBaseServiceProvider

### Many-to-Many Relations
- **ALWAYS** `$this->belongsToManyX(Related::class)`, never `belongsToMany()`

## 6. Standard Prompt Template

```text
# Task: [Task Name]

## Objective
[Clear description of what needs to be done]

## Context
We are working on [Task Name] in `laravel/Themes/Meetup/`.

## Reference
- `laravel/Themes/Meetup/docs/rules-index.md`
- `laravel/Modules/Xot/docs/critical-rules-consolidated.md`
- `laravel/Themes/Meetup/docs/replikate/replicate.md`

## Strict Rules
- ✅ Use `laravel/Themes/Meetup/` not `Themes/Meetup`
- ✅ Extend `XotBase...` classes
- ✅ No `property_exists()` on Eloquent models
- ✅ Update `docs/` before and after code
- ✅ Use LaravelPizza content only
- ✅ Localize all URLs with LaravelLocalization

## Workflow
1. Study existing documentation
2. Identify the issue/requirement
3. Implement following Laraxot patterns
4. Test with PHPStan Level 10
5. Update documentation
6. Verify in browser

## Expected Outcome
[Description of what success looks like]
```

## 7. Critical Workflow Reminders

### CSS/JS Changes
```bash
cd laravel/Themes/Meetup/
npm run build
npm run copy
# Then verify in browser with hard refresh
```

### PHP Changes
- Verify with PHPStan Level 10
- Check syntax with `php -l`
- Test functionality

### Content Changes
- Update JSON files in `laravel/config/local/laravelpizza/database/content/`
- Verify block component exists
- Test page rendering

## 8. Common Mistakes to Avoid

- ❌ Wrong theme paths (Two, Meet, Meetup)
- ❌ Extending Filament classes directly
- ❌ Using `property_exists()` on models
- ❌ Hardcoding URLs without localization
- ❌ Forgetting `npm run build && npm run copy`
- ❌ Not updating documentation
- ❌ Using content from other businesses
- ❌ Creating controllers for public pages

## 9. Quality Standards

### Code Quality
- PHPStan Level 10 compliance
- Clean, readable code
- Proper error handling
- Type safety where possible

### Documentation Quality
- Clear, concise instructions
- Accurate paths and references
- Up-to-date information
- Examples where helpful

### Visual Quality
- Pixel-parity with target
- Responsive design
- Accessible (WCAG 2.1 AA)
- Consistent styling

## 10. Learning & Improvement

### After Each Task
1. Document what was learned
2. Identify patterns that emerged
3. Note any rules that need clarification
4. Update this guide if needed

### Continuous Improvement
- This guide is a living document
- Update it when new patterns emerge
- Share learnings with team
- Maintain high standards

---


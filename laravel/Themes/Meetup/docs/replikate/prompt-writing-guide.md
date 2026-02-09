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

### Model Rules
- ❌ NEVER use `property_exists()` on Eloquent models (attributes are magical)
- ✅ ALWAYS use:
  - `isset($model->attribute)`
  - `$model->hasAttribute('attribute')`
  - `$model->isFillable('attribute')`
  - `SafeAttributeCastAction` for type safety

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

### Color Palette
- Primary Dark: #0f2b46 (navy)
- Primary: #ef4444 (red-orange)
- Secondary: #f97316 (orange)
- Accent: #06b6d4 (cyan)
- Background: #f8fafc (light gray)

### URL Structure
- Target: Flat URLs (/{slug})
- Local: Multilingual ({lang}/pages/{slug})
- Use `LaravelLocalization::localizeUrl()` for all URLs

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

*This guide is maintained by the Meetup theme development team. Last updated: February 2026*
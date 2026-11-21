# Task: Homepage Content Review

## Objective
Analyze the homepage for content-related issues, specifically looking for duplicated or placeholder content that doesn't belong to LaravelPizza.com.

## URL
- **Local Homepage**: http://127.0.0.1:8000/it
- **Target Reference**: https://laravelpizza.com/

## Instructions

### 1. Review Content
Carefully inspect the rendered homepage at the URL above. Look for:
- Content that doesn't match LaravelPizza brand
- Text from other business domains (e.g., "Marco Sottana", "Consulenza Sicurezza", "Odontoiatria", "Medicina Veterinaria")
- Generic placeholder text (e.g., "Lorem Ipsum", "Dolor sit amet")
- Content from TechPlanner or other projects

### 2. Identify Duplication
Check if any sections, blocks, or text passages appear more than once without a clear design reason. Common duplication patterns:
- Hero content repeated in features section
- Same CTA text appearing multiple times
- Duplicate descriptions across cards

### 3. Check for Placeholder Content
Identify any content that needs to be replaced with domain-specific text for LaravelPizza.com:

**Expected LaravelPizza Content**:
- Brand: LaravelPizza
- Focus: Laravel development, meetups, community
- Topics: Events, workshops, networking, PHP, Laravel
- Tone: Tech-focused, community-oriented, welcoming

**Wrong Content Examples**:
- ❌ "Marco Sottana - Consulenza Sicurezza"
- ❌ "Odontoiatria", "Medicina Veterinaria"
- ❌ "Radioprotezione", "Biosicurezza"
- ❌ "Via Vanzo 86/A, Mogliano Veneto"
- ❌ Any content not related to Laravel development

### 4. Analyze Content Source
Check the JSON configuration file:
- Path: `laravel/config/local/laravelpizza/database/content/pages/home.json`
- Verify that `content_blocks` array contains correct block types
- Check that each block has appropriate LaravelPizza-specific content

### 5. Block Component Verification
For each content block type in home.json:
- Verify the corresponding Blade component exists in `laravel/Themes/Meetup/resources/views/components/blocks/`
- Check that the component is rendering the content correctly
- Ensure no hardcoded wrong content in the Blade files

### 6. Update Documentation
After the analysis, study and update the `docs` folders:
- `laravel/Themes/Meetup/docs/` - Document findings
- `laravel/Modules/Cms/docs/` - Update if CMS-related issues found
- Create a report in `laravel/Themes/Meetup/docs/reports/` detailing:
  - What content issues were found
  - What content needs to be replaced
  - Recommended content structure for LaravelPizza
  - Before/after screenshots (if applicable)

## Expected Content Structure

Based on `replicate.md`, the LaravelPizza homepage should have:
1. Hero Section - Pizza/meetup imagery, community-focused headline
2. Features/Benefits - Why participate in Laravel meetups
3. Events Showcase - Upcoming Laravel events
4. Community/Speakers - Testimonials from developers
5. Latest Blog Posts - Laravel-related articles
6. Newsletter CTA - Stay updated on Laravel events

## Critical Issues to Report

If you find any of the following, report immediately:
- Content from "Marco Sottana" or other businesses
- Content about dentistry, veterinary medicine, or medical compliance
- Placeholder or lorem ipsum text
- Broken or missing content blocks
- Wrong URLs (should use `/it/pages/...` pattern)

## Workflow Reminder

**DOPO ogni modifica CSS/JS nel tema Meetup:**
1. cd laravel/Themes/Meetup/
2. npm run build
3. npm run copy
4. Verifica nel browser con hard refresh

## URL Mapping Reference

Remember: Target site uses flat URLs, local uses multilingual via Folio
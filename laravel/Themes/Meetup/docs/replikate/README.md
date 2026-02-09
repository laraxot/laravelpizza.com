# Replicate Prompts — LaravelPizza.com

This directory contains structured prompts and reference documents to guide the replication and improvement of `https://laravelpizza.com/` into the local `Meetup` theme.

## Core Reference

- **`replicate.md`** — Foundational analysis: target site structure (verified from screenshots), color palette, typography, implementation plan. **Always refer to this for design specs.**

- **`reference_analysis.md`** — Extended analysis with content management rules, workflow, task-specific instructions.

## Actionable Prompts

- **`main_replication_prompt.md`** — Master prompt for overall site alignment. Step-by-step process, architectural rules, verification.

- **`footer_improvement_prompt.md`** — Focused prompt for footer alignment: content, layout, colors, localization.

- **`home_content_review_prompt.md`** — Task for analyzing homepage content: wrong domain content, duplications, placeholder text.

## Guides

- **`prompt-writing-guide.md`** — Rules for writing prompts in this theme: correct paths, architecture rules, brand guidelines, standard template.

- **`corrections-summary-2026-02-09.md`** — Summary of all corrections applied to fix critical errors (wrong business domain, wrong colors, missing rules).

## Legacy Files

- **`replikate_footer.txt`** — DEPRECATED. Replaced by `footer_improvement_prompt.md`.
- **`start.txt`** — User instructions / workflow philosophy reference.

## Workflow

1. **Start with `main_replication_prompt.md`** for the overall task
2. **Consult `replicate.md`** for design specifications
3. **Use specific prompts** for focused tasks (footer, homepage review)
4. **Document progress** in `laravel/Themes/Meetup/docs/` and `laravel/Modules/Meetup/docs/`

## Critical Rules

- **Content**: LaravelPizza (Laravel meetups/community). NEVER use "Marco Sottana", medical/safety content
- **Colors**: Slate-900 (#0f172a) bg + Red-600 (#dc2626) accent. NOT #0f2b46 or #ef4444
- **Paths**: Always `laravel/Themes/Meetup/`, `laravel/Modules/Meetup/`
- **URLs**: Always `LaravelLocalization::localizeUrl('/path')`, never hardcode locale
- **SVG**: No inline SVG in Blade. Files in `Modules/Meetup/resources/svg/` + `<x-filament::icon>`
- **Architecture**: Folio + Volt + JSON CMS-driven pages. NO controllers.
- **Build**: `npm run build && npm run copy` after CSS/JS changes

# Using the Replicate Prompts

This directory contains a set of structured prompts and reference documents to guide the development process of replicating and improving upon the target website design, specifically `https://laravelpizza.com/`.

## Core Reference

- **`replicate.md`**
  This is the foundational analysis document. It contains a detailed breakdown of the target site's structure, a list of issues with our current implementation, a color palette, and a comprehensive implementation plan. **Always refer to this document for specific design and structural details.**

## Actionable Prompts

These files are structured as tasks for a developer or an AI assistant to execute.

- **`main_replication_prompt.md`**
  This is the "master" prompt for the overall site alignment task. It outlines the high-level, step-by-step process, emphasizing architectural rules and the verification process.

- **`footer_improvement_prompt.md`**
  A specific, focused prompt for rebuilding the site's footer to match the target design and content.

- **`home_content_review_prompt.md`**
  A task for analyzing the homepage to find and report content issues like duplication or placeholder text.

## Prompt Writing Guide

- **`prompt-writing-guide.md`**
  Establishes strict rules for writing prompts in this theme, including path corrections, architectural rules, and standard templates.

## Legacy Files (Deprecated)

- **`replikate_footer.txt`**
  Legacy file replaced by `footer_improvement_prompt.md`. Kept for reference but should not be used.

## Workflow

1. **Start with `main_replication_prompt.md`** to understand the overall task and workflow.
2. **Consult `replicate.md`** for detailed specifications.
3. **Use the specific prompts** (`footer_improvement_prompt.md`, `home_content_review_prompt.md`) to execute focused tasks.
4. **Always document your progress** and findings in the relevant `docs` folders as instructed in the prompts.

## Critical Rules

- **DO NOT** use "Marco Sottana" or any content from other business domains
- **ALWAYS** reference LaravelPizza.com content and brand
- **ALWAYS** use correct paths: `laravel/Themes/Meetup/`, `laravel/Modules/Meetup/`
- **ALWAYS** follow Laraxot architecture (Folio + Volt + Filament)
- **ALWAYS** update documentation before and after changes

## URL Mapping

Target site: https://laravelpizza.com/
Local site: http://127.0.0.1:8000/it

- / → /it
- /chi-siamo → /it/pages/chi-siamo
- /eventi → /it/pages/eventi
- /blog → /it/pages/blog
- /faq → /it/pages/faq
- /contatti → /it/pages/contatti
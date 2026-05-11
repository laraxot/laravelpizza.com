---
name: concepts
description: Central hub for geo module architectural rules and patterns.
type: directory
---

# Geolocation Component Rules

## Final Constructor Rule
- Prevent overriding final `__construct()` from `Filament\Forms\Components\Field`
- Details: [final-constructor-rule.md](concepts/final-constructor-rule.md)

## Blade Template Location Rule
- No dedicated Blade files for dynamic wizard pages
- All UIs rendered via Livewire widgets with JSON config
- Details: [blade-template-location-rule.md](concepts/blade-template-location-rule.md)

## Static Analysis Workflow
- Mandatory post-edit static analysis
- Tools: PHPStan, PHPMD, PHP Insights, Visual Parity
- Details: [static-analysis-workflow.md](concepts/static-analysis-workflow.md)

## Related Resources
- Livewire widget architecture: [wiki/heroku/…](wiki/heroku)
- Database schema documentation: [wiki/heroku/…](wiki/heroku)

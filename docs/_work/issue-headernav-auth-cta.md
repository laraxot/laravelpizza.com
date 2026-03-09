## Problem
In headernav guest state, auth CTA labels can appear in Italian (`Accedi`, `Registrati`) even when locale is not Italian.

## Goals
- enforce locale-correct labels for login/register
- improve visual hierarchy and accessibility of auth CTA buttons
- add Pest regression coverage

## Scope
- `laravel/Modules/Cms/resources/views/components/headernav/simple.blade.php`
- `laravel/Modules/Cms/resources/views/components/blocks/headernav/simple.blade.php`
- related test(s)

## Acceptance criteria
- labels use theme localization keys (`pub_theme::navigation.auth.*`)
- no hardcoded/legacy auth keys producing wrong language in header
- CTA hierarchy improved (secondary login, primary register) with clear focus-visible states
- Pest test verifies localization key usage and legacy key removal

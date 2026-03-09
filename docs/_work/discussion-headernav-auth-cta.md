## Context
Header auth CTAs in guest state need two fixes:
1. strict locale-correct labels (no Italian labels outside `it`)
2. clearer visual hierarchy and accessibility for login/register buttons

## Proposal
- Replace legacy auth translation keys with theme navigation keys:
  - `pub_theme::navigation.auth.login`
  - `pub_theme::navigation.auth.register`
- Keep login as secondary action and register as primary action.
- Add explicit focus-visible ring classes and better contrast.
- Add Pest regression test to enforce key usage and prevent fallback regressions.

## Tracking
- Issue: #557

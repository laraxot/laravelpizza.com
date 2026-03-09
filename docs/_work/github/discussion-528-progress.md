Progress update before implementation.

The analysis confirms that the best DRY/KISS direction is still presenter-only refinement:

- keep `ResolvePageAction` as the single source of truth for model resolution;
- avoid new domain logic in the theme;
- render organizer/owner, attendance mode and optional metadata only if present on the resolved `Event`;
- replace misleading RSVP behavior with an honest state when there is no `registration_url`.

I have already updated the local documentation first, then I am moving to:

- theme presenter cleanup;
- translation additions for the new labels;
- Pest assertions for the improved detail page;
- phpstan/phpmd/phpinsights on the touched PHP scope.

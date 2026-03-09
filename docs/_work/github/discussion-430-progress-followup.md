Progress update on the event-detail incident:

- corrected the dynamic model resolution in `ResolvePageAction`;
- validated that `/it/events/{slug}` now renders the real event instead of the generic fallback;
- reinforced the contract `route layer resolves model -> theme block only renders`;
- Pest coverage now includes both the resolver path and the localized event detail page.

Current status: verified fix, no more fallback message on the tested real event slug.

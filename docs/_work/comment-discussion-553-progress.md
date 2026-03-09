Implementation progress linked to issue #550:

- Added centralized page-level schema builder in Cms (`PageSchemaBuilder`) to map route/page context to schema.org page types.
- Integrated this into shared metatags component so pages now emit JSON-LD page schema by default.
- Added Pest tests for key mappings:
  - home -> WebPage
  - events index -> CollectionPage
  - event detail -> ItemPage (+ mainEntity Event link)
  - profile.edit -> ProfilePage (+ mainEntity Person)
  - auth.login -> WebPage

Quality checks executed on touched files:
- Pest: passed
- PHPStan: passed
- PHPInsights: passed run (style warnings include pre-existing syntax issues in unrelated Cms files)
- PHPMD: binary not present in current vendor/bin

Next step proposed: align route-level mapping for additional page types (AboutPage/ContactPage) as those routes become explicit in Folio/CMS route names.

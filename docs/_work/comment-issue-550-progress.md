Progress update:

## Docs first (completed)
- `laravel/Modules/Cms/docs/webpage-profilepage-rollout.md`
- `laravel/Themes/Meetup/docs/webpage-profilepage-route-map.md`

## Implementation (completed)
- Added page-schema builder:
  - `laravel/Modules/Cms/app/Support/PageSchemaBuilder.php`
- Wired metatags component to emit page-level JSON-LD:
  - `laravel/Modules/Cms/app/View/Components/Metatags.php`
  - `laravel/Modules/Cms/resources/views/components/metatags.blade.php`

## Tests (completed)
- Added Pest coverage for route->page-type mapping:
  - `laravel/Modules/Cms/tests/Unit/Support/PageSchemaBuilderTest.php`

## Quality gates run
- Pest: ✅ `5 passed (19 assertions)`
- PHPStan (targeted files): ✅ no errors
- PHPInsights (targeted files): ✅ run completed (code 98, architecture 88.2)
- PHPMD: ⚠️ `./vendor/bin/phpmd` not available in this workspace

## Notes
- Current profile route available is `profile.edit`; schema emits `ProfilePage` with `mainEntity: Person` when user context exists.
- Event detail continues to emit entity-level `Event` JSON-LD in block layer; this change adds a centralized page-level schema layer.

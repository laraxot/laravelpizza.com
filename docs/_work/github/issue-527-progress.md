Progress update after docs-first analysis.

Confirmed on the real event `id-id-quidem-quae-eveniet-Jy1p`:

- detail route resolves correctly and returns the real `Event` model;
- current page is functional but incomplete;
- organizer/host is available in data but not rendered;
- attendance mode is available but not rendered;
- location needs a more useful presentation;
- RSVP must stop implying a real booking flow when `registration_url` is absent.

Docs updated before code changes:

- `laravel/Themes/Meetup/docs/troubleshooting/event-detail-ux-gaps-id-id-quidem.md`
- `laravel/Modules/Meetup/docs/event-detail-page-status.md`
- `docs/rules/post-edit-php-quality-gate-rule.md`
- `docs/memory/php-quality-gate-memory.md`
- `docs/skills/post-edit-php-quality-gate-skill.md`

Next implementation step:

1. improve the presenter in `Themes/Meetup/resources/views/components/blocks/events/detail.blade.php`;
2. keep it query-free in the standard detail path;
3. add organizer, attendance mode, honest CTA and optional metadata rendering;
4. extend Pest coverage and run phpstan/phpmd/phpinsights on the touched PHP scope.

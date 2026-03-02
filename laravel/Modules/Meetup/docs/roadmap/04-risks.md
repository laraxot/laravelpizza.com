# Risks & Dependencies

## Dependencies
- **Modules\Cms**: Required for frontend rendering.
- **Modules\User**: Required for authentication and profiles.
- **Modules\Notify**: Required for communications.

## Risks
- **Data Consistency**: Ensuring `current_attendees` matches registration count.
- **Performance**: Heavy queries on event listing pages (need optimization/caching).
- **SEO**: Ensuring all slugs are unique and valid.

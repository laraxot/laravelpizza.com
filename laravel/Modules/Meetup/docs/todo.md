# TODO List - Meetup Module

## Completed

- [x] Module structure and ServiceProvider
- [x] Event model and migration
- [x] EventResource Filament admin
- [x] EventCalendarWidget (saade/filament-fullcalendar)
- [x] Homepage with CMS-driven blocks
- [x] Header/Footer sections
- [x] SVG icons system
- [x] WCAG 2.1 AA accessibility
- [x] PHPStan Level 10 compliance

## In Progress

- [ ] Events listing page (connect to Event model, replace static JSON)
- [ ] Event detail page with Schema.org JSON-LD
- [ ] Multi-language content (6 languages: it, en, es, de, fr, ru)

## To Do

### Models & Database
- [ ] `meetup_performers` table and Performer model (speakers)
- [ ] `meetup_event_performer` pivot (belongsToManyX)
- [ ] `meetup_venues` table and Venue model
- [ ] `meetup_registrations` table and Registration model
- [ ] `meetup_sponsors` table and Sponsor model

### CMS Pages (JSON-driven)
- [ ] about.json — About page
- [ ] contact.json — Contact form
- [ ] blog.json — Blog/articles listing
- [ ] faq.json — FAQ page
- [ ] privacy.json — Privacy policy
- [ ] terms.json — Terms of service
- [ ] speakers.json — Speaker profiles

### Filament Admin
- [ ] PerformerResource (extends XotBaseResource)
- [ ] VenueResource (extends XotBaseResource)
- [ ] RegistrationResource (extends XotBaseResource)
- [ ] SponsorResource (extends XotBaseResource)

### Actions (Spatie QueueableAction)
- [ ] CreateEventAction with execute()
- [ ] RegisterAttendeeAction with execute()
- [ ] SendEventNotificationAction with execute()
- [ ] CancelRegistrationAction with execute()

### Frontend
- [ ] Event registration form (Volt component)
- [ ] Speaker profile cards
- [ ] Venue map integration (Geo module)
- [ ] SEO meta tags and Open Graph
- [ ] Sitemap generation

### Testing
- [ ] Pest tests for all Actions
- [ ] Feature tests for CMS page rendering
- [ ] Filament resource CRUD tests

# Task: Implement Food Establishment Integration

**Priority**: MEDIUM
**Status**: TODO
**Estimated Effort**: 2 days
**Reference**: [Schema.org FoodEstablishment](https://schema.org/FoodEstablishment)

---

## Objective

Create a `FoodEstablishment` model to manage partner venues (pizzerias, restaurants) that host meetups, with proper Schema.org structured data for local SEO.

---

## Key Schema.org Properties

| Property | Type | Description |
|----------|------|-------------|
| `servesCuisine` | Text | Types of cuisine served |
| `acceptsReservations` | Boolean | Reservation capability |
| `openingHours` | Text | Opening hours specification |
| `priceRange` | Text | Price range indicator (€-€€€€) |
| `menu` | Menu/URL | Restaurant menu |
| `amenityFeature` | LocationFeatureSpecification | WiFi, Parking, etc. |

---

## Database Schema

```sql
-- meetup_food_establishments table
id, name, description, establishment_type, serves_cuisine (JSON),
price_range, accepts_reservations, opening_hours (JSON), menu_url,
address_id, latitude, longitude, telephone, email, url, logo,
cover_image, social_links (JSON), amenities (JSON), seating_capacity,
is_partner, partner_since
```

---

## Implementation Steps

- [ ] Create `EstablishmentType` enum
- [ ] Create `meetup_food_establishments` migration
- [ ] Create `FoodEstablishment` model
- [ ] Add `venue_id` to events table
- [ ] Implement `toSchemaOrg()` method
- [ ] Create Filament resource
- [ ] Update Event model with venue relationship
- [ ] Write Pest tests

---

**Reference**: [schema-org-research-comprehensive.md](./schema-org-research-comprehensive.md)

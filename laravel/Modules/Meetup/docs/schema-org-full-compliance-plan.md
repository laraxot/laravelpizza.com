# Schema.org Compliance — Full Gap Analysis & Implementation Plan

> **Goal**: Every page and model in the Meetup module must emit complete `application/ld+json` structured data following Schema.org specifications, making the project **rich snippets ready**.

---

## Page-to-Schema.org Type Mapping

| Project Page | Schema.org `@type` | `mainEntity` |
|---|---|---|
| Homepage (`/it`) | `WebPage` | — |
| Events list (`/it/events`) | `CollectionPage` | `ItemList` of `Event` |
| Event detail (`/it/events/{slug}`) | `WebPage` | `Event` |
| Profile page (`/it/profile/{id}`) | `ProfilePage` | `Person` |
| Terms (`/it/terms`) | `WebPage` | — |
| Privacy (`/it/privacy`) | `WebPage` | — |
| About (`/it/about`) | `AboutPage` | `Organization` |
| Contact (`/it/contact`) | `ContactPage` | `Organization` |
| Login / Register | `WebPage` | — |

---

## Model-to-Schema.org Type Mapping & Gap Analysis

### 1. `Event` → `schema.org/Event`

**Currently Has**: name, startDate, endDate, eventStatus, eventAttendanceMode, location (text), url, description, image, organizer (Person), offers, inLanguage, duration, maximumAttendeeCapacity.

**Missing (MUST ADD)**:

| Schema.org Property | DB Column / Source | Priority |
|---|---|---|
| `about` | `json about` or relation | Medium |
| `aggregateRating` | Computed from Feedback model | Low |
| `attendee` | `attendees()` relation count | High |
| `audience` | `audience` column (exists) | ✅ Already in DB |
| `doorTime` | `door_time` column (exists) | ✅ Already in DB |
| `isAccessibleForFree` | `is_accessible_for_free` column (exists) | ✅ Already in DB |
| `keywords` | `keywords` column (exists) | ✅ Already in DB |
| `maximumPhysicalAttendeeCapacity` | New column or from `max_attendees` | Medium |
| `maximumVirtualAttendeeCapacity` | New column | Low |
| `performer` | `performers()` relation | High |
| `previousStartDate` | `previous_start_date` column (exists) | ✅ Already in DB |
| `remainingAttendeeCapacity` | Computed: `max_attendees - attendees_count` | High |
| `review` | from Feedback model | Low |
| `sponsor` | `sponsors()` relation | High |
| `subEvent` / `superEvent` | `super_event_id` column (exists) | ✅ Already in DB |
| `typicalAgeRange` | `typical_age_range` column (exists) | ✅ Already in DB |
| `alternateName` | `alternate_name` column (exists) | ✅ Already in DB |
| `identifier` | `id` | ✅ Auto |
| `sameAs` | New JSON column or `meta_data` | Medium |

> [!IMPORTANT]
> Many columns already exist in the DB but are NOT being emitted in `toSchemaOrg()`. The first action is to include them.

---

### 2. `Venue` → `schema.org/Place`

**Currently Has**: name, address, city, country, latitude, longitude, capacity, website, phone, description.

**Missing (MUST ADD `toSchemaOrg()`)**:

| Schema.org Property | Source | Priority |
|---|---|---|
| `@type` | `"Place"` | Critical |
| `name` | `name` column | ✅ |
| `address` → `PostalAddress` | `address`, `city`, `country` | High |
| `geo` → `GeoCoordinates` | `latitude`, `longitude` | High |
| `maximumAttendeeCapacity` | `capacity` | High |
| `telephone` | `phone` | High |
| `url` | `website` | High |
| `description` | `description` | High |
| `photo` | New column or `meta_data` | Medium |
| `hasMap` | Computed from lat/lng | Low |
| `publicAccess` | New column | Low |
| `isAccessibleForFree` | New column | Low |

---

### 3. `Profile` → `schema.org/Person` (on `ProfilePage`)

**Currently Has**: first_name, last_name, phone, email.

**Missing (MUST ADD `toSchemaOrg()`)**:

| Schema.org Property | Source | Priority |
|---|---|---|
| `@type` | `"Person"` | Critical |
| `givenName` | `first_name` | High |
| `familyName` | `last_name` | High |
| `email` | `email` | High |
| `telephone` | `phone` | High |
| `image` | `avatar` accessor | High |
| `jobTitle` | New column or `extra` | Medium |
| `affiliation` | New column or `extra` | Medium |
| `sameAs` | Social links in `extra` | Medium |
| `knowsAbout` | New field or `extra` | Low |
| `knowsLanguage` | New field or `extra` | Low |
| `url` | Profile page URL | High |

---

### 4. `Performer` → `schema.org/Person`

**Currently Has**: name, type, bio, photo, website, email, company, twitter, linkedin, github.

**Missing (MUST ADD `toSchemaOrg()`)**:

| Schema.org Property | Source | Priority |
|---|---|---|
| `@type` | `"Person"` | Critical |
| `name` | `name` | ✅ |
| `description` | `bio` | High |
| `image` | `photo` | High |
| `url` | `website` | High |
| `email` | `email` | High |
| `affiliation` → `Organization` | `company` | High |
| `sameAs` | `[twitter, linkedin, github]` URLs | High |
| `jobTitle` | `type` (e.g., "Speaker") | High |
| `performerIn` | `events()` relation | Medium |

---

### 5. `Sponsor` → `schema.org/Organization`

**Currently Has**: name, level, website, logo, description, email, contact_person.

**Missing (MUST ADD `toSchemaOrg()`)**:

| Schema.org Property | Source | Priority |
|---|---|---|
| `@type` | `"Organization"` | Critical |
| `name` | `name` | ✅ |
| `url` | `website` | High |
| `logo` | `logo` | High |
| `description` | `description` | High |
| `email` | `email` | High |
| `contactPoint` | `contact_person` + `email` | High |
| `sponsor` (reverse link) | `events()` relation | Medium |

---

## Implementation Steps

### Phase 1: Emit Existing Data (No Schema Changes)
1. **Update `Event::toSchemaOrg()`** to include all existing columns: `doorTime`, `isAccessibleForFree`, `keywords`, `audience`, `typicalAgeRange`, `previousStartDate`, `alternateName`, `remainingAttendeeCapacity` (computed), `performer` (relation), `sponsor` (relation).
2. **Add `toSchemaOrg()`** to `Venue`, `Performer`, `Sponsor`, `Profile`.
3. **Update `Event::toSchemaOrg()` location** to use `Venue::toSchemaOrg()` when `location_id` is set.

### Phase 2: JSON-LD Emission in Blade Templates
4. Ensure the metatags component emits `<script type="application/ld+json">` with the correct `@type` per page.
5. Event detail pages emit `Event` JSON-LD.
6. Profile pages emit `ProfilePage` with `mainEntity: Person`.
7. List pages emit `CollectionPage` with `ItemList`.

### Phase 3: Missing Schema Data (DB Changes)
8. Add missing columns where needed (e.g., `sameAs` on profiles).
9. Store secondary Schema.org properties in `meta_data` JSON columns.

---

## Verification Plan

### Automated Tests
- `phpstan analyse Modules/Meetup` — zero errors
- Pest tests asserting `toSchemaOrg()` returns valid structures
- Test that JSON-LD `<script>` tags are present in page HTML

### Manual Verification
- Use [Google Rich Results Test](https://search.google.com/test/rich-results) on event detail pages
- Use [Schema.org Validator](https://validator.schema.org/) on all page types

---

## References

- [schema.org/Event](https://schema.org/Event)
- [schema.org/WebPage](https://schema.org/WebPage)
- [schema.org/ProfilePage](https://schema.org/ProfilePage)
- [schema.org/Place](https://schema.org/Place)
- [schema.org/Person](https://schema.org/Person)
- [schema.org/Organization](https://schema.org/Organization)
- [schema.org/CollectionPage](https://schema.org/CollectionPage)
- [schema.org/AboutPage](https://schema.org/AboutPage)
- [schema.org/ContactPage](https://schema.org/ContactPage)

# Schema.org gap analysis — Meetup module

## Executive summary

The Meetup module models have partial schema.org coverage. The `Event` model is the most complete: it
implements `toSchemaOrg()` and covers all required base properties. However, every model has gaps
ranging from missing DB columns to entirely absent `toSchemaOrg()` methods.

Critical gaps across all models:

- `Venue` has no `toSchemaOrg()` method. The DB schema is missing `postal_code`, `street_address`,
  `region`, `image`, `url`, `opening_hours`, `public_access`, and `amenity_feature`.
- `Performer` has no `toSchemaOrg()` method. Missing `job_title`, `given_name`, `family_name`,
  `knows_about`, `knows_language`, `same_as` (social profiles are split into individual columns
  instead), and `image` is stored as `photo` (different name).
- `Sponsor` has no `toSchemaOrg()` method. Missing `founding_date`, `legal_name`, `number_of_employees`,
  `tax_id`, `slogan`, `area_served`, `location`, and `same_as`.
- `Feedback` has no `toSchemaOrg()` method. Missing `review_body` (stored as `comment`), `review_aspect`,
  `positive_notes`, `negative_notes`, and no `@type` mapping.
- `Profile` has no `toSchemaOrg()` method. Missing `job_title`, `given_name`/`family_name` (exist but
  named differently), `knows_about`, `knows_language`, `same_as`, `honorific_prefix`, `works_for`,
  `affiliation`, `nationality`, `gender`, and `birth_date`.
- `Event.toSchemaOrg()` is missing: `attendee`, `performer`, `sponsor`, `review`, `aggregateRating`,
  `remainingAttendeeCapacity`, `maximumPhysicalAttendeeCapacity`, `maximumVirtualAttendeeCapacity`,
  `doorTime` (column exists but not output), `keywords` (column exists but not output),
  `isAccessibleForFree` (column exists but not output), `subEvent`, `superEvent`, `recordedIn`,
  `workFeatured`, `workPerformed`, `about`, `audience`, `contributor`, `funder`, `director`.

---

## Event — schema.org/Event

Reference: https://schema.org/Event

### DB columns present and schema.org mapping

| DB column | Schema.org property | Notes |
|---|---|---|
| `title` | `name` | mapped in `toSchemaOrg()` |
| `description` | `description` | mapped |
| `in_language` | `inLanguage` | mapped |
| `start_date` | `startDate` | mapped, ISO 8601 |
| `end_date` | `endDate` | mapped, ISO 8601 |
| `duration` | `duration` | mapped, ISO 8601 expected |
| `location` | `location.name` | mapped as Place.name only |
| `location_id` | `location` | FK to Venue; Venue is not yet embedded in schema output |
| `status` | — | internal workflow status, not a schema.org property |
| `event_status` | `eventStatus` | mapped via `EventStatus::toSchemaOrgUri()` |
| `event_attendance_mode` | `eventAttendanceMode` | mapped via `EventAttendanceMode::toSchemaOrgUri()` |
| `attendees_count` | — | no direct schema.org equivalent (computed) |
| `max_attendees` | `maximumAttendeeCapacity` | mapped |
| `cover_image` | `image` | mapped as array |
| `slug` | — | not a schema.org property; used for `url` |
| `url` | `url` | mapped via `localizeUrl()` |
| `offers` | `offers` | mapped (raw array, not typed Offer objects) |
| `meta_data` | — | internal |
| `user_id` | — | internal owner FK |
| `organizer_id` | `organizer` | mapped as Person with name+email |
| `alternate_name` | `alternateName` | column exists, NOT in `toSchemaOrg()` |
| `door_time` | `doorTime` | column exists, NOT in `toSchemaOrg()` |
| `is_accessible_for_free` | `isAccessibleForFree` | column exists, NOT in `toSchemaOrg()` |
| `keywords` | `keywords` | column exists, NOT in `toSchemaOrg()` |
| `typical_age_range` | `typicalAgeRange` | column exists, NOT in `toSchemaOrg()` |
| `audience` | `audience` | column exists, NOT in `toSchemaOrg()` |
| `previous_start_date` | `previousStartDate` | column exists, NOT in `toSchemaOrg()` |
| `registration_opens_at` | — | no direct schema.org equivalent |
| `registration_url` | — | can map to `offers[].url` |
| `repeat_frequency` | `eventSchedule.repeatFrequency` | column exists, not used in schema output |
| `repeat_days` | `eventSchedule.byDay` | column exists, not used |
| `repeat_count` | `eventSchedule.repeatCount` | column exists, not used |
| `schedule_end_date` | `eventSchedule.endDate` | column exists, not used |
| `except_dates` | `eventSchedule.exceptDate` | column exists, not used |
| `schedule_timezone` | `eventSchedule.scheduleTimezone` | column exists, not used |
| `super_event_id` | `superEvent` | column exists, NOT in `toSchemaOrg()` |

### DB columns missing (add migration)

| Schema.org property | Suggested DB column | PHP type | Priority |
|---|---|---|---|
| `maximumPhysicalAttendeeCapacity` | `maximum_physical_attendee_capacity` | `int\|null` | High |
| `maximumVirtualAttendeeCapacity` | `maximum_virtual_attendee_capacity` | `int\|null` | High |
| `remainingAttendeeCapacity` | — | computed: `max_attendees - attendees_count` | High (computed, no migration needed) |
| `recordedIn` | `recorded_in_url` | `string\|null` | Medium |
| `workFeatured` | `work_featured` | `array\|null` (JSON) | Low |
| `workPerformed` | `work_performed` | `array\|null` (JSON) | Low |
| `funding` | — | relates to a Grant model; out of scope for now | Low |
| `about` | `about` | `string\|null` | Low |
| `contributor` | — | many-to-many with User | Low |
| `director` | `director_id` | FK to User | Low |
| `translator` | `translator_id` | FK to User | Low |
| `funder` | `funder_id` | FK to User or Sponsor | Low |

### `toSchemaOrg()` — properties currently output

| Schema.org property | Value source |
|---|---|
| `@context` | hardcoded `https://schema.org` |
| `@type` | hardcoded `Event` |
| `name` | `$this->title` |
| `startDate` | `$this->start_date->toIso8601String()` |
| `endDate` | `$this->end_date->toIso8601String()` |
| `eventStatus` | `$this->event_status->toSchemaOrgUri()` |
| `eventAttendanceMode` | `$this->event_attendance_mode->toSchemaOrgUri()` |
| `location` | `['@type'=>'Place','name'=>$this->location]` (incomplete) |
| `url` | `LaravelLocalization::localizeUrl(...)` |
| `description` | `$this->description` |
| `image` | `[asset($this->cover_image)]` |
| `organizer` | `['@type'=>'Person','name'=>...,'email'=>...]` |
| `offers` | `$this->offers` (raw array) |
| `inLanguage` | `$this->in_language` |
| `duration` | `$this->duration` |
| `maximumAttendeeCapacity` | `$this->max_attendees` |

### `toSchemaOrg()` — properties missing from output

| Schema.org property | Source column/relation | Priority | Notes |
|---|---|---|---|
| `alternateName` | `alternate_name` | High | column exists |
| `doorTime` | `door_time` | High | column exists |
| `isAccessibleForFree` | `is_accessible_for_free` | High | column exists |
| `keywords` | `keywords` | High | column exists |
| `typicalAgeRange` | `typical_age_range` | Medium | column exists |
| `audience` | `audience` | Medium | column exists, type should be `Audience` object |
| `previousStartDate` | `previous_start_date` | Medium | column exists |
| `remainingAttendeeCapacity` | computed | High | `max_attendees - attendees_count` |
| `maximumPhysicalAttendeeCapacity` | `maximum_physical_attendee_capacity` | High | column missing |
| `maximumVirtualAttendeeCapacity` | `maximum_virtual_attendee_capacity` | High | column missing |
| `location` (full Place) | `location_id` → `Venue` relation | High | currently only `name` is output; should embed full Place with address and geo |
| `performer` | `Performer` relation (event_performer pivot) | High | relation exists, not in schema output |
| `organizer` (Organization) | `organizer_id` | Medium | currently only Person type; could also be Organization |
| `attendee` | `attendees()` relation | Medium | relation exists; only include when count is manageable |
| `sponsor` | `Sponsor` relation (event_sponsor pivot) | High | relation exists, not in schema output |
| `review` | `Feedback` relation | Medium | relation not defined yet on Event; Feedback has event_id |
| `aggregateRating` | computed from `Feedback` | Medium | needs AggregateRating object |
| `superEvent` | `super_event_id` | Medium | column exists |
| `subEvent` | `super_event_id` reverse | Medium | needs `HasMany` relation |
| `eventSchedule` | `repeat_frequency`, `repeat_days`, etc. | Medium | columns exist, not assembled |
| `recordedIn` | `recorded_in_url` | Low | column missing |
| `workFeatured` | `work_featured` | Low | column missing |
| `workPerformed` | `work_performed` | Low | column missing |
| `about` | `about` | Low | column missing |
| `contributor` | — | Low | relation missing |
| `funder` | `funder_id` | Low | column missing |
| `director` | `director_id` | Low | column missing |
| `identifier` | `id` or `slug` | Low | useful for Google structured data |
| `sameAs` | `url` | Low | external canonical URL |

---

## Venue — schema.org/Place

Reference: https://schema.org/Place

### DB columns present and schema.org mapping

| DB column | Schema.org property | Notes |
|---|---|---|
| `name` | `name` | |
| `description` | `description` | |
| `address` | `address.streetAddress` | raw string; not a full PostalAddress object |
| `city` | `address.addressLocality` | |
| `country` | `address.addressCountry` | |
| `latitude` | `geo.latitude` | |
| `longitude` | `geo.longitude` | |
| `capacity` | `maximumAttendeeCapacity` | |
| `website` | `url` | |
| `phone` | `telephone` | |
| `meta_data` | — | internal |

### DB columns missing (add migration)

| Schema.org property | Suggested DB column | PHP type | Priority |
|---|---|---|---|
| `address.streetAddress` | `street_address` | `string\|null` | High — current `address` is a blob; needs splitting |
| `address.postalCode` | `postal_code` | `string\|null` | High |
| `address.addressRegion` | `region` | `string\|null` | Medium |
| `image` | `image` | `string\|null` | Medium |
| `logo` | `logo` | `string\|null` | Medium |
| `publicAccess` | `public_access` | `bool` (default true) | Medium |
| `smokingAllowed` | `smoking_allowed` | `bool\|null` | Low |
| `isAccessibleForFree` | `is_accessible_for_free` | `bool\|null` | Low |
| `amenityFeature` | `amenity_features` | `array\|null` (JSON) | Low |
| `openingHoursSpecification` | `opening_hours` | `array\|null` (JSON) | Low |
| `slogan` | `slogan` | `string\|null` | Low |
| `branchCode` | `branch_code` | `string\|null` | Low |
| `hasMap` | `map_url` | `string\|null` | Low |
| `keywords` | `keywords` | `string\|null` | Low |
| `faxNumber` | `fax_number` | `string\|null` | Low |
| `geo.elevation` | `elevation` | `float\|null` | Low |
| `globalLocationNumber` | `gln` | `string\|null` | Low |

### `toSchemaOrg()` — currently present

The `Venue` model has no `toSchemaOrg()` method.

### `toSchemaOrg()` — all properties missing

The entire method is absent. When implemented it should output at minimum:

| Schema.org property | Value source | Priority |
|---|---|---|
| `@context` | `https://schema.org` | Required |
| `@type` | `Place` | Required |
| `name` | `$this->name` | Required |
| `description` | `$this->description` | High |
| `address` | PostalAddress object from `street_address`, `city`, `postal_code`, `region`, `country` | High |
| `geo` | GeoCoordinates from `latitude`/`longitude` | High |
| `telephone` | `$this->phone` | High |
| `url` | `$this->website` | High |
| `maximumAttendeeCapacity` | `$this->capacity` | High |
| `image` | `$this->image` | Medium |
| `publicAccess` | `$this->public_access` | Medium |
| `openingHoursSpecification` | `$this->opening_hours` | Medium |
| `amenityFeature` | `$this->amenity_features` | Low |
| `smokingAllowed` | `$this->smoking_allowed` | Low |
| `hasMap` | `$this->map_url` | Low |
| `slogan` | `$this->slogan` | Low |
| `logo` | `$this->logo` | Low |
| `keywords` | `$this->keywords` | Low |
| `identifier` | `$this->id` | Low |
| `sameAs` | external reference URLs | Low |

---

## Performer — schema.org/Person

Reference: https://schema.org/Person

### DB columns present and schema.org mapping

| DB column | Schema.org property | Notes |
|---|---|---|
| `name` | `name` | full name only; no given/family split |
| `bio` | `description` | |
| `photo` | `image` | naming mismatch: DB is `photo`, schema is `image` |
| `website` | `url` | |
| `email` | `email` | |
| `company` | `worksFor.name` | stored as string; should be an Organization object |
| `twitter` | `sameAs[]` | stored as plain username/URL; must be normalized to full URL |
| `linkedin` | `sameAs[]` | same |
| `github` | `sameAs[]` | same |
| `type` | — | internal classification (speaker, sponsor, etc.); no schema.org equivalent |
| `meta_data` | — | internal |

### DB columns missing (add migration)

| Schema.org property | Suggested DB column | PHP type | Priority |
|---|---|---|---|
| `givenName` | `given_name` | `string\|null` | High |
| `familyName` | `family_name` | `string\|null` | High |
| `jobTitle` | `job_title` | `string\|null` | High |
| `knowsAbout` | `knows_about` | `array\|null` (JSON) | High — for expertise/tech stack |
| `knowsLanguage` | `knows_language` | `array\|null` (JSON) | Medium |
| `honorificPrefix` | `honorific_prefix` | `string\|null` | Low |
| `nationality` | `nationality` | `string\|null` | Low |
| `gender` | `gender` | `string\|null` | Low |
| `telephone` | `phone` | `string\|null` | Low |
| `address` | — | belongs to a separate Address model | Low |
| `affiliation` | `affiliation` | `string\|null` | Low |
| `alumniOf` | — | would require separate model | Low |
| `award` | `awards` | `array\|null` (JSON) | Low |
| `identifier` | — | `id` (already exists as UUID) | Low |

### `toSchemaOrg()` — currently present

The `Performer` model has no `toSchemaOrg()` method.

### `toSchemaOrg()` — all properties missing

The entire method is absent. When implemented it should output at minimum:

| Schema.org property | Value source | Priority |
|---|---|---|
| `@context` | `https://schema.org` | Required |
| `@type` | `Person` | Required |
| `name` | `$this->name` | Required |
| `description` | `$this->bio` | High |
| `image` | `asset($this->photo)` | High |
| `url` | `$this->website` | High |
| `email` | `$this->email` | High |
| `givenName` | `$this->given_name` | High |
| `familyName` | `$this->family_name` | High |
| `jobTitle` | `$this->job_title` | High |
| `worksFor` | `['@type'=>'Organization','name'=>$this->company]` | High |
| `sameAs` | array of normalized twitter/linkedin/github URLs | High |
| `knowsAbout` | `$this->knows_about` | High |
| `knowsLanguage` | `$this->knows_language` | Medium |
| `identifier` | `$this->id` | Low |
| `performerIn` | events relation (array of Event schema) | Low |

---

## Sponsor — schema.org/Organization

Reference: https://schema.org/Organization

### DB columns present and schema.org mapping

| DB column | Schema.org property | Notes |
|---|---|---|
| `name` | `name` | |
| `description` | `description` | |
| `website` | `url` | |
| `logo` | `logo` | stored as file path; should be full URL |
| `contact_email` | `email` | note: `fillable` uses `contact_email` but docblock shows `email` — inconsistency |
| `contact_name` | `member` or `employee.name` | no direct schema.org property; maps to a Person |
| `level` | — | internal sponsorship tier; no schema.org equivalent |
| `order` | — | internal sorting; no schema.org equivalent |
| `meta_data` | — | internal |

### DB columns missing (add migration)

| Schema.org property | Suggested DB column | PHP type | Priority |
|---|---|---|---|
| `legalName` | `legal_name` | `string\|null` | High |
| `telephone` | `phone` | `string\|null` | High |
| `address` | — | join to a PostalAddress model or JSON column | Medium |
| `foundingDate` | `founding_date` | `\Illuminate\Support\Carbon\|null` | Medium |
| `numberOfEmployees` | `number_of_employees` | `int\|null` | Medium |
| `slogan` | `slogan` | `string\|null` | Medium |
| `areaServed` | `area_served` | `string\|null` | Medium |
| `sameAs` | `same_as` | `array\|null` (JSON) — social/external profiles | Medium |
| `keywords` | `keywords` | `string\|null` | Low |
| `taxID` | `tax_id` | `string\|null` | Low |
| `vatID` | `vat_id` | `string\|null` | Low |
| `duns` | `duns` | `string\|null` | Low |
| `isicV4` | `isic_v4` | `string\|null` | Low |
| `parentOrganization` | `parent_organization_id` | FK to Sponsor or external | Low |
| `knowsAbout` | `knows_about` | `array\|null` (JSON) | Low |

### `toSchemaOrg()` — currently present

The `Sponsor` model has no `toSchemaOrg()` method.

### `toSchemaOrg()` — all properties missing

The entire method is absent. When implemented it should output at minimum:

| Schema.org property | Value source | Priority |
|---|---|---|
| `@context` | `https://schema.org` | Required |
| `@type` | `Organization` | Required |
| `name` | `$this->name` | Required |
| `description` | `$this->description` | High |
| `url` | `$this->website` | High |
| `logo` | full URL from `$this->logo` | High |
| `email` | `$this->contact_email` | High |
| `legalName` | `$this->legal_name` | High |
| `telephone` | `$this->phone` | Medium |
| `foundingDate` | `$this->founding_date` | Medium |
| `slogan` | `$this->slogan` | Medium |
| `sameAs` | `$this->same_as` array | Medium |
| `numberOfEmployees` | `['@type'=>'QuantitativeValue','value'=>$this->number_of_employees]` | Low |
| `areaServed` | `$this->area_served` | Low |
| `identifier` | `$this->id` | Low |

---

## Feedback — schema.org/Review

Reference: https://schema.org/Review

### DB columns present and schema.org mapping

| DB column | Schema.org property | Notes |
|---|---|---|
| `user_id` | `author` (Person) | FK to User; should become `['@type'=>'Person','name'=>...]` |
| `event_id` | `itemReviewed` (Event) | FK to Event; should become the Event schema |
| `rating` | `reviewRating.ratingValue` | integer; schema expects a `Rating` object |
| `comment` | `reviewBody` | naming mismatch: DB is `comment`, schema is `reviewBody` |

### DB columns missing (add migration)

| Schema.org property | Suggested DB column | PHP type | Priority |
|---|---|---|---|
| `reviewRating.bestRating` | `rating_best` | `int` default 5 | High |
| `reviewRating.worstRating` | `rating_worst` | `int` default 1 | High |
| `reviewAspect` | `review_aspect` | `string\|null` | Medium |
| `positiveNotes` | `positive_notes` | `string\|null` | Medium |
| `negativeNotes` | `negative_notes` | `string\|null` | Medium |
| `headline` (CreativeWork) | `headline` | `string\|null` | Low |
| `dateCreated` (CreativeWork) | `created_at` | already exists | — |
| `dateModified` (CreativeWork) | `updated_at` | already exists | — |
| `inLanguage` (CreativeWork) | `in_language` | `string\|null` | Low |

### `toSchemaOrg()` — currently present

The `Feedback` model has no `toSchemaOrg()` method.

### `toSchemaOrg()` — all properties missing

The entire method is absent. When implemented it should output:

| Schema.org property | Value source | Priority |
|---|---|---|
| `@context` | `https://schema.org` | Required |
| `@type` | `Review` | Required |
| `author` | `['@type'=>'Person','name'=>$this->user->name]` | Required |
| `itemReviewed` | `$this->event->toSchemaOrg()` | Required |
| `reviewRating` | `['@type'=>'Rating','ratingValue'=>$this->rating,'bestRating'=>5,'worstRating'=>1]` | Required |
| `reviewBody` | `$this->comment` | High |
| `dateCreated` | `$this->created_at->toIso8601String()` | High |
| `dateModified` | `$this->updated_at->toIso8601String()` | High |
| `reviewAspect` | `$this->review_aspect` | Medium |
| `positiveNotes` | `$this->positive_notes` | Medium |
| `negativeNotes` | `$this->negative_notes` | Medium |
| `headline` | `$this->headline` | Low |
| `url` | page URL linking to this review | Low |

---

## Profile — schema.org/Person

Reference: https://schema.org/Person

The `Profile` model extends `BaseProfile` from `Modules/User`. It holds personal data linked to a
`User` model. From the docblock, the following columns are confirmed:

### DB columns present and schema.org mapping

| DB column | Schema.org property | Notes |
|---|---|---|
| `first_name` | `givenName` | |
| `last_name` | `familyName` | |
| `email` | `email` | |
| `phone` | `telephone` | |
| `fiscal_code` | — | Italian fiscal code; no schema.org equivalent |
| `notes` | — | internal |
| `extra` | — | SchemalessAttributes; may contain arbitrary data |
| `user_id` | — | FK to User |

### DB columns missing (add migration)

| Schema.org property | Suggested DB column | PHP type | Priority |
|---|---|---|---|
| `name` | — | computed from `first_name + last_name`; no migration needed | — |
| `image` | `avatar` | `string\|null` — currently a computed attribute | Medium |
| `jobTitle` | `job_title` | `string\|null` | High |
| `worksFor` | `company` | `string\|null` | High |
| `knowsAbout` | `knows_about` | `array\|null` (JSON) — expertise/skills | High |
| `knowsLanguage` | `knows_language` | `array\|null` (JSON) | Medium |
| `url` | `website` | `string\|null` — personal site | Medium |
| `sameAs` | `same_as` | `array\|null` (JSON) — twitter, linkedin, github URLs | High |
| `honorificPrefix` | `honorific_prefix` | `string\|null` | Low |
| `honorificSuffix` | `honorific_suffix` | `string\|null` | Low |
| `gender` | `gender` | `string\|null` | Low |
| `birthDate` | `birth_date` | `\Illuminate\Support\Carbon\|null` | Low |
| `nationality` | `nationality` | `string\|null` | Low |
| `address` | — | join to PostalAddress model | Low |
| `affiliation` | `affiliation` | `string\|null` | Low |
| `award` | `awards` | `array\|null` (JSON) | Low |
| `description` | `bio` | `string\|null` | High |
| `identifier` | — | `id` (already exists) | — |

### `toSchemaOrg()` — currently present

The `Profile` model has no `toSchemaOrg()` method.

### `toSchemaOrg()` — all properties missing

The entire method is absent. When implemented it should output at minimum:

| Schema.org property | Value source | Priority |
|---|---|---|
| `@context` | `https://schema.org` | Required |
| `@type` | `Person` | Required |
| `name` | `$this->full_name` (computed) | Required |
| `givenName` | `$this->first_name` | High |
| `familyName` | `$this->last_name` | High |
| `email` | `$this->email` | High |
| `telephone` | `$this->phone` | High |
| `description` | `$this->bio` | High |
| `image` | `$this->avatar` (computed) | High |
| `jobTitle` | `$this->job_title` | High |
| `worksFor` | `['@type'=>'Organization','name'=>$this->company]` | High |
| `knowsAbout` | `$this->knows_about` array | High |
| `url` | `$this->website` | Medium |
| `sameAs` | `$this->same_as` array | High |
| `knowsLanguage` | `$this->knows_language` array | Medium |
| `honorificPrefix` | `$this->honorific_prefix` | Low |
| `gender` | `$this->gender` | Low |
| `nationality` | `$this->nationality` | Low |
| `identifier` | `$this->id` | Low |

---

## Offers — schema.org/Offer (context: Event.offers column)

Reference: https://schema.org/Offer

The `Event.offers` column stores a raw JSON array. There is no typed `Offer` model. The array is
passed verbatim into `toSchemaOrg()` without validation or structure enforcement.

### Properties currently covered in the raw array (assumed)

The raw array has no enforced schema; content is arbitrary.

### Properties that should be present in each Offer object

| Schema.org property | PHP value | Priority |
|---|---|---|
| `@type` | `Offer` | Required |
| `name` | ticket name | Required |
| `price` | numeric | Required |
| `priceCurrency` | ISO 4217 code (e.g. `EUR`) | Required |
| `availability` | `https://schema.org/InStock` etc. | High |
| `validFrom` | ISO 8601 datetime | High |
| `validThrough` | ISO 8601 datetime | High |
| `url` | registration/ticket URL | High |
| `description` | ticket description | Medium |
| `eligibleQuantity` | QuantitativeValue object | Medium |
| `offeredBy` | Organization or Person | Low |

### Gap

No `Offer` model exists. The raw array approach cannot guarantee type safety or schema conformance.
A dedicated `Offer` model (or at minimum a `Spatie\LaravelData\Data` DTO) is required for PHPStan
Level 10 compliance and correct JSON-LD output.

---

## PostalAddress context — schema.org/PostalAddress

Reference: https://schema.org/PostalAddress

This type is used inside `Venue.toSchemaOrg()` (once implemented) and potentially in
`Profile.toSchemaOrg()`.

### Venue address: current vs required

| Schema.org property | DB column | Status |
|---|---|---|
| `streetAddress` | `address` (blob) | Partial — `address` mixes street+city in some cases |
| `addressLocality` | `city` | Present |
| `addressCountry` | `country` | Present |
| `postalCode` | — | Missing — add `postal_code` |
| `addressRegion` | — | Missing — add `region` |
| `email` | — | Not applicable at address level |
| `telephone` | `phone` (on Venue) | Use Venue.phone |

---

## GeoCoordinates context — schema.org/GeoCoordinates

Reference: https://schema.org/GeoCoordinates

### Venue geo: current vs required

| Schema.org property | DB column | Status |
|---|---|---|
| `latitude` | `latitude` | Present, cast to float |
| `longitude` | `longitude` | Present, cast to float |
| `elevation` | — | Missing — low priority |
| `address` | — | Redundant at this level; covered by PostalAddress |
| `addressCountry` | `country` | Present on Venue |
| `postalCode` | — | Missing |

---

## AggregateRating context — schema.org/AggregateRating

Reference: https://schema.org/AggregateRating

No `AggregateRating` computation exists in any model. The `Event` model does not include an
`aggregateRating` in its `toSchemaOrg()` output. The `Feedback` relation is not defined on `Event`
(only `Event.id` and `Feedback.event_id` link them; no `HasMany` is declared).

### Required additions

| Schema.org property | Source | Notes |
|---|---|---|
| `@type` | `AggregateRating` | Constant |
| `ratingValue` | `AVG(feedbacks.rating)` | Computed |
| `ratingCount` | `COUNT(feedbacks.id)` | Computed |
| `reviewCount` | `COUNT(feedbacks.id)` (same for this model) | Computed |
| `bestRating` | `5` | Constant |
| `worstRating` | `1` | Constant |
| `itemReviewed` | The `Event` itself | Back-reference |

To support this, `Event` needs a `feedbacks()` `HasMany` relation and a computed method
`toAggregateRatingSchema(): array<string, mixed>`.

---

## Implementation plan

### Phase 1 — High priority (schema.org correctness for existing fields)

These require no new DB columns; only code changes:

1. Add missing properties to `Event::toSchemaOrg()`:
   - `alternateName`, `doorTime`, `isAccessibleForFree`, `keywords`, `typicalAgeRange`,
     `previousStartDate`, `remainingAttendeeCapacity` (computed).
2. Enhance `Event::toSchemaOrg()` `location` block: when `location_id` is set, embed full
   `Venue::toSchemaOrg()` including PostalAddress and GeoCoordinates.
3. Add `toSchemaOrg()` to `Venue` (minimum: name, address as PostalAddress, geo as GeoCoordinates,
   telephone, url, maximumAttendeeCapacity).
4. Add `toSchemaOrg()` to `Performer` (minimum: name, description, image, url, email, worksFor,
   sameAs from twitter/linkedin/github).
5. Add `toSchemaOrg()` to `Sponsor` (minimum: name, description, url, logo, email, legalName).
6. Add `toSchemaOrg()` to `Feedback` (minimum: author, itemReviewed, reviewRating, reviewBody,
   dateCreated).
7. Add `toSchemaOrg()` to `Profile` (minimum: name, givenName, familyName, email, telephone,
   description, image, sameAs).
8. Add `feedbacks()` HasMany relation to `Event` and implement `toAggregateRatingSchema()`.
9. Add `performer` and `sponsor` to `Event::toSchemaOrg()` using existing relations.

### Phase 2 — Medium priority (missing DB columns)

New migrations required:

1. `add_schema_org_fields_to_venues_table`: `postal_code`, `region`, `street_address` (split from
   `address`), `image`, `logo`, `public_access`, `opening_hours` (JSON), `amenity_features` (JSON),
   `map_url`.
2. `add_schema_org_fields_to_performers_table`: `given_name`, `family_name`, `job_title`,
   `knows_about` (JSON), `knows_language` (JSON).
3. `add_schema_org_fields_to_sponsors_table`: `legal_name`, `phone`, `founding_date`, `slogan`,
   `area_served`, `same_as` (JSON), `number_of_employees`.
4. `add_schema_org_fields_to_feedbacks_table`: `rating_best`, `rating_worst`, `review_aspect`,
   `positive_notes`, `negative_notes`.
5. `add_schema_org_fields_to_profiles_table`: `bio`, `job_title`, `company`, `knows_about` (JSON),
   `knows_language` (JSON), `website`, `same_as` (JSON).
6. `add_capacity_fields_to_events_table`: `maximum_physical_attendee_capacity`,
   `maximum_virtual_attendee_capacity`.
7. Create a typed `OfferData` Spatie Data DTO to replace the raw `offers` JSON array in `Event`.

### Phase 3 — Low priority (advanced schema.org features)

1. `Event`: add `eventSchedule` assembly from existing `repeat_*` columns.
2. `Event`: add `superEvent` / `subEvent` support.
3. `Event`: add `recordedIn`, `workFeatured`, `workPerformed`, `about`, `funder`, `director`.
4. `Performer` / `Profile`: add `honorificPrefix`, `birthDate`, `nationality`, `gender`, `award`.
5. `Sponsor`: add `taxID`, `vatID`, `duns`, `parentOrganization`.
6. Evaluate a dedicated `Offer` Eloquent model for ticketing (replaces raw JSON in `Event.offers`).

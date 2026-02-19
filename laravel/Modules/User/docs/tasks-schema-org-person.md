# Task: Schema.org Person (profilo utente e speaker)

**Priority**: MEDIUM
**Status**: TODO
**Estimated Effort**: 1-2 days
**Reference**: [Schema.org Person](https://schema.org/Person)

---

## Objective

Implement Schema.org **Person** type for user profiles, speakers, and attendees to improve SEO, knowledge graph presence, and author attribution.

**Reference Links:**
- [schema-org-enhancements](schema-org-enhancements.md)
- [Schema.org Person](https://schema.org/Person)
- [Meetup schema-org-enhancement-recommendations](../../meetup/docs/schema-org-enhancement-recommendations.md)
- [Meetup schema-org-research-comprehensive](../../meetup/docs/schema-org-research-comprehensive.md)

---

## Schema.org Person Properties

Based on comprehensive Schema.org research:

| Property | Type | Description | Priority |
|----------|------|-------------|----------|
| `givenName` | Text | First name | High |
| `familyName` | Text | Last name | High |
| `name` | Text | Full display name | High |
| `jobTitle` | Text | Job position | High |
| `worksFor` | Organization | Employer | Medium |
| `url` | URL | Profile page | High |
| `image` | URL | Avatar/photo | High |
| `sameAs` | URL[] | Social links | Medium |
| `email` | Text | Contact email | Low |
| `knowsAbout` | DefinedTerm/Text | Expertise areas | Medium |
| `affiliation` | Organization | Memberships | Low |
| `honorificPrefix` | Text | Mr., Dr., etc. | Low |
| `knowsLanguage` | Language | Languages spoken | Low |

---

## Task 1: Profile Model Enhancement

### Database Migration

```php
// add_schema_org_fields_to_profiles_table.php
$table->string('job_title')->nullable();
$table->string('company_name')->nullable();
$table->string('company_url')->nullable();
$table->json('expertise')->nullable();      // Areas of expertise
$table->json('social_links')->nullable();   // Social profile URLs
$table->string('personal_url')->nullable(); // Personal website
$table->string('honorific_prefix')->nullable();
$table->json('languages')->nullable();
```

### Implementation

- [ ] Create migration for new fields
- [ ] Update Profile model with fillable and casts
- [ ] Implement `toPersonSchema()` method on Profile
- [ ] Add `toSchemaOrg()` alias method for consistency
- [ ] Update ProfileFactory with new fields

### toPersonSchema() Method

```php
public function toPersonSchema(): array
{
    $schema = [
        '@type' => 'Person',
        'name' => $this->user->name,
        'givenName' => $this->first_name,
        'familyName' => $this->last_name,
        'url' => route('profile.show', $this->user),
    ];
    
    if ($this->user->avatar) {
        $schema['image'] = asset($this->user->avatar);
    }
    
    if ($this->job_title) {
        $schema['jobTitle'] = $this->job_title;
    }
    
    if ($this->company_name) {
        $schema['worksFor'] = [
            '@type' => 'Organization',
            'name' => $this->company_name,
            'url' => $this->company_url,
        ];
    }
    
    if (!empty($this->social_links)) {
        $schema['sameAs'] = array_values(array_filter($this->social_links));
    }
    
    if (!empty($this->expertise)) {
        $schema['knowsAbout'] = $this->expertise;
    }
    
    return array_filter($schema);
}
```

---

## Task 2: Person in Event Context (Meetup)

### Organizer Schema

```php
// In Event model
public function getOrganizerSchema(): array
{
    $organizer = $this->organizer;
    
    if (!$organizer) {
        return [];
    }
    
    return [
        '@type' => 'Person',
        'name' => $organizer->name,
        'url' => route('profile.show', $organizer),
        'image' => $organizer->avatar ? asset($organizer->avatar) : null,
    ];
}
```

### Speaker/Performer Schema

```php
public function getPerformersSchema(): array
{
    return $this->speakers->map(function ($speaker) {
        return [
            '@type' => 'Person',
            'name' => $speaker->name,
            'url' => route('profile.show', $speaker),
            'image' => $speaker->avatar ? asset($speaker->avatar) : null,
            'jobTitle' => $speaker->profile?->job_title,
        ];
    })->all();
}
```

### Tasks

- [ ] Update Event model `toSchemaOrg()` with organizer Person
- [ ] Add `performer` property for speakers
- [ ] Implement privacy controls for attendee data
- [ ] Document privacy decisions in User docs

---

## Task 3: Team-Organization Relationship

When a Person belongs to a Team, expose the relationship:

```php
// Profile with Team/Organization context
public function toPersonSchemaWithOrganization(): array
{
    $schema = $this->toPersonSchema();
    
    if ($this->user->currentTeam) {
        $schema['memberOf'] = [
            '@type' => 'Organization',
            'name' => $this->user->currentTeam->name,
            'url' => route('team.show', $this->user->currentTeam),
        ];
    }
    
    return $schema;
}
```

### Tasks

- [ ] Add `memberOf` support for Team membership
- [ ] Document Organization-Person relationship pattern
- [ ] Update [schema-org-enhancements](schema-org-enhancements.md)

---

## Task 4: Filament Integration

### ProfileResource Update

- [ ] Add fields section for Schema.org properties
- [ ] Create job title, company, expertise inputs
- [ ] Add social links repeater for `sameAs` URLs
- [ ] Update infolist for viewing Schema.org data

---

## Privacy Considerations

1. **Public Profiles**: Full Person schema for public profiles
2. **Private Profiles**: Minimal or no Person exposure
3. **Event Attendees**: Count only, unless user consents
4. **Email**: Never expose without explicit consent
5. **Social Links**: User-added only, not scraped

---

## Verification Checklist

- [ ] Validate output with [validator.schema.org](https://validator.schema.org/)
- [ ] Test Person schema on profile pages
- [ ] Verify Event organizer/performer embedding
- [ ] Check privacy controls work correctly
- [ ] Run PHPStan Level 10 on changes
- [ ] Write Pest tests for schema generation
- [ ] Update documentation

---

## Related Files

- `Modules/User/app/Models/Profile.php`
- `Modules/User/app/Models/Traits/HasSchemaOrg.php` (new)
- `Modules/Meetup/app/Models/Event.php`
- `Modules/User/Filament/Resources/ProfileResource.php`

---

## Links

- [schema-org-enhancements](schema-org-enhancements.md)
- [profile-management](profile-management.md)
- [Meetup schema-org-research-comprehensive](../../meetup/docs/schema-org-research-comprehensive.md)
- [Meetup task-rsvp-actions](../../meetup/docs/task-rsvp-actions.md)

---

**Updated**: [DATE] (Enhanced with comprehensive research)

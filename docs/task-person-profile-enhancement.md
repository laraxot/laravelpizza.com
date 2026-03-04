# Task: Enhance User Profile with Schema.org Person

**Priority**: LOW
**Status**: TODO
**Estimated Effort**: 1 day
**Reference**: [Schema.org Person](https://schema.org/Person)

---

## Objective

Enhance the User/Profile model with Schema.org Person properties for:
- Better speaker/attendee profiles
- Author attribution in content
- Social profile linking
- Knowledge graph presence

---

## Key Properties to Add

| Property | Type | Description |
|----------|------|-------------|
| `givenName` | Text | First name |
| `familyName` | Text | Last name |
| `jobTitle` | Text | Job title |
| `worksFor` | Organization | Employer |
| `knowsAbout` | Text/Thing | Areas of expertise |
| `sameAs` | URL | Social profiles |
| `affiliation` | Organization | Affiliations |

---

## Database Fields

```php
// profiles table additions
$table->string('job_title')->nullable();
$table->string('company_name')->nullable();
$table->string('company_url')->nullable();
$table->json('expertise')->nullable();
$table->json('social_links')->nullable();
$table->string('personal_url')->nullable();
```

---

## Implementation Steps

- [ ] Update profiles migration
- [ ] Add new fields to Profile model
- [ ] Implement `toPersonSchema()` method
- [ ] Update User model toSchemaOrg()
- [ ] Update Filament ProfileResource
- [ ] Write Pest tests

---

**Reference**: [schema-org-research-comprehensive.md](./schema-org-research-comprehensive.md)

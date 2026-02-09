# Task: Schema.org Person Enhancement - 2026-02-10

**Created**: 2026-02-10  
**Module**: User  
**Status**: Pending  
**Priority**: Medium  

## Research Summary

Based on comprehensive research of Schema.org documentation, I've identified key areas for enhancement in the User module:

### 1. Enhanced Person Schema
- **URL**: https://schema.org/Person
- **Implementation**: Add comprehensive profile support
- **Files to modify**: 
  - `laravel/Modules/User/app/Models/User.php`

### 2. Address Integration
- **URL**: https://schema.org/address
- **Implementation**: Add address support to Person schema
- **Files to modify**:
  - `laravel/Modules/User/app/Models/User.php`

### 3. Professional Profile Enhancement
- **Implementation**: Add job title, company, and expertise fields
- **Files to modify**:
  - `laravel/Modules/User/app/Models/User.php`
  - `laravel/Modules/User/app/Models/Profile.php`

## Implementation Steps

### Phase 1: Core Person Schema (High Priority)
1. **Enhance User model** with comprehensive Person schema
2. **Add toPersonSchema() method** to User model
3. **Update toSchemaOrg() method** in User model
4. **Add profile photo support** to Person schema

### Phase 2: Professional Integration (Medium Priority)
1. **Enhance Profile model** with professional fields
2. **Add expertise tracking** to Profile model
3. **Add social profile links** to Profile model
4. **Update API endpoints** to include schema.org data

### Phase 3: Validation & Testing (Medium Priority)
1. **Add validation rules** for new profile fields
2. **Create test cases** for schema generation
3. **Update documentation** with new examples
4. **Add integration tests** for Meetup module

## Technical Requirements

### Database Changes
- Add `profile_photo_url` field to users table
- Add `profile_id` foreign key to users table
- Update profile table with new fields

### Model Enhancements
- Implement HasSchemaOrg trait pattern
- Add toSchemaOrg() and toPersonSchema() methods
- Update fillable arrays for new fields
- Add validation rules for new fields

### API Changes
- Update API endpoints to include schema.org data
- Add schema.org data to existing responses
- Ensure proper JSON-LD generation

## Testing Plan

1. **Unit Tests**: Test schema.org generation methods
2. **Integration Tests**: Test API endpoints with schema.org data
3. **Validation Tests**: Test new validation rules
4. **Regression Tests**: Ensure existing functionality still works

## Documentation Updates

1. Update existing schema.org documentation
2. Create new implementation guides
3. Update API documentation
4. Add examples for new features

## Success Criteria

1. All new models have proper schema.org support
2. API endpoints return valid JSON-LD
3. All new functionality is properly tested
4. Documentation is updated and accurate
5. No breaking changes to existing functionality

## Related Files

- [tasks-schema-org-person.md](./tasks-schema-org-person.md) - Existing person tasks
- [place-address-schemaorg.md](../Geo/docs/place-address-schemaorg.md) - Address documentation
- [architecture.md](./architecture.md) - User module architecture

## Implementation Details

### User Model Enhancements

```php
// Modules/User/app/Models/User.php
class User extends Authenticatable implements HasSchemaOrg
{
    protected $fillable = [
        // ... existing fields
        'profile_photo_url', // New field
    ];
    
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }
    
    public function toPersonSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => $this->name,
            'givenName' => $this->profile?->first_name,
            'familyName' => $this->profile?->last_name,
            'additionalName' => $this->profile?->middle_name,
            'honorificPrefix' => $this->profile?->honorific_prefix,
            'honorificSuffix' => $this->profile?->honorific_suffix,
            'jobTitle' => $this->profile?->job_title,
            'worksFor' => $this->profile?->company ? [
                '@type' => 'Organization',
                'name' => $this->profile->company,
            ] : null,
            'knowsAbout' => $this->profile?->expertise, // Array of topics
            'knowsLanguage' => $this->profile?->languages, // Array of languages
            'birthDate' => $this->profile?->birth_date,
            'birthPlace' => $this->profile?->birth_place ? [
                '@type' => 'Place',
                'name' => $this->profile->birth_place,
            ] : null,
            'address' => $this->address?->toSchemaOrg(),
            'email' => $this->email,
            'telephone' => $this->profile?->phone,
            'url' => $this->profile?->website,
            'sameAs' => array_filter([
                $this->profile?->github_url,
                $this->profile?->twitter_url,
                $this->profile?->linkedin_url,
                $this->profile?->facebook_url,
                $this->profile?->instagram_url,
                $this->profile?->youtube_url,
            ]),
            'image' => $this->profile_photo_url,
            'worksFor' => $this->profile?->company ? [
                '@type' => 'Organization',
                'name' => $this->profile->company,
                'url' => $this->profile?->company_website,
            ] : null,
            'owns' => $this->profile?->assets, // Array of owned items
            'memberOf' => $this->profile?->memberships, // Array of memberships
            'alumniOf' => $this->profile?->education, // Array of educational organizations
            'contactPoint' => $this->profile?->contact_info, // Contact information
            'hasCredential' => $this->profile?->credentials, // Educational credentials
            'hasOccupation' => $this->profile?->occupation, // Current occupation
            'hasOfferCatalog' => $this->profile?->offer_catalogs, // Offer catalogs
            'hasPOS' => $this->profile?->points_of_sale, // Points of sale
            'interactionStatistic' => $this->profile?->interaction_stats, // Interaction statistics
            'netWorth' => $this->profile?->net_worth, // Net worth
            'owns' => $this->profile?->assets, // Owned items
            'parent' => $this->profile?->parent_info, // Parent information
            'relatedTo' => $this->profile?->related_persons, // Related persons
            'sibling' => $this->profile?->siblings, // Siblings
            'spouse' => $this->profile?->spouse, // Spouse
            'worksFor' => $this->profile?->employer, // Current employer
            'workLocation' => $this->profile?->work_location, // Work location
            'url' => route('profiles.show', $this->id),
        ];
    }
    
    public function toSchemaOrg(): array
    {
        return $this->toPersonSchema();
    }
}
```

### Profile Model Enhancements

```php
// Modules/User/app/Models/Profile.php
class Profile extends BaseModel
{
    protected $fillable = [
        // ... existing fields
        'first_name',
        'last_name',
        'middle_name',
        'honorific_prefix',
        'honorific_suffix',
        'job_title',
        'company',
        'company_website',
        'expertise',
        'languages',
        'birth_date',
        'birth_place',
        'phone',
        'website',
        'github_url',
        'twitter_url',
        'linkedin_url',
        'facebook_url',
        'instagram_url',
        'youtube_url',
        'profile_photo_url',
        'assets',
        'memberships',
        'education',
        'contact_info',
        'credentials',
        'occupation',
        'offer_catalogs',
        'points_of_sale',
        'interaction_stats',
        'net_worth',
        'parent_info',
        'related_persons',
        'siblings',
        'spouse',
        'employer',
        'work_location',
    ];
    
    protected function casts(): array
    {
        return [
            // ... existing casts
            'expertise' => 'array',
            'languages' => 'array',
            'assets' => 'array',
            'memberships' => 'array',
            'education' => 'array',
            'contact_info' => 'array',
            'credentials' => 'array',
            'occupation' => 'array',
            'offer_catalogs' => 'array',
            'points_of_sale' => 'array',
            'interaction_stats' => 'array',
            'parent_info' => 'array',
            'related_persons' => 'array',
            'siblings' => 'array',
            'spouse' => 'array',
            'employer' => 'array',
            'work_location' => 'array',
        ];
    }
}
```

## Validation Rules

```php
// Modules/User/app/Http/Requests/UpdateProfileRequest.php
public function rules(): array
{
    return [
        // ... existing rules
        'first_name' => ['sometimes', 'string', 'max:100'],
        'last_name' => ['sometimes', 'string', 'max:100'],
        'middle_name' => ['sometimes', 'string', 'max:100'],
        'honorific_prefix' => ['sometimes', 'string', 'max:50'],
        'honorific_suffix' => ['sometimes', 'string', 'max:50'],
        'job_title' => ['sometimes', 'string', 'max:200'],
        'company' => ['sometimes', 'string', 'max:200'],
        'company_website' => ['sometimes', 'url', 'max:255'],
        'expertise' => ['sometimes', 'array'],
        'expertise.*' => ['string', 'max:100'],
        'languages' => ['sometimes', 'array'],
        'languages.*' => ['string', 'max:100'],
        'birth_date' => ['sometimes', 'date', 'before:today'],
        'birth_place' => ['sometimes', 'string', 'max:200'],
        'phone' => ['sometimes', 'string', 'max:50'],
        'website' => ['sometimes', 'url', 'max:255'],
        'github_url' => ['sometimes', 'url', 'max:255'],
        'twitter_url' => ['sometimes', 'url', 'max:255'],
        'linkedin_url' => ['sometimes', 'url', 'max:255'],
        'facebook_url' => ['sometimes', 'url', 'max:255'],
        'instagram_url' => ['sometimes', 'url', 'max:255'],
        'youtube_url' => ['sometimes', 'url', 'max:255'],
        'profile_photo_url' => ['sometimes', 'url', 'max:255'],
        'assets' => ['sometimes', 'array'],
        'memberships' => ['sometimes', 'array'],
        'education' => ['sometimes', 'array'],
        'contact_info' => ['sometimes', 'array'],
        'credentials' => ['sometimes', 'array'],
        'occupation' => ['sometimes', 'array'],
        'offer_catalogs' => ['sometimes', 'array'],
        'points_of_sale' => ['sometimes', 'array'],
        'interaction_stats' => ['sometimes', 'array'],
        'net_worth' => ['sometimes', 'numeric'],
        'parent_info' => ['sometimes', 'array'],
        'related_persons' => ['sometimes', 'array'],
        'siblings' => ['sometimes', 'array'],
        'spouse' => ['sometimes', 'array'],
        'employer' => ['sometimes', 'array'],
        'work_location' => ['sometimes', 'array'],
    ];
}
```

## API Response Enhancement

```php
// Modules/User/app/Http/Resources/UserResource.php
class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            // ... existing fields
            'schema_org' => $this->toSchemaOrg(),
            'person_schema' => $this->toPersonSchema(),
            'profile' => new ProfileResource($this->profile),
        ];
    }
}
```

## References

- [Schema.org Official Documentation](https://schema.org/)
- [Person](https://schema.org/Person)
- [address property](https://schema.org/address)
- [PostalAddress](https://schema.org/PostalAddress)
- [Organization](https://schema.org/Organization)
- [Place](https://schema.org/Place)

---

**Created by**: AI Assistant  
**Last Updated**: 2026-02-10
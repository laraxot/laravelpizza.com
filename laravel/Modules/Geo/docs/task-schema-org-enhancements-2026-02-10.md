# Task: Schema.org Enhancements for Geo Module - 2026-02-10

**Created**: 2026-02-10  
**Module**: Geo  
**Status**: Pending  
**Priority**: High  

## Research Summary

Based on comprehensive research of Schema.org documentation, I've identified key areas for enhancement in the Geo module:

### 1. Enhanced Place Schema
- **URL**: https://schema.org/Place
- **Implementation**: Add service area support using GeoCircle
- **Files to modify**: 
  - `laravel/Modules/Geo/app/Models/Place.php`

### 2. Enhanced Address Schema
- **URL**: https://schema.org/PostalAddress
- **Implementation**: Add Italian province support
- **Files to modify**:
  - `laravel/Modules/Geo/app/Models/Address.php`

### 3. GeoCircle Support
- **URL**: https://schema.org/GeoCircle
- **Implementation**: Service area representation
- **Files to modify**:
  - `laravel/Modules/Geo/app/Models/Place.php` (add toSchemaOrg method)

### 4. Person & Address Integration
- **URLs**: https://schema.org/Person, https://schema.org/address
- **Implementation**: Enhanced user profile support
- **Files to modify**:
  - `laravel/Modules/User/app/Models/User.php`
  - `laravel/Modules/Geo/app/Models/Address.php`

## Implementation Steps

### Phase 1: Core Models (High Priority)
1. **Enhance Place model** with GeoCircle support
2. **Update Address model** with Italian province support
3. **Add service radius tracking** to Place model
4. **Update toSchemaOrg() methods** for both models

### Phase 2: User Integration (Medium Priority)
1. **Enhance User model** with Person schema
2. **Update Address relationships** in User model
3. **Add profile photo support** to Person schema
4. **Add social profile links** to Person schema

### Phase 3: Validation & Testing (Medium Priority)
1. **Add validation rules** for province and region
2. **Create test cases** for schema generation
3. **Add integration tests** for Meetup module
4. **Update documentation** with new examples

## Technical Requirements

### Database Changes
- Add `service_radius_km` field to places table
- Add `province` field to addresses table
- Add `region` field to addresses table

### Model Enhancements
- Implement HasSchemaOrg trait pattern
- Add toSchemaOrg() methods to key models
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

- [place-address-schemaorg.md](./place-address-schemaorg.md) - Updated address documentation
- [tasks-schema-org-place-geocircle.md](./tasks-schema-org-place-geocircle.md) - Existing place/GeoCircle tasks
- [architecture.md](./architecture.md) - Geo module architecture
- [geo_entities.md](./geo_entities.md) - Geographic entities documentation

## Implementation Details

### Place Model Enhancements

```php
// Modules/Geo/app/Models/Place.php
class Place extends BaseModel implements HasSchemaOrg
{
    protected $fillable = [
        // ... existing fields
        'service_radius_km', // New field
    ];
    
    public function toSchemaOrg(): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Place',
            'name' => $this->name,
            'address' => $this->getAddressSchemaOrg(),
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ],
        ];
        
        // Add service area if exists
        if ($this->service_radius) {
            $schema['areaServed'] = $this->toGeoCircleSchema();
        }
        
        return $schema;
    }
    
    public function toGeoCircleSchema(): array
    {
        return [
            '@type' => 'GeoCircle',
            'geoMidpoint' => [
                '@type' => 'GeoCoordinates',
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ],
            'geoRadius' => [
                '@type' => 'Distance',
                'value' => $this->service_radius_km,
                'unitCode' => 'KM',
            ],
        ];
    }
}
```

### Address Model Enhancements

```php
// Modules/Geo/app/Models/Address.php
class Address extends BaseModel implements HasSchemaOrg
{
    protected $fillable = [
        // ... existing fields
        'province', // New field
        'region', // New field
    ];
    
    public function toSchemaOrg(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'PostalAddress',
            'streetAddress' => trim($this->street . ' ' . $this->street_number),
            'addressLocality' => $this->locality,
            'addressProvince' => $this->province, // Custom field
            'addressRegion' => $this->region, // Custom field
            'postalCode' => $this->postal_code,
            'addressCountry' => $this->country,
        ];
    }
}
```

### User Model Enhancements

```php
// Modules/User/app/Models/User.php
class User extends Authenticatable implements HasSchemaOrg
{
    public function toPersonSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => $this->name,
            'givenName' => $this->profile?->first_name,
            'familyName' => $this->profile?->last_name,
            'email' => $this->email,
            'jobTitle' => $this->profile?->job_title,
            'worksFor' => $this->profile?->company ? [
                '@type' => 'Organization',
                'name' => $this->profile->company,
            ] : null,
            'knowsAbout' => $this->profile?->expertise,
            'address' => $this->address?->toSchemaOrg(),
            'sameAs' => array_filter([
                $this->profile?->github_url,
                $this->profile?->twitter_url,
                $this->profile?->linkedin_url,
            ]),
            'image' => $this->profile_photo_url,
            'url' => route('profiles.show', $this->id),
        ];
    }
}
```

## References

- [Schema.org Official Documentation](https://schema.org/)
- [Place](https://schema.org/Place)
- [PostalAddress](https://schema.org/PostalAddress)
- [GeoCircle](https://schema.org/GeoCircle)
- [Person](https://schema.org/Person)
- [address property](https://schema.org/address)

---

**Created by**: AI Assistant  
**Last Updated**: 2026-02-10
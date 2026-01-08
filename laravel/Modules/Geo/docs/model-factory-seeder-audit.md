# Model/Factory/Seeder Audit

Generated: 2025-08-22 16:28

## Coverage
| Model | Factory | Seeded |
|---|---|---|
| Place | yes | no |
| County | yes | no |
| Province | yes | no |
| Address | yes | no |
| Location | yes | no |
| Comune | yes | no |
| PlaceType | yes | no |
| Region | yes | no |
| Locality | yes | no |
| State | yes | no |
| GeoJsonModel | n/a | n/a |
| ComuneJson | n/a | n/a |
| GeoTrait | n/a | n/a |
| HasAddress | n/a | n/a |
| HasPlaceTrait | n/a | n/a |
| GeographicalScopes | n/a | n/a |
| SushiToJsons | n/a | n/a |

Seeder: `database/seeders/GeoDatabaseSeeder.php`

## Missing / Actions
- Add exemplar seeding for: Region, Province, Comune, Address, Location (small curated set).
- Mark trait/utility/JSON helper classes as non-seed targets (n/a).

## Likely non-business-critical
- Trait/utility classes listed above; not direct domain entities.

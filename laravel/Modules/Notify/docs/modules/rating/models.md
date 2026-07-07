# Rating Module Models Documentation

## Overview
This document describes the models used in the Rating module and their relationships.

## Models

### RatingMorph
The `RatingMorph` model represents a polymorphic relationship for ratings in the system. It extends `BaseMorphPivot` and implements various relationships.

#### Properties
- `id`: Primary key
- `model_id`: ID of the related model
- `model_type`: Type of the related model
- `rating_id`: Foreign key to the Rating model
- `user_id`: Foreign key to the User model
- `note`: Optional note for the rating
- `value`: Rating value
- `is_winner`: Boolean flag for winning ratings
- `reward`: Reward associated with the rating

#### Relationships
- `rating`: BelongsTo relationship with the Rating model
- `user`: BelongsTo relationship with the User model (implements UserContract)
- `profile`: BelongsTo relationship with the Profile model (implements ProfileContract)
- `model`: MorphTo relationship for polymorphic associations

#### Recent Changes
- Fixed merge conflicts in the model definition
- Standardized profile relationship type to use ProfileContract
- Improved type safety in relationship declarations
- Added proper PHPDoc blocks for all properties

#### Links
- [Detailed Model Documentation](../Modules/Rating/docs/models/rating-morph.md)
- [PHPStan Rules](../Modules/Rating/docs/phpstan-rules.md) 
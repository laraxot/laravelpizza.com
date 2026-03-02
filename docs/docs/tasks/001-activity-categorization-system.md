# Task 001: Implement Complete Activity Categorization System

## Description
Implement a comprehensive activity categorization and tagging system to organize and classify all user activities throughout the system.

## Context
The Activity module currently has basic activity logging but lacks a proper categorization system. This makes it difficult to filter, search, and analyze activities by type, category, or tags.

## Requirements

### Functional Requirements
- Create activity categories (e.g., auth, content, admin, system, user)
- Implement activity subcategories for granular classification
- Add tag system for flexible activity labeling
- Support multiple categories per activity
- Create category hierarchy (parent-child relationships)
- Implement category-specific metadata

### Technical Requirements
- Use PHP 8.3 strict typing
- PHPStan Level 10 compliance
- Extend XotBaseModel patterns
- Use DatabaseTransactions for tests
- MySQL database with "_test" suffix for testing

## Implementation Steps

### 1. Database Schema
- [ ] Create `activity_categories` table
  - id (uuid/ulid)
  - name (string, unique)
  - slug (string, unique)
  - description (text, nullable)
  - parent_id (nullable, self-reference)
  - color (hex color code, nullable)
  - icon (nullable)
  - is_active (boolean, default true)
  - metadata (json, nullable)
  - timestamps

- [ ] Create `activity_tags` table
  - id (uuid/ulid)
  - name (string, unique)
  - slug (string, unique)
  - color (hex color code, nullable)
  - is_active (boolean, default true)
  - timestamps

- [ ] Create pivot tables
  - `activity_category` (activity_id, category_id)
  - `activity_tag` (activity_id, tag_id)

### 2. Models
- [ ] Create `ActivityCategory` model
  - Extends `Modules\Activity\Models\ActivityBaseModel`
  - Implements parent-child relationships
  - Includes soft deletes
  - Strict typing for all methods

- [ ] Create `ActivityTag` model
  - Extends `Modules\Activity\Models\ActivityBaseModel`
  - Includes soft deletes
  - Strict typing for all methods

- [ ] Update `Activity` model
  - Add `categories()` relationship (belongsToMany)
  - Add `tags()` relationship (belongsToMany)
  - Add helper methods for categorization

### 3. Migrations
- [ ] Create migration for categories table
- [ ] Create migration for tags table
- [ ] Create migration for pivot tables
- [ ] Add indexes for performance

### 4. Seeders
- [ ] Create `ActivityCategorySeeder` with default categories
  - Authentication (login, logout, password change)
  - Content (create, update, delete, publish)
  - Administration (settings, permissions, users)
  - System (backup, maintenance, jobs)
  - User (profile, preferences, notifications)

- [ ] Create `ActivityTagSeeder` with common tags
  - Critical, Important, Normal, Low
  - Manual, Automatic, Scheduled
  - Success, Warning, Error

### 5. Services
- [ ] Create `ActivityCategorizationService`
  - `categorizeActivity(Activity $activity, array $categories)`
  - `tagActivity(Activity $activity, array $tags)`
  - `getActivitiesByCategory(string $category)`
  - `getActivitiesByTag(string $tag)`
  - `suggestCategoriesForActivity(Activity $activity)`
  - `autoCategorize(Activity $activity)` based on event type

### 6. Actions
- [ ] Create `CategorizeActivityAction`
- [ ] Create `TagActivityAction`
- [ ] Create `AutoCategorizeActivityAction`

### 7. Filament Resources
- [ ] Create `ActivityCategoryResource`
  - List view with hierarchy
  - Create/Edit forms
  - Tree view for parent-child navigation

- [ ] Create `ActivityTagResource`
  - List view
  - Create/Edit forms
  - Color picker for visual distinction

- [ ] Update `ActivityResource`
  - Add category filters
  - Add tag filters
  - Display categories and tags in list view
  - Add category/tag selection in forms

### 8. Filters
- [ ] Create `CategoryFilter` for Activity tables
- [ ] Create `TagFilter` for Activity tables
- [ ] Create `CategoryAndTagFilter` combined filter

### 9. Events & Listeners
- [ ] Create `ActivityCreated` event
- [ ] Create `AutoCategorizeActivity` listener
  - Automatically categorize activities based on event type

### 10. Tests
- [ ] Create `ActivityCategoryTest`
  - Test category creation
  - Test parent-child relationships
  - Test category hierarchy

- [ ] Create `ActivityTagTest`
  - Test tag creation
  - Test tag uniqueness

- [ ] Create `ActivityCategorizationTest`
  - Test categorizing activities
  - Test tagging activities
  - Test filtering by category
  - Test filtering by tag
  - Test auto-categorization

### 11. Documentation
- [ ] Update module README with categorization features
- [ ] Create categorization guide in docs/
- [ ] Add API documentation

## Acceptance Criteria
- [ ] Activities can be assigned to multiple categories
- [ ] Activities can have multiple tags
- [ ] Categories can have parent-child relationships
- [ ] Auto-categorization works for 80% of common activities
- [ ] Filtering by category and tag works in Filament
- [ ] All tests pass with 85%+ coverage
- [ ] PHPStan Level 10 compliant

## Dependencies
- Xot module (base classes)
- User module (user activities)
- Filament 5.x (admin UI)

## Estimated Time
- Database schema: 2 hours
- Models: 2 hours
- Migrations: 1 hour
- Seeders: 2 hours
- Services: 3 hours
- Actions: 2 hours
- Filament Resources: 4 hours
- Filters: 1 hour
- Events/Listeners: 1 hour
- Tests: 4 hours
- Documentation: 2 hours

**Total: 24 hours (3 days)**

## Priority
**High** - Critical for activity organization and analytics

## Related Tasks
- Task 002: Advanced Activity Filtering
- Task 003: Activity Analytics Dashboard
- Task 004: Activity Notification System

## Notes
- Use UUID/ULID for primary keys to support distributed systems
- Consider using nested set pattern for category hierarchy if needed
- Implement caching for category/tag lookups
- Category colors should follow WCAG accessibility guidelines

---

**Status**: Pending
**Assignee**: TBD
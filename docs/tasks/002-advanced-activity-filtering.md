# Task 002: Implement Advanced Activity Filtering and Search

## Description
Implement advanced filtering, searching, and sorting capabilities for activities with support for complex queries, date ranges, and multi-criteria filters.

## Context
The current activity filtering is basic and limited. Users need powerful search and filtering capabilities to find specific activities quickly, especially for audit and compliance purposes.

## Requirements

### Functional Requirements
- Multi-criteria filtering (category, tag, user, date range, action)
- Full-text search on activity descriptions and properties
- Date range filtering with preset options (today, yesterday, last 7 days, etc.)
- Save custom filters for reuse
- Export filtered results
- Real-time filter updates
- Advanced boolean search (AND, OR, NOT operators)

### Technical Requirements
- Use PHP 8.3 strict typing
- PHPStan Level 10 compliance
- Efficient database queries with proper indexing
- Pagination support
- MySQL full-text search or Elasticsearch integration

## Implementation Steps

### 1. Database Optimization
- [ ] Add indexes to activity table columns
  - description (full-text index)
  - created_at, updated_at
  - causer_id
  - subject_id, subject_type

- [ ] Add composite indexes for common filter combinations
  - (created_at, activity_type)
  - (causer_id, created_at)
  - (subject_type, subject_id, created_at)

### 2. Search Service
- [ ] Create `ActivitySearchService`
  - `search(array $criteria): Builder`
  - `fullTextSearch(string $query): Builder`
  - `filterByDateRange(Carbon $from, Carbon $to): Builder`
  - `filterByCategories(array $categoryIds): Builder`
  - `filterByTags(array $tagIds): Builder`
  - `filterByUser(string|int $userId): Builder`
  - `filterByAction(string $action): Builder`
  - `applyAdvancedFilters(array $filters): Builder`

### 3. Filter Classes
- [ ] Create `ActivityFilter` abstract class
- [ ] Create `CategoryFilter` extends `ActivityFilter`
- [ ] Create `TagFilter` extends `ActivityFilter`
- [ ] Create `UserFilter` extends `ActivityFilter`
- [ ] Create `DateRangeFilter` extends `ActivityFilter`
- [ ] Create `ActionFilter` extends `ActivityFilter`
- [ ] Create `TextSearchFilter` extends `ActivityFilter`
- [ ] Create `CompositeFilter` for combining filters

### 4. Saved Filters Feature
- [ ] Create `SavedActivityFilter` model
  - id (uuid/ulid)
  - user_id
  - name (string)
  - filters (json)
  - is_public (boolean, default false)
  - timestamps

- [ ] Create migration for saved filters
- [ ] Create `SavedActivityFilterResource`
  - List view
  - Create/Edit forms with filter builder UI
  - Share filters between users

### 5. Filament Integration
- [ ] Create `AdvancedActivityFilterWidget`
  - Multi-select category filter
  - Multi-select tag filter
  - Date range picker with presets
  - User autocomplete filter
  - Action type filter
  - Full-text search input
  - Boolean search operators

- [ ] Update `ActivityResource`
  - Add advanced filter widget to table
  - Add saved filter dropdown
  - Add export button for filtered results
  - Add "save current filters" button

### 6. Export Functionality
- [ ] Create `ExportFilteredActivitiesAction`
  - Export to CSV
  - Export to Excel
  - Export to PDF
  - Include selected columns only
  - Apply current filters

### 7. Query Optimization
- [ ] Implement eager loading for relationships
- [ ] Use database-specific optimizations (subqueries, CTEs)
- [ ] Implement result caching for repeated queries
- [ ] Add query logging for performance monitoring

### 8. Actions
- [ ] Create `SearchActivitiesAction`
- [ ] Create `ApplyFiltersAction`
- [ ] Create `SaveFiltersAction`
- [ ] Create `LoadSavedFiltersAction`
- [ ] Create `ExportActivitiesAction`

### 9. API Endpoints
- [ ] `GET /api/activities/search` - Search activities
- [ ] `POST /api/activities/advanced-filter` - Apply advanced filters
- [ ] `GET /api/activities/saved-filters` - List saved filters
- [ ] `POST /api/activities/saved-filters` - Save filter
- [ ] `DELETE /api/activities/saved-filters/{id}` - Delete saved filter

### 10. Tests
- [ ] Create `ActivitySearchTest`
  - Test basic search
  - Test full-text search
  - Test date range filtering
  - Test category filtering
  - Test tag filtering
  - Test user filtering
  - Test combined filters

- [ ] Create `SavedActivityFilterTest`
  - Test saving filters
  - Test loading filters
  - Test sharing filters
  - Test filter validation

- [ ] Create `ActivityExportTest`
  - Test CSV export
  - Test Excel export
  - Test PDF export
  - Test filtered export

### 11. Documentation
- [ ] Create search syntax guide
- [ ] Document filter combinations
- [ ] Create saved filters tutorial
- [ ] Add API documentation

## Acceptance Criteria
- [ ] Search works across all activity fields
- [ ] Multiple filters can be combined
- [ ] Saved filters can be created and loaded
- [ ] Export functionality works for all formats
- [ ] Performance: < 500ms for typical queries
- [ ] All tests pass with 85%+ coverage
- [ ] PHPStan Level 10 compliant

## Dependencies
- Task 001: Activity Categorization System
- Xot module (base classes)
- Filament 5.x (admin UI)
- Laravel Excel (for exports)

## Estimated Time
- Database optimization: 2 hours
- Search service: 4 hours
- Filter classes: 3 hours
- Saved filters: 3 hours
- Filament integration: 4 hours
- Export functionality: 3 hours
- Query optimization: 2 hours
- Actions: 2 hours
- API endpoints: 2 hours
- Tests: 5 hours
- Documentation: 2 hours

**Total: 32 hours (4 days)**

## Priority
**High** - Essential for activity management and audit

## Related Tasks
- Task 001: Activity Categorization System
- Task 003: Activity Analytics Dashboard
- Task 004: Activity Notification System

## Notes
- Consider implementing Elasticsearch for better full-text search performance
- Use debouncing for real-time search to avoid excessive queries
- Implement rate limiting for API endpoints
- Cache popular filter combinations

---

**Status**: Pending
**Assignee**: TBD
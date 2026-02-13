# Task 003: Build Activity Analytics Dashboard

## Description
Create a comprehensive analytics dashboard for activities with charts, metrics, trend analysis, and real-time monitoring capabilities.

## Context
Activity data is being logged but there's no visualization or analytics. Users need insights into system usage, user behavior, and activity patterns to make informed decisions.

## Requirements

### Functional Requirements
- Activity overview metrics (total, by type, by category)
- Timeline visualization of activities
- User activity analysis (most active users, activity distribution)
- Category/tag breakdown with charts
- Trend analysis (daily, weekly, monthly comparisons)
- Real-time activity monitoring
- Customizable dashboard widgets
- Export analytics reports

### Technical Requirements
- Use PHP 8.3 strict typing
- PHPStan Level 10 compliance
- Chart.js for interactive charts
- WebSocket for real-time updates
- Efficient aggregation queries
- Caching for dashboard data

## Implementation Steps

### 1. Analytics Service
- [ ] Create `ActivityAnalyticsService`
  - `getTotalActivities(): int`
  - `getActivitiesByType(): array`
  - `getActivitiesByCategory(): array`
  - `getActivitiesByTag(): array`
  - `getTopUsers(int $limit = 10): array`
  - `getActivityTrend(string $period = '7d'): array`
  - `getActivityByHour(): array`
  - `getActivityByDayOfWeek(): array`
  - `getRealTimeActivity(int $minutes = 5): array`
  - `getActivityGrowthRate(string $period): float`

### 2. Data Aggregation
- [ ] Create `ActivityAggregator` class
  - `aggregateByDateRange(Carbon $from, Carbon $to): array`
  - `aggregateByUser(int $userId): array`
  - `aggregateByCategory(int $categoryId): array`
  - `aggregateByType(string $type): array`
  - `calculateGrowthMetrics(array $data): array`

- [ ] Create database views for common aggregations
  - `activity_daily_summary`
  - `activity_category_summary`
  - `activity_user_summary`

- [ ] Create scheduled jobs for pre-computation
  - `DailyActivityAggregationJob`
  - `WeeklyActivityAggregationJob`
  - `MonthlyActivityAggregationJob`

### 3. Dashboard Widgets
- [ ] Create `ActivityOverviewWidget` (XotBaseStatsWidget)
  - Total activities count
  - Activities today
  - Activities this week
  - Activities this month
  - Growth indicators

- [ ] Create `ActivityTimelineWidget` (XotBaseChartWidget)
  - Line chart showing activity over time
  - Configurable time range (day, week, month, year)
  - Multiple data series (by type, category)

- [ ] Create `ActivityByCategoryWidget` (XotBaseChartWidget)
  - Pie chart showing category distribution
  - Doughnut chart alternative
  - Click to filter activities by category

- [ ] Create `ActivityByTagWidget` (XotBaseChartWidget)
  - Bar chart showing tag usage
  - Top N tags
  - Color-coded by tag color

- [ ] Create `TopUsersWidget` (XotBaseTableWidget)
  - List of most active users
  - Activity count per user
  - User avatar and details
  - Link to user activity

- [ ] Create `ActivityTypeDistributionWidget` (XotBaseChartWidget)
  - Horizontal bar chart
  - Activity types (create, update, delete, etc.)
  - Percentage breakdown

- [ ] Create `RealTimeActivityWidget` (XotBaseWidget)
  - Live activity feed
  - WebSocket updates
  - Auto-refresh every 5 seconds
  - Show last N activities

- [ ] Create `ActivityHeatmapWidget` (XotBaseWidget)
  - Heatmap by hour and day of week
  - Color-coded activity intensity
  - Interactive hover details

### 4. Dashboard Page
- [ ] Create `ActivityDashboardPage` (XotBasePage)
  - Grid layout for widgets
  - Responsive design
  - Customizable widget positions
  - Date range selector affecting all widgets
  - Refresh button
  - Export dashboard as PDF

### 5. Filament Resources
- [ ] Create `ActivityAnalyticsResource`
  - Analytics dashboard as main page
  - Settings page for dashboard configuration
  - Widget management (add/remove/configure)

### 6. Caching Strategy
- [ ] Implement Redis caching for analytics data
  - Cache TTL per widget type
  - Cache invalidation on new activities
  - Cache warming for common queries
  - Cache tags for selective invalidation

- [ ] Create `ActivityAnalyticsCache` service
  - `getOrSet(string $key, callable $callback, int $ttl)`
  - `invalidateWidget(string $widgetType)`
  - `invalidateAll()`
  - `warmUpCache()`

### 7. Real-time Updates
- [ ] Implement WebSocket broadcasting
  - Broadcast `ActivityCreated` events
  - Broadcast `ActivityMetricsUpdated` events
  - Channel for dashboard updates
  - Authentication for WebSocket connections

- [ ] Create `ActivityBroadcastService`
  - `broadcastActivity(Activity $activity)`
  - `broadcastMetricsUpdate(array $metrics)`
  - `subscribeToUpdates(string $userId)`

### 8. Export Functionality
- [ ] Create `ActivityAnalyticsExporter`
  - Export dashboard as PDF
  - Export metrics as CSV
  - Export charts as images
  - Generate scheduled reports

- [ ] Create `GenerateAnalyticsReportJob`
  - Weekly/monthly analytics report
  - Email to administrators
  - PDF attachment with charts

### 9. Actions
- [ ] Create `RefreshAnalyticsAction`
- [ ] Create `ExportDashboardAction`
- [ ] Create `GenerateReportAction`
- [ ] Create `ConfigureWidgetAction`

### 10. Tests
- [ ] Create `ActivityAnalyticsServiceTest`
  - Test metrics calculation
  - Test aggregation queries
  - Test trend analysis
  - Test real-time activity

- [ ] Create `ActivityDashboardWidgetTest`
  - Test widget rendering
  - Test widget data loading
  - Test widget interactions

- [ ] Create `ActivityAnalyticsCacheTest`
  - Test caching
  - Test cache invalidation
  - Test cache warming

- [ ] Create `ActivityRealTimeUpdatesTest`
  - Test WebSocket broadcasting
  - Test real-time widget updates

### 11. Documentation
- [ ] Create dashboard user guide
- [ ] Document widget configuration
- [ ] Create analytics API documentation
- [ ] Add troubleshooting guide

## Acceptance Criteria
- [ ] Dashboard loads in < 2 seconds
- [ ] All widgets display correct data
- [ ] Real-time updates work for live activities
- [ ] Caching reduces database load by 80%
- [ ] Export functionality works for all formats
- [ ] All tests pass with 85%+ coverage
- [ ] PHPStan Level 10 compliant

## Dependencies
- Task 001: Activity Categorization System
- Task 002: Advanced Activity Filtering
- Xot module (base classes)
- Filament 5.x (admin UI)
- Redis (caching)
- Laravel Broadcasting (WebSocket)

## Estimated Time
- Analytics service: 6 hours
- Data aggregation: 4 hours
- Dashboard widgets: 12 hours (8 widgets × 1.5h)
- Dashboard page: 3 hours
- Filament resources: 2 hours
- Caching strategy: 3 hours
- Real-time updates: 4 hours
- Export functionality: 3 hours
- Actions: 2 hours
- Tests: 6 hours
- Documentation: 2 hours

**Total: 47 hours (6 days)**

## Priority
**High** - Critical for insights and monitoring

## Related Tasks
- Task 001: Activity Categorization System
- Task 002: Advanced Activity Filtering
- Task 004: Activity Notification System

## Notes
- Use Chart.js for all chart widgets
- Implement lazy loading for widgets with large datasets
- Consider using Livewire for widget interactivity
- Add accessibility features for charts (aria labels, keyboard navigation)
- Use WebSocket only for critical real-time updates to avoid performance issues

---

**Status**: Pending
**Assignee**: TBD
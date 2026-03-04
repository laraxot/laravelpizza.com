# Critical Rules for MeetupDashboard Implementation

## Rule: MeetupDashboard Must Include Specific Widgets

When enhancing the MeetupDashboard (`Modules/Meetup/app/Filament/Pages/MeetupDashboard.php`), always include the following specific widgets:

1. **MeetupStatsOverviewWidget** - For key event statistics
2. **EventCalendarWidget** - For event visualization 
3. **RecentEventsWidget** - For showing latest events

This ensures the dashboard provides actionable insights specific to meetup management rather than generic content.

## Implementation Pattern

```php
public function getWidgets(): array
{
    return [
        MeetupStatsOverviewWidget::class,
        EventCalendarWidget::class,
        RecentEventsWidget::class,
    ];
}
```

## Philosophy

- Follow DRY+KISS principles by extending existing XotBaseWidget classes
- Provide meetup-specific metrics that are valuable for organizers
- Maintain consistency with Filament design patterns
- Use existing translation system for labels
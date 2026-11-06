# InlineDatePicker Component

A customizable inline date picker component for Filament forms with month navigation and enabled/disabled date support.

## Features

- **Month Navigation**: Navigate between months with previous/next buttons
- **Enabled/Disabled Dates**: Specify which dates are selectable
- **Localization**: Built-in support for multiple languages
- **Keyboard Navigation**: Full keyboard accessibility
- **Customizable Styling**: Easily customize the appearance
- **Week Numbers**: Optional week number display
- **First Day of Week**: Configure which day starts the week

## Installation

This component is part of the UI module and is available out of the box.

## Basic Usage

```php
use Modules\UI\Filament\Components\InlineDatePicker;

InlineDatePicker::make('appointment_date')
    ->label('Select Appointment Date')
    ->enabledDates(fn () => [
        now()->addDay()->format('Y-m-d'),
        now()->addDays(2)->format('Y-m-d'),
        now()->addDays(3)->format('Y-m-d'),
    ])
    ->default(now()->addDay()->format('Y-m-d'))
    ->required();
```

## Available Methods

### enabledDates(array|Closure $dates)

Specify which dates should be selectable. Other dates will be disabled.

```php
->enabledDates(['2023-06-15', '2023-06-20', '2023-06-25'])

// Or using a closure
->enabledDates(fn () => \App\Models\Appointment::pluck('date')->toArray())
```

### highlightColor(string $color)

Set the highlight color for the selected date.

```php
->highlightColor('bg-blue-600')
```

### firstDayOfWeek(string $day)

Set the first day of the week. Can be 'sunday' or 'monday' (default).

```php
->firstDayOfWeek('sunday')
```

### showWeekNumbers(bool $show = true)

Show or hide week numbers.

```php
->showWeekNumbers()
```

## Styling

The component uses Tailwind CSS classes for styling. You can customize the appearance by overriding the following CSS classes in your application's stylesheet:

```css
/* Container */
.inline-date-picker {
    @apply bg-white rounded-lg shadow p-4 w-full max-w-md;
}

/* Navigation */
.inline-date-picker-nav {
    @apply flex items-center justify-between mb-4;
}

/* Navigation buttons */
.inline-date-picker-nav-button {
    @apply p-1 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500;
}

/* Month/Year display */
.inline-date-picker-month {
    @apply text-lg font-semibold text-gray-900;
}

/* Weekday headers */
.inline-date-picker-weekdays {
    @apply grid grid-cols-7 gap-1 text-xs text-center text-gray-500;
}

/* Calendar grid */
.inline-date-picker-grid {
    @apply grid grid-cols-7 gap-1 mt-1 text-sm;
}

/* Day button */
.inline-date-picker-day {
    @apply relative p-2 text-center rounded-full transition-colors;
}

/* Today indicator */
.inline-date-picker-today {
    @apply absolute bottom-0 left-1/2 w-1 h-1 transform -translate-x-1/2 rounded-full bg-blue-600;
}
```

## Localization

The component includes English and Italian translations out of the box. To add support for additional languages, create a new translation file in `resources/lang/{locale}/datepicker.php` following the same structure as the existing files.

## Events

The component emits the following Livewire events:

- `inline-date-picker-updated` - When the displayed month changes

## Accessibility

The component includes the following accessibility features:

- ARIA labels for all interactive elements
- Keyboard navigation
- High contrast mode support
- Screen reader announcements

## Examples

### Basic Usage

```php
use Modules\UI\Filament\Components\InlineDatePicker;

InlineDatePicker::make('appointment_date')
    ->label('Select a date')
    ->required();
```

### With Enabled Dates

```php
use Carbon\Carbon;
use Modules\UI\Filament\Components\InlineDatePicker;

$enabledDates = collect()
    ->range(1, 10)
    ->map(fn ($day) => Carbon::now()->addDays($day)->format('Y-m-d'))
    ->toArray();

InlineDatePicker::make('appointment_date')
    ->label('Select an available date')
    ->enabledDates($enabledDates)
    ->required();
```

### Custom Styling

```php
use Modules\UI\Filament\Components\InlineDatePicker;

InlineDatePicker::make('appointment_date')
    ->label('Select a date')
    ->highlightColor('bg-purple-600')
    ->firstDayOfWeek('sunday')
    ->showWeekNumbers();
```

## Testing

When writing tests for forms that use the InlineDatePicker, you can interact with it using Livewire test helpers:

```php
// Select a date
Livewire::test(YourForm::class)
    ->set('appointment_date', '2023-06-15')
    ->assertSet('appointment_date', '2023-06-15');

// Test validation
Livewire::test(YourForm::class)
    ->call('submit')
    ->assertHasErrors(['appointment_date' => 'required']);
```

## Troubleshooting

### Dates not being selected

Make sure the date format matches the expected format (Y-m-d). The component expects dates in 'YYYY-MM-DD' format.

### Navigation not working

Check that you're not overriding the component's JavaScript with custom code. The navigation is handled by Alpine.js and Livewire.

### Styling issues

If the component doesn't look right, make sure you have the required Tailwind CSS utilities included in your build. The component uses standard Tailwind classes for styling.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

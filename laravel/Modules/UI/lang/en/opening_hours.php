<?php

declare(strict_types=1);

return array (
  'instructions' => 
  array (
    'title' => 'Opening Hours Configuration',
    'description' => 'Set opening hours for each day of the week. Leave empty for closed days.',
  ),
  'headers' => 
  array (
    'day' => 'Day',
    'morning' => 'Morning',
    'afternoon' => 'Afternoon',
  ),
  'legend' => 
  array (
    'open' => 'Open',
    'closed' => 'Closed',
    'format' => 'Format: HH:MM',
  ),
  'days' => 
  array (
    'monday' => 'Monday',
    'tuesday' => 'Tuesday',
    'wednesday' => 'Wednesday',
    'thursday' => 'Thursday',
    'friday' => 'Friday',
    'saturday' => 'Saturday',
    'sunday' => 'Sunday',
  ),
  'periods' => 
  array (
    'morning' => 'Morning',
    'afternoon' => 'Afternoon',
    'evening' => 'Evening',
  ),
  'labels' => 
  array (
    'morning' => 'Morning',
    'afternoon' => 'Afternoon',
    'from' => 'From',
    'to' => 'To',
    'closed' => 'Closed',
  ),
  'descriptions' => 
  array (
    'day_schedule' => 'Configure opening hours for this day',
  ),
  'placeholders' => 
  array (
    'morning_hours' => 'Morning hours',
    'afternoon_hours' => 'Afternoon hours',
  ),
  'notes' => 
  array (
    'format_hint' => 'Use 24-hour format (e.g. 14:30 for 2:30 PM)',
    'empty_hint' => 'Leave empty means "closed"',
  ),
  'validation' => 
  array (
    'invalid_format' => 'Invalid time format. Use HH:MM-HH:MM',
    'invalid_time_range' => 'Opening time must be before closing time',
    'overlapping_hours' => 'Hours cannot overlap on the same day',
    'from_before_to' => 'The "From" time must be before the "To" time',
    'to_after_from' => 'The "To" time must be after the "From" time',
    'time_sequence' => 'Start time must be before end time',
    'morning_before_afternoon' => 'For :day, morning closing time must be before afternoon opening time.',
    'missing_closing_time' => 'If you specify :session opening time for :day, you must also specify closing time.',
    'missing_opening_time' => 'If you specify :session closing time for :day, you must also specify opening time.',
    'opening_before_closing' => 'The :session opening time for :day must be before closing time.',
    'morning' => 'morning',
    'afternoon' => 'afternoon',
    'opening_hours' => 
    array (
      'morning_before_afternoon' => 'For :day, morning closing time must be before afternoon opening time.',
      'missing_closing_time' => 'If you specify :session opening time for :day, you must also specify closing time.',
      'missing_opening_time' => 'If you specify :session closing time for :day, you must also specify opening time.',
      'opening_before_closing' => 'The :session opening time for :day must be before closing time.',
      'morning' => 'morning',
      'afternoon' => 'afternoon',
    ),
  ),
  'navigation' => 
  array (
    'label' => 'Missing Navigation Label',
    'plural_label' => 'Missing Navigation Plural Label',
    'group' => 'Missing Group',
    'icon' => 'heroicon-o-puzzle-piece',
    'sort' => 100,
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
  'fields' => 
  array (
  ),
  'actions' => 
  array (
  ),
);

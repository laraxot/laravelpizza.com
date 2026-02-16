<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Scheduler',
    'plural' => 'Schedulers',
    'group' => 
    array (
      'name' => 'Jobs',
      'description' => 'Scheduled jobs management',
    ),
    'label' => 'Scheduler',
    'sort' => '55',
    'icon' => 'job-schedule-animated',
  ),
  'resource' => 
  array (
    'single' => 'Schedule',
    'plural' => 'Schedules',
    'navigation' => 'Settings',
    'history' => 'Show run history',
  ),
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Name',
      'tooltip' => 'Enter the scheduled job name',
      'placeholder' => 'Job name',
      'helper_text' => '',
      'description' => '',
    ),
    'guard_name' => 
    array (
      'label' => 'Guard',
      'tooltip' => 'Select the guard for the job',
      'placeholder' => 'Guard name',
      'helper_text' => '',
      'description' => '',
    ),
    'permissions' => 
    array (
      'label' => 'Permissions',
      'tooltip' => 'Assign necessary permissions to the job',
      'placeholder' => 'Permissions',
      'helper_text' => '',
      'description' => '',
    ),
    'first_name' => 
    array (
      'label' => 'First Name',
      'tooltip' => 'Responsible person first name',
      'placeholder' => 'Responsible first name',
      'helper_text' => '',
      'description' => '',
    ),
    'last_name' => 
    array (
      'label' => 'Last Name',
      'tooltip' => 'Responsible person last name',
      'placeholder' => 'Responsible last name',
      'helper_text' => '',
      'description' => '',
    ),
    'command' => 
    array (
      'label' => 'Command',
      'tooltip' => 'Enter the command to execute',
      'placeholder' => 'Command',
      'helper_text' => '',
      'description' => '',
    ),
    'arguments' => 
    array (
      'label' => 'Arguments',
      'tooltip' => 'Specify any arguments for the command',
      'placeholder' => 'Arguments',
      'helper_text' => '',
      'description' => '',
    ),
    'options' => 
    array (
      'label' => 'Options',
      'tooltip' => 'Enter any options for the command',
      'placeholder' => 'Options',
      'helper_text' => '',
      'description' => '',
    ),
    'expression' => 
    array (
      'label' => 'Cron Expression',
      'tooltip' => 'Set the cron expression for scheduling',
      'placeholder' => 'Cron Expression',
      'helper_text' => '',
      'description' => '',
    ),
    'log_filename' => 
    array (
      'label' => 'Log Filename',
      'tooltip' => 'Log file name',
      'placeholder' => 'Log filename',
      'helper_text' => '',
      'description' => '',
    ),
    'status' => 
    array (
      'label' => 'Status',
      'tooltip' => 'Current job status',
      'placeholder' => 'Status',
      'helper_text' => '',
      'description' => '',
    ),
    'actions' => 
    array (
      'label' => 'Actions',
      'tooltip' => 'Available actions for the job',
      'icon' => 'action-icon',
      'color' => 'blue',
      'helper_text' => '',
      'description' => '',
    ),
    'run_in_background' => 
    array (
      'label' => 'Run in Background',
      'tooltip' => 'Run the job in background',
      'placeholder' => 'Run in background',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Created At',
      'tooltip' => 'Job creation date',
      'placeholder' => 'Creation date',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Updated At',
      'tooltip' => 'Last update date',
      'placeholder' => 'Update date',
      'helper_text' => '',
      'description' => '',
    ),
    'timezone' => 
    array (
      'label' => 'Timezone',
      'tooltip' => 'Set the timezone for the job',
      'placeholder' => 'Timezone',
      'helper_text' => '',
      'description' => '',
    ),
    'toggleColumns' => 
    array (
      'label' => 'toggleColumns',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'reorderRecords' => 
    array (
      'label' => 'reorderRecords',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'resetFilters' => 
    array (
      'label' => 'resetFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'messages' => 
  array (
    'no-records-found' => 'No records found.',
    'save-success' => 'Data saved successfully.',
    'save-error' => 'Error saving data.',
    'timezone' => 'All schedules will be executed in the timezone: ',
    'select' => 'Select a command',
    'custom' => 'Custom Command',
    'custom-command-here' => 'Custom Command here (e.g. `cat /proc/cpuinfo` or `artisan db:migrate`)',
  ),
  'status' => 
  array (
    'active' => 'Active',
    'inactive' => 'Inactive',
    'trashed' => 'Trashed',
    'running' => 'Running',
    'failed' => 'Failed',
  ),
  'buttons' => 
  array (
    'inactivate' => 
    array (
      'label' => 'Inactivate',
      'icon' => 'icon-inactivate',
      'color' => 'gray',
    ),
    'activate' => 
    array (
      'label' => 'Activate',
      'icon' => 'icon-activate',
      'color' => 'green',
    ),
    'history' => 
    array (
      'label' => 'History',
      'icon' => 'icon-history',
      'color' => 'purple',
    ),
    'run' => 
    array (
      'label' => 'Run Now',
      'modal' => 
      array (
        'heading' => 'Run Schedule',
        'description' => 'Do you want to run this schedule now?',
      ),
      'messages' => 
      array (
        'success' => 'Schedule executed successfully',
      ),
      'icon' => 'icon-run',
      'color' => 'blue',
    ),
    'toggle' => 
    array (
      'label' => 'Activate/Deactivate',
      'modal' => 
      array (
        'heading' => 'Modify Status',
        'description' => 'Do you want to modify the status of this schedule?',
      ),
      'messages' => 
      array (
        'success' => 'Status modified successfully',
      ),
      'icon' => 'icon-toggle',
      'color' => 'orange',
    ),
    'delete' => 
    array (
      'label' => 'Delete',
      'modal' => 
      array (
        'heading' => 'Delete Schedule',
        'description' => 'Are you sure you want to delete this schedule?',
      ),
      'messages' => 
      array (
        'success' => 'Schedule deleted successfully',
      ),
      'icon' => 'icon-delete',
      'color' => 'red',
    ),
  ),
  'validation' => 
  array (
    'cron' => 'The field must be filled in the cron expression format.',
    'regex' => 'The :attribute field must only contain letters, numbers, dashes, and underscores. Comma is also allowed.',
  ),
  'frequencies' => 
  array (
    'everyMinute' => 'Every Minute',
    'everyFiveMinutes' => 'Every 5 Minutes',
    'everyTenMinutes' => 'Every 10 Minutes',
    'everyFifteenMinutes' => 'Every 15 Minutes',
    'everyThirtyMinutes' => 'Every 30 Minutes',
    'hourly' => 'Every Hour',
    'daily' => 'Every Day',
    'weekly' => 'Every Week',
    'monthly' => 'Every Month',
    'quarterly' => 'Every Quarter',
    'yearly' => 'Every Year',
  ),
  'days' => 
  array (
    'sunday' => 'Sunday',
    'monday' => 'Monday',
    'tuesday' => 'Tuesday',
    'wednesday' => 'Wednesday',
    'thursday' => 'Thursday',
    'friday' => 'Friday',
    'saturday' => 'Saturday',
  ),
  'cron' => 
  array (
    'help' => 
    array (
      'title' => 'Cron Expressions Help',
      'minute' => 'Minute (0-59)',
      'hour' => 'Hour (0-23)',
      'day_of_month' => 'Day of Month (1-31)',
      'month' => 'Month (1-12)',
      'day_of_week' => 'Day of Week (0-6)',
      'examples' => 
      array (
        'every_minute' => '* * * * * - Every minute',
        'every_hour' => '0 * * * * - Every hour',
        'every_day' => '0 0 * * * - Every day at midnight',
        'every_monday' => '0 0 * * 1 - Every Monday at midnight',
      ),
    ),
  ),
  'model' => 
  array (
    'label' => 'schedule.model',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
  'actions' => 
  array (
  ),
);

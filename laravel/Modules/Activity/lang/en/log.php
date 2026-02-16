<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Log',
    'plural' => 'Log',
    'group' => 
    array (
      'name' => 'Monitoring',
      'description' => 'System log management',
    ),
    'label' => 'Log',
    'sort' => '61',
    'icon' => 'activity-log-animated',
  ),
  'fields' => 
  array (
    'level' => 
    array (
      'label' => 'Level',
      'emergency' => 'Emergency',
      'alert' => 'Alert',
      'critical' => 'Critical',
      'error' => 'Error',
      'warning' => 'Warning',
      'notice' => 'Notice',
      'info' => 'Info',
      'debug' => 'Debug',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'message' => 
    array (
      'label' => 'Message',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'context' => 
    array (
      'label' => 'Context',
      'exception' => 'Exception',
      'stack_trace' => 'Stack Trace',
      'additional' => 'Additional Info',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'channel' => 
    array (
      'label' => 'Channel',
      'system' => 'System',
      'application' => 'Application',
      'security' => 'Security',
      'database' => 'Database',
      'queue' => 'Queues',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'datetime' => 
    array (
      'label' => 'Date and Time',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'environment' => 
    array (
      'label' => 'Environment',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'filters' => 
  array (
    'level' => 'Level',
    'channel' => 'Channel',
    'date_range' => 'Date Range',
    'environment' => 'Environment',
    'search' => 'Search in message',
  ),
  'actions' => 
  array (
    'view_details' => 'View Details',
    'download' => 'Download',
    'clear' => 'Clear',
    'archive' => 'Archive',
  ),
  'messages' => 
  array (
    'no_logs' => 'No logs found',
    'cleared' => 'Logs cleared successfully',
    'archived' => 'Logs archived successfully',
    'downloaded' => 'Log file downloaded successfully',
  ),
  'badges' => 
  array (
    'level' => 
    array (
      'emergency' => 'Emergency',
      'alert' => 'Alert',
      'critical' => 'Critical',
      'error' => 'Error',
      'warning' => 'Warning',
      'notice' => 'Notice',
      'info' => 'Info',
      'debug' => 'Debug',
    ),
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);

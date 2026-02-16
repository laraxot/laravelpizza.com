<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Dashboard',
    'plural' => 'Dashboard',
    'group' => 
    array (
      'name' => 'Monitoring',
      'description' => 'Activity overview',
    ),
    'label' => 'Dashboard',
    'sort' => '59',
    'icon' => 'activity-dashboard-animated',
  ),
  'widgets' => 
  array (
    'recent_activities' => 'Recent Activities',
    'activity_summary' => 'Activity Summary',
    'top_users' => 'Most Active Users',
    'activity_by_type' => 'Activity by Type',
    'system_health' => 'System Status',
    'error_logs' => 'Error Logs',
  ),
  'charts' => 
  array (
    'activities_over_time' => 'Activities Over Time',
    'activities_by_user' => 'Activities by User',
    'activities_by_type' => 'Activities by Type',
    'error_distribution' => 'Error Distribution',
  ),
  'metrics' => 
  array (
    'total_activities' => 'Total Activities',
    'unique_users' => 'Unique Users',
    'average_actions' => 'Average Actions',
    'error_rate' => 'Error Rate',
  ),
  'periods' => 
  array (
    'last_hour' => 'Last Hour',
    'today' => 'Today',
    'yesterday' => 'Yesterday',
    'last_7_days' => 'Last 7 Days',
    'last_30_days' => 'Last 30 Days',
    'this_month' => 'This Month',
    'last_month' => 'Last Month',
    'custom' => 'Custom',
  ),
  'status' => 
  array (
    'healthy' => 'Healthy',
    'warning' => 'Warning',
    'critical' => 'Critical',
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

<?php

declare(strict_types=1);

return array (
  'pages' => 'Pages',
  'widgets' => 'Widgets',
  'navigation' => 
  array (
    'name' => 'Job',
    'plural' => 'Jobs',
    'group' => 
    array (
      'name' => 'Jobs',
      'description' => 'Background process management',
    ),
    'label' => 'jobs',
    'sort' => 30,
    'icon' => 'heroicon-o-cog',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => 'Unique job identifier',
      'helper_text' => '',
      'description' => '',
    ),
    'queue' => 
    array (
      'label' => 'Queue',
      'tooltip' => 'The queue this job belongs to',
      'helper_text' => '',
      'description' => '',
    ),
    'payload' => 
    array (
      'label' => 'Payload',
      'tooltip' => 'Data associated with the job',
      'helper_text' => '',
      'description' => '',
    ),
    'attempts' => 
    array (
      'label' => 'Attempts',
      'tooltip' => 'Number of attempts to execute the job',
      'helper_text' => '',
      'description' => '',
    ),
    'reserved_at' => 
    array (
      'label' => 'Reserved at',
      'tooltip' => 'Date and time when the job was reserved',
      'helper_text' => '',
      'description' => '',
    ),
    'available_at' => 
    array (
      'label' => 'Available at',
      'tooltip' => 'Date and time when the job became available',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Created at',
      'tooltip' => 'Job creation date',
      'helper_text' => '',
      'description' => '',
    ),
    'status' => 
    array (
      'label' => 'Status',
      'tooltip' => 'Current job status',
      'helper_text' => '',
      'description' => '',
    ),
    'progress' => 
    array (
      'label' => 'Progress',
      'tooltip' => 'Job completion percentage',
      'helper_text' => '',
      'description' => '',
    ),
    'type' => 
    array (
      'label' => 'Type',
      'tooltip' => 'Job type (e.g., import, export)',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Name',
      'tooltip' => 'Job name',
      'helper_text' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => 'Description',
      'tooltip' => 'Job description',
      'placeholder' => 'Enter a description',
      'helper_text' => '',
      'description' => '',
    ),
    'guard_name' => 
    array (
      'label' => 'Guard',
      'tooltip' => 'Job guardian',
      'helper_text' => '',
      'description' => '',
    ),
    'permissions' => 
    array (
      'label' => 'Permissions',
      'tooltip' => 'Permissions associated with the job',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Updated at',
      'tooltip' => 'Date of last job update',
      'helper_text' => '',
      'description' => '',
    ),
    'first_name' => 
    array (
      'label' => 'First Name',
      'tooltip' => 'Responsible person\'s first name',
      'helper_text' => '',
      'description' => '',
    ),
    'last_name' => 
    array (
      'label' => 'Last Name',
      'tooltip' => 'Responsible person\'s last name',
      'helper_text' => '',
      'description' => '',
    ),
    'select_all' => 
    array (
      'label' => 'Select All',
      'tooltip' => 'Select all available items',
      'helper_text' => '',
      'description' => '',
    ),
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
      'tooltip' => '',
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
    'openFilters' => 
    array (
      'label' => 'openFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'value' => 
    array (
      'label' => 'value',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'import' => 
    array (
      'label' => 'Import',
      'tooltip' => 'Import data from a file',
      'icon' => 'import-icon',
      'color' => 'blue',
      'fields' => 
      array (
        'import_file' => 
        array (
          'label' => 'Select an XLS or CSV file to upload',
          'placeholder' => 'Select the file to upload',
        ),
      ),
    ),
    'export' => 
    array (
      'label' => 'Export',
      'tooltip' => 'Export data to a file',
      'icon' => 'export-icon',
      'color' => 'green',
      'filename_prefix' => 'Areas as of',
      'columns' => 
      array (
        'name' => 
        array (
          'label' => 'Area name',
          'tooltip' => 'Name of the area to export',
        ),
        'parent_name' => 
        array (
          'label' => 'Parent area name',
          'tooltip' => 'Name of the parent area',
        ),
      ),
    ),
    'run' => 
    array (
      'label' => 'Run',
      'icon' => 'play',
      'color' => 'green',
      'modal' => 
      array (
        'heading' => 'Run Job',
        'description' => 'Do you want to run this job?',
      ),
      'messages' => 
      array (
        'success' => 'Job started successfully',
      ),
    ),
    'stop' => 
    array (
      'label' => 'Stop',
      'icon' => 'pause',
      'color' => 'red',
      'modal' => 
      array (
        'heading' => 'Stop Job',
        'description' => 'Do you want to stop this job?',
      ),
      'messages' => 
      array (
        'success' => 'Job stopped successfully',
      ),
    ),
    'delete' => 
    array (
      'label' => 'Delete',
      'icon' => 'trash',
      'color' => 'red',
      'modal' => 
      array (
        'heading' => 'Delete Job',
        'description' => 'Are you sure you want to delete this job?',
      ),
      'messages' => 
      array (
        'success' => 'Job deleted successfully',
      ),
    ),
  ),
  'messages' => 
  array (
    'no_jobs' => 'No jobs present',
    'job_started' => 'Job started',
    'job_stopped' => 'Job stopped',
    'job_completed' => 'Job completed',
    'job_failed' => 'Job failed',
  ),
  'statuses' => 
  array (
    'pending' => 'Pending',
    'processing' => 'Processing',
    'completed' => 'Completed',
    'failed' => 'Failed',
    'stopped' => 'Stopped',
  ),
  'types' => 
  array (
    'import' => 'Import',
    'export' => 'Export',
    'process' => 'Process',
    'notification' => 'Notification',
    'cleanup' => 'Cleanup',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);

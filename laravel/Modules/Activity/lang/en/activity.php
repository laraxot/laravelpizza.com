<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Activity',
        'plural' => 'Activities',
        'group' => [
            'name' => 'Monitoring',
            'description' => 'System activity monitoring',
        ],
        'label' => 'Activity',
        'sort' => '60',
        'icon' => 'heroicon-o-activity',
    ],
    'fields' => [
        'user' => [
            'label' => 'User',
            'placeholder' => 'Select a user',
            'help' => 'The user who performed the action',
            'name' => [
                'label' => 'Name',
                'placeholder' => 'Enter the name',
                'help' => 'Full name of the user',
                'validation' => 'required|string|max:255',
            ],
            'email' => [
                'label' => 'Email',
                'placeholder' => 'Enter the email',
                'help' => 'User email address',
                'validation' => 'required|email|max:255',
            ],
            'role' => [
                'label' => 'Role',
                'placeholder' => 'Select a role',
                'help' => 'User role in the system',
                'validation' => 'required|string',
            ],
        ],
        'action' => [
            'label' => 'Action',
            'placeholder' => 'Select an action',
            'help' => 'Type of action performed',
            'validation' => 'required|string',
            'options' => [
                'created' => [
                    'label' => 'Created',
                    'icon' => 'heroicon-o-plus-circle',
                    'color' => 'success',
                ],
                'updated' => [
                    'label' => 'Updated',
                    'icon' => 'heroicon-o-pencil',
                    'color' => 'warning',
                ],
                'deleted' => [
                    'label' => 'Deleted',
                    'icon' => 'heroicon-o-trash',
                    'color' => 'danger',
                ],
                'viewed' => [
                    'label' => 'Viewed',
                    'icon' => 'heroicon-o-eye',
                    'color' => 'info',
                ],
                'downloaded' => [
                    'label' => 'Downloaded',
                    'icon' => 'heroicon-o-arrow-down-tray',
                    'color' => 'primary',
                ],
                'uploaded' => [
                    'label' => 'Uploaded',
                    'icon' => 'heroicon-o-arrow-up-tray',
                    'color' => 'primary',
                ],
                'logged_in' => [
                    'label' => 'Logged In',
                    'icon' => 'heroicon-o-arrow-right-on-rectangle',
                    'color' => 'success',
                ],
                'logged_out' => [
                    'label' => 'Logged Out',
                    'icon' => 'heroicon-o-arrow-left-on-rectangle',
                    'color' => 'gray',
                ],
            ],
        ],
        'subject' => [
            'label' => 'Subject',
            'placeholder' => 'Select a subject',
            'help' => 'The object affected by the action',
            'type' => [
                'label' => 'Type',
                'placeholder' => 'Type of object',
                'help' => 'Class or type of the object',
                'validation' => 'nullable|string|max:255',
            ],
            'id' => [
                'label' => 'ID',
                'placeholder' => 'Object ID',
                'help' => 'Unique identifier of the object',
                'validation' => 'nullable|integer|min:1',
            ],
            'name' => [
                'label' => 'Name',
                'placeholder' => 'Name of the object',
                'help' => 'Descriptive name of the object',
                'validation' => 'nullable|string|max:255',
            ],
        ],
        'description' => [
            'label' => 'Description',
            'placeholder' => 'Enter a description',
            'help' => 'Detailed description of the activity',
            'validation' => 'nullable|string|max:1000',
        ],
        'ip_address' => [
            'label' => 'IP Address',
            'placeholder' => 'E.g. 192.168.1.1',
            'help' => 'IP address from which the action was performed',
            'validation' => 'nullable|ip',
        ],
        'user_agent' => [
            'label' => 'User Agent',
            'placeholder' => 'Browser and operating system',
            'help' => 'Information about the user\'s browser and system',
            'validation' => 'nullable|string|max:500',
        ],
        'created_at' => [
            'label' => 'Date',
            'placeholder' => 'Select date and time',
            'help' => 'Date and time when the activity was created',
            'validation' => 'required|date',
            'format' => 'd/m/Y H:i:s',
        ],
        'properties' => [
            'label' => 'Properties',
            'placeholder' => 'Additional properties',
            'help' => 'Additional data of the activity',
            'old' => [
                'label' => 'Old Value',
                'placeholder' => 'Previous value',
                'help' => 'Value before the change',
            ],
            'new' => [
                'label' => 'New Value',
                'placeholder' => 'Current value',
                'help' => 'Value after the change',
            ],
        ],
        'toggleColumns' => [
            'label' => 'Show/Hide Columns',
            'help' => 'Configure column visibility',
        ],
        'reorderRecords' => [
            'label' => 'Reorder Records',
            'help' => 'Reorder records in the table',
        ],
        'resetFilters' => [
            'label' => 'Reset Filters',
        ],
        'applyFilters' => [
            'label' => 'Apply Filters',
        ],
    ],
    'filters' => [
        'user' => [
            'label' => 'User',
            'placeholder' => 'Filter by user',
            'help' => 'Filter activities by user',
            'type' => 'select',
            'searchable' => '1',
        ],
        'action' => [
            'label' => 'Action',
            'placeholder' => 'Filter by action',
            'help' => 'Filter activities by action type',
            'type' => 'select',
            'multiple' => '1',
        ],
        'subject_type' => [
            'label' => 'Subject Type',
            'placeholder' => 'Filter by subject type',
            'help' => 'Filter activities by subject type',
            'type' => 'select',
            'searchable' => '1',
        ],
        'date_range' => [
            'label' => 'Date Range',
            'placeholder' => 'Select range',
            'help' => 'Filter activities by date range',
            'type' => 'date_range',
            'presets' => [
                'today' => 'Today',
                'yesterday' => 'Yesterday',
                'last_7_days' => 'Last 7 Days',
                'last_30_days' => 'Last 30 Days',
                'this_month' => 'This Month',
                'last_month' => 'Last Month',
            ],
        ],
        'ip_address' => [
            'label' => 'IP Address',
            'placeholder' => 'Filter by IP',
            'help' => 'Filter activities by IP address',
            'type' => 'text',
        ],
    ],
    'actions' => [
        'view_details' => [
            'label' => 'View Details',
            'icon' => 'heroicon-o-eye',
            'color' => 'primary',
            'success' => 'Details loaded successfully',
            'error' => 'Error loading details',
            'confirmation' => 'Do you want to view the details of this activity?',
        ],
        'export' => [
            'label' => 'Export',
            'icon' => 'heroicon-o-arrow-down-tray',
            'color' => 'success',
            'success' => 'Export completed successfully',
            'error' => 'Error during export',
            'confirmation' => 'Do you want to export the selected activities?',
        ],
        'clear_old' => [
            'label' => 'Clear Old',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'success' => 'Old activities deleted successfully',
            'error' => 'Error clearing activities',
            'confirmation' => 'Are you sure you want to delete old activities? This action cannot be undone.',
            'days_threshold' => '90',
        ],
        'bulk_delete' => [
            'label' => 'Delete Selected',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'success' => 'Selected activities deleted successfully',
            'error' => 'Error deleting activities',
            'confirmation' => 'Are you sure you want to delete the selected activities?',
        ],
    ],
    'messages' => [
        'no_activities' => 'No activities found for the selected filters',
        'cleared' => 'Old activities deleted successfully',
        'exported' => 'Activities exported successfully',
        'loading' => 'Loading activities...',
        'error_loading' => 'Error loading activities',
        'empty_state' => [
            'title' => 'No activities recorded',
            'description' => 'There are no activities to display yet. Activities will appear here when users start interacting with the system.',
        ],
    ],
    'export' => [
        'formats' => [
            'csv' => [
                'label' => 'CSV',
                'mime_type' => 'text/csv',
                'extension' => 'csv',
                'icon' => 'heroicon-o-document-text',
            ],
            'excel' => [
                'label' => 'Excel',
                'mime_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'extension' => 'xlsx',
                'icon' => 'heroicon-o-table-cells',
            ],
            'pdf' => [
                'label' => 'PDF',
                'mime_type' => 'application/pdf',
                'extension' => 'pdf',
                'icon' => 'heroicon-o-document',
            ],
        ],
        'columns' => [
            'date' => [
                'label' => 'Date',
                'format' => 'd/m/Y H:i:s',
                'sortable' => '1',
            ],
            'user' => [
                'label' => 'User',
                'sortable' => '1',
            ],
            'action' => [
                'label' => 'Action',
                'sortable' => '1',
            ],
            'subject' => [
                'label' => 'Subject',
                'sortable' => '',
            ],
            'ip' => [
                'label' => 'IP',
                'sortable' => '1',
            ],
            'description' => [
                'label' => 'Description',
                'sortable' => '',
            ],
        ],
        'filename_pattern' => 'activity_{date}_{time}',
        'max_records' => '10000',
    ],
    'permissions' => [
        'view' => 'activities.view',
        'create' => 'activities.create',
        'update' => 'activities.update',
        'delete' => 'activities.delete',
        'export' => 'activities.export',
        'clear_old' => 'activities.clear_old',
    ],
    'pagination' => [
        'per_page' => '25',
        'options' => [
            '0' => '10',
            '1' => '25',
            '2' => '50',
            '3' => '100',
        ],
    ],
    'cache' => [
        'ttl' => '300',
        'tags' => [
            '0' => 'activities',
            '1' => 'monitoring',
        ],
    ],
];

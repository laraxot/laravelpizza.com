<?php

declare(strict_types=1);

return [
    'label' => 'Export Xls',
    'plural_label' => 'Export Xls',
    'icon' => 'xot-files.xls',
    'tooltip' => 'Export Excel (XLS)',
    'actions' => [
        'export_xls' => [
            'label' => 'Export Excel',
            'icon' => 'xot-files.xls',
            'tooltip' => 'Export data in Excel format (.xlsx)',
            'placeholder' => 'Export to Excel',
            'help' => 'Download current data in Excel format for offline analysis',
            'description' => 'Action to export data in Excel format',
            'success' => 'Excel export completed successfully',
            'error' => 'An error occurred during Excel export',
            'modal' => [
                'heading' => 'Export to Excel',
                'description' => 'Select export options for the Excel file',
                'confirm' => 'Export',
                'cancel' => 'Cancel',
            ],
            'options' => [
                'include_headers' => 'Include column headers',
                'format_dates' => 'Format dates',
                'include_totals' => 'Include totals',
            ],
        ],
    ],
    'navigation' => [
        'label' => 'Export Xls',
        'plural_label' => 'Export Xls',
        'group' => 'General',
        'icon' => 'xot-files.xls',
        'sort' => 100,
    ],
    'fields' => [
    ],
];

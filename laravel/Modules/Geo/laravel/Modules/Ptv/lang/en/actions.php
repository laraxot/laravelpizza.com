<?php

declare(strict_types=1);

return [
    'fill_out_the_form' => 'fill out',
    'resource' => [
        'name' => 'Action',
    ],
    'navigation' => [
        'name' => 'Action',
        'plural' => 'Actions',
        'group' => [
            'name' => 'Admin',
        ],
    ],
    'fields' => [
        'brand' => 'Brand',
        'model' => 'Model',
        'description' => 'Description',
        'serial_number' => 'Serial number',
        'inventory_number' => 'Inventory code',
        'code' => 'Identifier',
        'manufacturing_year' => 'Manufacturing year',
        'purchase_year' => 'Purchase year',
        'is_enabled' => 'Is active?',
        'asset_type' => 'Type',
        'area' => 'Area',
        'parent' => 'Parent asset',
        'name' => 'Name',
    ],
    'actions' => [
        'compila' => [
            'label' => 'Fill out',
        ],
        'copy_from_last_year' => 'Copy from last year',
        'merge_double_row_cateco_year' => 'Merge double Cateco rows by year',
        'populate_year' => 'Populate year',
        'trova_esclusi' => [
            'label' => 'Find excluded',
        ],
        'fill_out_the_form' => 'Fill out',
        'showing_records' => 'Showing :count of :total records',
        'showing_limited_results' => 'Only the first 50 records are shown. Adjust filters to narrow results.',
        'enable' => [
            'cta' => 'Enable',
        ],
        'disable' => [
            'cta' => 'Disable',
        ],
        'import' => [
            'row_number' => 'Row :row',
            'fields' => [
                'import_file' => 'Select an XLS or CSV file to upload',
            ],
        ],
        'export' => [
            'filename_prefix' => 'Asset list as of',
            'columns' => [
                'brand' => 'Brand',
                'model' => 'Model',
                'description' => 'Description',
                'serial_number' => 'Serial number',
                'inventory_number' => 'Inventory code',
                'code' => 'Identifier',
                'manufacturing_year' => 'Manufacturing year',
                'purchase_year' => 'Purchase year',
                'is_enabled' => 'Is active?',
                'asset_type' => 'Type',
                'parent_inventory_number' => 'Parent inventory code',
            ],
        ],
        'delete_cessati' => [
            'label' => 'Delete Cessati',
            'selection_title' => 'Year Selection',
            'selection_description' => 'Select the year to find records that exist in Indennità Responsabilità but not in Rep00f',
            'year_label' => 'Year',
            'year_placeholder' => 'Select a year',
            'records_title' => 'Records to Delete',
            'records_description' => 'These records will be permanently deleted',
            'count_label' => 'Records found',
            'preview_label' => 'Records preview',
            'select_year' => 'Select a year',
            'records_found' => ':count records found',
            'no_records_found' => 'No records found',
            'more_records' => 'and :count more records...',
            'modal_title' => 'Delete Cessati Records',
            'modal_heading' => 'Delete Cessati Records',
            'modal_description' => 'Delete records that exist in Indennità Responsabilità but not in Rep00f for the selected year',
            'confirm_delete' => 'Delete Records',
            'submit_label' => 'Delete Records',
            'cancel' => 'Cancel',
            'cancel_label' => 'Cancel',
            'no_records_error' => 'No records found for the selected year',
            'no_year_error' => 'Please select a year',
            'success_title' => 'Records Deleted Successfully',
            'success_message' => ':count records have been deleted',
            'no_records_title' => 'No Records to Delete',
            'no_records_message' => 'No records found for the selected year',
            'error_title' => 'Deletion Error',
            'error_message' => 'An error occurred: :error',
        ],
    ],
    'widgets' => [
        'child_assets' => 'Child assets',
    ],
    'exceptions' => [
        'mandatory_data' => '{1} Mandatory data not present|{2} 2 Mandatory data not present|{3} 3 Mandatory data not present|[4,*] Several mandatory data not present',
    ],
];

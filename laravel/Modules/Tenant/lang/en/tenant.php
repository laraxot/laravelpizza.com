<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Tenant',
        'group' => 'System',
        'sort' => 25,
        'icon' => 'tenant-main-animated',
        'badge' => [
            'color' => 'success',
            'label' => 'Multi-tenant',
        ],
    ],
    'sections' => [
        'building' => [
            'navigation' => [
                'name' => 'Buildings',
                'group' => 'Tenant',
                'sort' => 10,
                'icon' => 'tenant-building-animated',
                'badge' => [
                    'color' => 'info',
                    'label' => 'Management',
                ],
            ],
            'fields' => [
                'name' => 'Name',
                'address' => 'Address',
                'units' => 'Units',
                'manager' => 'Manager',
                'status' => 'Status',
                'notes' => 'Notes',
            ],
        ],
        'unit' => [
            'navigation' => [
                'name' => 'Property Units',
                'group' => 'Tenant',
                'sort' => 20,
                'icon' => 'tenant-unit-icon',
                'badge' => [
                    'color' => 'warning',
                    'label' => 'Occupation',
                ],
            ],
            'fields' => [
                'number' => 'Number',
                'floor' => 'Floor',
                'type' => 'Type',
                'size' => 'Size',
                'tenant' => 'Tenant',
                'rent' => 'Rent',
                'status' => 'Status',
            ],
            'types' => [
                'apartment' => 'Apartment',
                'office' => 'Office',
                'store' => 'Store',
                'warehouse' => 'Warehouse',
            ],
        ],
        'tenant' => [
            'navigation' => [
                'name' => 'Tenants',
                'group' => 'Tenant',
                'sort' => 30,
                'icon' => 'tenant-person-icon',
                'badge' => [
                    'color' => 'primary',
                    'label' => 'Contracts',
                ],
            ],
            'fields' => [
                'name' => 'Name',
                'last_name' => 'Last Name',
                'tax_code' => 'Tax Code',
                'email' => 'Email',
                'phone' => 'Phone',
                'contract_start' => 'Contract Start',
                'contract_end' => 'Contract End',
                'deposit' => 'Security Deposit',
            ],
        ],
    ],
    'common' => [
        'status' => [
            'active' => 'Active',
            'inactive' => 'Inactive',
            'maintenance' => 'Under Maintenance',
            'reserved' => 'Reserved',
        ],
        'actions' => [
            'create' => 'Create',
            'edit' => 'Edit',
            'delete' => 'Delete',
            'view' => 'View',
            'assign' => 'Assign',
            'unassign' => 'Remove Assignment',
            'renew' => 'Renew',
            'terminate' => 'Terminate',
        ],
        'messages' => [
            'success' => [
                'created' => 'Created successfully',
                'updated' => 'Updated successfully',
                'deleted' => 'Deleted successfully',
                'assigned' => 'Assigned successfully',
                'unassigned' => 'Assignment removed successfully',
            ],
            'error' => [
                'create' => 'Error during creation',
                'update' => 'Error during update',
                'delete' => 'Error during deletion',
                'assign' => 'Error during assignment',
                'unassign' => 'Error during assignment removal',
            ],
            'confirm' => [
                'delete' => 'Are you sure you want to delete this item?',
                'terminate' => 'Are you sure you want to terminate this contract?',
            ],
        ],
        'filters' => [
            'status' => 'Status',
            'type' => 'Type',
            'floor' => 'Floor',
            'date_range' => 'Period',
            'occupation' => 'Occupation',
        ],
    ],
];

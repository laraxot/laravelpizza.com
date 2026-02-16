<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Tenant',
    'group' => 'System',
    'sort' => 25,
    'icon' => 'tenant-main-animated',
    'badge' => 
    array (
      'color' => 'success',
      'label' => 'Multi-tenant',
    ),
  ),
  'sections' => 
  array (
    'building' => 
    array (
      'navigation' => 
      array (
        'name' => 'Buildings',
        'group' => 'Tenant',
        'sort' => 10,
        'icon' => 'tenant-building-animated',
        'badge' => 
        array (
          'color' => 'info',
          'label' => 'Management',
        ),
      ),
      'fields' => 
      array (
        'name' => 'Name',
        'address' => 'Address',
        'units' => 'Units',
        'manager' => 'Manager',
        'status' => 'Status',
        'notes' => 'Notes',
      ),
    ),
    'unit' => 
    array (
      'navigation' => 
      array (
        'name' => 'Property Units',
        'group' => 'Tenant',
        'sort' => 20,
        'icon' => 'tenant-unit-icon',
        'badge' => 
        array (
          'color' => 'warning',
          'label' => 'Occupation',
        ),
      ),
      'fields' => 
      array (
        'number' => 'Number',
        'floor' => 'Floor',
        'type' => 'Type',
        'size' => 'Size',
        'tenant' => 'Tenant',
        'rent' => 'Rent',
        'status' => 'Status',
      ),
      'types' => 
      array (
        'apartment' => 'Apartment',
        'office' => 'Office',
        'store' => 'Store',
        'warehouse' => 'Warehouse',
      ),
    ),
    'tenant' => 
    array (
      'navigation' => 
      array (
        'name' => 'Tenants',
        'group' => 'Tenant',
        'sort' => 30,
        'icon' => 'tenant-person-icon',
        'badge' => 
        array (
          'color' => 'primary',
          'label' => 'Contracts',
        ),
      ),
      'fields' => 
      array (
        'name' => 'Name',
        'last_name' => 'Last Name',
        'tax_code' => 'Tax Code',
        'email' => 'Email',
        'phone' => 'Phone',
        'contract_start' => 'Contract Start',
        'contract_end' => 'Contract End',
        'deposit' => 'Security Deposit',
      ),
    ),
  ),
  'common' => 
  array (
    'status' => 
    array (
      'active' => 'Active',
      'inactive' => 'Inactive',
      'maintenance' => 'Under Maintenance',
      'reserved' => 'Reserved',
    ),
    'actions' => 
    array (
      'create' => 'Create',
      'edit' => 'Edit',
      'delete' => 'Delete',
      'view' => 'View',
      'assign' => 'Assign',
      'unassign' => 'Remove Assignment',
      'renew' => 'Renew',
      'terminate' => 'Terminate',
    ),
    'messages' => 
    array (
      'success' => 
      array (
        'created' => 'Created successfully',
        'updated' => 'Updated successfully',
        'deleted' => 'Deleted successfully',
        'assigned' => 'Assigned successfully',
        'unassigned' => 'Assignment removed successfully',
      ),
      'error' => 
      array (
        'create' => 'Error during creation',
        'update' => 'Error during update',
        'delete' => 'Error during deletion',
        'assign' => 'Error during assignment',
        'unassign' => 'Error during assignment removal',
      ),
      'confirm' => 
      array (
        'delete' => 'Are you sure you want to delete this item?',
        'terminate' => 'Are you sure you want to terminate this contract?',
      ),
    ),
    'filters' => 
    array (
      'status' => 'Status',
      'type' => 'Type',
      'floor' => 'Floor',
      'date_range' => 'Period',
      'occupation' => 'Occupation',
    ),
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

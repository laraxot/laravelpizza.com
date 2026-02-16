<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Menu',
    'plural' => 'Menus',
    'group' => 
    array (
      'name' => 'Menu Management',
      'description' => 'Manage website menus',
    ),
    'label' => 'Menus',
    'sort' => '57',
    'icon' => 'heroicon-o-bars-3',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'placeholder' => 'Menu ID',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Name',
      'placeholder' => 'Menu name',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'slug' => 
    array (
      'label' => 'Slug',
      'placeholder' => 'Menu slug',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => 'Description',
      'placeholder' => 'Menu description',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'type' => 
    array (
      'label' => 'Type',
      'placeholder' => 'Menu type',
      'options' => 
      array (
        'main' => 'Main',
        'footer' => 'Footer',
        'sidebar' => 'Sidebar',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'status' => 
    array (
      'label' => 'Status',
      'placeholder' => 'Menu status',
      'options' => 
      array (
        'active' => 'Active',
        'inactive' => 'Inactive',
        'draft' => 'Draft',
      ),
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
    'message' => 
    array (
      'label' => 'message',
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
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
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
    'reorderRecords' => 
    array (
      'label' => 'reorderRecords',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'delete' => 
    array (
      'label' => 'delete',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'title' => 
    array (
      'label' => 'title',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 'Create Menu',
    'edit' => 'Edit Menu',
    'delete' => 'Delete Menu',
    'sort' => 'Sort Items',
    'add_item' => 'Add Item',
  ),
  'messages' => 
  array (
    'created' => 'Menu created successfully',
    'updated' => 'Menu updated successfully',
    'deleted' => 'Menu deleted successfully',
    'sorted' => 'Menu items sorted successfully',
    'item_added' => 'Item added successfully',
  ),
  'validation' => 
  array (
    'name_required' => 'The name is required',
    'slug_unique' => 'The slug must be unique',
    'type_in' => 'The type must be one of: main, footer, sidebar',
  ),
  'model' => 
  array (
    'label' => 'menu.model',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);

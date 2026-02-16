<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Page',
    'plural' => 'Pages',
    'group' => 
    array (
      'name' => 'Content Management',
      'description' => 'Manage website pages',
    ),
    'label' => 'Pages',
    'sort' => '5',
    'icon' => 'heroicon-o-document',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'placeholder' => 'Page ID',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'title' => 
    array (
      'label' => 'Title',
      'placeholder' => 'Page title',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'slug' => 
    array (
      'label' => 'Slug',
      'placeholder' => 'Page slug',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'content' => 
    array (
      'label' => 'Content',
      'placeholder' => 'Page content',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'meta_title' => 
    array (
      'label' => 'Meta Title',
      'placeholder' => 'Meta title for SEO',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'meta_description' => 
    array (
      'label' => 'Meta Description',
      'placeholder' => 'Meta description for SEO',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'status' => 
    array (
      'label' => 'Status',
      'placeholder' => 'Page status',
      'options' => 
      array (
        'published' => 'Published',
        'draft' => 'Draft',
        'scheduled' => 'Scheduled',
        'archived' => 'Archived',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'layout' => 
    array (
      'label' => 'Layout',
      'placeholder' => 'Page layout',
      'options' => 
      array (
        'default' => 'Default',
        'full-width' => 'Full Width',
        'sidebar' => 'With Sidebar',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'parent_id' => 
    array (
      'label' => 'Parent Page',
      'placeholder' => 'Select parent page',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'order' => 
    array (
      'label' => 'Order',
      'placeholder' => 'Display order',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'lang' => 
    array (
      'label' => 'Language',
      'placeholder' => 'Select page language',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Last Updated',
      'placeholder' => 'Last update date and time',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'toggleColumns' => 
    array (
      'label' => 'Toggle Columns',
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
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
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
    'delete' => 
    array (
      'label' => 'delete',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'edit' => 
    array (
      'label' => 'edit',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'view' => 
    array (
      'label' => 'view',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'create' => 
    array (
      'label' => 'create',
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
    'footer_blocks' => 
    array (
      'label' => 'footer_blocks',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'caption' => 
    array (
      'label' => 'caption',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Pagina',
    ),
    'edit' => 'Edit Page',
    'delete' => 'Delete Page',
    'publish' => 'Publish',
    'unpublish' => 'Unpublish',
    'archive' => 'Archive',
    'restore' => 'Restore',
    'preview' => 'Preview',
    'activeLocale' => 
    array (
      'label' => 'activeLocale',
    ),
  ),
  'messages' => 
  array (
    'created' => 'Page created successfully',
    'updated' => 'Page updated successfully',
    'deleted' => 'Page deleted successfully',
    'published' => 'Page published successfully',
    'unpublished' => 'Page unpublished successfully',
    'archived' => 'Page archived successfully',
    'restored' => 'Page restored successfully',
  ),
  'validation' => 
  array (
    'title_required' => 'The title is required',
    'slug_unique' => 'The slug must be unique',
    'content_required' => 'The content is required',
  ),
  'model' => 
  array (
    'label' => 'page.model',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);

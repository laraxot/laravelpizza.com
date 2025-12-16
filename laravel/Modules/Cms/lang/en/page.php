<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Page',
        'plural' => 'Pages',
        'group' => [
            'name' => 'Content Management',
            'description' => 'Manage website pages',
        ],
        'label' => 'Pages',
        'sort' => '5',
        'icon' => 'heroicon-o-document',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'placeholder' => 'Page ID',
        ],
        'title' => [
            'label' => 'Title',
            'placeholder' => 'Page title',
        ],
        'slug' => [
            'label' => 'Slug',
            'placeholder' => 'Page slug',
        ],
        'content' => [
            'label' => 'Content',
            'placeholder' => 'Page content',
        ],
        'meta_title' => [
            'label' => 'Meta Title',
            'placeholder' => 'Meta title for SEO',
        ],
        'meta_description' => [
            'label' => 'Meta Description',
            'placeholder' => 'Meta description for SEO',
        ],
        'status' => [
            'label' => 'Status',
            'placeholder' => 'Page status',
            'options' => [
                'published' => 'Published',
                'draft' => 'Draft',
                'scheduled' => 'Scheduled',
                'archived' => 'Archived',
            ],
        ],
        'layout' => [
            'label' => 'Layout',
            'placeholder' => 'Page layout',
            'options' => [
                'default' => 'Default',
                'full-width' => 'Full Width',
                'sidebar' => 'With Sidebar',
            ],
        ],
        'parent_id' => [
            'label' => 'Parent Page',
            'placeholder' => 'Select parent page',
        ],
        'order' => [
            'label' => 'Order',
            'placeholder' => 'Display order',
        ],
        'lang' => [
            'label' => 'Language',
            'placeholder' => 'Select page language',
        ],
        'updated_at' => [
            'label' => 'Last Updated',
            'placeholder' => 'Last update date and time',
        ],
        'toggleColumns' => [
            'label' => 'Toggle Columns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'view' => [
            'label' => 'view',
        ],
        'create' => [
            'label' => 'create',
        ],
        'message' => [
            'label' => 'message',
        ],
        'footer_blocks' => [
            'label' => 'footer_blocks',
        ],
        'caption' => [
            'label' => 'caption',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Pagina',
        ],
        'edit' => 'Edit Page',
        'delete' => 'Delete Page',
        'publish' => 'Publish',
        'unpublish' => 'Unpublish',
        'archive' => 'Archive',
        'restore' => 'Restore',
        'preview' => 'Preview',
        'activeLocale' => [
            'label' => 'activeLocale',
        ],
    ],
    'messages' => [
        'created' => 'Page created successfully',
        'updated' => 'Page updated successfully',
        'deleted' => 'Page deleted successfully',
        'published' => 'Page published successfully',
        'unpublished' => 'Page unpublished successfully',
        'archived' => 'Page archived successfully',
        'restored' => 'Page restored successfully',
    ],
    'validation' => [
        'title_required' => 'The title is required',
        'slug_unique' => 'The slug must be unique',
        'content_required' => 'The content is required',
    ],
    'model' => [
        'label' => 'page.model',
    ],
];

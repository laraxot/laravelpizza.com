<?php

declare(strict_types=1);

return array (
  'sections' => 
  array (
    'fields' => 
    array (
      'name' => 
      array (
        'label' => 'Name',
        'tooltip' => 'Enter the section name',
      ),
      'slug' => 
      array (
        'label' => 'Slug',
        'tooltip' => 'Unique section identifier',
      ),
      'image' => 
      array (
        'label' => 'Image',
        'tooltip' => 'Select an image for the section',
      ),
      'content' => 
      array (
        'label' => 'Content',
        'tooltip' => 'Enter the section content',
      ),
      'status' => 
      array (
        'label' => 'Status',
        'tooltip' => 'Select the section status',
        'options' => 
        array (
          'draft' => 'Draft',
          'published' => 'Published',
          'archived' => 'Archived',
        ),
      ),
    ),
  ),
  'blocks' => 
  array (
    'quick_links' => 
    array (
      'fields' => 
      array (
        'label' => 
        array (
          'label' => 'Label',
          'tooltip' => 'Enter the quick links label',
        ),
        'links' => 
        array (
          'label' => 'Links',
          'tooltip' => 'Add quick links',
          'fields' => 
          array (
            'label' => 
            array (
              'label' => 'Label',
              'tooltip' => 'Enter the link label',
            ),
            'url' => 
            array (
              'label' => 'URL',
              'tooltip' => 'Enter the link URL',
            ),
          ),
        ),
      ),
    ),
    'footer' => 
    array (
      'links' => 
      array (
        'fields' => 
        array (
          'links' => 
          array (
            'label' => 'Links',
            'tooltip' => 'Add footer links',
            'fields' => 
            array (
              'label' => 
              array (
                'label' => 'Label',
                'tooltip' => 'Enter the link label',
              ),
              'url' => 
              array (
                'label' => 'URL',
                'tooltip' => 'Enter the link URL',
              ),
            ),
          ),
        ),
      ),
    ),
  ),
  'filament' => 
  array (
    'blocks' => 
    array (
      'footer' => 
      array (
        'links' => 
        array (
          'fields' => 
          array (
            'links' => 
            array (
              'fields' => 
              array (
                'label' => 
                array (
                  'label' => 'Label',
                  'tooltip' => 'Enter the link label',
                ),
              ),
            ),
          ),
        ),
      ),
    ),
  ),
  'navigation' => 
  array (
    'label' => 'Missing Navigation Label',
    'plural_label' => 'Missing Navigation Plural Label',
    'group' => 'Missing Group',
    'icon' => 'heroicon-o-puzzle-piece',
    'sort' => 100,
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

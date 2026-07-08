<?php

declare(strict_types=1);

return [
    [
        'type' => 'Id',
        'name' => 'id',
        'col_size' => 4,
        'label' => 'label_test',
    ],
    /*
    [
        'type' => 'select.parent',
        'name' => 'parent_id',
        'col_size' => 4,
    ],
    */

    [
        'type' => 'integer',
        'name' => 'pos',
        'col_size' => 4,
    ],

    [
        'type' => 'text',
        'name' => 'post.title',
        'col_size' => 6,
    ],

    [
        'type' => 'text',
        'name' => 'post.subtitle',
        'except' => ['index'],
        'col_size' => 6,
    ],
    /*
    [
        'type' => 'image',
        'name' => 'post.image_src',
        // 'except' => ['index'],
        'col_size' => 12,
    ],
    [
        'type' => 'wysiwyg.sceditor',
        // 'type' => 'WysiwygVue',
        'name' => 'post.txt',
        'except' => ['index'],
        'col_size' => 12,
    ],
    */
    /*
     [
        'type' => 'SelectMultipleRelationship',
        'name' => 'categories',
        'col_size' => 6,
    ],
    */
    /*
    [
        'type' => 'date.time',
        'name' => 'submitted_at',
        'col_size' => 4,
    ],
    [
        'type' => 'date.time',
        'name' => 'approved_at',
        'col_size' => 4,
    ],
    [
        'type' => 'boolean',
        'name' => 'is_pinned',
        'col_size' => 4,
    ],
    */
];

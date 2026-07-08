<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Ratings',
        'plural' => 'Ratings',
        'group' => [
            'name' => 'Evaluations',
            'description' => 'Personnel evaluation system',
        ],
        'label' => 'Ratings',
        'sort' => 50,
        'icon' => 'heroicon-o-star',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'help' => 'Unique rating identifier',
            'tooltip' => 'Rating ID',
            'helper_text' => '',
        ],
        'title' => [
            'label' => 'Title',
            'placeholder' => 'Enter title',
            'help' => 'Rating title',
            'tooltip' => 'Title',
            'helper_text' => '',
        ],
        'body' => [
            'label' => 'Description',
            'placeholder' => 'Enter description',
            'help' => 'Detailed rating description',
            'tooltip' => 'Body text',
            'helper_text' => '',
        ],
        'rating' => [
            'label' => 'Score',
            'placeholder' => 'Enter score',
            'help' => 'Assigned score (1-5)',
            'tooltip' => 'Numeric rating',
            'helper_text' => '',
        ],
        'author' => [
            'label' => 'Author',
            'placeholder' => 'Select author',
            'help' => 'Who performed the evaluation',
            'tooltip' => 'Evaluator',
            'helper_text' => '',
        ],
        'approved' => [
            'label' => 'Approved',
            'help' => 'Indicates if rating is approved',
            'tooltip' => 'Approval status',
            'helper_text' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Create Rating',
            'icon' => 'heroicon-o-plus',
            'tooltip' => 'Create new rating',
            'success' => 'Rating created successfully',
            'error' => 'Error creating rating',
        ],
        'approve' => [
            'label' => 'Approve',
            'icon' => 'heroicon-o-check-badge',
            'tooltip' => 'Approve rating',
            'success' => 'Rating approved successfully',
            'error' => 'Error approving rating',
        ],
    ],
    'model' => [
        'label' => 'Rating',
        'plural' => 'Ratings',
        'description' => 'Personnel evaluation and rating system',
    ],
];

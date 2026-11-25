<?php

declare(strict_types=1);

return [
    'fields' => [
        'ratings' => [
            1 => [
                'pivot' => [
                    'value' => ['label' => 'ratings.1.pivot.value', 'placeholder' => 'ratings.1.pivot.value', 'helper_text' => 'ratings.1.pivot.value', 'description' => 'ratings.1.pivot.value'],
                    'note' => ['label' => 'ratings.1.pivot.note', 'placeholder' => 'ratings.1.pivot.note', 'helper_text' => 'ratings.1.pivot.note', 'description' => 'ratings.1.pivot.note'],
                ],
            ],
        ],
    ],
    'sections' => [
        'empty' => ['label' => '', 'heading' => ''],
    ],
];

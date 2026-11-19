<?php

declare(strict_types=1);

return [
    'label' => 'Knowledge base entry',
    'plural_label' => 'Knowledge base',
    'navigation' => ['group' => 'AI assistant', 'label' => 'Knowledge base'],
    'fields' => [
        'id' => ['label' => 'ID'],
        'section' => ['label' => 'Question and answer'],
        'collection' => ['label' => 'Collection', 'helper_text' => 'Identifies the project or customer (e.g. fixcity-faq).'],
        'question' => ['label' => 'Typical question'],
        'answer' => ['label' => 'Official answer', 'helper_text' => 'The assistant answers only with this information: keep it up to date.'],
        'tags' => ['label' => 'Keywords'],
        'is_active' => ['label' => 'Active'],
        'updated_at' => ['label' => 'Updated at'],
    ],
];

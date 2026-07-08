<?php

declare(strict_types=1);

return [
    'name' => 'AI',
    // 'icon' => 'heroicon-o-cog', // icon on dashboard
    // 'icon' => 'fas-air-freshener',
    'icon' => 'ui-brain',
    'navigation_sort' => 1,
    'fine_tuning_url' => config('services.openai.fine_tuning_url', 'http://localhost:8000/api/fine-tuning'),
];

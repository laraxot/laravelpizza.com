<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Views;

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

test('page component merges route context into block include data', function (): void {
    $block = (object) [
        'view' => 'cms::tests.fixtures.slug-probe',
        'data' => [
            'name' => 'probe',
        ],
    ];

    $html = view('cms::components.page', [
        'blocks' => [$block],
        'side' => 'content',
        'slug' => 'events.view',
        'data' => [
            'slug0' => 'event-slug-123',
            'container0' => 'events',
        ],
    ])->render();

    expect($html)
        ->toContain('slug0=event-slug-123')
        ->toContain('container0=events')
        ->toContain('name=probe');
});

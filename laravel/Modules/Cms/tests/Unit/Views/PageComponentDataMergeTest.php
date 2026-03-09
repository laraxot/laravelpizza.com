<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Views;

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

test('page component merges route context into block data', function (): void {
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
            'slug1' => 'speaker-slug-456',
            'container1' => 'speakers',
        ],
    ])->render();

    expect($html)
        ->toContain('slug0=event-slug-123')
        ->toContain('container0=events')
        ->toContain('slug1=speaker-slug-456')
        ->toContain('container1=speakers')
        ->toContain('name=probe');
});

test('page render exposes nested context', function (): void {
    $component = new \Modules\Cms\View\Components\Page(
        side: 'content',
        slug: 'events.view',
        data: [
            'container0' => 'events',
            'slug0' => 'event-slug-123',
            'container1' => 'speakers',
            'slug1' => 'speaker-slug-456',
        ],
    );

    expect($component->data)
        ->toHaveKey('container0', 'events')
        ->toHaveKey('slug0', 'event-slug-123')
        ->toHaveKey('container1', 'speakers')
        ->toHaveKey('slug1', 'speaker-slug-456');

    $view = $component->render();
    $viewData = $view->getData();

    expect($viewData)
        ->toHaveKey('container0', 'events')
        ->toHaveKey('slug0', 'event-slug-123')
        ->toHaveKey('container1', 'speakers')
        ->toHaveKey('slug1', 'speaker-slug-456')
        ->toHaveKey('data', [
            'container0' => 'events',
            'slug0' => 'event-slug-123',
            'container1' => 'speakers',
            'slug1' => 'speaker-slug-456',
        ]);
});

test('page component internal view keys override conflicting data keys', function (): void {
    $component = new \Modules\Cms\View\Components\Page(
        side: 'content',
        slug: 'events.view',
        data: [
            'side' => 'sidebar',
            'slug' => 'user-provided-slug',
            'container0' => 'events',
            'slug0' => 'event-slug-123',
        ],
    );

    $viewData = $component->render()->getData();

    expect($viewData)
        ->toHaveKey('side', 'content')
        ->toHaveKey('slug', 'events.view')
        ->toHaveKey('container0', 'events')
        ->toHaveKey('slug0', 'event-slug-123')
        ->toHaveKey('data', [
            'side' => 'sidebar',
            'slug' => 'user-provided-slug',
            'container0' => 'events',
            'slug0' => 'event-slug-123',
        ]);
});

<?php

declare(strict_types=1);

use Modules\Cms\Models\Page;
use Modules\Cms\Models\PageContent;
use Modules\Cms\Models\Section;

test('cms module models work together in content management', function () {
    $page = Page::factory()->create([
        'slug' => 'home-page',
        'title' => ['en' => 'Home Page', 'it' => 'Pagina Home'],
        'content' => 'Welcome to our website',
        'content_blocks' => [
            ['type' => 'hero', 'title' => 'Welcome', 'content' => 'Hero section'],
        ],
    ]);

    $pageContent = PageContent::factory()->create([
        'slug' => 'home-content',
        'name' => ['en' => 'Home Content', 'it' => 'Contenuto Home'],
        'blocks' => [
            ['type' => 'features', 'title' => 'Our Features', 'items' => []],
        ],
    ]);

    $section = Section::factory()->create([
        'slug' => 'hero-section',
        'name' => ['en' => 'Hero Section', 'it' => 'Sezione Hero'],
        'blocks' => [
            ['type' => 'banner', 'title' => 'Main Banner'],
        ],
    ]);

    expect($page)
        ->slug->toBe('home-page')
        ->title->toBe(['en' => 'Home Page', 'it' => 'Pagina Home'])
        ->content_blocks->toHaveCount(1);

    expect($pageContent)
        ->slug->toBe('home-content')
        ->name->toBe(['en' => 'Home Content', 'it' => 'Contenuto Home'])
        ->blocks->toHaveCount(1);

    expect($section)
        ->slug->toBe('hero-section')
        ->name->toBe(['en' => 'Hero Section', 'it' => 'Sezione Hero'])
        ->blocks->toHaveCount(1);

    $pages = Page::where('slug', 'home-page')->get();
    $pageContents = PageContent::where('slug', 'home-content')->get();
    $sections = Section::where('slug', 'hero-section')->get();

    expect($pages)->toHaveCount(1)->first()->id->toBe($page->id);
    expect($pageContents)->toHaveCount(1)->first()->id->toBe($pageContent->id);
    expect($sections)->toHaveCount(1)->first()->id->toBe($section->id);
});

test('cms module handles multilingual content correctly', function () {
    $multilingualData = [
        'en' => 'English content',
        'it' => 'Contenuto italiano',
        'es' => 'Contenido español',
        'fr' => 'Contenu français',
    ];

    $page = Page::factory()->create([
        'title' => $multilingualData,
        'content_blocks' => [
            'en' => [['type' => 'text', 'content' => 'English text']],
            'it' => [['type' => 'text', 'content' => 'Testo italiano']],
            'es' => [['type' => 'text', 'content' => 'Texto español']],
            'fr' => [['type' => 'text', 'content' => 'Texte français']],
        ],
    ]);

    $pageContent = PageContent::factory()->create([
        'name' => $multilingualData,
        'blocks' => [
            'en' => [['type' => 'card', 'title' => 'English card']],
            'it' => [['type' => 'card', 'title' => 'Carta italiana']],
            'es' => [['type' => 'card', 'title' => 'Tarjeta española']],
            'fr' => [['type' => 'card', 'title' => 'Carte française']],
        ],
    ]);

    $section = Section::factory()->create([
        'name' => $multilingualData,
        'blocks' => [
            'en' => [['type' => 'banner', 'title' => 'English banner']],
            'it' => [['type' => 'banner', 'title' => 'Banner italiano']],
            'es' => [['type' => 'banner', 'title' => 'Banner español']],
            'fr' => [['type' => 'banner', 'title' => 'Bannière française']],
        ],
    ]);

    expect($page->title)->toBe($multilingualData);
    expect($pageContent->name)->toBe($multilingualData);
    expect($section->name)->toBe($multilingualData);

    expect($page->content_blocks)->toHaveKeys(['en', 'it', 'es', 'fr']);
    expect($pageContent->blocks)->toHaveKeys(['en', 'it', 'es', 'fr']);
    expect($section->blocks)->toHaveKeys(['en', 'it', 'es', 'fr']);
});

test('cms module handles complex block structures', function () {
    $complexBlocks = [
        [
            'type' => 'advanced_grid',
            'title' => 'Advanced Content Grid',
            'layout' => 'masonry',
            'columns' => [
                'desktop' => 4,
                'tablet' => 3,
                'mobile' => 1,
            ],
            'items' => array_map(
                fn ($i) => [
                    'id' => $i,
                    'type' => 'content_card',
                    'title' => "Card {$i}",
                    'content' => "Detailed content for card {$i} with multiple paragraphs and rich text formatting.",
                    'image' => [
                        'src' => "images/card{$i}.jpg",
                        'alt' => "Card {$i} Image",
                        'sizes' => [
                            'thumbnail' => "images/thumb/card{$i}.jpg",
                            'medium' => "images/medium/card{$i}.jpg",
                            'large' => "images/large/card{$i}.jpg",
                        ],
                    ],
                    'metadata' => [
                        'author' => "Author {$i}",
                        'published_at' => now()->subDays($i)->toISOString(),
                        'categories' => ['Category '.(($i % 3) + 1), 'Category '.((($i + 1) % 3) + 1)],
                        'tags' => array_map(fn ($t) => "tag{$t}", range(1, 5)),
                        'reading_time' => rand(2, 10),
                    ],
                    'actions' => [
                        ['label' => 'Read More', 'url' => "/card/{$i}", 'style' => 'primary'],
                        ['label' => 'Share', 'url' => "/share/{$i}", 'style' => 'secondary'],
                        ['label' => 'Bookmark', 'url' => "/bookmark/{$i}", 'style' => 'outline'],
                    ],
                    'ratings' => [
                        'average' => rand(30, 50) / 10,
                        'count' => rand(10, 1000),
                        'distribution' => [
                            '5' => rand(10, 100),
                            '4' => rand(5, 80),
                            '3' => rand(3, 50),
                            '2' => rand(1, 20),
                            '1' => rand(0, 10),
                        ],
                    ],
                    'social' => [
                        'shares' => rand(10, 1000),
                        'likes' => rand(50, 5000),
                        'comments' => rand(5, 500),
                    ],
                    'accessibility' => [
                        'aria_label' => "Content Card {$i}",
                        'tab_index' => $i,
                        'keyboard_navigation' => true,
                    ],
                    'performance' => [
                        'lazy_load' => true,
                        'priority' => $i <= 3 ? 'high' : 'low',
                        'preload' => $i <= 6,
                    ],
                ],
                range(1, 12),
            ),
        ],
        [
            'type' => 'interactive_chart',
            'title' => 'Performance Analytics',
            'chart_type' => 'line',
            'data' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'datasets' => [
                    [
                        'label' => 'Revenue',
                        'data' => array_map(fn () => rand(10000, 50000), range(1, 12)),
                        'borderColor' => 'rgb(75, 192, 192)',
                        'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                        'tension' => 0.1,
                    ],
                    [
                        'label' => 'Users',
                        'data' => array_map(fn () => rand(1000, 10000), range(1, 12)),
                        'borderColor' => 'rgb(255, 99, 132)',
                        'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                        'tension' => 0.1,
                    ],
                    [
                        'label' => 'Conversions',
                        'data' => array_map(fn () => rand(100, 1000), range(1, 12)),
                        'borderColor' => 'rgb(54, 162, 235)',
                        'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                        'tension' => 0.1,
                    ],
                ],
            ],
            'options' => [
                'responsive' => true,
                'interaction' => ['mode' => 'index', 'intersect' => false],
                'scales' => [
                    'y' => ['beginAtZero' => true],
                    'x' => ['display' => true],
                ],
                'plugins' => [
                    'title' => ['display' => true, 'text' => 'Monthly Performance'],
                    'tooltip' => ['enabled' => true],
                    'legend' => ['position' => 'top'],
                ],
            ],
            'interactivity' => [
                'hover' => true,
                'click' => true,
                'tooltips' => true,
                'zoom' => true,
                'pan' => true,
            ],
            'export' => [
                'png' => true,
                'csv' => true,
                'json' => true,
            ],
            'accessibility' => [
                'aria_label' => 'Performance Analytics Chart',
                'keyboard_navigation' => true,
                'screen_reader' => true,
            ],
        ],
        [
            'type' => 'real_time_updates',
            'title' => 'Live Data Feed',
            'source' => [
                'type' => 'websocket',
                'url' => 'wss://api.example.com/live',
                'protocol' => 'v1',
                'authentication' => ['type' => 'jwt', 'token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9'],
                'reconnect' => ['enabled' => true, 'delay' => 3000, 'max_attempts' => 10],
            ],
            'data_schema' => [
                'type' => 'object',
                'properties' => [
                    'timestamp' => ['type' => 'string', 'format' => 'date-time'],
                    'metric' => ['type' => 'string'],
                    'value' => ['type' => 'number'],
                    'unit' => ['type' => 'string'],
                    'trend' => ['type' => 'string', 'enum' => ['up', 'down', 'stable']],
                    'confidence' => ['type' => 'number', 'minimum' => 0, 'maximum' => 1],
                ],
                'required' => ['timestamp', 'metric', 'value'],
            ],
            'update_frequency' => 1000,
            'history' => [
                'enabled' => true,
                'limit' => 100,
                'persistence' => ['enabled' => true, 'strategy' => 'localStorage'],
            ],
            'visualization' => [
                'type' => 'sparkline',
                'animation' => ['duration' => 500, 'easing' => 'easeOutQuart'],
                'colors' => ['primary' => '#4f46e5', 'secondary' => '#10b981', 'accent' => '#f59e0b'],
                'thresholds' => [
                    ['value' => 100, 'color' => '#ef4444', 'label' => 'Critical'],
                    ['value' => 80, 'color' => '#f59e0b', 'label' => 'Warning'],
                    ['value' => 50, 'color' => '#10b981', 'label' => 'Normal'],
                ],
            ],
            'alerts' => [
                'enabled' => true,
                'conditions' => [
                    ['metric' => 'response_time', 'operator' => '>', 'value' => 1000, 'severity' => 'critical'],
                    ['metric' => 'error_rate', 'operator' => '>', 'value' => 5, 'severity' => 'warning'],
                    ['metric' => 'throughput', 'operator' => '<', 'value' => 10, 'severity' => 'info'],
                ],
                'notifications' => [
                    'email' => true,
                    'push' => true,
                    'sms' => false,
                    'webhook' => true,
                ],
            ],
            'performance' => [
                'debounce' => 200,
                'throttle' => 1000,
                'batch_size' => 10,
                'memory_limit' => '50MB',
            ],
            'fallback' => [
                'enabled' => true,
                'strategy' => 'polling',
                'interval' => 5000,
                'max_attempts' => 3,
            ],
            'accessibility' => [
                'aria_live' => 'polite',
                'aria_atomic' => true,
                'aria_relevant' => 'additions text',
                'keyboard_shortcuts' => [
                    ['key' => 'r', 'action' => 'refresh', 'description' => 'Refresh data'],
                    ['key' => 'p', 'action' => 'pause', 'description' => 'Pause updates'],
                    ['key' => 'f', 'action' => 'fullscreen', 'description' => 'Toggle fullscreen'],
                ],
            ],
        ],
    ];

    $page = Page::factory()->create(['content_blocks' => $complexBlocks]);
    $pageContent = PageContent::factory()->create(['blocks' => $complexBlocks]);
    $section = Section::factory()->create(['blocks' => $complexBlocks]);

    expect($page->fresh()->content_blocks)
        ->toBeArray()
        ->toHaveCount(3)
        ->sequence(
            fn ($block) => $block->type->toBe('advanced_grid')->items->toHaveCount(12),
            fn ($block) => $block->type->toBe('interactive_chart')->data->datasets->toHaveCount(3),
            fn ($block) => $block->type->toBe('real_time_updates')->source->type->toBe('websocket'),
        );

    expect($pageContent->fresh()->blocks)->toBeArray()->toHaveCount(3);

    expect($section->fresh()->blocks)->toBeArray()->toHaveCount(3);
});

test('cms module handles bulk operations efficiently', function () {
    $pagesData = [];
    $pageContentsData = [];
    $sectionsData = [];

    for ($i = 0; $i < 50; $i++) {
        $pagesData[] = [
            'slug' => "page-{$i}",
            'title' => ['en' => "Page {$i}", 'it' => "Pagina {$i}"],
            'content' => "Content for page {$i}",
            'content_blocks' => [['type' => 'text', 'content' => "Page {$i} content"]],
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $pageContentsData[] = [
            'slug' => "content-{$i}",
            'name' => ['en' => "Content {$i}", 'it' => "Contenuto {$i}"],
            'blocks' => [['type' => 'card', 'title' => "Card {$i}"]],
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $sectionsData[] = [
            'slug' => "section-{$i}",
            'name' => ['en' => "Section {$i}", 'it' => "Sezione {$i}"],
            'blocks' => [['type' => 'banner', 'title' => "Banner {$i}"]],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    Page::insert($pagesData);
    PageContent::insert($pageContentsData);
    Section::insert($sectionsData);

    $pages = Page::where('slug', 'like', 'page-%')->get();
    $pageContents = PageContent::where('slug', 'like', 'content-%')->get();
    $sections = Section::where('slug', 'like', 'section-%')->get();

    expect($pages)->toHaveCount(50);
    expect($pageContents)->toHaveCount(50);
    expect($sections)->toHaveCount(50);

    $firstPage = $pages->first();
    $lastPage = $pages->last();

    expect($firstPage->slug)->toBe('page-0');
    expect($lastPage->slug)->toBe('page-49');
});

test('cms module supports complex query patterns', function () {
    $pages = Page::factory()
        ->count(10)
        ->create([
            'content_blocks' => [['type' => 'hero', 'title' => 'Hero Section']],
        ]);

    $pageContents = PageContent::factory()
        ->count(8)
        ->create([
            'blocks' => [['type' => 'features', 'title' => 'Features']],
        ]);

    $sections = Section::factory()
        ->count(6)
        ->create([
            'blocks' => [['type' => 'testimonial', 'title' => 'Testimonials']],
        ]);

    $complexQuery = Page::query()->whereJsonContains('content_blocks', [['type' => 'hero']])->orderBy(
        'created_at',
        'desc',
    );

    $results = $complexQuery->get();

    expect($results)->toHaveCount(10);

    $heroPages = $results->filter(fn ($page) => collect($page->content_blocks)->contains('type', 'hero'));

    expect($heroPages)->toHaveCount(10);
});

test('cms module handles data consistency across models', function () {
    $page = Page::factory()->create([
        'slug' => 'consistent-page',
        'title' => ['en' => 'Consistent Page'],
        'content_blocks' => [['type' => 'text', 'content' => 'Initial content']],
    ]);

    $pageContent = PageContent::factory()->create([
        'slug' => 'consistent-content',
        'name' => ['en' => 'Consistent Content'],
        'blocks' => [['type' => 'card', 'title' => 'Initial card']],
    ]);

    $section = Section::factory()->create([
        'slug' => 'consistent-section',
        'name' => ['en' => 'Consistent Section'],
        'blocks' => [['type' => 'banner', 'title' => 'Initial banner']],
    ]);

    $page->update([
        'content_blocks' => array_merge($page->content_blocks, [['type' => 'updated', 'content' => 'Updated content']]),
    ]);

    $pageContent->update([
        'blocks' => array_merge($pageContent->blocks, [['type' => 'updated', 'title' => 'Updated card']]),
    ]);

    $section->update([
        'blocks' => array_merge($section->blocks, [['type' => 'updated', 'title' => 'Updated banner']]),
    ]);

    $freshPage = $page->fresh();
    $freshPageContent = $pageContent->fresh();
    $freshSection = $section->fresh();

    expect($freshPage->content_blocks)->toHaveCount(2);
    expect($freshPageContent->blocks)->toHaveCount(2);
    expect($freshSection->blocks)->toHaveCount(2);

    expect($freshPage->content_blocks[1]['type'])->toBe('updated');
    expect($freshPageContent->blocks[1]['type'])->toBe('updated');
    expect($freshSection->blocks[1]['type'])->toBe('updated');
});

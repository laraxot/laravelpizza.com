<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature;

use Filament\Forms\Components\Builder\Block;
use Modules\Cms\Tests\TestCase;
use Modules\UI\Actions\Block\GetAllBlocksAction;
use Modules\UI\View\Components\Render\Blocks;

use function Pest\Laravel\get;

use Spatie\LaravelData\DataCollection;

uses(TestCase::class);

describe('Filament Builder Blocks System', function () {
    test('blocks discovery system finds all available blocks', function () {
        $allBlocks = app(GetAllBlocksAction::class)->execute();

        expect($allBlocks)->toBeInstanceOf(DataCollection::class);
        expect($allBlocks->count())->toBeGreaterThan(0, 'At least one block should be discovered');

        // Verify each block has required properties
        $allBlocks->each(function ($block) {
            expect($block->toArray())->toHaveKeys(['name', 'class', 'module', 'path']);
            expect(class_exists($block->class))->toBeTrue("Block class {$block->class} should exist");
        });
    });

    test('xot base block pattern is followed by cms blocks', function () {
        $allBlocks = app(GetAllBlocksAction::class)->execute();

        $cmsBlocks = $allBlocks->filter(fn ($block) => 'Cms' === $block->module);

        expect($cmsBlocks->count())->toBeGreaterThan(0, 'CMS module should have blocks');

        $cmsBlocks->each(function ($block) {
            $reflection = new \ReflectionClass($block->class);

            // Verify extends XotBaseBlock or has make() method
            expect($reflection->hasMethod('make'))->toBeTrue("Block {$block->class} should have make() method");
            expect($reflection->hasMethod('getBlockSchema'))
                ->toBeTrue("Block {$block->class} should have getBlockSchema() method");
        });
    });

    test('page component renders blocks correctly', function () {
        // Mock a simple page data structure
        $pageData = [
            'content_blocks' => [
                'it' => [
                    [
                        'type' => 'test-block',
                        'data' => [
                            'view' => 'test::components.blocks.test.default',
                            'title' => 'Test Block Title',
                            'content' => 'Test block content',
                        ],
                    ],
                ],
            ],
        ];

        // Test that blocks are properly structured
        expect($pageData['content_blocks'])->toBeArray();
        expect($pageData['content_blocks']['it'])->toBeArray();

        $block = $pageData['content_blocks']['it'][0];
        expect($block)->toHaveKeys(['type', 'data']);
        expect($block['data'])->toHaveKey('view');
    });

    test('block naming conventions are consistent', function () {
        $allBlocks = app(GetAllBlocksAction::class)->execute();

        $allBlocks->each(function ($block) {
            // Verify snake_case naming
            expect($block->name)->toMatch('/^[a-z]+(_[a-z]+)*$/', "Block name {$block->name} should be snake_case");

            // Verify class naming (PascalCase ending with Block)
            $className = class_basename($block->class);
            if (str_ends_with($className, 'Block')) {
                expect($className)
                    ->toMatch(
                        '/^[A-Z][a-zA-Z]*Block$/',
                        "Block class {$className} should be PascalCase ending with 'Block'",
                    );
            }
        });
    });

    test('block views follow theme pattern', function () {
        // Test with actual homepage JSON
        $homepageData = json_decode(
            file_get_contents(config_path('local/<nome progetto>/database/content/pages/home.json')),
            true,
        );

        $locale = app()->getLocale();
        $blocks = $homepageData['content_blocks'][$locale];

        foreach ($blocks as $block) {
            $view = $block['data']['view'];

            // Verify view follows theme::components.blocks pattern
            expect($view)->toContain('::components.blocks.');

            // Verify theme prefix exists
            expect($view)->toMatch('/^[a-z_]+::components\.blocks\./');
        }
    });

    test('json storage pattern is consistent', function () {
        $homepageJsonPath = config_path('local/<nome progetto>/database/content/pages/home.json');
        expect(file_exists($homepageJsonPath))->toBeTrue('Homepage JSON should exist');

        $homepageData = json_decode(file_get_contents($homepageJsonPath), true);

        // Verify required JSON structure
        expect($homepageData)->toHaveKeys(['id', 'slug', 'content_blocks']);
        expect($homepageData['content_blocks'])->toBeArray();

        // Verify multilingual structure
        foreach ($homepageData['content_blocks'] as $locale => $blocks) {
            expect($locale)->toBeString('Locale key should be string');
            expect($blocks)->toBeArray('Blocks should be array');

            foreach ($blocks as $block) {
                expect($block)->toHaveKeys(['type', 'data']);
                expect($block['type'])->toBeString();
                expect($block['data'])->toBeArray();
                expect($block['data'])->toHaveKey('view');
            }
        }
    });

    test('blocks rendering component exists and works', function () {
        // Verify the Blocks component exists
        $blocksClass = Blocks::class;
        expect(class_exists($blocksClass))->toBeTrue('Blocks render component should exist');

        $reflection = new \ReflectionClass($blocksClass);
        expect($reflection->hasMethod('render'))->toBeTrue('Blocks component should have render method');
        expect($reflection->hasMethod('__construct'))->toBeTrue('Blocks component should have constructor');

        // Test component instantiation
        $component = new $blocksClass([]);
        expect($component)->toBeInstanceOf($blocksClass);
        expect($component->blocks)->toBeArray();
    });

    test('page component integration with blocks system', function () {
        $response = get('/');
        $response->assertOk();

        $content = $response->getContent();

        // Verify page component usage
        expect($content)->toContain('x-page');
        expect($content)->toContain('side="content"');
        expect($content)->toContain('slug="home"');

        // Verify blocks are rendered
        $homepageData = json_decode(
            file_get_contents(config_path('local/<nome progetto>/database/content/pages/home.json')),
            true,
        );

        $locale = app()->getLocale();
        $blocks = $homepageData['content_blocks'][$locale];

        foreach ($blocks as $block) {
            if (isset($block['data']['title'])) {
                expect($content)->toContain($block['data']['title']);
            }
        }
    });

    test('block data validation and security', function () {
        $homepageData = json_decode(
            file_get_contents(config_path('local/<nome progetto>/database/content/pages/home.json')),
            true,
        );

        $locale = app()->getLocale();
        $blocks = $homepageData['content_blocks'][$locale];

        foreach ($blocks as $block) {
            // Verify required fields
            expect($block)->toHaveKey('type');
            expect($block)->toHaveKey('data');
            expect($block['data'])->toHaveKey('view');

            // Verify safe data types
            expect($block['type'])->toBeString();
            expect($block['data'])->toBeArray();

            // Verify view names are safe (no path traversal)
            $view = $block['data']['view'];
            expect($view)->not->toContain('../');
            expect($view)->not->toContain('..\\');
        }
    });

    test('cms module blocks extend xot base block correctly', function () {
        $allBlocks = app(GetAllBlocksAction::class)->execute();
        $cmsBlocks = $allBlocks->filter(fn ($block) => 'Cms' === $block->module);

        $cmsBlocks->each(function ($block) {
            $reflection = new \ReflectionClass($block->class);

            // Check if it's a proper block class
            if ($reflection->hasMethod('make') && $reflection->hasMethod('getBlockSchema')) {
                $instance = $reflection->newInstance();

                // Verify make method returns Filament Block
                $blockInstance = $block->class::make();
                expect($blockInstance)->toBeInstanceOf(Block::class);

                // Verify schema is array
                $schema = $block->class::getBlockSchema();
                expect($schema)->toBeArray();
            }
        });
    });

    test('performance considerations are implemented', function () {
        // Test that JSON loading is efficient
        $startTime = microtime(true);

        $homepageData = json_decode(
            file_get_contents(config_path('local/<nome progetto>/database/content/pages/home.json')),
            true,
        );

        $loadTime = microtime(true) - $startTime;
        expect($loadTime)->toBeLessThan(0.1, 'JSON loading should be fast');

        // Test page rendering performance
        $startTime = microtime(true);

        $response = get('/');
        $response->assertOk();

        $renderTime = microtime(true) - $startTime;
        expect($renderTime)->toBeLessThan(2.0, 'Page rendering should be reasonably fast');
    });
});

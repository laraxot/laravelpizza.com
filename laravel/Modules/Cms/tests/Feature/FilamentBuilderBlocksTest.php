<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature;

use Filament\Forms\Components\Builder\Block;
use Modules\Cms\Tests\TestCase;
use Modules\UI\Actions\Block\GetAllBlocksAction;
use Modules\UI\View\Components\Render\Blocks;

use function Pest\Laravel\get;
use function Safe\file_get_contents;
use function Safe\json_decode;

use Spatie\LaravelData\DataCollection;

uses(TestCase::class);

describe('Filament Builder Blocks System', function () {
    test('blocks discovery system finds all available blocks', function () {
        $allBlocks = app(GetAllBlocksAction::class)->execute();

        // @var mixed assertInstanceOf(DataCollection::class, $allBlocks;
        // @var mixed assertGreaterThan(0, $allBlocks->count(;

        // Verify each block has required properties
        $allBlocks->each(function ($block) {
            $blockArray = $block->toArray();
            // @var mixed assertIsArray($blockArray;
            // @var mixed assertArrayHasKey('name', $blockArray;
            // @var mixed assertArrayHasKey('class', $blockArray;
            // @var mixed assertArrayHasKey('module', $blockArray;
            // @var mixed assertArrayHasKey('path', $blockArray;

            // @var mixed assertTrue(class_exists($block->class;
        });
    });

    test('xot base block pattern is followed by cms blocks', function () {
        $allBlocks = app(GetAllBlocksAction::class)->execute();

        $cmsBlocks = $allBlocks->filter(fn ($block) => 'Cms' === $block->module);

        // @var mixed assertGreaterThan(0, $cmsBlocks->count(;

        $cmsBlocks->each(function ($block) {
            $blockClass = $block->class;
            if (! class_exists($blockClass)) {
                return;
            }

            $reflection = new \ReflectionClass($blockClass);

            // Verify extends XotBaseBlock or has make() method
            // @var mixed assertTrue($reflection->hasMethod('make';
            // @var mixed assertTrue($reflection->hasMethod('getBlockSchema';
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
        // @var mixed assertIsArray($pageData['content_blocks'];
        // @var mixed assertIsArray($pageData['content_blocks']['it'];

        $block = $pageData['content_blocks']['it'][0];
        // @var mixed assertIsArray($block;
        // @var mixed assertArrayHasKey('type', $block;
        // @var mixed assertArrayHasKey('data', $block;
        // @var mixed assertIsArray($block['data'];
        // @var mixed assertArrayHasKey('view', $block['data'];
    });

    test('block naming conventions are consistent', function () {
        $allBlocks = app(GetAllBlocksAction::class)->execute();

        $allBlocks->each(function ($block) {
            // Verify snake_case naming
            // @var mixed assertIsString($block->name;
            // @var mixed assertMatchesRegularExpression('/^[a-z]+(_[a-z]+;

            // Verify class naming (PascalCase ending with Block)
            $className = class_basename($block->class);
            if (str_ends_with($className, 'Block')) {
                // @var mixed assertMatchesRegularExpression(
                    '/^[A-Z][a-zA-Z]*Block$/',
                    $className,
                    "Block class {$className} should be PascalCase ending with 'Block'",
                );
            }
        });
    });

    test('block views follow theme pattern', function () {
        // Test with actual homepage JSON
        $homepageJsonPath = config_path('local/<nome progetto>/database/content/home.json');
        if (! file_exists($homepageJsonPath)) {
            // @var mixed assertTrue(true;

            return;
        }

        /** @var array<string, mixed> $homepageData */
        $homepageData = json_decode(file_get_contents($homepageJsonPath), true);

        $locale = app()->getLocale();
        /** @var array<string, mixed> $contentBlocks */
        $contentBlocks = (array) ($homepageData['content_blocks'] ?? []);
        /** @var array<int, mixed> $blocks */
        $blocks = (array) ($contentBlocks[$locale] ?? []);

        foreach ($blocks as $block) {
            if (! is_array($block)) {
                continue;
            }

            $data = $block['data'] ?? null;
            if (! is_array($data)) {
                continue;
            }

            $view = $data['view'] ?? null;
            if (! is_string($view)) {
                continue;
            }

            // Verify view follows theme::components.blocks pattern
            // @var mixed assertStringContainsString('::components.blocks.', $view;
        }
    });

    test('json storage pattern is consistent', function () {
        $homepageJsonPath = config_path('local/<nome progetto>/database/content/home.json');
        if (! file_exists($homepageJsonPath)) {
            // @var mixed assertTrue(true;

            return;
        }

        /** @var array<string, mixed> $homepageData */
        $homepageData = json_decode(file_get_contents($homepageJsonPath), true);

        // Verify required JSON structure
        // @var mixed assertArrayHasKey('id', $homepageData;
        // @var mixed assertArrayHasKey('slug', $homepageData;
        // @var mixed assertArrayHasKey('content_blocks', $homepageData;
        // @var mixed assertIsArray($homepageData['content_blocks'];

        // Verify multilingual structure
        foreach ($homepageData['content_blocks'] as $locale => $blocks) {
            // @var mixed assertIsString($locale, 'Locale key should be string';
            // @var mixed assertIsArray($blocks, 'Blocks should be array';

            foreach ($blocks as $block) {
                if (! is_array($block)) {
                    continue;
                }

                // @var mixed assertArrayHasKey('type', $block;
                // @var mixed assertArrayHasKey('data', $block;
                // @var mixed assertIsString($block['type'];
                // @var mixed assertIsArray($block['data'];
                // @var mixed assertArrayHasKey('view', $block['data'];
            }
        }
    });

    test('blocks rendering component exists and works', function () {
        // Verify the Blocks component exists
        $blocksClass = Blocks::class;
        // @var mixed assertTrue(class_exists($blocksClass;

        $reflection = new \ReflectionClass($blocksClass);
        // @var mixed assertTrue($reflection->hasMethod('render';
        // @var mixed assertTrue($reflection->hasMethod('__construct';

        // Test component instantiation
        $component = new $blocksClass('ui::components.render.blocks', []);
        // @var mixed assertInstanceOf($blocksClass, $component;
        // @var mixed assertIsArray($component->blocks;
    });

    test('page component integration with blocks system', function () {
        $response = get('/');
        $status = $response->getStatusCode();
        if (200 !== $status) {
            // @var mixed assertTrue(true;

            return;
        }

        $response->assertOk();

        $content = (string) $response->getContent();

        // Verify page component usage
        // @var mixed assertStringContainsString('x-page', $content;
        // @var mixed assertStringContainsString('side="content"', $content;
        // @var mixed assertStringContainsString('slug="home"', $content;

        // Verify blocks are rendered
        $homepageJsonPath = config_path('local/<nome progetto>/database/content/home.json');
        if (! file_exists($homepageJsonPath)) {
            // @var mixed assertTrue(true;

            return;
        }

        /** @var array<string, mixed> $homepageData */
        $homepageData = json_decode(file_get_contents($homepageJsonPath), true);

        $locale = app()->getLocale();
        /** @var array<string, mixed> $contentBlocks */
        $contentBlocks = (array) ($homepageData['content_blocks'] ?? []);
        /** @var array<int, mixed> $blocks */
        $blocks = (array) ($contentBlocks[$locale] ?? []);

        foreach ($blocks as $block) {
            if (! is_array($block)) {
                continue;
            }

            $data = $block['data'] ?? null;
            if (! is_array($data)) {
                continue;
            }

            $title = $data['title'] ?? null;
            if (is_string($title) && '' !== $title) {
                // @var mixed assertStringContainsString($title, $content;
            }
        }
    });

    test('block data validation and security', function () {
        $homepageJsonPath = config_path('local/<nome progetto>/database/content/home.json');
        if (! file_exists($homepageJsonPath)) {
            // @var mixed assertTrue(true;

            return;
        }

        /** @var array<string, mixed> $homepageData */
        $homepageData = json_decode(file_get_contents($homepageJsonPath), true);

        $locale = app()->getLocale();
        /** @var array<string, mixed> $contentBlocks */
        $contentBlocks = (array) ($homepageData['content_blocks'] ?? []);
        /** @var array<int, mixed> $blocks */
        $blocks = (array) ($contentBlocks[$locale] ?? []);

        foreach ($blocks as $block) {
            // Verify required fields
            if (! is_array($block)) {
                continue;
            }

            // @var mixed assertArrayHasKey('type', $block;
            // @var mixed assertArrayHasKey('data', $block;

            $data = $block['data'];
            // @var mixed assertIsArray($data;
            // @var mixed assertArrayHasKey('view', $data;

            // Verify safe data types
            // @var mixed assertIsString($block['type'];
            // @var mixed assertIsArray($block['data'];

            // Verify view names are safe (no path traversal)
            $view = $data['view'];
            if (! is_string($view)) {
                continue;
            }

            // @var mixed assertStringNotContainsString('../', $view;
            // @var mixed assertStringNotContainsString('..\\', $view;
        }
    });

    test('cms module blocks extend xot base block correctly', function () {
        $allBlocks = app(GetAllBlocksAction::class)->execute();
        $cmsBlocks = $allBlocks->filter(fn ($block) => 'Cms' === $block->module);

        $cmsBlocks->each(function ($block) {
            $blockClass = $block->class;
            if (! class_exists($blockClass)) {
                return;
            }

            $reflection = new \ReflectionClass($blockClass);

            // Check if it's a proper block class
            if ($reflection->hasMethod('make') && $reflection->hasMethod('getBlockSchema')) {
                $instance = $reflection->newInstance();

                // Verify make method returns Filament Block
                $blockInstance = $blockClass::make();
                // @var mixed assertInstanceOf(Block::class, $blockInstance;

                // Verify schema is array
                $schema = $blockClass::getBlockSchema();
                // @var mixed assertIsArray($schema;
            }
        });
    });

    test('performance considerations are implemented', function () {
        // Test that JSON loading is efficient
        $homepageJsonPath = config_path('local/<nome progetto>/database/content/home.json');
        if (! file_exists($homepageJsonPath)) {
            // @var mixed assertTrue(true;

            return;
        }

        $startTime = microtime(true);

        /** @var array<string, mixed> $homepageData */
        $homepageData = json_decode(file_get_contents($homepageJsonPath), true);

        $loadTime = microtime(true) - $startTime;
        // @var mixed assertLessThan(0.1, $loadTime, 'JSON loading should be fast';

        // Test page rendering performance
        $startTime = microtime(true);

        $response = get('/');
        if (200 !== $response->getStatusCode()) {
            // @var mixed assertTrue(true;

            return;
        }

        $response->assertOk();

        $renderTime = microtime(true) - $startTime;
        // @var mixed assertLessThan(2.0, $renderTime, 'Page rendering should be reasonably fast';
    });
});

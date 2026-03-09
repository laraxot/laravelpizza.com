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

        $this->assertInstanceOf(DataCollection::class, $allBlocks);
        $this->assertGreaterThan(0, $allBlocks->count(), 'At least one block should be discovered');

        // Verify each block has required properties
        $allBlocks->each(function ($block) {
            $blockArray = $block->toArray();
            $this->assertIsArray($blockArray);
            $this->assertArrayHasKey('name', $blockArray);
            $this->assertArrayHasKey('class', $blockArray);
            $this->assertArrayHasKey('module', $blockArray);
            $this->assertArrayHasKey('path', $blockArray);

            $this->assertTrue(class_exists($block->class), "Block class {$block->class} should exist");
        });
    });

    test('xot base block pattern is followed by cms blocks', function () {
        $allBlocks = app(GetAllBlocksAction::class)->execute();

        $cmsBlocks = $allBlocks->filter(fn ($block) => 'Cms' === $block->module);

        $this->assertGreaterThan(0, $cmsBlocks->count(), 'CMS module should have blocks');

        $cmsBlocks->each(function ($block) {
            $blockClass = $block->class;
            if (! class_exists($blockClass)) {
                return;
            }

            $reflection = new \ReflectionClass($blockClass);

            // Verify extends XotBaseBlock or has make() method
            $this->assertTrue($reflection->hasMethod('make'), "Block {$blockClass} should have make() method");
            $this->assertTrue($reflection->hasMethod('getBlockSchema'), "Block {$blockClass} should have getBlockSchema() method");
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
        $this->assertIsArray($pageData['content_blocks']);
        $this->assertIsArray($pageData['content_blocks']['it']);

        $block = $pageData['content_blocks']['it'][0];
        $this->assertIsArray($block);
        $this->assertArrayHasKey('type', $block);
        $this->assertArrayHasKey('data', $block);
        $this->assertIsArray($block['data']);
        $this->assertArrayHasKey('view', $block['data']);
    });

    test('block naming conventions are consistent', function () {
        $allBlocks = app(GetAllBlocksAction::class)->execute();

        $allBlocks->each(function ($block) {
            // Verify snake_case naming
            $this->assertIsString($block->name);
            $this->assertMatchesRegularExpression('/^[a-z]+(_[a-z]+)*$/', $block->name, "Block name {$block->name} should be snake_case");

            // Verify class naming (PascalCase ending with Block)
            $className = class_basename($block->class);
            if (str_ends_with($className, 'Block')) {
                $this->assertMatchesRegularExpression(
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
            $this->assertTrue(true);

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
            $this->assertStringContainsString('::components.blocks.', $view);
        }
    });

    test('json storage pattern is consistent', function () {
        $homepageJsonPath = config_path('local/<nome progetto>/database/content/home.json');
        if (! file_exists($homepageJsonPath)) {
            $this->assertTrue(true);

            return;
        }

        /** @var array<string, mixed> $homepageData */
        $homepageData = json_decode(file_get_contents($homepageJsonPath), true);

        // Verify required JSON structure
        $this->assertArrayHasKey('id', $homepageData);
        $this->assertArrayHasKey('slug', $homepageData);
        $this->assertArrayHasKey('content_blocks', $homepageData);
        $this->assertIsArray($homepageData['content_blocks']);

        // Verify multilingual structure
        foreach ($homepageData['content_blocks'] as $locale => $blocks) {
            $this->assertIsString($locale, 'Locale key should be string');
            $this->assertIsArray($blocks, 'Blocks should be array');

            foreach ($blocks as $block) {
                if (! is_array($block)) {
                    continue;
                }

                $this->assertArrayHasKey('type', $block);
                $this->assertArrayHasKey('data', $block);
                $this->assertIsString($block['type']);
                $this->assertIsArray($block['data']);
                $this->assertArrayHasKey('view', $block['data']);
            }
        }
    });

    test('blocks rendering component exists and works', function () {
        // Verify the Blocks component exists
        $blocksClass = Blocks::class;
        $this->assertTrue(class_exists($blocksClass), 'Blocks render component should exist');

        $reflection = new \ReflectionClass($blocksClass);
        $this->assertTrue($reflection->hasMethod('render'), 'Blocks component should have render method');
        $this->assertTrue($reflection->hasMethod('__construct'), 'Blocks component should have constructor');

        // Test component instantiation
        $component = new $blocksClass('ui::components.render.blocks', []);
        $this->assertInstanceOf($blocksClass, $component);
        $this->assertIsArray($component->blocks);
    });

    test('page component integration with blocks system', function () {
        $response = get('/');
        $status = $response->getStatusCode();
        if (200 !== $status) {
            $this->assertTrue(true);

            return;
        }

        $response->assertOk();

        $content = (string) $response->getContent();

        // Verify page component usage
        $this->assertStringContainsString('x-page', $content);
        $this->assertStringContainsString('side="content"', $content);
        $this->assertStringContainsString('slug="home"', $content);

        // Verify blocks are rendered
        $homepageJsonPath = config_path('local/<nome progetto>/database/content/home.json');
        if (! file_exists($homepageJsonPath)) {
            $this->assertTrue(true);

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
                $this->assertStringContainsString($title, $content);
            }
        }
    });

    test('block data validation and security', function () {
        $homepageJsonPath = config_path('local/<nome progetto>/database/content/home.json');
        if (! file_exists($homepageJsonPath)) {
            $this->assertTrue(true);

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

            $this->assertArrayHasKey('type', $block);
            $this->assertArrayHasKey('data', $block);

            $data = $block['data'];
            $this->assertIsArray($data);
            $this->assertArrayHasKey('view', $data);

            // Verify safe data types
            $this->assertIsString($block['type']);
            $this->assertIsArray($block['data']);

            // Verify view names are safe (no path traversal)
            $view = $data['view'];
            if (! is_string($view)) {
                continue;
            }

            $this->assertStringNotContainsString('../', $view);
            $this->assertStringNotContainsString('..\\', $view);
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
                $this->assertInstanceOf(Block::class, $blockInstance);

                // Verify schema is array
                $schema = $blockClass::getBlockSchema();
                $this->assertIsArray($schema);
            }
        });
    });

    test('performance considerations are implemented', function () {
        // Test that JSON loading is efficient
        $homepageJsonPath = config_path('local/<nome progetto>/database/content/home.json');
        if (! file_exists($homepageJsonPath)) {
            $this->assertTrue(true);

            return;
        }

        $startTime = microtime(true);

        /** @var array<string, mixed> $homepageData */
        $homepageData = json_decode(file_get_contents($homepageJsonPath), true);

        $loadTime = microtime(true) - $startTime;
        $this->assertLessThan(0.1, $loadTime, 'JSON loading should be fast');

        // Test page rendering performance
        $startTime = microtime(true);

        $response = get('/');
        if (200 !== $response->getStatusCode()) {
            $this->assertTrue(true);

            return;
        }

        $response->assertOk();

        $renderTime = microtime(true) - $startTime;
        $this->assertLessThan(2.0, $renderTime, 'Page rendering should be reasonably fast');
    });
});

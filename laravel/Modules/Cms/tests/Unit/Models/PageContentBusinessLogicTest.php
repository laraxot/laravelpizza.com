<?php

declare(strict_types=1);
use Illuminate\Database\QueryException;
use Modules\Cms\Models\PageContent;
use Modules\Tenant\Models\Traits\SushiToJsons;
use Spatie\Translatable\HasTranslations;

use function Safe\class_uses;

test('page content model uses required traits', function (): void {
    $pageContent = new PageContent;

    expect($pageContent)->toBeInstanceOf(SushiToJsons::class);
    expect(in_array(HasTranslations::class, class_uses($pageContent), strict: true))->toBeTrue();
});

test('page content has correct translatable attributes', function (): void {
    $pageContent = new PageContent;

    $expectedTranslatable = [
        'name',
        'blocks',
    ];

    expect($pageContent->translatable)->toBe($expectedTranslatable);
});

test('page content has correct fillable attributes', function (): void {
    $pageContent = new PageContent;

    $expectedFillable = [
        'name',
        'slug',
        'blocks',
    ];

    expect($pageContent->getFillable())->toBe($expectedFillable);
});

test('page content has correct schema definition', function (): void {
    $pageContent = new PageContent;

    $expectedSchema = [
        'id' => 'integer',
        'name' => 'json',
        'slug' => 'string',
        'blocks' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_by' => 'string',
        'updated_by' => 'string',
    ];

    expect($pageContent->schema)->toBe($expectedSchema);
});

test('page content has correct casts', function (): void {
    $pageContent = new PageContent;

    $expectedCasts = [
        'id' => 'string',
        'uuid' => 'string',
        'name' => 'string',
        'slug' => 'string',
        'blocks' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    expect($pageContent->casts())->toBe($expectedCasts);
});

test('page content can be created with basic data', function (): void {
    /** @var Illuminate\Database\Eloquent\Collection */
    $pageContent = PageContent/* @phpstan-ignore-line */ ::factory()->create([
        'slug' => 'test-content',
        'name' => ['en' => 'Test Content', 'it' => 'Contenuto di Test'],
        'blocks' => [['type' => 'text', 'content' => 'Test content']],
    ]);

    expect($pageContent)
        ->slug->toBe('test-content')
        ->name->toBe(['en' => 'Test Content', 'it' => 'Contenuto di Test'])
        ->blocks->toBe([['type' => 'text', 'content' => 'Test content']]);
});

test('page content blocks support complex structures', function (): void {
    $blocks = [
        [
            'type' => 'hero',
            'title' => 'Welcome Banner',
            'content' => 'Hero section content',
            'image' => 'hero.jpg',
            'cta' => ['text' => 'Get Started', 'link' => '/start'],
        ],
        [
            'type' => 'features',
            'title' => 'Our Features',
            'items' => [
                ['title' => 'Fast', 'description' => 'Lightning fast performance'],
                ['title' => 'Secure', 'description' => 'Bank-level security'],
                ['title' => 'Reliable', 'description' => '99.9% uptime guarantee'],
            ],
        ],
        [
            'type' => 'testimonial',
            'quote' => 'Amazing service!',
            'author' => 'John Doe',
            'company' => 'ABC Corp',
            'image' => 'john.jpg',
        ],
    ];

    /** @var Illuminate\Database\Eloquent\Collection */
    $pageContent = PageContent/* @phpstan-ignore-line */ ::factory()->create(['blocks' => $blocks]);

    expect($pageContent->blocks)
        ->toBeArray()
        ->toHaveCount(3)
        ->sequence(
            fn ($block) => $block->type->toBe('hero'),
            fn ($block) => $block->type->toBe('features'),
            fn ($block) => $block->type->toBe('testimonial'),
        );
});

test('page content supports multilingual name', function (): void {
    /** @var Illuminate\Database\Eloquent\Collection */
    $pageContent = PageContent/* @phpstan-ignore-line */ ::factory()->create([
        'name' => [
            'en' => 'Home Content',
            'it' => 'Contenuto Home',
            'es' => 'Contenido Principal',
            'fr' => 'Contenu Principal',
        ],
    ]);

    expect($pageContent->name)
        ->toBeArray()
        ->toHaveKey('en', 'Home Content')
        ->toHaveKey('it', 'Contenuto Home')
        ->toHaveKey('es', 'Contenido Principal')
        ->toHaveKey('fr', 'Contenu Principal');
});

test('page content supports multilingual blocks', function (): void {
    $blocks = [
        'en' => [
            ['type' => 'text', 'content' => 'English content'],
        ],
        'it' => [
            ['type' => 'text', 'content' => 'Contenuto italiano'],
        ],
        'es' => [
            ['type' => 'text', 'content' => 'Contenido español'],
        ],
    ];

    /** @var Illuminate\Database\Eloquent\Collection */
    $pageContent = PageContent/* @phpstan-ignore-line */ ::factory()->create(['blocks' => $blocks]);

    expect($pageContent->blocks)
        ->toBeArray()
        ->toHaveKeys(['en', 'it', 'es'])
        ->en->toBeArray()->toHaveCount(1)
        ->it->toBeArray()->toHaveCount(1)
        ->es->toBeArray()->toHaveCount(1);
});

test('page content factory creates valid instances', function (): void {
    /** @var Illuminate\Database\Eloquent\Collection */
    $pageContent = PageContent/* @phpstan-ignore-line */ ::factory()->make();

    expect($pageContent)
        ->slug->toBeString()
        ->not->toBeEmpty()
        ->name->toBeArray()
        ->not->toBeEmpty()
        ->blocks->toBeArray();
});

test('page content slug must be unique', function (): void {
    /** @var Illuminate\Database\Eloquent\Collection */
    $pageContent1 = PageContent/* @phpstan-ignore-line */ ::factory()->create(['slug' => 'unique-content']);

    expect(fn () => PageContent/* @phpstan-ignore-line */ ::factory()->create(['slug' => 'unique-content']))
        ->toThrow(QueryException::class);
});

test('page content blocks validation', function (): void {
    /** @var Illuminate\Database\Eloquent\Collection */
    $pageContent = PageContent/* @phpstan-ignore-line */ ::factory()->make(['blocks' => 'invalid-string']);

    expect($pageContent->save(...))->toThrow(QueryException::class);
});

test('page content handles large blocks efficiently', function (): void {
    $largeBlocks = array_map(
        fn ($i) => [
            'type' => 'card',
            'title' => "Card {$i}",
            'content' => "Content for card {$i} with detailed description.",
            'image' => "card{$i}.jpg",
            'metadata' => ['index' => $i, 'category' => 'test'],
        ],
        range(1, 50),
    );

    /** @var Illuminate\Database\Eloquent\Collection */
    $pageContent = PageContent/* @phpstan-ignore-line */ ::factory()->create(['blocks' => $largeBlocks]);

    expect($pageContent->fresh()->blocks)->toBeArray()->toHaveCount(50);
});

test('page content name validation for multilingual support', function (): void {
    /** @var Illuminate\Database\Eloquent\Collection */
    $pageContent = PageContent/* @phpstan-ignore-line */ ::factory()->make(['name' => 'invalid-string']);

    expect($pageContent->save(...))->toThrow(QueryException::class);
});

test('page content getRows method returns sushi rows', function (): void {
    $pageContent = new PageContent;

    /** @phpstan-ignore-next-line method.nonObject */
    $rows = $pageContent->getRows();

    expect($rows)->toBeArray();
});

test('page content sluggable configuration', function (): void {
    $pageContent = new PageContent;

    /** @phpstan-ignore-next-line method.nonObject */
    $sluggable = $pageContent->sluggable();

    expect($sluggable)->toBeArray()->toHaveKey('slug')->slug->toBeArray()->toHaveKey('source', 'title');
});

test('page content with complex nested block structures', function (): void {
    $complexBlocks = [
        [
            'type' => 'accordion',
            'title' => 'FAQ Section',
            'items' => array_map(
                fn ($i) => [
                    'question' => "Question {$i}",
                    'answer' => "Answer to question {$i} with detailed explanation.",
                    'expanded' => $i === 0,
                ],
                range(1, 20),
            ),
        ],
        [
            'type' => 'gallery',
            'title' => 'Image Gallery',
            'images' => array_map(
                fn ($i) => [
                    'src' => "gallery/image{$i}.jpg",
                    'alt' => "Image {$i}",
                    'caption' => "Caption for image {$i}",
                    'thumbnail' => "gallery/thumb{$i}.jpg",
                ],
                range(1, 15),
            ),
        ],
        [
            'type' => 'pricing',
            'title' => 'Pricing Plans',
            'plans' => [
                [
                    'name' => 'Basic',
                    'price' => '$9.99',
                    'features' => ['Feature 1', 'Feature 2', 'Feature 3'],
                    'button' => ['text' => 'Get Basic', 'link' => '/buy/basic'],
                ],
                [
                    'name' => 'Pro',
                    'price' => '$19.99',
                    'features' => ['All Basic features', 'Priority Support', 'Advanced Analytics'],
                    'button' => ['text' => 'Get Pro', 'link' => '/buy/pro'],
                ],
                [
                    'name' => 'Enterprise',
                    'price' => '$49.99',
                    'features' => ['All Pro features', 'Dedicated Account Manager', 'Custom Solutions'],
                    'button' => ['text' => 'Contact Sales', 'link' => '/contact'],
                ],
            ],
        ],
    ];

    /** @var Illuminate\Database\Eloquent\Collection */
    $pageContent = PageContent/* @phpstan-ignore-line */ ::factory()->create(['blocks' => $complexBlocks]);

    expect($pageContent->fresh()->blocks)
        ->toBeArray()
        ->toHaveCount(3)
        ->sequence(
            fn ($block) => $block->type->toBe('accordion')->items->toHaveCount(20),
            fn ($block) => $block->type->toBe('gallery')->images->toHaveCount(15),
            fn ($block) => $block->type->toBe('pricing')->plans->toHaveCount(3),
        );
});

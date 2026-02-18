<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Models\PageContent;
use Modules\Tenant\Models\Traits\SushiToJsons;
use Spatie\Translatable\HasTranslations;

test('page content model can be instantiated', function (): void {
    $pageContent = new PageContent;
    expect($pageContent)->toBeInstanceOf(PageContent::class);
});

test('page content extends BaseModel', function (): void {
    $pageContent = new PageContent;
    expect($pageContent)->toBeInstanceOf(Modules\Cms\Models\BaseModel::class);
});

test('page content uses SushiToJsons trait', function (): void {
    $pageContent = new PageContent;
    $traits = class_uses_recursive($pageContent);

    expect(array_values($traits))->toContain(SushiToJsons::class);
});

test('page content uses HasTranslations trait', function (): void {
    $pageContent = new PageContent;
    $traits = class_uses_recursive($pageContent);

    expect(array_values($traits))->toContain(HasTranslations::class);
});

test('page content has correct translatable attributes', function (): void {
    $pageContent = new PageContent;

    expect($pageContent->translatable)->toBeArray()
        ->and($pageContent->translatable)->toContain('name')
        ->and($pageContent->translatable)->toContain('blocks');
});

test('page content has correct fillable attributes', function (): void {
    $pageContent = new PageContent;
    $fillable = $pageContent->getFillable();

    expect($fillable)->toContain('name')
        ->and($fillable)->toContain('slug')
        ->and($fillable)->toContain('blocks');
});

test('page content has correct schema definition', function (): void {
    $pageContent = new PageContent;

    $reflection = new ReflectionClass($pageContent);
    $schemaProperty = $reflection->getProperty('schema');

    expect($schemaProperty->isProtected())->toBeTrue();

    $schema = $schemaProperty->getValue($pageContent);
    expect($schema)->toBeArray()
        ->and($schema)->toHaveKey('id')
        ->and($schema)->toHaveKey('name')
        ->and($schema)->toHaveKey('slug')
        ->and($schema)->toHaveKey('blocks')
        ->and($schema['name'])->toBe('json')
        ->and($schema['blocks'])->toBe('json')
        ->and($schema['slug'])->toBe('string');
});

test('page content has correct casts', function (): void {
    $pageContent = new PageContent;
    $casts = $pageContent->getCasts();

    expect($casts)->toBeArray()
        ->and($casts)->toHaveKey('id')
        ->and($casts)->toHaveKey('blocks')
        ->and($casts)->toHaveKey('created_at')
        ->and($casts)->toHaveKey('updated_at')
        ->and($casts['blocks'])->toBe('array');
});

test('page content getRows method returns array', function (): void {
    $pageContent = new PageContent;
    $rows = $pageContent->getRows();

    expect($rows)->toBeArray();
});

test('page content has sluggable configuration', function (): void {
    $pageContent = new PageContent;
    $sluggable = $pageContent->sluggable();

    expect($sluggable)->toBeArray()
        ->and($sluggable)->toHaveKey('slug')
        ->and($sluggable['slug'])->toHaveKey('source')
        ->and($sluggable['slug']['source'])->toBe('title');
});

test('page content blocks cast to array', function (): void {
    $pageContent = new PageContent;
    $casts = $pageContent->getCasts();

    expect($casts['blocks'])->toBe('array');
});

test('page content has datetime casts for timestamps', function (): void {
    $pageContent = new PageContent;
    $casts = $pageContent->getCasts();

    expect($casts['created_at'])->toBe('datetime');
    expect($casts['updated_at'])->toBe('datetime');
});

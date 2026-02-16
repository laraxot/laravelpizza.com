<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Models\PageContent;

test('PageContent model can be instantiated', function () {
    $pageContent = new PageContent;

    expect($pageContent)->toBeInstanceOf(PageContent::class);
});

test('PageContent model has expected fillable fields', function () {
    $pageContent = new PageContent;

    $fillable = $pageContent->getFillable();

    expect($fillable)->toContain('name')
        ->and($fillable)->toContain('slug')
        ->and($fillable)->toContain('blocks');
});

test('PageContent model extends BaseModel', function () {
    $pageContent = new PageContent;

    expect($pageContent)->toBeInstanceOf(Modules\Cms\Models\BaseModel::class);
});

test('PageContent model has translatable fields', function () {
    $pageContent = new PageContent;

    expect(property_exists($pageContent, 'translatable'))->toBeTrue();
    expect($pageContent->translatable)->toContain('name')
        ->and($pageContent->translatable)->toContain('blocks');
});

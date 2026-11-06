<?php

declare(strict_types=1);

use Modules\Lang\Models\BaseModel;
use Modules\Lang\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('base model uses lang connection', function (): void {
    Assert::assertSame('lang', TestCase::makeLangBaseModel()->getConnectionName());
});

test('base model has correct table name', function (): void {
    Assert::assertSame('test_lang_table', TestCase::makeLangBaseModel()->getTable());
});

test('base model can be instantiated with anonymous subclass', function (): void {
    $baseModel = TestCase::makeLangBaseModel();

    Assert::assertSame('test_lang_table', $baseModel->getTable());
    Assert::assertNotSame(BaseModel::class, $baseModel::class);
});

test('base model has timestamps enabled', function (): void {
    Assert::assertTrue(TestCase::makeLangBaseModel()->usesTimestamps());
});

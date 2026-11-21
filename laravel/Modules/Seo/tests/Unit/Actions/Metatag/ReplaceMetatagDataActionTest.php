<?php

declare(strict_types=1);

namespace Modules\Seo\Tests\Unit\Actions\Metatag;

use Modules\Seo\Actions\Metatag\GetMetatagDataAction;
use Modules\Seo\Actions\Metatag\ReplaceMetatagDataAction;
use PHPUnit\Framework\Assert;

it('replaces the whole metatag state', function (): void {
    app(ReplaceMetatagDataAction::class)->execute(['title' => 'Old Title']);
    app(ReplaceMetatagDataAction::class)->execute(['title' => 'New Title', 'description' => 'New Description']);

    $data = app(GetMetatagDataAction::class)->execute();

    Assert::assertSame('New Title', $data->getTitle());
    Assert::assertSame('New Description', $data->getDescription());
});

it('resets fields not present in the replacement data', function (): void {
    app(ReplaceMetatagDataAction::class)->execute(['title' => 'First', 'description' => 'First Description']);
    app(ReplaceMetatagDataAction::class)->execute(['title' => 'Second']);

    $data = app(GetMetatagDataAction::class)->execute();

    Assert::assertSame('Second', $data->getTitle());
    Assert::assertSame('', $data->getDescription());
});

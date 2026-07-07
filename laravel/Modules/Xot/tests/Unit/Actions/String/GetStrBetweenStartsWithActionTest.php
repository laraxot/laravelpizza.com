<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Modules\Xot\Actions\String\GetStrBetweenStartsWithAction;
use PHPUnit\Framework\Assert;

it('extracts string between markers correctly', function (): void {
    $action = app(GetStrBetweenStartsWithAction::class);

    $body = 'prefix { content { inner } } suffix';
    $result = $action->execute($body, 'content', '{', '}');

    Assert::assertSame('content { inner }', $result);
});

it('throws exception when start marker is missing', function (): void {
    $action = app(GetStrBetweenStartsWithAction::class);
});

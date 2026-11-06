<?php

declare(strict_types=1);
use Modules\Xot\Actions\String\GetStrBetweenStartsWithAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('extracts string between markers correctly', function (): void {
    $action = app(GetStrBetweenStartsWithAction::class);

    $body = 'prefix { content { inner } } suffix';
    $result = $action->execute($body, 'content', '{', '}');

    Assert::assertSame('content { inner }', $result);
});

it('throws exception when start marker is missing', function (): void {
    $action = app(GetStrBetweenStartsWithAction::class);

    expect(fn (): string => $action->execute('prefix { content } suffix', 'missing', '{', '}'))
        ->toThrow(\Exception::class, 'Cannot find missing');
});

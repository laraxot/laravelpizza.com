<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\String;

use Modules\Xot\Actions\String\GetStrBetweenStartsWithAction;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

it('extracts string between markers correctly', function (): void {
    $action = app(GetStrBetweenStartsWithAction::class);

    $body = 'prefix { content { inner } } suffix';
    $result = $action->execute($body, 'content', '{', '}');

    expect($result)->toBe('content { inner }');
});

it('throws exception when start marker is missing', function (): void {
    $action = app(GetStrBetweenStartsWithAction::class);
    expect(fn () => $action->execute('body', 'missing', '{', '}'))->toThrow(\Exception::class);
});

<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\String;

use Modules\Xot\Actions\String\GetPronounceablePasswordAction;
use Modules\Xot\Actions\String\GetStrBetweenStartsWithAction;
use Modules\Xot\Actions\String\NormalizeDriverNameAction;
use Modules\Xot\Actions\String\SanitizeAction;

test('get pronounceable password action works', function () {
    $action = app(GetPronounceablePasswordAction::class);
    $password = $action->execute(12);

    expect(strlen($password))->toBeGreaterThanOrEqual(8); // min length logic inside
    // Should contain at least one digit and some characters from the special set
    expect($password)->toMatch('/[0-9]/');
});

test('get str between starts with action works', function () {
    $action = app(GetStrBetweenStartsWithAction::class);
    $body = 'prefix { content { inner } } suffix';
    $result = $action->execute($body, 'content', '{', '}');

    expect($result)->toContain('content { inner }');
});

test('normalize driver name action works', function () {
    $action = app(NormalizeDriverNameAction::class);
    expect($action->execute('360-Dialog'))->toBe('360dialog')
        ->and($action->execute('My_Driver'))->toBe('mydriver');
});

test('sanitize action works', function () {
    $action = app(SanitizeAction::class);
    $input = '  <p>Hello &amp; World</p>  ';
    expect($action->execute($input))->toBe('Hello & World');
});

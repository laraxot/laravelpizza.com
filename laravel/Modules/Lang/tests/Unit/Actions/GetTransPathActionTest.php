<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit\Actions;

use Modules\Lang\Actions\GetTransPathAction;
use Modules\Lang\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

function makeGetTransPathAction(): GetTransPathAction
{
    return new GetTransPathAction;
}

describe('GetTransPathAction Business Logic', function () {
    test('returns correct path for valid translation key', function () {
        $key = 'meetup::messages.welcome';
        $result = makeGetTransPathAction()->execute($key);

        Assert::assertStringContainsString('meetup', strtolower($result));
        Assert::assertStringContainsString('lang', $result);
        Assert::assertStringContainsString('messages.php', $result);
    });

    test('extracts namespace and file from key', function () {
        $key = 'cms::validation.required';
        $result = makeGetTransPathAction()->execute($key);

        Assert::assertStringContainsString('cms', strtolower($result));
        Assert::assertStringContainsString('validation.php', $result);
    });

    test('handles simple key without namespace', function () {
        $result = makeGetTransPathAction()->execute('test');
        Assert::assertNotSame('', $result);
    });

    test('extracts language from app locale', function () {
        $key = 'user::auth.login';
        $result = makeGetTransPathAction()->execute($key);

        Assert::assertStringContainsString('lang/', $result);
    });

    test('handles keys with multiple dots', function () {
        $key = 'module::file.nested.deep.value';
        $result = makeGetTransPathAction()->execute($key);

        Assert::assertStringContainsString('file.php', $result);
    });
});

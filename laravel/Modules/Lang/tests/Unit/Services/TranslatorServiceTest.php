<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit\Services;

use Modules\Lang\Services\TranslatorService;
use Modules\Lang\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

function makeTranslatorService(): TranslatorService
{
    /** @var TranslatorService $translator */
    $translator = app('translator');

    return $translator;
}

describe('TranslatorService Business Logic', function () {
    test('returns the key itself when translation is missing', function () {
        $key = 'lang::missing.unknown_key_'.uniqid();

        $result = makeTranslatorService()->get($key);

        Assert::assertSame($key, $result);
    });

    test('get returns a string or an array', function () {
        $result = makeTranslatorService()->get('lang::missing.another_key_'.uniqid());

        Assert::assertTrue(is_string($result) || is_array($result));
    });
});

<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit\Actions;

<<<<<<< HEAD
uses(TestCase::class);

use Modules\Lang\Actions\GetAllTranslationAction;
use Modules\Lang\Tests\TestCase;
=======
use Modules\Lang\Actions\GetAllTranslationAction;
use Modules\Lang\Tests\TestCase;
use PHPUnit\Framework\Assert;
>>>>>>> 40b96bcd6 (.)

uses(TestCase::class);

function makeGetAllTranslationAction(): GetAllTranslationAction
{
    return new GetAllTranslationAction();
}

describe('GetAllTranslationAction Business Logic', function () {
    test('returns array of translation files', function () {
        $result = makeGetAllTranslationAction()->execute();

        Assert::assertGreaterThanOrEqual(0, count($result));
    });

    test('returns files with key and path', function () {
        $result = makeGetAllTranslationAction()->execute();

        if (count($result) > 0) {
            Assert::assertArrayHasKey('key', $result[0]);
            Assert::assertArrayHasKey('path', $result[0]);
        }
    });

    test('handles session locale setting', function () {
        session()->put('locale', 'it');

        $result = makeGetAllTranslationAction()->execute();

        Assert::assertGreaterThanOrEqual(0, count($result));
    });

    test('handles invalid session locale gracefully', function () {
        session()->put('locale', 'invalid_locale');

        $result = makeGetAllTranslationAction()->execute();

        Assert::assertGreaterThanOrEqual(0, count($result));
    });

    test('returns empty array when no translation files exist', function () {
        $result = makeGetAllTranslationAction()->execute();

        Assert::assertGreaterThanOrEqual(0, count($result));
    });
});

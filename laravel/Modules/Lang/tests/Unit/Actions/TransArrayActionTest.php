<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit\Actions;

use Modules\Lang\Actions\TransArrayAction;
use Modules\Lang\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

function makeTransArrayAction(): TransArrayAction
{
    return new TransArrayAction();
}

describe('TransArrayAction Business Logic', function () {
    test('converts array elements to strings without transKey', function () {
        $input = [1, 2, 3];
        $result = makeTransArrayAction()->execute($input, null);

        Assert::assertCount(3, $result);
    });

    test('handles array with string keys', function () {
        $input = ['a' => 'value1', 'b' => 'value2'];
        $result = makeTransArrayAction()->execute($input, null);

        Assert::assertSame('value1', $result['a']);
        Assert::assertSame('value2', $result['b']);
    });

    test('handles empty array', function () {
        $input = [];
        $result = makeTransArrayAction()->execute($input, null);

        Assert::assertEmpty($result);
    });

    test('translates array elements with transKey when translation exists', function () {
        $input = ['test_key'];
        $result = makeTransArrayAction()->execute($input, 'test');

        Assert::assertCount(1, $result);
    });

    test('returns original value when translation does not exist', function () {
        $input = ['nonexistent_key'];
        $result = makeTransArrayAction()->execute($input, 'nonexistent');

        Assert::assertSame(['nonexistent_key'], $result);
    });

    test('handles numeric array elements', function () {
        $input = [100, 200, 300];
        $result = makeTransArrayAction()->execute($input, null);

        Assert::assertSame('100', $result[0]);
    });

    test('handles array with mixed types', function () {
        $input = ['string', 123, true, null];
        $result = makeTransArrayAction()->execute($input, null);

        Assert::assertCount(4, $result);
    });
});

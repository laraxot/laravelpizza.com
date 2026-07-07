<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit\Actions;

<<<<<<< HEAD
uses(TestCase::class);

use Modules\Lang\Actions\TransArrayAction;
use Modules\Lang\Tests\TestCase;

beforeEach(function () {
    $this->action = new TransArrayAction();
});
=======
use Modules\Lang\Actions\TransArrayAction;
use Modules\Lang\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

function makeTransArrayAction(): TransArrayAction
{
    return new TransArrayAction();
}
>>>>>>> 40b96bcd6 (.)

describe('TransArrayAction Business Logic', function () {
    test('converts array elements to strings without transKey', function () {
        $input = [1, 2, 3];
<<<<<<< HEAD
        $result = $this->action->execute($input, null);
=======
        $result = makeTransArrayAction()->execute($input, null);
>>>>>>> 40b96bcd6 (.)

        Assert::assertCount(3, $result);
    });

    test('handles array with string keys', function () {
        $input = ['a' => 'value1', 'b' => 'value2'];
<<<<<<< HEAD
        $result = $this->action->execute($input, null);
=======
        $result = makeTransArrayAction()->execute($input, null);
>>>>>>> 40b96bcd6 (.)

        Assert::assertSame('value1', $result['a']);
        Assert::assertSame('value2', $result['b']);
    });

    test('handles empty array', function () {
        $input = [];
<<<<<<< HEAD
        $result = $this->action->execute($input, null);
=======
        $result = makeTransArrayAction()->execute($input, null);
>>>>>>> 40b96bcd6 (.)

        Assert::assertEmpty($result);
    });

    test('translates array elements with transKey when translation exists', function () {
        $input = ['test_key'];
<<<<<<< HEAD
        $result = $this->action->execute($input, 'test');
=======
        $result = makeTransArrayAction()->execute($input, 'test');
>>>>>>> 40b96bcd6 (.)

        Assert::assertCount(1, $result);
    });

    test('returns original value when translation does not exist', function () {
        $input = ['nonexistent_key'];
<<<<<<< HEAD
        $result = $this->action->execute($input, 'nonexistent');
=======
        $result = makeTransArrayAction()->execute($input, 'nonexistent');
>>>>>>> 40b96bcd6 (.)

        Assert::assertSame(['nonexistent_key'], $result);
    });

    test('handles numeric array elements', function () {
        $input = [100, 200, 300];
<<<<<<< HEAD
        $result = $this->action->execute($input, null);
=======
        $result = makeTransArrayAction()->execute($input, null);
>>>>>>> 40b96bcd6 (.)

        Assert::assertSame('100', $result[0]);
    });

    test('handles array with mixed types', function () {
        $input = ['string', 123, true, null];
<<<<<<< HEAD
        $result = $this->action->execute($input, null);
=======
        $result = makeTransArrayAction()->execute($input, null);
>>>>>>> 40b96bcd6 (.)

        Assert::assertCount(4, $result);
    });
});

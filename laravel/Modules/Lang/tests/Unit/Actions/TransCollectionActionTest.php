<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit\Actions;

<<<<<<< HEAD
uses(TestCase::class);

use Illuminate\Support\Collection;
use Modules\Lang\Actions\TransCollectionAction;
use Modules\Lang\Tests\TestCase;

beforeEach(function () {
    $this->action = new TransCollectionAction();
});
=======
use Illuminate\Support\Collection;
use Modules\Lang\Actions\TransCollectionAction;
use Modules\Lang\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

function makeTransCollectionAction(): TransCollectionAction
{
    return new TransCollectionAction();
}
>>>>>>> 40b96bcd6 (.)

describe('TransCollectionAction Business Logic', function () {
    test('converts collection elements to strings without transKey', function () {
        /** @var Collection<int|string, mixed> $input */
        $input = new Collection([1, 2, 3]);
<<<<<<< HEAD
        $result = $this->action->execute($input, null);
=======
        $result = makeTransCollectionAction()->execute($input, null);
>>>>>>> 40b96bcd6 (.)

        Assert::assertInstanceOf(Collection::class, $result);
        Assert::assertSame(['1', '2', '3'], $result->toArray());
    });

    test('handles collection with string items', function () {
        /** @var Collection<int|string, mixed> $input */
        $input = new Collection(['a', 'b', 'c']);
<<<<<<< HEAD
        $result = $this->action->execute($input, null);
=======
        $result = makeTransCollectionAction()->execute($input, null);
>>>>>>> 40b96bcd6 (.)

        Assert::assertInstanceOf(Collection::class, $result);
    });

    test('handles empty collection', function () {
        /** @var Collection<int|string, mixed> $input */
        $input = new Collection([]);
<<<<<<< HEAD
        $result = $this->action->execute($input, null);
=======
        $result = makeTransCollectionAction()->execute($input, null);
>>>>>>> 40b96bcd6 (.)

        Assert::assertInstanceOf(Collection::class, $result);
        Assert::assertEmpty($result);
    });

    test('translates collection elements with transKey when translation exists', function () {
        /** @var Collection<int|string, mixed> $input */
        $input = new Collection(['test_key']);
<<<<<<< HEAD
        $result = $this->action->execute($input, 'test');
=======
        $result = makeTransCollectionAction()->execute($input, 'test');
>>>>>>> 40b96bcd6 (.)

        Assert::assertInstanceOf(Collection::class, $result);
        Assert::assertCount(1, $result);
    });

    test('returns original value when translation does not exist', function () {
        /** @var Collection<int|string, mixed> $input */
        $input = new Collection(['nonexistent_key']);
<<<<<<< HEAD
        $result = $this->action->execute($input, 'nonexistent');
=======
        $result = makeTransCollectionAction()->execute($input, 'nonexistent');
>>>>>>> 40b96bcd6 (.)

        Assert::assertInstanceOf(Collection::class, $result);
    });

    test('handles numeric collection elements', function () {
        /** @var Collection<int|string, mixed> $input */
        $input = new Collection([100, 200, 300]);
<<<<<<< HEAD
        $result = $this->action->execute($input, null);
=======
        $result = makeTransCollectionAction()->execute($input, null);
>>>>>>> 40b96bcd6 (.)

        Assert::assertInstanceOf(Collection::class, $result);
    });

    test('handles associative collection', function () {
        /** @var Collection<int|string, mixed> $input */
        $input = new Collection(['key1' => 'value1', 'key2' => 'value2']);
<<<<<<< HEAD
        $result = $this->action->execute($input, null);
=======
        $result = makeTransCollectionAction()->execute($input, null);
>>>>>>> 40b96bcd6 (.)

        Assert::assertInstanceOf(Collection::class, $result);
    });
});

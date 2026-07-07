<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit\Actions;

use Illuminate\Support\Collection;
use Modules\Lang\Actions\TransCollectionAction;
use Modules\Lang\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

function makeTransCollectionAction(): TransCollectionAction
{
    return new TransCollectionAction();
}

describe('TransCollectionAction Business Logic', function () {
    test('converts collection elements to strings without transKey', function () {
        /** @var Collection<int|string, mixed> $input */
        $input = new Collection([1, 2, 3]);
        $result = makeTransCollectionAction()->execute($input, null);

        Assert::assertInstanceOf(Collection::class, $result);
        Assert::assertSame(['1', '2', '3'], $result->toArray());
    });

    test('handles collection with string items', function () {
        /** @var Collection<int|string, mixed> $input */
        $input = new Collection(['a', 'b', 'c']);
        $result = makeTransCollectionAction()->execute($input, null);

        Assert::assertInstanceOf(Collection::class, $result);
    });

    test('handles empty collection', function () {
        /** @var Collection<int|string, mixed> $input */
        $input = new Collection([]);
        $result = makeTransCollectionAction()->execute($input, null);

        Assert::assertInstanceOf(Collection::class, $result);
        Assert::assertEmpty($result);
    });

    test('translates collection elements with transKey when translation exists', function () {
        /** @var Collection<int|string, mixed> $input */
        $input = new Collection(['test_key']);
        $result = makeTransCollectionAction()->execute($input, 'test');

        Assert::assertInstanceOf(Collection::class, $result);
        Assert::assertCount(1, $result);
    });

    test('returns original value when translation does not exist', function () {
        /** @var Collection<int|string, mixed> $input */
        $input = new Collection(['nonexistent_key']);
        $result = makeTransCollectionAction()->execute($input, 'nonexistent');

        Assert::assertInstanceOf(Collection::class, $result);
    });

    test('handles numeric collection elements', function () {
        /** @var Collection<int|string, mixed> $input */
        $input = new Collection([100, 200, 300]);
        $result = makeTransCollectionAction()->execute($input, null);

        Assert::assertInstanceOf(Collection::class, $result);
    });

    test('handles associative collection', function () {
        /** @var Collection<int|string, mixed> $input */
        $input = new Collection(['key1' => 'value1', 'key2' => 'value2']);
        $result = makeTransCollectionAction()->execute($input, null);

        Assert::assertInstanceOf(Collection::class, $result);
    });
});

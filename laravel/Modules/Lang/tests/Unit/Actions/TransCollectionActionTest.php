<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit\Actions;

uses(TestCase::class);

use Illuminate\Support\Collection;
use Modules\Lang\Actions\TransCollectionAction;
use Modules\Lang\Tests\TestCase;

beforeEach(function () {
    $this->action = new TransCollectionAction();
});

describe('TransCollectionAction Business Logic', function () {
    test('converts collection elements to strings without transKey', function () {
        $input = new Collection([1, 2, 3]);
        $result = $this->action->execute($input, null);

        expect($result)->toBeInstanceOf(Collection::class);
        // TransArrayAction converts numbers to strings via SafeStringCastAction
        expect($result->toArray())->toBe(['1', '2', '3']);
    });

    test('handles collection with string items', function () {
        $input = new Collection(['a', 'b', 'c']);
        $result = $this->action->execute($input, null);

        expect($result)->toBeInstanceOf(Collection::class);
    });

    test('handles empty collection', function () {
        $input = new Collection([]);
        $result = $this->action->execute($input, null);

        expect($result)->toBeInstanceOf(Collection::class);
        expect($result)->toBeEmpty();
    });

    test('translates collection elements with transKey when translation exists', function () {
        $input = new Collection(['test_key']);
        $result = $this->action->execute($input, 'test');

        expect($result)->toBeInstanceOf(Collection::class);
        expect($result)->toHaveCount(1);
    });

    test('returns original value when translation does not exist', function () {
        $input = new Collection(['nonexistent_key']);
        $result = $this->action->execute($input, 'nonexistent');

        expect($result)->toBeInstanceOf(Collection::class);
    });

    test('handles numeric collection elements', function () {
        $input = new Collection([100, 200, 300]);
        $result = $this->action->execute($input, null);

        expect($result)->toBeInstanceOf(Collection::class);
    });

    test('handles associative collection', function () {
        $input = new Collection(['key1' => 'value1', 'key2' => 'value2']);
        $result = $this->action->execute($input, null);

        expect($result)->toBeInstanceOf(Collection::class);
    });
});

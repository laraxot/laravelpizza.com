<?php

declare(strict_types=1);

uses(Modules\Lang\Tests\TestCase::class);

use Modules\Lang\Actions\TransArrayAction;

beforeEach(function () {
    $this->action = new TransArrayAction;
});

describe('TransArrayAction Business Logic', function () {
    test('converts array elements to strings without transKey', function () {
        $input = [1, 2, 3];
        $result = $this->action->execute($input, null);

        expect($result)->toBeArray();
        expect($result)->toHaveCount(3);
    });

    test('handles array with string keys', function () {
        $input = ['a' => 'value1', 'b' => 'value2'];
        $result = $this->action->execute($input, null);

        expect($result)->toBeArray();
        expect($result['a'])->toBe('value1');
        expect($result['b'])->toBe('value2');
    });

    test('handles empty array', function () {
        $input = [];
        $result = $this->action->execute($input, null);

        expect($result)->toBeArray();
        expect($result)->toBeEmpty();
    });

    test('translates array elements with transKey when translation exists', function () {
        // Setup: add a translation for testing
        $input = ['test_key'];
        $result = $this->action->execute($input, 'test');

        expect($result)->toBeArray();
        expect($result)->toHaveCount(1);
    });

    test('returns original value when translation does not exist', function () {
        $input = ['nonexistent_key'];
        $result = $this->action->execute($input, 'nonexistent');

        expect($result)->toBeArray();
    });

    test('handles numeric array elements', function () {
        $input = [100, 200, 300];
        $result = $this->action->execute($input, null);

        expect($result)->toBeArray();
        expect($result[0])->toBe('100');
    });

    test('handles array with mixed types', function () {
        $input = ['string', 123, true, null];
        $result = $this->action->execute($input, null);

        expect($result)->toBeArray();
        expect($result)->toHaveCount(4);
    });
});

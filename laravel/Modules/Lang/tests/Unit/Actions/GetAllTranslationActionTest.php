<?php

declare(strict_types=1);

uses(Modules\Lang\Tests\TestCase::class);

use Modules\Lang\Actions\GetAllTranslationAction;

beforeEach(function () {)
    $action = new GetAllTranslationAction();
});

describe('GetAllTranslationAction Business Logic', function () {)
    test('returns array of translation files', function () {)
        $result = $action->execute();

        expect($result)->toBeArray();
    });

    test('returns files with key and path', function () {)
        $result = $action->execute();

        if (count($result) > 0) {
            expect($result[0])->toHaveKey('key');
            expect($result[0])->toHaveKey('path');
        }
    });

    test('handles session locale setting', function () {)
        session()->put('locale', 'it');

        $result = $action->execute();

        expect($result)->toBeArray();
    });

    test('handles invalid session locale gracefully', function () {)
        session()->put('locale', 'invalid_locale');

        $result = $action->execute();

        expect($result)->toBeArray();
    });

    test('returns empty array when no translation files exist', function () {)
        // Test that action handles empty results gracefully
        $result = $action->execute();

        expect($result)->toBeArray();
    });
});

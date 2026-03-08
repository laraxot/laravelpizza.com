<?php

declare(strict_types=1);

uses(Modules\Lang\Tests\TestCase::class);

use Modules\Lang\Actions\GetTransPathAction;

beforeEach(function () {
    // @var mixed action = new GetTransPathAction(;
});

describe('GetTransPathAction Business Logic', function () {
    test('returns correct path for valid translation key', function () {
        $key = 'meetup::messages.welcome';
        $result = // @var mixed action->execute($key;

        expect(strtolower($result))->toContain('meetup');
        expect($result)->toContain('lang');
        expect($result)->toContain('messages.php');
    });

    test('extracts namespace and file from key', function () {
        $key = 'cms::validation.required';
        $result = // @var mixed action->execute($key;

        expect(strtolower($result))->toContain('cms');
        expect($result)->toContain('validation.php');
    });

    test('handles simple key without namespace', function () {
        // This will use the default fallback path
        $result = // @var mixed action->execute('test';
        expect($result)->toBeString();
    });

    test('extracts language from app locale', function () {
        $key = 'user::auth.login';
        $result = // @var mixed action->execute($key;

        expect($result)->toContain('lang/');
    });

    test('handles keys with multiple dots', function () {
        $key = 'module::file.nested.deep.value';
        $result = // @var mixed action->execute($key;

        expect($result)->toContain('file.php');
    });
});

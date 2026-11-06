<?php

declare(strict_types=1);
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('login widget translations have a scalar fifth level in every supported locale', function (): void {
    foreach (['it', 'en', 'de', 'es'] as $locale) {
        /** @var array<string, mixed> $translations */
        $translations = require dirname(__DIR__, 4).'/lang/'.$locale.'/auth.php';

        foreach (['google', 'microsoft', 'github', 'or_continue_with', 'submit', 'forgot_password', 'no_account', 'create_account', 'logging_in'] as $key) {
            $value = data_get($translations, 'login.'.$key.'.text');

            Assert::assertIsString($value, $locale.'.auth.login.'.$key.'.text must be a string');
            Assert::assertNotSame('', $value);
        }

        $googleButton = data_get($translations, 'login.google.button.text');
        Assert::assertIsString($googleButton, $locale.'.auth.login.google.button.text must be a string');
        Assert::assertNotSame('', $googleButton);

        Assert::assertIsString(data_get($translations, 'actions.login.success'));
        Assert::assertIsString(data_get($translations, 'actions.login.error'));
    }
});

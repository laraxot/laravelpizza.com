<?php

declare(strict_types=1);

use Modules\User\Tests\TestCase;

uses(TestCase::class);

// TwoFactorService does not exist in the User module yet.
// These tests are skipped until the service is implemented.

test('enable generates secret and qr code', function (): void {
    $this->markTestSkipped('TwoFactorService not yet implemented in User module.');
});

test('enable stores encrypted secret', function (): void {
    $this->markTestSkipped('TwoFactorService not yet implemented in User module.');
});

test('enable generates 10 recovery codes', function (): void {
    $this->markTestSkipped('TwoFactorService not yet implemented in User module.');
});

test('confirm enables 2fa with valid code', function (): void {
    $this->markTestSkipped('TwoFactorService not yet implemented in User module.');
});

test('confirm fails with invalid code', function (): void {
    $this->markTestSkipped('TwoFactorService not yet implemented in User module.');
});

test('disable removes all 2fa data', function (): void {
    $this->markTestSkipped('TwoFactorService not yet implemented in User module.');
});

test('verify validates correct code', function (): void {
    $this->markTestSkipped('TwoFactorService not yet implemented in User module.');
});

test('verify rejects incorrect code', function (): void {
    $this->markTestSkipped('TwoFactorService not yet implemented in User module.');
});

test('verify returns false if no secret', function (): void {
    $this->markTestSkipped('TwoFactorService not yet implemented in User module.');
});

test('verify recovery code works once', function (): void {
    $this->markTestSkipped('TwoFactorService not yet implemented in User module.');
});

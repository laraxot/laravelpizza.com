<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Modules\Xot\Providers\XotServiceProvider;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

it('boots the xot service provider', function () {
    expect(app()->providerIsLoaded(XotServiceProvider::class))->toBeTrue();
});

it('has app available in test', function () {
    expect(app())->not->toBeNull();
});

it('generates unique email', function () {
    $email1 = 'test-'.uniqid('', true).'@example.com';
    $email2 = 'test-'.uniqid('', true).'@example.com';

    expect($email1)->toContain('@example.com');
    expect($email2)->toContain('@example.com');
    expect($email1)->not->toEqual($email2);
});

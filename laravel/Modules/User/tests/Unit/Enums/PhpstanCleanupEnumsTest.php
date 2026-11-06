<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use Modules\User\Enums\FetchUserApiTokenExitCode;
use Modules\User\Enums\NameSearchEnum;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('NameSearchEnum splits a full name at the first separator', function (): void {
    $fullName = Str::of('Mario Rossi');

    Assert::assertSame('Mario', NameSearchEnum::Name->applyTo($fullName, ' ')->toString());
    Assert::assertSame('Rossi', NameSearchEnum::Surname->applyTo($fullName, ' ')->toString());
});

test('NameSearchEnum keeps the legacy Stringable method names as backed values', function (): void {
    Assert::assertSame('before', NameSearchEnum::Name->value);
    Assert::assertSame('after', NameSearchEnum::Surname->value);
});

test('FetchUserApiTokenExitCode exposes distinct non-zero exit codes', function (): void {
    Assert::assertSame(1, FetchUserApiTokenExitCode::InvalidEnvironment->value);
    Assert::assertSame(2, FetchUserApiTokenExitCode::UserNotFound->value);
});

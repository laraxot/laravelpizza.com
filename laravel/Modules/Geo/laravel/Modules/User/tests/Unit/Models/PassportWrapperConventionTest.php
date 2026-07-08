<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Assert;

use function Safe\glob;

uses(Modules\User\Tests\TestCase::class);

test('every vendor passport eloquent model has a local oauth wrapper', function (): void {
    $passportSrc = base_path('vendor/laravel/passport/src');

    /** @var list<string> $passportFiles */
    $passportFiles = glob($passportSrc.'/*.php');
    if ([] === $passportFiles) {
        Assert::fail('Unable to read Passport source directory.');
    }

    $vendorModelClasses = collect($passportFiles)
        ->map(function (mixed $file): string {
            return 'Laravel\\Passport\\'.pathinfo((string) $file, PATHINFO_FILENAME);
        })
        ->filter(function (string $class): bool {
            if (! class_exists($class)) {
                return false;
            }

            $reflection = new ReflectionClass($class);

            return ! $reflection->isAbstract()
                && $reflection->isSubclassOf(Model::class);
        })
        ->values();

    Assert::assertSame([
        'Laravel\\Passport\\AuthCode',
        'Laravel\\Passport\\Client',
        'Laravel\\Passport\\DeviceCode',
        'Laravel\\Passport\\RefreshToken',
        'Laravel\\Passport\\Token',
    ], $vendorModelClasses->all());

    $vendorModelClasses->each(function (string $vendorClass): void {
        $shortName = class_basename($vendorClass);
        $wrapperClass = 'Modules\\User\\Models\\Oauth'.$shortName;

        Assert::assertTrue(class_exists($wrapperClass), "Missing wrapper for {$vendorClass}");
    });
});

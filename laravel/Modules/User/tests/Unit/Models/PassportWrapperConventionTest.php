<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Tests\TestCase;
use ReflectionClass;

uses(TestCase::class);

test('every vendor passport eloquent model has a local oauth wrapper', function (): void {
    $passportSrc = base_path('vendor/laravel/passport/src');

    $vendorModelClasses = collect((array) glob($passportSrc.'/*.php'))
        ->map(function (string $file): string {
            return 'Laravel\\Passport\\'.pathinfo($file, PATHINFO_FILENAME);
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

    expect($vendorModelClasses->all())->toBe([
        'Laravel\\Passport\\AuthCode',
        'Laravel\\Passport\\Client',
        'Laravel\\Passport\\DeviceCode',
        'Laravel\\Passport\\RefreshToken',
        'Laravel\\Passport\\Token',
    ]);

    $vendorModelClasses->each(function (string $vendorClass): void {
        $shortName = class_basename($vendorClass);
        $wrapperClass = 'Modules\\User\\Models\\Oauth'.$shortName;

        expect(class_exists($wrapperClass))->toBeTrue('Missing wrapper: '.$wrapperClass)
            ->and(is_subclass_of($wrapperClass, $vendorClass))->toBeTrue('Wrapper must extend '.$vendorClass);
    });
});

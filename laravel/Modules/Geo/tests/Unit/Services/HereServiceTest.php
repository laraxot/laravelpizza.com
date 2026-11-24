<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Services;

use Modules\Geo\Services\HereService;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('has correct base URL', function (): void {
<<<<<<< .merge_file_dVNSnC
<<<<<<< .merge_file_PaDil7
<<<<<<< .merge_file_OVcQdK
    $service = new HereService;
=======
    $service = new HereService();
>>>>>>> .merge_file_JF64Fd
=======
    $service = new HereService();
>>>>>>> .merge_file_tWyeWu
=======
    $service = new HereService();
>>>>>>> .merge_file_8UBsBF
    Assert::assertSame('https://router.hereapi.com/v8/routes', $service->base_url);
});

it('has static method for getting duration and length', function (): void {
    Assert::assertContains('getDurationAndLength', get_class_methods(HereService::class));
});

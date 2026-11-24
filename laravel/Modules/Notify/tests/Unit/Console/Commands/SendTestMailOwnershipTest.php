<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Console\Commands;

use Modules\Notify\Console\Commands\SendTestMail;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('keeps the Mailtrap command inside the Notify module', function (): void {
    $reflection = new \ReflectionClass(SendTestMail::class);

    Assert::assertSame('Modules\\Notify\\Console\\Commands', $reflection->getNamespaceName());
    Assert::assertSame(
        module_path('Notify', 'app/Console/Commands/SendTestMail.php'),
        $reflection->getFileName(),
    );
    Assert::assertFalse(file_exists(base_path('app/Console/Commands/SendTestMail.php')));
});

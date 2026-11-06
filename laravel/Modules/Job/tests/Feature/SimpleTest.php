<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Feature;

use Modules\Job\Providers\JobServiceProvider;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('has a simple passing test', function () {
    Assert::assertTrue(class_exists(JobServiceProvider::class));
    Assert::assertSame('Job', (new JobServiceProvider(app()))->name);
});

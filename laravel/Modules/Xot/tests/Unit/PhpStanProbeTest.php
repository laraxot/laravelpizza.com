<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Models\BaseModel;
use PHPUnit\Framework\Assert;

uses(\Modules\Xot\Tests\TestCase::class);

it('probe mixed', function (): void {
    /** @var mixed $mixed */
    $mixed = null;

    Assert::assertNull($mixed);
});

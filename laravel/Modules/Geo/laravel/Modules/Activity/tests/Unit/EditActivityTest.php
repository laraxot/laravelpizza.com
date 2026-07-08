<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Modules\Activity\Filament\Resources\ActivityResource;
use Modules\Activity\Filament\Resources\ActivityResource\Pages\EditActivity;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Activity\Tests\TestCase::class);

describe('Edit Activity', function (): void {
    test('edit activity has correct resource', function (): void {
$page = new EditActivity;
        Assert::assertEquals(
            ActivityResource::class,
            $page::getResource()
        );
    });
});

<?php

declare(strict_types=1);
<<<<<<< .merge_file_1wYsJR

use Modules\Activity\Filament\Resources\ActivityResource\Pages\ViewActivity;
use Modules\Activity\Filament\Resources\ActivityResource;
=======
use Modules\Activity\Filament\Resources\ActivityResource;
use Modules\Activity\Filament\Resources\ActivityResource\Pages\ViewActivity;
use Modules\Activity\Tests\TestCase;

uses(TestCase::class);
>>>>>>> .merge_file_EMpvld

test('ViewActivity uses the standard view record page contract', function (): void {
    expect(ViewActivity::getResource())->toBe(ActivityResource::class);
});

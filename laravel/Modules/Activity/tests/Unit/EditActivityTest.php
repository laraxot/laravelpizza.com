<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Modules\Activity\Filament\Resources\ActivityResource;
use Modules\Activity\Filament\Resources\ActivityResource\Pages\EditActivity;
use Modules\Activity\Tests\TestCase;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use PHPUnit\Framework\Attributes\Test;

class EditActivityTest extends TestCase
{
    #[Test]
    public function edit_activity_extends_xot_base_edit_record(): void
    {
        $this->assertTrue(
            is_subclass_of(
                EditActivity::class,
                XotBaseEditRecord::class
            )
        );
    }

    #[Test]
    public function edit_activity_has_correct_resource(): void
    {
        $page = new EditActivity;
        $this->assertEquals(
            ActivityResource::class,
            $page::getResource()
        );
    }
}

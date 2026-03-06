<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Modules\Activity\Filament\Resources\ActivityResource\Pages\EditActivity;
use PHPUnit\Framework\Attributes\Test;
use Modules\Activity\Tests\TestCase;

class EditActivityTest extends TestCase
{

    #[Test]
    public function edit_activity_extends_xot_base_edit_record(): void
    {
        $this->assertTrue(
            is_subclass_of(
                EditActivity::class,
                \Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord::class
            )
        );
    }

    #[Test]
    public function edit_activity_has_correct_resource(): void
    {
        $page = new EditActivity();
        $this->assertEquals(
            \Modules\Activity\Filament\Resources\ActivityResource::class,
            $page::getResource()
        );
    }

    #[Test]
    public function edit_activity_exposes_delete_header_action(): void
    {
        $page = new EditActivity();

        $reflection = new \ReflectionClass($page);
        $method = $reflection->getMethod('getHeaderActions');
        $method->setAccessible(true);

        /** @var array<string, mixed> $actions */
        $actions = $method->invoke($page);

        $this->assertArrayHasKey('delete', $actions);
    }
}

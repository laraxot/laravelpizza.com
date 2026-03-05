<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Modules\Activity\Filament\Actions\ListLogActivitiesAction;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ListLogActivitiesActionTest extends TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseTransactions;

    #[Test]
    public function it_extends_xot_base_action(): void
    {
        $action = new ListLogActivitiesAction('test');
        $this->assertInstanceOf(\Modules\Xot\Filament\Actions\XotBaseAction::class, $action);
    }

    #[Test]
    public function it_has_correct_default_name(): void
    {
        $action = new ListLogActivitiesAction('list_log_activities');
        $this->assertEquals('list_log_activities', $action->getDefaultName());
    }
}

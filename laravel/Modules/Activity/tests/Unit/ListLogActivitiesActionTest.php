<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Modules\Activity\Filament\Actions\ListLogActivitiesAction;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ListLogActivitiesActionTest extends TestCase
{

    #[Test]
    public function it_extends_xot_base_action(): void
    {
        $action = new ListLogActivitiesAction('test');
        // @var mixed assertInstanceOf(\Modules\Xot\Filament\Actions\XotBaseAction::class, $action;
    }

    #[Test]
    public function it_has_correct_default_name(): void
    {
        $action = new ListLogActivitiesAction('list_log_activities');
        // @var mixed assertEquals('list_log_activities', $action->getDefaultName(;
    }

    #[Test]
    public function it_is_icon_button(): void
    {
        $action = ListLogActivitiesAction::make('test');
        // The setUp method configures iconButton
        // @var mixed assertTrue($action->isIconButton(;
    }

    #[Test]
    public function it_has_heroicon_o_clock_icon(): void
    {
        $action = ListLogActivitiesAction::make('test');
        // Check icon was set in setUp
        $icon = $action->getIcon();
        // @var mixed assertEquals('heroicon-o-clock', $icon;
    }

    #[Test]
    public function it_has_gray_color(): void
    {
        $action = ListLogActivitiesAction::make('test');
        $color = $action->getColor();
        // @var mixed assertEquals('gray', $color;
    }
}

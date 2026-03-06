<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Modules\Activity\Filament\Actions\ListLogActivitiesAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ListLogActivitiesActionFakeResource
{
    /**
     * @param  array<string, mixed>  $params
     */
    public static function getUrl(string $name, array $params = []): string
    {
        return '/fake/'.$name.'/'.($params['record']->getKey() ?? 'none');
    }
}

class ListLogActivitiesActionFakeListRecords extends ListRecords
{
    /**
     * @return class-string
     */
    public static function getResource(): string
    {
        return ListLogActivitiesActionFakeResource::class;
    }
}

class ListLogActivitiesActionTest extends TestCase
{

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

    #[Test]
    public function it_is_icon_button(): void
    {
        $action = ListLogActivitiesAction::make('test');
        // The setUp method configures iconButton
        $this->assertTrue($action->isIconButton());
    }

    #[Test]
    public function it_has_heroicon_o_clock_icon(): void
    {
        $action = ListLogActivitiesAction::make('test');
        // Check icon was set in setUp
        $icon = $action->getIcon();
        $this->assertEquals('heroicon-o-clock', $icon);
    }

    #[Test]
    public function it_has_gray_color(): void
    {
        $action = ListLogActivitiesAction::make('test');
        $color = $action->getColor();
        $this->assertEquals('gray', $color);
    }

    #[Test]
    public function it_builds_url_via_resource_callback(): void
    {
        $action = ListLogActivitiesAction::make('test');
        $record = $this->createMock(Model::class);
        $record->method('getKey')->willReturn('fake-id');

        $livewireReflection = new \ReflectionClass(ListLogActivitiesActionFakeListRecords::class);
        /** @var ListRecords $livewire */
        $livewire = $livewireReflection->newInstanceWithoutConstructor();

        $reflection = new \ReflectionObject($action);
        $property = $reflection->getProperty('url');
        $property->setAccessible(true);
        /** @var \Closure $urlClosure */
        $urlClosure = $property->getValue($action);

        $url = $urlClosure($livewire, $record);

        $this->assertSame('/fake/log-activity/fake-id', $url);
    }
}

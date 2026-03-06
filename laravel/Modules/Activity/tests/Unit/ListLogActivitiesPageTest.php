<?php

declare(strict_types=1);

use Filament\Tables\Enums\PaginationMode;
use Modules\Activity\Filament\Pages\Concerns\CanPaginate;
use Modules\Activity\Filament\Pages\ListLogActivities;
use Modules\Activity\Filament\Resources\ActivityResource;
use Modules\Xot\Filament\Resources\Pages\XotBasePage;
use PHPUnit\Framework\TestCase;

class ListLogActivitiesPageTest extends TestCase
{
    public function test_class_is_abstract(): void
    {
        $reflection = new \ReflectionClass(ListLogActivities::class);
        $this->assertTrue($reflection->isAbstract());
    }

    public function test_extends_xot_base_page(): void
    {
        $this->assertTrue(is_subclass_of(ListLogActivities::class, XotBasePage::class));
    }

    public function test_uses_can_paginate_trait(): void
    {
        $this->assertContains(
            CanPaginate::class,
            class_uses_recursive(ListLogActivities::class)
        );
    }

    public function test_has_get_activities_method(): void
    {
        $this->assertTrue(method_exists(ListLogActivities::class, 'getActivities'));
    }

    public function test_has_restore_activity_method(): void
    {
        $this->assertTrue(method_exists(ListLogActivities::class, 'restoreActivity'));
    }

    public function test_has_can_restore_activity_method(): void
    {
        $this->assertTrue(method_exists(ListLogActivities::class, 'canRestoreActivity'));
    }

    public function test_has_get_breadcrumb_method(): void
    {
        $this->assertTrue(method_exists(ListLogActivities::class, 'getBreadcrumb'));
    }

    public function test_has_get_title_method(): void
    {
        $this->assertTrue(method_exists(ListLogActivities::class, 'getTitle'));
    }

    public function test_has_get_field_label_method(): void
    {
        $this->assertTrue(method_exists(ListLogActivities::class, 'getFieldLabel'));
    }

    public function test_get_pagination_mode_returns_default(): void
    {
        $page = new class extends ListLogActivities {
            public static function getResource(): string
            {
                return ActivityResource::class;
            }
        };

        $this->assertSame(PaginationMode::Default, $page->getPaginationMode());
    }

    public function test_view_is_correct(): void
    {
        $reflection = new \ReflectionClass(ListLogActivities::class);
        $property = $reflection->getProperty('view');
        $property->setAccessible(true);

        $page = new class extends ListLogActivities {
            public static function getResource(): string
            {
                return ActivityResource::class;
            }
        };

        $view = $property->getValue($page);
        $this->assertSame('activity::filament.pages.list-log-activities', $view);
    }
}
